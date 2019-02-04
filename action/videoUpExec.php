<?php 
error_reporting(-1);
ob_start();

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

include($_SERVER['DOCUMENT_ROOT'].'/config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_security.php');



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

//print_r($_POST['country']);

$country     = $_POST['country'];
$country		 = 	$country;

$dThumb     = f($_POST['defaultthumbnail'], 'strip');
$dThumb		 = 	f($dThumb, 'escapeAll');
$dThumb 	     = mysqli_real_escape_string($con, $dThumb);

$NameWithoutExtension     = f($_POST['nwe'], 'strip');
$NameWithoutExtension		 = 	f($NameWithoutExtension, 'escapeAll');
$NameWithoutExtension 	     = mysqli_real_escape_string($con, $NameWithoutExtension);

$ip = $_SERVER['REMOTE_ADDR'];

$locationForMp4 = "uploadedvideo/new".$NameWithoutExtension.".mp4";

$locationForOgg = "uploadedvideo/new".$NameWithoutExtension.".ogg";

$locationForWebm = "uploadedvideo/new".$NameWithoutExtension.".webm";

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
$defaultThumb_11 = __DIR__."/../uploadedvideo/videothumb/new".$NameWithoutExtension."01.png";
$p400x225_1 = __DIR__."/../uploadedvideo/videothumb/p400x225new".$NameWithoutExtension."01.png";
$p400x225_11 = "uploadedvideo/videothumb/p400x225new".$NameWithoutExtension."01.png";
$p200x150_1 = __DIR__."/../uploadedvideo/videothumb/p200x150new".$NameWithoutExtension."01.png";
$image400x225_1 = new Imagick($defaultThumb_11);
    $image400x225_1->adaptiveResizeImage(400,225);
	$image400x225_1->setImageFormat( "png" );
    $image400x225_1->writeImage($p400x225_1);
     $image200x150_1 = new Imagick($defaultThumb_11);
    $image200x150_1->adaptiveResizeImage(200,150);
   $image200x150_1->setImageFormat( "png" );
    $image200x150_1->writeImage($p200x150_1);
    
    



$p400x225_path_2="new".$NameWithoutExtension."02.png";
$defaultThumb_2 = $base_url."uploadedvideo/videothumb/new".$NameWithoutExtension."02.png";
$defaultThumb_21 = __DIR__."/../uploadedvideo/videothumb/new".$NameWithoutExtension."02.png";
$p400x225_2 = __DIR__."/../uploadedvideo/videothumb/p400x225new".$NameWithoutExtension."02.png";
$p200x150_2 = __DIR__."/../uploadedvideo/videothumb/p200x150new".$NameWithoutExtension."02.png";
$image400x225_2 = new Imagick($defaultThumb_21);
    $image400x225_2->adaptiveResizeImage(400,225);
   $image400x225_2->setImageFormat( "png" );
    $image400x225_2->writeImage($p400x225_2);
    
    
    $image200x150_2 = new Imagick($defaultThumb_21);
    $image200x150_2->adaptiveResizeImage(200,150);
   $image200x150_2->setImageFormat( "png" );
    $image200x150_2->writeImage($p200x150_2);
    
$p400x225_path_3="new".$NameWithoutExtension."03.png";
$defaultThumb_3 = $base_url."uploadedvideo/videothumb/new".$NameWithoutExtension."03.png";
$defaultThumb_31 = __DIR__."/../uploadedvideo/videothumb/new".$NameWithoutExtension."03.png";
$p400x225_3 = __DIR__."/../uploadedvideo/videothumb/p400x225new".$NameWithoutExtension."03.png";
$p200x150_3 = __DIR__."/../uploadedvideo/videothumb/p200x150new".$NameWithoutExtension."03.png";
$image400x225_3 = new Imagick($defaultThumb_31);
    $image400x225_3->adaptiveResizeImage(400,225);
   $image400x225_3->setImageFormat( "png" );
    $image400x225_3->writeImage($p400x225_3);
    
     $image200x150_3 = new Imagick($defaultThumb_31);
    $image200x150_3->adaptiveResizeImage(200,150);
   $image200x150_3->setImageFormat( "png" );
    $image200x150_3->writeImage($p200x150_3);
    
$p400x225_path_4="new".$NameWithoutExtension."04.png";
$defaultThumb_4 = $base_url."uploadedvideo/videothumb/new".$NameWithoutExtension."04.png";
$defaultThumb_41 = __DIR__."/../uploadedvideo/videothumb/new".$NameWithoutExtension."04.png";
$p400x225_4 = __DIR__."/../uploadedvideo/videothumb/p400x225new".$NameWithoutExtension."04.png";
$p200x150_4 = __DIR__."/../uploadedvideo/videothumb/p200x150new".$NameWithoutExtension."04.png";
$image400x225_4 = new Imagick($defaultThumb_41);
    $image400x225_4->adaptiveResizeImage(400,225);
   $image400x225_4->setImageFormat( "png" );
    $image400x225_4->writeImage($p400x225_4);
    
     $image200x150_4 = new Imagick($defaultThumb_41);
    $image200x150_4->adaptiveResizeImage(200,150);
   $image200x150_4->setImageFormat( "png" );
    $image200x150_4->writeImage($p200x150_4);
    

