<?php 
    include_once 'includes/header.inc.php' ;
    echo " 
        <style>
            #register{
                border-bottom: 2px solid yellow ;
            }
        </style>" ;
?>
    <main>
        <h1 id = "loginCaption" class = "caption text-center my-4">Register</h1>
        <form action="includes/signup.inc.php" class = "form" id = "register" method = "POST">
            <input type = "text" class = "inputField" name = "username" placeholder = "Username" id = "rusername" class = "username"><br>
            <input type = "password" class = "inputField" name = "password" placeholder = "Password" id = "rpassword" class = "password" autocomplete="false"><br> 
            <input type = "password" class = "inputField" name = "repeatpassword" placeholder = "Repeat Password ..." id = "repeatpassword" class = "password" autocomplete="false"><br> 
            <input type = "text" class = "inputField" name = "fullname" placeholder = "Full Name" id = "fullname"><br>
            <input type = "email" class = "inputField" name = "email" placeholder = "Email" id = "remail" class = "email"><br>
            <input type = "tel" class = "inputField" name = "phonenumber" placeholder = "Phone Number" id = "phonenumber"><br>
            <input type = "date" class = "inputField" name = "dob" placeholder = "Date Of Birth" id = "dob"><br>
            <input type = "submit" name = "rsubbutton" id = "rsubbutton" value = "Become A Member" class = "submit btn">
        </form>
        <?php
            if(isset($_GET["error"]))   {
                if($_GET["error"] == "emptyinput")  {
                    echo "<p class = 'errorBox text-center'>Fill In All Fields</p>"; 
                }
                else if($_GET["error"] == "invalidusername") {
                    echo "<p class = 'errorBox text-center'>Enter a valid username</p>"; 
                }
                else if($_GET["error"] == "invalidemail") {
                    echo "<p class = 'errorBox text-center'>Enter a valid Email-Id</p>"; 
                }
                else if($_GET["error"] == "passwordnomatch") {
                    echo "<p class = 'errorBox text-center'>Passwords not matching, try again!</p>"; 
                }
                else if($_GET["error"] == "usernametaken") {
                    echo "<p class = 'errorBox text-center'>User Name Already Taken :(</p>"; 
                }
                else if($_GET["error"] == "phoneerror") {
                    echo "<p class = 'errorBox text-center'>Enter a valid phone number</p>"; 
                }
                else if($_GET["error"] == "tooyoung") {
                    echo "<p class = 'errorBox text-center'>You Must Be Above 12 Years</p>"; 
                }
                else if($_GET["error"] == "stmtfailed") {
                    echo "<p class = 'errorBox text-center'>Something went wrong !</p>"; 
                }
                else if($_GET["error"] == "none")   {
                    echo "<p class = 'successBox text-center'>You have sucessfully signed up !</p>" ;
                }
            }
        ?>
    </main>

<?php
    include_once 'includes/footer.inc.php' ;
?>
</html>