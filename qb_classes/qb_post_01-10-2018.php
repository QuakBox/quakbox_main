<?php	
//ini_set('display_errors',1);
//error_reporting(E_ALL);
ob_start();
require_once("connection/qb_database.php");
require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_security.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_lookup.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_misc.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member.php');
include($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php');


class posts
{
 
function view_post_by_id($post_id)
{
    	$sql = "SELECT msg.messages_id, msg.content_id, msg.share,msg.description, msg.messages, msg.date_created, msg.type, msg.wall_privacy, m.member_id,
		  msg.msg_album_id, m.username,msg.country_flag, u.upload_data_id, u.album_id,msg.share,msg.video_id
		  ,msg.share_by,m.username, msg.wall_type, v.location,v.location1,v.location2, v.thumburl, v.title, v.video_id, v.description,
 		  v.msg_id, v.category, v.title_color,v.title_size,v.ads,a.ads_name,
		  a.location as adslocation,a.location1 as adslocation1,a.location2 as adslocation2, a.click_url,msg.share_msg
		  FROM message msg LEFT JOIN member m ON msg.member_id = m.member_id 
		  LEFT JOIN upload_data u on msg.messages_id = u.msg_id		  
		  LEFT JOIN videos v ON v.msg_id = msg.messages_id 
		  LEFT JOIN videos_ads a ON v.ads_id = a.id
		  WHERE msg.messages_id='".$post_id."'
		  ";
		  
		;
	$db_Obj = new database();	
	$results = $db_Obj->execQueryWithFetchObject($sql); 
	
	return $results;
}
    
function view_latest_post($country)
{
	$QbSecurityPost=new QB_SqlInjection();
	$encryptedWallID=$QbSecurityPost->QB_AlphaID($country,true);
	if($encryptedWallID==1000){
		$country="world";
	}	
	
	$sql = "SELECT msg.messages_id,msg.share,msg.description, msg.messages, msg.date_created, msg.type, msg.wall_privacy, m.member_id,
		  msg.msg_album_id, m.username,msg.country_flag, u.upload_data_id, u.album_id,msg.share,msg.video_id
		  ,msg.share_by,m.username, v.location,v.location1,v.location2, v.thumburl, v.title, v.video_id, v.description,
 		  v.msg_id, v.category, v.title_color,v.title_size,v.ads,a.ads_name,
		  a.location as adslocation,a.location1 as adslocation1,a.location2 as adslocation2, a.click_url,msg.share_msg
		  FROM message msg LEFT JOIN member m ON msg.member_id = m.member_id 
		  LEFT JOIN upload_data u on msg.messages_id = u.msg_id		  
		  LEFT JOIN videos v ON v.msg_id = msg.messages_id 
		  LEFT JOIN videos_ads a ON v.ads_id = a.id
		  WHERE msg.country_flag='".$country."'		  
		  GROUP BY msg.messages_id 
		  ORDER BY date_created DESC
		  LIMIT 10";
	$db_Obj = new database();	
	$results = $db_Obj->execQueryWithFetchAll($sql); 
	return $results;
}
function view_latest_post_by_last_id($country,$last_id)
{
	$QbSecurityPost=new QB_SqlInjection();
	$encryptedWallID=$QbSecurityPost->QB_AlphaID($country,true);
	if($encryptedWallID==1000){
		$country="world";
	
	$sql = "SELECT msg.messages_id, msg.messages, msg.date_created, msg.type, msg.wall_privacy, m.member_id,
		msg.msg_album_id, m.username, msg.country_flag, u.upload_data_id, u.album_id,msg.share,
		msg.share_by,m.username , v.location,v.location1,v.location2, v.thumburl, v.title, v.video_id, v.description,
		v.msg_id, v.category, v.title_color,v.title_size,v.ads,a.ads_name,
		a.location as adslocation,a.location1 as adslocation1,a.location2 as adslocation2, a.click_url,msg.share_msg
		FROM message msg LEFT JOIN member m ON msg.member_id = m.member_id
		LEFT JOIN upload_data u on msg.messages_id = u.msg_id	 
		LEFT JOIN videos v ON v.msg_id = msg.messages_id 
		LEFT JOIN videos_ads a ON v.ads_id = a.id
		WHERE msg.country_flag='".$country."'
		AND messages_id < '$last_id'
		GROUP BY msg.messages_id 
		ORDER BY messages_id DESC LIMIT 5";
	}
	$db_Obj = new database();
	$results = $db_Obj->execQueryWithFetchAll($sql); 
	return $results;	
}
function getcountrycode($name)
{
        $sql="select * from geo_country where country_title='".$name."'";
        $db_Obj = new database();
	$results = $db_Obj->execQueryWithFetchAll($sql); 
	return $results;
}
function get_share_post_flag($share_id){
	//echo $share_id."test";
	$db_Obj = new database();
	 $sql="SELECT country_flag  FROM `message` WHERE `messages_id` ='".$share_id."'";
	$results = $db_Obj->execQueryWithFetchAll($sql);
	
	return $results;
}
function view_latest_post_by_top_id($country,$top_id)
{
	$QbSecurityPost=new QB_SqlInjection();
	$encryptedWallID=$QbSecurityPost->QB_AlphaID($country,true);
	if($encryptedWallID==1000){
		$country="world";
	
	$sql = "SELECT msg.messages_id, msg.messages, msg.date_created, msg.type, msg.wall_privacy, m.member_id,
		msg.msg_album_id, m.username, msg.country_flag, u.upload_data_id, u.album_id,msg.share,
		msg.share_by,m.username , v.location,v.location1,v.location2, v.thumburl, v.title, v.video_id, v.description,
		v.msg_id, v.category, v.title_color,v.title_size,v.ads,a.ads_name,
		a.location as adslocation,a.location1 as adslocation1,a.location2 as adslocation2, a.click_url,msg.share_msg
		FROM message msg LEFT JOIN member m ON msg.member_id = m.member_id
		LEFT JOIN upload_data u on msg.messages_id = u.msg_id	 
		LEFT JOIN videos v ON v.msg_id = msg.messages_id 
		LEFT JOIN videos_ads a ON v.ads_id = a.id
		WHERE msg.country_flag='".$country."'
		AND messages_id > '$top_id'
		GROUP BY msg.messages_id 
		ORDER BY messages_id DESC LIMIT 5";
		}
	$db_Obj = new database();
	$results = $db_Obj->execQueryWithFetchAll($sql); 
	return $results;	
}

function view_post_likeDeatilsByPostID($postID){
	$sql = "SELECT * FROM bleh WHERE remarks='". $postID ."'";
	$db_Obj = new database();
	$results = $db_Obj->execQueryWithFetchAll($sql); 
	return $results;	
}
function view_post_dislikeDeatilsByPostID($postID){
	$sql = "SELECT * FROM post_dislike WHERE msg_id='". $postID ."'";
	$db_Obj = new database();
	$results = $db_Obj->execQueryWithFetchAll($sql); 
	return $results;	
}
function view_post_likeForPostIDByMember($postID,$memberID){
	$sql = "SELECT * FROM bleh WHERE remarks='". $postID ."' and member_id='".$memberID."'";
	$db_Obj = new database();
	$results = $db_Obj->execQueryWithFetchAll($sql); 
	return $results;	
}
function view_post_dislikeForPostIDByMember($postID,$memberID){
	$sql = "SELECT * FROM post_dislike WHERE msg_id='". $postID ."' and member_id='".$memberID."'";
	$db_Obj = new database();
	$results = $db_Obj->execQueryWithFetchAll($sql); 
	return $results;	
}

function insert_post_like($postID,$memberID){
	$this->delete_post_dislike($postID,$memberID);
	$this->send_notification_message($postID,0,$memberID,1);
	$this->send_notification_message($postID,0,$memberID,7);
	$this->send_notification_message($postID,0,$memberID,13);
	$this->send_notification_message($postID,0,$memberID,14);
	$this->send_notification_message($postID,0,$memberID,15);
	$this->send_notification_message($postID,0,$memberID,16);
	
	$db_Obj = new database(); 
	$sql = "INSERT INTO bleh(`remarks`, `member_id`) VALUES (".$postID.", ".$memberID.");";		
	$rs = $db_Obj->insertQueryReturnLastID($sql); 
	return $rs;
}

function delete_post_like($postID,$memberID){
	$db_Obj = new database(); 
	$sql = "DELETE FROM bleh WHERE remarks='".$postID."' and member_id='".$memberID."'";		
	$rs = $db_Obj->execQuery($sql); 
	return $rs;
}

function insert_post_dislike($postID,$memberID){
	$this->delete_post_like($postID,$memberID);
	$this->send_notification_message($postID,0,$memberID,2);
	$this->send_notification_message($postID,0,$memberID,8);
	$this->send_notification_message($postID,0,$memberID,17);
	$this->send_notification_message($postID,0,$memberID,18);
	$this->send_notification_message($postID,0,$memberID,19);
	$this->send_notification_message($postID,0,$memberID,20);
	$db_Obj = new database(); 
	$sql = "insert into post_dislike(msg_id,member_id,date_created,isread)values('$postID','$memberID',now(),'1');";		
	$rs = $db_Obj->insertQueryReturnLastID($sql); 
	return $rs;
}

function delete_post_dislike($postID,$memberID){
	$db_Obj = new database(); 
	$sql = "DELETE FROM post_dislike WHERE msg_id='$postID' and member_id='$memberID'";		
	$rs = $db_Obj->execQuery($sql); 
	return $rs;
}

function delete_post($postID){
	$db_Obj2 = new database(); 
	$sql2 = "DELETE FROM post_meta WHERE post_id='$postID'";		
	$rs2 = $db_Obj2->execQuery($sql2); 
	$db_Obj = new database(); 
	$sql = "DELETE FROM message WHERE messages_id='$postID'";		
	$rs = $db_Obj->execQuery($sql); 
	return $rs;
}
function delete_comment($postID){
    $db_Obj2 = new database();
    $sqlComment = "SELECT reply_id FROM comment_reply WHERE comment_id = '$postID' ";
    $ResultId = $db_Obj2->execQueryWithFetchAll($sqlComment);
    $count =count($ResultId);
    $i = 0;
    while($i < $count) {
        $this->delete_comment_reply($ResultId[$i]['reply_id']);
        $i++;
    }
    $db_Obj = new database();
    $sql = "DELETE FROM postcomment WHERE comment_id='$postID'";
    $rs = $db_Obj->execQuery($sql);
    return $rs;
}
function delete_comment_reply($postID){
    $db_Obj2 = new database();
    $sql2 = "DELETE FROM reply_reply WHERE reply_id='$postID'";
    $rs2 = $db_Obj2->execQuery($sql2);
    $db_Obj = new database();
    $sql = "DELETE FROM comment_reply WHERE reply_id ='$postID'";
    $rs = $db_Obj->execQuery($sql);
    return $rs;
}
function delete_comment_reply_reply($postID){
    $db_Obj = new database();
    $sql = "DELETE FROM reply_reply WHERE id ='$postID'";
    $rs = $db_Obj->execQuery($sql);
    return $rs;
}
function viewCommentsByPostID($postID){
	$db_Obj = new database(); 
	$sql = "SELECT * FROM postcomment p,member m WHERE p.post_member_id=m.member_id and p.msg_id='$postID'";		
	$rs = $db_Obj->execQuery($sql); 
	return $rs;
}
function viewAllCommentsByPostID($postID){
	$db_Obj = new database(); 
	$sql = "SELECT * FROM postcomment p,member m WHERE p.post_member_id=m.member_id and p.msg_id='$postID'";		
	$rs = $db_Obj->execQuery($sql); 
	return $rs;
}
function viewCommentsRplByCommentId($comment_id,$limit){
	$db_Obj = new database(); 
	$sql = "SELECT * FROM comment_reply c inner join member m on c.`member_id`=m.`member_id` WHERE comment_id='$comment_id' ORDER BY reply_id DESC Limit $limit";		
	$rs = $db_Obj->execQuery($sql); 
	return $rs;
}
function viewAllCommentsRplByCommentId($comment_id){
	$db_Obj = new database(); 
	$sql = "SELECT * FROM comment_reply c inner join member m on c.`member_id`=m.`member_id` WHERE comment_id='$comment_id' ORDER BY reply_id  DESC";		
	$rs = $db_Obj->execQuery($sql); 
	return $rs;
}
function viewAllCountCommentsRplByCommentId($comment_id){
	$db_Obj = new database(); 
	$sql = "SELECT count(reply_id) AS count FROM comment_reply c inner join member m on c.`member_id`=m.`member_id` WHERE comment_id='$comment_id' ORDER BY reply_id DESC";		
	$rs = $db_Obj->execQueryWithFetchAll($sql); 
	return $rs;
}

function insert_post_comment($postID,$memberID,$comment){

	$db_Obj = new database();
	$time2 = time(); 
	//$comment=$db_Obj->cleanString($comment);
	$sql = "INSERT INTO postcomment (post_member_id,msg_id,content, type, date_created) VALUES('$memberID','$postID','$comment','1','$time2');";		
	$rs = $db_Obj->insertQueryReturnLastID($sql); 
	
	$this->send_notification_message($postID,$rs,$memberID,3);
	$this->send_notification_message($postID,$rs,$memberID,9);
	$this->send_notification_message($postID,$rs,$memberID,21);
	$this->send_notification_message($postID,$rs,$memberID,22);
	$this->send_notification_message($postID,$rs,$memberID,23);
	$this->send_notification_message($postID,$rs,$memberID,24);
	
	return $rs;
}


function insert_comment_reply($commentID,$memberID,$reply){
	$db_Obj = new database();
	$time2 = strtotime(date("Y-m-d H:i:s"));
	$replyContent=$db_Obj->cleanString($reply);
	 $sql = "INSERT INTO comment_reply (member_id,comment_id,content,date_created) VALUES('$memberID','$commentID','$replyContent','$time2');";
	
	$rs = $db_Obj->insertQueryReturnLastID($sql);
	/// Get post Id of the comment
	$comment_post_res = $db_Obj->execQueryWithFetchObject("SELECT `msg_id` FROM `postcomment` WHERE `comment_id` = $commentID ");
	$post_id = $comment_post_res->msg_id;
	// Send Notification Massage

	$this->send_notification_message($post_id,$commentID,$memberID,4);
    $this->send_notification_message($post_id,$commentID,$memberID,5);
	return $rs;
}


function insert_post_status($memberID,$status,$encryptedWallID,$ip,$wallItem){	
	$db_Obj = new database();
	$datecreated=strtotime(date('Y-m-d H:i:s'));
	$status=$db_Obj->cleanString($status);
	$QbSecurityPost=new QB_SqlInjection();
	//echo $encryptedWallID;
	if($encryptedWallID == 88)
	{
		$wallID = $encryptedWallID;
	}else if($encryptedWallID == 89){
		$wallID = $encryptedWallID;
	}else if($encryptedWallID == 90){
		$wallID = $encryptedWallID;
	}
	else{
	$wallID=$QbSecurityPost->QB_AlphaID($encryptedWallID,true);
	}
	//$wallID=$QbSecurityPost->QB_AlphaID($encryptedWallID,true);
	$objLookupClass=new lookup();
	$wall=$objLookupClass->getValueByKey($wallID);
	$userId = '';
	
	if($wall=='World'){
		$wallItem='world';
	}else if($wall=='Member Wall'){
		$userId =$QbSecurityPost->QB_AlphaID($wallItem,true);
		$sqlForUsername = "SELECT username FROM member WHERE member_id = '$userId' ";
		$UsernameResult = $db_Obj->execQuery($sqlForUsername);
					while( $fetchUsername = mysqli_fetch_array( $UsernameResult ) ) {
						$wallItem = $fetchUsername['username'];
						break;
					}
	}
	//echo "wall:".$wallID;
	//echo "<br>query is:INSERT INTO message (member_id,messages,country_flag,type,wall_privacy,date_created,ip,url_title,content_id,wall_type) VALUES('$memberID','$status','$wallItem',0,1,'$datecreated','$ip','','$userId','$wallID')";	
	//die();
	if($wall=='Member Wall'){		
		$sql = "INSERT INTO message (member_id,messages,country_flag,type,wall_privacy,date_created,ip,url_title,content_id,wall_type) ";
	$sql .="VALUES('$memberID','$status','$wallItem',0,1,'$datecreated','$ip','','$userId','$wallID')";	
	}else
	{
	$sql = "INSERT INTO message (member_id,messages,country_flag,type,wall_privacy,date_created,ip,url_title,wall_type) ";
	$sql .="VALUES('$memberID','$status','$wallItem',0,1,'$datecreated','$ip','','$wallID')";
	}	
	
	

	
	/*dummy variables
	description,url_title,content_id,msg_album_id,photo_id,share_member_id, unshare_member_id,video_id ,share,share_by,share_id,share_on_member,share_on_country,share_on_group,share_on_world,share_privacy 
	,share_msg,photo_status*/
	
		
	$rs = $db_Obj->insertQueryReturnLastID($sql); 
	
	//Added By Yasser Hossam 3/2/2016, 8/2/2015
	/* if($wallID == 91)
	{//group
			$this->send_notification_message($rs,0,$memberID,11);
	}
	else if($wallID == 90)
	{//friend
		$this->send_notification_message($rs,0,$memberID,29);
	}
	else
	{
		$this->send_notification_message($rs,0,$memberID,6);
	} */

	
	

	return $rs; 
}

function insert_post_image($memberID,$description,$encryptedWallID,$ip,$privacy,$upload_image,$wallItem){	
	$db_Obj = new database();
	$datecreated=strtotime(date('Y-m-d H:i:s'));
	$description=$db_Obj->cleanString($description);
	$QbSecurityPost=new QB_SqlInjection();
	//$wallID=$QbSecurityPost->QB_AlphaID($encryptedWallID,true);
	if($encryptedWallID == 88)
	{
		$wallID = $encryptedWallID;
	}else if($encryptedWallID == 89){
		$wallID = $encryptedWallID;
	}else if($encryptedWallID == 90){
		$wallID = $encryptedWallID;
	}
	else{
	$wallID=$QbSecurityPost->QB_AlphaID($encryptedWallID,true);
	}
	//echo "encrpteid:".$encryptedWallID."~~~INSERT INTO message (member_id,messages,type,wall_privacy,date_created,ip,url_title,description,wall_type) 
		//	VALUES('$memberID','$upload_image',1,'$privacy','$datecreated','$ip','','$description','$wallID');";
	
	//die($wallID);
	$objLookupClass=new lookup();
	$wall=$objLookupClass->getValueByKey($wallID);
	$objMisc = new misc(); 
	$albumName = '';
	$userId = '';
	$time = time();
	if($wall=='World'){
		$wallItem='world';
	}else if($wall=='Member Wall'){
		$userId =$QbSecurityPost->QB_AlphaID($wallItem,true);
		$sqlForUsername = "SELECT username FROM member WHERE member_id = '$userId' ";
		$UsernameResult = $db_Obj->execQuery($sqlForUsername);
					while( $fetchUsername = mysqli_fetch_array( $UsernameResult ) ) {
						$wallItem = $fetchUsername['username'];
						break;
					}
	}
	
	if($wall=='Group Wall' || $wall=='My Wall'){
		$sql = "INSERT INTO message (member_id,messages,type,wall_privacy,date_created,ip,url_title,description,wall_type) 
			VALUES('$memberID','$upload_image',1,'$privacy','$datecreated','$ip','','$description','$wallID');";
	
	}
	else if($wall=='Member Wall'){		
		$sql = "INSERT INTO message (member_id,messages,country_flag,type,wall_privacy,date_created,ip,url_title,description,content_id,wall_type) 
			VALUES('$memberID','$upload_image','$wallItem',1,'$privacy','$datecreated','$ip','','$description','$userId','$wallID');";	
	}
	else{		
		 $sql = "INSERT INTO message (member_id,messages,country_flag,type,wall_privacy,date_created,ip,url_title,description,wall_type) 
			VALUES('$memberID','$upload_image','$wallItem',1,'$privacy','$datecreated','$ip','','$description','$wallID');";	
	}	
	$rs = $db_Obj->insertQueryReturnLastID($sql);
	/*$sqlForUsername = "SELECT username FROM member WHERE member_id = '$memberID' ";
	$UsernameResult = $db_Obj->execQuery($sqlForUsername);
					while( $fetchUsername = mysqli_fetch_array( $UsernameResult ) ) {
						$albumName = $fetchUsername['username'].' Album';
						break;
					} */
	$albumName = ucwords($wallItem);
	if($wall=='My Wall'){
		$albumName ='My Uploads';
	}
	if(!empty($rs)){
	 	$sqlnfeeds = "INSERT INTO news_feeds ";
	        $sqlnfeeds.= "(`date_created`, `msg_id`) ";
	        $sqlnfeeds.= "VALUES ";
	        $sqlnfeeds.= "('".strtotime(date("Y-m-d H:i:s"))."', '$rs') ";
	        $newsResult = $db_Obj->execQuery($sqlnfeeds);
	}
	$sqlForCheckingAlbum = "SELECT album_id FROM user_album WHERE album_user_id = '$memberID' AND album_name='$albumName'";
	$AlbumResult = $db_Obj->execQuery($sqlForCheckingAlbum);
					while( $FetchRes = mysqli_fetch_array( $AlbumResult ) ) {
						$album_id = $FetchRes['album_id'];
						break;
					}
	if($album_id != '' ){
				
				$insertIntoAlbum = "INSERT INTO upload_data (USER_CODE,FILE_NAME,FILE_SIZE,FILE_TYPE,date_created,album_id,msg_id) VALUES  			 				('$memberID','$upload_image','','',$time,'$album_id','$rs') ";
				$ResultInsertIntoAlbum = $db_Obj->execQuery($insertIntoAlbum);
				
				
			$sqlForAlbumId = "SELECT album_id FROM user_album WHERE album_user_id = '$memberID' AND album_name='$albumName'";
			$AlbumIdResult = $db_Obj->execQuery($sqlForAlbumId);		
					while( $fetchAlbumId = mysqli_fetch_array( $AlbumIdResult ) ) {
						$album_id1 = $fetchAlbumId['album_id'];
						break;
					}
				
				if( $album_id1 != '' ){
				
				$insertIntoAlbum1 = "INSERT INTO upload_data (USER_CODE,FILE_NAME,FILE_SIZE,FILE_TYPE,date_created,album_id,msg_id) VALUES  			 				('$memberID','$upload_image','','',$time,'$album_id1','$rs') ";
				$ResultInsertIntoAlbum1 = $db_Obj->execQuery($insertIntoAlbum1);
				
				} else{
				
				if($wall=='Country'){
				$country_id =$objMisc->getcountryIdByName($wallItem);
				$insertAlbumDetails="INSERT INTO user_album (album_user_id,album_name,type,country_id
				) VALUES('$memberID','$albumName','$wallID','$country_id')";
				}else
				{
				$insertAlbumDetails="INSERT INTO user_album (album_user_id,album_name,type) VALUES('$memberID','$albumName','$wallID');";
				}
				$LastIdofInsert = $db_Obj->insertQueryReturnLastID($insertAlbumDetails);
				
				$album_id1= $LastIdofInsert;
				
				$insertIntoAlbum2 = "INSERT INTO upload_data (USER_CODE,FILE_NAME,FILE_SIZE,FILE_TYPE,date_created,album_id,msg_id) VALUES  			 				('$memberID','$upload_image','','',$time,'$album_id1','$rs') ";
				$ResultInsertIntoAlbum2 = $db_Obj->execQuery($insertIntoAlbum2);
				
				
				}				
			}
			
			else
			{	
			
				if($wall=='Country'){
				$country_id =$objMisc->getcountryIdByName($wallItem);
				$insertAlbumDetails="INSERT INTO user_album (album_user_id,album_name,type,country_id
				) VALUES('$memberID','$albumName','$wallID','$country_id')";
				}else
				{
				$insertAlbumDetails="INSERT INTO user_album (album_user_id,album_name,type) VALUES('$memberID','$albumName','$wallID');";
				}
				
				$LastIdofInsert = $db_Obj->insertQueryReturnLastID($insertAlbumDetails);
				
				$album_id = $LastIdofInsert;
				
				$insertIntoAlbum = "INSERT INTO upload_data (USER_CODE,FILE_NAME,FILE_SIZE,FILE_TYPE,date_created,album_id,msg_id) VALUES  			 				('$memberID','$upload_image','','',$time,'$album_id','$rs') ";
				$ResultInsertIntoAlbum = $db_Obj->execQuery($insertIntoAlbum);
				
				
			}
			
			
	//Added By Yasser Hossam 3/2/2016, 8/2/2015
	if($wallID == 91)
	{//group
			$this->send_notification_message($rs,0,$memberID,11);
	}
	else if($wallID == 90)
	{//friend
		$this->send_notification_message($rs,0,$memberID,29);
	}
	else
	{
		$this->send_notification_message($rs,0,$memberID,6);
	}
	
	
	return $rs; 
}

