<!DOCTYPE html>
<html>
    <body>

        <?php
        include '../../connect_to_server.php';
        
        // grab the questions thats associted with the survey_id
        $sql = "SELECT `survey_question_xref`.`survey_id`, `survey_entity`.`title`, `survey_entity`.`description`, `question_entity`.`question_id`, `question_entity`.`question`, `question_entity`.`identifier`, `question_entity`.`answer`, `question_entity`.`result` FROM `yyang316868_48947`.`survey_question_xref` AS `survey_question_xref`, `yyang316868_48947`.`survey_entity` AS `survey_entity`, `yyang316868_48947`.`question_entity` AS `question_entity` WHERE `survey_question_xref`.`survey_id` = `survey_entity`.`survey_id` AND `question_entity`.`question_id` = `survey_question_xref`.`question_id`";
        $result = $conn->query($sql);
        
        // locate the survey that was taken
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                if($row["title"] == $_GET["title"]){
                    $question_id = $row["question_id"];
                    $ans = json_decode($row["answer"]);
                    $res = json_decode($row["result"]);
                    
                    for($i=0; $i<count($ans); $i++){
                        if($ans[$i] == $_POST[$row["identifier"]]){
                            $res[$i]++;
                        }
                    }
                    
                    $res = json_encode($res);
                    
                    updateResult($res, $question_id,$servername,$username,$password,$dbname);
                }
            }
            
        } else {
            echo "
            <script type=\"text/javascript\">
                alert('Couldn't locate the survey);
                window.location.replace('main.php');
            </script>
            ";
        }
        
        // update the result
        function updateResult($res, $question_id,$servername,$username,$password,$dbname){
            // Create connection
            $newConn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($newConn->connect_error) {
                die("Connection failed: " . $newConn->connect_error);
            } 
            
            $sqlUpdate = 'UPDATE question_entity SET result="'.$res.'" WHERE question_id='.$question_id.'';
            
            if ($newConn->query($sqlUpdate) === TRUE) {
                
            } else {
                echo '
                <script type="text/javascript">
                    alert("Error updating record: "'.$newConn->error.');
                    //window.location.replace("main.php");
                </script>
                ';
            }
            
            $newConn->close();
        };
        
        echo "
        <script type=\"text/javascript\">
            window.location.replace('main.php');
        </script>
        ";

        $conn->close();
        ?>

    </body>
</html>