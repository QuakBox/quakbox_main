<?php 
ob_start();
session_start();	
include_once('../config.php');
	
$add_member_id = $_SESSION['SESS_MEMBER_ID'];
$event_id = mysqli_real_escape_string($con, f($_REQUEST['id'],'escapeAll'));
if(empty($event_id)){
	exit();
}
$emsql = mysqli_query($con, "SELECT status FROM event_members WHERE event_id = '$event_id' and member_id = 
'$add_member_id'");
if(mysqli_num_rows($emsql) == 0){
	exit();
}
$emcount = mysqli_num_rows($emsql);
	
$sql="DELETE FROM event_members where event_id = '$event_id' and member_id = '$add_member_id'";
$responce = mysqli_query($con, $sql);

header("location: ".$base_url."event_view.php?id=".$event_id."");
exit();
?> 
