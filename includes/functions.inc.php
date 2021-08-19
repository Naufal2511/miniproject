<?php
function emptyInputSignup($username,$fullname,$email,$password,$repeatpassword,$phonenumber,$dob)   {
    $result ;
    //empty() - predefined function used for checking whether there is some data, or there is no data.
    //question: how is this possible, because the variables may point to some junk values ?... maybe since the value = "", it might work.
    if(empty($username) || empty($fullname) || empty($email) || empty($password) || empty($repeatpassword) || empty($phonenumber) || empty($dob))    {
        $result = true ; // yes, there is some empty inputs
    }
    else    {
        $result = false ; //no, there are no empty inputs
    }
    return $result ;
}

function invalidUsername($username)  {
    $result ;
    //preg_match() - a predefined function that is used for checking whether a particular parameter exists in a string.
    if(!preg_match("/^[a-zA-Z0-9]*$/", $username))   {
        $result = true ;
    }
    else{
        $result = false ;
    }
    return $result ;
}

function invalidEmail($email)   {
    $result ;

    //filter_var <- predefined function to check something with a flag to make it check for a valid email
    if(!filter_var($email, FILTER_VALIDATE_EMAIL))  {
        $result = true ;
    }
    else    {
        $result = false ;
    }
    return $result ;
}

function passwordMatch($password, $repeatpassword)  {
    $result ;
    if($password !== $repeatpassword)   {
        $result = true ; 
    }
    else    {
        $result = false ;
    }
    return $result ;
}

function usernameExists($conn, $username, $email)   {
    $sql = "SELECT * FROM userdetails WHERE username = ? OR email = ? ;" ; // ? is a placeholder, it will be a blank, like it will be like a container... Like if we directly pass all the values directly into the Database, there might be stuffs like SQL injection. So first we create containers and fill in the blanks slowly
    $stmt = mysqli_stmt_init($conn) ; //mysqli_stmt_init() is a predefined function that "initialises a new statement "
    if(!mysqli_stmt_prepare($stmt,$sql))    {
        header("location: ../register.php?error=stmterror") ;
        exit() ;
    }
    else    {
        mysqli_stmt_bind_param($stmt,"ss",$username,$email) ; // mysqli_stmt_bind_param now can inject the user values into the placeholders. the "ss" denotes teo strings to be inputted. if one needs to take 3 inputs, then "sss"
        mysqli_stmt_execute($stmt) ; //executes the statement in the database...

        // Now we are grabbing the user from the database. but if we are able to grab the data, then that means the user already exists, but we need to check whether they are not existing in our table before...

        $resultData = mysqli_stmt_get_result($stmt) ; //grabbing the output from the database

        if($row = mysqli_fetch_assoc($resultData)) {
            return $row ; // returing all the data from the database when this is called.
        }
        else{
            $result = false ;
            return $result ; 
        }

        mysqli_stmt_close($stmt) ;
    }
}

function dobnotsatisfy($dob)    {
    $result ;
    $dateofbirth = new DateTime($dob) ;
    $curr_date = new DateTime() ;
    $diff = date_diff($curr_date,$dateofbirth) ; 
    // print_r($diff) ;
    if(((array)$diff)['y'] >= 12) {
        $result = false ;
    }
    else    {
        $result = true ;
    }
    return $result ;
}

function phonenumberNotValid($phonenumber)  {
    $result ;
    if(strlen($phonenumber) >= 8)  {
        if(!preg_match('/^\+*[0-9]*$/',$phonenumber))    {
            $result = true ;
        }
        else    {
            $result = false ;
        }
    }
    else    {
        $result = true ;
    }
    return $result ;
}

