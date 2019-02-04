<?php ob_start();
session_start();
include('../config.php');

$session_uid = $_SESSION['SESS_MEMBER_ID'];
//die($session_uid);
$video_id    = mysqli_real_escape_string($con, f($_POST['video_id'],'escapeAll'));
$description = mysqli_real_escape_string($con, f($_POST['desc'],'escapeAll'));
$title 	     = mysqli_real_escape_string($con, f($_POST['title'],'escapeAll'));
$title_color = mysqli_real_escape_string($con, f($_POST['title_color'],'escapeAll'));
$title_size  = mysqli_real_escape_string($con, f($_POST['title_size'],'escapeAll'));
$category    = mysqli_real_escape_string($con, f($_POST['category'],'escapeAll'));
$privacy     = mysqli_real_escape_string($con, f($_POST['tpe'],'escapeAll'));
$dThumb      = mysqli_real_escape_string($con, f($_POST['defaultthumbnail'],'escapeAll'));

$ip	     = $_SERVER['REMOTE_ADDR'];
$defaultThumb = $dThumb;
$custom_thumb = mysqli_real_escape_string($con, f($_POST['custom_thumb'],'escapeAll'));
if(empty($custom_thumb)){
$vquery = "UPDATE videos SET description = '$description', category = '$category'
          ,thumburl = '$dThumb',title = '$title',type = '$privacy'
		  ,title_size = '$title_size',title_color = '$title_color'
		  WHERE video_id = '$video_id' AND user_id = '$session_uid'";
} else {
	$vquery = "UPDATE videos SET description = '$description', category = '$category'
          ,thumburl = '$dThumb',title = '$title',type = '$privacy'
		  ,title_size = '$title_size',title_color = '$title_color',custom_thumb = '$custom_thumb'
		  WHERE video_id = '$video_id' AND user_id = '$session_uid'";
}

//echo $vquery;

//die();
$vsql = mysqli_query($con, $vquery)  or die(mysqli_error($con));



if($custom_thumb != $dThumb){
	$vquery = "UPDATE videos SET custom_thumb = '' WHERE video_id = '$video_id' AND user_id = '$session_uid'";
	$vsql = mysqli_query($con, $vquery)  or die(mysqli_error($con));
}

	
?> 