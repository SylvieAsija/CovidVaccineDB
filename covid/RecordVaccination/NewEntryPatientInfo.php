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

            $firstnameErr = $lastnameErr = "";
            $firstname = $lastname = "";
            $new_date = $birthday = "";

            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                if (empty($_POST["firstname"])) {
                    $firstnameErr = "First name is required";
                } else {
                    $firstname = test_input($_POST["firstname"]);
                    // check if name only contains letters and whitespace
                    if (!preg_match("/^[a-zA-Z-' ]*$/",$firstname)) {
                        $firstnameErr = "Only letters and white space allowed";
                    }
                }
            
                if (empty($_POST["lastname"])) {
                    $lastnameErr = "Last name is required";
                    } else {
                    $lastname = test_input($_POST["lastname"]);
                    // check if name only contains letters and whitespace
                    if (!preg_match("/^[a-zA-Z-' ]*$/",$lastname)) {
                        $lastnameErr = "Only letters and white space allowed";
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

<h2>Finish Recording a Vaccination</h2>
<p><span class="error">* required field</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
    First Name: <input type="text" name="firstname" value="<?php echo $firstname;?>">
    <span class="error">* <?php echo $firstnameErr;?></span>
    <br><br>
    Last Name: <input type="text" name="lastname" value="<?php echo $lastname;?>">
    <span class="error">* <?php echo $lastnameErr;?></span>
    <br><br>
    Birthday: <input type="date" name="birthday" value="<?php echo date('Y-m-d');?>"/>
    <br><br>
    <input type="submit" value="Submit">
</form>

<?php
// echo "<h2>Your Input:</h2>";
// if(isset($_SESSION['OHIPNum'])) {
//     echo "OHIP number recorded successfully: ";
//     echo $_SESSION['OHIPNum'];
//     echo "<br>";
// }





if ($firstnameErr == "" and $firstname != "") {
    $sql = "UPDATE patient SET PatFName='$firstname' WHERE PatOHIPNum=$_SESSION[OHIPNum]";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    echo "First name recorded successfully: ";
    echo $firstname;
    echo "<br>";

    $_SESSION['firstname'] = $_POST['firstname'];

}

if ($lastnameErr == "" and $lastname != "") {
    $sql = "UPDATE patient SET PatLName='$lastname' WHERE PatOHIPNum=$_SESSION[OHIPNum]";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    echo "Last name recorded successfully: ";
    echo $lastname;
    echo "<br>";

    $_SESSION['lastname'] = $_POST['lastname'];

}

if (isset($_POST['birthday'])) {
    $new_date = date('Y-m-d', strtotime($_POST['birthday']));
    $sql = "UPDATE patient SET PatDOB='$new_date' WHERE PatOHIPNum=$_SESSION[OHIPNum]";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    echo "Birthday recorded successfully: ";
    echo $new_date;
    echo "<br>";

    $_SESSION['birthday'] = $_POST['birthday'];

    header("Location: NewEntryVaccineAppointmentInfo.php");

}

?>

    </body>
</html>
