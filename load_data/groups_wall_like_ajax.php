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

$q=mysqli_query($con, "SELECT bleh_id FROM groups_wall_like WHERE member_id='$uid' and remarks='$msg_id' ");
if(mysqli_num_rows($q)==0)
{
$query=mysqli_query($con, "INSERT INTO groups_wall_like (remarks,member_id) VALUES('$msg_id','$uid')");
//$q=mysqli_query("UPDATE messages SET like_count = like_count+1 WHERE msg_id='$msg_id'") ;
//$g=mysqli_query("SELECT like_count FROM messages WHERE msg_id='$msg_id'");
//$d=mysqli_fetch_array($g);
//echo $d['like_count'];
}
}
else
{
//---Unlike----
$query=mysqli_query($con, "DELETE FROM groups_wall_like WHERE remarks='$msg_id' and member_id='$uid'");
//$q=mysqli_query("UPDATE messages SET like_count=like_count-1 WHERE msg_id='$msg_id'");
//$g=mysqli_query("SELECT like_count FROM messages WHERE msg_id='$msg_id'");
//$d=mysqli_fetch_array($g);
//echo $d['like_count'];
}
}
?>