<?php ob_start();

session_start();
if(!isset($_SESSION['SESS_MEMBER_ID']))
	{
echo "1";	
	}
	else
	{

include_once('../config.php');

$session_uid = $_SESSION['SESS_MEMBER_ID'];
$messages_id = mysqli_real_escape_string($con, f($_POST['msg_id'],'escapeAll'));
if(empty($messages_id)){
	exit();
}
$msql = mysqli_query($con, "select * from message where messages_id = '$messages_id' AND member_id = '$session_uid'");

if(mysqli_num_rows($msql) == 0){
	exit();
}
$mres = mysqli_fetch_array($msql);
$messages_id = $mres['messages_id'];
$url = '../'.$mres['messages'];
$share_id = $mres['share_id'];
if($share_id==0)
{ 
//this is the orginal post
//this will delete shared post
$smsql = mysqli_query($con, "select * from message where share_id = '$messages_id'");
$share_count = mysqli_num_rows($smsql);

//delete all share post related that post
if($share_count > 0){
		while($smres = mysqli_fetch_array($smsql)){
		$share_msg_id = $smres['messages_id'];
		
		//delete post
		mysqli_query($con, "DELETE FROM message WHERE messages_id='$share_msg_id'");		
		//delete post like
		mysqli_query($con, "DELETE FROM bleh WHERE remarks='$share_msg_id'");
		//delete post dislike
		mysqli_query($con, "DELETE FROM post_dislike WHERE msg_id='$share_msg_id'");
		//delete post comment
		mysqli_query($con, "DELETE FROM postcomment where msg_id = '$share_msg_id'");	
		//delete post repot
		mysqli_query($con, "DELETE FROM comment_report WHERE msg_id='$share_msg_id'");
		//delete videos
		mysqli_query($con, "DELETE FROM videos WHERE msg_id = '$share_msg_id'");
		//delete post photo
		mysqli_query($con, "DELETE FROM uplolad_data WHERE msg_id = '$share_msg_id'");
		
		//fetch comment id
		$scsql = mysqli_query($con, "select * from postcomment where msg_id = '$share_msg_id'");
		while($scres = mysqli_fetch_array($scsql))
		{
		$scomment_id = $scres['comment_id'];
		$srsql = mysqli_query($con, "select * from comment_reply where comment_id = '$comment_id'");
		while($srres = mysqli_fetch_array($srsql))
		{
		
		$sql1=mysqli_query($con, "select * from reply_reply WHERE reply_id='$rres[reply_id]'");
		while($reply1=mysqli_fetch_array($sql1))
		{
		
		
		$responce2 = mysqli_query($con, "DELETE FROM reply_reply1 WHERE msg_id='$reply1[id]'") or die(mysqli_error($con));
		}
		$responce5 = mysqli_query($con, "DELETE FROM reply_reply WHERE reply_id='$rres[reply_id]'") or die(mysqli_error($con));
		$responce4 = mysqli_query($con,"DELETE FROM comment_reply1 WHERE msg_id='$rres[reply_id]'") or die(mysqli_error($con));
		}
		$responce3= mysqli_query($con, "DELETE FROM comment_reply WHERE comment_id='$comment_id'") or die(mysqli_error($con));
		$responce1 = mysqli_query($con, "DELETE FROM postcomment1 WHERE msg_id='$comment_id'") or die(mysqli_error($con));
		mysqli_query($con, "DELETE FROM comment_like WHERE comment_id='$comment_id'")or die(mysqli_error($con));
		mysqli_query($con, "DELETE FROM comment_reply WHERE comment_id='$comment_id'")or die(mysqli_error($con));
		}
		
	}
}

//this will delete the original post
$csql = mysqli_query($con, "select * from postcomment where msg_id = '$messages_id'");
while($cres = mysqli_fetch_array($csql))
{
$comment_id = $cres['comment_id'];
$rsql = mysqli_query($con, "select * from comment_reply where comment_id = '$comment_id'");
while($rres = mysqli_fetch_array($rsql))
{

$sql1=mysqli_query($con, "select * from reply_reply WHERE reply_id='$rres[reply_id]'");
while($reply1=mysqli_fetch_array($sql1))
{


$responce2 = mysqli_query($con, "DELETE FROM reply_reply1 WHERE msg_id='$reply1[id]'") or die(mysqli_error($con));
}
$responce5 = mysqli_query($con,"DELETE FROM reply_reply WHERE reply_id='$rres[reply_id]'") or die(mysqli_error($con));
$responce4 = mysqli_query($con,"DELETE FROM comment_reply1 WHERE msg_id='$rres[reply_id]'") or die(mysqli_error($con));
}
$responce3= mysqli_query($con,"DELETE FROM comment_reply WHERE comment_id='$comment_id'") or die(mysqli_error($con));
$responce1 = mysqli_query($con,"DELETE FROM postcomment1 WHERE msg_id='$comment_id'") or die(mysqli_error($con));
mysqli_query($con,"DELETE FROM comment_like WHERE comment_id='$comment_id'")or die(mysqli_error($con));
mysqli_query($con,"DELETE FROM comment_reply WHERE comment_id='$comment_id'")or die(mysqli_error($con));
}








//fetch videos thumbs
$thumbsql = mysqli_query($con,"select * from videos where msg_id = '$messages_id'");
$thumbres = mysqli_fetch_array($thumbsql);
$parent_id = $thumbres['parent_id'];

$parent_sql = mysqli_query($con,"SELECT video_id FROM videos WHERE parent_id = '$parent_id'");
$parent_count = mysqli_num_rows($parent_sql);

//fetch videos files url
$urlforMP4 = '../'.$thumbres['location'];
$urlforOGG = '../'.$thumbres['location1'];
$urlforWEBM = '../'.$thumbres['location2'];
//fetch video thumb files url
$pathforthumbimage1 = '../uploadedvideo/videthumb/p400x225'.$thumbres['thumburl1'];
$pathforthumbimage2 = '../uploadedvideo/videthumb/p400x225'.$thumbres['thumburl2'];
$pathforthumbimage3 = '../uploadedvideo/videthumb/p400x225'.$thumbres['thumburl3'];
$pathforthumbimage4 = '../uploadedvideo/videthumb/p400x225'.$thumbres['thumburl4'];
$pathforthumbimage5 = '../uploadedvideo/videthumb/p400x225'.$thumbres['thumburl5'];
$pathforthumbimage6 = '../uploadedvideo/videthumb/p400x225'.$thumbres['custom_thumb'];

$pathforthumbimage7 = '../uploadedvideo/videthumb/p200x150'.$thumbres['thumburl1'];
$pathforthumbimage8 = '../uploadedvideo/videthumb/p200x150'.$thumbres['thumburl2'];
$pathforthumbimage9 = '../uploadedvideo/videthumb/p200x150'.$thumbres['thumburl3'];
$pathforthumbimage10 = '../uploadedvideo/videthumb/p200x150'.$thumbres['thumburl4'];
$pathforthumbimage11 = '../uploadedvideo/videthumb/p200x150'.$thumbres['thumburl5'];
$pathforthumbimage12 = '../uploadedvideo/videthumb/p200x150'.$thumbres['custom_thumb'];


if($parent_count == 1){
//remove videos file from server
@unlink($urlforMP4);
@unlink($urlforOGG);
@unlink($urlforWEBM);

//remove videos thumb file from server
@unlink($pathforthumbimage1);
@unlink($pathforthumbimage2);
@unlink($pathforthumbimage3);
@unlink($pathforthumbimage4);
@unlink($pathforthumbimage5);
@unlink($pathforthumbimage6);

@unlink($pathforthumbimage7);
@unlink($pathforthumbimage8);
@unlink($pathforthumbimage9);
@unlink($pathforthumbimage10);
@unlink($pathforthumbimage11);
@unlink($pathforthumbimage12);
}






mysqli_query($con, "DELETE FROM message WHERE messages_id='$messages_id'");
mysqli_query($con, "DELETE FROM message1 WHERE msg_id='$messages_id'");
mysqli_query($con, "DELETE FROM videos1 WHERE video_id='$messages_id'");

mysqli_query($con, "DELETE FROM bleh WHERE remarks='$messages_id'");

mysqli_query($con, "DELETE FROM comment_report WHERE msg_id='$messages_id'");
mysqli_query($con, "DELETE FROM videos WHERE msg_id = '$messages_id'");
mysqli_query($con, "DELETE FROM uplolad_data WHERE msg_id = '$messages_id'");

$thumbmessage = mysqli_query($con, "SELECT messages_id FROM message WHERE messages='".$mres['messages']."'");
$thumbcount = mysqli_num_rows($thumbmessage);
if($thumbcount == 1){
unlink($url);
}
}
else
{
// this is the shared post
$share_msg_id = $messages_id;
		
		//delete post
		mysqli_query($con, "DELETE FROM message WHERE messages_id='$share_msg_id'");		
		//delete post like
		mysqli_query($con, "DELETE FROM bleh WHERE remarks='$share_msg_id'");
		//delete post dislike
		mysqli_query($con, "DELETE FROM post_dislike WHERE msg_id='$share_msg_id'");
		//delete post comment
		mysqli_query($con, "DELETE FROM postcomment where msg_id = '$share_msg_id'");	
		//delete post repot
		mysqli_query($con, "DELETE FROM comment_report WHERE msg_id='$share_msg_id'");
		//delete videos
		mysqli_query($con, "DELETE FROM videos WHERE msg_id = '$share_msg_id'");
		//delete post photo
		mysqli_query($con, "DELETE FROM uplolad_data WHERE msg_id = '$share_msg_id'");
		
		//fetch comment id
		$scsql = mysqli_query($con, "select * from postcomment where msg_id = '$share_msg_id'");
		while($scres = mysqli_fetch_array($scsql))
		{
		$scomment_id = $scres['comment_id'];
		$srsql = mysqli_query($con, "select * from comment_reply where comment_id = '$comment_id'");
		while($srres = mysqli_fetch_array($srsql))
		{
		
		$sql1=mysqli_query($con, "select * from reply_reply WHERE reply_id='$rres[reply_id]'");
		while($reply1=mysqli_fetch_array($sql1))
		{
		
		
		$responce2 = mysqli_query($con, "DELETE FROM reply_reply1 WHERE msg_id='$reply1[id]'") or die(mysqli_error($con));
		}
		$responce5 = mysqli_query($con, "DELETE FROM reply_reply WHERE reply_id='$rres[reply_id]'") or die(mysqli_error($con));
		$responce4 = mysqli_query($con, "DELETE FROM comment_reply1 WHERE msg_id='$rres[reply_id]'") or die(mysqli_error($con));
		}
		$responce3= mysqli_query($con, "DELETE FROM comment_reply WHERE comment_id='$comment_id'") or die(mysqli_error($con));
		$responce1 = mysqli_query($con, "DELETE FROM postcomment1 WHERE msg_id='$comment_id'") or die(mysqli_error($con));
		mysqli_query($con, "DELETE FROM comment_like WHERE comment_id='$comment_id'")or die(mysqli_error($con));
		mysqli_query($con, "DELETE FROM comment_reply WHERE comment_id='$comment_id'")or die(mysqli_error($con));
		}
		
	
}
}
?>