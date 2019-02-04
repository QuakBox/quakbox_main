<?php ob_start();
$member_id = $_POST['member_id'];
include('../config.php');

	$file			=	$_FILES['image']['tmp_name'];
	$mname 		= 	$_POST['mname']." ".Album;
	$privacy 		= 	$_POST['privacy'];
	$time 			= 	time();
	$ip				=	$_SERVER['REMOTE_ADDR'];
	$share_member 	= 	$_POST['photo_custom_share'];	
	$unshare_member = 	$_POST['photo_custom_unshare'];
	
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
						
			$sql="INSERT INTO message(messages,member_id,date_created,ip,type,wall_privacy,share_member_id,unshare_member_id) VALUES ('$location','$member_id',$time,'$ip',1,'$privacy','".$share_member."','".$unshare_member."')"; 
			
			mysqli_query($con, $sql) or die(mysqli_error($con));
			
			$message_id = mysqli_insert_id($con);
			
			//insert query into news feeds			
			if(!empty($message_id)){
 $sqlnfeeds = "INSERT INTO news_feeds ";
        $sqlnfeeds.= "(`date_created`, `msg_id`) ";
        $sqlnfeeds.= "VALUES ";
        $sqlnfeeds.= "('".strtotime(date("Y-m-d H:i:s"))."', '$message_id') ";
        mysqli_query($con, $sqlnfeeds);
}
			
			$checkalbum = "Select * from user_album where album_user_id = '".$member_id."' and album_name = '".$mname."'";
			$querry = mysqli_query($con, $checkalbum) or die(mysqli_error($con));
			
			//$rowscheck=mysqli_num_rows($checkalbum);
			$album_id=0;
		
			if(mysqli_num_rows($querry) >0)
			{	
				while($row1=mysqli_fetch_array($querry))
				{
					echo $album_id=$row1['album_id']; 
				}
				
				echo $insertIntoAlbum="Insert into upload_data (USER_CODE,FILE_NAME,FILE_SIZE,FILE_TYPE,date_created,album_id,msg_id) VALUES  			 				('$member_id','$location','$image_size','".$file_type."',$time,'$album_id','$message_id') ";
				mysqli_query($con, $insertIntoAlbum) or die(mysqli_error($con));
			}
			else
			{	
			
/*				if( $country == ''){
			
						$sql = mysqli_query("select username from members where menber_id='".$member_id."'");
					while( $row = mysqli_fetch_array( $sql ) ) {
						$country = $row['username'];
						break;	
					}
				}	*/
						
				$insertAlbumDetails="INSERT into user_album (album_user_id,album_name) VALUES('".$member_id."','".$mname."');";
				
				mysqli_query($con, $insertAlbumDetails) or die(mysqli_error($con)) ;
				
				$album_id=mysqli_insert_id($con);
				
				$insertIntoAlbum="Insert into upload_data (USER_CODE,FILE_NAME,FILE_SIZE,FILE_TYPE,date_created,album_id,msg_id) VALUES 		 				('$member_id','$location','$image_size','".$file_type."',$time,'$album_id','$message_id') ";
				mysqli_query($con, $insertIntoAlbum) or die(mysqli_error($con));
			}
		}





	if(mysqli_query($con, "Update message set msg_album_id=".$album_id." where messages_id=".$message_id."") or die(mysqli_error($con)))
	header("location: ".$base_url."mywall.php");
	exit();			
	
}
?> 

