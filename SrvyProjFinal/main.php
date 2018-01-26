<!DOCTYPE html>
<html>
    <head>
        <title>SurveyGorilla - Home</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <script src="Survey.js"></script>
        <script src="functions.js"></script>
    </head>
    
    <body>
        <ul id="topnav">
            <img src="img/logo_white.png" id="navMenu" onclick="navMenu()">
            <li>
                <a href="main.php" class ="active">
                    <img src="img/logo_white.png" id="logo">
                    SurveyGorilla
                </a>
            </li>
            <li><a href="mySurvey.php" id="mySurvey">My Survey</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
        
        <div id="main">
            <div id="pageHeader">
                <h1 id="survey_name">All Survey</h1>
            </div>
            <!--      list of surveys to display      -->
            <div id="surveyList">
            </div>
            
            <div id="bigCont">
                <div id="loginCont">
                    <!--------------------------- login form ----------------------------->
                    <div id="login">
                        <p id="loginTitle" class="active">Login</p>
                        <p id="loginTitle" onclick="displaySignup()">Sign Up</p>
                        <hr>
                        <form action="login.php" method="post" id="loginForm">
                            <input type="text" name="email" placeholder="Email" onfocus="this.placeholder=''" onblur="this.placeholder='Email'"><br>
                            <br><input type="password" name="password" id="password" placeholder="Password" onfocus="this.placeholder=''" onblur="this.placeholder='Password'"><br><br>
                        </form>
                        <a id="loginBtn" onclick="loginCheck()">Login</a>
                    </div>
                    
                    <!--------------------------- signup form ----------------------------->
                    <div id="signup">
                        <p id="loginTitle" onclick="displayLogin()">Login</p>
                        <p id="loginTitle" class="active">Sign Up</p>
                        <hr>
                        <form action="signup.php" method="post" id="signUpForm">
                            <span id="errormsg">
                            </span>
                            <input type="text" name="firstname" id="firstName" placeholder="First Name" onfocus="this.placeholder=''" onblur="this.placeholder='First Name'" required><br>
                            <br><input type="text" name="lastname" id="lastName" placeholder="Last Name" onfocus="this.placeholder=''" onblur="this.placeholder='Last Name'" required><br>
                            <br><input type="text" name="email" id="email" placeholder="Email" onfocus="this.placeholder=''" onblur="this.placeholder='Email'" required><br>
                            <br><input type="password" name="password" id="pass" placeholder="Password" onfocus="this.placeholder=''" onblur="this.placeholder='Password'" required><br>
                            <br><input type="password" name="password" placeholder="Repeat Password" onfocus="this.placeholder=''" onblur="this.placeholder='Repeat Password'"  onclick="regExpreCheck()" id="rePass" required><br><br>
                        </form>
                        <a id="signUpBtn" onclick="signupCheck()">Sign Up</a>
                    </div>
                    
                </div>
            </div>
            
        </div>
        
        <!-------------- checking if the user already loged in -------------->
        <?php
            if(!isset($_COOKIE["user_id"])) {
                echo '
                <script type="text/javascript">
                    document.getElementById("bigCont").style.display="block";
                    document.getElementById("navMenu").style.display="none";
                </script>
                ';
            }
        ?>
        
        
        <!---------------------------  Javascript  --------------------------->
        <script type="text/javascript">
            /*********************** display and hide login contents ***********************/
            function displayLoginopt(){
                document.getElementById("login").style.display = "none";
                document.getElementById("signup").style.display = "none";
            }
            
            function displayLogin(){
                document.getElementById("login").style.display = "block";
                document.getElementById("signup").style.display = "none";
            }
            
            function displaySignup(){
                document.getElementById("login").style.display = "none";
                document.getElementById("signup").style.display = "block";
            }
            
            /***************************** login/signup check ***********************************/
            function loginCheck(){
                var RECheck = regExpreCheck("password");
                
                if(RECheck == true){
                    document.getElementById("loginForm").submit();
                }
            }
            
            function adminLoginCheck(){
                var RECheck = regExpreCheck("adminPassword");
                
                if(RECheck == true){
                    document.getElementById("adminLoginForm").submit();
                }
            }
            
            function signupCheck(){
                var RECheck = regExpreCheck("pass");
                var samePass = matchPass();
                
                if(RECheck==true && samePass==true){
                    document.getElementById("signUpForm").submit();
                }
            }
            
            function regExpreCheck(testLoc){
                var pass = document.getElementById(testLoc).value;

                var check = /((?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,})/.test(pass);

                if(!check){
                    alert("The password must be:\n- 6 digit long\n- 1 uppercase letter\n- 1 lowercase letter\n- 1 number");
                    
                    return false;
                }else{
                    return true;
                }
            }
            
            function matchPass(){
                if(document.getElementById("pass").value != document.getElementById("rePass").value){
                    alert("The password you entered does not match");
                    return false;
                }else{
                    return true;
                }
            }
        </script>
        
        <!---------------------------  PHP  --------------------------->
        <?php
        include '../../connect_to_server.php';
        
        $sql = "SELECT `survey_id`, `title`, `description` FROM `yyang316868_48947`.`survey_entity` AS `survey_entity`";
        $result = $conn->query($sql);
        
        // check for email and password
        if ($result->num_rows > 0) {
            // output data of each row
            echo '<script type="text/javascript">';
            while($row = $result->fetch_assoc()) {
                $hrefLnk = 'takeSurvey.php?survey_id='.$row["survey_id"].'';
                
                echo '
                document.getElementById("surveyList").innerHTML += "<div class=\'surveyListCont\'><div class=\'surveyListTitle\'>'.$row["title"].'</div><a class=\'surveyListBtn\' href=\''.$hrefLnk.'\'></a><div class=\'surveyListDescription\'>'.$row["description"].'</div></div>";
                ';
            }
            echo '</script>';
        } else {
            echo "0 results";
        }

        $conn->close();
        ?>
    </body>
</html>