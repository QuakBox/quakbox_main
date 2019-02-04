<?php
define("SITE_NAME", "Quakbox");
define("SITE_EMAIL", "noreply@quakbox.com");
define("SITE_NOTIFICATION_EMAIL", "notification@quakbox.com");
$protocol  = empty($_SERVER['HTTPS']) ? 'http' : 'https';
$domain	=$_SERVER['HTTP_HOST'];
define("SITE_URL", "$protocol://{$domain}");
define("ENC_KEY","QBAVSGJ");
		