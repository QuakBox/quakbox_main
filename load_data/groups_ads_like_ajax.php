<?php
include ('../config.php');
session_start();
if(isSet($_POST['msg_id']) && isSet($_POST['rel']))
{
$msg_id=mysqli_real_escape_string($con, f($_POST['msg_id'],'escapeAll'));
$rel=mysqli_real_escape_string($con, f($_POST['rel'],'escapeAll'));
$uid=$_SESSION['SESS_MEMBER_ID']; // User login session id
if($rel=='Like')
{
//---Like----

$q="SELECT ads_id FROM ads_like WHERE member_id='$uid' and ads_id='$msg_id' ";
if(mysqli_num_rows($q)==0)
{
$query=mysqli_query($con, "INSERT INTO groups_wall_ads_like (ads_id,member_id) VALUES('$msg_id','$uid')") or die(mysqli_error($con));
//$q=mysqli_query("UPDATE messages SET like_count = like_count+1 WHERE msg_id='$msg_id'") ;
//$g=mysqli_query("SELECT like_count FROM messages WHERE msg_id='$msg_id'");
//$d=mysqli_fetch_array($g);
//echo $d['like_count'];
}
}
else
{
//---Unlike----
$query=mysqli_query($con, "DELETE FROM groups_wall_ads_like WHERE ads_id='$msg_id' and member_id='$uid'");
//$q=mysqli_query("UPDATE messages SET like_count=like_count-1 WHERE msg_id='$msg_id'");
//$g=mysqli_query("SELECT like_count FROM messages WHERE msg_id='$msg_id'");
//$d=mysqli_fetch_array($g);
//echo $d['like_count'];
}
}
?>