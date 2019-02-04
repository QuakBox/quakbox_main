<?php ob_start();

include('../config.php');

	$member_id = $_POST['uploadedby'];
	$url=$_POST['mylinktext'];
	$content_id = $_POST['content_id'];
	$url_title=$_POST['title'];
	$privacy 	 = $_POST['privacy'];	
	$time = time();
	$ip=$_SERVER['REMOTE_ADDR'];
	
	$share_member = $_POST['photo_custom_share'];	
	$unshare_member = $_POST['photo_custom_unshare'];
	
	$member_sql = mysqli_query($con, "select * from members where username='".$share_member."'");
	$row = mysqli_fetch_array($member_sql);
	
	$member_sql1 = mysqli_query($con, "select * from members where username='".$unshare_member."'");
	$row2 = mysqli_fetch_array($member_sql1);	

	
if(isset($_POST['mylinktext']))
{
	echo $sql="INSERT INTO message(messages,url_title,member_id,content_id,type,date_created,ip,wall_privacy,share_member_id,unshare_member_id) VALUES ('$url','$url_title','$member_id','$content_id',3,'$time','$ip','$privacy','".$share_member."','".$unshare_member."')";
	mysqli_query($con, $sql) or die(mysqli_error($con));
	
	
	//insert into videos table
	$vquery = "INSERT INTO videos (location,title,user_id,type,url_type,date_created,msg_id) 
			VALUES('$url','$url_title','$member_id','0','2','$time','$newwallid')";
	$vsql = mysqli_query($con, $vquery);
	
	$video_id = mysqli_insert_id($con);
	
		echo $umsql="UPDATE message set video_id = '$video_id' where messages_id = '$newwallid'";
		mysqli_query($con, $umsql);
	
	//insert into news feeds
		$newwallid = mysqli_insert_id($con);
if(!empty($newwallid)){
 $sqlnfeeds = "INSERT INTO news_feeds ";
        $sqlnfeeds.= "(`date_created`, `msg_id`) ";
        $sqlnfeeds.= "VALUES ";
        $sqlnfeeds.= "('".strtotime(date("Y-m-d H:i:s"))."', '$newwallid') ";
        //mysqli_query($sqlnfeeds);
}

		$url = $_SERVER['HTTP_REFERER'];
header("location: ".$url."");	
exit();
}
?> 
