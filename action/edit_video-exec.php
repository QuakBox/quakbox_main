<?php ob_start();
session_start();
$member_id = $_POST['member_id'];
include('../config.php');

$session_uid = $_SESSION['SESS_MEMBER_ID'];
$file = $_FILES['video']['tmp_name'];
$url = mysqli_real_escape_string($con, f($_POST['url'],'escapeAll'));
$title = mysqli_real_escape_string($con, f($_POST['title'],'escapeAll'));
$description = mysqli_real_escape_string($con, f($_POST['description'],'escapeAll'));
$category = mysqli_real_escape_string($con, f($_POST['category'],'escapeAll'));
$type = mysqli_real_escape_string($con, f($_POST['type'],'escapeAll'));
$video_id = mysqli_real_escape_string($con, f($_POST['video_id'],'escapeAll'));

$time = time();
$ip=$_SERVER['REMOTE_ADDR'];

/*$file_size = $_FILES['video']['size'];
if ($file_size == NULL) 
{
	echo "not set";
	mysqli_query($con, "insert into videos(location,title,description,category,user_id,type,url_type,date_created) 
			values('$url','$title','$description','$category','$member_id','$type',1,'$time')") or die(mysqli_error($con));
$sql="INSERT INTO message(messages,member_id,country_flag,type,date_created,ip) VALUES ('$url','$member_id','World',3,'$time','$ip')";
}
else
{
	$image= addslashes(file_get_contents($_FILES['video']['tmp_name']));
	$image_name= $time.addslashes($_FILES['video']['name']);
	$image_size= getimagesize($_FILES['video']['tmp_name']);	
		
	move_uploaded_file($_FILES["video"]["tmp_name"],"../uploadedvideo/" . $image_name);			
	$location="uploadedvideo/" . $image_name;
	
	mysqli_query($con, "insert into videos(location,title,description,category,user_id,type,url_type,date_created) 
			values('$location','$title','$description','$category','$member_id','$type',2,'$time')") or die(mysqli_error($con));

$sql="INSERT INTO message(messages,video,member_id,country_flag,type,date_created,ip) VALUES ('$location','$location','$member_id','World',2,'$time','$ip')";

}
*/

$sql = "update videos set title = '$title', description = '$description',category = '$category', type = '$type' where video_id = '$video_id' AND user_id = '$session_uid'";

mysqli_query($con, $sql) or die(mysqli_error($con));



header("location: ".$base_url."myvideos.php");
exit();
?> 
