<?php ob_start();
session_start();
require_once('../config.php');
$session_uid = $_SESSION['SESS_MEMBER_ID'];
$id = mysqli_real_escape_string($con, f($_REQUEST['id'],'escapeAll'));
if(empty($id)){
	exit();
}
$sqlforthumburl = mysqli_query($con, "select * from videos where video_id = '$id' AND user_id = '$session_uid'");
if(mysqli_num_rows($sqlforthumburl) == 0){
	exit();
}
$mres1 = mysqli_fetch_array($sqlforthumburl);

$msql = mysqli_query($con, "select * from message where video_id = '$id'");
$mres = mysqli_fetch_array($msql);
$messages_id = $mres['messages_id'];

$parent_id = $mres1['parent_id'];

$parent_sql = mysqli_query($con, "SELECT video_id FROM videos WHERE parent_id = '$parent_id'");
$parent_count = mysqli_num_rows($parent_sql);
//fetch videos files url
$urlforMP4 = '../'.$mres1['location'];
$urlforOGG = '../'.$mres1['location1'];
$urlforWEBM = '../'.$mres1['location2'];
//fetch video thumb files url
$pathforthumbimagep400x2251 = '../uploadedvideo/videothumb/p400x225'.$mres1['thumburl1'];
$pathforthumbimagep200x1501 = '../uploadedvideo/videothumb/p200x150'.$mres1['thumburl1'];
$pathforthumbimagep400x2252 = '../uploadedvideo/videothumb/p400x225'.$mres1['thumburl2'];
$pathforthumbimagep200x1502 = '../uploadedvideo/videothumb/p200x150'.$mres1['thumburl2'];
$pathforthumbimagep400x2253 = '../uploadedvideo/videothumb/p400x225'.$mres1['thumburl3'];
$pathforthumbimagep200x1503 = '../uploadedvideo/videothumb/p200x150'.$mres1['thumburl3'];
$pathforthumbimagep400x2254 = '../uploadedvideo/videothumb/p400x225'.$mres1['thumburl4'];
$pathforthumbimagep200x1504 = '../uploadedvideo/videothumb/p200x150'.$mres1['thumburl4'];
$pathforthumbimagep400x2255 = '../uploadedvideo/videothumb/p400x225'.$mres1['thumburl5'];
$pathforthumbimagep200x1505 = '../uploadedvideo/videothumb/p200x150'.$mres1['thumburl5'];
$pathforthumbimagep400x2256 = '../uploadedvideo/videothumb/p400x225'.$mres1['custom_thumb'];
$pathforthumbimagep200x1506 = '../uploadedvideo/videothumb/p200x150'.$mres1['custom_thumb'];

if($parent_count == 1){
//remove videos file from server
@unlink($urlforMP4);
@unlink($urlforOGG);
@unlink($urlforWEBM);

//remove videos thumb file from server
@unlink($pathforthumbimagep400x2251);
@unlink($pathforthumbimagep200x1501);
@unlink($pathforthumbimagep400x2252);
@unlink($pathforthumbimagep200x1502);
@unlink($pathforthumbimagep400x2253);
@unlink($pathforthumbimagep200x1503);
@unlink($pathforthumbimagep400x2254);
@unlink($pathforthumbimagep200x1504);
@unlink($pathforthumbimagep400x2255);
@unlink($pathforthumbimagep200x1505);
unlink($pathforthumbimagep400x2256);
unlink($pathforthumbimagep200x1506);
}
if(mysqli_num_rows($msql) > 0)
{
$csql = mysqli_query($con, "select comment_id from postcomment where msg_id = '$messages_id'");
$cres = mysqli_fetch_array($csql);
$comment_id = $cres['comment_id'];

$rsql = mysqli_query($con, "select reply_id from comment_reply where comment_id = '$comment_id'");
$rres = mysqli_fetch_array($csql);
$reply_id = $cres['comment_id'];

mysqli_query($con, "DELETE FROM message WHERE messages_id='$messages_id'");
mysqli_query($con, "DELETE FROM postcomment WHERE msg_id='$messages_id'");
mysqli_query($con, "DELETE FROM bleh WHERE remarks='$messages_id'");
mysqli_query($con, "DELETE FROM comment_like WHERE comment_id='$comment_id'");
mysqli_query($con, "DELETE FROM comment_reply WHERE comment_id='$comment_id'");
mysqli_query($con, "DELETE FROM comment_report WHERE msg_id='$messages_id'");
}
mysqli_query($con, "DELETE FROM videos_views WHERE video_id='$id'");
mysqli_query($con, "DELETE FROM videos WHERE video_id='$id'");

$url = $_SERVER['HTTP_REFERER'];
header("location: ".$url."");
exit();

?>