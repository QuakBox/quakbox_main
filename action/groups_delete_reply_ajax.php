<?php
include_once('../config.php');
$messages_id = $_POST['reply_id'];
$messages_id	 = 	f($messages_id, 'strip');
$messages_id	 = 	f($messages_id, 'escapeAll');
$messages_id   = mysqli_real_escape_string($con, $messages_id);

$rsql = mysqli_query($con, "DELETE FROM groups_wall_reply_reply WHERE reply_id='$messages_id'");
mysqli_query($con, "DELETE FROM groups_wall_reply_like WHERE reply_id='$messages_id'");
mysqli_query($con, "DELETE FROM groups_wall_reply_dislike WHERE reply_id='$messages_id'");
$responce = mysqli_query($con, "DELETE FROM groups_wall_reply WHERE reply_id='$messages_id'") or die(mysqli_error($con));


?>