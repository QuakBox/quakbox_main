<?php
include ('../config.php');
session_start();
if(isset($_POST['reply_id']) && isset($_POST['rel']))
{
$comment_id       = mysqli_real_escape_string($con, f($_POST['reply_id'],'escapeAll'));
$rel              = mysqli_real_escape_string($con, f($_POST['rel'],'escapeAll'));
$time             = time();
$uid              = $_SESSION['SESS_MEMBER_ID']; // User login session id
$dislike_count    = '';

if($rel=='Like')
{
//---Like----
$member_sql = mysqli_query($con, "select * from members where member_id='$uid'");
$member_res = mysqli_fetch_array($member_sql);

//dislike data fetch using following query
$dislikequery = "SELECT * FROM groups_wall_reply_dislike WHERE member_id='$uid' and reply_id='$comment_id'";
$dislikesql = mysqli_query($con, $dislikequery);

//like data fetch using following query
$likequery = "SELECT * FROM groups_wall_reply_like WHERE member_id='$uid' and reply_id='$comment_id'";
$likesql = mysqli_query($con, $likequery);

$q=mysqli_query($con, "SELECT * FROM groups_wall_reply_like WHERE member_id='$uid' and reply_id='$comment_id' ");
mysqli_num_rows($q);
if(mysqli_num_rows($q)==0)
{
$query=mysqli_query($con, "INSERT INTO groups_wall_reply_like (reply_id,member_id,created) VALUES('$comment_id','$uid','$time')");

$g = mysqli_query($con, "SELECT like_id FROM groups_wall_reply_like WHERE reply_id = '$comment_id'");
$like_count = mysqli_num_rows($g);

if(mysqli_num_rows($dislikesql) > 0) {
		$query=mysqli_query($con, "DELETE FROM groups_wall_reply_dislike WHERE reply_id='$comment_id' and member_id='$uid'");			
	$h = mysqli_query($con, "SELECT dislike_id FROM groups_wall_reply_dislike WHERE reply_id = '$comment_id'");
	$dislike_count = mysqli_num_rows($h);	
}

}
}
else
{
//---Unlike----
$query=mysqli_query($con, "DELETE FROM groups_wall_reply_like WHERE reply_id='$comment_id' and member_id='$uid'");
$g = mysqli_query($con, "SELECT like_id FROM groups_wall_reply_like WHERE reply_id = '$comment_id'");
$like_count = mysqli_num_rows($g);
}
// Lets say everything is in order
    $output = array('likecount' => $like_count,'dislikecount' => $dislike_count);
    echo json_encode($output);
}
?>