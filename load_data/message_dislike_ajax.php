<?php
include ('../config.php');
session_start();
if(isSet($_POST['msg_id']) && isSet($_POST['rel']))
{
$msg_id=mysqli_real_escape_string($con, f($_POST['msg_id'],'escapeAll'));
$rel=mysqli_real_escape_string($con, f($_POST['rel'],'escapeAll'));
$uid=$_SESSION['SESS_MEMBER_ID']; // User login session id
$time = time();
if($rel=='disLike')
{
//---Like----
$member_sql = mysqli_query($con, "select * from members where member_id='$uid'");
$member_res = mysqli_fetch_array($member_sql);

$q=mysqli_query($con, "SELECT disbleh_id FROM blehdis WHERE member_id='$uid' and remarks='$msg_id' ");
if(mysqli_num_rows($q)==0)
{
$query=mysqli_query($con, "INSERT INTO blehdis (remarks,member_id) VALUES('$msg_id','$uid')");

$msgsql = mysqli_query($con, "SELECT m.member_id,m.email_id FROM message msg LEFT JOIN members m ON m.member_id = msg.member_id 
WHERE msg.messages_id = '$msg_id'");
$msgres = mysqli_fetch_array($msgsql);
$msg_member_id = $msgres['member_id'];

$url = 'posts.php?id='.$msg_id.'';

if($uid != $msg_member_id)
{
$nquery = "INSERT INTO notifications (sender_id, received_id, type_of_notifications, href, is_unread, date_created)
				VALUES('$uid','$msg_member_id',8,'$url',0,'$time')";
mysqli_query($con, $nquery);

/************************************* mail function ***********************************/

echo $to = $msgres['email_id'];
$subject = "".$member_res['username']." Dislikes your status";
echo $message = "
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
qbdev quakbox
<span>
</a>
</td>
</tr>
</tbody>
</table>

<table width='100%' cellpadding='0' cellspacing='0' style='border-collapse:collapse; width=620px;' border='0'>
<tbody>
<tr>
<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding:0px;background-color:#f2f2f2;border-left:none;border-right:none;border-top:none;border-bottom:none'>

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
Dislikes your status
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


<tbody>
<table>

</td>
</tr>

</tbody>
</table>

<p><a href='".$base_url."'>".$site_name."</a></p>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";


$headers .= "From: ".$site_email."";

$mail = mail($to, $subject, $message, $headers); 


/************************************* end mail function ***********************************/


}
//$q=mysqli_query("UPDATE messages SET like_count = like_count+1 WHERE msg_id='$msg_id'") ;
//$g=mysqli_query("SELECT like_count FROM messages WHERE msg_id='$msg_id'");
//$d=mysqli_fetch_array($g);
//echo $d['like_count'];
}
}
else
{
//---Unlike----
$query=mysqli_query($con, "DELETE FROM blehdis WHERE remarks='$msg_id' and member_id='$uid'");
//$q=mysqli_query("UPDATE messages SET like_count=like_count-1 WHERE msg_id='$msg_id'");
//$g=mysqli_query("SELECT like_count FROM messages WHERE msg_id='$msg_id'");
//$d=mysqli_fetch_array($g);
//echo $d['like_count'];
}
}
?>