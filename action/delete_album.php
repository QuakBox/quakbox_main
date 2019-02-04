<?php 
//error_reporting(0);
ob_start();
include_once('../config.php');
$album_id = mysqli_real_escape_string($con, f($_REQUEST['msg_id'],'escapeAll'));
if(empty($album_id)){
	exit();
}
$uasql = mysqli_query($con, "SELECT album_user_id FROM user_album WHERE album_id = '$album_id'");
 
if(mysqli_num_rows($uasql) == 0){
	exit();
}
$uares = mysqli_fetch_array($uasql);
$memer_id = $uares['album_user_id'];

$usql = mysqli_query($con, "SELECT username FROM members WHERE member_id = '$memer_id'");
$ures = mysqli_fetch_array($usql);
$username  = $ures['username'];

$msql = mysqli_query($con, "select * from message where msg_album_id = '$album_id'");
$mres = mysqli_fetch_array($msql);
$messages_id = $mres['messages_id'];
$msgcount = mysqli_num_rows($msql);
$url = '../'.$mres['messages'];

$csql = mysqli_query($con, "select comment_id from postcomment where msg_id = '$messages_id'");
$cres = mysqli_fetch_array($csql);
$comment_id = $cres['comment_id'];

$rsql = mysqli_query($con, "select reply_id from comment_reply where comment_id = '$comment_id'");
$rres = mysqli_fetch_array($csql);
$reply_id = $cres['comment_id'];



mysqli_query($con, "DELETE FROM postcomment WHERE msg_id='$messages_id'");
mysqli_query($con,"DELETE FROM bleh WHERE remarks='$messages_id'");
mysqli_query($con,"DELETE FROM comment_like WHERE comment_id='$comment_id'");
mysqli_query($con,"DELETE FROM comment_reply WHERE comment_id='$comment_id'");
mysqli_query($con,"DELETE FROM comment_report WHERE msg_id='$messages_id'");

$dsql = "DELETE ua.*,u.*,msg.*
FROM user_album ua JOIN upload_data u ON ua.album_id = u.album_id 
JOIN message msg ON ua.album_id = msg.msg_album_id 
WHERE ua.album_id = '$album_id'";

mysqli_query($con, $dsql) or die(mysqli_error($con));
unlink($url);
header("Location:" .$_SERVER['HTTP_REFERER']);
exit();
//header("location:".$base_url."photos/".$username."");

?>