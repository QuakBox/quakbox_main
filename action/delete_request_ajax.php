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
	$member_id = mysqli_real_escape_string($con, f($_POST['member_id'],'escapeAll'));
if(empty($member_id)){
	exit();
}	
$sql="delete from friendlist where added_member_id='$member_id' AND member_id = '$add_member_id'";

$responce = mysqli_query($con, $sql);

}
?>