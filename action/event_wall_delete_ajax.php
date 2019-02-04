<?php ob_start();
include_once('../config.php');
$messages_id = mysqli_real_escape_string($con, f($_POST['msg_id'],'escapeAll'));
$uid=$_SESSION['SESS_MEMBER_ID']; // User login session id
$msql = mysqli_query($con, "select * from event_wall where messages_id = '$messages_id' AND $member_id = '$uid'");
if(mysqli_num_rows($msql) > 0){
	exit();
}
$mres = mysqli_fetch_array($msql);
$messages_id = $mres['messages_id'];
$url = '../'.$mres['messages'];

$csql = mysqli_query($con, "select * from event_wall_comment where msg_id = '$messages_id'");
while($cres = mysqli_fetch_array($csql))
{
$comment_id = $cres['comment_id'];
$rsql = mysqli_query($con, "select * from event_wall_comment_reply where comment_id = '$comment_id'");
while($rres = mysqli_fetch_array($rsql))
{

$sql1=mysqli_query($con, "select * from event_wall_reply_reply WHERE reply_id='$rres[reply_id]'");
while($reply1=mysqli_fetch_array($sql1))
{


$responce2 = mysqli_query($con, "DELETE FROM reply_reply1 WHERE msg_id='$reply1[id]'") or die(mysqli_error($con));
}
$responce5 = mysqli_query($con, "DELETE FROM event_wall_reply_reply WHERE reply_id='$rres[reply_id]'") or die(mysqli_error($con));
$responce4 = mysqli_query($con, "DELETE FROM comment_reply1 WHERE msg_id='$rres[reply_id]'") or die(mysqli_error($con));
}
$responce3= mysqli_query($con, "DELETE FROM event_wall_comment_reply WHERE comment_id='$comment_id'") or die(mysqli_error($con));
$responce1 = mysqli_query($con, "DELETE FROM postcomment1 WHERE msg_id='$comment_id'") or die(mysqli_error($con));
mysqli_query($con, "DELETE FROM event_wall_comment_like WHERE comment_id='$comment_id'")or die(mysqli_error($con));
mysqli_query($con, "DELETE FROM event_wall_comment_reply WHERE comment_id='$comment_id'")or die(mysqli_error($con));
}









$thumbsql = mysqli_query($con, "select * from event_videos where msg_id = '$messages_id'");
$thumbres = mysqli_fetch_array($thumbsql);
$parent_id = $thumbres['parent_id'];

$parent_sql = mysqli_query($con, "SELECT video_id FROM event_videos WHERE parent_id = '$parent_id'");
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






mysqli_query($con, "DELETE FROM event_wall WHERE messages_id='$messages_id'");
mysqli_query($con, "DELETE FROM message1 WHERE msg_id='$messages_id'");


mysqli_query($con, "DELETE FROM event_wall_like WHERE remarks='$messages_id'");

mysqli_query($con, "DELETE FROM event_wall_report WHERE msg_id='$messages_id'");
mysqli_query($con, "DELETE FROM event_videos WHERE msg_id = '$messages_id'");
mysqli_query($con, "DELETE FROM uplolad_data WHERE msg_id = '$messages_id'");

$thumbmessage = mysqli_query($con, "SELECT messages_id FROM event_wall WHERE messages='".$mres['messages']."'");
$thumbcount = mysqli_num_rows($thumbmessage);
if($thumbcount == 1){
unlink($url);
}
?>