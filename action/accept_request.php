<?php ob_start();
session_start();
require '../config.php';
	$add_member_id = $_SESSION['SESS_MEMBER_ID'];
	$member_id = $_REQUEST['member_id'];
	$member_id	 = 	f($member_id, 'strip');
$member_id	 = 	f($member_id, 'escapeAll');
$member_id   = mysqli_real_escape_string($con, $member_id);

	$member = mysqli_query($con, "select * from members where member_id='$add_member_id'");
	$member_res = mysqli_fetch_array($member);
	
mysqli_query($con, "update friendlist set status=1 where member_id = $add_member_id and added_member_id = '$member_id'");

echo $sql="INSERT INTO friendlist (member_id, added_member_id, status, request_status)
VALUES
('$member_id','$add_member_id','1',1)";

$responce = mysqli_query($con,$sql);

$member_sql = mysqli_query($con,"select * from members where member_id='$member_id");
$member_res = mysqli_fetch_array($member_sql);

header("location: ".$base_url."pending_request.php");
exit();
?>