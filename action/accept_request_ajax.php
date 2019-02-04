<?php ob_start();
session_start();
if(!isset($_SESSION['SESS_MEMBER_ID']))
	{
echo "1";	
	}
	else
	{
require '../config.php';
	$add_member_id = $_SESSION['SESS_MEMBER_ID'];
	$member_id = $_POST['member_id'];
	$member_id	 = 	f($member_id, 'strip');
$member_id	 = 	f($member_id, 'escapeAll');
$member_id   = mysqli_real_escape_string($con, $member_id);
	
mysqli_query($con, "update friendlist set status=1 where member_id = $add_member_id and added_member_id = '$member_id'");

$sql="INSERT INTO friendlist (member_id, added_member_id, status, request_status,is_unread)
VALUES
('$member_id','$add_member_id','1',1,1)";

$responce = mysqli_query($con, $sql);

$member_sql = mysqli_query($con, "select * from members where member_id='$add_member_id'");
$member_res = mysqli_fetch_array($member_sql);

$url = $member_res['username'];
$time = time();

$nquery = "INSERT INTO notifications (sender_id, received_id, type_of_notifications, title, href, is_unread, date_created)
				VALUES('$add_member_id','$member_id',35,'Accepted your friend request','$url',0,'$time')";
mysqli_query($con, $nquery);
}
?>