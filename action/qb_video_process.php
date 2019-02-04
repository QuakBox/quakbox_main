<?php
//error_reporting(E_All);
//ini_set('display_errors',1);
require_once($_SERVER['DOCUMENT_ROOT'] . '/common/qb_session.php');
//echo "<pre>hi";
//
ini_set('post_max_size', "16G");
ini_set('upload_max_filesize', "16G");

//die('multiple1212');
$upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploadedvideo/';
$temp_name = $_FILES['uploadedvideofile']['tmp_name'];
$file_name = $_FILES['uploadedvideofile']['name'];
$file_path = $upload_dir  . $file_name;

$time = time();
$ip = $_SERVER['REMOTE_ADDR'];
$videoNameWithoutExtension = pathinfo($file_name, PATHINFO_FILENAME);
$video_name = $time . $videoNameWithoutExtension;
$ext = pathinfo($file_name, PATHINFO_EXTENSION);


if (is_dir($upload_dir) && is_writable($upload_dir)) {
	//echo "<br>i m writable";
    if (move_uploaded_file($temp_name, $file_path)) {
    $replaced_name = str_replace([' ', '_', '(', ')', '-', '`', '~', '!', '@', '#', '$', '%', '^', '&', '+', '=',
            '{', '}', '[', ']', ';', '.', ':'], '', $video_name) . '.' . $ext;

    rename($upload_dir . $file_name, $upload_dir . $replaced_name);
	//echo "<br>uploaded:";
    echo $replaced_name;
} else {
  //  echo "error".$_FILES["uploadedvideofile"]["error"];
    echo "error";
}
} else {
    //echo 'Upload directory is not writable, or does not exist.';
    echo 'error';
}



?>
