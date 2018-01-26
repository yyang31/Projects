<!DOCTYPE html>
<html>
    <head>
        <title>Edit a User</title>
    </head>
    <body>
        
        <?php
        
        // connect to the server
        include '../../connect_to_server.php';
        
        $cart = json_decode($_COOKIE["user_cart"]);
        $checkedOut = false;
        
        for($i = 0; $i < count($cart); $i++){
            $sql = "UPDATE item_entity SET quantity=quantity-1 WHERE item_id='".$cart[$i]."'";
            
            if ($conn->query($sql) === TRUE) {
                $checkedOut = true;
            } else {
                echo "Error updating record: " . $conn->error;
            }
        }
        
        if($checkedOut){
            $sql = "UPDATE cart_entity SET cart='[]' WHERE cart_id='".$_COOKIE["user_id"]."'";
        
            if ($conn->query($sql) === TRUE) {
                    setcookie('user_cart',"[]");

                    echo "
                    <script type=\"text/javascript\">
                        window.location.replace('main.php');
                    </script>
                    ";
            } else {
                echo "Error updating record: " . $conn->error;
            }
        }
        ?>
        
    </body>
</html>