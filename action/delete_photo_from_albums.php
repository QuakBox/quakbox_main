<?php ob_start();
include_once('../config.php');
$msg_id = mysqli_real_escape_string($con, f($_POST['msg_id'],'escapeAll'));
if(empty($msg_id)){
	exit();
}
$msql = mysqli_query($con, "select * from upload_data where upload_data_id = '$msg_id'") or die(mysqli_error($con));
if(mysqli_num_rows($msql) == 0){
	exit();
}
$mres = mysqli_fetch_array($msql);

$url = '../uploadedimage/'.$mres['FILE_NAME'];

mysqli_query($con, "DELETE FROM upload_data WHERE upload_data_id = '".$msg_id."'") or die(mysqli_error($con));

//unlink($url);
?>