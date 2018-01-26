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
        
        <div id="bigCont">
            <div id="newSurveyCont">
                <div id="closePopup" onclick="hidePopup()">X</div>
                <div id="surveyHeader">
                    <h1>New Survey</h1>
                </div>

                <form action="" method="post" id="popupForm">
                    <h3>Question:</h3>
                    <input type="text" name="question" required>
                    <h3>Identifier:</h3> 
                    <input type="text" name="identifier" required>
                    <h3>Answer:</h3> 
                    <div id="answerCon">
                        <input type="text" name="answer1" required>
                        <input type="text" name="answer2" required>
                    </div>
                    <div id="moreAnswer" onclick="moreAnswer()">+</div>
                    <input type="submit" name="submit" id="popupSubmit" value="Add">
                </form>
            </div>
        </div>

        <div id="main">
            <div id="surveyHeader">
                <h1 id="survey_name"></h1>
                <p id="description"></p>
            </div>
        </div>
        
        <?php
        include '../../connect_to_server.php';
        
        // begaining of the java script
        echo '<script type="text/javascript">';
        
        // grab the data from survey_entity
        $sql = "SELECT `survey_id`, `title`, `description` FROM `yyang316868_48947`.`survey_entity` AS `survey_entity`";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                if($row["survey_id"] == $_GET["survey_id"]){
                    $survey_id = $row["survey_id"];
                    echo 'document.getElementById("popupForm").action="addQuestion.php?survey_id='.$row["survey_id"].'";';
                    echo 'document.title="Survey Gorilla - Edit '.$row["title"].'";';
                    echo 'var newSurvey = new Survey("'.$row["title"].' - Edit", "'.$row["description"].'");';

                }
            }
        } else {
            echo "0 results";
        }
        
        
        // all the survey answers form the database
        $sql = "SELECT `survey_question_xref`.`survey_id`, `survey_entity`.`title`, `survey_entity`.`description`, `question_entity`.`question`, `question_entity`.`identifier`, `question_entity`.`answer` FROM `yyang316868_48947`.`survey_question_xref` AS `survey_question_xref`, `yyang316868_48947`.`survey_entity` AS `survey_entity`, `yyang316868_48947`.`question_entity` AS `question_entity` WHERE `survey_question_xref`.`survey_id` = `survey_entity`.`survey_id` AND `question_entity`.`question_id` = `survey_question_xref`.`question_id`";
        $result = $conn->query($sql);
        
        // add survey answers
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                if($row["survey_id"] == $_GET["survey_id"]){
                    echo 'newSurvey.addQuestion("'.$row["identifier"].'", "'.$row["question"].'", '.$row["answer"].');';
                }
            }
        } else {
            echo "0 results";
        }
        
        // print out the survey
        echo 'newSurvey.displaySurvey();';
        
        // creating the 'addQuestion' button
        echo 'document.getElementById("surveyForm").innerHTML += "<a id=\'addQuestionBtn\' onclick=\'showPopup()\'>+</a>";';
        echo 'document.getElementById("surveyForm").innerHTML += "<a id=\'deleteSurvey\' onclick=\'deleteConfirm()\'>Delete Survey</a>";';
        
        //end of the java script
        echo '</script>';
        
        $conn->close();
        ?>
        
        <script type="text/javascript">
            // remove the sumbit button from the popup from
            var sumbitBtn = document.getElementById("surveySubmit");
            sumbitBtn.parentNode.removeChild(sumbitBtn);
            
            // add more answers
            var answerCounter = 3;
            function moreAnswer(){
                // the new element
                var newAnswer = document.createElement("input");
                newAnswer.type = "text";
                newAnswer.name="answer" + answerCounter;
                answerCounter++;
                newAnswer.required = true;
                //document.getElementById("popupForm").appendChild(newAnswer);
                //var pre = document.getElementById("moreAnswer");
                document.getElementById("answerCon").appendChild(newAnswer);
            }
            
            // popup
            function showPopup(){
                document.getElementById("bigCont").style.display = "block";
            }
            
            function hidePopup(){
                document.getElementById("bigCont").style.display = "none";
                resetPopup();
            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == bigCont) {
                    bigCont.style.display = "none";
                    resetPopup();
                }
            }
            
            function resetPopup(){
                // delete the added answer inputs
                var nodeLength = document.getElementById("answerCon").childNodes.length - 1;
                
                for(var i = answerCounter; i >3; i--){
                    var select = document.getElementById('answerCon');
                    select.removeChild(select.childNodes[nodeLength]);
                    answerCounter--;
                    nodeLength--;
                }
                
                // clear the answers
                for(var i = nodeLength; i >0; i--){
                    var select = document.getElementById('answerCon');
                    select.childNodes[i].value="";
                }
                
                // clear the form
                nodeLength = document.getElementById("popupForm").childNodes.length - 3;
                for(var i = nodeLength; i >0; i--){
                    var select = document.getElementById('popupForm');
                    select.childNodes[i].value="";
                }
            }
            
            function deleteConfirm(){
                var conf = confirm("Are you sure you want to delete this survey?");
                
                if(conf){
                    window.location.replace("deleteSurvey.php?survey_id=<?php echo $survey_id ?>");
                }
            }
        </script>

    </body>
</html>