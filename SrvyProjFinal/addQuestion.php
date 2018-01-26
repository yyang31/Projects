<!DOCTYPE html>
<html>
    <body>

        <?php
        include '../../connect_to_server.php';
        
        // retreat the answers from the post
        // create answer and result array
        $answerArray = array();
        $resultArray = array();
        
        foreach($_POST as $key => $value)
        {
            if (strstr($key, 'answer'))
            {
                array_push($answerArray, strtolower($value));
                array_push($resultArray, 0);
            }
        }
        
        $answerArray = json_encode($answerArray);
        $resultArray = json_encode($resultArray);
        
        $questionAdded = false;
        
        // insert new survey
        $sql = "INSERT INTO question_entity (question, identifier, answer, result)
        VALUES ('".$_POST["question"]."', '".$_POST["identifier"]."','".$answerArray."','".$resultArray."')";
        
        if ($conn->multi_query($sql) === TRUE) {
            $questionAdded = true;
            $last_id = $conn->insert_id;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        
        // create the cross reference
        $sql = "INSERT INTO survey_question_xref (survey_id, question_id)
        VALUES ('".$_GET["survey_id"]."', '".$last_id."')";
        
        if($questionAdded){
            if ($conn->multi_query($sql) === TRUE) {
                echo "
                    <script type=\"text/javascript\">
                        window.location.replace('editSurvey.php?survey_id=".$_GET["survey_id"]."');
                    </script>
                ";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        $conn->close();
        ?>

    </body>
</html>