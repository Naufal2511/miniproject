<?php
    if(isset($_SESSION)) {
        session_start() ;
    }
?>
<?php
    include_once 'includes/dbh.inc.php' ;
    include_once 'includes/functions.inc.php' ;
    include_once 'includes/header.inc.php' ;
    echo " 
    <style>
        #welcome{
            border-bottom: 2px solid yellow ;
        }
    </style>" ;
?>
        <!-- <nav>
            <div class="logo">
                <a href = "index.html"><img id = "logoimg" src = "logonew.png"></a>
            </div>
            <ul>
                <li><a class = "underline" href = "welcome.php">HOME</a></li>
                <li><a href = "upload.php">UPLOAD</a></li>
                <li><a href = "messages.html">MESSAGES</a></li>
                <li><a href = "aboutus.html">ABOUT US</a></li>
                
                </ul>
            </div>
        </nav> -->
    <!-- <li id = "myaccountanchor" onmouseover = "displaydets()" ><a href = "#">MY ACCOUNT</a></li>
            </ul>
            <div id = "accountdetails" class="accountdetails" onmouseover = "displaydets()">
                <ul>
                    <li>User Name : <//?php echo $_SESSION['uid']?></li>
                    <li>Full Name :</li>
                    <li>Email Id :</li> -->
    <?php
    if(isset($_SESSION['uid'])) {

        echo "<div class='main'>" ;
    
            // Pid Uid ProjectTitle ProjectImg ProjectDesc ProjectFooter
        $sql = "SELECT * FROM projectdetails ORDER BY pid DESC" ;
    
        $query = mysqli_query($conn,$sql) ;
        if($query)   {
            while($row = mysqli_fetch_assoc($query))    { 
               $userrow = getfullname($conn,$row['uid']) ;
                if($userrow === false) {
                    $fullname = "error loading user's name" ;
                }
                echo "
                    <div class='card py-1'>
                        <div class='projectTitle py-3'>".$row['project_title']."</div>
                        <div class='projectImg'>
                            <img id = 'cardImg' src = 'uploads/".$row['uid']."_".$row['pid'].".".$row['project_ext']."' alt = 'Error loading image from uploads/".$row['uid']."_".$row['pid'].".".$row['project_ext']."' height = '400px' width = '400px'>
                        </div>
                        <div class='projectDesc'>".nl2br(str_replace('  ', ' &nbsp;', htmlspecialchars($row['project_desc'])))."</div>
                        <div class='projectFooter py-3'><div>Posted By : "."<a href = 'message2.php?touser=".$userrow['username']."&flag=1'>".$userrow['fullname']."</a> on ".$row['project_date']."</div><div><span class='fa fa-thumbs-up likeButton' id = 'likeButton' onclick = 'likeregister()'>"."inprogress"."</span></div></div>
                    </div>" ;
                    }
        }
        else    {
            header("location: aboutus.php?error=someerror") ;
        }
    }
    else    {
        header("location: login.php?error=loginrequired") ;
        exit() ;
    }
        ?>
            <h3 class = "text-center">You have reached the end. Good Job</h3>
        <!-- Template
        <div class="card py-1">
            <div class="projectTitle py-3">Project Title</div>
            <div class="projectImg">
                <img src ="logo.png" height = "100px" width = "100px">
            </div>
            <div class="projectDesc py-3">Project Desc</div>
            <div class="projectNav py-3">Project Footer</div>
        </div> -->
   <?php
    include_once 'includes/footer.inc.php' ;
    ?>
<script>
    function likeregister() {
    <?php $likeFlag = 1 ; ?>
    document.getElementById('likeButton').style.color = 'blue' ;
        
    }

    function displaydets(){
        // alert('You have touched me') ;
        document.getElementById('accountdetails').style.display = "block" ;
    }
    function nodisplaydets()    {
        // alert('You have touched me') ;
        document.getElementById('accountdetails').style.display = "none" ;
    }
</script>
</html>