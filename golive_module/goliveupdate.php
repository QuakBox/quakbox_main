<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php'); 	 
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');		
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/post_extra.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/time_stamp.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/video-time.php');
	header("Access-Control-Allow-Origin: *"); 
 
//echo "1212 121";
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/connection/qb_database.php');


require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_security.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_lookup.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_misc.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');

require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member.php');

require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_post.php');
	
	$session_member_id = $QbSecurity->qbClean($_SESSION['SESS_MEMBER_ID'], $con);
//echo "<pre>";
//print_r($_POST);
//die();
header("Access-Control-Allow-Origin: *"); 
//error_reporting(E_ALL);
//ini_set('display_errors', 1);  
//echo "1212 121";
//require_once("qb_classes/connection/qb_database.php");
//include($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php');
//require_once("qb_classes/qb_post.php");
//set_error_handler("someFunction");

function get_post_creator_id($postID)
{
	$db_Obj = new database(); 
	$post_creator = $db_Obj->execQueryWithFetchObject("SELECT `member`.`member_id` FROM `message` INNER JOIN `member` ON `member`.`member_id` = `message`.`member_id` WHERE `messages_id` = $postID");
	return $post_creator->member_id;
}
function insert_portal_notification($senderId,$receiverID,$type,$title,$href)
{
	$db_Obj = new database(); 
	$title = str_replace("'","",$title);
	 $sql = "INSERT INTO notifications (sender_id, received_id, type_of_notifications,title, href, is_unread, date_created) 
	VALUES('$senderId','$receiverID','$type','$title','$href',0,".strtotime(date("Y-m-d H:i:s")).")";	
	$rs = $db_Obj->insertQueryReturnLastID($sql); 
}
function get_comment_creator($commentID)
{
	$db_Obj = new database(); 
	$comment = $db_Obj->execQueryWithFetchObject("SELECT post_member_id FROM `postcomment` WHERE `comment_id` = $commentID");
	return $comment->post_member_id;
}
function toAscii($str) {
    return str_replace(' ', '%20', $str);
}
function get_member_Img($memberId)
{
	$objMember = new member1();
	$media = $objMember->select_member_meta_value($memberId,'current_profile_image');
	if(!$media)
		$media = "images/default.png";
	
	return $media;
}
function get_comment_content($commentID)
{
	$db_Obj = new database(); 
	$comment = $db_Obj->execQueryWithFetchObject("SELECT content FROM `postcomment` WHERE `comment_id` = $commentID");
	return $comment->content;
}
function fetchcountryCode($post_country)
{
	$db_Obj = new database(); 
	$country123 = $db_Obj->execQueryWithFetchObject("SELECT code FROM `geo_country` WHERE `country_title` = '$post_country'");
		$country_code = $country123->code;
	return $country_code;
	
}
function fetchvideourl($postID)
{
	$db_Obj = new database(); 
	 $sql = "SELECT live_video_url FROM `user_live_video` WHERE `msg_id` = '$postID'";
	$videos = $db_Obj->execQueryWithFetchObject($sql);
	//echo "<pre>";
	//print_r($videos);
	return $videos->live_video_url;
	
}
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
$sender_Img = $base_url . toAscii(get_member_Img($senderID));
$sender_friends_count = $member->get_member_friends_count($senderID);
$sender_username = $member->get_member_username($senderID);
	
/////// Post Creator Info.
$post_creator_id = get_post_creator_id($postID);
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
	{$post_type=" live video";
        $post_content='';
	}
else if($post_type_id==3)
	{
		$post_type="url";
}

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
		//$country_code = fetchcountryCode($post_country);
		
		
		//$country_img = $base_url."images/Flags/flags_new/flags/".$country_code.".png";
		//$country_wall_url = $base_url."country/".$country_code;
		$country_wall_url = "";
	}
	$country_img_html ="";
//$country_img_html = "<a href='".$country_wall_url."'><img src='".$country_img."' height='25' width='25' style='padding-left:5px;'></a>";
//end place details
///////////////////////////////////////////////////////////////////////////////
		
/////// Comment Info.
if($commentID != 0)
{	
	$commenter_id = get_comment_creator($commentID);
	$commenter_name = $member->get_member_name($commenter_id);
	$commenter_email = $member->get_member_email($commenter_id);	
	$comment_content = get_comment_content($commentID);
	$comment_content_html = "<tr><td style='font-size:14px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding:25px;margin:25px;width:60%;'>
						$comment_content</td></tr>";
}


