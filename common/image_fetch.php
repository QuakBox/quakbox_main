<?php

require_once (__DIR__.'/../includes/php_fast_cache.php');

$remoteImage ='';
$remoteImage = $_GET['url'];
if($remoteImage !=''){

	$imageId = md5($remoteImage).'.'.strtolower(pathinfo($remoteImage, PATHINFO_EXTENSION));
	$imageCachePath = __DIR__.'/../image-cache/'.$imageId;
	if(!file_exists($imageCachePath)){
    	    $imginfo = @getimagesize($remoteImage);
        	if(!empty($imginfo)){
    		    $a=$imginfo['mime'];
		    file_put_contents($imageCachePath, file_get_contents($remoteImage));
	    }
	}

	header("Content-type: ".mime_content_type($imageCachePath));

	$fp = fopen($imageCachePath, 'rb');
	fpassthru($fp);

	// @readfile($imageCachePath);
	exit();
}
print "Error";
exit;
