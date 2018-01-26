<!DOCTYPE html>
<html>
    <body>

        <?php
        include '../../connect_to_server.php';
        
        $surveyCreated = false;
        
        // insert new survey
        $sql = "INSERT INTO survey_entity (title, description)
        VALUES ('".$_POST["title"]."', '".$_POST["description"]."')";
        
        if ($conn->multi_query($sql) === TRUE) {
            $surveyCreated = true;
            $last_id = $conn->insert_id;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        
        // create the cross reference
        $sql = "INSERT INTO user_survey_xref (user_id, survey_id)
        VALUES ('".$_COOKIE["user_id"]."', '".$last_id."')";
        
        if($surveyCreated){
            if ($conn->multi_query($sql) === TRUE) {
                echo "
                    <script type=\"text/javascript\">
                        window.location.replace('mySurvey.php');
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