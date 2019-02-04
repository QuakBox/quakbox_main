<?php ob_start();
	//Start session
	session_start();
	
	//Include database connection details
	require_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_lookup.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
	$objMember = new member1(); 
	$lookupObject = new lookup(); 
	//Sanitize the POST values
	$member_id = $_SESSION['SESS_MEMBER_ID'];
/******************/

	$message_body = mysqli_real_escape_string($con, f($_POST['message'],'escapeAll'));
	//echo $_REQUEST['message'];	
	$member = mysqli_query($con, "select * from member where member_id = '$member_id' order by member_id desc LIMIT 1");
	$member_res = mysqli_fetch_array($member);

	// $member=$clicks_res['member_id'];
	$media = $objMember->select_member_meta_value($member_res['member_id'],'current_profile_image');
	$displayname=$member_res['displayname'];
	if(!$media)
		$media = "images/default.png";
	$media=$base_url.$media;
	//$o_country_id=$member_res['origion_country'];
	
	//$sql_origin="select * from geo_country where country_id=$o_country_id";
	
	//$st_origin=mysqli_query($con, $sql_origin);
	//$res_origin=mysqli_fetch_array($st_origin);
	$fsql = mysqli_query($con, "select * from friendlist where added_member_id = '$member_id'");
	$fcount = mysqli_num_rows($fsql);
	if($member_res)
	{
		$subject = $displayname." invites you to join quakbox";
		$message = "
	<html>
	
	<body style='font-family:Verdana, Geneva, sans-serif; font-size:14px;'>
	
	<table width='100%' cellpadding='0' cellspacing='0' style='border-collapse:collapse;width:100%;'>
	<tbody>
	<tr>
	<td style='font-family:lucida grande,tahoma,verdana,arial,sans-serif;font-size:12px;'>
	
	<table width='100%' cellpadding='0' cellspacing='0' style='border-collapse:collapse;width:100%;'>
	<tbody>
	<tr>
	<td style='font-size:16px;font-family:lucida grande,tahoma,verdana,arial,sans-serif;background:#4F70D1;color:#ffffff;font-weight:bold;vertical-align:baseline;letter-spacing:-0.03em;text-align:left;padding:5px 20px;'>
	<a href='".$base_url."' style='text-decoration:none'>
	<span style='background:#4F70D1;color:#ffffff;font-weight:bold;font-family:lucida grande,tahoma,verdana,arial,sans-serif;vertical-align:middle;font-size:16px;letter-spacing:-0.03em;text-align:left;vertical-align:baseline;'>
	<img src='".$base_url."images/qb-email.png' height='30' style='margin-right:3px;'><img src='".$base_url."images/qb-quack.png' width='75' height='30'>
	<span>
	</a>
	</td>
	</tr>
	</tbody>
	</table>
	
	<table width='100%' cellpadding='0' cellspacing='0' style='border-collapse:collapse;width:100%;' border='0'>
	<tbody>
	<tr>
	<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding:0px;background-color:#f2f2f2;border-left:none;border-right:none;border-top:none;border-bottom:none'>
	
	<table cellpadding='0' cellspacing='0' style='border-collapse:collapse;width:100%;'>
	<tbody>
	<tr>
	<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding:0px;width:100%;'>
	
	<table width='100%' cellpadding='0' cellspacing='0' style='border-collapse:collapse;width:100%;'>
	<tbody>
	<tr>
	
	<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding:20px;background-color:#fff;border-left:none;border-right:none;border-top:none;border-bottom:none'>
	
	<table cellpadding='0' cellspacing='0' style='border-collapse:collapse;'>
	<tbody>
	<tr>
	
	<td valign='top' style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding-right:15px;text-align:left'>
	<a href='".$base_url."' style='color:#3b5998;text-decoration:none'>
	<img style='border:0' height='50' width='50' src='".$media."' />
	</a>
	</td>
	
	<td valign='top' style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;width:100%;text-align:left'>
	<table cellpadding='0' cellspacing='0' style='border-collapse:collapse;width:100%;'>
	<tbody>
	<tr>
	<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding-bottom:2px'>
	<span style='color:#111111;font-size:14px;font-weight:bold'>
	<a href='".$base_url."' target='_blank' style='color:#3b5998;text-decoration:none'>
	".$displayname."
	</a>
	invites you to join quakbox
	</span>
	</td>
	</tr>
	
	<tr>
	<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding-top:1px'>
	<span style='color:#333333'>
	<span>
	".$fcount." friends
	
	<br><br>
	".nl2br($message_body)."
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
	<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding:0px;width:100%;'>
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
/**************/	
	$emailIds = explode(",", $_POST['email']);
	foreach( $emailIds as $email_id ){
		//Create INSERT query
		$sql = "INSERT INTO invite_friends(member_id, email_id,status) VALUES('$member_id','$email_id','0')";
		$result = mysqli_query($con, $sql) or die(mysqli_error($con));
		
   		$email_id = mysqli_real_escape_string($con, f($email_id,'escapeAll'));
   		$mail = mail($email_id, $subject, $message, $headers); 

	}

$url = '';
if(strpos($_SERVER['HTTP_REFERER'], "?") == null)
	$url = $_SERVER['HTTP_REFERER'];
else
	$url = substr($_SERVER['HTTP_REFERER'], 0, strpos($_SERVER['HTTP_REFERER'], "?"));
	
//echo $url;
header("location: ".$url."?err=".mysqli_error($con));
exit();		
}
	
?>