$p400x225_path_5="new".$NameWithoutExtension."05.png";
$defaultThumb_5 = $base_url."uploadedvideo/videothumb/new".$NameWithoutExtension."05.png";
$defaultThumb_51 = __DIR__."/../uploadedvideo/videothumb/new".$NameWithoutExtension."05.png";
$p400x225_5 = __DIR__."/../uploadedvideo/videothumb/p400x225new".$NameWithoutExtension."05.png";
$p200x150_5 = __DIR__."/../uploadedvideo/videothumb/p200x150new".$NameWithoutExtension."05.png";
$image400x225_5 = new Imagick($defaultThumb_51);
    $image400x225_5->adaptiveResizeImage(400,225);
   $image400x225_5->setImageFormat( "png" );
    $image400x225_5->writeImage($p400x225_5);
    
    
     $image200x150_5 = new Imagick($defaultThumb_51);
    $image200x150_5->adaptiveResizeImage(200, 150);
   $image200x150_5->setImageFormat( "png" );
    $image200x150_5->writeImage($p200x150_5);
	

// extension_loaded('ffmpeg') or die('Error in loading ffmpeg');
require_once('../qb_classes/ffmpeg-php/FFmpegAutoloader.php');

$ffmpegInstance = new ffmpeg_movie("../".$locationForMp4);

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

//echo $country;



if($country != 'null' )

	{
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/country_menu.php');
require_once($_SERVER['DOCUMENT_ROOT']."/qb_classes/connection/qb_database.php");
$miscObjCountry=new misc();	
$db_Obj = new database();	
$values = implode(',', $country);

	//$sql="INSERT INTO message(member_id,type,date_created,ip,wall_privacy,wall_type) VALUES ('$member_id',2,'$time','$ip','1','89')";

	$QbSecurityPost=new QB_SqlInjection();
	
	$countryResult=$miscObjCountry->getcountryByID($country[0]);
	//print_r($countryResult);
	foreach($countryResult as $valueCountryResult){
		$countryID=$valueCountryResult['country_id'];
		$countryTitle=$valueCountryResult['country_title'];
	}
	
	$encryptedCountry=base64_encode($QbSecurityPost->Qbencrypt($countryTitle,ENC_KEY));
	$encryptedCountry=$countryTitle;

		$wallItem = $countryTitle;
		
		$userId =$QbSecurityPost->QB_AlphaID($wallItem,true);
		$sqlForUsername = "SELECT username FROM member WHERE member_id = '$userId' ";
		$UsernameResult = $db_Obj->execQuery($sqlForUsername);
					while( $fetchUsername = mysqli_fetch_array( $UsernameResult ) ) {
						$wallItem = $fetchUsername['username'];
						break;
					}
	


	$sql = "INSERT INTO message (member_id,messages,country_flag,type,wall_privacy,date_created,ip,url_title,description,wall_type) 
			VALUES('$member_id','$title','$wallItem',2,'1','$time','$ip','','$description','89');";	


mysqli_query($con, $sql) or die(mysqli_error($con));



$newwallid = mysqli_insert_id($con);

	$vquery = "INSERT INTO videos (description,category, location,location1,location2,thumburl,thumburl1,thumburl2,thumburl3,thumburl4,thumburl5,title,user_id,type,url_type,date_created,msg_id,title_size,title_color,country_id,duration,custom_thumb) VALUES('$description','$category','$locationForMp4','$locationForOgg','$locationForWebm','$p400x225_path','$p400x225_path_1','$p400x225_path_2','$p400x225_path_3','$p400x225_path_4','$p400x225_path_5','$title','$member_id','$privacy','1','$time','$newwallid','$title_size','$title_color','".$values."','$duration','$custom_thumb')";

	$vsql = mysqli_query($con, $vquery)  or die(mysqli_error($con));	

	$video_id = mysqli_insert_id($con);

	

	mysqli_query($con, "UPDATE videos set parent_id = '$pvideo_id' where video_id = '$video_id'");
	
	$umsql="UPDATE message set video_id = '$video_id' where messages_id = '$newwallid'";

	mysqli_query($con, $umsql);

	

	

} else {


//$wallItem='world';
	
//	$sql="INSERT INTO message(member_id,type,date_created,ip,wall_privacy,wall_type) VALUES ('$member_id',2,'$time','$ip','1','88')";

$sql = "INSERT INTO message (member_id,messages,country_flag,type,wall_privacy,date_created,ip,url_title,description,wall_type) 
			VALUES('$member_id','$title','$wallItem',2,'1','$time','$ip','','$description','');";	

mysqli_query($con, $sql) or die(mysqli_error($con));



$newwallid = mysqli_insert_id($con);

$vquery = "INSERT INTO videos (description,category, location,location1,location2,thumburl,thumburl1,thumburl2,thumburl3,thumburl4,thumburl5,title,user_id,type,url_type,date_created,msg_id,title_size,title_color,country_id,duration,custom_thumb) VALUES('$description','$category','$locationForMp4','$locationForOgg','$locationForWebm','$p400x225_path','$p400x225_path_1','$p400x225_path_2','$p400x225_path_3','$p400x225_path_4','$p400x225_path_5','$title','$member_id','$privacy','1','$time','$newwallid','$title_size','$title_color','".$country."','$duration','$custom_thumb')";

	$vsql = mysqli_query($con, $vquery)  or die(mysqli_error($con));	

	$video_id = mysqli_insert_id($con);

	

	mysqli_query($con, "UPDATE videos set parent_id = '$pvideo_id' where video_id = '$video_id'");
	
	$umsql="UPDATE message set video_id = '$video_id' where messages_id = '$newwallid'";

	mysqli_query($con, $umsql);

}

/*unlink($defaultThumb_11);
unlink($defaultThumb_21);
unlink($defaultThumb_31);
unlink($defaultThumb_41);
unlink($defaultThumb_51);
*/
?> 