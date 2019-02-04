<?php
include_once('../config.php');
$messages_id = $_POST['msg_id'];
$messages_id	 = 	f($messages_id, 'strip');
$messages_id	 = 	f($messages_id, 'escapeAll');
$messages_id   = mysqli_real_escape_string($con, $messages_id);

$msql = mysqli_query($con, "select * from groups_wall where messages_id = '$messages_id'");
$mres = mysqli_fetch_array($msql);
$messages_id = $mres['messages_id'];
$url = '../'.$mres['messages'];

$csql = mysqli_query($con, "select comment_id from groups_wall_comment where msg_id = '$messages_id'");
$cres = mysqli_fetch_array($csql);
$comment_id = $cres['comment_id'];

$thumbsql = mysqli_query($con, "select * from videos where msg_id = '$messages_id'");
$thumbres = mysqli_fetch_array($thumbsql);
$parent_id = $thumbres['parent_id'];

$parent_sql = mysqli_query($con, "SELECT video_id FROM videos WHERE parent_id = '$parent_id'");
$parent_count = mysqli_num_rows($parent_sql);

//fetch videos files url
$urlforMP4 = '../'.$thumbres['location'];
$urlforOGG = '../'.$thumbres['location1'];
$urlforWEBM = '../'.$thumbres['location2'];
//fetch video thumb files url
$pathforthumbimage1 = '../'.$thumbres['thumburl1'];
$pathforthumbimage2 = '../'.$thumbres['thumburl2'];
$pathforthumbimage3 = '../'.$thumbres['thumburl3'];
if($parent_count == 1){
//remove videos file from server
@unlink($urlforMP4);
@unlink($urlforOGG);
@unlink($urlforWEBM);

//remove videos thumb file from server
@unlink($pathforthumbimage1);
@unlink($pathforthumbimage2);
@unlink($pathforthumbimage3);
}

$rsql = mysqli_query($con, "select reply_id from groups_wall_reply where comment_id = '$comment_id'");
$rres = mysqli_fetch_array($rsql);
$reply_id = $rres['comment_id'];

mysqli_query($con, "DELETE FROM groups_wall WHERE messages_id='$messages_id'");
mysqli_query($con, "DELETE FROM groups_wall_comment WHERE msg_id='$messages_id'");
mysqli_query($con, "DELETE FROM groups_wall_like WHERE remarks='$messages_id'");
mysqli_query($con, "DELETE FROM groups_wall_comment_like WHERE comment_id='$comment_id'");
mysqli_query($con, "DELETE FROM groups_wall__reply WHERE comment_id='$comment_id'");
mysqli_query($con, "DELETE FROM comment_report WHERE msg_id='$messages_id'");
mysqli_query($con, "DELETE FROM videos WHERE msg_id = '$messages_id'");
mysqli_query($con, "DELETE FROM uplolad_data WHERE msg_id = '$messages_id'");

$thumbmessage = mysqli_query($con, "SELECT messages_id FROM groups_wall WHERE messages='".$mres['messages']."'");
$thumbcount = mysqli_num_rows($thumbmessage);
if($thumbcount == 1){
unlink($url);
}
?>