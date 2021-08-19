<?php
    include_once 'includes/header.inc.php' ;
    echo " 
        <style>
            #login{
                border-bottom: 2px solid yellow ;
            }
        </style>" ;
?>
    <main>
        <img id = "solidtriangle" src = "images/solidtriangle.png">
        <img id = "solidsquare" src = "images/solidsquare.png">
        <img id = "astronautimg" src = "images/astronaut.png">
        <h1 id = "loginCaption" class = "caption text-center my-4">Login</h1>
        <form action="includes/login.inc.php" class = "form" id = "login" method = "POST">
            <input type = "text" class = "username inputField" name = "username" placeholder = "Username or Email-Id..." id = "lusername" required><br>
            <input type = "password" class = "password inputField" name = "password" placeholder = "Password..." id = "lpassword" value = "" autocomplete="false" required><br>   
            <input type = "submit" class = "submit btn" name = "lsubbutton" id = "lsubbutton" value = "LOGIN ->">
        </form>
        <?php 
        if(isset($_GET['error']))   {
            if($_GET['error'] == 'emptyinput')  {
                echo "<p class = 'errorBox text-center'>Fill All The Fields !</p>" ;
            }
            else if ($_GET['error'] == 'wronglogin')    {
                echo "<p class = 'errorBox text-center'>Wrong Login Credentials, Please try again</p>" ;
            }
            else if ($_GET['error'] == 'loginrequired')    {
                echo "<p class = 'errorBox text-center'>You have to login first</p>" ;
            }
        }
    ?>
    </main>
    <?php
    include_once 'includes/footer.inc.php' ;
    ?>
    </html>