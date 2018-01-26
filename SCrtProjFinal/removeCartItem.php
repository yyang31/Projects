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
        
        for($i = 0; $i < count($cart); $i++){
            if($cart[$i] == $_GET["item_id"]){
                array_splice($cart, $i, 1);
            }
        }
        
        $cart = json_encode($cart);
        
        // update user info
        $sql = "UPDATE cart_entity SET cart='".$cart."' WHERE cart_id='".$_COOKIE["user_id"]."'";

        if ($conn->query($sql) === TRUE) {
            // reset the cookie
            setcookie('user_cart',$cart);

            echo "
            <script type=\"text/javascript\">
                window.location.replace('main.php');
            </script>
            ";
        } else {
            echo "Error updating record: " . $conn->error;
        }
        ?>
        
    </body>
</html>