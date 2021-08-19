<?php

    $server = "localhost" ;
    $user = "root" ;
    $pass = "" ;
    $db = "forum1" ;

    $conn = mysqli_connect($server,$user,$pass,$db) ;

    if(!$conn)  {
        die("Connection Failed".mysqli_connect_error()) ;
    }