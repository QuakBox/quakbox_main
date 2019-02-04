<?php ob_start();
include('../config.php');


$mystatusx = mysqli_real_escape_string($con, $_POST['mystatusx']);
$mystatusx   = f($mystatusx, 'strip');
$mystatusx	 = 	f($mystatusx, 'escapeAll');
$mystatusx   = mysqli_real_escape_string($con, $mystatusx);

$user =$_POST['name'];
$user   = f($user, 'strip');
$user	 = 	f($user, 'escapeAll');
$user   = mysqli_real_escape_string($con, $user);

$pic =$_POST['name1'];
$pic   = f($pic, 'strip');
$pic	 = 	f($pic, 'escapeAll');
$pic   = mysqli_real_escape_string($con, $pic);

$poster =$_POST['poster'];
$poster   = f($poster, 'strip');
$poster	 = 	f($poster, 'escapeAll');
$poster   = mysqli_real_escape_string($con, $poster);

$sql="INSERT INTO message (messages, user, picture, date_created, poster)
VALUES
('$mystatusx','$user','$pic','".strtotime(date("Y-m-d H:i:s"))."','$poster')";

mysqli_query($con, "UPDATE messages SET picture = '$pic' WHERE username='$user'");
if (!mysqli_query($con, $sql))
  {
  die('Error: ' . mysqli_error($con));
  }

header("location: ".$base_url."mywall.php");
exit();
?> 