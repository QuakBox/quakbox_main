<?php ob_start();
	//Include database connection details
	require_once('../config.php');
		
	//Validation error flag
	$errflag = false;	
	
	//Sanitize the POST values
	$member_id = clean($_POST['member_id'],$con);
	$member_id	 = 	f($member_id, 'strip');
$member_id	 = 	f($member_id, 'escapeAll');
$member_id   = mysqli_real_escape_string($con, $member_id);

	$email_id = clean($_POST['email_id'],$con);
	$email_id	 = 	f($email_id, 'strip');
$email_id	 = 	f($email_id, 'escapeAll');
$email_id   = mysqli_real_escape_string($con, $email_id);

	$username = clean($_POST['username'],$con);
	$username	 = 	f($username, 'strip');
$username	 = 	f($username, 'escapeAll');
$username   = mysqli_real_escape_string($con, $username);

	$member_name = clean($_POST['member_name'],$con);
	$member_name	 = 	f($member_name, 'strip');
$member_name	 = 	f($member_name, 'escapeAll');
$member_name   = mysqli_real_escape_string($con, $member_name);

	$password = md5($_POST['password']);
	
	$language = clean($_POST['language'],$con);	
	$language	 = 	f($language, 'strip');
$language	 = 	f($language, 'escapeAll');
$language   = mysqli_real_escape_string($con, $language);

	
	//Create Update query
	if($password != NULL)
	{
		$md5password = md5($password);
	 	$sql = "update members set email_id='$email_id', username = '$username', FirstName='$member_name', password='$password' where member_id = '$member_id'";
	}
	else
	{
		$sql = "update members set email_id='$email_id', username = '$username', FirstName='$member_name' where member_id = '$member_id'";	
	}
	echo $sql;
	$result = mysqli_query($con,$sql) or die(mysqli_error($con));
	
	$member_sql = mysqli_query($con,"select * from members where member_id='$member_id'");
$member_res = mysqli_fetch_array($member_sql);


	//Check whether the query was successful or not
$url = '';
if(strpos($_SERVER['HTTP_REFERER'], "?") == null)
	$url = $_SERVER['HTTP_REFERER'];
else
	$url = substr($_SERVER['HTTP_REFERER'], 0, strpos($_SERVER['HTTP_REFERER'], "?"));
	
//echo $url;
header("location: ".$url."?err=".mysqli_error($con));
exit();
?>