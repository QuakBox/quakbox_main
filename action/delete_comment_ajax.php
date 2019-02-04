<?php ob_start();
//error_reporting(0);
session_start();
if(!isset($_SESSION['SESS_MEMBER_ID']))
	{
echo "1";	
	}
	else
	{


include_once('../config.php');
$messages_id = mysqli_real_escape_string($con, f($_POST['com_id'],'escapeAll'));
if(empty($messages_id)){
	exit();
}
$sql1 = mysqli_query($con, "SELECT * FROM postcomment WHERE comment_id='$messages_id'") or die(mysqli_error($con));

 
if(mysqli_num_rows($sql1) == 0){
	exit();
}
$sql=mysqli_query($con, "select * from comment_reply WHERE comment_id='$messages_id'");
while($reply=mysqli_fetch_array($sql))
{
$sql1=mysqli_query($con, "select * from reply_reply WHERE reply_id='$reply[reply_id]'");
while($reply1=mysqli_fetch_array($sql1))
{
$responce5 = mysqli_query($con, "DELETE FROM reply_reply WHERE id='$reply1[id]'") or die(mysqli_error($con));
$responce2 = mysqli_query($con, "DELETE FROM reply_reply1 WHERE msg_id='$reply1[id]'") or die(mysqli_error($con));
}

$responce3= mysqli_query($con, "DELETE FROM comment_reply WHERE reply_id='$reply[reply_id]'") or die(mysqli_error($con));
$responce4 = mysqli_query($con, "DELETE FROM comment_reply1 WHERE msg_id='$reply[reply_id]'") or die(mysqli_error($con));
}


$responce = mysqli_query($con, "DELETE FROM postcomment WHERE comment_id='$messages_id'") or die(mysqli_error($con));
$responce1 = mysqli_query($con, "DELETE FROM postcomment1 WHERE msg_id='$messages_id'") or die(mysqli_error($con));
}
?>