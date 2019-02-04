<?php 
error_reporting(-1);
ob_start();

session_start();



include($_SERVER['DOCUMENT_ROOT'].'/config.php');



$newwallid = 0;

$member_id   = $_SESSION['SESS_MEMBER_ID'];

$description 		= 	f($_POST['desc'], 'escapeAll');
$description		= 	nl2br($description);
$description  	    = 	mysqli_real_escape_string($con, $description);

$title		 = 	f($_POST['title'], 'escapeAll');
$title 	     = nl2br($title);
$title 	     = mysqli_real_escape_string($con, $title);


$title_color = f($_POST['title_color'], 'strip');
$title_color		 = 	f($title_color, 'escapeAll');
$title_color 	     = nl2br($title_color);
$title_color 	     = mysqli_real_escape_string($con, $title_color);

$title_size = f($_POST['title_size'], 'strip');
$title_size		 = 	f($title_size , 'escapeAll');
$title_size 	     = nl2br($title_size);
$title_size 	     = mysqli_real_escape_string($con, $title_size);

$category    =f($_POST['category'], 'strip');;
$category		 = 	f($category, 'escapeAll');
$category 	     = nl2br($category);
$category 	     = mysqli_real_escape_string($con, $category);

$privacy     = f($_POST['tpe'], 'strip');
$privacy		 = 	f($privacy, 'escapeAll');
$privacy 	     = nl2br($privacy);
$privacy 	     = mysqli_real_escape_string($con, $privacy);

$time = time();

if($privacy==1)

$wall_privacy = 3;

else

$wall_privacy = 1;


$streaming     = f($_POST['strm'], 'strip');
$streaming		 = 	f($streaming, 'escapeAll');
$streaming 	     = mysqli_real_escape_string($con, $streaming);


$country     = f($_POST['country'], 'strip');
$country		 = 	f($country, 'escapeAll');
$country 	     = mysqli_real_escape_string($con, $country);

$dThumb     = f($_POST['defaultthumbnail'], 'strip');
$dThumb		 = 	f($dThumb, 'escapeAll');
$dThumb 	     = mysqli_real_escape_string($con, $dThumb);

$NameWithoutExtension     = f($_POST['nwe'], 'strip');
$NameWithoutExtension		 = 	f($NameWithoutExtension, 'escapeAll');
$NameWithoutExtension 	     = mysqli_real_escape_string($con, $NameWithoutExtension);

$ip = $_SERVER['REMOTE_ADDR'];

$locationForMp4 = $_SERVER['DOCUMENT_ROOT']."/uploadedvideo/new".$NameWithoutExtension.".mp4";

$locationForOgg = $_SERVER['DOCUMENT_ROOT']."/uploadedvideo/new".$NameWithoutExtension.".ogg";

$locationForWebm = $_SERVER['DOCUMENT_ROOT']."/uploadedvideo/new".$NameWithoutExtension.".webm";

$locationForThumb1 = $NameWithoutExtension."01.png";
$locationForThumb2 = $NameWithoutExtension."02.png";
$locationForThumb3 = $NameWithoutExtension."03.png";
$locationForThumb4 = $NameWithoutExtension."04.png";
$locationForThumb5 = $NameWithoutExtension."05.png";
$custom_thumb     = f($_POST['custom_thumb'], 'strip');
$custom_thumb		 = 	f($custom_thumb, 'escapeAll');
$custom_thumb 	     = mysqli_real_escape_string($con, $custom_thumb);

if($custom_thumb == $dThumb){
	$custom_thumb = $custom_thumb;
	$p400x225_path = $custom_thumb;
} else {
	$custom_thumb = '';
	$p400x225_path = $dThumb;
$defaultThumb = $_SERVER['DOCUMENT_ROOT']."/uploadedvideo/videothumb/".$dThumb;
$p400x225 = $_SERVER['DOCUMENT_ROOT']."/uploadedvideo/videothumb/p400x225".$dThumb;
$p200x150=$_SERVER['DOCUMENT_ROOT']."/uploadedvideo/videothumb/p200x150".$dThumb;	
	
	//image resize into 400x225
	$image400x225 = new Imagick($defaultThumb );
    $image400x225->adaptiveResizeImage(400,225);
    $image400x225->writeImage($p400x225);
    
    $image200x150 = new Imagick($defaultThumb );
    $image200x150->adaptiveResizeImage(200,150);
    $image200x150->writeImage($p200x150);
	
}

$p400x225_path_1 = "new".$NameWithoutExtension."01.png";
$defaultThumb_1 = $base_url."uploadedvideo/videothumb/new".$NameWithoutExtension."01.png";
$p400x225_1 = $base_url."uploadedvideo/videothumb/p400x225new".$NameWithoutExtension."01.png";
$p200x150_1 = $base_url."uploadedvideo/videothumb/p200x150new".$NameWithoutExtension."01.png";
$image400x225_1 = new Imagick($defaultThumb_1);
    $image400x225_1->adaptiveResizeImage(400,225);
	
    $image400x225_1->writeImage($p400x225_1);
    
     $image200x150_1 = new Imagick($defaultThumb_1);
    $image200x150_1->adaptiveResizeImage(200,150);
    $image200x150_1->writeImage($p200x150_1);
    
    



