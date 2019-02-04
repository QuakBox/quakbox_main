<?php ob_start();
$member_id = $_POST['member_id'];
include('../config.php');

	$url=$_POST['mylinktext'];
	$content_id = $_POST['content_id'];
	$url_title=$_POST['title'];	
	$time = time();
	$ip=$_SERVER['REMOTE_ADDR'];
	
if(isset($_POST['mylinktext']))
{
	$sql="INSERT INTO groups_wall(messagesurl_title,member_id,content_id,type,date_created,ip) VALUES ('$url','$url_title','$member_id','$country',3,'$time','$ip')";
	mysqli_query($con, $sql) or die(mysqli_error($con));
	
	
		$url = $_SERVER['HTTP_REFERER'];
header("location: ".$url."");	
exit();
}
?> 
