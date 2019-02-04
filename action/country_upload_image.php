<?php ob_start();
$member_id = $_POST['member_id'];
include('../config.php');

	$file			=	$_FILES['image']['tmp_name'];
	$country 		= 	mysqli_real_escape_string($con, f($_POST['country'],'escapeAll'));
	$privacy 		= 	mysqli_real_escape_string($con, f($_POST['privacy'],'escapeAll'));
	$time 			= 	time();
	$ip				=	$_SERVER['REMOTE_ADDR'];
	$share_member 	= 	mysqli_real_escape_string($con, f($_POST['photo_custom_share'],'escapeAll'));	
	$unshare_member = 	mysqli_real_escape_string($con, f($_POST['photo_custom_unshare'],'escapeAll'));
	
	$cquery = mysqli_query($con,"SELECT country_id FROM geo_country = '$country'");
	$csql = mysqli_fetch_array($cquery);
	$country_id = $csql['country_id'];
	
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
			move_uploaded_file($_FILES["image"]["tmp_name"],"../uploadedimage/" . $_FILES["image"]["name"]);			
			$location="uploadedimage/" . $_FILES["image"]["name"];
			$name=$image_name;
						
			$sql="INSERT INTO message(messages,member_id,country_flag,date_created,ip,type,wall_privacy,share_member_id,unshare_member_id) VALUES ('$location','$member_id','".$country."',$time,'$ip',1,'$privacy','".$share_member."','".$unshare_member."')"; 
			
			mysqli_query($con, $sql) or die(mysqli_error($con));
			
			$message_id = mysqli_insert_id($con);
			
			$sql = mysqli_query($con, "select album_id from user_album where album_name='$country'");
					while( $row = mysqli_fetch_array( $sql ) ) 
					{
						$album_id1 = $row['album_id'];
						break;
					}
				
				if( $album_id1 != '' )
				{
				
				$insertIntoAlbum="Insert into upload_data (USER_CODE,FILE_NAME,FILE_SIZE,FILE_TYPE,date_created,album_id,msg_id) VALUES 		 				('$member_id','$location','$image_size','".$file_type."',$time,'$album_id1','$message_id') ";
				mysqli_query($con, $insertIntoAlbum) or die(mysqli_error($con));
				
				} 
				else
				{				
					$insertAlbumDetails="INSERT into user_album (album_user_id,album_name,type,country_id) 
										VALUES('$member_id','$country',1,'$country_id');";
				
					mysqli_query($con, $insertAlbumDetails) or die(mysqli_error($con)) ;
				
					$album_id1=mysqli_insert_id($con);
				
					$insertIntoAlbum="Insert into upload_data (USER_CODE,FILE_NAME,FILE_SIZE,FILE_TYPE,date_created,album_id,msg_id) VALUES 		 				('$member_id','$location','$image_size','".$file_type."',$time,'$album_id1','$message_id') ";
				mysqli_query($con, $insertIntoAlbum) or die(mysqli_error($con));
				
				
				}				
			
		}
		
	mysqli_query($con, "Update message set msg_album_id=".$album_id1." where messages_id=".$message_id."") or die(mysqli_error($con));
	header("location: ".$base_url."country_wall.php?country=".$country."");	
	exit();		
	
}
?> 



