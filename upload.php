<?php 
    session_start() ;
    if(isset($_SESSION['uid'])) {
        include_once 'includes/dbh.inc.php' ;
        include_once 'includes/header.inc.php' ;
        echo " 
        <style>
            #upload{
                border-bottom: 2px solid yellow ;
            }
        </style>" ;
        echo "<div class='main'>
            <h1 class = 'caption text-center'>Upload</h1>
            <form id = 'uploadForm' class = 'form' name = 'uploadForm' method = 'POST' action = 'uploaddb.php' enctype = 'multipart/form-data'>
                <input type= 'text' name= 'project_title' placeholder = 'What is your project' class = 'inputField' id='project_title' required>
                <textarea cols = '40' rows = '20' name='project_desc' placeholder = 'What is your project about' class = 'inputField' id='project_desc' required></textarea>
                <input type = 'file' name='project_img' class = 'inputField' id='project_img' required>
                <input type = 'submit' name = 'usubbutton' id = 'usubbutton' value = 'Submit' class = 'submit btn'>
            </form>" ; 
            if(isset($_GET['error']))   {
                if($_GET['error'] == 'toobig')  {
                echo "<p class = 'text-center'>Your File Size Is Too Large, Please Try Again</p>" ;
                }
                else if ($_GET['error'] == 'wrongfiletype')    {
                    echo "<p class = 'text-center'>Wrong file type,Allowed Types : jpg/jpeg/png/gif/tiff</p>" ;
                }
            }
            echo "</div>" ;
    }
    else    {
        header("location: login.php?error=loginrequired") ;
    }

?>
<?php
    include_once 'includes/footer.inc.php' ;
?>
</html>