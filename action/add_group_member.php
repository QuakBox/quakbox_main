<?php 
ob_start();
session_start();	
	include_once('../config.php');
	
	$member_id = $_SESSION['SESS_MEMBER_ID'];
	$group_id = $_REQUEST['group_id'];
	  	$group_id	 = 	f($group_id, 'strip');
$group_id	 = 	f($group_id, 'escapeAll');
$group_id   = mysqli_real_escape_string($con, $group_id);

	
echo $sql="INSERT INTO groups_members (member_id, groupid,approved,permissions) VALUES('$member_id','$group_id',1,0)";

$responce = mysqli_query($con, $sql) or die(mysqli_error($con));
header("location: ".$base_url."view_groups.php?group_id=<?php echo '".$group_id."'?>");
exit();

?> 