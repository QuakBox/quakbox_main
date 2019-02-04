<?php 
ob_start();
session_start();	
include_once('../config.php');
	
$add_member_id = $_SESSION['SESS_MEMBER_ID'];
$event_id = $_REQUEST['event_id'];
$event_id	 = 	f($event_id, 'strip');
$event_id	 = 	f($event_id, 'escapeAll');
$event_id   = mysqli_real_escape_string($con, $event_id);
	
$sql="update event_members set status = 1 where event_id = '$event_id' and member_id = '$add_member_id'";
$responce = mysqli_query($con, $sql);

//header("location: ".$base_url."/event_view.php?id=".$event_id."");
//exit();
?> 
