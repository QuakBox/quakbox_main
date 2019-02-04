<?php ob_start();
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/config.php');	
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
$memberObject = new member1();
$add_member_id = $_SESSION['SESS_MEMBER_ID'];		
	if($_POST != array())
	{
		
		foreach ($_POST['email'] as $member_id){		 

$member_id   = f($member_id, 'strip');
$member_id	 = 	f($member_id, 'escapeAll');
$member_id   = mysqli_real_escape_string($con, $member_id);
$sql="INSERT INTO friendlist (member_id, added_member_id, status, request_status) VALUES ('$member_id','$add_member_id','0',1)";
$responce = mysqli_query($con, $sql);

$member_sql = mysqli_query($con, "select * from member where member_id='$member_id'");
$member_res = mysqli_fetch_array($member_sql);

$fsql = mysqli_query($con, "select * from friendlist where added_member_id = '$member_id'");
$fcount = mysqli_num_rows($fsql);

$current_profile_image = $memberObject->select_member_meta_value($member_res['member_id'],"current_profile_image");
$current_profile_image = $base_url.$current_profile_image;
$country=$memberObject-> select_member_meta_value_for_GeoCountry($member_res['member_id']);
//mail function
$to = $member_res['email'];
$subject = "".$member_res['username']." wants to be friends on qbdev quakbox";
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
<img style='border:0' height='50' width='50' src='".$current_profile_image."' />
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
wants to be friends on qbdev quakbox
</span>
</td>
</tr>

<tr>
<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding-top:1px;padding-bottom:2px'>
<span style='color:#808080'>
".$country."
</span>
</td>
</tr>

<tr>
<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding-top:1px'>
<span style='color:#333333'>
<span>
".$fcount." friends
</span>
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
<a href='".$base_url."' target='_blank' style='text-decoration:none'>
See all requests
</a>
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
			}
		}

header("location: ".$base_url."getting_started_invite.php");
exit();
?>