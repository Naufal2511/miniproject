<?php

    if(isset($_POST["lsubbutton"])) {

        $username = $_POST["username"] ;
        $password = $_POST["password"] ;

        require_once 'dbh.inc.php' ;
        require_once 'functions.inc.php' ;

        if(emptyInputLogin($username,$password))    {
            header("location: ../login.php?error=emptyinput") ;
            exit() ;
        }

        userLogin($conn,$username,$password) ;

    }
    else    {
        header("location: ../login.php?error=loginrequired") ;
        exit() ;
    }