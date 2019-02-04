<?php 
ob_start();
require($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php');	
include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_security.php');
require($_SERVER['DOCUMENT_ROOT'].'/common/qb_email.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
$objMember = new member1(); 
	
  $add_member_id = $_SESSION['SESS_MEMBER_ID'];
  $encryptedMemberID = $_REQUEST['memEnc'];
  $encryptedMemberID = f($encryptedMemberID, 'strip');
  $encryptedMemberID = f($encryptedMemberID, 'escapeAll');
  $encryptedMemberID = mysqli_real_escape_string($con, $encryptedMemberID);
  
  $member_id =$QbSecurity->QB_AlphaID($encryptedMemberID, true); 
  
  $msg = mysqli_real_escape_string($con, $_POST['message']);
  $msg = f($msg, 'escapeAll');
  $msg = mysqli_real_escape_string($con, $msg);

  $time = time();

  $check= mysqli_query($con, "select * from friendlist where (added_member_id = '$member_id' AND member_id='$add_member_id') OR
		(member_id = '$member_id' AND added_member_id='$add_member_id')") or die(mysqli_error($con));
				
 $check_count= mysqli_num_rows($check);
 if($check_count==0)
  	{
	
$sql="INSERT INTO friendlist (member_id, added_member_id, status, request_status,msg,sent) VALUES ('$member_id','$add_member_id','0',1,'".$msg."','$time')";
$responce = mysqli_query($con, $sql);


			

 
			// Added By Yasser Hossam & Moshera Ahmed 8/2/2016 
			// send notification
			$nquery = "INSERT INTO notifications (sender_id, received_id, type_of_notifications, href,title, is_unread, date_created)
				VALUES('$add_member_id','$member_id',36,'pending_request.php','wants to add you as a friend',0,'$time')";
			mysqli_query($con, $nquery);
			
			
			
			

//request to member data
$member_sql = mysqli_query($con, "select * from member where member_id = '$member_id'");
$member_res = mysqli_fetch_array($member_sql);

//request from member data
$member_sql1 = mysqli_query($con, "select * from member where member_id = '$add_member_id'");
$member_res1 = mysqli_fetch_array($member_sql1);

//$country = $member_res1['origion_country'];

$fsql = mysqli_query($con, "select * from friendlist where added_member_id = '$add_member_id'");
$fcount = mysqli_num_rows($fsql);



//$country_sql = mysqli_query($con, "select country_title from geo_country where country_id='".$country."'") or die(mysqli_error($con));
//$country_res = mysqli_fetch_array($country_sql);
$media = $objMember->select_member_meta_value($member_res1['member_id'],'current_profile_image');
if(!$media)
$media = "images/default.png";
$media=$base_url.$media;

//mail function
$to = $member_res['email'];
$subject = "".ucfirst($member_res1['username'])." wants to be your friends on quakbox";

$mailTitle="You have a new friend request";
$htmlbody = " 
        	<div style='width:100px;float:left;border:1px solid #ddd;'>
        		<a href='".$base_url.$member_res1['username']."' title='".$member_res1['username']."' target='_blank' style='text-decoration:none;'><img style='width:100%;' alt='".$member_res1['username']."' title='".$member_res1['username']."' src='".$media."' /></a>
        	</div> 
        	<div style='float:left;padding:15px;'>
        		<div>
        			<a href='".$base_url.$member_res1['username']."' title='".$member_res1['username']."' target='_blank' style='text-decoration:none;color:#085D93;'>".$member_res1['username']." wants to be your friends on quakbox</a>
        		</div>
        		";
if($msg != ''){	
$htmlbody .="<div>Message: ".$msg."</div>";
}
$htmlbody .="<div>".$fcount." friends</div>";

$obj = new QBEMAIL(); 
$mail=$obj->send_email($to,$subject,'',$mailTitle,$htmlbody,'');
//$mail = mail($to, $subject, $htmlbody, $headers); 

?> 
<?php
$_SESSION['err_count']=0;
header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
}
else
{
header('Location: ' . $_SERVER['HTTP_REFERER'].'?err=you have already sent or have request');
exit;
}
?>