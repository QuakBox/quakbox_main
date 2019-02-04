<?php 
ob_start();
session_start();	
include_once('../config.php');
	
  $add_member_id = $_SESSION['SESS_MEMBER_ID'];
 $member_id = $_REQUEST['member_id'];
  	$member_id	 = 	f($member_id, 'strip');
$member_id	 = 	f($member_id, 'escapeAll');
$member_id   = mysqli_real_escape_string($con, $member_id);

 $msg = mysqli_real_escape_string($con, $_POST['message']);
$time = time();

$check= mysqli_query($con, "select * from friendlist where (added_member_id = '$member_id' AND member_id='$add_member_id') OR
		(member_id = '$member_id' AND added_member_id='$add_member_id')") or die(mysqli_error($con));
				
		$check_count= mysqli_num_rows($con, $check);
		if($check_count==0)
		
		{



	
$sql="INSERT INTO friendlist (member_id, added_member_id, status, request_status,msg,sent) VALUES ('$member_id','$add_member_id','0',1,'".$msg."','$time')";
$responce = mysqli_query($con, $sql);

if(!empty($msg)){
//Insert message query
	$msgsql = "insert into cometchat(cometchat.from,cometchat.to,cometchat.message,cometchat.sent,cometchat.read) values('$add_member_id','$member_id','".$msg."','$time',1)";
	$msgresult = mysqli_query($con$msgsql) or die(mysqli_error($con));
}

//request to member data
$member_sql = mysqli_query($con, "select * from members where member_id = '$member_id'");
$member_res = mysqli_fetch_array($member_sql);

//request from member data
$member_sql1 = mysqli_query($con, "select * from members where member_id = '$add_member_id'");
$member_res1 = mysqli_fetch_array($con, $member_sql1);

$country = $member_res1['origion_country'];

$fsql = mysqli_query($con, "select * from friendlist where added_member_id = '$add_member_id'");
$fcount = mysqli_num_rows($fsql);



$country_sql = mysqli_query($con, "select country_title from geo_country where country_id='".$country."'") or die(mysqli_error($con));
$country_res = mysqli_fetch_array($country_sql);

//mail function
$to = $member_res['email_id'];
$subject = "".$member_res1['username']." wants to be friends on quakbox";
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
<img style='border:0' height='50' width='50' src='".$base_url.$member_res1['profImage']."' />
</a>
</td>

<td valign='top' style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;width:100%;text-align:left'>
<table cellpadding='0' cellspacing='0' style='border-collapse:collapse; width='100%''>
<tbody>
<tr>
<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding-bottom:2px'>
<span style='color:#111111;font-size:14px;font-weight:bold'>
<a href='".$base_url."' target='_blank' style='color:#3b5998;text-decoration:none'>
".$member_res1['username']."
</a>
wants to be friends on quakbox
</span>
</td>
</tr>

<tr>
<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding-top:1px;padding-bottom:2px'>
<span style='color:#808080'>
Country: ".$country_res['country_title']."
</span>
</td>
</tr>";

if($msg != ''){
	
$message .= "<tr>
<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding-top:1px;padding-bottom:2px'>
<span style='color:#808080'>
Message: ".$msg."
</span>
</td>
</tr>";
}

$message .="
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
<table cellpadding='0' cellspacing='0' style='border-collapse:collapse;'>
<tbody>
<tr>
<td style='border-width:1px;border-style:solid;border-color:#29447e #29447e #1a356e;background-color:#5b74a8'>
<a href='".$base_url."pending_request.php' target='_blank' style='color:#3b5998;text-decoration:none'>
<table cellpadding='0' cellspacing='0' style='border-collapse:collapse;'>
<tbody>
<tr>
<td style='border-collapse: collapse;  border-radius: 2px;  text-align: center;  display: block;  border: solid 1px #4f70d1;  background: #4f70d1;  padding: 7px 16px 8px 16px;'>

<span style='font-weight:bold;white-space:nowrap;font-size:13px;color: #fff;'>
Accept Request
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

<p><a href='".$base_url."'>".$site_name."</a></p>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";


$headers .= "From: ".$site_email."";

$mail = mail($to, $subject, $message, $headers); 

?> 
<?php
$_SESSION['err_count']=0;
//header('Location: ' . $_SERVER['HTTP_REFERER'].'?err='.mysqli_error($con));
//exit;
}
else
{
//header('Location: ' . $_SERVER['HTTP_REFERER'].'?err=you have already sent or have equest');
//exit;
}
?>