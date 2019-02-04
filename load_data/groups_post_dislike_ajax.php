<?php
include ('../config.php');
session_start();
if(isset($_POST['msg_id']) && isset($_POST['rel'])) {
	$msg_id     = mysqli_real_escape_string($con, f($_POST['msg_id'],'escapeAll'));
	$rel        = mysqli_real_escape_string($con, f($_POST['rel'],'escapeAll'));
	$uid        = $_SESSION['SESS_MEMBER_ID']; // User login session id
	$time       = time();
	$like_count = '';
if($rel=='disLike') {
//---dislike----
$member_sql = mysqli_query($con, "select * from members where member_id='$uid'");
$member_res = mysqli_fetch_array($member_sql);

$q = mysqli_query($con, "SELECT dislike_id FROM groups_wall_dislike WHERE member_id='$uid' and msg_id='$msg_id' ");

//dislike data fetch using following query
$dislikequery = "SELECT * FROM groups_wall_dislike WHERE member_id='$uid' and msg_id='$msg_id'";
$dislikesql = mysqli_query($con, $dislikequery);

//like data fetch using following query
$likequery = "SELECT * FROM groups_wall_like WHERE member_id='$uid' and remarks='$msg_id'";
$likesql = mysqli_query($con, $likequery);
mysqli_num_rows($q);
if(mysqli_num_rows($q) == 0) {
	$query = mysqli_query($con, "INSERT INTO groups_wall_dislike (msg_id,member_id) VALUES('$msg_id','$uid')");
	$g = mysqli_query($con, "SELECT dislike_id FROM groups_wall_dislike WHERE msg_id = '$msg_id'");
	$dislike_count = mysqli_num_rows($g);
	
	if(mysqli_num_rows($likesql) > 0) {
		$query=mysqli_query($con, "DELETE FROM groups_wall_like WHERE remarks='$msg_id' and member_id='$uid'");			
		$h = mysqli_query($con, "SELECT bleh_id FROM groups_wall_like WHERE remarks = '$msg_id'");
		$like_count = mysqli_num_rows($h);	
	}
}
else {
	$query = mysqli_query($con, "DELETE FROM groups_wall_dislike WHERE msg_id='$msg_id' and member_id='$uid'");
    $g = mysqli_query($con, "SELECT dislike_id FROM groups_wall_dislike WHERE msg_id='$msg_id'");    
	$dislike_count = mysqli_num_rows($g);	
	
}


}
 // Lets say everything is in order
    $output = array('likecount' => $like_count,'dislikecount' => $dislike_count);
    echo json_encode($output);
}

?>