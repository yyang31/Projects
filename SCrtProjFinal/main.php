<!DOCTYPE html>
<html>
    <head>
        <title>Storefront</title>
        <link rel="stylesheet" href="style.css">
        <script src="Item.js"></script>
    </head>
    
    <body>
        <div id="topnav">
            <div id="logo"><span style="font-size:20px;">not</span>Game<span style="color:rgb(251,13,27);">Stop</span></div>
            <img src="img/other/Hamburger_icon.png" id="menuBtn" onclick="sideBar()">
        </div>
        
        <!--    item popup    -->
        <div id="itemPopupBigCont">
            <div id="itemPopupCont">
                <div id="itemPopupName">
                    <div id="popupclose" onclick="hidePopup()">X</div>
                </div>
                <div id="itemPopupImgCont">
                </div>
                <div id="itemPopupPrice">
                    <div id="itemQuantity">
                    </div>
                </div>
                <div id="itemPopupDescriptionTitle">About the game:</div>
                <div id="itemPopupDescription">
                </div>
                <a id="itemPopupAdd">Add to Cart</a>
            </div>
        </div>
        
        <div id="main">
            
            <!---------------------------------- Home ---------------------------------------->
            <div id="home">
                
            </div>
            
            <!--------------------------------- logedin -------------------------------------->
            <div id="logedin">
                <div id="welcomeMsg"></div>
                <div id="logoutBtn" onclick="logout()">logout </div>
            </div>
            
            <!------------------------------ login/ signup ------------------------------------>        
            <div id="login">
                <div id="loginSignupBtn">
                    <a id="loginMenu" class="active" onclick="displayLogin()">Login</a>
                    <a id="signupMenu" onclick="displaySignup()">Sign Up</a>
                </div>
                
                <!-- login -->
                <div id="loginContent">
                    <h1>Login</h1>
                    <div id="loginFormCont">
                        <form action="login.php" id="loginForm" method="post">
                            <span id="loginErrormsg" class="errormsg">
                            </span>
                            <input type="text" placeholder="Email" name="email" id="emailAddress"><br>
                            <br><input type="password" placeholder="Password" name="password" id="password"><br><br>
                        </form>
                        <a id="loginBtn" onclick="loginCheck()">Login</a>
                    </div>
                </div>
                
                <!-- signup -->
                <div id="signUpContent">
                    <h1>Sign Up</h1>
                    <div id="signUpFormCont">
                        <form action="signup.php" method="post" id="signUpForm">
                            <span id="signupErrormsg" class="errormsg">
                            </span>
                            <input type="text" name="firstname" placeholder="First Name" id="firstName" required><br>
                            <br><input type="text" name="lastname" placeholder="Last Name" id="lastName" required><br>
                            <br><input type="text" name="email" placeholder="Email" id="email" required><br>
                            <br><input type="password" name="password" placeholder="Password" id="pass" required><br>
                            <br><input type="password" name="password" placeholder="Repeat Password" onclick="regExpreCheck('signupErrormsg', 'pass')" id="rePass" required><br><br>
                        </form>
                        <a id="signUpBtn" onclick="signupCheck()">Sign Up</a>
                    </div>
                </div>
            </div>
            
            <!---------------------------------- Cart ---------------------------------------->
            <div id="cart">
                <div id="cartTitle">Shopping Cart</div>
                <div id="cartCont"></div>
                <div id="cartTotal"></div>
                <a id="checkOut" href="checkOut.php">Check Out</a>
            </div>
            
        </div>
        
        <!---------------------------------- Java Script ---------------------------------------->
        <script>
            /********************************* Navbar ****************************************/
            function sideBar(){
                var target = "login";
                
                if(document.getElementById("logedin").classList.contains("active")){
                    document.getElementById("cart").style.display = "block";
                    target = "logedin";
                }
                
                if(document.getElementById(target).classList.contains("hidden")){
                    document.getElementById(target).classList.remove("hidden");
                    document.getElementById(target).style.display = "block";
                    document.getElementById("home").style.width = "70%";
                    
                    var divs = document.getElementsByClassName('itemCont');
                    for(var i = 0; i < divs.length; i++) {
                        divs[i].style.width= "29%";  
                    }
                    
                    document.getElementById("menuBtn").src="img/other/Hamburger_icon.png";
                }else{
                    document.getElementById(target).classList.add("hidden");
                    document.getElementById(target).style.display = "none";
                    document.getElementById("cart").style.display = "none";
                    document.getElementById("home").style.width = "98%";
                    
                    var divs = document.getElementsByClassName('itemCont');
                    for(var i = 0; i < divs.length; i++) {
                        divs[i].style.width= "21%";  
                    }
                    
                    document.getElementById("menuBtn").src="img/other/Hamburger_icon_2.png";
                }
            }
            
            /*********************************** Home ****************************************/
            function showPopup(item_id, name, price, description, quantity, img_loc){
                document.getElementById("itemPopupBigCont").style.display = "block";
                document.getElementById("itemPopupName").innerHTML = name + '<div id="popupclose" onclick="hidePopup()">X</div>';
                document.getElementById("itemPopupImgCont").innerHTML = '<img src="'+img_loc+'" id="itemImg">';
                document.getElementById("itemPopupPrice").innerHTML = price + '<div id="itemQuantity"></div>';
                document.getElementById("itemPopupDescription").innerHTML = description;
                
                if(quantity == "0"){
                    document.getElementById("itemQuantity").innerHTML = "Out of stock";
                    document.getElementById("itemPopupAdd").classList.add("outOfStock");
                }else{
                    document.getElementById("itemPopupAdd").classList.remove("outOfStock");
                    document.getElementById("itemQuantity").innerHTML = quantity + " left in stock";
                    document.getElementById("itemPopupAdd").href= "addCartItem.php?item_id="+item_id;
                }
                
                document.body.style.overflow = "hidden";
            }
            
            function hidePopup(){
                document.getElementById("itemPopupBigCont").style.display = "none";
                document.body.style.overflow = "scroll";
            }
            
            // When the user clicks anywhere outside of the itemPopup, close it
            window.onclick = function(event) {
                if (event.target == itemPopupBigCont) {
                    itemPopupBigCont.style.display = "none";
                    document.body.style.overflow = "scroll";
                }
            }
            
            /******************************* Login and Signup ********************************/
            function displayLogin(){
                document.getElementById("loginContent").style.display = "block";
                document.getElementById("loginMenu").classList.add("active");
                
                document.getElementById("signUpContent").style.display = "none";
                document.getElementById("signupMenu").classList.remove("active");
            }
            
            function displaySignup(){
                document.getElementById("loginContent").style.display = "none";
                document.getElementById("loginMenu").classList.remove("active");
                
                document.getElementById("signUpContent").style.display = "block";
                document.getElementById("signupMenu").classList.add("active");
            }
            
            /********************************** Other function *******************************/
            function loginCheck(){
                var RECheck = regExpreCheck("loginErrormsg", "password");
                
                if(RECheck==true){
                    document.getElementById("loginForm").submit();
                }
            }
            
            function adminLoginCheck(){
                var RECheck = regExpreCheck("adminLoginErrormsg", "adminPassword");
                
                if(RECheck==true){
                    document.getElementById("adminLoginForm").submit();
                }
            }
            
            function signupCheck(){
                var RECheck = regExpreCheck("signupErrormsg", "pass");
                var samePass = matchPass();
                
                // sumbit the form if above three conditions are ALL true
                if(RECheck==true && samePass==true){
                    document.getElementById("signUpForm").submit();
                }
            }
            
            // check for regular expression in the password section
            function regExpreCheck(msgLoc, passLoc){
                var pass = document.getElementById(passLoc).value;

                var check = /((?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,})/.test(pass);

                if(!check){
                    errorMsg(msgLoc, "The password you entered does not meet the following requirements:<br>- <b>6</b> digit long<br>- <b>1</b> uppercase letter<br>- <b>1</b> lowercase letter<br>- <b>1</b> number");
                    return false;
                }else{
                    document.getElementById(msgLoc).style.display = "none";
                    
                    return true;
                }
            }
            
            // check for matching password
            function matchPass(){
                if(document.getElementById("pass").value != document.getElementById("rePass").value){
                    errorMsg("signupErrormsg", "The password you entered does not match.");
                    return false;
                }else{
                    return true;
                }
            }
            
            function errorMsg(loc, msg){
                document.getElementById(loc).style.display = "block";
                document.getElementById(loc).innerHTML = msg;
            }
            
            function logout() {
                var conf = confirm("Are you sure you want to log out?");
                if(conf){
                    document.cookie = "user_id=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=../../;";
                    document.cookie = "user_first=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=../../;";
                    document.cookie = "user_last=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=../../;";
                    document.cookie = "user_email=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=../../;";
                    document.cookie = "user_cart=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=../../;";
                    location.replace("main.php");
                }
            }
        </script>
        
        <!-------------------------------------- PHP -------------------------------------------->
        <?php
        include '../../connect_to_server.php';
        
        $cart;
        
        /****************************** user *******************************/
        if(isset($_COOKIE["user_first"])) {
            echo '
            <script type="text/javascript">
                document.getElementById("logedin").style.display = "block";
                document.getElementById("logedin").classList.add("active");
                document.getElementById("login").style.display = "none";
                document.getElementById("cart").style.display = "block";
                document.getElementById("welcomeMsg").innerHTML="Welcome back, '.$_COOKIE["user_first"].'!";
            </script>
            ';
            
            $cart = json_decode($_COOKIE["user_cart"]);
        }
        
        /****************************** item *******************************/
        // sql for getting item_entity
        $sql = "SELECT `item_entity`.`item_id`, `item_entity`.`name`, `item_entity`.`price`, `item_entity`.`quantity`, `console_enum`.`console_name`, `item_entity`.`img_loc`, `item_entity`.`description` FROM `yyang316868_48947`.`console_enum` AS `console_enum`, `yyang316868_48947`.`item_entity` AS `item_entity` WHERE `console_enum`.`console_id` = `item_entity`.`console`";
        $result = $conn->query($sql);
        
        $cartTotal = 0;
        
        // create and display all items
        if ($result->num_rows > 0) {
            // output data of each row
            echo '
            <script type="text/javascript">
            var newItem;
            ';
            while($row = $result->fetch_assoc()) {
                // display the item
                echo '
                    newItem = new Item("'.$row["item_id"].'","'.$row["name"].'","'.$row["price"].'","'.$row["description"].'","'.$row["quantity"].'","'.$row["console_name"].'","'.$row["img_loc"].'");
                    newItem.display("home");
                ';
                
                if(isset($_COOKIE["user_cart"])) {
                    // check if this item is in the shopping cart
                    for($i = 0; $i < count($cart); $i++){
                        if($cart[$i] == $row["item_id"]){
                            // display the cart item
                            echo 'newItem.displayCart("cartCont");';
                            
                            // set the total
                            $cartTotal += $row["price"];
                            echo 'document.getElementById("cartTotal").innerHTML = "Total = $'.$cartTotal.'";';
                        }
                    }
                }
            }
            echo '</script>';
        } else {
            echo "0 results";
        }
        
        $conn->close();
        
        ?>
    </body>
</html>