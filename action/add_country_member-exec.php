<?php
ob_start();
session_start();
	//Include database connection details
	require_once('../config.php');
	$session_member_id = $_SESSION['SESS_MEMBER_ID'];
		//Sanitize the POST values
	$member_id = $_POST['member_id'];
	$member_id	 = 	f($member_id, 'strip');
$member_id	 = 	f($member_id, 'escapeAll');
$member_id   = mysqli_real_escape_string($con, $member_id);

	$invite_member_id = $_POST['event_member_id'];
	$invite_member_id	 = 	f($invite_member_id, 'strip');
$invite_member_id	 = 	f($invite_member_id, 'escapeAll');
$invite_member_id   = mysqli_real_escape_string($con, $invite_member_id);

	$country_code = $_POST['country_code'];	
	$country_code	 = 	f($country_code, 'strip');
$country_code	 = 	f($country_code, 'escapeAll');
$country_code   = mysqli_real_escape_string($con, $country_code);

	$invite_frinds = $_POST['invite_frinds'];	
	$invite_frinds	 = 	f($invite_frinds, 'strip');
$invite_frinds	 = 	f($invite_frinds, 'escapeAll');
$invite_frinds   = mysqli_real_escape_string($con, $invite_frinds);

	$time = time();
	
	
	$cquery = mysqli_query($con, "select country_title,code from geo_country where code = '$country_code'");
	$cres  = mysqli_fetch_array($cquery);
	$country = $cres['country_title'];
	
	$url = 'country_wall.php?country='.$country.'';
	
	$member = mysqli_query($con, "select * from members where member_id='$invite_member_id' order by member_id desc LIMIT 1");
	$member_res = mysqli_fetch_array($member);	
	
	$msql = mysqli_query($con, "select * from members where member_id = '$member_id'");
	$mres = mysqli_fetch_array($msql);
			
	//Insert query
	$gmquery = "select * from favourite_country where member_id = '$invite_member_id' and code = '$country_code'";
	$gmsql = mysqli_query($con, $gmquery);
	
	mysqli_num_rows($gmsql);
	
	if(mysqil_num_rows($gmsql) == 0)
	{						
		$isql = "INSERT INTO favourite_country (member_id, code,favourite_country) VALUES('$invite_member_id','$country_code',1)";
		mysqli_query($con, $isql);
		
		$nquery = "INSERT INTO notifications (sender_id, received_id, type_of_notifications,title, href, is_unread, date_created)
				VALUES('$session_member_id','$invite_member_id',32,'invited you to like his country $country','$url',0,'$time')";
	mysqli_query($con, $nquery);
	
	}
	
	
	
	//mail function
echo $to = $member_res['email_id'];
$subject = "".$mres['username']." invited you to like his country ".$cres['country_title']."";
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
quakbox
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
<img style='border:0' height='50' width='50' src='".$base_url."images/Flags/flags_new/50x50flags/".strtolower($cres['code']).".png' />
</a>
</td>

<td valign='top' style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;width:100%;text-align:left'>
<table cellpadding='0' cellspacing='0' style='border-collapse:collapse; width='100%''>
<tbody>
<tr>
<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding-bottom:2px'>
<span style='color:#111111;font-size:14px;font-weight:bold'>
".$cres['country_title']." on quakbox
</span>
</td>
</tr>

<tr>
<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding-top:1px;padding-bottom:2px'>
<span style='color:#808080'>
<a href='".$base_url."' target='_blank' style='color:#3b5998;text-decoration:none'>
".$mres['username']."</a> invited you to like his country <a href='".$base_url."' target='_blank' style='color:#3b5998;text-decoration:none'>".$cres['country_title']."</a> 
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
View Page
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
	
header("location: ".$base_url."country_wall.php?country=".$country."");		
exit();	
?>