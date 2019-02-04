<?php ob_start();

	//Include database connection details
	require_once('../config.php');	
	
	//Sanitize the POST values
	$session_uid = $_SESSION['SESS_MEMBER_ID'];
	$member_id = mysqli_real_escape_string($con, f($_POST['member_id'],'escapeAll'));
	$group_id = mysqli_real_escape_string($con, f($_POST['group_id'],'escapeAll'));
	$approvals = mysqli_real_escape_string($con, f($_POST['approvals'],'escapeAll'));
	$name = mysqli_real_escape_string($con, f($_POST['name'],'escapeAll'));	
	$desciption = mysqli_real_escape_string($con, f($_POST['desciption'],'escapeAll'));
	$categoryid = mysqli_real_escape_string($con, f($_POST['categoryid'],'escapeAll'));
	$approvals = mysqli_real_escape_string($con, f($_POST['approvals'],'escapeAll'));
	$discussordering = mysqli_real_escape_string($con, f($_POST['discussordering'],'escapeAll'));
	$photopermission = mysqli_real_escape_string($con, f($_POST['photopermission'],'escapeAll'));
	$grouprecentphotos = mysqli_real_escape_string($con, f($_POST['grouprecentphotos'],'escapeAll'));
	$videopermission = mysqli_real_escape_string($con, f($_POST['videopermission'],'escapeAll'));
	$grouprecentvideos = mysqli_real_escape_string($con, f($_POST['grouprecentvideos'],'escapeAll'));
	$newmembernotification = mysqli_real_escape_string($con, f($_POST['newmembernotification'],'escapeAll'));
	$joinrequestnotification = mysqli_real_escape_string($con, f($_POST['joinrequestnotification'],'escapeAll'));
	$wallnotification = mysqli_real_escape_string($con, f($_POST['wallnotification'],'escapeAll'));	
	$time = time();
	$avatar = "images/groupThumbAvatar.jpg";
		
	//Insert query
	$sql = "update groups set approvals='$approvals', name='$name',description='$desciption',categoryid='$categoryid',discussordering='$discussordering',photopermission='$photopermission',
grouprecentphotos='$grouprecentphotos',videopermission='$videopermission',grouprecentvideos='$grouprecentvideos',newmembernotification='$newmembernotification',joinrequestnotification='$joinrequestnotification',wallnotification='$wallnotification' where id='$group_id' AND ownerid = '$session_uid'";
	$result = mysqli_query($con, $sql) or die(mysqli_error($con));
		
	
	//Check whether the query was successful or not
	if($result) 
	{	
		header("location: ".$base_url."groups_wall.php?group_id=".$group_id."");
		exit();		
	}
?>