function insert_post_video($memberID,$title,$description,$encryptedWallID,$ip,$privacy,$videoname,$wallItem){	
	$db_Obj = new database();
	$datecreated=strtotime(date('Y-m-d H:i:s'));
	$description=$db_Obj->cleanString($description);
	$QbSecurityPost=new QB_SqlInjection();
	
	if($encryptedWallID == 88)
	{
		$wallID = $encryptedWallID;
	}else if($encryptedWallID == 89){
		$wallID = $encryptedWallID;
	}else if($encryptedWallID == 90){
		$wallID = $encryptedWallID;
	}else{
	$wallID=$QbSecurityPost->QB_AlphaID($encryptedWallID,true);
	}
	//$wallID=$QbSecurityPost->QB_AlphaID($encryptedWallID,true);
	$objLookupClass=new lookup();
	$wall=$objLookupClass->getValueByKey($wallID);
	$objMisc = new misc(); 
	$albumName = '';
	$userId = '';
	$time = time();	
	//echo "post2";
	/*$NameWithoutExtension   = f($videoname, 'strip');
	$NameWithoutExtension	 = 	f($NameWithoutExtension, 'escapeAll');*/
	$videoname1 = pathinfo(basename($videoname), PATHINFO_FILENAME);
	$NameWithoutExtension   = $videoname1;
	//echo "post3";
	$locationForMp4 = "uploadedvideo/new".$NameWithoutExtension.".mp4";
	$locationForOgg = "uploadedvideo/new".$NameWithoutExtension.".ogg";
	$locationForWebm = "uploadedvideo/new".$NameWithoutExtension.".webm";
	/*$defaultThumb = "uploadedvideo/videothumb/".$dThumb;*/
	//echo "post4";
	/*$base_url2='/home/qbdevqb/public_html/';*/
	$locationForThumb1= $NameWithoutExtension."01.png";
	$p300x150_path= "../uploadedvideo/videothumb/new".$NameWithoutExtension."01.png";
	$p300x150 = "../uploadedvideo/videothumb/p400x225".$NameWithoutExtension."01.png";
	$p200x150_1 = "../uploadedvideo/videothumb/p200x150".$NameWithoutExtension."01.png";	
	//echo "step1";
	//image resize into 300x150
	$image300x150 = new Imagick($p300x150_path);	
	$image300x150->adaptiveResizeImage(400,225);     
	$image300x150->writeImage($p300x150);
	$image200x150_1 = new Imagick($p300x150_path);
	$image200x150_1->adaptiveResizeImage(200,150);
	$image200x150_1->writeImage($p200x150_1);
	//echo "step2";
	$locationForThumb2= $NameWithoutExtension."02.png";
	$p300x150_path_2= "../uploadedvideo/videothumb/new".$NameWithoutExtension."02.png";
	$p300x150_2 = "../uploadedvideo/videothumb/p400x225".$NameWithoutExtension."02.png";
	$p200x150_2 = "../uploadedvideo/videothumb/p200x150".$NameWithoutExtension."02.png";
	//echo "589";

	//image resize into 300x150
	$image300x150_2 = new Imagick($p300x150_path_2);
	$image300x150_2->adaptiveResizeImage(400,225);
	$image300x150_2->writeImage($p300x150_2);
	$image200x150_2 = new Imagick($p300x150_path_2);
	$image200x150_2->adaptiveResizeImage(200,150);
	$image200x150_2->writeImage($p200x150_2);
	//echo "598";

	$locationForThumb3= $NameWithoutExtension."03.png";
	$p300x150_path_3= "../uploadedvideo/videothumb/new".$NameWithoutExtension."03.png";
	$p300x150_3 = "../uploadedvideo/videothumb/p400x225".$NameWithoutExtension."03.png";
	$p200x150_3 = "../uploadedvideo/videothumb/p200x150".$NameWithoutExtension."03.png";
	//echo "604";

	//image resize into 300x150
	$image300x150_3 = new Imagick($p300x150_path_3);
	$image300x150_3->adaptiveResizeImage(400,225);
	$image300x150_3->writeImage($p300x150_3);
	$image200x150_3 = new Imagick($p300x150_path_3);
	$image200x150_3->adaptiveResizeImage(200,150);
	$image200x150_3->writeImage($p200x150_3);
	//echo "613";

	$locationForThumb4= $NameWithoutExtension."04.png";
	$p300x150_path_4= "../uploadedvideo/videothumb/new".$NameWithoutExtension."04.png";
	$p300x150_4 = "../uploadedvideo/videothumb/p400x225".$NameWithoutExtension."04.png";
	$p200x150_4 = "../uploadedvideo/videothumb/p200x150".$NameWithoutExtension."04.png";
	//echo "619";

	//image resize into 300x150
	$image300x150_4= new Imagick($p300x150_path_4);
	$image300x150_4->adaptiveResizeImage(400,225);
	$image300x150_4->writeImage($p300x150_4);
	$image200x150_4 = new Imagick($p300x150_path_4);
	$image200x150_4->adaptiveResizeImage(200,150);
	$image200x150_4->writeImage($p200x150_4);
	//echo "628";
	$locationForThumb5= $NameWithoutExtension."05.png";
	$p300x150_path_5= "../uploadedvideo/videothumb/new".$NameWithoutExtension."05.png";
	$p300x150_5 = "../uploadedvideo/videothumb/p400x225".$NameWithoutExtension."05.png";
	$p200x150_5 = "../uploadedvideo/videothumb/p200x150".$NameWithoutExtension."05.png";
	

	//image resize into 300x150
	$image300x150_5= new Imagick($p300x150_path_5);
	$image300x150_5->adaptiveResizeImage(400,225);
	$image300x150_5->writeImage($p300x150_5);
	$image200x150_5 = new Imagick($p300x150_path_5);
	$image200x150_5->adaptiveResizeImage(200,150);
	$image200x150_5->writeImage($p200x150_5);
	//echo "642";

	//extension_loaded('ffmpeg') or die('Error in loading ffmpeg');
	require_once('ffmpeg-php/FFmpegAutoloader.php');
	
	$ffmpegInstance = new ffmpeg_movie("../".$locationForMp4);
	$duration = intval($ffmpegInstance->getDuration());
	//echo $sql = "INSERT INTO message (member_id,messages,type,wall_privacy,date_created,ip,url_title,description,wall_type) 
			//VALUES('$memberID','$videoname',2,'$privacy','$datecreated','$ip','','$description','$wallID');";
	//die('testing');		
	if($wall=='World'){
		$wallItem='world';
	}else if($wall=='Member Wall'){
		$userId =$QbSecurityPost->QB_AlphaID($wallItem,true);
		$sqlForUsername = "SELECT username FROM member WHERE member_id = '$userId' ";
		$UsernameResult = $db_Obj->execQuery($sqlForUsername);
					while( $fetchUsername = mysqli_fetch_array( $UsernameResult ) ) {
						$wallItem = $fetchUsername['username'];
						break;
					}
	}
	
	/*$description=preg_replace('/\v+|\\\[rn]/', '<br/>', $description);//nl2br($description);*/
	
	if($wall=='Group Wall' || $wall=='My Wall'){
		$sql = "INSERT INTO message (member_id,messages,type,wall_privacy,date_created,ip,url_title,description,wall_type) 
			VALUES('$memberID','$videoname',2,'$privacy','$datecreated','$ip','','$description','$wallID');";
	
	}
	else if($wall=='Member Wall'){		
		$sql = "INSERT INTO message (member_id,messages,country_flag,type,wall_privacy,date_created,ip,url_title,description,content_id,wall_type) 
			VALUES('$memberID','$videoname','$wallItem',2,'$privacy','$datecreated','$ip','','$description','$userId','$wallID');";	
	}
	else{		
		$sql = "INSERT INTO message (member_id,messages,country_flag,type,wall_privacy,date_created,ip,url_title,description,wall_type) 
			VALUES('$memberID','$videoname','$wallItem',2,'$privacy','$datecreated','$ip','','$description','$wallID');";	
	}	

	$rs = $db_Obj->insertQueryReturnLastID($sql);
	
 	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/time_stamp.php');	 
 	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/tolink.php');
	
	$videoquery = "INSERT INTO videos (description, location,location1,location2,thumburl,thumburl1,thumburl2,thumburl3,thumburl4,thumburl5,title,user_id,type,url_type,date_created,msg_id,duration,title_size,title_color) VALUES('$description','$locationForMp4','$locationForOgg','$locationForWebm','$locationForThumb2','$locationForThumb1','$locationForThumb2','$locationForThumb3','$locationForThumb4','$locationForThumb5','$title','$memberID','$privacy','1','$datecreated','$rs','$duration','14','FFFFFF')";
	
	$ResultInsertIntoVideos = $db_Obj->execQuery($videoquery);
	
	
	//Added By Yasser Hossam 3/2/2016, 8/2/2015
	if($wallID == 91)
	{//group
			$this->send_notification_message($rs,0,$memberID,11);
	}
	else if($wallID == 90)
	{//friend
		$this->send_notification_message($rs,0,$memberID,29);
	}
	else
	{
		$this->send_notification_message($rs,0,$memberID,6);
	}
	
	return $rs; 
}

