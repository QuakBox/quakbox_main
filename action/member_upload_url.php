<?php ob_start();
$member_id = $_POST['member_id'];
include('../config.php');

	$url=$_POST['mylinktext'];
	$url_title=$_POST['title'];
	$country = $_POST['country'];
	$time = time();
	$ip=$_SERVER['REMOTE_ADDR'];
	
if(isset($_POST['mylinktext']))
{
	$sql="INSERT INTO message(messages,url_title,member_id,country_flag,type,date_created,ip) VALUES ('$url','$url_title','$member_id','$country',3,'$time','$ip')";
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
		
		header("location: ".$base_url."mywall.php");			
	exit();
}
?> 
