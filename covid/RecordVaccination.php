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

            .form{
                position: absolute;
                text-align: center;
                left: 600px;
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
               // echo "Connected successfully";
            } catch(PDOException $e) {
               // echo "Connection failed: " . $e->getMessage();
            }        
        
        
        //https://tryphp.w3schools.com/showphp.php?filename=demo_form_validation_complete
// define variables and set to empty values
$OHIPNumErr = "";
$OHIPNum = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["OHIPNum"])) {
        $OHIPNumErr = "OHIP number is required";
    } else {
        $OHIPNum = test_input($_POST["OHIPNum"]);
        if (strlen($_POST["OHIPNum"]) != 10) {
            $OHIPNumErr = "OHIP numbers are 10 digits long";
        } else if(!preg_match("/^[0-9]*$/",$OHIPNum)) {
            $OHIPNumErr = "Only numbers allowed";
        } 
    }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<h2>Record a Vaccination</h2>
<p><span class="error">* required field</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
    OHIP Number: <input type="text" name="OHIPNum" maxlength = "10" size="10" value="<?php echo $OHIPNum;?>">
    <span class="error">* <?php echo $OHIPNumErr;?></span>
    <br><br>
    <input type="submit" value="Submit">
</form>

<?php
//echo "<h2>Your Input:</h2>";
if ($OHIPNumErr == "" and $OHIPNum != "") {
    $OHIPNumExists = 0;
    $sql = "SELECT PatOHIPNum FROM patient WHERE PatOHIPNum = :OHIPNum";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':OHIPNum',$_POST["OHIPNum"]);
    $stmt->execute();

    if($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $OHIPNumExists = 1;
    } else {
        $OHIPNumExists = 0;
    }

    $stmt->closeCursor();

    if ($OHIPNumExists) {
        echo $OHIPNum;
        echo "<br>";

        $_SESSION['OHIPNum'] = $_POST['OHIPNum'];

        $sql = "SELECT * FROM patient WHERE PatOHIPNum =$OHIPNum";
        $result = $conn->query($sql);

            while($row = $result->fetch()) {
                $firstname = $row["PatFName"];
                $lastname = $row["PatLName"];
                $birthday = $row["PatDOB"];
            }
    
        $_SESSION['firstname'] = $firstname;
        $_SESSION['lastname'] = $lastname;
        $_SESSION['birthday'] = $birthday;

        header("Location: RecordVaccination/NewEntryVaccineAppointmentInfo.php");

    } else {
        echo "no it doesn't exist";
        echo "<br>";
        $sql = "INSERT INTO patient (PatOHIPNum)
                VALUES('$OHIPNum')";
        $conn->exec($sql);
        echo "OHIP number recorded successfully";
        echo "<br>";
        echo $OHIPNum;

        $_SESSION['OHIPNum'] = $_POST['OHIPNum'];

        header("Location: RecordVaccination/NewEntryPatientInfo.php");
    }
}

?>


    </body>
</html>
