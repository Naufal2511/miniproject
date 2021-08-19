<?php
// to check whether user came to this place by clicking the submit button in the register page, or else it will redirect to register page
    if (isset($_POST["rsubbutton"])) {
        echo "It works" ;
        $username = $_POST["username"] ;
        $fullname = $_POST["fullname"] ;
        $email = $_POST["email"] ;
        $password = $_POST["password"] ;
        $repeatpassword = $_POST["repeatpassword"] ;
        $phonenumber = $_POST["phonenumber"] ;
        $dob = $_POST["dob"] ;

        //database processing
        require_once 'dbh.inc.php' ;
        //error handlers ٧
        require_once 'functions.inc.php' ;

        //note: All functions in functions.inc.php will return only true or false

        //to make sure no inputs are empty
        if(emptyInputSignup($username,$fullname,$email,$password,$repeatpassword,$phonenumber,$dob) !== false)    {
            header("location: ../register.php?error=emptyinput") ; 
            exit() ; //stops the script from running completely
        }

        //to check if username is valid
        if(invalidUsername($username) !== false)    {
            header("location: ../register.php?error=invalidusername") ; 
            exit() ; //stops the script from running completely
        }

        //to check whether password and repeat password is matching
        if(passwordMatch($password,$repeatpassword) !== false)    {
            header("location: ../register.php?error=passwordnomatch") ; 
            exit() ; //stops the script from running completely
        }
        if(phonenumberNotValid($phonenumber) !== false) {
            header("Location: ../register.php?error=phoneerror") ;
            exit() ;
        }
        
        if(dobnotsatisfy($dob) !== false) {
            header("location: ../register.php?error=tooyoung") ;
            exit() ;     
        }
                
        //to check if username already taken or not
        if(usernameExists($conn,$username,$email) !== false)    {
            header("location: ../register.php?error=usernametaken") ; 
            exit() ; //stops the script from running completely
        }
        // if the code reaches here, the user has not made any mistakes that we are checking for.
        //signing up the user

        createUser($conn,$username,$password,$fullname,$email,$phonenumber,$dob) ;
    }
    else{
        header("location: ../register.php") ;
        exit() ;
    }