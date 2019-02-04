<?php
//error_reporting(0);
require($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php');	
include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
require($_SERVER['DOCUMENT_ROOT'].'/common/qb_email.php');
if(!isset($_SESSION['SESS_MEMBER_ID']))
	{	
	$like_count="expired";
	$dislike_count="expired";
		 $output = array('likecount' => $like_count,'dislikecount' => $dislike_count);
    echo json_encode($output);
		
		
	}
	else
	{



if(isSet($_POST['msg_id']) && isSet($_POST['rel']))
{
$msg_id=mysqli_real_escape_string($con, f($_POST['msg_id'],'escapeAll'));
$rel=mysqli_real_escape_string($con, f($_POST['rel'],'escapeAll'));
$uid=$_SESSION['SESS_MEMBER_ID']; // User login session id
$time = time();
$dislike_count = '';
if($rel=='Like')
{
//---Like----
$member_sql = mysqli_query($con, "select * from members where member_id='$uid'");
$member_res = mysqli_fetch_array($member_sql);

//dislike data fetch using following query
$dislikequery = "SELECT * FROM post_dislike WHERE member_id='$uid' and msg_id='$msg_id'";
$dislikesql = mysqli_query($con, $dislikequery);

//like data fetch using following query
$likequery = "SELECT * FROM bleh WHERE member_id='$uid' and remarks='$msg_id'";
$likesql = mysqli_query($con, $likequery);

$q=mysqli_query($con, "SELECT bleh_id FROM bleh WHERE member_id='$uid' and remarks='$msg_id' ");
if(mysqli_num_rows($q)==0)
{
$query=mysqli_query($con, "INSERT INTO bleh (remarks,member_id) VALUES('$msg_id','$uid')");

$g = mysqli_query($con, "SELECT bleh_id FROM bleh WHERE remarks = '$msg_id'");
$like_count = mysqli_num_rows($g);

if(mysqli_num_rows($dislikesql) > 0) {
		$query=mysqli_query($con, "DELETE FROM post_dislike WHERE msg_id='$msg_id' and member_id='$uid'");			
	$h = mysqli_query($con, "SELECT dislike_id FROM post_dislike WHERE msg_id = '$msg_id'");
	$dislike_count = mysqli_num_rows($h);	
}

$msgsql = mysqli_query($con, "SELECT m.member_id,m.email_id,msg.type,msg.messages FROM message msg LEFT JOIN members m ON m.member_id = msg.member_id 
WHERE msg.messages_id = '$msg_id'");
$msgres = mysqli_fetch_array($msgsql);
$msg_member_id = $msgres['member_id'];
$type = $msgres['type'];
$messages = $msgres['messages'];
$description = (isset($msgres['description']))?$msgres['description']:"";
$url = 'posts.php?id='.$msg_id.'';

if($uid != $msg_member_id)
{
$nquery = "INSERT INTO notifications (sender_id, received_id, type_of_notifications, href, is_unread, date_created)
				VALUES('$uid','$msg_member_id',1,'$url',0,'$time')";
mysqli_query($con, $nquery);

/************************************* mail function ***********************************/
if($type == 0){
	$subject_msg = 'status';
} else if($type == 1){
	$subject_msg = 'image';
}else {
	$subject_msg = 'video';
}

$to = $msgres['email_id'];
$subject = "".ucfirst($member_res['username']).""." likes your ".$subject_msg."";
$mailTitle="";
$htmlbody = " 
        	<div style='width:100px;float:left;border:1px solid #ddd;'>
        		<a href='".$base_url.$member_res['username']."' title='".$member_res['username']."' target='_blank' style='text-decoration:none;'><img style='width:100%;' alt='".$member_res['username']."' title='".$member_res['username']."' src='".$base_url.$member_res['profImage']."' /></a>
        	</div> 
        	<div style='float:left;padding:15px;'>
        		<div>
        			<a href='".$base_url.$member_res['username']."' title='".$member_res['username']."' target='_blank' style='text-decoration:none;color:#085D93;'>".$member_res['username']." likes your status on quakbox</a>
        		</div>
        		";
				if($type == 0) {
$htmlbody .= "<div><span style='color:#808080'>
".$messages."
</span></div>";
} else if($type == 1) {
if($description!="")
	{
	$htmlbody.="<div>".$description."</div>";
	}
	$htmlbody .= "<a href='".$base_url."posts.php?id=".$msg_id."' target='_blank'><img src='".$base_url.$messages."' height='200' width='200'></a>";
} else if($type == 2) {
	$htmlbody .= "<a href='".$base_url."posts.php?id=".$msg_id."' target='_blank'><img src='".$base_url.$messages."' height='200' width='200'><a>";
}

$htmlbody .="<div><a href='".$base_url."posts.php?id=".$msg_id."' target='_blank' style='color:#3b5998;'>
<span style='font-weight:bold;white-space:nowrap;font-size:13px;'>
See Post
</span></a></div>";

$obj = new QBEMAIL(); 
$mail=$obj->send_email($to,$subject,'',$mailTitle,$htmlbody,'');

/************************************* end mail function ***********************************/


}
}
}
else
{
//---Unlike----
$query=mysqli_query($con, "DELETE FROM bleh WHERE remarks='$msg_id' and member_id='$uid'");
$g = mysqli_query($con, "SELECT bleh_id FROM bleh WHERE remarks = '$msg_id'");
$like_count = mysqli_num_rows($g);
$dislikequery = "SELECT * FROM post_dislike WHERE msg_id='$msg_id'";
$dislikesql = mysqli_query($con, $dislikequery);
$dislike_count = mysqli_num_rows($dislikesql);
}
// Lets say everything is in order
    $output = array('likecount' => $like_count,'dislikecount' => $dislike_count);
    header('Content-type: application/json');
    echo json_encode($output);
  
}}
?>