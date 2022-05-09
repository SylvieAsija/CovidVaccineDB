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

            echo "<table style='border: solid 1px black;'>";
            echo "<tr><th>OHIP Number</th><th>First Name</th><th>Last Name</th><th>Date of Birth</th><th>Clinic Name</th><th>Vaccination Date</th><th>Lot Number</th></tr>";


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
               // echo "Connected successfully";
            } catch(PDOException $e) {
               // echo "Connection failed: " . $e->getMessage();
            }        
            

            $stmt = $conn->prepare("SELECT patient.PatOHIPNum, PatFName, PatLName, PatDOB, ClinicName, VaccDate, LotNum FROM patient, vaccinationappointment WHERE patient.PatOHIPNum = vaccinationappointment.PatOHIPNum AND patient.PatOHIPNum = '$_SESSION[PatOHIPNum]'");
            $stmt->execute();

            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
                echo $v;
            }

            $conn = null;
            echo "</table>";
        




            //  echo "<h2>Patient Information:</h2>";
             
            //  if(isset($_SESSION['OHIPNum'])) {
            //      echo "OHIP Number: ";
            //      echo $_SESSION['OHIPNum'];
            //      echo "<br>";
            //  }

            //  if(isset($_SESSION['firstname'])) {
            //      echo "First name: ";
            //      echo $_SESSION['firstname'];
            //      echo "<br>";
            //  }

            //  if(isset($_SESSION['lastname'])) {
            //      echo "Last name: ";
            //      echo $_SESSION['lastname'];
            //      echo "<br>";
            //  }

            //  if(isset($_SESSION['birthday'])) {
            //      echo "Birthday: ";
            //      echo $_SESSION['birthday'];
            //      echo "<br>";
            //  }

            //  if(isset($_SESSION['ClinicName'])) {
            //     echo "Vaccination Clinic: ";
            //     echo $_SESSION['ClinicName'];
            //     echo "<br>";
            // }

            // if(isset($_SESSION['VaccDate'])) {
            //     echo "Vaccination Date: ";
            //     echo $_SESSION['VaccDate'];
            //     echo "<br>";
            // }

            // if(isset($_SESSION['LotNum'])) {
            //     echo "Lot Number: ";
            //     echo $_SESSION['LotNum'];
            //     echo "<br>";
            // }
             ?>
    </body>
</html>
