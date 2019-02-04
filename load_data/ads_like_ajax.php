<?php
//error_reporting(0);
include ('../config.php');
session_start();
if(!isset($_SESSION['SESS_MEMBER_ID']))
	{	
	
    echo "expired";
		
		
	}
	else
	{

if(isSet($_POST['msg_id']) && isSet($_POST['rel']))
{
$msg_id=mysqli_real_escape_string($con, f($_POST['msg_id'],'escapeAll'));
$rel=mysqli_real_escape_string($con, f($_POST['rel'],'escapeAll'));
$uid=$_SESSION['SESS_MEMBER_ID']; // User login session id
if($rel=='Like')
{
//---Like----

$q=mysqli_query($con, "SELECT ads_id FROM ads_like WHERE member_id='$uid' and ads_id='$msg_id' ");
if(mysqli_num_rows($q)==0)
{
$query=mysqli_query($con, "INSERT INTO ads_like (ads_id,member_id) VALUES('$msg_id','$uid')") or die(mysqli_error($con));
}
}
else
{
//---Unlike----
$query=mysqli_query($con, "DELETE FROM ads_like WHERE ads_id='$msg_id' and member_id='$uid'");
}

$g=mysqli_query($con, "SELECT ads_like_id FROM ads_like WHERE ads_id='$msg_id'");
$d=mysqli_num_rows($g);
echo $d;
}}
?>