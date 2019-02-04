<?php ob_start();
require($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php');	
include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_security.php');
  $sessionMemberId = $_SESSION['SESS_MEMBER_ID'];
  $encryptedMemberID = $_REQUEST['memEnc'];
  $encryptedMemberID = f($encryptedMemberID, 'strip');
  $encryptedMemberID = f($encryptedMemberID, 'escapeAll');
  $encryptedMemberID = mysqli_real_escape_string($con, $encryptedMemberID);
  
  $member_id =$QbSecurity->QB_AlphaID($encryptedMemberID, true);
if(empty($member_id)){
	exit();
}	
$sql="delete from blocklist where blocked_userid='$member_id'";
$responce = mysqli_query($con, $sql) or die(mysqli_error($con));

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
?>