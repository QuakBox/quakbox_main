<?php
// This Class Created By Yasser Hossam & Moshera Ahmed
// Sending Emails from QuackBox user to our email for reporting an issue
// Creating Date 13/4/2016
require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php'); 
include_once($_SERVER['DOCUMENT_ROOT']."/qb_classes/connection/qb_database.php");
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');

$member = new Member();
$sender_name = $member->get_member_name($_SESSION['SESS_MEMBER_ID']);
$sender_email = $member->get_member_email($_SESSION['SESS_MEMBER_ID']);
                
                
$site_email = "noreply@quakbox.com";
$to = "drebravo@gmail.com";
$subject = "QuakBox Issues| New Issue Reported from $sender_name";
$message = "
<html>
<head>
<body>
Hello, <br/>
This is a new Issue reported <br/>
<b>Reporter :</b> $sender_name <br/>
<b>URL :</b> " . $_REQUEST['url'] . " <br/>
<b>Platform :</b> " . $_REQUEST['platform'] . " <br/> 
<b>Issue : </b>" . $_REQUEST['issue'] . " <br/>
</body>
</html>
";


$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
$headers .= "From: QuakBox <".$site_email.">";
                
$mail = mail($to, $subject, $message, $headers); 	
	
header("location: ../home.php");
