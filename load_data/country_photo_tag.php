
<?php 
include('../config.php');

if( isset($_REQUEST['tag_text'])) {
	$photo_id = (int)$_REQUEST['photo_id'];
	$tag_text = mysqli_real_escape_string($con, f($_REQUEST['tag_text'],'escapeAll'));
	$div_top = mysqli_real_escape_string($con, f($_REQUEST['div_top'],'escapeAll'));
	$div_left = mysqli_real_escape_string($con, f($_REQUEST['div_left'],'escapeAll'));

	$sql = "INSERT INTO country_photo_tag values('','','$photo_id','','$tag_text','$div_top','$div_left')"; 
	
	$query = mysqli_query($con, $sql);
	
}
?>