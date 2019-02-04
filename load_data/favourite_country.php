<?php
include ('../config.php');
session_start();
if(isSet($_POST['comment_id']) && isSet($_POST['rel']))
{
$comment_id=mysqli_real_escape_string($con, f($_POST['comment_id'],'escapeAll'));
$rel=mysqli_real_escape_string($con, f($_POST['rel'],'escapeAll'));
$uid=$_SESSION['SESS_MEMBER_ID']; // User login session id
if($rel=='Like')
{
//---Like----

$q="SELECT * FROM comment_like WHERE member_id='$uid' and comment_id='$comment_id' ";
if(mysqli_num_rows($q)==0)
{
$query=mysqli_query($con, "INSERT INTO comment_like (comment_id,member_id) VALUES('$comment_id','$uid')");
//$q=mysqli_query("UPDATE messages SET like_count = like_count+1 WHERE msg_id='$msg_id'") ;
//$g=mysqli_query("SELECT like_count FROM messages WHERE msg_id='$msg_id'");
//$d=mysqli_fetch_array($g);
//echo $d['like_count'];
}
}
else
{
//---Unlike----
$query=mysqli_query($con, "DELETE FROM comment_like WHERE comment_id='$comment_id' and member_id='$uid'");
//$q=mysqli_query("UPDATE messages SET like_count=like_count-1 WHERE msg_id='$msg_id'");
//$g=mysqli_query("SELECT like_count FROM messages WHERE msg_id='$msg_id'");
//$d=mysqli_fetch_array($g);
//echo $d['like_count'];
}
}
?>