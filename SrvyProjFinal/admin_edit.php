<!DOCTYPE html>
<html>
    <head>
        <title>Edit User</title>
    </head>
    <body>
        <div>Edit a User</div>
        <?php
        // connect to the server
        include '../../connect_to_server.php';
        // get the number of user
        $sql = "SELECT  `user_id`, `first_name`, `last_name`, `email`, `password` FROM `yyang316868_48947`.`user_entity` AS `user_entity`";
        // access the database
        $result = $conn->query($sql);
        
        // Check for a valid user name
        $idx = $_GET['user_id'];
        if ($idx<=0) {
            echo "
            <script type=\"text/javascript\">
                alert('This page has been accessed in error');
                location.assign('admin_view.php');
            </script>
            ";
        }
        
        // Create the form:
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                if($idx == $row["user_id"]){
                    $str='<form action="update_user.php" method="post">';
                    $str.='<br>User ID:<br><input type="text" name="user_id" value="'.$row['user_id'].'" readonly/></p>';
                    $str.='First Name:<br><input type="text" name="first_name" value="'.$row['first_name'].'" required/></p>';
                    $str.='Last Name:<br><input type="text" name="last_name" value="'.$row['last_name'].'" required/></p>';
                    $str.='Email:<br><input type="text" name="email" value="'.$row['email'].'" required/></p>';
                    $str.='Password:<br><input type="text" name="password" pattern="[a-zA-Z0-9]{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" value="'.$row['password'].'" required/></p>';
                    $str.='<p><input type="submit" value="Edit"/></form></p>';
                    
                    echo "
                    <script type=\"text/javascript\">
                        document.write('".$str."');
                        document.write('<a href=\"admin_view.php\">back</a>');
                    </script>
                    ";
                }
            }
        } else {
            echo "0 results";
        }
        
        ?>
        
    </body>
</html>
