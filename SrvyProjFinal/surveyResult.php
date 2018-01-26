<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="Survey.js"></script>
        <script src="functions.js"></script>
    </head>
    <body>
        <ul id="topnav">
            <img src="img/logo_white.png" id="navMenu" onclick="navMenu()">
            <li>
                <a href="main.php" class ="active">
                    <img src="img/logo_white.png" id="logo">
                    SurveyGorilla
                </a>
            </li>
            <li><a href="mySurvey.php">My Survey</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>

        <div id="main">
            <div id="surveyHeader">
                <h1 id="survey_name"></h1>
                <p id="description"></p>
            </div>
        </div>
        
        <!------------------------------   PHP   ------------------------------>
        <?php
        include '../../connect_to_server.php';
        
        // begaining of the java script
        echo '<script type="text/javascript">'."\r\n";
        
        // grab the data from survey_entity
        $sql = "SELECT `survey_id`, `title`, `description` FROM `yyang316868_48947`.`survey_entity` AS `survey_entity`";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                if($row["survey_id"] == $_GET["survey_id"]){
                    echo 'document.title="Survey Gorilla - '.$row["title"].' Result";'."\r\n";
                    echo 'var newSurvey = new Survey("'.$row["title"].' - Result", "'.$row["description"].'");'."\r\n";

                }
            }
        } else {
            echo "0 results";
        }
        
        
        // grab the email and password form the database
        $sql = "SELECT `survey_question_xref`.`survey_id`, `survey_entity`.`title`, `survey_entity`.`description`, `question_entity`.`question`, `question_entity`.`identifier`, `question_entity`.`answer`,`question_entity`.`result` FROM `yyang316868_48947`.`survey_question_xref` AS `survey_question_xref`, `yyang316868_48947`.`survey_entity` AS `survey_entity`, `yyang316868_48947`.`question_entity` AS `question_entity` WHERE `survey_question_xref`.`survey_id` = `survey_entity`.`survey_id` AND `question_entity`.`question_id` = `survey_question_xref`.`question_id`";
        $result = $conn->query($sql);
        
        $count = 0;
        
        // check for email and password
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                if($row["survey_id"] == $_GET["survey_id"]){
                    echo 'newSurvey.addQuestion("'.$row["identifier"].'", "'.$row["question"].'", '.$row["answer"].');'."\r\n";
                    echo 'newSurvey.questions['.$count.'].result = '.$row["result"].';'."\r\n";
                    $count++;
                }
            }
        } else {
            echo "0 results";
        }
        
        // print out the survey
        echo 'newSurvey.displayResult();'."\r\n";

        //end of the java script
        echo '</script>';
        
        $conn->close();
        ?>

    </body>
</html>