<!DOCTYPE html>
<html>
    <head>
        <title>Display the User Table</title>
    </head>
    <body>
        <div>Display the User Table</div>
        
        <?php
        
        if(!isset($_COOKIE["adminEmail"])) {
            echo "<script type=\"text/javascript\"> alert('Admin Login Fail!')</script>";
            echo "<script type=\"text/javascript\"> window.location.replace('Login.html')</script>";
        }
        
        include '../../connect_to_server.php';
        
        $display = 5;
        $pages=0;
        $start=0;

        // get the number of user
        $sql = "SELECT  `user_id` FROM `yyang316868_48947`.`user_entity` AS `user_entity`";
        // access the database
        $result = $conn->query($sql);
        
        // Determine how many pages there are...
        if(isset($_GET['p'])){
            $pages = $_GET['p'];
        }else {
            $records = $result->num_rows;
            // Calculate the number of pages...
            if ($records > $display) { // More than 1 page.
                    $pages = ceil ($records/$display);
            } else {
                    $pages = 1;
            }
        }
        
        // Determine where in the database to start returning results...
        if(isset($_GET['s'])){
            if (intval($_GET['s'], 10)>0){
                $start = $_GET['s'];
            } else {
                $start = 0;
            }
        }

        // Determine the sort...
        $sort = "last_name";
        if(isset($_GET['sort'])) {
            $sort = $_GET['sort'];
        }
        
        // Determine the sorting order:
        switch ($sort) {
                case 'first_name':
                        $sort = 'first_name';
                        break;
                case 'last_name':
                        $sort = 'last_name';
                        break;
                case 'email':
                        $sort = 'email';
                        break;
                case 'password':
                        $sort = 'password';
                        break;
                default:
                        $sort = 'last_name';
                        break;
        }
        
        // Define the query:
        $sql = "SELECT  `user_id`, `first_name`, `last_name`, `email`, `password` FROM `yyang316868_48947`.`user_entity` AS `user_entity` ORDER BY `".$sort."` LIMIT ".$start.", ".$display."";
        
        // access the database
        $result = $conn->query($sql);
        
        // Table header
        $strTab='<table align="center" cellspacing="0" cellpadding="5" width="75%">';
        $strTab.='<tr>';
        $strTab.='<td align="left"><b>Edit</b></td>';
        $strTab.='<td align="left"><b>Delete</b></td>';
        $strTab.='<td align="left"><b><a href="admin_view.php?sort=first_name">First Name</a></b></td>';
        $strTab.='<td align="left"><b><a href="admin_view.php?sort=last_name">Last Name</a></b></td>';
        $strTab.='<td align="left"><b><a href="admin_view.php?sort=email">Email</a></b></td>';
        $strTab.='<td align="left"><b><a href="admin_view.php?sort=password">Password</a></b></td>';
        $strTab.='</tr>';
        
        // create the table
        echo "
        <script type=\"text/javascript\">
            document.write('".$strTab."');
        </script>
        ";
        
        // Fetch and print all the records....
        $end = $result->num_rows;
        if($end-$start>$display){
            $end=1*$start+$display;
        }
        $bg = '#eeeeee';
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee');
                $strRow= '<tr bgcolor="'.$bg.'">';
                $strRow.=('<td align="left"><a href="admin_edit.php?user_id='.$row["user_id"].'">Edit</a></td>');
                $strRow.=('<td align="left"><a onclick="deleteUser('.$row['user_id'].')" style="cursor:pointer">Delete</a></td>');
                $strRow.=('<td align="left">'.$row['first_name'].'</td>');
                $strRow.=('<td align="left">'.$row['last_name'].'</td>');
                $strRow.=('<td align="left">'.$row['email'].'</td>');
                $strRow.=('<td align="left">'.$row['password'].'</td>');
                $strRow.='</tr>';
                
                echo "
                <script type=\"text/javascript\">
                    document.write('".$strRow."');
                </script>
                ";
            }
        } else {
            echo "0 results";
        }
        
        echo "
        <script type=\"text/javascript\">
            document.write('</table>');
        </script>
        ";
        
        // Make the links to other pages, if necessary.
        if ($pages > 1) {
            echo "
            <script type=\"text/javascript\">
                document.write('<br /><p>');
            </script>
            ";
            $current_page = floor($start/$display) + 1;

            // If it's not the first page, make a Previous button:
            if ($current_page != 1) {
                $pageStart = $start - $display;
                $url = "admin_view.php?s=".$pageStart."&p=".$pages."&sort=".$sort."";
                echo "
                <script type=\"text/javascript\">
                    document.write('<a href=".$url.">Previous</a> ');
                </script>
                ";
            }

            // Make all the numbered pages:
            for ($i = 1; $i <= $pages; $i++) {
                    if ($i != $current_page) {
                        $pageDisplay = $display * ($i - 1);
                        $url = "admin_view.php?s=".$pageDisplay."&p=".$pages."&sort=".$sort."";
                        echo "
                        <script type=\"text/javascript\">
                            document.write(\"<a href='".$url."'>".$i."</a>\");
                        </script>
                        ";
                    } else {
                        echo "
                        <script type=\"text/javascript\">
                            document.write(".$i.");
                        </script>
                        ";
                    }
            } // End of FOR loop.

            // If it's not the last page, make a Next button:
            if ($current_page != $pages) {
                $StartPDisplay = 1*$start + $display;
                $url = "admin_view.php?s=".$StartPDisplay."&p=".$pages."&sort=".$sort."";
                echo "
                <script type=\"text/javascript\">
                    document.write(\"<a href='".$url."'>Next</a>\");
                </script>
                ";
            }

            echo "
            <script type=\"text/javascript\">
                document.write('</p>'); // Close the paragraph.
            </script>
            ";

        }
        
        $conn->close();
        ?>
        
        <script type="text/javascript">
            function deleteUser(userLoc){
                var conf = confirm("You sure you want to delete this user?");
                
                if(conf == true){
                    location.assign("delete_user.php?user_id='"+userLoc+"'");
                }
            }
        </script>
        
    </body>
</html>