function insert_post_meta($postID,$metaKey,$metaValue){
	$db_Obj = new database();
	$metaValue=$db_Obj->cleanString($metaValue);
	$sql = "INSERT INTO post_meta (post_id,meta_key,meta_value) VALUES('$postID','$metaKey','$metaValue');";		
	$rs = $db_Obj->insertQueryReturnLastID($sql); 
	return $rs; 
}

function check_post_meta($postID,$metaKey){
	$db_Obj = new database();
	$sql = "select meta_value from post_meta where post_id=".$postID." and meta_key='".$metaKey."';";		
	$rs = $db_Obj->execQueryWithFetchAll($sql); 
	$output='qberror';
	foreach($rs as $column => $value) {
		$output=$value['meta_value'];	
	}
	return $output; 
}

function insert_post_report($memberID,$postID,$reportContent){
	$db_Obj = new database();
	$metaValue=$db_Obj->cleanString($metaValue);
	$sql = "INSERT INTO comment_report(member_id,msg_id,report, date_created) VALUES('$memberID','$postID','$reportContent','".strtotime(date("Y-m-d H:i:s"))."');";		
	$rs = $db_Obj->insertQueryReturnLastID($sql); 
	return $rs; 
}

function view_comment_likeDeatilsByCommentID($commentID){
	$sql = "SELECT * FROM comment_like WHERE comment_id='". $commentID."'";
	$db_Obj = new database();
	$results = $db_Obj->execQueryWithFetchAll($sql); 
	return $results;	
}
function view_comment_dislikeDeatilsByCommentID($commentID){
	$sql = "SELECT * FROM comment_dislike WHERE comment_id='". $commentID."'";
	$db_Obj = new database();
	$results = $db_Obj->execQueryWithFetchAll($sql); 
	return $results;	
}
function view_comment_likeDeatilsByMemberID($commentID,$memberID){
	$sql = "SELECT * FROM comment_like WHERE comment_id='". $commentID."' and member_id='".$memberID."'";
	$db_Obj = new database();
	$results = $db_Obj->execQueryWithFetchAll($sql); 
	return $results;	
}
function view_comment_dislikeDeatilsByMemberID($commentID,$memberID){
	$sql = "SELECT * FROM comment_dislike WHERE comment_id='". $commentID."'  and member_id='".$memberID."'";
	$db_Obj = new database();
	$results = $db_Obj->execQueryWithFetchAll($sql); 
	return $results;	
}

