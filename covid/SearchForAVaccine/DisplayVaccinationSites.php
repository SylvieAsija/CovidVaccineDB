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
echo "<tr><th>Company</th><th>Clinic</th><th>Number of Doses</th></tr>";


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

            $stmt = $conn->prepare("SELECT DISTINCT CompName,ClinicName, Doses FROM vaccine, vaccinationappointment WHERE vaccine.LotNum = vaccinationappointment.LotNum AND vaccine.CompName = '$_SESSION[VaccineCompany]'");
            $stmt->execute();

            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
                echo $v;
            }

            $conn = null;
            echo "</table>";

            ?>
            <br>
    </body>
</html>
