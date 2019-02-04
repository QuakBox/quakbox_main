<?php
//error_reporting(0);
include ('../config.php');
session_start();

if(!isset($_SESSION['SESS_MEMBER_ID']))
	{	
	$like_count="expired";
	$dislike_count="expired";
		 $output = array('likecount' => $like_count,'dislikecount' => $dislike_count);
    echo json_encode($output);
		
		
	}
	else
	{

if(isset($_POST['comment_id']) && isset($_POST['rel'])) {
	$msg_id     = mysqli_real_escape_string($con, f($_POST['comment_id'],'escapeAll'));
	$rel        = mysqli_real_escape_string($con, f($_POST['rel'],'escapeAll'));
	$uid        = $_SESSION['SESS_MEMBER_ID']; // User login session id
	$time       = time();
	$like_count = '';
	
if($rel=='disLike') {
//---dislike----
$member_sql = mysqli_query($con, "select * from members where member_id='$uid'");
$member_res = mysqli_fetch_array($member_sql);

$q=mysqli_query($con, "SELECT dislike_comment_id FROM comment_dislike WHERE member_id='$uid' and comment_id='$msg_id'");

//dislike data fetch using following query
$dislikequery = "SELECT * FROM comment_dislike WHERE member_id='$uid' and comment_id='$msg_id'";
$dislikesql = mysqli_query($con, $dislikequery);

//like data fetch using following query
$likequery = "SELECT * FROM comment_like WHERE member_id='$uid' and comment_id='$msg_id'";
$likesql = mysqli_query($con, $likequery);

$h = mysqli_query($con, "SELECT like_id FROM comment_like WHERE comment_id = '$msg_id'");
	$like_count = mysqli_num_rows($h);
	//echo $like_count;
	
if(mysqli_num_rows($q)==0) {
	$query = mysqli_query($con, "INSERT INTO comment_dislike (comment_id,member_id,created) VALUES('$msg_id','$uid','$time')");
	$g = mysqli_query($con, "SELECT dislike_comment_id FROM comment_dislike WHERE comment_id = '$msg_id'");
	$dislike_count = mysqli_num_rows($g);
	
	if(mysqli_num_rows($likesql) > 0) {
		$query=mysqli_query($con, "DELETE FROM comment_like WHERE comment_id='$msg_id' and member_id='$uid'");			
	$h = mysqli_query($con, "SELECT like_id FROM comment_like WHERE comment_id = '$msg_id'");
	$like_count = mysqli_num_rows($h);
	//echo $like_count;	
}
}
else {
	$query = mysqli_query($con, "DELETE FROM comment_dislike WHERE comment_id='$msg_id' and member_id='$uid'");
    $g = mysqli_query($con, "SELECT dislike_comment_id FROM comment_dislike WHERE comment_id='$msg_id'");    
	$dislike_count = mysqli_num_rows($g);	
	
}


}
 // Lets say everything is in order
    $output = array('likecount' => $like_count,'dislikecount' => $dislike_count);
    header('Content-type: application/json');
    echo json_encode($output);
}
}
?>