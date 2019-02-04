<?php ob_start();
include_once('../config.php');
$member = mysqli_real_escape_string($con, f($_POST['c_id'],'escapeAll'));
$member_id = mysqli_real_escape_string($con, f($_POST['member_id'],'escapeAll'));
if(empty($member_id)){
	exit();
}
mysqli_query($con, "DELETE FROM cometchat WHERE (cometchat.from='$member' AND cometchat.to='$member_id') OR (cometchat.from='$member_id' AND cometchat.to='$member')");

?>