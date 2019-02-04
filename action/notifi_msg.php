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
	
echo $sql = "update msg_recepient set is_read = 1 where msg_to = $member_id";
mysqli_query($con, $sql);
}

?>