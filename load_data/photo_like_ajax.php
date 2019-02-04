<?php session_start();
include '../config.php';
if(isSet($_POST['msg_id']) && isSet($_POST['rel']))
{
$msg_id=mysqli_real_escape_string($con, f($_POST['msg_id'],'escapeAll'));
$rel=mysqli_real_escape_string($con, f($_POST['rel'],'escapeAll'));
$member_id = $_SESSION['SESS_MEMBER_ID'];
$uid=$member_id; // User login session id
if($rel=='Like')
{
//---Like----
echo $q="SELECT upload_data_like_id FROM upload_data_like WHERE upload_data_user_id='".$uid."' and upload_data_item_id='$msg_id' ";
if(mysqli_num_rows($q)==0)
{
$query=mysqli_query($con, "INSERT INTO upload_data_like (upload_data_item_id,upload_data_user_id) VALUES('$msg_id','$uid')");
$q=mysqli_query($con, "UPDATE upload_data SET like_count = like_count+1 WHERE upload_data_id='$msg_id'") ;
$g=mysqli_query($con, "SELECT like_count FROM upload_data WHERE upload_data_id='$msg_id'");
$d=mysqli_fetch_array($g);
echo $d['like_count'];
}
}
else
{
//---Unlike----
$q=mysqli_query($con, "SELECT upload_data_like_id FROM upload_data_like WHERE upload_data_user_id='$uid' and upload_data_item_id='$msg_id' ");
if(mysqli_num_rows($q)>0)
{
$query=mysqli_query($con, "DELETE FROM upload_data_like WHERE upload_data_item_id='$msg_id' and upload_data_user_id='$uid'");
$q=mysqli_query($con, "UPDATE upload_data SET like_count=like_count-1 WHERE upload_data_id='$msg_id'");
$g=mysqli_query($con, "SELECT like_count FROM upload_data WHERE upload_data_id='$msg_id'");
$d=mysqli_fetch_array($g);
echo $d['like_count'];
}
}
}
?>