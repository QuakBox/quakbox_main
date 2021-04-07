<?php ob_start();
$member_id = $_POST['member_id'];
include('../config.php');

	$file			=	$_FILES['image']['tmp_name'];
	$country 		= 	$_POST['country'];
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
						
			$sql="INSERT INTO message(messages,photo,member_id,country_flag,date_created,ip,type,wall_privacy,share_member_id,unshare_member_id) VALUES ('$location','$location','$member_id','".$country."',$time,'$ip',1,'$privacy','".$share_member."','".$unshare_member."')"; 
			
			mysqli_query($con, $sql) or die(mysqli_error($con));
			
			$message_id = mysqli_insert_id($con);
			
			//insert into news feeds
		
if(!empty($message_id)){
 $sqlnfeeds = "INSERT INTO news_feeds ";
        $sqlnfeeds.= "(`date_created`, `msg_id`) ";
        $sqlnfeeds.= "VALUES ";
        $sqlnfeeds.= "('".strtotime(date("Y-m-d H:i:s"))."', '$message_id') ";
        mysqli_query($con, $sqlnfeeds);
}
			
			
			
			$sql = mysqli_query($con, "select username from members where member_id = '$member_id' ");
					while( $row = mysqli_fetch_array($sql) ) {
						$name_album = $row['username'].' Album';
						break;
					}
					
			$sql = mysqli_query($con, "select album_id from user_album where album_user_id = '$member_id' and album_name='$name_album'");
					while( $row = mysqli_fetch_array($sql) ) {
						$album_id = $row['album_id'];
						break;
					}
			
			
				
			if($album_id != '' ){
				
				$insertIntoAlbum = "Insert into upload_data (USER_CODE,FILE_NAME,FILE_SIZE,FILE_TYPE,date_created,album_id,msg_id) VALUES ('$member_id','$name','$image_size','".$file_type."',$time,'$album_id','$message_id') ";
				mysqli_query($con, $insertIntoAlbum) or die(mysqli_error($con));
				
				
			$sql = mysqli_query($con, "select album_id from user_album where album_user_id = '$member_id' and album_name='$country'");
					while( $row = mysqli_fetch_array( $sql ) ) {
						$album_id1 = $row['album_id'];
						break;
					}
				
				if( $album_id1 != '' ){
				
				$insertIntoAlbum="Insert into upload_data (USER_CODE,FILE_NAME,FILE_SIZE,FILE_TYPE,date_created,album_id,msg_id) VALUES 		 				('$member_id','$name','$image_size','".$file_type."',$time,'$album_id1','$message_id') ";
				mysqli_query($con, $insertIntoAlbum) or die(mysqli_error($con));
				
				} else{
				
				$insertAlbumDetails="INSERT into user_album (album_user_id,album_name) VALUES('$member_id','$country');";
				
				mysqli_query($con, $insertAlbumDetails) or die(mysqli_error($con)) ;
				
				$album_id1=mysqli_insert_id($con);
				
				$insertIntoAlbum="Insert into upload_data (USER_CODE,FILE_NAME,FILE_SIZE,FILE_TYPE,date_created,album_id,msg_id) VALUES 		 				('$member_id','$name','$image_size','".$file_type."',$time,'$album_id1','$message_id') ";
				mysqli_query($con, $insertIntoAlbum) or die(mysqli_error($con));
				
				
				}				
			}
			
			else
			{	
			
				$insertAlbumDetails="INSERT into user_album (album_user_id,album_name) VALUES('$member_id','$country');";
				
				mysqli_query($con, $insertAlbumDetails) or die(mysqli_error($con)) ;
				
				$album_id=mysqli_insert_id($con);
				
				$insertIntoAlbum="Insert into upload_data (USER_CODE,FILE_NAME,FILE_SIZE,FILE_TYPE,date_created,album_id,msg_id) VALUES 		 				('$member_id','$name','$image_size','".$file_type."',$time,'$album_id','$message_id') ";
				mysqli_query($con, $insertIntoAlbum) or die(mysqli_error($con));
				
				/*$insertMemberAlbum="INSERT into user_album (album_user_id,album_name) VALUES('$member_id','$name_album');";
						
				mysqli_query($insertMemberAlbum) or die(mysqli_error()) ;
				
				$album_id=mysqli_insert_id();
				
				$insertIntoAlbum="Insert into upload_data (USER_CODE,FILE_NAME,FILE_SIZE,FILE_TYPE,date_created,album_id,msg_id) VALUES 		 				('$member_id','$name','$image_size','".$file_type."',$time,'$album_id','$message_id') ";
				mysqli_query($insertIntoAlbum) or die(mysqli_error());*/
			}
		}
		
	mysqli_query($con, "Update message set msg_album_id=".$album_id." where messages_id=".$message_id."") or die(mysqli_error($con));
	header("location: ".$base_url."country_wall.php?country=".$country."");			
	exit();
}
?> 