function insert_comment_like($commentID,$memberID){
	$this->delete_comment_dislike($commentID,$memberID);
	$db_Obj = new database(); 
	$sql = "INSERT INTO comment_like (comment_id,member_id) VALUES (".$commentID.", ".$memberID.");";		
	$rs = $db_Obj->insertQueryReturnLastID($sql); 
	return $rs;
}

function delete_comment_like($commentID,$memberID){
	$db_Obj = new database(); 
	$sql = "DELETE FROM comment_like WHERE comment_id='".$commentID."' and member_id='".$memberID."'";		
	$rs = $db_Obj->execQuery($sql); 
	return $rs;
}
function insert_comment_dislike($commentID,$memberID){
	$this->delete_comment_like($commentID,$memberID);
	$time2 = time();
	$db_Obj = new database(); 
	$sql = "insert into comment_dislike(comment_id,member_id,created)values('$commentID','$memberID','$time2');";		
	$rs = $db_Obj->insertQueryReturnLastID($sql); 
	return $rs;
}

function delete_comment_dislike($commentID,$memberID){
	$db_Obj = new database(); 
	$sql = "DELETE FROM comment_dislike WHERE comment_id='$commentID' and member_id='$memberID'";		
	$rs = $db_Obj->execQuery($sql); 
	return $rs;
}

function view_reply_likeDeatilsByReplyID($replyID){
	$sql = "SELECT * FROM reply_like WHERE reply_id='". $replyID."'";
	$db_Obj = new database();
	$results = $db_Obj->execQueryWithFetchAll($sql); 
	return $results;	
}
function view_reply_dislikeDeatilsByReplyID($replyID){
	$sql = "SELECT * FROM reply_dislike WHERE reply_id='". $replyID."'";
	$db_Obj = new database();
	$results = $db_Obj->execQueryWithFetchAll($sql); 
	return $results;	
}
function view_reply_likeDeatilsByMemberID($replyID,$memberID){
	$sql = "SELECT * FROM reply_like WHERE reply_id='". $replyID."' and member_id='".$memberID."'";
	$db_Obj = new database();
	$results = $db_Obj->execQueryWithFetchAll($sql); 
	return $results;	
}
function view_reply_dislikeDeatilsByMemberID($replyID,$memberID){
	$sql = "SELECT * FROM reply_dislike WHERE reply_id='". $replyID."'  and member_id='".$memberID."'";
	$db_Obj = new database();
	$results = $db_Obj->execQueryWithFetchAll($sql); 
	return $results;	
}
function insert_reply_like($replyID,$memberID){
	$this->delete_reply_dislike($replyID,$memberID);
	$db_Obj = new database(); 
	$time2 = time();
	$sql = "INSERT INTO reply_like (reply_id,member_id,created) VALUES('$replyID','$memberID','$time2')";		
	$rs = $db_Obj->insertQueryReturnLastID($sql); 
	return $rs;
}
function delete_reply_like($replyID,$memberID){
	$db_Obj = new database(); 
	$sql = "DELETE FROM reply_like WHERE reply_id='$replyID' and member_id='$memberID'";		
	$rs = $db_Obj->execQuery($sql); 
	return $rs;
}
function insert_reply_dislike($replyID,$memberID){
	$this->delete_reply_like($replyID,$memberID);
	$time2 = time();
	$db_Obj = new database(); 
	$sql = "INSERT INTO reply_dislike (reply_id,member_id,created) VALUES('$replyID','$memberID','$time2');";		
	$rs = $db_Obj->insertQueryReturnLastID($sql); 
	return $rs;
}
function delete_reply_dislike($replyID,$memberID){
	$db_Obj = new database(); 
	$sql = "DELETE FROM reply_dislike WHERE reply_id='$replyID' and member_id='$memberID'";		
	$rs = $db_Obj->execQuery($sql); 
	return $rs;
}
function insert_comment_replys_reply($replyID,$memberID,$replyContent){	
	$db_Obj = new database();
	$time2 = strtotime(date("Y-m-d H:i:s")); 
	$replyContent=$db_Obj->cleanString($replyContent);
	$sql = "INSERT INTO reply_reply (member_id,reply_id,content,date_created) VALUES('$memberID','$replyID','$replyContent','$time2');";		
	$rs = $db_Obj->insertQueryReturnLastID($sql); 
	return $rs;
}

function viewReplysRplById($replyID,$limit){
	$db_Obj = new database(); 
	$sql = "SELECT * FROM reply_reply c inner join member m on c.`member_id`=m.`member_id` WHERE reply_id='$replyID' ORDER BY reply_id DESC Limit $limit";		
	$rs = $db_Obj->execQuery($sql); 
	return $rs;
}
function viewAllReplysRplById($replyID){
	$db_Obj = new database(); 
	$sql = "SELECT * FROM reply_reply c inner join member m on c.`member_id`=m.`member_id` WHERE reply_id='$replyID' ORDER BY reply_id DESC";		
	$rs = $db_Obj->execQuery($sql); 
	return $rs;
}
function viewAllCountReplysReplyById($replyID){
	$db_Obj = new database(); 
	$sql = "SELECT count(reply_id) AS count FROM reply_reply c inner join member m on c.`member_id`=m.`member_id` WHERE reply_id='$replyID' ORDER BY reply_id DESC";		
	$rs = $db_Obj->execQueryWithFetchAll($sql); 
	return $rs;
}

