<?php ob_start();
session_start();
$member_id = $_POST['member_id'];
include('../config.php');

$file=$_FILES['image']['tmp_name'];

$country = clean($_POST['country'], $con);
$country   = f($country, 'strip');
$country	 = 	f($country, 'escapeAll');
$country   = mysqli_real_escape_string($con, $country);

$time = time();
$ip=$_SERVER['REMOTE_ADDR'];

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
	exec("/usr/local/bin/ffmpeg -y -i ../uploadedvideo/".$image_name." ../uploadedvideo/".$image_namew.".flv  </dev/null >/dev/null 2>/var/log/ffmpeg.log &");	
	$old_img_name = $image_name;
	$image_name=$image_namew.".flv";	
	$location="uploadedvideo/" . $image_name;
	$sql="INSERT INTO message(messages,member_id,country_flag,type,date_created,ip) VALUES ('$location','$member_id','$country',2,'$time','$ip')";

mysqli_query($con, $sql) or die(mysqli_error($con));

//insert into news feeds
		$newwallid = mysqli_insert_id($con);
if(!empty($newwallid)){
 $sqlnfeeds = "INSERT INTO news_feeds ";
        $sqlnfeeds.= "(`date_created`, `msg_id`) ";
        $sqlnfeeds.= "VALUES ";
        $sqlnfeeds.= "('".strtotime(date("Y-m-d H:i:s"))."', '$newwallid') ";
        mysqli_query($con, $sqlnfeeds);
}
	unlink("../uploadedvideo/" .$old_img_name);
	header("location: ".$base_url."mywall.php");
	exit();


}
?> 