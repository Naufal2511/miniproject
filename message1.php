<?php
session_start();

$curr_user =  $_SESSION["username"];
include_once 'includes/dbh.inc.php' ;
include_once 'includes/functions.inc.php' ;
error_reporting(0);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/style1.css">
<link rel="stylesheet" href="css/utils.css">
<title>Messages</title>

<script>
		/*function myfunction(){
			alert('HI');
			var x = document.getElementById('user1').innerHTML;
			alert(x);
            document.getElementById('username').innerHTML = x;	  
		}*/
		function radioOnclick(my){
			var arr = my.value.split("~");
			//alert(arr);
			document.getElementById("User").value = arr[1];
			//document.myform.User.readOnly = true;           		
			document.myform.submit();			
		}			
</script>
<?php //echo "<script>document.writeln(y);</script>";?>


</head>

<body class = "ihsanbody">
	<header>
	<nav>
	<div class="logo">
	<a href = "index.html"><img id = "logoimg" src = "images/logonew.png" width= "80px" height = "80px"></a>
	</div>
	<ul>
	<li><a href = "welcome.php">GO BACK</a></li>
	<li><a href = "aboutus.html">ABOUT US</a></li>
	</ul>
	</nav>
	</header>

    <div class="divmainclass">
        
		<div class="divsubclass">
              <h2>INBOX</h2>
        </div>
		
        <div class="divsubclass1">
				<?php
				$conn = mysqli_connect($server,$user,$pass,$db) ; 
                  if(!$conn)  {
                  echo "error"." ".mysqli_error($conn) ;
                   }
	              else{		
		          $sql = "SELECT * FROM userdetails WHERE username NOT IN  ('$curr_user')";
		         $result = mysqli_query($conn, $sql)  ; 
		          echo "<table class='mytable' border='3px' >";
	              echo "<caption>Chat</caption><br>";
	              echo "<tr><th style='width:50px;'>Select</th><th> User</th></tr>";
                 if($result)   {
                 while($row = mysqli_fetch_assoc($result))    {
                  $rec_uname = $row['username'];
                  echo "<tr><td><input type='radio' onclick = 'radioOnclick(this)' value ='".$row['uid']."~".$row['username']."'></td><td id='user1' value='".$row['username']."'>".$row['username']."</td></tr>";
			      } } }
                   echo "</table>";	              						   
			   ?>		   
        </div>
			
        <div class="divsubclass2">

		    <div class="divsubclass3">
                 	<form action="<?php $_PHP_SELF ?>" method="POST" name="myform" target="_SELF">
				   <input type="text" id="User" name="User"style="text-align:center;color:darkblue;background-color:transparent;margin:10px;width:100px;height:25px;font-size:20px;" readOnly>
				   <!--<button type="Submit" id="btn" name="btn">Select User</button>-->
			</div>
			
			<div class="divsubclass4">
				    <?php
			        if($_REQUEST["User"]){
						$user = $_REQUEST["User"];
						//echo $user;
						//$_SESSION['selected_user'] = $user;
					
						$sql2 = "SELECT * FROM messages WHERE touser='$curr_user' AND fromuser='$user' OR touser='$user' AND fromuser='$curr_user' ORDER BY time ASC";
						$result2 = mysqli_query($conn,$sql2);
						if($result2)	{
							$row_count = mysqli_num_rows($result2);
							if($row_count == 0)	{
								echo "<h3>NO MESSAGES</h3>";
							}
							while($row2 = mysqli_fetch_array($result2))	{
								$time = $row2['time'];
								$message = $row2['message'];
								$from_user1 = $row2['fromuser'];
								$to_user = $row2['touser'];
								if($from_user1 == $curr_user){
									echo "<br><p style='text-align:right;'>".$time." ".$from_user1."<br>";
									echo $message."<br><br></p>"; 
								}
								else	{				 
									echo "<p style='text-align:left;'>".$time." ".$from_user1."<br>";
									echo $message."<br><br></p>";
								}   
							}
						}
                    }				
				     //$selected_user = $_SESSION["selected_user"];
				     $selected_user = $_REQUEST["User"];
                     echo "<script>document.getElementById('User').value = '$selected_user';</script>";
				     //$_SESSION["selected_user"] = NULL;
					 
                     if($_REQUEST['message'] && $_REQUEST['User']){
				     $msg = $_REQUEST['message'] ;
			         }
			         if($msg){
                     $sql3 = "INSERT INTO messages (fromuser,touser,message) VALUES ('$curr_user','$user','$msg')";	
                     $result3 = mysqli_query($conn,$sql3);
                     if($result3){
                     echo "<script>
					 alert('Message Sent Successfully');
					 document.myform.submit();
				     </script>";
                     }
					 else {
                     echo "<script>alert('Error Sending Message');</script>";
			         }
			         }
					 
					 
			        ?>
			</div>
			
		</div>
			
		<div class="divsubclass5">
                 <b>Reply</b>			  			 
			     <br><br>
			     <textarea  rows="3" cols="50" id="msg" name="message" placeholder="Type Your Message Here"></textarea>
	             <button type="submit" class="button"><span>SEND MESSAGE</span></button>
		</div>	
			 
        <div class="divsubclass6">
                 <center>
                    <b id="dt">This is the Websiste Footer</b>
                 </center>
        </div>
		
    </div>
<?php include_once 'includes/footer.inc.php' ;
		mysqli_close($conn); ?>
<script>
const d = new Date();
document.getElementById('dt').innerHTML = d ;
</script>
</form>
</body>
</html>