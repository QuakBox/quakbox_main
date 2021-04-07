<?php

echo phpinfo();
die();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require($_SERVER['DOCUMENT_ROOT'].'/PHPMailer-master/PHPMailerAutoload.php');

$mail = new PHPMailer;
$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->SMTPAuth = true;                               // Enable SMTP authentication

$mail->From = "support@quakbox.com";
$mail->FromName = 'Mailer';
$mail->addAddress("naresh.shaw@gmail.com");                            // Add a recipient

$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
$mail->Subject = "test";
$mail->Body    ="body";


if(!$mail->send()) {
	echo 'Message could not be sent.';
	echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
	echo 'Message has been sent';
}
exit;

?>