<?php ob_start();
include_once '../config.php';	
		
	if($_POST != array())
	{
		foreach ($_POST['email'] as $id){
		 $id = mysqli_real_escape_string($con, f($id,'escapeAll'));
			mysqli_query($con, "delete from import_contact where id = '$id'") or die(mysqli_error($con));
			
			}
		}

header('location: '.$base_url.'import_contact.php');
exit();
?>