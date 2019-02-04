<?php ob_start();
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

$q="SELECT bleh_id FROM event_wall_like WHERE member_id='$uid' and remarks='$msg_id' ";
if(mysqli_num_rows($q)==0)
{
$query=mysqli_query($con, "INSERT INTO event_wall_like (remarks,member_id) VALUES('$msg_id','$uid')");

}
}
else
{
//---Unlike----
$query=mysqli_query($con, "DELETE FROM event_wall_like WHERE remarks='$msg_id' and member_id='$uid'");
}
}
?>