<?php
session_start();
include('config.php');
$imgdesc=$_POST['imgdesc'];
$imgid=$_POST['imgid'];
$album_id=$_POST['album_id'];
$imgcapt=$_POST['imgcapt'];

$sql="update upload_data set caption='$imgcapt',description='$imgdesc' where upload_data_id=$imgid";
mysqli_query($con, $sql);
//echo $sql;
//echo $imgid;
?>