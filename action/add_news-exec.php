<?php ob_start();

	//Include database connection details
	require_once('../config.php');
		
	//Sanitize the POST values
	$member_id = clean($_POST['member_id'],$con);
	$member_id	 = 	f($member_id, 'strip');
$member_id	 = 	f($member_id, 'escapeAll');
$member_id   = mysqli_real_escape_string($con, $member_id);

	$group_id = clean($_POST['group_id'],$con);	
	$group_id	 = 	f($group_id, 'strip');
$group_id	 = 	f($group_id, 'escapeAll');
$group_id   = mysqli_real_escape_string($con, $group_id);

	$desciption = clean($_POST['desciption'],$con);
$desciption	 = 	f($group_id, 'escapeAll');
$desciption   = mysqli_real_escape_string($con, $group_id);

	$title = clean($_POST['title'],$con);
$title	 = 	f($title, 'escapeAll');
$title   = mysqli_real_escape_string($con, $title);

	$time = time();
			
	//Insert query
	$sql = "insert into groups_bulletins(groupid,created_by,published,title,message,date) values('$group_id','$member_id','1','$title','$desciption','$time')";
	$result = mysqli_query($con,$sql) or die(mysqli_error($con));
	
	//Check whether the query was successful or not
	if($result) 
	{	
		header("location: ".$base_url."view_groups.php?group_id=".$group_id."");
		exit();		
	}
?>