<?php
  if(!isset($_SESSION)) { 
    session_start(); 
  } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href= "css/style.css">
    <link rel="stylesheet" href="css/utils.css">
    <link rel="stylesheet" href="css/mediaqueries.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/fontawesome.min.css" integrity="sha384-wESLQ85D6gbsF459vf1CiZ2+rr+CsxRY0RpiF1tLlQpDnAgg6rwdsUF1+Ics2bni" crossorigin="anonymous">
    <script src="https://use.fontawesome.com/87c7131e35.js"></script>
    <title>Welcome to Forum</title>
</head>
<body>
    <header id = "header">
        <nav id = "headerNav">
            <div class="logo">
                <a href = "index.php"><img id = "logoimg" src = "images/logonew.png"></a>
            </div>
            <ul id = "headerUl">
                <?php
                    if (isset($_SESSION["uid"])) {
                        
                        echo "<li><a id = 'welcome' href = 'welcome.php'>FEED</a></li>
                        <li><a id = 'upload' href = 'upload.php'>UPLOAD</a></li>
                        <li><a id = 'messages' href = 'message2.php'>MESSAGES</a></li>
                        <li><a id = 'aboutus' href = 'aboutus.php'>ABOUT US</a></li>
                        <li><a href = 'includes/logout.inc.php'>LOGOUT</a></li>
                        <li><a href = '#' style = 'text-transform: uppercase;'>".$_SESSION['username']."</a></li>" ;

                    }
                    else    {
                        echo "<li><a id = 'loginHeader' href = 'login.php'>LOGIN</a></li>
                        <li><a id = 'registerHeader' href = 'register.php'>REGISTER</a></li>" ;
                    }
                ?>
               
            </ul>
            <li class = "invisibleButton"><a href = '#' class = 'invisibleButton ' onClick = 'show()' style = 'text-transform: uppercase;'><span class='invisibleButton fa fa-list fa-3x'></span></a></li>
        </nav>
    </header>

    <script>
        var flag = 0 ;
        function show() {
            if(flag == 0)   {
            headerUl = document.getElementById('headerUl') ;
            headerUl.style.display = "flex" ;
            flag = 1 ; 
            header.style.height = "50vh" ;
            // headerNav.style.display = "flex" ;
            }
            else if(flag == 1)   {
                headerUl.style.display = "none" ;
                header.style.height = "12vh" ;
                flag = 0 ;
                // headerNav.style.display = "none" ;
            }
        }
        // header.style.height = "12vh" ;
        // headerUl.style.display = "flex" ;
    </script>