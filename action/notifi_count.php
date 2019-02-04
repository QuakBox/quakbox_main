<?php ob_start();
session_start();
if(!isset($_SESSION['SESS_MEMBER_ID']))
	{
echo "1";	
	}
	else
	{
require '../config.php';
	$member_id = $_SESSION['SESS_MEMBER_ID'];
	
echo $sql = "update notifications set is_unread = 1 where received_id = $member_id";
mysqli_query($con, $sql);
}

?>