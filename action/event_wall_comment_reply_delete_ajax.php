<?php ob_start();
include_once('../config.php');
$messages_id = mysqli_real_escape_string($con, f($_POST['reply_id'],'escapeAll'));
$responce = mysqli_query($con, "DELETE FROM event_wall_comment_reply WHERE reply_id='$messages_id'") or die(mysqli_error($con));
$responce = mysqli_query($con, "DELETE FROM event_wall_reply_reply WHERE reply_id='$messages_id'") or die(mysqli_error($con));
//$responce = mysqli_query($con, "DELETE FROM event_wall_reply_reply WHERE id='$messages_id'") or die(mysqli_error($con));
echo $responce;
?>