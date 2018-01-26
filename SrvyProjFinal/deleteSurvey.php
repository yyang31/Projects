<!DOCTYPE html>
<html>
    <body>

        <?php
        include '../../connect_to_server.php';
        
        $sql = "SELECT `xref_id`, `survey_id`, `question_id` FROM `yyang316868_48947`.`survey_question_xref` AS `survey_question_xref`";
        $result = $conn->query($sql);
        
        // locate and delete the answers
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                if($row["survey_id"] == $_GET["survey_id"]){
                    deleteQuestion($row["xref_id"], $row["question_id"], $servername, $username, $password, $dbname);
                }
            }
            
            $surveyDeleted = true;
        } else {
            echo "0 results";
        }
        
        // update the result
        function deleteQuestion($xref_id, $question_id,$servername,$username,$password,$dbname){
            // Create connection
            $newConn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($newConn->connect_error) {
                die("Connection failed: " . $newConn->connect_error);
            } 
            
            $sqlDeleteQuestion = 'DELETE FROM question_entity WHERE question_id='.$question_id.'';
            if($newConn->query($sqlDeleteQuestion) != TRUE){
                echo "
                <script type=\"text/javascript\">
                    alert('Fail to delete question from question_entity);
                    window.location.replace('mySurvey.php');
                </script>
                ";
            }
            
            $sqlDeleteQuestion = 'DELETE FROM survey_question_xref WHERE xref_id='.$xref_id.'';
            if($newConn->query($sqlDeleteQuestion) != TRUE){
                echo "
                <script type=\"text/javascript\">
                    alert('Fail to delete question from survey_question_xref);
                    window.location.replace('mySurvey.php');
                </script>
                ";
            }
            
            $newConn->close();
        };
        
        //delete the survey from survey_entity
        $sql = 'DELETE FROM survey_entity WHERE survey_id='.$_GET["survey_id"].'';
        if($conn->query($sql) != TRUE){
            echo "
            <script type=\"text/javascript\">
                alert('Fail to delete survey from survey_entity);
                window.location.replace('mySurvey.php');
            </script>
            ";
        }
        
        //delete the survey from user_survey_xref
        $sql = 'DELETE FROM user_survey_xref WHERE survey_id='.$_GET["survey_id"].'';
        $conn->query($sql);
        if($conn->query($sql) != TRUE){
            echo "
            <script type=\"text/javascript\">
                alert('Fail to delete survey from user_survey_xref);
                window.location.replace('mySurvey.php');
            </script>
            ";
        }
        
        echo "
        <script type=\"text/javascript\">
            window.location.replace('mySurvey.php');
        </script>
        ";

        $conn->close();
        ?>

    </body>
</html>