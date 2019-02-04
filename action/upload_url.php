<?php ob_start();
include('../config.php');

	$member_id 		= $_POST['member_id'];
	$url			  = $_POST['mylinktext'];
	$url_title		= $_POST['title'];
	$country 		  = $_POST['country'];
	$country_id 	   = $_POST['country_id'];
	$time 			 = time();
	$ip			   = $_SERVER['REMOTE_ADDR'];
	
if(isset($_POST['mylinktext']))
{
	$sql="INSERT INTO message(messages,url_title,member_id,country_flag,type,date_created,ip) VALUES ('$url','$url_title','$member_id','$country',3,'$time','$ip')";
	mysqli_query($con, $sql) or die(mysqli_error($con));
	
	$newwallid = mysqli_insert_id($con);
	
	//insert into videos table
	$vquery = "INSERT INTO videos (location,title,user_id,type,url_type,date_created,msg_id,country_id) 
			VALUES('$url','$url_title','$member_id','0','2','$time','$newwallid','$country_id')";
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

		header("location: ".$base_url."country_wall.php?country=".$country."");	
		exit();		

}
?> 
