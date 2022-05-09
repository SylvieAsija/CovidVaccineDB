<!DOCTYPE html> 
<html>
    <head>
        <style>
            .container {
                position: relative;
                text-align: center;
                color: black;
                width: 1080px;
            }

            .CTitleText {
                position:absolute;
                top: 50%;
                left: 50%;
                font-family: fantasy;
                font-size: 50px;
            }

            .CLTitleText {
                position: absolute;
                top: 75px;
                left: 16px;
                font-family: fantasy;
                font-size: 50px;
                color:#000;
            }

            .CLTitleText:hover {
                color: red;
            }

            .CLTitleText:active {
                
            }

            .error{
                color:#FF0000;
            }

        </style>
    </head>
    <body>
        <div class="container">
            <img src="images\blue_banner.jpg" alt="covid banner" width="1600px" height="200px">
            <div class="CTitleText">COVID VACCINE DATABASE</div>
            <a href="http://localhost/covid.php">
                <div class="CLTitleText">COVID</br>DB</div>
            </a>
        </div>

        <?php 
        session_start();
            $servername = "localhost";
            $username = "root";
            $password = "";

            try {
                $conn = new PDO("mysql:host=$servername;dbname=coviddb", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //echo "Connected successfully";
            } catch(PDOException $e) {
                //echo "Connection failed: " . $e->getMessage();
            }        


            echo "<h1>Vaccination Information:</h1>";
            //     if(isset($_SESSION['OHIPNum'])) {
            //         echo "OHIP recorded successfully: ";
            //         echo $_SESSION['OHIPNum'];
            //         echo "<br>";
            //     }

            //     if(isset($_SESSION['firstname'])) {
            //         echo "First name recorded successfully: ";
            //         echo $_SESSION['firstname'];
            //         echo "<br>";
            //     }

            //     if(isset($_SESSION['lastname'])) {
            //         echo "Last name recorded successfully: ";
            //         echo $_SESSION['lastname'];
            //         echo "<br>";
            //     }

            //     if(isset($_SESSION['birthday'])) {
            //         echo "Birthday recorded successfully: ";
            //         echo $_SESSION['birthday'];
            //         echo "<br>";
            //     }

                $ClinicName = "";
        ?>
        
        <form name="patientDropdown" method="POST">
        Vaccination Site:       
        <?php
            $stmt=$conn->prepare("SELECT DISTINCT ClinicName FROM vaccinationappointment");
            $stmt->execute();
            $list = $stmt->fetchAll();
            ?>

            <SELECT ClinicName="ClinicName" name="ClinicName">
                <option>--- SELECT ---</option>
            <?php foreach ($list as $row): ?>
                <?php echo "<option value='{$row['ClinicName']}'>{$row['ClinicName']}</option>";?>
                <?php endforeach ?>
            </select>
            <br>
        Date Administered:        
        <?php
            $stmt=$conn->prepare("SELECT DISTINCT VaccDate FROM vaccinationappointment");
            $stmt->execute();
            $list = $stmt->fetchAll();
            ?>

            <SELECT VaccDate="VaccDate" name="VaccDate">
            <option>--- SELECT ---</option>
            <?php foreach ($list as $row): ?>
                <?php echo "<option value='{$row['VaccDate']}'>{$row['VaccDate']}</option>";?>
                <?php endforeach ?>
            </select>
            <br>
        Lot Number:        
        <?php
            $stmt=$conn->prepare("SELECT DISTINCT LotNum FROM vaccinationappointment");
            $stmt->execute();
            $list = $stmt->fetchAll();
            ?>

            <SELECT LotNum="LotNum" name="LotNum">
            <option>--- SELECT ---</option>
            <?php foreach ($list as $row): ?>
                <?php echo "<option value='{$row['LotNum']}'>{$row['LotNum']}</option>";?>
                <?php endforeach ?>
            </select>
            <br>
            <br>

            <input type="submit" value="Submit"> 
            <br>
            </form>

                <?php

                //echo "test: ";
                
                $_SESSION['CLinicName'] = "";
                $_SESSION['VaccDate'] = "";
                $_SESSION['LotNum'] = "";

                if(isset($_SESSION['OHIPNUm'])) {
                    echo $_SESSION['OHIPNum'];
                }

                if(isset($_POST['ClinicName'])) {
                    if ($_POST['ClinicName'] != "") {
                        $_SESSION['ClinicName'] = $_POST['ClinicName'];
                        echo $_SESSION['ClinicName'];
                        echo "<br>";
                    }
                }

                if(isset($_POST['VaccDate'])) {
                    $_SESSION['VaccDate'] = $_POST['VaccDate'];
                    echo $_SESSION['VaccDate'];
                    echo "<br>";
                }

                if(isset($_POST['LotNum'])) {
                    $_SESSION['LotNum'] = $_POST['LotNum'];
                    echo $_SESSION['LotNum'];
                }

               //if ($_SESSION['ClinicName'] != "--- SELECT ---" and $_SESSION['VaccDate'] != "--- SELECT ---" and $_SESSION['LotNum'] != "--- SELECT ---") {
           
                 
          
                
                if (isset($_SESSION['ClinicName']) and isset($_SESSION['VaccDate']) and isset($_SESSION['LotNum'])) {
                    
                    try {
                        $sql = "INSERT INTO vaccinationappointment (LotNum, ClinicName, PatOHIPNum, VaccDate)
                        VALUES('$_SESSION[LotNum]','$_SESSION[ClinicName]','$_SESSION[OHIPNum]','$_SESSION[VaccDate]')";
                        $conn->exec($sql);
                        echo "Values recorded successfully";
                        echo "<br>";
                        header("Location: DisplayPatientVaccinations.php");

                    } catch (PDOException $e) {

                    }

                }
  

                // echo $ClinicName;
                //     if(isset($_POST['ClinicName'])) {
                //         $_SESSION = $row['ClinicName'];
                //         echo $_SESSION["ClinicName"];
                //     }
                //     if(isset($_POST['VaccDate'])) {
                //         $_SESSION = $_POST['VaccDate'];
                //     }
                //     if(isset($_POST['LotNum'])) {
                //         $_SESSION = $_POST['LotNum'];  
                //     }

                   // header("Location: DisplayPatientVaccinations.php");

                    ?>
    </body>
</html>
