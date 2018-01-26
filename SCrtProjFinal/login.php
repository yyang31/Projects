<!DOCTYPE html>
<html>
    <body>

        <?php
        include '../../connect_to_server.php';
        
        // grab the email and password form the database
        $sql = "SELECT `user_entity`.`user_id`, `user_entity`.`first_name`, `user_entity`.`last_name`, `user_entity`.`email`, `user_entity`.`password`, `cart_entity`.`cart` FROM `yyang316868_48947`.`user_cart_xref` AS `user_cart_xref`, `yyang316868_48947`.`user_entity` AS `user_entity`, `yyang316868_48947`.`cart_entity` AS `cart_entity` WHERE `user_cart_xref`.`user_id` = `user_entity`.`user_id` AND `cart_entity`.`cart_id` = `user_cart_xref`.`cart_id`";
        $result = $conn->query($sql);
        
        $failLogin = true;
        
        // check for email and password
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                if(strtolower($_POST["email"]) === strtolower($row["email"]) && $_POST["password"] === $row["password"]){
                    setcookie('user_id', $row["user_id"]);
                    setcookie('user_first', $row["first_name"]);
                    setcookie('user_last', $row["last_name"]);
                    setcookie('user_email',$row["email"]);
                    setcookie('user_cart',$row["cart"]);
                        
                    echo "
                    <script type=\"text/javascript\">
                        window.location.replace('main.php');
                    </script>
                    ";
                }
            }
        } else {
            echo "0 results";
        }
        
        if($failLogin){
            echo "
            <script type=\"text/javascript\">
                alert('Invalid Username and/or Password!');
                window.location.replace('main.php');
            </script>
            ";
        }

        $conn->close();
        ?>

    </body>
</html>