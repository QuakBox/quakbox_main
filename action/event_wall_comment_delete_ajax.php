<?php ob_start();
include_once('../config.php');
$messages_id = mysqli_real_escape_string($con, f($_POST['com_id'],'escapeAll'));
$responce = mysqli_query($con, "DELETE FROM event_wall_comment WHERE comment_id='$messages_id'") or die(mysqli_error($con));
echo $responce;
?>