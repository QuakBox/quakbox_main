<?php 
/**
   * @package    action
   * @subpackage 
   * @author     Vishnu
   * Created date  02/05/2015 
   * Updated date  03/13/2015 
   * Updated by    Vishnu S
 **/
ob_start();
require($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php');
include($_SERVER['DOCUMENT_ROOT'].'/config.php');
require($_SERVER['DOCUMENT_ROOT'].'/common/qb_email.php');
$member_id = clean($_POST['member_id'], $con);
$member_id   = f($member_id, 'strip');
$member_id	 = 	f($member_id, 'escapeAll');
$member_id   = mysqli_real_escape_string($con, $member_id);

$content_id = clean($_POST['content_id'], $con);
$content_id   = f($content_id, 'strip');
$content_id	 = 	f($content_id, 'escapeAll');
$content_id   = mysqli_real_escape_string($con, $content_id);

$mystatusx = clean($_POST['mystatusx'], $con);
$mystatusx   = f($mystatusx, 'strip');
$mystatusx	 = 	f($mystatusx, 'escapeAll');
$mystatusx = nl2br($mystatusx);
$mystatusx = mysqli_real_escape_string($con, $mystatusx);
$members_details=mysqli_query($con,"SELECT * FROM `members` WHERE `member_id`='$member_id'");
$members_fetch_details=mysqli_fetch_array($members_details);

$friend_mail_id=mysqli_query($con,"SELECT * FROM `members` WHERE `member_id`='$content_id'");
$friend_fetch_details=mysqli_fetch_array($friend_mail_id);

$mcount = trim(preg_replace_callback('/\s\s+/', function ($matches) {return ' ';}, $mystatusx));
if($mcount == ''){$url = $_SERVER['HTTP_REFERER'];
header("location: ".$url."");exit();
}

else {
$sql="INSERT INTO message (messages, member_id,content_id, date_created,wall_privacy)
VALUES('$mystatusx','$member_id','$content_id','".strtotime(date("Y-m-d H:i:s"))."',1)";

mysqli_query($con, $sql);
$msg_id=mysqli_insert_id($con);
$content_url="posts.php?id=".$msg_id;
$nquery = "INSERT INTO notifications (sender_id, received_id, type_of_notifications, href, is_unread, date_created)

				VALUES('$member_id','$content_id',8,'$content_url',0,'".strtotime(date("Y-m-d H:i:s"))."')";

mysqli_query($con, $nquery);
$to=$friend_fetch_details['email_id'];
$subject = "".ucfirst($members_fetch_details['username'])." update status on your quakbox wall";

$mailTitle="";
$htmlbody = " 
        	<div style='width:100px;float:left;border:1px solid #ddd;'>
        		<a href='".$base_url.$members_fetch_details['username']."' title='".$members_fetch_details['username']."' target='_blank' style='text-decoration:none;'><img style='width:100%;' alt='".$members_fetch_details['username']."' title='".$members_fetch_details['username']."' src='".$base_url.$members_fetch_details['profImage']."' /></a>
        	</div> 
        	<div style='float:left;padding:15px;'>
        		<div>
        			<a href='".$base_url.$members_fetch_details['username']."' title='".$members_fetch_details['username']."' target='_blank' style='text-decoration:none;color:#085D93;'>".$members_fetch_details['username']." update a status on your quakbox wall</a>
        		</div>
        		";
if($mystatusx != ''){	
$htmlbody .="<div>Message: ".$mystatusx."</div>";
}
echo $to;
$obj = new QBEMAIL(); 
$mail=$obj->send_email($to,$subject,'',$mailTitle,$htmlbody,'');
$url = $_SERVER['HTTP_REFERER'];
header("location: ".$url."");exit();
}
?> 