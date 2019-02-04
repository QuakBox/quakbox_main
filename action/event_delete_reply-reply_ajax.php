<?php ob_start();
include_once('../config.php');

$session_uid = $_SESSION['SESS_MEMBER_ID'];
$messages_id = mysqli_real_escape_string($con, f($_POST['reply_id'],'escapeAll'));
$responce = mysqli_query($con, "DELETE FROM event_wall_reply_reply WHERE id='$messages_id' AND member_id = '$session_uid'") or die(mysqli_error($con));
//$responce1 = mysqli_query($con, "DELETE FROM reply_reply1 WHERE msg_id='$messages_id'") or die(mysqli_error($con));

?>