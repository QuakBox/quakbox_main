<?php ob_start();

include_once('../config.php');

$member_id = $_REQUEST['member_id'];
$member_id	 = 	f($member_id, 'strip');
$member_id	 = 	f($member_id, 'escapeAll');
$member_id   = mysqli_real_escape_string($con, $member_id);

$messages = $_REQUEST['postcomment'];
$messages	 = 	f($messages, 'strip');
$messages	 = 	f($messages, 'escapeAll');
$messages   = mysqli_real_escape_string($con, $messages);

$postid =$_REQUEST['postid'];
$postid	 = 	f($postid, 'strip');
$postid	 = 	f($postid, 'escapeAll');
$postid   = mysqli_real_escape_string($con, $postid);

$type = $_REQUEST['type'];
$type	 = 	f($type, 'strip');
$type	 = 	f($type, 'escapeAll');
$type   = mysqli_real_escape_string($con, $type);

echo $sql="INSERT INTO groups_wall_comment (post_member_id,msg_id,content, type, date_created)
VALUES
('$member_id','$postid','$messages','$type','".strtotime(date("Y-m-d H:i:s"))."')";

mysqli_query($con, $sql);
		$url = $_SERVER['HTTP_REFERER'];
header("location: ".$url."");	
exit();

?>

