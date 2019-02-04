<?php
/**
   * @package    action
   * @subpackage event_cover-exec.php
   * @author     Vishnu 
   * Created date  02/11/2015 04:40:05
   * Updated date  03/25/2015 07:37:05
   * Updated by    VishnuNCN
 **/
 session_start();
ob_start();
include('../config.php');
$session_uid = $_SESSION['SESS_MEMBER_ID'];
$event_id = mysqli_real_escape_string($con, f($_POST['event_id'],'escapeAll'));
$cover = $_FILES['cover']['tmp_name'];

$image_size = getimagesize($_FILES['cover']['tmp_name']);
if($image_size == FALSE)
{
}
else
{
	
		$uploaddir = '../uploadedimage/';
		$file = $uploaddir . basename($_FILES['cover']['name']);
			
		move_uploaded_file($_FILES['cover']['tmp_name'], $file);
		$location="uploadedimage/" . $_FILES["cover"]["name"]; 
					  
		$sql = "update event set cover='$location'
						where id='$event_id' AND event_host = '$session_uid ' ";	
			  mysqli_query($con, $sql);
		
					
}

header("location:".$base_url."event_view.php?id=".$event_id."");


?>