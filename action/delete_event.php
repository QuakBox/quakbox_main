<?php ob_start();
require_once('../config.php');
$event_id = mysqli_real_escape_string($con, f($_REQUEST['id'],'escapeAll'));
$country_code = mysqli_real_escape_string($con, f($_REQUEST['country'],'escapeAll'));
if(empty($event_id)){
	exit();
}
$wsql = mysqli_query($con, "SELECT messages_id FROM event_wall WHERE event_id = '$event_id'");;
echo "SELECT messages_id FROM event_wall WHERE event_id = '$event_id'","<br>";
if(mysqli_num_rows($wsql) == 0){
	$sql = "delete from event where id='$event_id'";
$responce = mysqli_query($con, $sql);

header("location: ".$base_url."country_event.php?country=".$country_code);
exit();
}
else
{
$wres = mysqli_fetch_array($wsql);
$messages_id = $wres['messages_id'];

$csql = mysqli_query($con, "select comment_id from event_wall_comment where msg_id = '$messages_id'");
echo "select comment_id from event_wall_comment where msg_id = '$messages_id'","<br>";
$cres = mysqli_fetch_array($csql);
$comment_id = $cres['comment_id'];

$rsql = mysqli_query($con, "select reply_id from event_wall_comment_reply where comment_id = '$comment_id'");
echo "select reply_id from event_wall_comment_reply where comment_id = '$comment_id'","<br>";
$rres = mysqli_fetch_array($csql);
$reply_id = $cres['comment_id'];

mysqli_query($con, "DELETE FROM event_wall WHERE messages_id='$messages_id'");
mysqli_query($con, "DELETE FROM event_wall_comment WHERE msg_id='$messages_id'");
mysqli_query($con, "DELETE FROM event_wall_like WHERE remarks='$messages_id'");
mysqli_query($con,"DELETE FROM event_wall_comment_like WHERE comment_id='$comment_id'");
mysqli_query($con,"DELETE FROM event_wall_comment_reply WHERE comment_id='$comment_id'");
mysqli_query($con,"DELETE FROM event_wall_report WHERE msg_id='$messages_id'");
mysqli_query($con,"DELETE FROM event_members WHERE event_id='$event_id'");

$sql = "delete from event where id='$event_id'";
$responce = mysqli_query($con, $sql);

header("location: ".$base_url."country_event.php?country=".$country_code);
exit();
}
?>