$p400x225_path_2="new".$NameWithoutExtension."02.png";
$defaultThumb_2 = $base_url."uploadedvideo/videothumb/new".$NameWithoutExtension."02.png";
$p400x225_2 = $base_url."uploadedvideo/videothumb/p400x225new".$NameWithoutExtension."02.png";
$p200x150_2 = $base_url."uploadedvideo/videothumb/p200x150new".$NameWithoutExtension."02.png";
$image400x225_2 = new Imagick($defaultThumb_2);
    $image400x225_2->adaptiveResizeImage(400,225);
    $image400x225_2->writeImage($p400x225_2);
    
    
    $image200x150_2 = new Imagick($defaultThumb_2);
    $image200x150_2->adaptiveResizeImage(200,150);
    $image200x150_2->writeImage($p200x150_2);
    
$p400x225_path_3="new".$NameWithoutExtension."03.png";
$defaultThumb_3 = $base_url."uploadedvideo/videothumb/new".$NameWithoutExtension."03.png";
$p400x225_3 = $base_url."uploadedvideo/videothumb/p400x225new".$NameWithoutExtension."03.png";
$p200x150_3 = $base_url."uploadedvideo/videothumb/p200x150new".$NameWithoutExtension."03.png";
$image400x225_3 = new Imagick($defaultThumb_3);
    $image400x225_3->adaptiveResizeImage(400,225);
    $image400x225_3->writeImage($p400x225_3);
    
     $image200x150_3 = new Imagick($defaultThumb_3);
    $image200x150_3->adaptiveResizeImage(200,150);
    $image200x150_3->writeImage($p200x150_3);
    
$p400x225_path_4="new".$NameWithoutExtension."04.png";
$defaultThumb_4 = $base_url."uploadedvideo/videothumb/new".$NameWithoutExtension."04.png";
$p400x225_4 = $base_url."uploadedvideo/videothumb/p400x225new".$NameWithoutExtension."04.png";
$p200x150_4 = $base_url."uploadedvideo/videothumb/p200x150new".$NameWithoutExtension."04.png";
$image400x225_4 = new Imagick($defaultThumb_4);
    $image400x225_4->adaptiveResizeImage(400,225);
    $image400x225_4->writeImage($p400x225_4);
    
     $image200x150_4 = new Imagick($defaultThumb_4);
    $image200x150_4->adaptiveResizeImage(200,150);
    $image200x150_4->writeImage($p200x150_4);
    

$p400x225_path_5="new".$NameWithoutExtension."05.png";
$defaultThumb_5 = $base_url."uploadedvideo/videothumb/new".$NameWithoutExtension."05.png";
$p400x225_5 = $base_url."uploadedvideo/videothumb/p400x225new".$NameWithoutExtension."05.png";
$p200x150_5 = $base_url."uploadedvideo/videothumb/p200x150new".$NameWithoutExtension."05.png";
$image400x225_5 = new Imagick($defaultThumb_5);
    $image400x225_5->adaptiveResizeImage(400,225);
    $image400x225_5->writeImage($p400x225_5);
    
    
     $image200x150_5 = new Imagick($defaultThumb_5);
    $image200x150_5->adaptiveResizeImage(200,150);
    $image200x150_5->writeImage($p200x150_5);
	

//extension_loaded('ffmpeg') or die('Error in loading ffmpeg');
require_once('../qb_classes/ffmpeg-php/FFmpegAutoloader.php');

$ffmpegInstance = new ffmpeg_movie($locationForMp4);

$duration = intval($ffmpegInstance->getDuration());



$pvsql = mysqli_query($con, "SELECT video_id FROM videos ORDER BY video_id DESC LIMIT 1");

$pvres = mysqli_fetch_array($pvsql);

$pvideo_id = $pvres['video_id'];



