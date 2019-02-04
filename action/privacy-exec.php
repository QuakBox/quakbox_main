<?php ob_start();

	//Include database connection details
	require_once('../config.php');
	
	//Sanitize the POST values
	$privacyProfileView = clean($_POST['privacyProfileView'], $con);
$privacyProfileView   = f($privacyProfileView, 'strip');
$privacyProfileView	 = 	f($privacyProfileView, 'escapeAll');
$privacyProfileView   = mysqli_real_escape_string($con, $privacyProfileView);

	$privacyFriendsView = clean($_POST['privacyFriendsView'], $con);
$privacyFriendsView   = f($privacyFriendsView, 'strip');
$privacyFriendsView	 = 	f($privacyFriendsView, 'escapeAll');
$privacyFriendsView   = mysqli_real_escape_string($con, $privacyFriendsView);

	$privacyPhotoView = clean($_POST['privacyPhotoView'], $con);
$privacyPhotoView   = f($privacyPhotoView, 'strip');
$privacyPhotoView	 = 	f($privacyPhotoView, 'escapeAll');
$privacyPhotoView   = mysqli_real_escape_string($con, $privacyPhotoView);


	$notifyEmailSystem = clean($_POST['notifyEmailSystem'], $con);
$notifyEmailSystem   = f($notifyEmailSystem, 'strip');
$notifyEmailSystem	 = 	f($notifyEmailSystem, 'escapeAll');
$notifyEmailSystem   = mysqli_real_escape_string($con, $notifyEmailSystem);

	$notifyEmailAps = clean($_POST['notifyEmailAps'], $con);
$notifyEmailAps   = f($notifyEmailAps, 'strip');
$notifyEmailAps	 = 	f($notifyEmailAps, 'escapeAll');
$notifyEmailAps   = mysqli_real_escape_string($con, $notifyEmailAps);

	$notifyWallComment = clean($_POST['notifyWallComment'], $con);
$notifyWallComment   = f($notifyWallComment, 'strip');
$notifyWallComment	 = 	f($notifyWallComment, 'escapeAll');
$notifyWallComment   = mysqli_real_escape_string($con, $notifyWallComment);

	$privacyGenderView = clean($_POST['privacyGenderView'], $con);
$privacyGenderView   = f($privacyGenderView, 'strip');
$privacyGenderView	 = 	f($privacyGenderView, 'escapeAll');
$privacyGenderView   = mysqli_real_escape_string($con, $privacyGenderView);

	$privacyEmailView = clean($_POST['privacyEmailView'], $con);
$privacyEmailView   = f($privacyEmailView, 'strip');
$privacyEmailView	 = 	f($privacyEmailView, 'escapeAll');
$privacyEmailView   = mysqli_real_escape_string($con, $privacyEmailView);

	$privacyBirthdayView = clean($_POST['privacyBirthdayView'], $con);
$privacyBirthdayView   = f($privacyBirthdayView, 'strip');
$privacyBirthdayView	 = 	f($privacyBirthdayView, 'escapeAll');
$privacyBirthdayView   = mysqli_real_escape_string($con, $privacyBirthdayView);

	$privacyMobileNoView = clean($_POST['privacyMobileNoView'], $con);
$privacyMobileNoView   = f($privacyMobileNoView, 'strip');
$privacyMobileNoView	 = 	f($privacyMobileNoView, 'escapeAll');
$privacyMobileNoView   = mysqli_real_escape_string($con, $privacyMobileNoView);

	$privacyWorkandEducationView = clean($_POST['privacyWorkandEducationView'], $con);
$privacyWorkandEducationView   = f($privacyWorkandEducationView, 'strip');
$privacyWorkandEducationView	 = 	f($privacyWorkandEducationView, 'escapeAll');
$privacyWorkandEducationView   = mysqli_real_escape_string($con, $privacyWorkandEducationView);
	
	
		$member_id = clean($_POST['member_id'], $con);
$member_id   = f($member_id, 'strip');
$member_id	 = 	f($member_id, 'escapeAll');
$member_id   = mysqli_real_escape_string($con, $member_id);
	//Insert query
	
	$query1 = mysqli_query($con,  "SELECT privacy_member_id FROM privacy WHERE privacy_member_id='$member_id'");
	   $total = mysqli_num_rows($query1);
	   
	   if($total == 0 )
	   {
		
	
	$sql = "insert into privacy(profile,friends,photo,privacy_member_id,receive_email,receive_notification,comment_notification,gender,email,birthday,mobileno,workandeducation ) values('$privacyProfileView','$privacyFriendsView','$privacyPhotoView','$member_id','$notifyEmailSystem','$notifyEmailAps','$notifyWallComment','$privacyGenderView','$privacyEmailView','$privacyBirthdayView','$privacyobileNoView','$privacyWorkandEducationView')";
	$result = mysqli_query($con, $sql) or die(mysqli_error($con));
	}
	
	else
	{
	
			$sql = mysqli_query($con, "UPDATE privacy set profile = '$privacyProfileView',
											   friends = '$privacyFriendsView',
											   photo = '$privacyPhotoView',	 
											   receive_email= '$notifyEmailSystem',
											   receive_notification = '$notifyEmailAps',
											   comment_notification = '$notifyWallComment',
											   gender = '$privacyGenderView',
											   email = '$privacyEmailView',
											   birthday = '$privacyBirthdayView',
											   mobileno = '$privacyobileNoView',
											   workandeducation = '$privacyWorkandEducationView'
											   WHERE privacy_member_id = '$member_id'");

	
	}
	
	$url = '';
if(strpos($_SERVER['HTTP_REFERER'], "?") == null)
	$url = $_SERVER['HTTP_REFERER'];
else
	$url = substr($_SERVER['HTTP_REFERER'], 0, strpos($_SERVER['HTTP_REFERER'], "?"));
	
//echo $url;
header("location: ".$url."?err=".mysqli_error($con));
exit();
?>