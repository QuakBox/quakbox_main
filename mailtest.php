<?php

$headers = 'From: noreply@quakbox.com';
$ret = mail('dmitry@htmlin.com', 'Test email using PHP', 'This is a test email message', $headers);

var_dump($ret);
