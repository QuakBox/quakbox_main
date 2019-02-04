<?php 
 session_start();

if(!isset($_SESSION['id']))
{
	header("location:login.php");
}
include("config.php");
$name=$_POST['name'];
$url=$_POST['url'];
$status  = $_POST['status'];
//$name=$_POST['name'];
/*$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);

if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/x-png")
|| ($_FILES["file"]["type"] == "image/png"))
&& ($_FILES["file"]["size"] < 20000)
&& in_array($extension, $allowedExts)) {*/
  //if ($_FILES["file"]["error"] > 0) {
   // echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
  //} else {
    /*echo "Upload: " . $_FILES["file"]["name"] . "<br>";
    echo "Type: " . $_FILES["file"]["type"] . "<br>";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";
   // if (file_exists("upload/" . $_FILES["file"]["name"])) {
      echo $_FILES["file"]["name"] . " already exists. ";*/
    //} else {
    //print_r( $_FILES );
	if ($_FILES["file"]["error"] == 0){
	 
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "../app_images/" . $_FILES["file"]["name"]);
      //"Stored in: " . "app_images/" . $_FILES["file"]["name"];
	  $image="../app_images/" . $_FILES["file"]["name"];
	}
   // }
 // }
/*} else {
  echo "Invalid file";
}*/
if(isset($_POST['update']))
{
	$id=$_POST['update'];
	$query=mysqli_query($conn,"update app set name='$name',url='$url',image='$image',status='$status' where id='$id'" )or die(mysqli_error($conn));
	header("location:apps_table.php");
}
else
{
$query=mysqli_query($conn,"insert into app (name,url,image,status) values ('$name','$url','$image','1')")or die(mysqli_error($conn));
}
header("location:apps_table.php");
?>


