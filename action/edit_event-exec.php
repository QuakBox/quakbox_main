<?php ob_start();
session_start();
include('../config.php');

$session_uid = $_SESSION['SESS_MEMBER_ID'];
$event_id = mysqli_real_escape_string($con, f($_POST['event_id'],'escapeAll'));
$event_name = mysqli_real_escape_string($con, f($_POST['event_input'],'escapeAll'));
$event_description = mysqli_real_escape_string($con, f($_POST['event_description'],'escapeAll'));
$event_date = date('Y-m-d',strtotime($_POST['event_date']));
$event_location = mysqli_real_escape_string($con, f($_POST['where_event'],'escapeAll'));


$time = time();
$ip=$_SERVER['REMOTE_ADDR'];


$sql = "update event set event_name = '$event_name', event_description = '$event_description',datepicker = '$event_date', event_location = '$event_location' where id = '$event_id' AND event_host = '$session_uid'";

mysqli_query($con, $sql) or die(mysqli_error($con));



header("location: ".$base_url."event_view.php?id=".$event_id."");
exit();
?> 