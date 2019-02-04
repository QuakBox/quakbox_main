<?php ob_start();
require_once('../config.php');
$add_member_id = $_SESSION['SESS_MEMBER_ID'];
$group_id = mysqli_real_escape_string($con, f($_REQUEST['group_id'],'escapeAll'));
if(empty($group_id)){
	exit();
}

$wsql = mysqli_query($con, "SELECT id FROM groups WHERE id='$group_id'  AND ownerid = '$session_uid'");
if(mysqli_num_rows($wsql) == 0){
	exit();
}

$sql = "delete from groups where id='$group_id'  AND ownerid = '$session_uid'";
$responce = mysqli_query($con, $sql);

$sql1 = mysqli_query($con, "delete from groups_members where group_id='$group_id'");
if($responce)
{
	header("location: ".$base_url."view_groups.php?group_id=<?php echo ".$group_id."?>");
	exit();
}

?>