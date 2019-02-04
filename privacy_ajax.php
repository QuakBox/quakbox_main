<?php 

	session_start();
	require_once('config.php');
$msg_id12 =$_POST['msg_id'];
//$msg_id121 =$_POST['msg_id1'];
$name = $_POST['name'];
$pr="update message set wall_privacy=$name where messages_id=$msg_id12";
mysqli_query($con, $pr);
//echo $msg_id12."\n".$name//"\n".$msg_id121;
$pri1=mysqli_query($con, "select wall_privacy from message where messages_id=$msg_id12");
 $pri=mysqli_fetch_array($pri1);
echo $pri['wall_privacy']; 
?>