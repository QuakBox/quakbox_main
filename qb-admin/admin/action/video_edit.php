<?php ob_start();
include('../config.php');

$video_id    = $_POST['video_id'];
$description = $_POST['desc'];
$title 	     = $_POST['title'];
$title_color = $_POST['title_color'];
$title_size  = $_POST['title_size'];
$category    = $_POST['category'];
$privacy     = $_POST['privacy'];
//$dThumb      = $_POST['defaultthumbnail'];
$ads     = $_POST['ads'];
if($ads == 1){
    $ads_id     = $_POST['ads_id'];
} else {
	$ads_id     = 0;
}
$published = $_POST['published'];
//$defaultThumb = "uploadedvideo/videothumb/".$dThumb;

$vquery = "UPDATE videos SET description = '$description', category = '$category'
          ,status = '$published',title = '$title',type = '$privacy'
		  ,title_size = '$title_size',title_color = '$title_color',
		  ads = '$ads',ads_id = '$ads_id'
		  WHERE video_id = '$video_id'";
	
$vsql = mysqli_query($conn, $vquery);?>