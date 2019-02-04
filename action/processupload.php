<?php 
/**
   * @package    action
   * @subpackage 
   * @author     Vishnu
   * Created date  02/05/2015 
   * Updated date  03/13/2015 
   * Updated by    Vishnu S
 **/
ob_start();
session_start();
include('../config.php');
$member_id=$_POST['member_id'];
$member_id   = f($member_id, 'strip');
$member_id	 = 	f($member_id, 'escapeAll');
$member_id   = mysqli_real_escape_string($con, $member_id);

$title	 = 	f($_POST['title'], 'escapeAll');
$title   = mysqli_real_escape_string($con, $title);

$country_id=$_POST['country_id'];
$country_id   = f($country_id, 'strip');
$country_id	 = 	f($country_id, 'escapeAll');
$country_id   = mysqli_real_escape_string($con, $country_id);

//echo $country_id;

$title = mysqli_real_escape_string($con, $_POST['title']);
$description = mysqli_real_escape_string($con, $_POST['description']);
$category = mysqli_real_escape_string($con, $_POST['category']);
$ip=$_SERVER['REMOTE_ADDR'];



$videopath="";
$imagepath="";

$upload_dir = '../test/';  
$upload_dir2 = '../test/';
 if(isset($_FILES['imageInput']['name']))
 {
     $temp_name = $_FILES['imageInput']['tmp_name'];  
      $file_name = $_FILES['imageInput']['name'];  
      $file_path = $upload_dir.$file_name;
	  $file_type=$_FILES['imageInput']['type'];
	  move_uploaded_file($temp_name, $file_path);
	 // echo "yes";
	  $videopath="test/".$file_name;
}
if(isset($_FILES['image']['name']))
 {
     $temp_name = $_FILES['image']['tmp_name'];  
      $file_name = $_FILES['image']['name'];  
      $file_path = $upload_dir2.$file_name;
	  $file_type=$_FILES['image']['type'];
	  move_uploaded_file($temp_name, $file_path);
	 // echo "yes";
	  
	  $imagepath="test/".$file_name;
}
//echo "videopath=".$videopath;
//echo "imagepath=".$imagepath;

function friendlyURL($string){
	$string = preg_replace_callback("`\[.*\]`U",function ($matches) {return '';},$string);
	$string = preg_replace_callback('`&(amp;)?#?[a-z0-9]+;`i',function ($matches) {return '-';},$string);
	$string = htmlentities($string, ENT_COMPAT, 'utf-8');
	$string = preg_replace_callback( "`&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);`i",function ($matches) {return $matches[1];}, $string );
	$string = preg_replace_callback( array("`[^a-z0-9]`i","`[-]+`") ,function ($matches) {return '-';}, $string);
	return strtolower(trim($string, '-'));
}


$myFriendlyURL = friendlyURL($title);

$sql = "insert into news(image_url,video_url,title,description,member_id,country_id,date_created,ip,category_id,url,status) 
			values('$imagepath','$videopath','$title','$description','$member_id','$country_id',now(),'$ip','$category','$myFriendlyURL',1)";
//echo $sql;
mysqli_query($con, $sql) or die(mysqli_error($con));
		  
?>