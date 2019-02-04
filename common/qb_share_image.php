<?php
$shareImg  = $_SERVER['DOCUMENT_ROOT'] . "/" . base64_decode( $_GET['i']);
$playerImg = $_SERVER['DOCUMENT_ROOT'] . "/video-ads/images/controls_images/playButtonScreenWhite.png";

$imginfo = getimagesize($shareImg);
$a=$imginfo['mime'];
switch( $a){
	case 'image/png':
		$dest = imagecreatefrompng(  $shareImg );
		break;
	case 'image/gif' :
		$dest = imagecreatefromgif($shareImg );
		break;
	case 'image/jpeg':
		$dest = imagecreatefromjpeg( $shareImg );
		break;
}


$src = imagecreatefrompng( $playerImg );

/*
imagealphablending($dest, false);
imagesavealpha($dest, true);*/

imagecopy($dest, $src, 165, 70, 0, 0, 71, 71); //have to play with these numbers for it to work for you, etc.

header('Content-Type: ' . $a);
imagepng($dest);

imagedestroy($dest);
imagedestroy($src);
?>