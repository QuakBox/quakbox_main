<?php ob_start();

session_start();
require_once('../config.php');
$member_id = mysqli_real_escape_string($con, f($_REQUEST['member_id'],'escapeAll'));
if(empty($member_id)){
	exit();
}
$loginuserid=$_SESSION['userid'];
$sqlcheck="delete from friendlist where (member_id=$loginuserid && added_member_id=$member_id) || (member_id=$member_id && added_member_id=$loginuserid )";
mysqli_query($con, $sqlcheck);

?>
