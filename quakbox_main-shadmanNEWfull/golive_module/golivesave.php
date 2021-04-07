<?php
   //ini_set('display_errors',1);
//error_reporting(E_ALL);
header("Access-Control-Allow-Origin: *"); 
 
//echo "1212 121";
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/connection/qb_database.php');


require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_security.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_lookup.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_misc.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_post.php');

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
function fetchvideoid($postID)
{
	$db_Obj = new database(); 
	 $sql = "SELECT video_id FROM `videos` WHERE `msg_id` = '$postID'";
	$videos = $db_Obj->execQueryWithFetchObject($sql);
	//echo "<pre>";
	//print_r($videos);
	return $videos->video_id;
	
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
	if($type == 30)
	{
		$action = "Post a   ";
		$receiver = "";
		$target = $post_type;
		$receivers = $member->get_member_friends_emails($senderID);
		
		$portal_notification_sender = $senderID;
		$portal_notification_receiver = $member->get_member_friends_ids($senderID);
		
	//	$videos = $db_Obj->execQueryWithFetchObject("SELECT * FROM `videos` WHERE `msg_id` = '$postID'");
		$video_id = fetchvideoid($postID);
		
		
		$portal_notification_href = 'watch.php?video_id='.$video_id;
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
   		 insert_portal_notification($portal_notification_sender,$receivers_id,$type,$notification_title,'posts.php?id='.$postID); 
	}
		//echo "<pre>adaada";
		//print_r($receivers);
	
	////////////// Send Mail Notification
	// Generate Email Subject
	//$subject = "QuakBox | ". $sender_name. " " . $action . " " . $receiver . " " . $target . $before_place . " in " . $place ;
	$portal_notification_href_link = $base_url.$portal_notification_href;
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
	
	
	
//set_error_handler("someFunction");
$loggedin_member_id_for_ajax = $_SESSION['SESS_MEMBER_ID'];
   
   
            if (isset($_FILES["video-blob"])) {
				
               /*$uploadDirectory = 'uploads/'.$_POST["filename"].'.webm';
				
				
                if (!move_uploaded_file($_FILES["video-blob"]["tmp_name"], $uploadDirectory)) {
                    echo("Problem writing video file to disk!");
					echo $_FILES["video-blob"]["error"];
					
                }
                else {
					echo "Done";
                   
                }*/
				
				$db_Obj = new database();
	$db_post = new posts();
   
    
    $fileName = "";
    $tempName = '';
    $file_idx = '';
     $file_idx = 'video-blob';
        $fileName = $_POST['filename'];
        $live_video_id = $_POST['LiveVideourl'];
        $live_video_privacy = $_POST['live_video_privacy'];
        $tempName = $_FILES[$file_idx]['tmp_name'];
   
    
    /*if (empty($fileName) || empty($tempName)) {
        if(empty($tempName)) {
            echo 'Invalid temp_name: '.$tempName;
            return;
        }

        echo 'Invalid file name: '.$fileName;
        return;
    }*/

    
   
    
	//$fileName = "40342010542822715.webm";
     $filePath = 'uploadedvideo/new' . $fileName.'.webm';
    
    // make sure that one can upload only allowed audio/video files
    $allowed = array(
        'webm',
        'wav',
        'mp4',
        "mkv",
        'mp3',
        'ogg'
    );
    $extension = pathinfo($filePath, PATHINFO_EXTENSION);
    if (!$extension || empty($extension) || !in_array($extension, $allowed)) {
        echo 'Invalid file extension: '.$extension;
        return;
    }
    
    if (!move_uploaded_file($tempName, $filePath)) {
        if(!empty($_FILES["video-blob"]["error"])) {
            $listOfErrors = array(
                '1' => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
                '2' => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
                '3' => 'The uploaded file was only partially uploaded.',
                '4' => 'No file was uploaded.',
                '6' => 'Missing a temporary folder. Introduced in PHP 5.0.3.',
                '7' => 'Failed to write file to disk. Introduced in PHP 5.1.0.',
                '8' => 'A PHP extension stopped the file upload. PHP does not provide a way to ascertain which extension caused the file upload to stop; examining the list of loaded extensions with phpinfo() may help.'
            );
            $error = $_FILES["video-blob"]["error"];

            if(!empty($listOfErrors[$error])) {
                echo $listOfErrors[$error];
            }
            else {
                echo 'Not uploaded because of error #'.$_FILES["video-blob"]["error"];
            }
        }
        else {
            echo 'Problem saving file: '.$tempName;
        }
        return;
    }else{
		
		$description ='';
		$userId = '';
	$time = time();	
	//echo "post2";
	/*$NameWithoutExtension   = f($videoname, 'strip');
	$NameWithoutExtension	 = 	f($NameWithoutExtension, 'escapeAll');*/
	$videoname1 = pathinfo(basename($fileName), PATHINFO_FILENAME);
	$NameWithoutExtension   = $videoname1;
	//echo "post3";
	$databasePath = 'uploadedvideo/new' . $fileName.'.webm';;
	$locationForMp4 = $databasePath;
	//$locationForMp4 = "uploads/new".$NameWithoutExtension.".mp4";
	$locationForOgg = $databasePath;
	//$locationForOgg = "uploads/new".$NameWithoutExtension.".ogg";
	$locationForWebm = $databasePath; 
	//$locationForWebm = "uploads/new".$NameWithoutExtension.".webm";
	/*$defaultThumb = "uploadedvideo/videothumb/".$dThumb;*/
	//echo "post4";
	/*$base_url2='/home/qbdevqb/public_html/';*/
	/*$locationForThumb1= $NameWithoutExtension."01.png";
	$p300x150_path= "uploads/videothumb/new".$NameWithoutExtension."01.png";
	$p300x150 = "uploads/videothumb/p400x225".$NameWithoutExtension."01.png";
	$p200x150_1 = "uploads/videothumb/p200x150".$NameWithoutExtension."01.png";	
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
	$p300x150_path_2= "uploads/videothumb/new".$NameWithoutExtension."02.png";
	$p300x150_2 = "uploads/videothumb/p400x225".$NameWithoutExtension."02.png";
	$p200x150_2 = "uploads/videothumb/p200x150".$NameWithoutExtension."02.png";
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
	$p300x150_path_3= "uploads/videothumb/new".$NameWithoutExtension."03.png";
	$p300x150_3 = "uploads/videothumb/p400x225".$NameWithoutExtension."03.png";
	$p200x150_3 = "uploads/videothumb/p200x150".$NameWithoutExtension."03.png";
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
	$p300x150_path_4= "uploads/videothumb/new".$NameWithoutExtension."04.png";
	$p300x150_4 = "uploads/videothumb/p400x225".$NameWithoutExtension."04.png";
	$p200x150_4 = "uploads/videothumb/p200x150".$NameWithoutExtension."04.png";
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
	$p300x150_path_5= "uploads/videothumb/new".$NameWithoutExtension."05.png";
	$p300x150_5 = "uploads/videothumb/p400x225".$NameWithoutExtension."05.png";
	$p200x150_5 = "uploads/videothumb/p200x150".$NameWithoutExtension."05.png";
	

	//image resize into 300x150
	$image300x150_5= new Imagick($p300x150_path_5);
	$image300x150_5->adaptiveResizeImage(400,225);
	$image300x150_5->writeImage($p300x150_5);
	$image200x150_5 = new Imagick($p300x150_path_5);
	$image200x150_5->adaptiveResizeImage(200,150);
	$image200x150_5->writeImage($p200x150_5);
	//echo "642";*/

	//extension_loaded('ffmpeg') or die('Error in loading ffmpeg');
	$duration =100; 
	require_once('qb_classes/ffmpeg-php/FFmpegAutoloader.php'); 
	$title =$_POST['videoTitle'];;
	$ffmpegInstance = new ffmpeg_movie($locationForMp4);
	$duration = intval($ffmpegInstance->getDuration());
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
	$description = "Went For Live Streaming";
	$wallID = 89;
	$sql = "INSERT INTO message (member_id,messages,country_flag,type,wall_privacy,date_created,ip,url_title,description,wall_type) 
			VALUES('$loggedin_member_id_for_ajax','$description','$wallItem',2,'$privacy','$datecreated','$ip','','$description','$wallID');";	
	$rs = $db_Obj->insertQueryReturnLastID($sql);		 
 	$videoquery = "INSERT INTO videos (description, location,location1,location2,thumburl,thumburl1,thumburl2,thumburl3,thumburl4,thumburl5,title,user_id,type,url_type,date_created,msg_id,duration,title_size,title_color,live_video_id,live_video_privacy) VALUES('$description','$locationForMp4','$locationForOgg','$locationForWebm','$locationForThumb2','$locationForThumb1','$locationForThumb2','$locationForThumb3','$locationForThumb4','$locationForThumb5','$title','$loggedin_member_id_for_ajax','$live_video_privacy','1','$datecreated','$rs','$duration','14','FFFFFF','$live_video_id','$live_video_privacy')"; 
	
	//$ResultInsertIntoVideos = $db_Obj->execQuery($videoquery);
	$last_video_id = $db_Obj->insertQueryReturnLastID($videoquery);	 
	if($live_video_privacy ==0)
	{
	send_notification_message($rs,0,$loggedin_member_id_for_ajax,30);  
	}	
	}
    
    echo $last_video_id; 
            }
      
?>
