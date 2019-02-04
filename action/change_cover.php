<?php
ob_start();
include('../config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php'); 
$session_uid = $_SESSION['SESS_MEMBER_ID'];
$channel_id = mysqli_real_escape_string($con, f($_POST['channel_id'],'escapeAll'));
$username = mysqli_real_escape_string($con, f($_POST['username'],'escapeAll'));
$cover = $_FILES['file_upload']['tmp_name'];

$image_size = getimagesize($_FILES['file_upload']['tmp_name']);
if($image_size == FALSE)
{
}
else
{
	
		$uploaddir = '../uploadedimage/';
		$file = $uploaddir . basename($_FILES['file_upload']['name']);
			
		move_uploaded_file($_FILES['file_upload']['tmp_name'], $file);
		$location="uploadedimage/" . $_FILES["file_upload"]["name"]; 
					  
		$sql = "update videos_channel set cover_photo='" . $location."' 
						where id='".$channel_id."' AND member_id = '".$session_uid."' ";
		//echo $sql;					
		mysqli_query($con, $sql) or die(mysqli_error($con));
		
					
}
//die();
header("location: ".$base_url."user/".$username."");
exit();

?>