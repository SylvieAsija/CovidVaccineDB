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

        <div class="container">
            <img src="images\blue_banner.jpg" alt="covid banner" width="1600px" height="200px">
            <div class="CTitleText">COVID VACCINE DATABASE</div>
            <a href="http://localhost/covid.php">
                <div class="CLTitleText">COVID</br>DB</div>
            </a>
        </div>
        <form method="post">
            <h1>Vaccine Company</h1>
            <input type="radio"value="Pfizer" name="VaccineCompany">
            <label for="Pfizer">Pfizer</label><br>
            <input type="radio"value="Moderna" name="VaccineCompany">
            <label for="Pfizer">Moderna</label><br>
            <input type="radio"value="Astrazeneca" name="VaccineCompany">
            <label for="Pfizer">Astrazeneca</label><br>
            <input type="radio"value="Johnson & Johnson" name="VaccineCompany">
            <label for="Pfizer">Johnson & Johnson</label><br><br>
            <input type="submit" value="Submit">
            <br>
        </form>

        <?php
            if(isset($_POST['VaccineCompany'])) {
            $_SESSION['VaccineCompany'] = $_POST['VaccineCompany'];
            echo $_POST['VaccineCompany'];
            echo $_SESSION['VaccineCompany'];
            header("Location: SearchForAVaccine/DisplayVaccinationSites.php");
            }
        ?>
        
    </body>
</html>
