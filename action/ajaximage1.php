<?php ob_start();
include('../config.php');

$session_id = $_POST['member_id'];// User session id

$path = "../uploads/";
$countryid=$_POST['country'];
$countryid	 = 	f($countryid, 'strip');
$countryid	 = 	f($countryid, 'escapeAll');
$countryid   = mysqli_real_escape_string($con, $countryid);

list($width, $height) = getimagesize($_FILES['image']['tmp_name']);
//echo $width;
//echo $height;

echo "hiihi";
exit;
function getExtension($str)
{
$i = strrpos($str,".");
if (!$i)
{
return "";
}
$l = strlen($str) - $i;
$ext = substr($str,$i+1,$l);
return $ext;
}

$valid_formats = array("jpg", "png", "gif", "bmp","jpeg","PNG","JPG","JPEG","GIF","BMP");
if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
{
$name = $_FILES['image']['name'];
$size = $_FILES['image']['size'];
$time = time();
if(strlen($name))
{
$ext = getExtension($name);
if(in_array($ext,$valid_formats))
{
if($size<(1024*5120)) // Image size max 1 MB
{
$actual_image_name = time().$session_id.".".$ext;
$tmp = $_FILES['image']['tmp_name'];
$file=$tmp;

$p400x250 = 'p400x250'.$actual_image_name;
$p400x250_path=$path.'p400x250'.$actual_image_name;
$image160x160 = new Imagick($file );
$image160x160->adaptiveResizeImage($width,$height);
$image160x160->writeImage($p400x250_path);
//Insert upload image files names into user_uploads table
mysqli_query($con, "INSERT INTO user_uploads(image_name,user_id_fk,created) VALUES('".$p400x250."','$session_id','$time')");
$id = mysqli_insert_id($con);


echo "<img  style='width: 100%; height:auto;' src='".$base_url."uploads/$p400x250' class='preview' id='".$id."'>";

?>
<textarea name="description" id="photo_description" placeholder="Description"></textarea>

<?php

//}
//else
//echo "failed";
}
else
echo "Image file size max 1 MB";
}
else
echo "Invalid file format..";
}
else
echo "Please select image..!";
exit;
}
?>