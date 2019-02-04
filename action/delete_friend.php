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
$sql = "DELETE FROM friendlist WHERE (added_member_id = '$member_id' AND member_id = '$sessionMemberId') OR (member_id = '$member_id' AND added_member_id = '$sessionMemberId')";

$response = mysqli_query($con, $sql);

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
?>