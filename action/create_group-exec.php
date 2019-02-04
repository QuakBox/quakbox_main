<?php ob_start();

	//Include database connection details
	require_once('../config.php');
		
	//Sanitize the POST values
	
	$member_id = mysqli_real_escape_string($con, f($_POST['member_id'],'escapeAll'));
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
	$sql = "insert into groups(ownerid,name,avatar,description,categoryid,approvals,created,discussordering,photopermission,grouprecentphotos,videopermission,grouprecentvideos,newmembernotification,joinrequestnotification,wallnotification) values('$member_id','$name','$avatar','$desciption','$categoryid','$approvals','$time','$discussordering','$photopermission','$grouprecentphotos','$videopermission','$grouprecentvideos','$newmembernotification','$joinrequestnotification','$wallnotification')";
	$result = mysqli_query($con,$sql) or die(mysqli_error($con));
	
	$group_id = mysqli_insert_id($con);
	mysqli_query($con, "insert into groups_members(groupid,member_id,approved,permissions) values('$group_id','$member_id',1,1)") or die(mysqli_error($con));
	
	//Check whether the query was successful or not
	if($result) 
	{	
		header("location: ".$base_url."groups_created.php?group_id=".$group_id."");	
		exit();	
	}
?>