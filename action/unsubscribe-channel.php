<?php
include ('../config.php');
session_start();
if(isset($_POST['id']))
{
$id = f($_POST['id'], 'strip');
$id = f($id , 'escapeAll');
$id       = mysqli_real_escape_string($con, $id);
$uid      = $_SESSION['SESS_MEMBER_ID']; // User login session id
$count    = '';

//---Like----
$member_sql = mysqli_query($con, "select * from members where member_id='$uid'");
$member_res = mysqli_fetch_array($member_sql);

mysqli_query($con, "DELETE FROM videos_subscribe WHERE member_id = '$id' AND subscriber_member_id = '$uid'");

//dislike data fetch using following query
$unsubquery = "SELECT * FROM videos_subscribe WHERE member_id='$id'";
$unsubsql = mysqli_query($con, $unsubquery);
echo $count = mysqli_num_rows($unsubsql);
}
?>