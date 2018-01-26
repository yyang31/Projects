<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        //Coonect to database
        include '../../connect_to_server.php';
        $sql = "SELECT `first_name`, `last_name`, `email`, `password` FROM `yyang316868_48947`.`admin_entity` AS `admin_entity`";
        
        $result = $conn->query($sql);
        
        $adminFirst;
        $adminLast;
        $adminEmail; 
        $adminUsername;
        
        $logedin = false;
        
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                if(strtolower($_POST["email"]) === strtolower($row["email"]) 
                        && $_POST["password"] === $row["password"]){
                    
                    $adminFirst = $row["first_name"];
                    $adminLast = $row["last_name"];
                    $adminEmail = $row["email"];
                    
                    setcookie('adminFirst', $adminFirst);
                    setcookie('adminLast', $adminLast);
                    setcookie('adminEmail',$adminEmail);
                    setcookie('adminUsername',$adminUsername);
                    
                    //Store these variables into local storage or cookies
                    echo "<script type=\"text/javascript\"> window.location.replace('admin_view.php')</script>";
                    
                    $logedin = true;
                    }
                }
            }else {
            echo "0 results";
        }
        
        if(!$logedin){
            echo "<script type=\"text/javascript\"> alert('You are not admin!')</script>";
//            echo "<script type=\"text/javascript\"> window.location.replace('admin.html')</script>";
        }
        
        $conn->close();
        ?>
    </body>
</html>
