<?php ob_start();
include('../config.php');

$session_uid = $_SESSION['SESS_MEMBER_ID'];
$id          = mysqli_real_escape_string($con, f($_POST['id'],'escapeAll'));
$description = mysqli_real_escape_string($con, f($_POST['description'],'escapeAll'));

$sql = "UPDATE videos_channel SET description = '$description' where id = '$id' AND member_id = '$session_uid'";

mysqli_query($con, $sql) or die(mysqli_error($con));

?> 