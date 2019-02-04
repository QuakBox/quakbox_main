<?php ob_start();
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

$q="SELECT * FROM event_wall_comment_like WHERE member_id='$uid' and comment_id='$comment_id' ";
$resultq=mysqli_query($con,$q)
if(mysqli_num_rows($resultq)==0)
{
$query=mysqli_query($con, "INSERT INTO event_wall_comment_like (comment_id,member_id) VALUES('$comment_id','$uid')");

}
}
else
{
//---Unlike----
$query=mysqli_query($con, "DELETE FROM event_wall_comment_like WHERE comment_id='$comment_id' and member_id='$uid'");
}
}
?>