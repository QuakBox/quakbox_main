<?php ob_start();
    include_once '../config.php'; 
    $video_id = mysqli_real_escape_string($con, f($_POST['video_id'],'escapeAll'));  	
    if(empty($video_id)){
	exit();
}
	$vquery = "UPDATE videos SET custom_thumb = '' WHERE video_id = '$video_id'";
	if(mysqli_num_rows($vquery) == 0){
	exit();
}
	$vsql = mysqli_query($con, $vquery)  or die(mysqli_error($con));
	
	$pvsql = mysqli_query($con, "SELECT v.thumburl,v.thumburl2,v.custom_thumb	FROM videos			
			             WHERE v.video_id = '$video_id'
			             ORDER BY v.video_id DESC") or die(mysqli_error($con));
    $pvres = mysqli_fetch_array($pvsql);
	
	$custom_thumb400x225 = '../uploadedvideo/videothumb/p400x225'.$pvres['custom_thumb'];
	$custom_thumb200x150 = '../uploadedvideo/videothumb/p200x150'.$pvres['custom_thumb'];
	
	//remove thumb from server
	@unlink($custom_thumb400x225);
	@unlink($custom_thumb200x150);
	
	$custom_thumb  = $pvres['custom_thumb'];
	$default_thumb = $pvres['thumburl'];
	$thumburl2 = $pvres['thumburl2'];
	if($custom_thumb == $default_thumb){
		$vquery = "UPDATE videos SET thumburl = '$thumburl2' WHERE video_id = '$video_id'";
	    $vsql = mysqli_query($con, $vquery)  or die(mysqli_error($con));
	}
 ?>  