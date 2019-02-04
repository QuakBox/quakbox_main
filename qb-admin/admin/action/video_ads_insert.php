<?php 
ob_start();
session_start();

include('../config.php');

$title = $_POST['title'];
$status = $_POST['published'];
$click_url = $_POST['click_url'];
$time  = time();
$ip	   = $_SERVER['REMOTE_ADDR'];


$NameWithoutExtension  = $_POST['nwe'];

$locationForMp4 = "uploadedvideo/ads/new".$NameWithoutExtension.".mp4";

$locationForOgg = "uploadedvideo/ads/new".$NameWithoutExtension.".ogg";

$locationForWebm = "uploadedvideo/ads/new".$NameWithoutExtension.".webm";

//extension_loaded('ffmpeg') or die('Error in loading ffmpeg');
require_once('../../../qb_classes/ffmpeg-php/FFmpegAutoloader.php');

$ffmpegInstance = new ffmpeg_movie("../../../".$locationForMp4);

$duration = intval($ffmpegInstance->getDuration());

$vquery = "INSERT INTO videos_ads (location,location1,location2,ads_name,date_created,published,click_url) VALUES('$locationForMp4','$locationForOgg','$locationForWebm','$title','$time','$status','$click_url')";

mysqli_query($conn, $vquery);
?> 