function view_latest_post2($encryptedWallID,$wallItem)
{
	$QbSecurityPost=new QB_SqlInjection();
	$wallID=$QbSecurityPost->QB_AlphaID($encryptedWallID,true);
	$objLookupClass=new lookup();
	$wall=$objLookupClass->getValueByKey($wallID);
	//$item=$QbSecurityPost->Qbdecrypt(base64_decode($wallItem), ENC_KEY);
	
	$sql = "SELECT msg.messages_id,msg.share,msg.description, msg.messages, msg.date_created, msg.type, msg.wall_privacy, m.member_id,msg.content_id,
		  msg.msg_album_id, m.username,msg.country_flag, u.upload_data_id, u.album_id,msg.share,msg.share_id,msg.video_id
		  ,msg.share_by,m.username, v.location,v.location1,v.location2, v.thumburl, v.title, v.video_id, v.description as videodescription,
 		  v.msg_id, v.category, v.title_color,v.title_size,v.ads,a.ads_name,
		  a.location as adslocation,a.location1 as adslocation1,a.location2 as adslocation2, a.click_url,msg.share_msg
		  FROM message msg ";
	if($wall=='Group Wall'){
		$sql .= " LEFT JOIN post_meta pm ON msg.messages_id = pm.post_id";
	}	  
	$sql .= " LEFT JOIN member m ON msg.member_id = m.member_id 
		  LEFT JOIN upload_data u on msg.messages_id = u.msg_id		  
		  LEFT JOIN videos v ON v.msg_id = msg.messages_id 
		  LEFT JOIN videos_ads a ON v.ads_id = a.id
		  WHERE  msg.wall_type='".$wallID."'";
		  
	if($wall=='Country'){
		$sql .= " AND msg.country_flag='$wallItem'";
		
	}
	else if($wall=='Group Wall'){
		$wallItem2=$QbSecurityPost->QB_AlphaID($wallItem,true);
		$sql .= " AND pm.meta_key='group_id'";
		$sql .= " AND pm.meta_value='".$wallItem2."'";
	}		  
	$sql .= " GROUP BY msg.messages_id 
		  ORDER BY date_created DESC
		  LIMIT 10";
	$sql;
	
	$db_Obj = new database();	
	$results = $db_Obj->execQueryWithFetchAll($sql); 
	return $results;
}
function view_latest_post_by_last_id2($encryptedWallID,$wallItem,$last_id)
{	
	$memberID = $_SESSION['SESS_MEMBER_ID'];
	$QbSecurityPost=new QB_SqlInjection();
	$wallID=$QbSecurityPost->QB_AlphaID($encryptedWallID,true);
	$objLookupClass=new lookup();
	$wall=$objLookupClass->getValueByKey($wallID);
	//$item=$QbSecurityPost->Qbdecrypt(base64_decode($wallItem), ENC_KEY);
/*	
 $sql = "SELECT msg.messages_id,msg.share,msg.description, msg.messages, msg.date_created, msg.type, msg.wall_privacy, m.member_id,msg.content_id,
		  msg.msg_album_id, m.username,msg.country_flag, u.upload_data_id, u.album_id,msg.share,msg.video_id
		  ,msg.share_by,m.username, v.location,v.location1,v.location2, v.thumburl, v.title, v.video_id, v.description,
 		  v.msg_id, v.category, v.title_color,v.title_size,v.ads,a.ads_name,
		  a.location as adslocation,a.location1 as adslocation1,a.location2 as adslocation2, a.click_url,msg.share_msg";
	
	if($wall=='My Wall'){
	$sql .=	  ",msg.member_id,m.status,v.country_id ";
	}
	
	if($wall=='Member Wall'){
	$sql .=	  ",msg.member_id,m.status,v.country_id ";
	}

	$sql .= " FROM message msg ";
	if($wall=='Group Wall'){
		$sql .= " LEFT JOIN post_meta pm ON msg.messages_id = pm.post_id";
	}
	
	if($wall=='Member Wall'){
	$sql .=	  "LEFT JOIN status_share s ON ( msg.messages_id = s.msg_id )";
	}
		  
	$sql .= " LEFT JOIN member m ON msg.member_id = m.member_id 
		  LEFT JOIN upload_data u on msg.messages_id = u.msg_id		  
		  LEFT JOIN videos v ON v.msg_id = msg.messages_id 
		  LEFT JOIN videos_ads a ON v.ads_id = a.id
		  WHERE  msg.wall_type='".$wallID."'";
		  
	if($wall=='Country'){
		$sql .= " AND msg.country_flag='$wallItem'";
		
	}
	else if($wall=='Group Wall'){
		$wallItem2=$QbSecurityPost->QB_AlphaID($wallItem,true);
		$sql .= " AND pm.meta_key='group_id'";
		$sql .= " AND pm.meta_value='".$wallItem2."'";
	}else if($wall=='My Wall'){
	$sql .=	"  AND msg.content_id ='".$memberID."'
		   OR msg.member_id  = '".$memberID."'";
	}
	else if($wall=='Member Wall'){
	$sql .=	"  AND msg.content_id = '".$wallItem."'
		   OR msg.member_id = '".$wallItem."'
		   OR s.share_on_member = '".$wallItem."'
		   AND msg.photo_status != 1";
	}
	
	*/
	 $sql = "SELECT msg.messages_id,msg.description, msg.messages, msg.date_created, msg.type, msg.wall_privacy, m.member_id,msg.content_id,
		  msg.msg_album_id, msg.country_flag, u.upload_data_id, u.album_id,msg.share,msg.video_id
		  ,msg.share_by,m.username, v.location,v.location1,v.location2, v.thumburl, v.title, v.video_id, v.description as videodescription,
 		  v.msg_id, v.category, v.title_color,v.title_size,v.ads,a.ads_name,
		  a.location as adslocation,a.location1 as adslocation1,a.location2 as adslocation2, a.click_url,msg.share_msg";
	if($wall=='My Wall'){
	$sql .=	  ",msg.member_id,m.status,v.country_id ";
	}	  
		
	$sql .=	  " FROM message msg ";
	if($wall=='Group Wall'){
		$sql .= " LEFT JOIN post_meta pm ON msg.messages_id = pm.post_id";
	}
	if($wall=='Member Wall'){
	$sql .=	  "LEFT JOIN status_share s ON ( msg.messages_id = s.msg_id )";
	}	  
	$sql .= " LEFT JOIN member m ON msg.member_id = m.member_id 
		  LEFT JOIN upload_data u on msg.messages_id = u.msg_id		  
		  LEFT JOIN videos v ON v.msg_id = msg.messages_id 
		  LEFT JOIN videos_ads a ON v.ads_id = a.id
		  WHERE  msg.wall_type='".$wallID."'";
		  
	if($wall=='Country'){
		$sql .= " AND msg.country_flag='$wallItem'";
		
	}
	else if($wall=='Group Wall'){
		$wallItem1=$QbSecurityPost->QB_AlphaID($wallItem,true);
		$sql .= " AND pm.meta_key='group_id'";
		$sql .= " AND pm.meta_value='".$wallItem1."'";
	}else if($wall=='My Wall'){
	$sql .=	"  AND msg.content_id in ($wallItem)
		   OR msg.member_id = '".$memberID."'";
	}
	else if($wall=='Member Wall'){
		
	$sql .=	"  AND msg.content_id = '".$wallItem."'
		   OR msg.member_id = '".$wallItem."'
		   OR s.share_on_member = '".$wallItem."'
		   AND msg.photo_status != 1";
	}		  	  
	$sql .= "  AND messages_id < '$last_id'
		  GROUP BY msg.messages_id 
		  ORDER BY date_created DESC
		  LIMIT 10";
	
	$db_Obj = new database();	
	$results = $db_Obj->execQueryWithFetchAll($sql); 
	return $results;	
}
function view_latest_post_by_top_id2($encryptedWallID,$wallItem,$top_id)
{
	$memberID = $_SESSION['SESS_MEMBER_ID'];
	$QbSecurityPost=new QB_SqlInjection();
	$wallID=$QbSecurityPost->QB_AlphaID($encryptedWallID,true);
	$objLookupClass=new lookup();
	$wall=$objLookupClass->getValueByKey($wallID);
	//$item=$QbSecurityPost->Qbdecrypt(base64_decode($wallItem), ENC_KEY);
	
 $sql = "SELECT msg.messages_id,msg.description, msg.messages, msg.date_created, msg.type, msg.wall_privacy, m.member_id,msg.content_id,
		  msg.msg_album_id, msg.country_flag, u.upload_data_id, u.album_id,msg.share,msg.video_id
		  ,msg.share_by,m.username, v.location,v.location1,v.location2, v.thumburl, v.title, v.video_id, v.description as videodescription,
 		  v.msg_id, v.category, v.title_color,v.title_size,v.ads,a.ads_name,
		  a.location as adslocation,a.location1 as adslocation1,a.location2 as adslocation2, a.click_url,msg.share_msg";
	if($wall=='My Wall'){
	$sql .=	  ",msg.member_id,m.status,v.country_id ";
	}	  
		
	$sql .=	  " FROM message msg ";
	if($wall=='Group Wall'){
		$sql .= " LEFT JOIN post_meta pm ON msg.messages_id = pm.post_id";
	}
	if($wall=='Member Wall'){
	$sql .=	  "LEFT JOIN status_share s ON ( msg.messages_id = s.msg_id )";
	}	  
	$sql .= " LEFT JOIN member m ON msg.member_id = m.member_id 
		  LEFT JOIN upload_data u on msg.messages_id = u.msg_id		  
		  LEFT JOIN videos v ON v.msg_id = msg.messages_id 
		  LEFT JOIN videos_ads a ON v.ads_id = a.id
		  WHERE  msg.wall_type='".$wallID."'";
		  
	if($wall=='Country'){
		$sql .= " AND msg.country_flag='$wallItem'";
		
	}
	else if($wall=='Group Wall'){
		$wallItem1=$QbSecurityPost->QB_AlphaID($wallItem,true);
		$sql .= " AND pm.meta_key='group_id'";
		$sql .= " AND pm.meta_value='".$wallItem1."'";
	}else if($wall=='My Wall'){
	$sql .=	"  AND msg.content_id ='".$memberID."'
		   OR msg.member_id = '".$memberID."'";
	}
	else if($wall=='Member Wall'){
		
	$sql .=	"  AND msg.content_id = '".$wallItem."'
		   OR msg.member_id = '".$wallItem."'
		   OR s.share_on_member = '".$wallItem."'
		   AND msg.photo_status != 1";
	}		  
	$sql .= "  AND messages_id > '$top_id'
		  GROUP BY msg.messages_id 
		  ORDER BY date_created DESC
		  LIMIT 10";
	
	$db_Obj = new database();	
	$results = $db_Obj->execQueryWithFetchAll($sql); 
	return $results;	
}

function view_latest_postByMember($memberID)
{
	
	
	$sql = "SELECT msg.content_id, msg.country_flag, msg.date_created, msg.messages_id, msg.member_id, 
		 m.username, msg.type, msg.messages, msg.msg_album_id, u.upload_data_id, u.album_id, msg.share,
		msg.video_id, msg.share_by, msg.wall_privacy, msg.share_msg,
		v.location,v.location1,v.location2, v.thumburl, v.title, v.video_id, v.description as videodescription,
		 			v.msg_id, v.category, v.title_color,v.title_size,v.ads,a.ads_name,
						a.location as adslocation,a.location1 as adslocation1,a.location2 as adslocation2, a.click_url,msg.share_msg
		FROM message msg
		LEFT JOIN status_share s ON ( msg.messages_id = s.msg_id )
		LEFT JOIN member m ON msg.member_id = m.member_id
		LEFT JOIN upload_data u on msg.messages_id = u.msg_id
		LEFT JOIN videos v ON v.msg_id = msg.messages_id 
		LEFT JOIN videos_ads a ON v.ads_id = a.id
		WHERE msg.content_id ='$memberID'
		OR msg.member_id = '$memberID'
		OR s.share_on_member = '$memberID'
		AND msg.photo_status != 1
		GROUP BY messages_id
		ORDER BY messages_id DESC
		LIMIT 10";
	
	$db_Obj = new database();	
	$results = $db_Obj->execQueryWithFetchAll($sql); 
	return $results;
}

function view_previous_postByMember($memberID,$last_id)
{
	
	
	$sql = "SELECT msg.content_id, msg.country_flag, msg.date_created, msg.messages_id, msg.member_id, 
		 m.username, msg.type, msg.messages, msg.msg_album_id, u.upload_data_id, u.album_id, msg.share,
		msg.video_id, msg.share_by, msg.wall_privacy, msg.share_msg,
		v.location,v.location1,v.location2, v.thumburl, v.title, v.video_id, v.description,
		 			v.msg_id, v.category, v.title_color,v.title_size,v.ads,a.ads_name,
						a.location as adslocation,a.location1 as adslocation1,a.location2 as adslocation2, a.click_url
		FROM message msg
		LEFT JOIN status_share s ON ( msg.messages_id = s.msg_id )
		LEFT JOIN member m ON msg.member_id = m.member_id
		LEFT JOIN upload_data u on msg.messages_id = u.msg_id
		LEFT JOIN videos v ON v.msg_id = msg.messages_id 
		LEFT JOIN videos_ads a ON v.ads_id = a.id
		WHERE msg.content_id ='$memberID'
		OR msg.member_id = '$memberID'
		OR s.share_on_member = '$memberID'
		AND msg.photo_status != 1
		AND messages_id < '$last_id'
		GROUP BY messages_id
		ORDER BY messages_id DESC
		LIMIT 10";
	
	$db_Obj = new database();	
	$results = $db_Obj->execQueryWithFetchAll($sql); 
	return $results;
}

		

function view_latest_postForMywall($memberID, $wallItem)
{
	
	
 $sql = "SELECT msg.content_id,msg.description, msg.country_flag, msg.date_created, msg.messages_id, msg.member_id, 
 m.status, m.username, msg.type, msg.messages, msg.msg_album_id, u.upload_data_id, u.album_id, msg.share,
msg.video_id, msg.share_by, msg.wall_privacy, v.location,v.location1,v.location2, v.thumburl, v.title, v.video_id, v.description as videodescription, v.msg_id, v.category, v.country_id, v.title_color,v.title_size,v.ads,a.ads_name,
				a.location as adslocation,a.location1 as adslocation1,a.location2 as adslocation2, a.click_url, msg.share_msg
FROM message msg
LEFT JOIN member m ON msg.member_id = m.member_id
LEFT JOIN upload_data u on msg.messages_id = u.msg_id
LEFT JOIN videos v ON v.msg_id = msg.messages_id 
LEFT JOIN videos_ads a ON v.ads_id = a.id
WHERE msg.content_id ='$memberID'
OR msg.member_id in ($wallItem)
OR msg.member_id = '$memberID'
OR msg.share_by = '$memberID'
AND msg.photo_status != 1
GROUP BY messages_id
ORDER BY messages_id DESC
LIMIT 10";
	
	$db_Obj = new database();	
	$results = $db_Obj->execQueryWithFetchAll($sql); 
	return $results;
}

function view_previous_postForMywall($memberID, $wallItem,$last_id)
{
	
	
 $sql = "SELECT msg.content_id,msg.description, msg.country_flag, msg.date_created, msg.messages_id, msg.member_id, 
 m.status, m.username, msg.type, msg.messages, msg.msg_album_id, u.upload_data_id, u.album_id, msg.share,
msg.video_id, msg.share_by, msg.wall_privacy, v.location,v.location1,v.location2, v.thumburl, v.title, v.video_id, v.description,
 			v.msg_id, v.category, v.country_id, v.title_color,v.title_size,v.ads,a.ads_name,
				a.location as adslocation,a.location1 as adslocation1,a.location2 as adslocation2, a.click_url, msg.share_msg
FROM message msg
LEFT JOIN member m ON msg.member_id = m.member_id
LEFT JOIN upload_data u on msg.messages_id = u.msg_id
LEFT JOIN videos v ON v.msg_id = msg.messages_id 
LEFT JOIN videos_ads a ON v.ads_id = a.id
WHERE msg.content_id ='$memberID'
OR msg.member_id in ($wallItem)
OR msg.member_id = '$memberID'
OR msg.share_by = '$memberID'
AND msg.photo_status != 1
AND messages_id < '$last_id'
GROUP BY messages_id
ORDER BY messages_id DESC
LIMIT 10";
	
	$db_Obj = new database();	
	$results = $db_Obj->execQueryWithFetchAll($sql); 
	return $results;
}





