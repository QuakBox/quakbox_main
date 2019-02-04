<?php 
/**
   * Event_Upload_image is the action of event_view.php .. 
   * helps to upload images memo for an event
   * @package    event
   * @subpackage 
   * @author     Vishnu NCN
   * Created date  02/03/2015 08:02:16
   * Updated date  02/26/2015 12:42:05
   * Updated by    Vishnu NCN
   */
ob_start();
session_start();
$member_id = $_SESSION['SESS_MEMBER_ID'];
include('../config.php');

	$file=$_FILES['image']['tmp_name'];
	$photo_title = mysqli_real_escape_string($con, f($_POST['photo_title'],'escapeAll'));
	$event_id = mysqli_real_escape_string($con, f($_POST['event_id'],'escapeAll'));	
	$time = time();
	$ip=$_SERVER['REMOTE_ADDR'];
	
	$equery = "SELECT event_name FROM event WHERE id = '$event_id'";
	$esql = mysqli_query($con, $equery) or die(mysqli_error($con));
	$eres = mysqli_fetch_array($esql);
	$event_name = $eres['event_name'];
		
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
			move_uploaded_file($_FILES["image"]["tmp_name"],"../uploadedimage/" . $time.$_FILES["image"]["name"]);			
			$location="uploadedimage/" . $time.$_FILES["image"]["name"];
			$name=$image_name;			
			$sql="INSERT INTO event_wall(event_id,messages,member_id,date_created,ip,type) 
				VALUES ('$event_id','$location','$member_id',$time,'$ip',1)"; 
			mysqli_query($con, $sql) or die(mysqli_error($con));
			
			$message_id=mysqli_insert_id($con);
			
						
			 $checkalbum="Select * from user_album where event_id = '".$event_id."' AND type = 2";
			 $querry=mysqli_query($con, $checkalbum) or die(mysqli_error($con));
			
			//$rowscheck=mysqli_num_rows($checkalbum);
			$album_id=0;
			
			if(mysqli_num_rows($querry) >0)
			{	
				while($row1=mysqli_fetch_array($querry))
				{
					$album_id = $row1['album_id']; 
				}
				
				$insertIntoAlbum="Insert into upload_data (USER_CODE,FILE_NAME,FILE_SIZE,FILE_TYPE,date_created,album_id,msg_id,caption) VALUES  			 				('$member_id','$location','$image_size','".$file_type."',$time,'$album_id','$message_id','$photo_title') ";
				mysqli_query($con, $insertIntoAlbum) or die(mysqli_error($con));
				$photo_id = mysqli_insert_id($con);
			}
			else
			{
				
				$insertAlbumDetails="INSERT into user_album (album_user_id,album_name,event_id,type) VALUES('".$member_id."','".							  				$event_name."','$event_id',2);";
				mysqli_query($con, $insertAlbumDetails) or die(mysqli_error($con)) ;
				$album_id = mysqli_insert_id($con);
				$insertIntoAlbum="Insert into upload_data (USER_CODE,FILE_NAME,FILE_SIZE,FILE_TYPE,date_created,album_id,msg_id,caption) VALUES 		 				('$member_id','$location','$image_size','".$file_type."',$time,'$album_id','$message_id','$photo_title') ";
				mysqli_query($con, $insertIntoAlbum) or die(mysqli_error($con));
				$photo_id = mysqli_insert_id($con);
			}
		}

	if(mysqli_query($con, "Update message set photo_id=".$photo_id." where messages_id=".$message_id."") or die(mysqli_error($con)))
	




			
///////////////////// Send Notification Added By Yasser Hossam & Moshera Ahmad 9/2/2015
// Get Event Name
$event = mysqli_query($con, "SELECT  `event_name` FROM `event` WHERE id=$event_id");
$event_res = mysqli_fetch_array($event_members);
$event_name = $event_res['event_name'];


require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_send_email.php');
$member = new Member();
$email = new SendEmail();

$event_members = mysqli_query($con, "SELECT DISTINCT `member_id` FROM `event_members` WHERE `event_id` = $event_id AND `member_id` <> member_id");
$event_members_res = mysqli_fetch_array($event_members);

    foreach( $event_members_res as $row ) 
	{
	$event_member_id = $row['member_id'];
	$newsql = "INSERT  INTO notifications (sender_id, received_id, type_of_notifications, title, href, is_unread, date_created) 
	VALUES($member_id,$event_member_id,40,'Posted a new photo in the $event_name event','event_view.php?id=$event_id',0,".strtotime(date("Y-m-d H:i:s")).")";
	mysqli_query($con, $newsql) or die(mysqli_error($con));
	
	/////////////////// Send Notification Message 
	$sender_name = $member->get_member_name($member_id);
	$message_body = "<a href='https://quakbox.com/event_view.php?id=$event_id'>https://quakbox.com/event_view.php?id=$event_id</a>" ;
	 
	$subject = " Posted a new photo in the $event_name event" ;

	////////send_notification_email($sender_id,$receiver_id,$subject,$message_body,$media)
	$email->send_notification_email($member_id,$event_member_id,$subject,$message_body,"");	
	///// End Send Notification Message
	
	}
////////////////////////////////////////////////////	




		header("location: ".$base_url."events/".$event_id."");			
	exit();
}
?> 
