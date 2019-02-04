<?php
include ('../config.php');
session_start();
if(isset($_POST['id']))
{
$id       = f($_POST['id'],'escapeAll');
$id       = mysqli_real_escape_string($con, $id);
$rel      = f($_POST['rel'],'escapeAll');
$rel      = mysqli_real_escape_string($con, $rel);
$uid      = $_SESSION['SESS_MEMBER_ID']; // User login session id
$count    = '';

$member_sql = mysqli_query($con, "select id from videos_subscribe WHERE member_id = '$id' AND subscriber_member_id = '$uid'");
$member_res = mysqli_fetch_array($member_sql);
$sub_count = mysqli_num_rows($member_sql); 
if($rel == 'subscribe')
{
//---Like----

if($sub_count == 0){
mysqli_query($con, "INSERT INTO videos_subscribe (member_id,subscriber_member_id) VALUES('$id', '$uid')");
}
}
else
{
	if($sub_count > 0){
	mysqli_query($con, "DELETE FROM videos_subscribe WHERE member_id = '$id' AND subscriber_member_id = '$uid'");
	}
}
//dislike data fetch using following query
$unsubquery = "SELECT * FROM videos_subscribe WHERE member_id='$id'";
$unsubsql = mysqli_query($con, $unsubquery);
echo $count = mysqli_num_rows($unsubsql);
}
?>