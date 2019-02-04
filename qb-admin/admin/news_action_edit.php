<?php
session_start ();
include ("config.php");

if (isset ( $_POST ['submit'] )) {
	$news_id = $_POST['news_id'];
	$title_name = $_POST['title_name'];
	$category_id = $_POST ['category_id'];
	$members_id = $_POST ['members_id'];
	$country_id = $_POST ['country_id'];
	$url = $_POST['url'];
	$image_url = $_POST['image_url'];
	$video_url = $_POST['video_url'];
	$status = $_POST['status'];
	
  
  $updateNewsQuery = "UPDATE `news` SET 
		`title`='$title_name',
		`category_id`='$category_id',
		`member_id`='$members_id',
		`country_id`='$country_id',
		`url`='$url',
		`image_url`='$image_url',
		`video_url`='$video_url',
		`status`	= '$status'
		 WHERE `news_id` = '$news_id'";
  mysqli_query ($conn, $updateNewsQuery );

  header ( "location:newstable.php" );
}

?>
