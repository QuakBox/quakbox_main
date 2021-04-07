<?php 
require_once('config.php');
$video_id = $_REQUEST['video_id']; 
	$pvquery = "SELECT v.location,v.location1,v.location2, v.thumburl, v.title, v.video_id, v.date_created, v.view_count,v.description,
				v.url_type, v.msg_id, v.category, m.member_id, m.username,v.title_color,v.title_size,v.ads,a.ads_name,
				a.location as adslocation,a.location1 as adslocation1,a.location2 as adslocation2, a.click_url
				FROM videos v LEFT JOIN members m ON m.member_id = v.user_id 
				LEFT JOIN videos_ads a ON v.ads_id = a.id
				WHERE v.video_id = '$video_id'";

	$pvsql = mysqli_query($con, $pvquery) or die(mysqli_error($con));
	$mrow = mysqli_fetch_array($pvsql);
?>

<!DOCTYPE html>
<html>
<body>
<style type="text/css">
video {  
   width:100%; 
   max-width:600px; 
   height:auto; 
}
</style>
<?php

$mp4videopath = $mrow['location'];
$oggvideopath = $mrow['location1'];
$webmvideopath = $mrow['location2'];
$thumb = $mrow['thumburl'];
?>

<video id="video" poster="<?php echo $base_url.'uploadedvideo/videothumb/p400x225'.$thumb; ?>" preload="none" controls>
<source src="<?php echo $base_url.$mp4videopath; ?>" type="video/mp4">
</video>
</body>

</html>




     