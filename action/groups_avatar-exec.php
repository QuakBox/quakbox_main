<?php ob_start();
include('../config.php');

	$file=$_FILES['filedata']['tmp_name'];
	$group_id = clean($_POST['groupid']);	
	$group_id	 = 	f($group_id, 'strip');
$group_id	 = 	f($group_id, 'escapeAll');
$group_id   = mysqli_real_escape_string($con, $group_id);

if (!isset($file)) 
{
	echo "";
}
else
{
	$filedata= addslashes(file_get_contents($_FILES['filedata']['tmp_name']));
	$filedata_name= addslashes($_FILES['filedata']['name']);
	$filedata_size= getimagesize($_FILES['filedata']['tmp_name']);

	
		if ($filedata_size==FALSE) 
		{	
			echo "That's not an image!";			
		}
		else
		{			
			move_uploaded_file($_FILES["filedata"]["tmp_name"],"../uploadedimage/" . $_FILES["filedata"]["name"]);			
			$location="uploadedimage/" . $_FILES["filedata"]["name"];						
			$sql="update groups set avatar='$location' where id='$group_id'";
		}
if (mysqli_query($con, $sql) or die(mysqli_error($con)))
{
	header("location: ".$base_url."groups_wall.php?group_id=".$group_id."");
	exit();			
}
	}
?> 