//// Added By Yasser Hossam & Moshera Ahmad 31/1/2016 to 8/2/2016
// Send Notification Messages
//////////////////////////////////////////
///////////////// Type Mapping ///////////
// 1- Member Likes your Post...tested
// 2- Member Dislike your post...tested
// 3- Member comment on your post...tested
// 4- Member reply on a comment on your post...tested
// 5- Member reply on your comment on a post... (reply on your comment not working)
// 6- Friend Create New Post... tested
// 7- Someone Liked post shared from your wall... tested
// 8- Someone Disliked post shared from your wall... tested
// 9- Someone Commented on a post shared from your wall... tested
// 10- Someone shared a post shared from your wall... tested
// 11- group post notification. !!! (not working) !!
// 12- Someone shared your post... tested
// 13- Someone Likes post you Liked... tested
// 14- Someone Likes post you Disliked... tested
// 15- Someone Likes post you commented on... tested
// 16- Someone Likes post you Shared... tested
// 17- Someone Dislike post you Liked... tested
// 18- Someone Dislike post you Disliked... tested
// 19- Someone Dislike post you commented on... tested
// 20- Someone Dislike post you Shared... tested
// 21- Someone comment on a post you Liked... tested
// 22- Someone comment on a post you Disliked... tested
// 23- Someone comment on a post you commented on... tested
// 24- Someone comment on a post you Shared... tested
// 25- Someone share a post you Liked... tested
// 26- Someone Share a post you Disliked... tested
// 27- Someone shared a post you commented on... tested
// 28- Someone share a post you Shared... tested
// 29- Someone posted in friend wall
// 30- News Alert ... tested (mail notification not yet)




/// Cases to be handled 
//3.page_request,
//4.country_request,
//5.group_request,
//6.invite_event,
//7.request_accepted,
//10.wants to be friend 






