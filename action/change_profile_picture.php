<?php ob_start();
include('../config.php');
$member_id = mysqli_real_escape_string($con, f($_REQUEST['member_id'],'escapeAll'));
$photo_id = mysqli_real_escape_string($con, f($_REQUEST['image_id'],'escapeAll'));

$mquery = mysqli_query($con, "SELECT member_id,username FROM members WHERE member_id = '$member_id'");
$mres = mysqli_fetch_array($mquery);
$back_page = $base_url.'i/'.$mres['username'];

$pquery = "SELECT FILE_NAME FROM upload_data 
			WHERE upload_data_id = '$photo_id'";
$psql = mysqli_query($con, $pquery) or die(mysqli_error($con));
$presult = mysqli_fetch_array($psql);
$image_name = $presult['FILE_NAME'];			

$query = "UPDATE members SET profImage = '$image_name' WHERE member_id = '$member_id'";
$result = mysqli_query($con, $query);

header("location: ".$back_page.""); 
exit();
?>