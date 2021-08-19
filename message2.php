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
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/utils.css">
<link rel="stylesheet" href="css/style2ihsan.css">

<title>Messages</title>
        <style>
            #messages{
                border-bottom: 2px solid yellow ;
            }
        </style>
<script>

		function radioOnclick(my){
			var arr = my.value.split("~");
			document.getElementById("user_id").value = arr[0];
			document.getElementById("User").value = arr[1];		
			document.myform.submit();
		}			
</script>

</head>

<body class = "ihsanbody">
	<header>
	<nav>
	<div class="logo">
	<a href = "welcome.php"><img id = "logoimg" src = "images/logonew.png" width= "80px" height = "80px"></a>
	</div>
	<ul>
	<li><a href = "welcome.php">GO BACK</a></li>
	<li><a href = "aboutus.php">ABOUT US</a></li>
	</ul>
	</nav>
	</header>

    <div class="divmainclass">
        
		<div class="divsubclass">
              <h2>INBOX</h2>
        </div>
		<div class = "gridmainclass">
			<div class="divsubclass1">
					<?php
					$conn = mysqli_connect($server,$user,$pass,$db) ; 
					if(!$conn)  {
					echo "error"." ".mysqli_error($conn) ;
					}
					else
					{		
					$sql = "SELECT * FROM userdetails WHERE username NOT IN  ('$curr_user')";
					// $sql1 = "SELECT * FROM messages WHERE fromuser = $curr_user ; " ;
					$result = mysqli_query($conn, $sql)  ; 
					// $res1 = mysqli_query($conn,$sql1) ;
					echo "<table class='mytable' border='3px' >";
					echo "<caption>Chat</caption><br>";
					echo "<tr><th> User</th></tr>";
					
						if($result)  					 
					{
						while($row = mysqli_fetch_assoc($result))    {
						$rec_uname = $row['username'];
						$uid = $row['uid'];
						echo "<tr id='$uid' onclick='rowOnclick($uid)'><input type='radio' class='hdn' id='$rec_uname' name='$rec_uname' onclick = 'radioOnclick(this)' value ='".$row['uid']."~".$row['username']."'/><td><label for='$rec_uname' id='$rec_uname'>".$row['username']."</label></td></tr>";
						
					} 
					
					} 
					}				  
					echo "</table>";	    
					
					// echo "<div class = 'dividerBar'>OTHER USERS</div>
						  
					// 	<div class = 'contactsTable'>
					// 	<table class='myContactstable' border='3px' >
					// 	<tr><th> User</th></tr>
					// " ;
					// if($res1)	{
					// 	while($row = mysqli_fetch_assoc($res1))	{
					// 		$otherUsers = $row['touser'] ; 
							
					// 	}
					// }

				?>		

			</div>
				
			<div class="divsubclass2">

				<div class="divsubclass3">
						<form action="<?php $_PHP_SELF ?>" method="POST" name="myform" target="_SELF">
					<input type="text" id="User" name="User" class="input1" readOnly>
					<input type="hidden" id="user_id"  name="user_id" readOnly>
					<button type="Submit" id="btn" name="btn" class="hdn">Select User</button>
				</div>
				
				<div class="divsubclass4">
						<?php
						if($_REQUEST["User"]){
							$user = $_REQUEST["User"];
						
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
										echo "<p style= ' background-image: linear-gradient(to right, #4facfe 0%, #00f2fe 100%); text-align:right; color: #8e4141; text-transform : capitalize ; padding : 2px 12px ; border-radius: 7px ; margin: 5px auto; margin-top: 2px ;'><br>".$from_user1."<br>".$time."<br>";
										echo $message."<br><br></p>"; 
									}
									else	{				 
										echo "<p style=' background-image: linear-gradient(60deg, #29323c 0%, #485563 100%); text-align:left; color: white ; font-weight: bold ; text-transform : capitalize ; padding : 2px 12px ; border-radius: 7px ; margin: 5px auto;'><br>".$from_user1."<br>".$time."<br>";
										echo $message."<br><br></p>";
									}   
								}
							}
						}								     
						$selected_user = $_REQUEST["User"];
						$user_id = $_REQUEST["user_id"];
						echo "<script>
							document.getElementById('User').value = '$selected_user';
							document.getElementById('user_id').value = '$user_id';
							document.getElementById($user_id).style.backgroundColor = 'yellow';
							document.getElementById('$selected_user').checked = true;		
						</script>";			
						
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
					<textarea  rows="3" cols="100" id="msg" name="message" placeholder="Type Your Message Here"></textarea>
					<button type="submit" class="button"><span>SEND MESSAGE</span></button>
			</div>	
		</div>	 
        <div class="divsubclass6">
                 <center>
                    <b id="dt">This is the Websiste Footer</b>
                 </center>
        </div>
		
    </div>
<?php
// $flag = $_GET['flag'] ;
if(isset($_GET['touser'])){
	$flag = $_GET['flag'] ;
	$touser = $_GET['touser'];

	echo "<script>
	document.getElementById('User').value = '$touser';
	</script>
	" ; 
	if($flag == 1)	{
		echo "<script>document.getElementById('btn').click() ;
			alert('FLAG = ".$flag."') ;
			</script> " ;
		header("Location: message2.php?touser=".$touser."&flag=0") ;
	}

	

}
include_once 'call_function.php';
include_once 'includes/footer.inc.php' ;
		mysqli_close($conn); ?>
<script>
const d = new Date();
document.getElementById('dt').innerHTML = d ;
</script>
</form>
</body>
</html>