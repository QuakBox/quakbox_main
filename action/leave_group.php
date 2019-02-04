<?php ob_start();
require_once('../config.php');
$group_id = f($_REQUEST['group_id'],'escapeAll');
$group_id = mysqli_real_escape_string($con, $group_id);
$member_id = f($_REQUEST['member_id'],'escapeAll');
$member_id = mysqli_real_escape_string($con, $member_id);
$sql = "delete from groups_members where groupid='$group_id' and member_id='$member_id'";
$responce = mysqli_query($con, $sql);

	//header("location:../view_groups.php?group_id=".$group_id."");


?>