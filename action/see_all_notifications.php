<?php
ob_start();
session_start();
require '../config.php';
$member_id = $_SESSION['SESS_MEMBER_ID'];
	
echo $sql = "UPDATE notifications SET is_unread = 1 WHERE received_id = $member_id";
mysqli_query($con, $sql);