function send_notification_message($postID,$commentID,$senderID,$type){
$base_url = "https://quakbox.com/";
$site_email = "noreply@quakbox.com";
		
$db_Obj = new database();	
$member = new Member();
$objMember = new member1();
$email_signature = ''; // str_replace("\\n", '<br>', $objMember->select_member_meta_value($senderID, 'email_signature'));

$receivers = "";
$before_place  = "";

//////// Sender Info.
$sender_name = $member->get_member_name($senderID);
$sender_Img = $base_url . $this->toAscii($this->get_member_Img($senderID));
$sender_friends_count = $member->get_member_friends_count($senderID);
$sender_username = $member->get_member_username($senderID);
	
/////// Post Creator Info.
$post_creator_id = $this->get_post_creator_id($postID);
$post_creator_name = $member->get_member_name($post_creator_id);
$post_creator_email = $member->get_member_email($post_creator_id);
$post_creator_username = $member->get_member_username($post_creator_id);


/////// Post Info
$post_res = $db_Obj->execQueryWithFetchObject("SELECT * FROM `message` WHERE `messages_id` = $postID");
$post_country = $post_res->country_flag;
$post_type_id = $post_res->type;
$post_country_flag = $post_res->country_flag;
$post_content = $post_res->messages;
$original_post_id = $post_res->share_id;
$place = $post_country ;
//post Type
if($post_type_id == 0)
{
	$post_type="status";
	$post_content = "<tr><td style='font-size:18px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding:5px;width:100%;'>"."\"".$post_content."\""."</td></tr>";
}
else if($post_type_id==1)
	{
		$post_type="photo";
		$post_content = "<tr><td style='padding:5px;width:100%;'>"."<img src='".$base_url.$post_content."' height='150' width='150'>"."</td></tr>";
	}
else if($post_type_id==2)
	{$post_type="video";
        $post_content='';
	}
else if($post_type_id==3)
	{$post_type="url";}
// end post type	
// Get Place Details (Image and URL)
	if($post_country == "world")
	{
		$post_country = "the world";
		$country_img = $base_url."images/ImageWorld.png";
		$country_wall_url = $base_url."home";
		$place = "the world" ;
	}
	else
	{
		$country = $db_Obj->execQueryWithFetchObject("SELECT code FROM `geo_country` WHERE `country_title` = '$post_country'");
		$country_code = $country->code;
		$country_img = $base_url."images/Flags/flags_new/flags/".$country_code.".png";
		$country_wall_url = $base_url."country/".$country_code;
	}
	
$country_img_html = "<a href='".$country_wall_url."'><img src='".$country_img."' height='25' width='25' style='padding-left:5px;'></a>";
//end place details
///////////////////////////////////////////////////////////////////////////////
		
/////// Comment Info.
if($commentID != 0)
{	
	$commenter_id = $this->get_comment_creator($commentID);
	$commenter_name = $member->get_member_name($commenter_id);
	$commenter_email = $member->get_member_email($commenter_id);	
	$comment_content = $this->get_comment_content($commentID);
	$comment_content_html = "<tr><td style='font-size:14px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding:25px;margin:25px;width:60%;'>
						$comment_content</td></tr>";
}


/////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////	
$portal_notification_sender = "";
$portal_notification_receiver = "";
$portal_notification_href = "";


	if($type == 1)
	{
		$action = "Likes";
		$receiver = "your";
		$target = $post_type;
		$receivers = $post_creator_email."";
		
		$portal_notification_sender = $senderID;
		$portal_notification_receiver = $post_creator_id;
		$portal_notification_href = 'posts.php?id='.$postID;
	}
	else if($type == 2)
	{
		$action = "Dislikes";
		$receiver = "your";
		$target = $post_type;
		$receivers = $post_creator_email."";
		
		$portal_notification_sender = $senderID;
		$portal_notification_receiver = $post_creator_id;
		$portal_notification_href = 'posts.php?id='.$postID;
	}
	else if($type == 3)
	{
		$action = "Commented on";
		$receiver = "your";
		$target = $post_type;
		$receivers = $post_creator_email."";
		$post_content =  $post_content . "<tr><td></td></tr>" . $comment_content_html ;
		
		$portal_notification_sender = $senderID;
		$portal_notification_receiver = $post_creator_id;
		$portal_notification_href = 'posts.php?id='.$postID;
	}
	else if($type == 4)
	{
		if($commenter_id == $post_creator_id){$commenter_name = "your";}
		else if ($commenter_id == $senderID){$commenter_name = "his";}
		else {$commenter_name = $commenter_name . "'s";}
		
		$action = "Replied on ".$commenter_name." comment on ";
		$receiver = "your";
		$target = $post_type;
		$receivers = $post_creator_email."";
		
		$portal_notification_sender = $senderID;
		$portal_notification_receiver = $post_creator_id;
		$portal_notification_href = 'posts.php?id='.$postID;
	}
	else if($type == 5)
	{
		if($senderID == $post_creator_id)
		{$post_creator_name = "his";}
		else if($commenter_id == $post_creator_id)
		{$post_creator_name = "your";}
		else {$post_creator_name .= "\'s";}
	
		$action = "Reply on your comment on ";
		$receiver = $post_creator_name . " ";
		$target = $post_type;
		$receivers = $commenter_email."";

		$portal_notification_sender = $senderID;
		$portal_notification_receiver = $commenter_id;
		$portal_notification_href = 'posts.php?id='.$postID;
	}
	else if($type == 6)
	{
		$action = "Post a new  ";
		$receiver = "";
		$target = $post_type;
		$receivers = $member->get_member_friends_emails($senderID);
		
		$portal_notification_sender = $senderID;
		$portal_notification_receiver = $member->get_member_friends_ids($senderID);
		$portal_notification_href = 'posts.php?id='.$postID;
	}
	else if($type == 7)
	{
		$action = "Likes";
		$receiver = "";
		$target = $post_type;
		$before_place = " shared from your wall";
		
		$original_poster_id = $this->get_post_source_creator($original_post_id);
		$original_poster_email = $member->get_member_email($original_poster_id);
		$receivers =$original_poster_email;
		$post_creator_id = $original_poster_id;
		
		$portal_notification_sender = $senderID;
		$portal_notification_receiver = $original_poster_id;
		$portal_notification_href = 'posts.php?id='.$original_post_id;		
	}
	else if($type == 8)
		{
			$action = "Dislikes";
			$receiver = "";
			$target = $post_type ;
			$before_place = " shared from your wall";
			
			$original_poster_id = $this->get_post_source_creator($original_post_id);
			$original_poster_email = $member->get_member_email($original_poster_id);
			$receivers =$original_poster_email;
			$post_creator_id = $original_poster_id;
				
			$portal_notification_sender = $senderID;
			$portal_notification_receiver = $original_poster_id;
			$portal_notification_href = 'posts.php?id='.$original_post_id;
		}
	else if($type == 9)
		{
			$action = "Commented on a ";
			$receiver = "";
			$target = $post_type;
			$before_place = " shared from your wall" ;
			
			$original_poster_id = $this->get_post_source_creator($original_post_id);
			$original_poster_email = $member->get_member_email($original_poster_id);
			$receivers =$original_poster_email;
			$post_creator_id = $original_poster_id;
			
			$portal_notification_sender = $senderID;
			$portal_notification_receiver = $original_poster_id;
			$portal_notification_href = 'posts.php?id='.$original_post_id;
		}
		else if($type == 10)
		{
			$action = "shared a ";
			$receiver = "";
			$target = $post_type;
			$before_place = " shared from your wall" ;
			
			$original_poster_id = $this->get_post_source_creator($original_post_id);
			$original_poster_email = $member->get_member_email($original_poster_id);
			$receivers =$original_poster_email;
			$post_creator_id = $original_poster_id;
			
			$portal_notification_sender = $senderID;
			$portal_notification_receiver = $original_poster_id;
			$portal_notification_href = 'posts.php?id='.$original_post_id;
		}
	else if($type == 11)
	{
		$action = "Post a new  ";
		$receiver = "";
		$target = $post_type;
				
		$groupID = $this->get_group_Id_from_alphID($post_country_flag);
		$group_name = $this->get_group_name_by_id($groupID);		
		$place = $group_name ;
		$receivers = $this->get_group_members_emails_without_sender($groupID,$senderID);	

		$country_wall_url = $base_url."groups_wall.php?group_id=".$groupID;
		$country_img_html = "";
		
		$portal_notification_sender = $senderID;
		$portal_notification_receiver = $this->get_group_members_ids_without_sender($groupID,$senderID);
		$portal_notification_href = "groups_wall.php?group_id=".$groupID;
	}
	else if($type == 12)
	{
		$action = "shared  ";
		$receiver = "your";
		$target = $post_type;
	
		$original_post_creator = $this->get_post_source_creator($original_post_id);
		$original_poster_email = $member->get_member_email($original_post_creator);
		$receivers = $original_poster_email;
		
		$original_post_creator_id = $original_post_creator;

		$portal_notification_sender = $senderID;
		$portal_notification_receiver = $original_post_creator;
		$portal_notification_href = 'posts.php?id='.$original_post_id;
	}
	else if($type == 13)
	{
		$action = "Likes  ";
		$receiver = "a";
		$target = $post_type;
		$before_place = " you have liked";
		
		$receivers = $this->get_post_likers_emails($postID,$senderID);
		
		$portal_notification_sender = $senderID;
		$portal_notification_receiver = $this->get_post_likers_ids($postID,$senderID);
		$portal_notification_href = 'posts.php?id='.$postID;
	
	}
	else if($type == 14)
	{
		$action = "Likes  ";
		$receiver = "a";
		$target = $post_type;
		$before_place = " you have disliked";
		
		$receivers = $this->get_post_dislikers_emails($postID,$senderID );
		
		$portal_notification_sender = $senderID;
		$portal_notification_receiver = $this->get_post_dislikers_ids($postID,$senderID );
		$portal_notification_href = 'posts.php?id='.$postID;
	
	}
	else if($type == 15)
	{
		$action = "Likes  ";
		$receiver = "a";
		$target = $post_type;
		$before_place = " you have commented on";
		
		$receivers = $this->get_post_commenters_emails($postID,$senderID );
		
		$portal_notification_sender = $senderID;
		$portal_notification_receiver = $this->get_post_commenters_ids($postID,$senderID );
		$portal_notification_href = 'posts.php?id='.$postID;
	
	}
	else if($type == 16)
	{
		$action = "Likes  ";
		$receiver = "a";
		$target = $post_type;
		$before_place = " you have shared ";
		
		$receivers = $this->get_post_sharers_emails($postID,$senderID );
		
		$portal_notification_sender = $senderID;
		$portal_notification_receiver = $this->get_post_sharers_ids($postID,$senderID );
		$portal_notification_href = 'posts.php?id='.$postID;
	
	}		
	else if($type == 17)
	{
		$action = "Dislikes  ";
		$receiver = "a";
		$target = $post_type;
		$before_place = " you have liked";
		
		$receivers = $this->get_post_likers_emails($postID,$senderID);
		
		$portal_notification_sender = $senderID;
		$portal_notification_receiver = $this->get_post_likers_ids($postID,$senderID);
		$portal_notification_href = 'posts.php?id='.$postID;
	
	}
	else if($type == 18)
	{
		$action = "Dislikes  ";
		$receiver = "a";
		$target = $post_type;
		$before_place = " you have disliked";
		
		$receivers = $this->get_post_dislikers_emails($postID,$senderID );
		
		$portal_notification_sender = $senderID;
		$portal_notification_receiver = $this->get_post_dislikers_ids($postID,$senderID );
		$portal_notification_href = 'posts.php?id='.$postID;
	
	}
	else if($type == 19)
	{
		$action = "Dislikes  ";
		$receiver = "a";
		$target = $post_type;
		$before_place = " you have commented on";
		
		$receivers = $this->get_post_commenters_emails($postID,$senderID );
		
		$portal_notification_sender = $senderID;
		$portal_notification_receiver = $this->get_post_commenters_ids($postID,$senderID );
		$portal_notification_href = 'posts.php?id='.$postID;
	
	}
	else if($type == 20)
	{
		$action = "Dislikes  ";
		$receiver = "a";
		$target = $post_type;
		$before_place = " you have shared ";
		
		$receivers = $this->get_post_sharers_emails($postID,$senderID );
		
		$portal_notification_sender = $senderID;
		$portal_notification_receiver = $this->get_post_sharers_ids($postID,$senderID );
		$portal_notification_href = 'posts.php?id='.$postID;
	
	}	
		else if($type == 21)
	{
		$action = "Commented on ";
		$receiver = "a";
		$target = $post_type;
		$before_place = " you have liked";
		
		$receivers = $this->get_post_likers_emails($postID,$senderID);
		
		$portal_notification_sender = $senderID;
		$portal_notification_receiver = $this->get_post_likers_ids($postID,$senderID);
		$portal_notification_href = 'posts.php?id='.$postID;
	
	}
	else if($type == 22)
	{
		$action = "Commented on ";
		$receiver = "a";
		$target = $post_type;
		$before_place = " you have disliked";
		
		$receivers = $this->get_post_dislikers_emails($postID,$senderID );
		
		$portal_notification_sender = $senderID;
		$portal_notification_receiver = $this->get_post_dislikers_ids($postID,$senderID );
		$portal_notification_href = 'posts.php?id='.$postID;
	
	}
	else if($type == 23)
	{
		$action = "Commented on ";
		$receiver = "a";
		$target = $post_type;
		$before_place = " you have commented on";
		
		$receivers = $this->get_post_commenters_emails($postID,$senderID );
		
		$portal_notification_sender = $senderID;
		$portal_notification_receiver = $this->get_post_commenters_ids($postID,$senderID );
		$portal_notification_href = 'posts.php?id='.$postID;
	
	}
	else if($type == 24)
	{
		$action = "Commented on ";
		$receiver = "a";
		$target = $post_type;
		$before_place = " you have shared ";
		
		$receivers = $this->get_post_sharers_emails($postID,$senderID );
		
		$portal_notification_sender = $senderID;
		$portal_notification_receiver = $this->get_post_sharers_ids($postID,$senderID );
		$portal_notification_href = 'posts.php?id='.$postID;
	}	
		else if($type == 25)
	{
		$action = "Shared ";
		$receiver = "a";
		$target = $post_type;
		$before_place = " you have liked";
		
		$receivers = $this->get_post_likers_emails($postID,$senderID);
		
		$portal_notification_sender = $senderID;
		$portal_notification_receiver = $this->get_post_likers_ids($postID,$senderID);
		$portal_notification_href = 'posts.php?id='.$postID;
	
	}
	else if($type == 26)
	{
		$action = "Shared ";
		$receiver = "a";
		$target = $post_type;
		$before_place = " you have disliked";
		
		$receivers = $this->get_post_dislikers_emails($postID,$senderID );
		
		$portal_notification_sender = $senderID;
		$portal_notification_receiver = $this->get_post_dislikers_ids($postID,$senderID );
		$portal_notification_href = 'posts.php?id='.$postID;
	
	}
	else if($type == 27)
	{
		$action = "Shared ";
		$receiver = "a";
		$target = $post_type;
		$before_place = " you have commented on";
		
		$receivers = $this->get_post_commenters_emails($postID,$senderID );
		
		$portal_notification_sender = $senderID;
		$portal_notification_receiver = $this->get_post_commenters_ids($postID,$senderID );
		$portal_notification_href = 'posts.php?id='.$postID;
	
	}
	else if($type == 28)
	{
		$action = "Shared ";
		$receiver = "a";
		$target = $post_type;
		$before_place = " you have shared ";
		
		$receivers = $this->get_post_sharers_emails($postID,$senderID );
		
		$portal_notification_sender = $senderID;
		$portal_notification_receiver = $this->get_post_sharers_ids($postID,$senderID );
		$portal_notification_href = 'posts.php?id='.$postID;
	}	
	else if($type == 29)
	{
		$action = "Post ";
		$receiver = "a new ";
		$target = $post_type;
		
		$place ="your wall";
		
		$wall_owner_id = $member->get_id_by_username($post_country_flag);
		
		$receivers = $member->get_member_email($wall_owner_id);
		
		$portal_notification_sender = $senderID;
		$portal_notification_receiver = $wall_owner_id;
		$portal_notification_href = 'posts.php?id='.$postID;
	}	
	
	
	
	
	if(($senderID != $post_creator_id) || ($type == 6) || ($type == 5 && ($senderID != $commenter_id))|| ($type == 11) 
		|| ($type == 12 && ($senderID != $original_post_creator_id) ) || ($type == 29) )
	{
		
		
		
	/////////////// Insert Portal Notification
	$notification_title =" " . $action . " " . $receiver . " " . $target . $before_place . " in " . $place;
	$receivers_ids = explode(",", $portal_notification_receiver);
	foreach( $receivers_ids as $receivers_id )
	{
   		 $this->insert_portal_notification($portal_notification_sender,$receivers_id,$type,$notification_title,'posts.php?id='.$postID); 
	}
	
	
	////////////// Send Mail Notification
	// Generate Email Subject
	$subject = "QuakBox | ". $sender_name. " " . $action . " " . $receiver . " " . $target . $before_place . " in " . $place ;
	

	// Generate 
	$message = 
	"
		<html>
	
	<body style='font-family:Verdana, Geneva, sans-serif; font-size:14px;'>
	
	<table width='100%' cellpadding='0' cellspacing='0' style='border-collapse:collapse;width:100%;'>
	<tbody>
	<tr>
	<td style='font-family:lucida grande,tahoma,verdana,arial,sans-serif;font-size:12px;'>
	
	<table width='100%' cellpadding='0' cellspacing='0' style='border-collapse:collapse;width:100%;'>
	<tbody>
	<tr>
	<td style='font-size:16px;font-family:lucida grande,tahoma,verdana,arial,sans-serif;background:#4F70D1;color:#ffffff;font-weight:bold;vertical-align:baseline;letter-spacing:-0.03em;text-align:left;padding:5px 20px;'>
	<a href='".$base_url."' style='text-decoration:none'>
	<span style='background:#4F70D1;color:#ffffff;font-weight:bold;font-family:lucida grande,tahoma,verdana,arial,sans-serif;vertical-align:middle;font-size:16px;letter-spacing:-0.03em;text-align:left;vertical-align:baseline;'>
	<img src='".$base_url."images/qb-email.png' height='30' style='margin-right:3px;'><img src='".$base_url."images/qb-quack.png' width='75' height='30'>
	<span>
	</a>
	</td>
	</tr>
	</tbody>
	</table>
	
	<table width='100%' cellpadding='0' cellspacing='0' style='border-collapse:collapse;width:100%;' border='0'>
	<tbody>
	<tr>
	<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding:0px;background-color:#f2f2f2;border-left:none;border-right:none;border-top:none;border-bottom:none'>
	
	<table cellpadding='0' cellspacing='0' style='border-collapse:collapse;width:100%;'>
	<tbody>
	<tr>
	<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding:0px;width:100%;'>
	
	<table width='100%' cellpadding='0' cellspacing='0' style='border-collapse:collapse;width:100%;'>
	<tbody>
	<tr>
	
	<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding:20px;background-color:#fff;border-left:none;border-right:none;border-top:none;border-bottom:none'>
	
	<table cellpadding='0' cellspacing='0' style='border-collapse:collapse;'>
	<tbody>
	<tr>
	
	<td valign='top' style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding-right:15px;text-align:left'>
	<a href='".$base_url."i/".$sender_username."' style='color:#3b5998;text-decoration:none'>
	<img style='border:0' height='50' width='50' src='".$sender_Img."' />
	</a>
	</td>
	
	<td valign='top' style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;width:100%;text-align:left'>
	<table cellpadding='0' cellspacing='0' style='border-collapse:collapse;width:100%;'>
	<tbody>
	<tr>
	<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding-bottom:2px'>
	<span style='color:#111111;font-size:14px;font-weight:bold'>
	<a href='".$base_url."i/".$sender_username."' target='_blank' style='color:#3b5998;text-decoration:none'>
	".$sender_username."
	</a>
	
	". " " . $action . " " . $receiver . " " . "$target" . $before_place . 
	" in " . "<a href='".$country_wall_url."'>" .$place. "</a>" .
	$country_img_html .
	
	"</span>
	</td>
	</tr>
	
	<tr>
	<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding-top:1px'>
	<span style='color:#333333'>
	<span>
	".$sender_friends_count." friends
	
	<br><br>
	"."     "."
	</span>
	</span>
	</td>
	</tr>
	</tbody>
	</table>
	
	</td>
	</tr>
	</tbody>
	</table>
	
	</td>
	</tr>
	</tbody>
	</table>
	
	</td>
	</tr>
	
	<tr>
	<td style='font-size:18px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding:5px;width:100%;'>
	<center>
	$post_content 
	</center>
	
	</td>
	</tr>
	
	<tr>
	<td style='font-size:15px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding:5px;width:100%;'>
	$email_signature 
	</td>
	</tr>
	
	
	
	<tbody>
	<table>
	
	</td>
	</tr>
	
	</tbody>
	</table>
	
	</body>
	</html>
	";
	
		// Always set content-type when sending HTML email
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

		$headers .= "From: QuakBox <".$site_email.">";
	 
	$emailIds = explode(",", $receivers);
	foreach( $emailIds as $email_id )
	{
   		$mail = mail($email_id, $subject, $message, $headers); 
	}
		
  }
  
  
}	




