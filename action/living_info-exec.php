<?php
	//Start session
	ob_start();
	session_start();
	
	//Include database connection details
	require_once('../config.php');
	
	//Array to store validation errors
	$errmsg_arr = array();
	
	//Validation error flag
	$errflag = false;
	
	//Sanitize the POST values
	$member_id = clean($_POST['member_id'], $con);
	$country = clean($_POST['country'], $con);
	$origion_country=clean($_POST['origion_country'], $con);
	
	
	//Create Update query
	$sql = "update members set country='$country',origion_country='$origion_country' where member_id = '$member_id'";
	$result = mysqli_query($con, $sql) or die(mysqli_error($con));
	
	//Check whether the query was successful or not
	if($result) 
	{
	 $_SESSION['SESS_MEMBER_ID'] = $member_id;		
		header("location: ".$base_url."profile.php");
		exit();
	}
?>