<!DOCTYPE html>
<html>
    <head>
        <title>Edit a User</title>
    </head>
    <body>
        
        <?php
        
        // connect to the server
        include '../../connect_to_server.php';
        
        // sql to delete a record
        $sql = "DELETE FROM user_entity WHERE user_id=".$_GET["user_id"]."";

        if ($conn->query($sql) === TRUE) {
            echo "
            <script type=\"text/javascript\">
                alert('User deleted');
                location.assign('admin_view.php');
            </script>
            ";
        } else {
            $errorMsg = "Error deleting record: " . $conn->error;
            echo "
            <script type=\"text/javascript\">
                alert(\"".$errorMsg."\");
                location.assign('admin_view.php');
            </script>
            ";
        }
        
        ?>
        
    </body>
</html>