// General Functions
// Coded By Yasser Hossam & Moshera Ahmad 
// For General Uses in the notifications and other modules



// Get Post Likers Emails
// Input : PostId, Output : String with emails separated by (,)
function get_post_likers_emails($postID,$senderID)
{
	$members_emails = "";
	$db_Obj = new database(); 
	$sql = "SELECT DISTINCT `email` FROM `bleh` INNER JOIN `member` ON `member`.`member_id` = `bleh`.`member_id` WHERE `remarks` = '$postID'  AND `member`.`member_id` <> '$senderID'";
	$results = $db_Obj->execQueryWithFetchAll($sql);
	foreach( $results as $row ) 
	{
		$members_emails = $members_emails . "," . $row['email'];
	}
	return $members_emails;
}


// Get Post Likers Ids
// Input : PostId, Output : String with ids separated by (,)
function get_post_likers_ids($postID,$senderID)
{
	$members_ids = "";
	$db_Obj = new database(); 
	$sql = "SELECT DISTINCT `member_id` FROM `bleh` WHERE `remarks` = '$postID'  AND `member_id` <> '$senderID'";
	$results = $db_Obj->execQueryWithFetchAll($sql);
	foreach( $results as $row ) 
	{
		$members_ids = $members_ids . "," . $row['member_id'];
	}
	return $members_ids;
}


// Get Post Dislikers Emails
// Input : PostId, Output : String with emails separated by (,)
function get_post_dislikers_emails($postID,$senderID)
{
	$members_emails = "";
	$db_Obj = new database(); 
	$sql = "SELECT DISTINCT `email` FROM `post_dislike` INNER JOIN `member` ON `member`.`member_id` = `post_dislike`.`member_id` WHERE `msg_id` = '$postID'  AND `member`.`member_id` <> '$senderID'";
	$results = $db_Obj->execQueryWithFetchAll($sql);
	foreach( $results as $row ) 
	{
		$members_emails = $members_emails . "," . $row['email'];
	}
	return $members_emails;
}


// Get Post Dislikers Id
// Input : PostId, Output : String with ids separated by (,)
function get_post_dislikers_ids($postID,$senderID)
{
	$members_ids = "";
	$db_Obj = new database(); 
	$sql = "SELECT DISTINCT `member_id` FROM `post_dislike` WHERE `msg_id` = '$postID' AND `member_id` <> '$senderID'";
	$results = $db_Obj->execQueryWithFetchAll($sql);
	foreach( $results as $row ) 
	{
		$members_ids = $members_ids . "," . $row['member_id'];
	}
	return $members_ids;
}




// Get Post Commenters Emails
// Input : PostId, Output : String with emails separated by (,)
function get_post_commenters_emails($postID,$senderID)
{
	$members_emails = "";
	$db_Obj = new database(); 
	$sql = "SELECT DISTINCT `email` FROM `postcomment` INNER JOIN `member` ON `member`.`member_id` = `postcomment`.`post_member_id` WHERE `msg_id` = '$postID'  AND `member`.`member_id` <> '$senderID'";
	$results = $db_Obj->execQueryWithFetchAll($sql);
	foreach( $results as $row ) 
	{
		$members_emails = $members_emails . "," . $row['email'];
	}
	return $members_emails;
}



// Get Post commenters Id
// Input : PostId, Output : String with ids separated by (,)
function get_post_commenters_ids($postID,$senderID)
{
	$members_ids = "";
	$db_Obj = new database(); 
	$sql = "SELECT DISTINCT `post_member_id` FROM `postcomment` WHERE `msg_id` = '$postID' AND `post_member_id` <> '$senderID'";
	$results = $db_Obj->execQueryWithFetchAll($sql);
	foreach( $results as $row ) 
	{
		$members_ids = $members_ids . "," . $row['post_member_id'];
	}
	return $members_ids;
}



// Get Post Sharers Emails
// Input : PostId, Output : String with emails separated by (,)
function get_post_sharers_emails($postID,$senderID)
{
	$members_emails = "";
	$db_Obj = new database(); 
	$sql = "SELECT DISTINCT `email` FROM `message` INNER JOIN `member` ON `member`.`member_id` = `message`.`member_id` WHERE share_id = '$postID'  AND `member`.`member_id` <> '$senderID'";
	$results = $db_Obj->execQueryWithFetchAll($sql);
	foreach( $results as $row ) 
	{
		$members_emails = $members_emails . "," . $row['email'];
	}
	return $members_emails;
}



// Get Post sharers Id
// Input : PostId, Output : String with ids separated by (,)
function get_post_sharers_ids($postID,$senderID)
{
	$members_ids = "";
	$db_Obj = new database(); 
	$sql = "SELECT DISTINCT `member_id` FROM `message` WHERE `share_id` = '$postID' AND `member_id` <> '$senderID'";
	$results = $db_Obj->execQueryWithFetchAll($sql);
	foreach( $results as $row ) 
	{
		$members_ids = $members_ids . "," . $row['post_member_id'];
	}
	return $members_ids;
}



// Get members favourite a specific country 
// Input : country code, Output : list of interested people emails
function get_country_fans_emails($country_code)
{
	$members_emails = "";
	$db_Obj = new database(); 
	$sql = "SELECT DISTINCT `member`.`email` FROM `favourite_country` INNER JOIN `member` ON `member`.`member_id` = `favourite_country`.`member_id` WHERE `favourite_country`.`cod;2e` = '$country_code'";
	$results = $db_Obj->execQueryWithFetchAll($sql);
	foreach( $results as $row ) 
	{
		$members_emails = $members_emails . "," . $row['email'];
	}
	return $members_emails;
}


// Get the post creator Id
// Input : postID , Output : creatorID
function get_post_creator_id($postID)
{
	$db_Obj = new database(); 
	$post_creator = $db_Obj->execQueryWithFetchObject("SELECT `member`.`member_id` FROM `message` INNER JOIN `member` ON `member`.`member_id` = `message`.`member_id` WHERE `messages_id` = $postID");
	return $post_creator->member_id;
}


// Get the user which this post shared from his wall
// Input : PostId , Output : member_id
function get_post_source_creator($postId)
{
	$db_Obj = new database(); 
	$shared_source_member = $db_Obj->execQueryWithFetchObject("SELECT `member`.`member_id` FROM `message` INNER JOIN `member` ON `member`.`member_id` = `message`.`member_id` WHERE `message`.`messages_id` = '$postId'");
	return $shared_source_member->member_id;
}


// Get the user's image
// Input : memberId , Output : Image Path without base url
function get_member_Img($memberId)
{
	$objMember = new member1();
	$media = $objMember->select_member_meta_value($memberId,'current_profile_image');
	if(!$media)
		$media = "images/default.png";
	
	return $media;
}


// Get the commenter Id of the comment
// Input : CommentId , Output : member_id
function get_comment_creator($commentID)
{
	$db_Obj = new database(); 
	$comment = $db_Obj->execQueryWithFetchObject("SELECT post_member_id FROM `postcomment` WHERE `comment_id` = $commentID");
	return $comment->post_member_id;
}


// Get the comment Content
// Input : CommentId , Output : comment content
function get_comment_content($commentID)
{
	$db_Obj = new database(); 
	$comment = $db_Obj->execQueryWithFetchObject("SELECT content FROM `postcomment` WHERE `comment_id` = $commentID");
	return $comment->content;
}



//////////////////////////////////////////////////////////////// Group Functions
// Get group Id using group alpha code
// Input : group alpha code , Output : group Id
function get_group_Id_from_alphID($group_alpha_code)
{
	//get group ID from Alpha ID
	$QbSecurityPost = new QB_SqlInjection();
	$groupID = $QbSecurityPost->QB_AlphaID($group_alpha_code,true);
	return $groupID;
}


// Get group name using group alpha code
// Input : group alpha code , Output : group name
function get_group_name_by_id($groupID)
{ 
	$db_Obj = new database();
	$group = $db_Obj->execQueryWithFetchObject("SELECT name AS GroupName FROM `groups` WHERE `id` = $groupID");
	return $group->GroupName;
}


// Get Group Members Emails
// Input : GroupId, Output : String with emails separated by (,)
function get_group_members_emails($GroupID)
{
	$members_emails = "";
	$db_Obj = new database(); 
	$sql = "SELECT email FROM groups_members INNER JOIN `member` ON `member`.`member_id` = `groups_members`.`member_id` WHERE `groupid` = '$GroupID'";
	$results = $db_Obj->execQueryWithFetchAll($sql);
	foreach( $results as $row ) 
	{
		$members_emails = $members_emails . "," . $row['email'];
	}
	return $members_emails;
}


// Get Group Members Emails without sender
// Input : GroupId, Output : String with emails separated by (,)
function get_group_members_emails_without_sender($GroupID,$senderID)
{
	$members_emails = "";
	$db_Obj = new database(); 
	$sql = "SELECT email FROM groups_members INNER JOIN `member` ON `member`.`member_id` = `groups_members`.`member_id` WHERE `groupid` = '$GroupID' AND `member`.`member_id` <> '$senderID' ";
	$results = $db_Obj->execQueryWithFetchAll($sql);
	foreach( $results as $row ) 
	{
		$members_emails = $members_emails . "," . $row['email'];
	}
	return $members_emails;
}
		
// Get Group Members Ids without sender
// Input : GroupId, Output : String with Ids separated by (,)
function get_group_members_ids_without_sender($GroupID,$senderID)
{
	$members_ids = "";
	$db_Obj = new database(); 
	$sql = "SELECT `member`.member_id FROM groups_members INNER JOIN `member` ON `member`.`member_id` = `groups_members`.`member_id` WHERE `groupid` = '$GroupID' AND `member`.`member_id` <> '$senderID' ";
	$results = $db_Obj->execQueryWithFetchAll($sql);
	foreach( $results as $row ) 
	{
		$members_ids = $members_ids . "," . $row['member_id'];
	}
	return $members_ids;
}		
		
		
//////////////////////////////////////////////////////////////////////////// End Group Functions







//// Added By Yasser Hossam & Moshera Ahmad 7/2/2016
// Insert Portal Notification
function insert_portal_notification($senderId,$receiverID,$type,$title,$href)
{
	$db_Obj = new database(); 
	$title = str_replace("'","",$title);
	 $sql = "INSERT INTO notifications (sender_id, received_id, type_of_notifications,title, href, is_unread, date_created) 
	VALUES('$senderId','$receiverID','$type','$title','$href',0,".strtotime(date("Y-m-d H:i:s")).")";	
	$rs = $db_Obj->insertQueryReturnLastID($sql); 
}




///////////////////// Very General Functions
function toAscii($str) {
    return str_replace(' ', '%20', $str);
}






}