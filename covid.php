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
                color: red;
            }

            .RecVaxButton {
                top: 250px;
                left: 5%;
                position: absolute;
                padding: 15px 25px;
                font-size: 24px;
                text-align: center;
                cursor: pointer;
                outline: none;
                color: #000;
                background-color: #808080;
                border: none;
                border-radius: 15px;
                box-shadow: 0 9px #000;
            }

            .RecVaxButton:hover{
                top: 235px;
                left: 3%;
                padding: 30px 50px;
                box-shadow: 0 5px #000;
                transform: translateY(4px);
            }

            /*take a look at .RecVaxButton:active might need it eventually */

            .SearchVaxButton {
                top: 250px;
                left: 30%;
                position: absolute;
                padding: 15px 25px;
                font-size: 24px;
                text-align: center;
                cursor: pointer;
                outline: none;
                color: #000;
                background-color: #808080;
                border: none;
                border-radius: 15px;
                box-shadow: 0 9px #000;
            }

            .SearchVaxButton:hover{
                top: 235px;
                left: 28%;
                padding: 30px 50px;
                box-shadow: 0 5px #000;
                transform: translateY(4px);
            }

            .CheckStatusButton {
                top: 250px;
                left: 55%;
                position: absolute;
                padding: 15px 25px;
                font-size: 24px;
                text-align: center;
                cursor: pointer;
                outline: none;
                color: #000;
                background-color: #808080;
                border: none;
                border-radius: 15px;
                box-shadow: 0 9px #000;
            }

            .CheckStatusButton:hover{
                top: 235px;
                left: 53%;
                padding: 30px 50px;
                box-shadow: 0 5px #000;
                transform: translateY(4px);
            }

            .WorkerCheckButton {
                top: 250px;
                left: 75%;
                position: absolute;
                padding: 15px 25px;
                font-size: 24px;
                text-align: center;
                cursor: pointer;
                outline: none;
                color: #000;
                background-color: #808080;
                border: none;
                border-radius: 15px;
                box-shadow: 0 9px #000;
            }

            .WorkerCheckButton:hover{
                top: 235px;
                left: 73%;
                padding: 30px 35px;
                box-shadow: 0 5px #000;
                transform: translateY(4px);
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

        <a href="covid/RecordVaccination.php">
            <button class="RecVaxButton">Record a Vaccination</button>
        </a>

        <a href="covid/SearchForAVaccine.php">
            <button class="SearchVaxButton">Search for a Vaccine</button>
        </a>

        <a href="covid/CheckPatientStatus.php">
            <button class="CheckStatusButton">Patient Lookup</button>
        </a>

        <a href="covid/MedicalWorkerLookup.php">
            <button class="WorkerCheckButton">Worker Loopup</button>
        </a>

        <?php            
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

    </body>
</html>
