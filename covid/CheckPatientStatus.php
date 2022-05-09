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



?>


<form name="patientDropdown" method="POST">
        Patient List:  
        <?php 


            $stmt=$conn->prepare("SELECT DISTINCT PatOHIPNum FROM patient");
            $stmt->execute();
            $list = $stmt->fetchAll();
            ?>

            <SELECT PatOHIPNum="PatOHIPNum" name="PatOHIPNum">
                <option>--- SELECT ---</option>
            <?php foreach ($list as $row): ?>
                <?php echo "<option value='{$row['PatOHIPNum']}'>{$row['PatOHIPNum']}</option>";?>
                <?php endforeach ?>
            </select>
            <br>
       
            <input type="submit" value="Submit" >
            <br>
            </form>

            <?php 

                $_SESSION['PatOHIPNum'] = "";
                if(isset($_POST['PatOHIPNum']) and $_POST['PatOHIPNum'] != "--- SELECT ---") {
                    $_SESSION['PatOHIPNum'] = $_POST['PatOHIPNum'];
                    echo $_POST['PatOHIPNum'];
                    header("Location: DisplayPatientStatus.php");
                }

                if(isset($_SESSION['PatOHIPNum'])) {
                    //echo $_SESSION['PatOHIPNum'];
                    //header("Location: DisplayPatientStatus.php");
                }
        
            ?>
    </body>
</html>
