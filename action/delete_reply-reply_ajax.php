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
$session_uid = $_SESSION['SESS_MEMBER_ID'];
$messages_id = mysqli_real_escape_string($con, f($_POST['reply_id'],'escapeAll'));
if(empty($messages_id)){
	exit();
}
$sql1=mysqli_query($con, "select * from reply_reply WHERE reply_id='$messages_id' AND member_id = '$session_uid'");
if(mysqli_num_rows($sql1) == 0){
	exit();
}
$responce = mysqli_query($con, "DELETE FROM reply_reply WHERE id='$messages_id'") or die(mysqli_error($con));
$responce1 = mysqli_query($con, "DELETE FROM reply_reply1 WHERE msg_id='$messages_id'") or die(mysqli_error($con));
}
?>