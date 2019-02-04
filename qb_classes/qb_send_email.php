<?php
// This Class Created By Yasser Hossam & Moshera Ahmed
// Sending Emails from QuackBox to users for notifications or any other propose
// Creating Date 4/2/2016

include_once($_SERVER['DOCUMENT_ROOT'] . "/qb_classes/connection/qb_database.php");
require_once($_SERVER['DOCUMENT_ROOT'] . '/qb_classes/qb_member.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/qb_classes/qb_member1.php');

class SendEmail
{


    function send_notification_email($sender_id, $receiver_id, $subject, $message_body, $media)
    {
        $base_url = "https://quakbox.com/";
        $site_email = "noreply@quakbox.com";

        $member = new Member();
        $sender_name = $member->get_member_name($sender_id);
        $sender_friends_count = $member->get_member_friends_count($sender_id);
        $receivers = $member->get_member_email($receiver_id);


        $objMember = new member1();
        $media = $objMember->select_member_meta_value($sender_id, 'current_profile_image');
        $email_signature = ''; // str_replace("\\n", '<br>', $objMember->select_member_meta_value($sender_id, 'email_signature'));
        if ($media) {
            $media = $base_url . $media;
        } else {
            $media = $base_url . 'images/default.png';
        }

        $media = str_replace(' ', '%20', $media);
        $message_content = str_replace(array("\r\n", "\r", "\n", "\\r", "\\n", "\\r\\n", "\\"), "<br/>", $message_body);

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
	<a href='" . $base_url . "' style='text-decoration:none'>
	<span style='background:#4F70D1;color:#ffffff;font-weight:bold;font-family:lucida grande,tahoma,verdana,arial,sans-serif;vertical-align:middle;font-size:16px;letter-spacing:-0.03em;text-align:left;vertical-align:baseline;'>
	<img src='" . $base_url . "images/qb-email.png' height='30' style='margin-right:3px;'><img src='" . $base_url . "images/qb-quack.png' width='75' height='30'>
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
	<a href='" . $base_url . "' style='color:#3b5998;text-decoration:none'>
	<img style='border:0' height='50' width='50' src='" . $media . "' />
	</a>
	</td>
	
	<td valign='top' style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;width:100%;text-align:left'>
	<table cellpadding='0' cellspacing='0' style='border-collapse:collapse;width:100%;'>
	<tbody>
	<tr>
	<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding-bottom:2px'>
	<span style='color:#111111;font-size:14px;font-weight:bold'>
	<a href='" . $base_url . "' target='_blank' style='color:#3b5998;text-decoration:none'>
	" . $sender_name . "
	</a>
	" . " $subject
	</span>
	</td>
	</tr>
	
	<tr>
	<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding-top:1px'>
	<span style='color:#333333'>
	<span>
	" . $sender_friends_count . " friends
	
	<br><br>
	" . "     " . "
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
	<td style='font-size:18px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding:5px;width:100%;'>
	<center>
	$message_content
	</center>
	</td>
	</tr>
	
	<tr>
	<td style='font-size:15px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding:5px;width:100%;'>$email_signature</td>
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

        $subject = "QuakBox | " . $sender_name . $subject;
        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
        $headers .= "From: QuakBox <" . $site_email . ">";

        $emailIds = explode(",", $receivers);
        foreach ($emailIds as $email_id) {
            $mail = mail($email_id, $subject, $message, $headers);
        }

    }


}

?>