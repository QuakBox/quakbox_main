<?php ob_start();
session_start();

include('../config.php');

$member_id = $_POST['member_id'];
$member_id   = f($member_id, 'strip');
$member_id	 = 	f($member_id, 'escapeAll');
$member_id   = mysqli_real_escape_string($con, $member_id);

$file=$_FILES['image']['tmp_name'];

$content_id = $_POST['content_id'];
$content_id   = f($content_id, 'strip');
$content_id	 = 	f($content_id, 'escapeAll');
$content_id   = mysqli_real_escape_string($con, $content_id);

$privacy 	 = $_POST['privacy'];
$privacy   = f($privacy, 'strip');
$privacy	 = 	f($privacy, 'escapeAll');
$privacy   = mysqli_real_escape_string($con, $privacy);

$time = time();
$ip=$_SERVER['REMOTE_ADDR'];
$title 	   = $_POST['title'];
$title	 = 	f($title, 'escapeAll');
$title   = mysqli_real_escape_string($con, $title);

$thumburl 	= "uploadedvideo/default_thumb.png";

$share_member = $_POST['photo_custom_share'];
$share_member   = f($share_member, 'strip');
$share_member	 = 	f($share_member, 'escapeAll');
$share_member   = mysqli_real_escape_string($con, $share_member);
	
	$unshare_member = $_POST['photo_custom_unshare'];
	$unshare_member   = f($unshare_member, 'strip');
$unshare_member	 = 	f($unshare_member, 'escapeAll');
$unshare_member   = mysqli_real_escape_string($con, $unshare_member);

	
	$member_sql = mysqli_query($con, "select * from members where username='".$share_member."'");
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
exec("/usr/local/bin/ffmpeg -y -i ../uploadedvideo/".$image_name." ../uploadedvideo/".$image_namew.".flv  </dev/null >/dev/null 2>/var/log/ffmpeg.log &");	
	$old_img_name = $image_name;
	$image_name=$image_namew.".flv";	
				
	$location="uploadedvideo/" . $image_name;
	$sql="INSERT INTO message(messages,member_id,content_id,type,date_created,ip,wall_privacy,share_member_id,unshare_member_id) VALUES ('$location','$member_id','$content_id',2,'$time','$ip','$privacy','".$share_member."','".$unshare_member."')";

mysqli_query($con,$sql) or die(mysqli_error($con));

$newwallid = mysqli_insert_id($con);
//insert into videos table
	$vquery = "INSERT INTO videos (location,thumburl,title,user_id,type,url_type,date_created,msg_id) 
			VALUES('$location','$thumburl','$title','$member_id','0','1','$time','$newwallid')";
	$vsql = mysqli_query($con, $vquery);
	
	$video_id = mysqli_insert_id($con);
	
	echo $umsql="UPDATE message set video_id = '$video_id' where messages_id = '$newwallid'";
		mysqli_query($con, $umsql);

//insert into news feeds
		
if(!empty($newwallid)){
 $sqlnfeeds = "INSERT INTO news_feeds ";
        $sqlnfeeds.= "(`date_created`, `msg_id`) ";
        $sqlnfeeds.= "VALUES ";
        $sqlnfeeds.= "('".strtotime(date("Y-m-d H:i:s"))."', '$newwallid') ";
        mysqli_query($con, $sqlnfeeds);
}
unlink("../uploadedvideo/" .$old_img_name);
	$url = $_SERVER['HTTP_REFERER'];
	header("location: ".$url."");
exit();

}
?> 