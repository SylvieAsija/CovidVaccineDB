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

echo "<table style='border: solid 1px black;'>";
echo "<tr><th>Clinic Name</th><th>Worker First Name</th><th>Worker Last Name</th><th>Occupation</th></tr>";


class TableRows extends RecursiveIteratorIterator {
    function __construct($it) {
    parent::__construct($it, self::LEAVES_ONLY);
    }
    function current() {
        return "<td style='width:150px;border:1px solid black;'>" . parent::current(). "</td>";
    }
    
    function beginChildren() {
        echo "<tr>";
    }
    
    function endChildren() {
        echo "</tr>" . "\n";
    }
}


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



<form name="SiteList" method="POST">
        Site List:  
        <?php 


            $stmt=$conn->prepare("SELECT DISTINCT ClinicName FROM clinic");
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
       
            <input type="submit" value="Submit" >
            <br>
            </form>

            <?php 

                $_SESSION['ClinicName'] = "";
                if(isset($_POST['ClinicName']) and $_POST['ClinicName'] != "--- SELECT ---") {
                    $_SESSION['ClinicName'] = $_POST['ClinicName'];
                    //echo $_POST['ClinicName'];
                }
        
            ?>

<?php
$stmt = $conn->prepare("SELECT clinic.ClinicName, HWFName, HWLName FROM clinic INNER JOIN worksat ON clinic.ClinicName = worksat.ClinicName INNER JOIN healthcareworker ON worksat.HWID = healthcareworker.HWID WHERE clinic.ClinicName = '$_SESSION[ClinicName]'");
$stmt->execute();

$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
    echo $v;
}

$conn = null;
echo "</table>";

                ?>
    </body>
</html>
