<?php ob_start();
include_once('../config.php');
$messages_id = mysqli_real_escape_string($con, f($_POST['msg_id'],'escapeAll'));
if(empty($messages_id)){
	exit();
}
mysqli_query($con, "DELETE FROM upload_data WHERE upload_data_id='$messages_id'");

?>