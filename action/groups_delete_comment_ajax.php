<?php
include_once('../config.php');
$messages_id = $_POST['com_id'];
$messages_id	 = 	f($messages_id, 'strip');
$messages_id	 = 	f($messages_id, 'escapeAll');
$messages_id   = mysqli_real_escape_string($con, $messages_id);

$responce = mysqli_query($con, "DELETE FROM groups_wall_comment WHERE comment_id='$messages_id'") or die(mysqli_error($con));
echo $responce;
?>