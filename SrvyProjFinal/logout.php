<!DOCTYPE html>
<html>
    <body>

        <?php
        setcookie("user_id", "", time() - 3600, "/");
        
        echo "
        <script type=\"text/javascript\">
            window.location.replace('main.php');
        </script>
        ";
        ?>

    </body>
</html>