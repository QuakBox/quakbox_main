 <?php 

/**
   * @package    action
   * @subpackage 
   * @author     Vishnu 
   * Created date  02/11/2015 04:40:05
   * Updated date  02/23/2015 05:00:05
   * Updated by    Vishnu S
 **/
 include_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_security.php');
 require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_lookup.php');
 $QbSecurityPost=new QB_SqlInjection();
 $objLookupClass=new lookup();
 
 	//Start session
	//session_start();//commented by vishnu since session is not used any where
	ob_start();
	
	//Include database connection details
	include '../config.php';
	$member_id = isset($_POST['member_id']) ? $_POST['member_id'] : '';
	//HTML tags are stripped from the string before it is used.
	$member_id=f($member_id, 'strip');
	//HTML and special characters are escaped from the string before it is used.
	$member_id=f($member_id, 'escapeAll');
	//Escape special characters
	$member_id=mysqli_real_escape_string($con, $member_id);
	$msg_id = isset($_REQUEST['msg_id']) ? $_REQUEST['msg_id'] : '';	
	//HTML tags are stripped from the string before it is used.
	
	$msg_id=f($msg_id, 'strip');
	
	//HTML and special characters are escaped from the string before it is used.
	$msg_id=f($msg_id, 'escapeAll');
	//Escape special characters
	$msg_id=mysqli_real_escape_string($con, $msg_id);	
	$desciption = isset($_POST['share_status']) ? $_POST['share_status'] : '';
	//HTML tags are stripped from the string before it is used.
	$desciption=f($desciption, 'strip');
	//HTML and special characters are escaped from the string before it is used.
	$desciption=f($desciption, 'escapeAll');
	//Insert line breaks where newlines (\n) occur in the string
	$desciption = nl2br($desciption);
	//Escape special characters
	$desciption = mysqli_real_escape_string($con, $desciption);
	$privacy=isset($_POST['privacy']) ? $_POST['privacy'] : '';
	//HTML tags are stripped from the string before it is used.
	$privacy=f($privacy, 'strip');
	//HTML and special characters are escaped from the string before it is used.
	$privacy=f($privacy, 'escapeAll');
	//Escape special characters 
	$privacy=mysqli_real_escape_string($con, $privacy);	
	$friend_name = isset($_REQUEST['friend_name']) ? $_REQUEST['friend_name'] : '';
	//HTML tags are stripped from the string before it is used.	
	$friend_name=f($friend_name, 'strip');
	//HTML and special characters are escaped from the string before it is used.
	$friend_name=f($friend_name, 'escapeAll');
	//Escape special characters
	$friend_name=mysqli_real_escape_string($con, $friend_name);	
	$group_name = isset($_POST['group_name']) ? $_POST['group_name'] : '';
	//HTML tags are stripped from the string before it is used.
	$group_name=f($group_name, 'strip');
	//HTML and special characters are escaped from the string before it is used.
	$group_name=f($group_name, 'escapeAll');
	//Escape special characters
	$group_name= mysqli_real_escape_string($con, $group_name);	
	$country_name = isset($_POST['countries']) ? $_POST['countries'] : '';
	//HTML tags are stripped from the string before it is used.
	$world = isset($_POST['world']) ? $_POST['world'] : '';
	//HTML tags are stripped from the string before it is used.
	$world=f($world, 'strip');
	//HTML and special characters are escaped from the string before it is used.
	$world=f($world, 'escapeAll');
	//Escape special characters
	$world=mysqli_real_escape_string($con, $world);	
	$hiddenDivElement = isset($_REQUEST['hiddenIDForSelection']) ? $_REQUEST['hiddenIDForSelection'] : '';
	//HTML tags are stripped from the string before it is used.
	$hiddenDivElement=f($hiddenDivElement, 'strip');
	//HTML and special characters are escaped from the string before it is used.
	$hiddenDivElement=f($hiddenDivElement, 'escapeAll');
	//Escape special characters
	$hiddenDivElement=mysqli_real_escape_string($con, $hiddenDivElement);	
	$time = time();
	$ip = $_SERVER['REMOTE_ADDR'];	
	//Break a string into an array			
	$freinds_n = explode(",",$friend_name);
	//Break a string into an array
	$groups_n = explode(",",$group_name);
		
	try
	{		//Query to fetch values from tables message,member and upload_data
			$msql = mysqli_query($con, "SELECT msg.messages_id, msg.msg_album_id, msg.messages, 
			msg.type, m.member_id,msg.video_id,msg.share_id,u.FILE_NAME,u.album_id,
			m.username, u.upload_data_id FROM message msg 
			LEFT JOIN member m ON msg.member_id = m.member_id 
			LEFT JOIN upload_data u ON msg.messages_id = u.msg_id			 
			WHERE msg.messages_id = '$msg_id'")or die(mysqli_error($con));
			
			
			$mres = mysqli_fetch_array($msql);
			$messages_id = $mres['messages_id'];
			//Insert line breaks where newlines (\n) occur in the string
			$messages = nl2br($mres['messages']);
			//Escape special characters
			$messages = mysqli_real_escape_string($con, $messages);
	
			$msg_memberid = $mres['member_id'];
			$type = $mres['type'];
			$album_id = $mres['msg_album_id'];
			$photo_id = $mres['upload_data_id'];
			$video_id = $mres['video_id'];
			$file_name = $mres['FILE_NAME'];
			$calbum_id = $mres['album_id'];
			$share_check = $mres['share_id'];
			if($share_check==0)
			{
				$share_id_insert=$messages_id;
			}
			else
			{
				$share_id_insert=$share_check;
			}
			//Query to fetch values from tables videos ,member and videos_category 
			$pvquery = "SELECT v.location,v.location1,v.location2, v.thumburl, v.thumburl1,v.thumburl2,v.thumburl3,v.thumburl4,v.thumburl5,
			 v.title, v.video_id, v.date_created, v.view_count,v.description,
			v.url_type, v.msg_id, v.category, m.username,v.title_color,v.title_size,v.type, m.username
			FROM videos v LEFT JOIN videos_category c ON v.category = c.id
			LEFT JOIN member m ON m.member_id = v.user_id 
			WHERE v.msg_id = '$msg_id'";
			$pvsql = mysqli_query($con, $pvquery) or die(mysqli_error($con));
			$pvres = mysqli_fetch_array($pvsql);
				
			$description = $pvres['description'];		
			$title 	     = $pvres['title'];		
			$title_color = $pvres['title_color'];		
			$title_size  = $pvres['title_size'];		
			$category    = $pvres['category'];		
			$privacy= $pvres['type'];		
		
		
			$locationForMp4 = $pvres['location'];
		
			$locationForOgg = $pvres['location1'];
		
			$locationForWebm = $pvres['location2'];
		
			$defaultThumb = $pvres['thumburl'];		
		
			$locationForThumb1 = $pvres['thumburl1'];
		
			$locationForThumb2 = $pvres['thumburl2'];
		
			$locationForThumb3 = $pvres['thumburl3'];
		
			$locationForThumb4 = $pvres['thumburl4'];
		
			$locationForThumb5 = $pvres['thumburl5'];
		
			$prvsql = mysqli_query($con, "SELECT video_id FROM videos ORDER BY video_id DESC LIMIT 1")or die(mysqli_error($con));

			$prvres = mysqli_fetch_array($prvsql);

			$prvideo_id = $prvres['video_id'];
			
			

			
	
			//Insert query
			if($hiddenDivElement == 2){ 
			$wallTypeId =$objLookupClass->getKeyByValue("Country");			
	
			for ($i = 0; $i < count($country_name); $i++) {
			//Query to fetch values from table geo_country 
			$favcountries_sql = mysqli_query($con, "select * from geo_country where country_id = '$country_name[$i]' ") or die(mysqli_error($con));

			$favcountries_res = mysqli_fetch_array($favcountries_sql);
			$country_title = $favcountries_res['country_title'];
			//Query to insert values into message table
			/*$sql = "insert into message(messages,date_created,member_id,country_flag,type,ip,msg_album_id,photo_id,video_id,share_by,share_privacy,share,share_msg,wall_privacy,share_id,wall_type) 						     values('$messages','$time','$member_id','$country_title','$type','$ip','$album_id','$photo_id','$video_id','$member_id','$privacy',1,'$desciption',1,'$share_id_insert', '$wallTypeId')";*/
			$sql = "insert into message(messages,date_created,member_id,country_flag,type,ip,msg_album_id,photo_id,video_id,share_by,share_privacy,share,share_msg,wall_privacy,share_id,wall_type) values('$messages','$time','$member_id','$country_title','$type','$ip','$album_id','$photo_id','$video_id','$member_id','$privacy',1,'$desciption',1,'$share_id_insert', '$wallTypeId')";
	
			$result = mysqli_query($con, $sql) or die(mysqli_error($con));
	

				
		
		
			$new_msgid = mysqli_insert_id($con);
	
			if($mres['type'] == 1)
			{		
				//Query to insert values into upload_data table
				$insertIntoAlbum="Insert into upload_data (USER_CODE,FILE_NAME,FILE_SIZE,FILE_TYPE,date_created,album_id,msg_id,share) VALUES 	
				('$member_id','$file_name','$image_size','".$file_type."',$time,'$calbum_id','$new_msgid',1) ";
				mysqli_query($con, $insertIntoAlbum) or die(mysqli_error($con));
			}
			if($mres['type'] == 2)
			{
				//Query to insert values into videos table
		       		$vquery = "INSERT INTO videos (description,category, location,location1,location2,
				 thumburl,thumburl1,thumburl2,thumburl3,title,user_id,
		          	 type,url_type,date_created,msg_id,title_size,title_color)
				 VALUES('$description','$category','$locationForMp4','$locationForOgg','$locationForWebm',				   
				 '$defaultThumb','$locationForThumb1','$locationForThumb2','$locationForThumb3',
				 '$title','$member_id','$privacy','1','$time','$new_msgid','$title_size','$title_color')";

				$vsql = mysqli_query($con, $vquery)  or die(mysqli_error($con));	

				$video_id = mysqli_insert_id($con);	
				//Query to update values in table videos 
				mysqli_query($con, "UPDATE videos set parent_id = '$prvideo_id' where video_id = '$video_id'");
				//Query to update values in table message 
				$umsql="UPDATE message set video_id = '$video_id' where messages_id = '$new_msgid'";

				mysqli_query($con, $umsql);
			}
	
	
	
			}
	
		}
		else if($hiddenDivElement == 0){ 
			$wallTypeId =$objLookupClass->getKeyByValue("Member Wall");
		if($friend_name != NULL)
		{
		for ($i = 0; $i < count($freinds_n); $i++) {
		//Query to insert values into message table	naresh 24-09-2018
		//$sql = "insert into message (messages,date_created,member_id,content_id,type,ip,msg_album_id,photo_id,video_id,share_by,share_privacy,share,share_msg,wall_privacy,share_id, wall_type) 	values('$messages','$time','".$freinds_n[$i]."','".$freinds_n[$i]."','$type','$ip','$album_id','$photo_id','$video_id','$member_id','$privacy',1,'$desciption',1,'$share_id_insert','$wallTypeId')";
		
		$sql = "insert into message (messages,date_created,member_id,content_id,type,ip,msg_album_id,photo_id,video_id,share_by,share_privacy,share,share_msg,wall_privacy,share_id, wall_type) 	values('$messages','$time','$member_id','".$freinds_n[$i]."','$type','$ip','$album_id','$photo_id','$video_id','".$freinds_n[$i]."','$privacy',1,'$desciption',1,'$share_id_insert','$wallTypeId')";
	
		$result = mysqli_query($con, $sql) or die(mysqli_error($con));
		
		$new_msgid = mysqli_insert_id($con);
		$url = 'posts.php?id='.$new_msgid.'';
		if($mres['type'] == 1)
		{
			//Query to insert values into upload_data table
			$insertIntoAlbum="Insert into upload_data (USER_CODE,FILE_NAME,date_created,album_id,msg_id,share) 
			VALUES ('$member_id','$file_name','$time','$album_id','$new_msgid',1) ";
			mysqli_query($con, $insertIntoAlbum) or die(mysqli_error($con));
		}
		//Query to insert values into notifications table
		$nquery = "INSERT INTO notifications (sender_id, received_id, type_of_notifications, href, is_unread, date_created)
				VALUES('$member_id','$freinds_n[$i]',9,'$url',0,'$time')";
		mysqli_query($con, $nquery);

	
		}
		if($mres['type'] == 2)
		{
		
				//Query to insert values into videos table
				$vquery = "INSERT INTO videos (description,category, location,location1,location2,
				  thumburl,thumburl1,thumburl2,thumburl3,title,user_id,
		          	  type,url_type,date_created,msg_id,title_size,title_color)
				  VALUES('$description','$category','$locationForMp4','$locationForOgg','$locationForWebm',				   
				  '$defaultThumb','$locationForThumb1','$locationForThumb2','$locationForThumb3',
				  '$title','$member_id','$privacy','1','$time','$new_msgid','$title_size','$title_color')";

			$vsql = mysqli_query($con, $vquery)  or die(mysqli_error($con));	

			$video_id = mysqli_insert_id($con);	
			//Query to update values in table videos 
			mysqli_query($con, "UPDATE videos set parent_id = '$prvideo_id' where video_id = '$video_id'");
			//Query to update values in table message 
			$umsql="UPDATE message set video_id = '$video_id' where messages_id = '$new_msgid'";

			mysqli_query($con, $umsql);
	      }
		
	
	    }
	}
	else if($hiddenDivElement == 1){
 
	$wallTypeId =$objLookupClass->getKeyByValue("Group Wall");
	if($group_name != NULL)
	{		
	for ($i = 0; $i < count($groups_n); $i++) {
	//Query to insert values into groups_wall table
	$sql = "insert into groups_wall(messages,date_created,member_id,type,ip,msg_album_id,photo_id,video_id,group_id,share,share_by,share_msg) 
								values('$messages','$time','$member_id','$type','$ip','$album_id',
								'$photo_id','$video_id','".$groups_n[$i]."',1,'$member_id','$description')";
	
	$result = mysqli_query($con, $sql) or die(mysqli_error($con));
	$group_members=mysqli_query($con,"SELECT * FROM `groups_members` WHERE `member_id`!='$member_id' and `groupid`='$groups_n[$i]'");
	
	while($fetch_mems=mysqli_fetch_array($group_members)){
	$members=$fetch_mems['member_id'];
	$grp_url='groups_wall.php?group_id='.$fetch_mems['groupid'];
	$nquery = "INSERT INTO notifications (sender_id, received_id, type_of_notifications, href, is_unread, date_created)
				VALUES('$member_id','$members',9,'$grp_url',0,'$time')";
		mysqli_query($con, $nquery);
	}	
	$new_msgid = mysqli_insert_id($con);
	if($mres['type'] == 1)
	{
		//Query to insert values into groups_photo table
		$insertIntoAlbum="Insert into groups_photo (group_id,member_id,FILE_NAME,FILE_SIZE,FILE_TYPE,date_created,album_id,msg_id,share) VALUES  			 				('".$groups_n[$i]."','$member_id','$file_name','$image_size','".$file_type."',$time,'$album_id','$new_msgid',1) ";
		mysqli_query($con, $insertIntoAlbum) or die(mysqli_error($con));
	}
	
	if($mres['type'] == 2)
	{
		
		//Query to insert values into videos table
		$vquery = "INSERT INTO videos (description,category, location,location1,location2,
				  thumburl,thumburl1,thumburl2,thumburl3,title,user_id,
		          type,url_type,date_created,msg_id,title_size,title_color)
				  VALUES('$description','$category','$locationForMp4','$locationForOgg','$locationForWebm',				   
				  '$defaultThumb','$locationForThumb1','$locationForThumb2','$locationForThumb3',
				  '$title','$member_id','$privacy','1','$time','$new_msgid','$title_size','$title_color')";

		$vsql = mysqli_query($con, $vquery)  or die(mysqli_error($con));	

		$video_id = mysqli_insert_id($con);	
		//Query to update values in table videos 
		mysqli_query($con, "UPDATE videos set parent_id = '$prvideo_id' where video_id = '$video_id'");
		//Query to update values in table message 
		$umsql="UPDATE message set video_id = '$video_id' where messages_id = '$new_msgid'";

		mysqli_query($con, $umsql);
	}
	
	}
	}
	}
	else
	{	
		$wallTypeId =$objLookupClass->getKeyByValue("World");
	//Query to insert values into message table
	$sql = "insert into message(messages,date_created,member_id,type,ip,msg_album_id,photo_id,video_id,share_by,share_privacy,share,country_flag,share_msg,wall_privacy,share_id,wall_type) values ('$messages','$time','$member_id','$type','$ip','$album_id','$photo_id','$video_id','$member_id','$privacy',1,'$world','$desciption',1,'$share_id_insert', '$wallTypeId')";
	
	$result = mysqli_query($con, $sql) or die(mysqli_error($con));
	
	$new_msgid = mysqli_insert_id($con);
	
	if($mres['type'] == 1)
	{
		//Query to insert values into upload_data table
		$insertIntoAlbum="Insert into upload_data (USER_CODE,FILE_NAME,FILE_SIZE,FILE_TYPE,date_created,album_id,msg_id,share) VALUES  			 				('$member_id','$file_name','$image_size','".$file_type."',$time,'$album_id','$new_msgid',1) ";
		mysqli_query($con, $insertIntoAlbum) or die(mysqli_error($con));
	}
	
	if($mres['type'] == 2)
	{
		
		//Query to insert values into videos table
		$vquery = "INSERT INTO videos (description,category, location,location1,location2,
				  thumburl,thumburl1,thumburl2,thumburl3,title,user_id,
		          type,url_type,date_created,msg_id,title_size,title_color)
				  VALUES('$description','$category','$locationForMp4','$locationForOgg','$locationForWebm',				   
				  '$defaultThumb','$locationForThumb1','$locationForThumb2','$locationForThumb3',
				  '$title','$member_id','$privacy','1','$time','$new_msgid','$title_size','$title_color')";

		$vsql = mysqli_query($con, $vquery)  or die(mysqli_error($con));	

		$video_id = mysqli_insert_id($con);	
		//Query to update values in table videos 
		mysqli_query($con,"UPDATE videos set parent_id = '$prvideo_id' where video_id = '$video_id'");
		//Query to update values in table message 
		$umsql="UPDATE message set video_id = '$video_id' where messages_id = '$new_msgid'";

		mysqli_query($con, $umsql);
	}
	
	
	
	
	}
	
	//mysqli_query($con, "UPDATE message set share = 1 where messages_id = '$msg_id'");
	}
	catch(Exception $ex)
	{

		/* General exception error message */
		 //write_log($ex->getMessage(),$level='1',$destination,$member_id='Anonymous'); 
	}
	
	
	
	
	
	
					
	
			// Added By Yasser Hossam & Moshera Ahmed 4/2/2016 
			// Notify User By Email When someone share his/her post
			require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_post.php');
			$post = new posts();
					//send_notification_message($postID,$commentID,$senderID,$type)
			$post->send_notification_message($new_msgid,0,$member_id,10);
			$post->send_notification_message($new_msgid,0,$member_id,12);
			$post->send_notification_message($msg_id,0,$member_id,25);
			$post->send_notification_message($msg_id,0,$member_id,26);
			$post->send_notification_message($msg_id,0,$member_id,27);
			$post->send_notification_message($msg_id,0,$member_id,28);

			/////////////////////////////////////////////////////////////////////////////////////////////////
			
			
			

?>