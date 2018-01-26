<!DOCTYPE html>
<html>
    <body>

        <?php
        include '../../connect_to_server.php';
        
        // get user_id of the people who is in the room
        $sql = "SELECT `email` FROM `yyang316868_48947`.`user_entity` AS `user_entity`";
        $result = $conn->query($sql);
        
        $uniqueEmail = true;
        
        // check for duplicate email address
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                if( strtolower($row["email"]) == strtolower($_POST["email"])){
                    echo "
                    <script type=\"text/javascript\">
                        alert('The email you entered is already associated with another account.\
                        Please try with a different email!');
                        window.location.replace('main.php');
                    </script>
                    ";
                    
                    $uniqueEmail = false;
                }
            }
        } else {
            echo "0 results";
        }
        
        // insert new user
        if($uniqueEmail){
            $sql = "INSERT INTO user_entity (first_name, last_name, email, password)
            VALUES ('".$_POST["firstname"]."', '".$_POST["lastname"]."', '".$_POST["email"]."', '".$_POST["password"]."')";

            if ($conn->multi_query($sql) === TRUE) {
                setcookie("user_id",$conn->insert_id, time() + (86400 * 30), "/"); // 86400 = 1 
                
                echo "
                    <script type=\"text/javascript\">
                        alert('Welcome! you have successfully signed up.');
                        window.location.replace('main.php');
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