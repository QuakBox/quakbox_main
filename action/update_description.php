<?php ob_start();
session_start();
include('../config.php');
if($_POST['data'])
{
$data = f($_POST['data'] , 'escapeAll');
$data = mysqli_real_escape_string($con, $data);
$c_id = f($_POST['c_id'], 'strip');
$c_id = f($c_id , 'escapeAll');
$c_id = mysqli_real_escape_string($con, $c_id);
$sql = "UPDATE upload_data set description='$data' where upload_data_id = '$c_id'";
mysqli_query($con, $sql);
echo $data;
}
?>