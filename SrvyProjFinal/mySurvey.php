<!DOCTYPE html>
<html>
    <head>
        <title>SurveyGorilla - My Survey</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
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
        
        <div id="bigCont">
            <div id="newSurveyCont">
                <div id="closePopup" onclick="hidePopup()">X</div>
                <div id="surveyHeader">
                    <h1>New Survey</h1>
                </div>

                <form action="newSurvey.php" method="post" id="surveyForm">
                    <h3>Survey Title:</h3>
                    <input type="text" name="title" required>
                    <h3>Description:</h3> 
                    <input type="text" name="description" required><br><br><br>
                    <input type="submit" name="submit" id="surveySubmit" value="Create">
                </form>
            </div>
        </div>
        
        <div id="main">
            <div id="pageHeader">
                <h1 id="survey_name"></h1>
            </div>
            <!--      list of surveys to display      -->
            <div id="surveyList">
            </div>
        </div>
        
        <!---------------------------  Javascript  --------------------------->
        <script>
            function showPopup(){
                document.getElementById("bigCont").style.display = "block";
            }

            function hidePopup(){
                document.getElementById("bigCont").style.display = "none";
            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == bigCont) {
                    bigCont.style.display = "none";
                }
            }
        </script>
        
        <!---------------------------  PHP  --------------------------->
        <?php
        include '../../connect_to_server.php';
        
        // start of Javascript
        echo '<script type="text/javascript">';
        
        // find user's name
        $sql = "SELECT `user_id`, `first_name` FROM `yyang316868_48947`.`user_entity` AS `user_entity`";
        $result = $conn->query($sql);
        
        // locating user's name
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                if($_COOKIE["user_id"] == $row["user_id"]){
                    echo '
                        document.getElementById("survey_name").innerHTML = "'.$row["first_name"].'\'s Survey";
                    ';
                }
            }
        } else {
            echo "0 results";
        }
        
        $sql = "SELECT `user_entity`.`user_id`, `user_entity`.`first_name`, `survey_entity`.`survey_id`, `survey_entity`.`title`, `survey_entity`.`description` FROM `yyang316868_48947`.`user_survey_xref` AS `user_survey_xref`, `yyang316868_48947`.`user_entity` AS `user_entity`, `yyang316868_48947`.`survey_entity` AS `survey_entity` WHERE `user_survey_xref`.`user_id` = `user_entity`.`user_id` AND `survey_entity`.`survey_id` = `user_survey_xref`.`survey_id`";
        $result = $conn->query($sql);
        
        // locate all the survey
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                if($_COOKIE["user_id"] == $row["user_id"]){
                    $resultLnk = 'surveyResult.php?survey_id='.$row["survey_id"].'';
                    $editLnk = 'editSurvey.php?survey_id='.$row["survey_id"].'';
                
                    echo '
                    document.getElementById("surveyList").innerHTML += "<div class=\'surveyListCont\'><a class=\'surveyListTitle surveyLink\' href=\''.$resultLnk.'\'>'.$row["title"].'</a><a class=\'surveyEditBtn\' href=\''.$editLnk.'\'></a><div class=\'surveyListDescription\'>'.$row["description"].'</div></div>";
                    ';
                }
            }
            
            echo'
            document.getElementById("surveyList").innerHTML += "<a id=\'newSurveyBtn\' onclick=\'showPopup()\'>+</a>";
            ';
        } else {
            echo "0 results";
        }
        echo '</script>';

        $conn->close();
        ?>
    </body>
</html>