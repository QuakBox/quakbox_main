<?php ob_start();
$member_id = $_POST['member_id'];
include('../config.php');

	$file=$_FILES['image']['tmp_name'];
	$group_id = $_POST['group_id'];
	$group_id	 = 	f($group_id, 'strip');
$group_id	 = 	f($group_id, 'escapeAll');
$group_id   = mysqli_real_escape_string($con, $group_id);

	$group_name = $_POST['group_name'];
	$group_name	 = 	f($group_name, 'strip');
$group_name	 = 	f($group_name, 'escapeAll');
$group_name   = mysqli_real_escape_string($con, $group_name);

	$photo_title = $_POST['photo_title'];
	$photo_title	 = 	f($photo_title, 'strip');
$photo_title	 = 	f($photo_title, 'escapeAll');
$photo_title   = mysqli_real_escape_string($con, $photo_title);
	
	$time = time();
	$ip=$_SERVER['REMOTE_ADDR'];
		
if (!isset($file)) 
{
	echo "";
}
else
{
	$image= addslashes(file_get_contents($_FILES['image']['tmp_name']));
	$image_name= addslashes($_FILES['image']['name']);
	$image_size= getimagesize($_FILES['image']['tmp_name']);
	$file_type='image/jpeg';
	
		if ($image_size==FALSE) 
		{	
			echo "That's not an image!";			
		}
		else
		{			
			$album_id=0;
			move_uploaded_file($_FILES["image"]["tmp_name"],"../group_photo/" . $time.$_FILES["image"]["name"]);			
			$location = $time.$_FILES["image"]["name"];
			$name = $image_name;
						
			$sql="INSERT INTO groups_wall(messages,member_id,group_id,date_created,ip,type) 
				VALUES ('$location','$member_id','".$group_id."',$time,'$ip',1)"; 
			mysqli_query($con,$sql) or die(mysqli_error($con));
			$message_id=mysqli_insert_id();
			
						
			 $checkalbum="Select * from groups_album where album_group_id = '".$group_id."' and album_name = '".$group_name."'";
			 $querry=mysqli_query($con, $checkalbum) or die(mysqli_error($con));
			
			$album_id=0;
			
			if(mysqli_num_rows($querry) >0)
			{	
				while($row1=mysqli_fetch_array($querry))
				{
					echo $album_id = $row1['album_id']; 
				}
				
				echo $insertIntoAlbum="Insert into groups_photo (group_id,member_id,FILE_NAME,date_created,album_id,msg_id,caption) VALUES  			 				('$group_id','$member_id','$location',$time,'$album_id','$message_id','$photo_title') ";
				mysqli_query($con, $insertIntoAlbum) or die(mysqli_error($con));
			}
			else
			{
				
				$insertAlbumDetails="INSERT into groups_album (album_group_id,album_name) VALUES('".$group_id."','".$group_name."');";
				mysqli_query($con, $insertAlbumDetails) or die(mysqli_error($con));
				
				$album_id=mysqli_insert_id($con);
				
				$insertIntoAlbum="Insert into groups_photo (group_id,member_id,FILE_NAME,date_created,album_id,msg_id,caption) VALUES('$group_id','$member_id','$location',$time,'$album_id','$message_id','$photo_title') ";
				mysqli_query($con, $insertIntoAlbum) or die(mysqli_error($con));
			}
		}

	
	
	$url = $_SERVER['HTTP_REFERER'];
header("location: ".$url."");
exit();
					
}
?> 
