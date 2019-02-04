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
echo $q="SELECT pcl_id FROM photo_comments_like WHERE photo_comment_user_id='".$uid."' and photo_comment_id='$msg_id' ";
if(mysqli_num_rows($q)==0)
{
$query=mysqli_query($con, "INSERT INTO photo_comments_like (photo_comment_id,photo_comment_user_id) VALUES('$msg_id','$uid')");
$q=mysqli_query($con, "UPDATE photo_comments SET like_count = like_count+1 WHERE c_id='$msg_id'") ;
$g=mysqli_query($con, "SELECT like_count FROM photo_comments WHERE c_id='$msg_id'");
$d=mysqli_fetch_array($g);
echo $d['like_count'];
}
}
else
{
//---Unlike----
$q=mysqli_query($con, "SELECT pcl_id FROM photo_comments_like WHERE photo_comment_user_id='$uid' and photo_comment_id='$msg_id' ");
if(mysqli_num_rows($q)>0)
{
$query=mysqli_query($con, "DELETE FROM photo_comments_like WHERE photo_comment_id='$msg_id' and photo_comment_user_id='$uid'");
$q=mysqli_query($con, "UPDATE photo_comments SET like_count=like_count-1 WHERE c_id='$msg_id'");
$g=mysqli_query($con, "SELECT like_count FROM photo_comments WHERE c_id='$msg_id'");
$d=mysqli_fetch_array($g);
echo $d['like_count'];
}
}
}
?>