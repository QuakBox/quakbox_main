<?php ob_start();
require_once('../config.php');
$member_id = f($_REQUEST['member_id'],'escapeAll');
$member_id = mysqli_real_escape_string($con, $member_id);
$activation_code = f($_REQUEST['verification_code'],'escapeAll');
$activation_code = mysqli_real_escape_string($con, $activation_code);
$checksql = "Select * from members where member_id='$member_id' and status_code='$activation_code'";
$sqlcount = mysqli_query($con, $checksql) or die(mysqli_error($con));
$member = mysqli_fetch_array($sqlcount);
if(mysqli_num_rows($sqlcount) == 0){
header("location: ".$base_url."error.html");	
exit();
}
else
{
//mail function
$to = $member['email_id'];
$subject = "Account Details For '".$member['FirstName']."' at ".$site_name."";
$message = "
<html>
<head>
<title>'".$subject."'</title>
</head>
<body style='font-family:Verdana, Geneva, sans-serif; font-size:14px;'>

<p>Hello ".$member['FirstName'].",</p><br />
<p>	Thank You for registering at <a href='".$base_url."'>$site_name</a>. Your account is created and must be activated before you can log in. To activate the account, click on the following link or copy-&-paste it in your browser.</p>
<br>

<a href='".$base_url."activation.php?verification_code=".$activation_code."&member_id=".$member['member_id']."'>Click here to Activate your account</a><br />
<p>Or Copy Below link and paste in Your Browser.
</p><br />
<a href='".$base_url."activation.php?verification_code=".$activation_code."&member_id=".$member['member_id']."'>".$base_url."activation.php?member_id=".$activation_code."&member_id=".$member['member_id']."
</a>
<br />
<p>After activation you may log in to <a href='".$base_url."'>$site_name</a> using the following username or Email Id:</p>
<br>
Email_id: ".$member['username']."@".$site_email."<br>
User Name: ".$member['username']."<br>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

$headers .= "From: ".$site_email."";

$mail = mail($to , $subject, $message, $headers); 
header("location: ".$base_url."activation.php?sakdj=5ucc3555en7");
exit();

}
?>