function createUser($conn,$username,$password,$fullname,$email,$phonenumber,$dob)    {
    $sql = "INSERT INTO userdetails (username,password,fullname,email,phonenumber,dob) VALUES (?,?,?,?,?,?) ;";
    $stmt = mysqli_stmt_init($conn) ;
    if(!mysqli_stmt_prepare($stmt,$sql))    {
        header("location: ../register.php?error=stmtfailed") ;
        exit() ;
    }
    //hashing the password to make it unreadable
    $hashedPwd = password_hash($password, PASSWORD_DEFAULT) ;
    mysqli_stmt_bind_param($stmt,"ssssss",$username,$hashedPwd,$fullname,$email,$phonenumber,$dob) ;
    // mysqli_stmt_execute($stmt) ;
    if(!mysqli_stmt_execute($stmt)) {
        header("location: ../register.php?error=".mysqli_error($stmt)) ;
    }
    mysqli_stmt_close($stmt) ;
    header("location: ../register.php?error=none") ;
    exit() ;
}


function emptyInputLogin($username,$password)   {
    $result ;   
    if(empty($username) || empty($password))    {
        $result = true ;
    }
    else    {
        $result = false ;
    }
    return $result ;
}

function userLogin ($conn,$username,$password)  {
    $uidExists = usernameExists($conn,$username,$username) ;

    if($uidExists === false)    {
        header("location: ../login.php?error=wronglogin") ;
        exit() ;
    }
    $pwdHashed = $uidExists["password"] ; 
    $checkPwd = password_verify($password,$pwdHashed) ;

    if($checkPwd === false) {
        header("location: ../login.php?error=wronglogin") ;
        exit() ;
    }
    else if($checkPwd === true) {
        session_start() ;
        $_SESSION["uid"] = $uidExists["uid"] ; 
        $_SESSION["username"] = $uidExists["username"] ;
        header("location: ../welcome.php") ;
        exit() ;
    }
}
function findpid($flag,$conn,$project_title,$project_desc,$fileExt,$project_date)  {
    $uid = $_SESSION['uid'] ;
    $pid ;
    if($flag == 1)  {
        // echo "uid : ".$uid." ".$project_desc." ".$project_title."<br>" ;

        // $sql1 = "INSERT INTO projectdetails (uid,project_title, project_desc, project_ext,project_date) VALUES ('$uid','$project_title','$project_desc','$fileExt');" ;
        $sql1 = "INSERT INTO projectdetails (uid,project_title, project_desc, project_ext,project_date) VALUES (?,?,?,?,?);" ;
        $stmt = mysqli_stmt_init($conn) ;
        if(!mysqli_stmt_prepare($stmt,$sql1))    {
            header("location: ../upload.php?error=stmtfailed") ;
            exit() ;
        }
        mysqli_stmt_bind_param($stmt,"sssss",$uid,$project_title,$project_desc,$fileExt,$project_date) ;
        mysqli_stmt_execute($stmt) ;
        mysqli_stmt_close($stmt) ;
        // $sq8 = "SELECT pid FROM projectdetails WHERE uid = '$uid'" ;
        $sql2 = "SELECT pid FROM projectdetails WHERE pid=(SELECT MAX(pid) FROM projectdetails);" ;
        // $sq5 = "SELECT uid, username, email, password FROM userdetails WHERE email = '$email'" ;
        $query1 = mysqli_query($conn, $sql2) ;
        if($query1)  {
            while($row = mysqli_fetch_assoc($query1))    {
                print_r($row) ;
                $pid = $row['pid'] ;
                echo "success" ;
            }
            return $pid ;
        }
        else{
            echo " erors in selecting data" ;
        }
    }
    else{
        echo "critical error, failed to upload" ;
        return -1 ;
    }
}
function getfullname($conn,$uid)  {
    $sql = "SELECT * FROM userdetails WHERE uid = '$uid'" ;
    $query = mysqli_query($conn, $sql) ;
    if($query)   {
        while($row = mysqli_fetch_assoc($query))    {
            return $row ;
        }
    }
    else    {
        return false;
    }
}

function likeregister() {
    $likeFlag = 1 ;
    echo "<script>
        document.getElementById('likeButton').style.color = 'blue' ;
        </script>" ;
}
