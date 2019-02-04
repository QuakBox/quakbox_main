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
$messages_id = mysqli_real_escape_string($con, f($_POST['reply_id'],'escapeAll'));
$session_uid = $_SESSION['SESS_MEMBER_ID'];
if(empty($messages_id)){
	exit();
}
$sql1=mysqli_query($con, "select * from comment_reply WHERE reply_id='$messages_id' AND member_id = '$session_uid'");
if(mysqli_num_rows($sql1) == 0){
	exit();
}
while($reply=mysqli_fetch_array($sql1))
{
$responce2 = mysqli_query($con, "DELETE FROM reply_reply1 WHERE msg_id='$reply[id]'") or die(mysqli_error($con));
}
$rsql = mysqli_query($con, "DELETE FROM reply_reply WHERE reply_id='$messages_id'");
mysqli_query($con, "DELETE FROM reply_like WHERE reply_id='$messages_id'");
mysqli_query($con, "DELETE FROM reply_dislike WHERE reply_id='$messages_id'");
$responce = mysqli_query($con, "DELETE FROM comment_reply WHERE reply_id='$messages_id'") or die(mysqli_error($con));
$responce1 = mysqli_query($con, "DELETE FROM comment_reply1 WHERE msg_id='$messages_id'") or die(mysqli_error($con));
}
?>