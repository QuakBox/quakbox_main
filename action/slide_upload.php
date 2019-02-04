<?php  ob_start();
include_once '../config.php';

    $upload_dir = '../uploadedvideo/upload_photos/';           	 
	$time = time();
	$i = 0;
	foreach ($_FILES['slidefile']['name'] as $name => $value){
	$i++;
	$temp_name = $_FILES['slidefile']['tmp_name'][$name];  
    $file_name = $_FILES['slidefile']['name'][$name];  
    $file_path = $upload_dir.$file_name;	
    $n= sprintf("%03d", $i);
	$image_name= 'image'.$n.'.png';
	
	header('Content-type: image/png');
	$image = new Imagick($temp_name);
    $image->adaptiveResizeImage(212,288);
    $image->writeImage('../uploadedvideo/upload_photos/'.$image_name);	 	 
	
	$preview_location = $base_url.'uploadedvideo/upload_photos/';	
	echo "<div class='slideshow-slide'><img src='".$preview_location.$image_name."'class='slideshow-slide-thumb'><div>";		  
	 
	}
 ?>  