/////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////	
$portal_notification_sender = "";
$portal_notification_receiver = "";
$portal_notification_href = "";
	//echo "testing";
	if($type == 31)
	{
		$action = " is on    ";
		$receiver = "";
		$target = $post_type;
		$receivers = $member->get_member_friends_emails($senderID);
		
		$portal_notification_sender = $senderID;
		$portal_notification_receiver = $member->get_member_friends_ids($senderID);
		
	//	$videos = $db_Obj->execQueryWithFetchObject("SELECT * FROM `videos` WHERE `msg_id` = '$postID'");
		$videourl = fetchvideourl($postID);
		
		
		$portal_notification_href = $videourl;
	}
		
		
		
	/////////////// Insert Portal Notification
	//if($place !="")
	//$notification_title =" " . $action . " " . $receiver . " " . $target . $before_place . " in " . $place;
	//else
		//$notification_title =" " . $action . " " . $receiver . " " . $target . $before_place ;
	$notification_title =" " . $action . " " . $receiver . " " . $target . $before_place ;
	$receivers_ids = explode(",", $portal_notification_receiver);
	foreach( $receivers_ids as $receivers_id )
	{
   		 //insert_portal_notification($portal_notification_sender,$receivers_id,$type,$notification_title,'posts.php?id='.$postID); 
   		 insert_portal_notification($portal_notification_sender,$receivers_id,$type,$notification_title,$portal_notification_href); 
	}
		//echo "<pre>adaada";
		//print_r($receivers);
	
	////////////// Send Mail Notification
	// Generate Email Subject
	//$subject = "QuakBox | ". $sender_name. " " . $action . " " . $receiver . " " . $target . $before_place . " in " . $place ;
	$portal_notification_href_link = $portal_notification_href;
	//$before_place ='';
	if($place !="")
	{
		//$subject = "QuakBox | ". $sender_name. " " . $action . " " . $receiver . " " . $target . $before_place . " in " . $place ;
		$subject = "QuakBox | ". $sender_name. " " . $action . " " . $receiver . " " . $target . $before_place;
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
	
	". " " . $action . " " . $receiver . " " . "<a target='_blank' href='".$portal_notification_href_link."'>".$target."</a>" . $before_place . 
	"";
		if($place !="")
		{
			//$message .= " in " . "<a href='".$country_wall_url."'>" .$place. "</a>" .	$country_img_html. "";
		}
		$message .= 
	
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
	}else{
			$subject = "QuakBox | ". $sender_name. " " . $action . " " . $receiver . " " . $target . $before_place  ;
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
	
	". " " . $action . " " . $receiver . " " . "<a target='_blank' href='".$portal_notification_href_link."'>".$target."</a>" . $before_place . 
	 "</a>" .
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
	}
	
	
	

		//die();

	// Generate 
	
		//echo "<pre>testing54312";
		//print_r($receivers);
		//die();
		// Always set content-type when sending HTML email
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

		$headers .= "From: QuakBox <".$site_email.">";
		
		
	 
	$emailIds = explode(",", $receivers);
	//echo "<pre>";
	//print_r($emailIds);
	
	foreach( $emailIds as $email_id )
	{
   		$mail = mail($email_id, $subject, $message, $headers); 
	}
		
}
$loggedin_member_id_for_ajax = $_SESSION['SESS_MEMBER_ID'];
$loc = $_POST['loc'];
$start = $_POST['start'];
$title = $_POST['title'];
$user_privacy = $_POST['privacy'];   
$db_Obj = new database();
$currenTime = time();
	$db_post = new posts();
	if($start ==1)
	{
		$privacy =0;
	$datecreated=strtotime(date('Y-m-d H:i:s'));
	$rs =0;
	$locationForThumb2 = '';
	$locationForThumb1 ='';
	$locationForThumb3 ='';
	$locationForThumb4 = '';
	$locationForThumb5 ='';
	//$duration =100; 
	$wallItem = "btC";
	 $ip = $_SERVER['REMOTE_ADDR'];
	//$type = "4";
	$description = "is on live";  
	$wallID = 89;
	 $sql1 = "INSERT INTO message (member_id,messages,country_flag,type,wall_privacy,date_created,ip,url_title,description,wall_type) 
			VALUES('$loggedin_member_id_for_ajax','$description','$wallItem',2,'$privacy','$datecreated','$ip','','$description','$wallID');";	
	$rs = $db_Obj->insertQueryReturnLastID($sql1);
	$sql = "INSERT INTO user_live_video ( user_id, 	live_video_url,status,video_title,privacy,msg_id,start_time) 
			VALUES('$loggedin_member_id_for_ajax','$loc','$start','$title',$user_privacy,'$rs','$currenTime');";	
	 		
	echo $rs1 = $db_Obj->insertQueryReturnLastID($sql);	
	if($user_privacy ==0)
	send_notification_message($rs,0,$loggedin_member_id_for_ajax,31); 
	}else
	{
		$musql = "update user_live_video set status = 0,end_time= '$currenTime' where live_video_url = '$loc' and user_id = '$loggedin_member_id_for_ajax'";

$mures = mysqli_query($con, $musql) or die(mysqli_error($con));
	}		
	 //echo 'success';
      
?>
