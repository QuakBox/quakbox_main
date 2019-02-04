<?php ob_start();
session_start();
require_once('../config.php');
$member_id = f($_REQUEST['member_id'],'escapeAll');
$member_id = mysqli_real_escape_string($con, $member_id);
$member_session=$member_id;
if(isset($_SESSION['SESS_MEMBER_ID']))
{$member_session = $_SESSION['SESS_MEMBER_ID'];}

$activation_code = f($_REQUEST['verification_code'],'escapeAll');
$activation_code = mysqli_real_escape_string($con, $activation_code);
$checksql = "Select * from members where member_id = '".$member_id."' and status_code='".$activation_code."'";
$sqlcount = mysqli_query($con, $checksql);
if(mysqli_num_rows($sqlcount) == 0){
header("location: ".$base_url."error.html");	
exit();
}
else
{
$sql = "update members set status_id = 1 where member_id = '".$member_id."' and status_code='".$activation_code."'";
mysqli_query($con, $sql);
include('../cpanelemailreg.php');
header("location: ".$base_url."activation.php?verification_code=".$activation_code."&member_id=".$member_id."");
exit();
}
?>