<?php
session_start ();
include ("config.php");

if (isset ( $_POST ['submit'] )) {
	
	$comment_report_id = $_POST['comment_report_id'];
	$message_id = $_POST['message_id'];
	$report_testing = $_POST ['report_testing'];
	$members_id = $_POST ['members_id'];
	$status = $_POST['status'];
  
  $updateReportQuery = "UPDATE `comment_report` SET 
		`msg_id`='$message_id',
		`report`='$report_testing',
		`member_id`='$members_id',
		`status` = '$status'
		 WHERE `id` = '$comment_report_id'";
  //exit( $updateReportQuery );
  
  mysqli_query ( $conn, $updateReportQuery );

  header ( "location:comment_report.php" );
}

?>
