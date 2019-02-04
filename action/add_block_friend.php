<?php //Start session
	ob_start();
	session_start();
	
	//Include database connection details
	require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_lookup.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
	$objLookupClass=new lookup();
	$objMember = new member1();	
	$activeID =  $objLookupClass->getLookupKey("MEMBER STATUS", "ACTIVE");
$blocked_member_id = 0;

$memberUsername = $_REQUEST['user_search'];
	$memberUsername	 = 	f($memberUsername, 'strip');
$memberUsername	 = 	f($memberUsername, 'escapeAll');
$memberUsername   = mysqli_real_escape_string($con, $memberUsername);
$memberResult=$objMember->getMemberByUsernameandStatus($memberUsername,$activeID);
$countOfMemberResult=count($memberResult);
foreach($memberResult as $valueMemberResult){
		$blocked_member_id =$valueMemberResult['member_id'];			
}

$member_id   = htmlspecialchars(trim($_SESSION['SESS_MEMBER_ID']));

$blockquery = "SELECT id FROM blocklist WHERE userid = '$member_id' AND blocked_userid = '$blocked_member_id'";
$blocksql = mysqli_query($con, $blockquery)or die(mysqli_error($con));
$blockcount = mysqli_num_rows($blocksql) ;
if($blockcount == 0){
$sql="INSERT INTO blocklist (userid, blocked_userid) VALUES ('$member_id','$blocked_member_id')";
$responce = mysqli_query($con,$sql) or die(mysqli_error($con));
$last_id=mysqli_insert_id($con);
mysqli_query($con,"delete from friendlist  where (member_id='$blocked_member_id' and added_member_id='$member_id') or (member_id='$member_id' and added_member_id='$blocked_member_id') ");


}
header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
?>