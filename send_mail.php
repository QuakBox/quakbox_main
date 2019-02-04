<?php
require_once 'assets/lib/mail/swiftmailer/lib/swift_required.php';

// Create the mail transport configuration
$transport = Swift_MailTransport::newInstance();

// Create the message
$message = Swift_Message::newInstance();
$message->setTo(array(
  "ymservices1@gmail.com" => "Yasser",
  "ymservices4@gmail.com" => "Gatien"
));
$message->setSubject("This email is sent using QuakBox");
$message->setBody("You're our best client ever.");
$message->setFrom("yhossam90@gmail.com", "QB");

// Send the email
$mailer = Swift_Mailer::newInstance($transport);
$mailer->send($message);
echo "Done!";
echo "<br/>";
echo ini_get('max_execution_time');