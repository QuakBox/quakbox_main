<?php ob_start();
include_once '../config.php'; 
    $temp_name = $_FILES['thumbfile']['tmp_name'];  
    $file_name = $_FILES['thumbfile']['name'];      
	$file_type = $_FILES['thumbfile']['type'];	
	$time = time();	
    
	$image_name200x150 = 'p200x150custom_thumb'.$time.'.png';
	$image_name400x281 = 'p400x225custom_thumb'.$time.'.png';
	$image_name = 'custom_thumb'.$time.'.png';
	
	header('Content-type: image/png');
	$image200x150 = new Imagick($temp_name);
    $image200x150->adaptiveResizeImage(200,150);
    $image200x150->writeImage('../uploadedvideo/videothumb/'.$image_name200x150);
	
	$image400x281 = new Imagick($temp_name);
    $image400x281->adaptiveResizeImage(400,281);
    $image400x281->writeImage('../uploadedvideo/videothumb/'.$image_name400x281);
	
	$preview_location = $base_url.'uploadedvideo/videothumb/';	
	echo $image_name;  	
        
 ?>  