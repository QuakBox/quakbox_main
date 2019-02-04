<?php ob_start();
session_start();

include('../config.php');

	$member_id 		= $_POST['member_id'];
	$member_id	 = 	f($member_id, 'strip');
$member_id	 = 	f($member_id, 'escapeAll');
$member_id   = mysqli_real_escape_string($con, $member_id);

	$title 			= $_POST['title'];
$title	 = 	f($title, 'escapeAll');
$title   = mysqli_real_escape_string($con, $title);

	$file			 = $_FILES['image']['tmp_name'];

	$thumburl 		 = "uploadedvideo/default_thumb.png";
	
	$country 		  = $_POST['country'];
	$country	 = 	f($country, 'strip');
$country	 = 	f($country, 'escapeAll');
$country   = mysqli_real_escape_string($con, $country);

	$country_id 	   = $_POST['country_id'];
	$country_id	 = 	f($country_id, 'strip');
$country_id	 = 	f($country_id, 'escapeAll');
$country_id   = mysqli_real_escape_string($con, $country_id);

	$privacy 		  = $_POST['privacy'];
	$privacy	 = 	f($privacy, 'strip');
$privacy	 = 	f($privacy, 'escapeAll');
$privacy   = mysqli_real_escape_string($con, $privacy);

	$time 			 = time();
	$ip			   = $_SERVER['REMOTE_ADDR'];


$share_member = $_POST['photo_custom_share'];	
$share_member	 = 	f($share_member, 'strip');
$share_member	 = 	f($share_member, 'escapeAll');
$share_member   = mysqli_real_escape_string($con, $share_member);

	$unshare_member = $_POST['photo_custom_unshare'];
	$unshare_member	 = 	f($unshare_member, 'strip');
$unshare_member	 = 	f($unshare_member, 'escapeAll');
$unshare_member   = mysqli_real_escape_string($con, $unshare_member);
	
	$member_sql = mysqli_query($con,"select * from members where username='".$share_member."'");
	$row = mysqli_fetch_array($member_sql);
	
	$member_sql1 = mysqli_query($con, "select * from members where username='".$unshare_member."'");
	$row2 = mysqli_fetch_array($member_sql1);	

if (!isset($file)) 
{
	echo "";
}
else
{
	$image= addslashes(file_get_contents($_FILES['image']['tmp_name']));
	$image_name= $time.addslashes($_FILES['image']['name']);
	$image_size= getimagesize($_FILES['image']['tmp_name']);	
	$image_namew = pathinfo($image_name, PATHINFO_FILENAME);	
	move_uploaded_file($_FILES["image"]["tmp_name"],"../uploadedvideo/" . $image_name);			
	exec("/usr/local/bin/ffmpeg -i ../uploadedvideo/".$image_name." -ab 56 -ar 44100 -b 200 -r 15 -s 240x180 -f flv ../uploadedvideo/".$image_namew.".flv");
	$old_img_name = $image_name;
	$image_name=$image_namew.".flv";	
	$location="uploadedvideo/" . $image_name;
	$sql="INSERT INTO message(messages,member_id,country_flag,type,date_created,ip,wall_privacy,share_member_id,unshare_member_id) VALUES ('$location','$member_id','$country',2,'$time','$ip','$privacy','".$share_member."','".$unshare_member."')";
	
	$newwallid = mysqli_insert_id($con);
	
	//insert into videos table
	$vquery = "INSERT INTO videos (location,thumburl,title,user_id,type,url_type,date_created,msg_id,country_id) 
			VALUES('$location','$thumburl','$title','$member_id','0','1','$time','$newwallid','$country_id')";
	$vsql = mysqli_query($con, $vquery);
	
	

if (mysqli_query($con, $sql) or die(mysqli_error($con)))
{
	unlink("../uploadedvideo/" .$old_img_name);
	header("location: ".$base_url."country_videos.php?country_id=".$country."");
	exit();
}

}
?> 