if($streaming=="mywall" || $streaming=="everywhere"){

if($streaming=="mywall"){

	$sql="INSERT INTO message(member_id,type,date_created,ip,wall_privacy) VALUES ('$member_id',2,'$time','$ip','1')";



mysqli_query($con, $sql) or die(mysqli_error($con));



$newwallid = mysqli_insert_id($con);



//insert into videos table

	$vquery = "INSERT INTO videos (description,category, location,location1,location2,thumburl,thumburl1,thumburl2,thumburl3,title,user_id,type,url_type,date_created,msg_id,title_size,title_color,duration,custom_thumb) VALUES('$description','$category','$locationForMp4','$locationForOgg','$locationForWebm','$p400x225_path','$p400x225_path_1','$p400x225_path_2','$p400x225_path_3','$title','$member_id','$privacy','1','$time','$newwallid','$title_size','$title_color','$duration','$custom_thumb')";

	

	$vsql = mysqli_query($con, $vquery)  or die(mysqli_error($con));

	$video_id = mysqli_insert_id($con);

	

	$umsql="UPDATE message set video_id = '$video_id' where messages_id = '$newwallid'";

	mysqli_query($con,$umsql);

}

if($streaming=="everywhere"){

	

	$fquery = "select m.member_id,m.email_id from friendlist f,members m where f.member_id=m.member_id and f.added_member_id = '".$member_id."' AND status !=0";

//echo $fquery;

$fsql = mysqli_query($con, $fquery);



if(mysqli_num_rows($fsql) > 0)

{

while($fres = mysqli_fetch_array($fsql))

{

	$content_id = $fres['member_id'];

$sql="INSERT INTO message(content_id,member_id,type,date_created,ip,wall_privacy) VALUES ('$content_id','$member_id',2,'$time','$ip','1')";



mysqli_query($con, $sql) or die(mysqli_error($con));



$newwallid = mysqli_insert_id($con);



//insert into videos table

	$vquery = "INSERT INTO videos (description,category, location,location1,location2,thumburl,thumburl1,thumburl2,thumburl3,title,user_id,type,url_type,date_created,msg_id,title_size,title_color,duration,custom_thumb) VALUES('$description','$category','$locationForMp4','$locationForOgg','$locationForWebm','$p400x225_path','$p400x225_path_1','$p400x225_path_2','$p400x225_path_3','$title','$member_id','$privacy','1','$time','$newwallid','$title_size','$title_color','$duration','$custom_thumb')";

	$vsql = mysqli_query($con, $vquery)  or die(mysqli_error($con));	

	$video_id = mysqli_insert_id($con);

	

	mysqli_query($con, "UPDATE videos set parent_id = '$pvideo_id' where video_id = '$video_id'");

	$umsql="UPDATE message set video_id = '$video_id' where messages_id = '$newwallid'";

	mysqli_query($con, $umsql);

}

}

}

}



if($country != NULL)

	{

$values = implode(',', $country);

	$sql="INSERT INTO message(member_id,type,date_created,ip,wall_privacy) VALUES ('$member_id',2,'$time','$ip','1')";



mysqli_query($con, $sql) or die(mysqli_error($con));



$newwallid = mysqli_insert_id($con);

	$vquery = "INSERT INTO videos (description,category, location,location1,location2,thumburl,thumburl1,thumburl2,thumburl3,thumburl4,thumburl5,title,user_id,type,url_type,date_created,msg_id,title_size,title_color,country_id,duration,custom_thumb) VALUES('$description','$category','$locationForMp4','$locationForOgg','$locationForWebm','$p400x225_path','$p400x225_path_1','$p400x225_path_2','$p400x225_path_3','$p400x225_path_4','$p400x225_path_5','$title','$member_id','$privacy','1','$time','$newwallid','$title_size','$title_color','".$values."','$duration','$custom_thumb')";

	$vsql = mysqli_query($con, $vquery)  or die(mysqli_error($con));	

	$video_id = mysqli_insert_id($con);

	

	mysqli_query($con, "UPDATE videos set parent_id = '$pvideo_id' where video_id = '$video_id'");
	
	$umsql="UPDATE message set video_id = '$video_id' where messages_id = '$newwallid'";

	mysqli_query($con, $umsql);

	

	

} else {
	
	$sql="INSERT INTO message(member_id,type,date_created,ip,wall_privacy) VALUES ('$member_id',2,'$time','$ip','1')";



mysqli_query($con, $sql) or die(mysqli_error($con));



$newwallid = mysqli_insert_id($con);

$vquery = "INSERT INTO videos (description,category, location,location1,location2,thumburl,thumburl1,thumburl2,thumburl3,thumburl4,thumburl5,title,user_id,type,url_type,date_created,msg_id,title_size,title_color,country_id,duration,custom_thumb) VALUES('$description','$category','$locationForMp4','$locationForOgg','$locationForWebm','$p400x225_path','$p400x225_path_1','$p400x225_path_2','$p400x225_path_3','$p400x225_path_4','$p400x225_path_5','$title','$member_id','$privacy','1','$time','$newwallid','$title_size','$title_color','".$country[$i]."','$duration','$custom_thumb')";

	$vsql = mysqli_query($con, $vquery)  or die(mysqli_error($con));	

	$video_id = mysqli_insert_id($con);

	

	mysqli_query($con, "UPDATE videos set parent_id = '$pvideo_id' where video_id = '$video_id'");
	
	$umsql="UPDATE message set video_id = '$video_id' where messages_id = '$newwallid'";

	mysqli_query($con, $umsql);

}

unlink($defaultThumb_1);
unlink($defaultThumb_2);
unlink($defaultThumb_3);
unlink($defaultThumb_4);
unlink($defaultThumb_5);

?> 