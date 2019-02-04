<?php
include ('../config.php');
session_start();
if(isSet($_POST['comment_id']) && isSet($_POST['rel']))
{
$comment_id=mysqli_real_escape_string($con, f($_POST['comment_id'],'escapeAll'));
$msg_id =  mysqli_real_escape_string($con, f($_POST['msg_id'],'escapeAll'));
$rel= mysqli_real_escape_string($con, f($_POST['rel'],'escapeAll'));
$time = time();
$uid=$_SESSION['SESS_MEMBER_ID']; // User login session id
$dislike_count = '';
if($rel=='Like')
{
//---Like----
$member_sql = mysqli_query($con, "select * from members where member_id='$uid'");
$member_res = mysqli_fetch_array($member_sql);

//dislike data fetch using following query
$dislikequery = "SELECT * FROM groups_wall_comment_dislike WHERE member_id='$uid' and comment_id='$comment_id'";
$dislikesql = mysqli_query($con, $dislikequery);

//like data fetch using following query
$likequery = "SELECT * FROM groups_wall_comment_like WHERE member_id='$uid' and comment_id='$comment_id'";
$likesql = mysqli_query($con, $likequery);

$q=mysqli_query($con, "SELECT * FROM groups_wall_comment_like WHERE member_id='$uid' and comment_id='$comment_id' ");
mysqli_num_rows($q);
if(mysqli_num_rows($q)==0)
{
$query=mysqli_query($con, "INSERT INTO groups_wall_comment_like (msg_id,comment_id,member_id) VALUES('$msg_id','$comment_id','$uid')");

$g = mysqli_query($con, "SELECT like_id FROM groups_wall_comment_like WHERE comment_id = '$comment_id'");
$like_count = mysqli_num_rows($g);

if(mysqli_num_rows($dislikesql) > 0) {
		$query=mysqli_query($con, "DELETE FROM groups_wall_comment_dislike WHERE comment_id='$comment_id' and member_id='$uid'");			
	$h = mysqli_query($con, "SELECT dislike_id FROM groups_wall_comment_dislike WHERE comment_id = '$comment_id'");
	$dislike_count = mysqli_num_rows($h);	
}

$msgsql = mysqli_query($con, "SELECT m.member_id,m.email_id FROM groups_wall msg LEFT JOIN members m ON m.member_id = msg.member_id 
WHERE msg.messages_id = '$msg_id'");
$msgres = mysqli_fetch_array($msgsql);
$msg_member_id = $msgres['member_id'];

$url = 'posts.php?id='.$msg_id.'';

if($uid != $msg_member_id)
{
$nquery = "INSERT INTO notifications (sender_id, received_id, type_of_notifications, href, is_unread, date_created)
				VALUES('$uid','$msg_member_id',1,'$url',0,'$time')";
mysqli_query($con, $nquery);

/************************************* mail function ***********************************/

$to = $msgres['email_id'];
$subject = "".$member_res['username']." likes your status";
$message = "
<html>
<head>

<body style='font-family:Verdana, Geneva, sans-serif; font-size:14px;'>

<table cellpadding='0' cellspacing='0' style='border-collapse:collapse; width=98%;'>
<tbody>
<tr>
<td style='font-family:lucida grande,tahoma,verdana,arial,sans-serif;font-size:12px;'>

<table width='620px' cellpadding='0' cellspacing='0' style='border-collapse:collapse; width=620px;'>
<tbody>
<tr>
<td style='font-size:16px;font-family:lucida grande,tahoma,verdana,arial,sans-serif;background:#4F70D1;color:#ffffff;font-weight:bold;vertical-align:baseline;letter-spacing:-0.03em;text-align:left;padding:5px 20px;'>
<a href='".$base_url."' style='text-decoration:none'>
<span style='background:#4F70D1;color:#ffffff;font-weight:bold;font-family:lucida grande,tahoma,verdana,arial,sans-serif;vertical-align:middle;font-size:16px;letter-spacing:-0.03em;text-align:left;vertical-align:baseline;'>
<img src='".$base_url.$logo1."' height='30' style='margin-right:10px;'><img src='".$base_url.$logo."' width='75' height='30'>
<span>
</a>
</td>
</tr>
</tbody>
</table>

<table width='100%' cellpadding='0' cellspacing='0' style='border-collapse:collapse; width=620px;' border='0'>
<tbody>
<tr>
<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding:0px;border-left:none;border-right:none;border-top:none;border-bottom:none'>

<table cellpadding='0' cellspacing='0' style='border-collapse:collapse; width=620px;'>
<tbody>
<tr>
<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding:0px;width:620px'>

<table width='100%' cellpadding='0' cellspacing='0' style='border-collapse:collapse; width=100%;'>
<tbody>
<tr>

<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding:20px;background-color:#fff;border-left:none;border-right:none;border-top:none;border-bottom:none'>

<table cellpadding='0' cellspacing='0' style='border-collapse:collapse;'>
<tbody>
<tr>

<td valign='top' style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding-right:15px;text-align:left'>
<a href='".$base_url."' style='color:#3b5998;text-decoration:none'>
<img style='border:0' height='50' width='50' src='".$base_url.$member_res['profImage']."' />
</a>
</td>

<td valign='top' style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;width:100%;text-align:left'>
<table cellpadding='0' cellspacing='0' style='border-collapse:collapse; width='100%''>
<tbody>
<tr>
<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding-bottom:2px'>
<span style='color:#111111;font-size:14px;font-weight:bold'>
<a href='".$base_url."' target='_blank' style='color:#3b5998;text-decoration:none'>
".$member_res['username']."
</a>
likes your status
</span>
</td>
</tr>

</tbody>
</table>

</td>
</tr>
</tbody>
</table>

</td>
</tr>
</tbody>
</table>

</td>
</tr>

<tr>
<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding:0px;width:620px'>

<table cellpadding='0' cellspacing='0' style='border-collapse:collapse;'>
<tbody>
<tr>
<td style='border-width:1px;border-style:solid;border-color:#29447e #29447e #1a356e;background-color:#5b74a8'>
<a href='".$base_url."posts.php?id=".$msg_id."' target='_blank' style='color:#3b5998;text-decoration:none'>
<table cellpadding='0' cellspacing='0' style='border-collapse:collapse;'>
<tbody>
<tr>
<td style='border-collapse: collapse;  border-radius: 2px;  text-align: center;  display: block;  border: solid 1px #4f70d1;  background: #4f70d1;  padding: 7px 16px 8px 16px;'>

<span style='font-weight:bold;white-space:nowrap;font-size:13px;color: #fff;'>
See Post
</span>

</td>
</tr>
</tbody>
</table>
</a>
</td>
</tr>
</tbody>
</table>
</td>
</tr>

<tbody>
<table>

</td>
</tr>

</tbody>
</table>

</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";


$headers .= "From:Qbdev Quakbox";

$mail = mail($to, $subject, $message, $headers); 


/************************************* end mail function ***********************************/
}
}
}
else
{
//---Unlike----
$query=mysqli_query($con, "DELETE FROM groups_wall_comment_like WHERE comment_id='$comment_id' and member_id='$uid'");
$g = mysqli_query($con, "SELECT like_id FROM groups_wall_comment_like WHERE comment_id = '$comment_id'");
$like_count = mysqli_num_rows($g);
}
// Lets say everything is in order
    $output = array('likecount' => $like_count,'dislikecount' => $dislike_count);
    echo json_encode($output);
}
?>