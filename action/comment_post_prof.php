<?php ob_start();
include_once('../config.php'); 

$messages = clean($_POST['postcomment'], $con);
$user =clean($_POST['user'], $con);
$pic =clean($_POST['pic'], $con);
$postid =clean($_POST['postid'],$con);

$sql="INSERT INTO postcomment (content, commentedby, pic, id, date_created)
VALUES
('$messages','$user','$pic','$postid','".strtotime(date("Y-m-d H:i:s"))."')";

if (!mysqli_query($con, $sql))
  {
  die('Error: ' . mysqli_error($con));
  }
header("location: ".$base_url."mywall.php");
exit();

?>
