<?php ob_start();
require_once('../config.php');
foreach($_POST['check'] as $value){
$id = mysqli_real_escape_string($con, f($value,'escapeAll'));
if(empty($id)){
	exit();
}
mysqli_query($con, "DELETE FROM videos_subscribe WHERE member_id='$id'");
}
$url = $_SERVER['HTTP_REFERER'];
header("location: ".$url."");
exit();

?>