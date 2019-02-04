<?php ob_start();
include_once('../config.php');

$member_id = $_REQUEST['member_id'];
$messages = $_REQUEST['postcomment'];
$postid =$_REQUEST['postid'];
$type = $_REQUEST['type'];

echo $sql="INSERT INTO groups_wall_comment (post_member_id,msg_id,content, type, date_created)
VALUES
('$member_id','$postid','$messages','$type','".strtotime(date("Y-m-d H:i:s"))."')";

mysqli_query($con, $sql);
		$url = $_SERVER['HTTP_REFERER'];
header("location: ".$url."");	
exit();

?>

