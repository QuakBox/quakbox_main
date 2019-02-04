<?php ob_start();
	//Start session
	session_start();
	
	//Include database connection details
	require_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_registration_class.php');
$object = new registration();
	$memberObject = new member1();
	//Sanitize the POST values
	$member_id = $_SESSION['SESS_MEMBER_ID'];	
    if($_POST != array())
	{
		foreach ($_POST['email'] as $email){
	

$email   = f($email, 'strip');
$email	 = 	f($email, 'escapeAll');
$email   = mysqli_real_escape_string($con, $email);	
	$member = mysqli_query($con, "select * from member where member_id = '$member_id' order by member_id desc LIMIT 1");
	$member_res = mysqli_fetch_array($member);
	
	$current_profile_image = $memberObject->select_member_meta_value($member_res['member_id'],"current_profile_image");
$current_profile_image = $base_url.$current_profile_image;
$country=$memberObject-> select_member_meta_value_for_GeoCountry($member_res['member_id']);

	$fsql = mysqli_query($con, "select * from friendlist where added_member_id = '$member_id'");
$fcount = mysqli_num_rows($fsql);
if($member_res)
{
//mail function
$to = $email;
$subject = $member_res['username']." invites you to join ".$site_name."";
$message = "
<html>

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
".$site_name."
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
invites you to join qbdev quakbox
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
Sign up
</a>
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



$headers .= "From: ".$site_email."";

$mail = mail($email, $subject, $message, $headers); 

$object-> skipChekPoints($member_id, 'Importing Contacts');
//echo $url;
header("location: ".$base_url."registerProfile.php");
exit();		
		}
		}
	}
?>