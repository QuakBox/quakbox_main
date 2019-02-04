<?php
ob_start();
require($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php');	
include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
require($_SERVER['DOCUMENT_ROOT'].'/common/qb_email.php');
	
	
		//Sanitize the POST values
	$session_member_id = $_SESSION['SESS_MEMBER_ID'];
	$member_id = mysqli_real_escape_string($con, f($_POST['member_id'],'escapeAll'));
	$invite_member_id = mysqli_real_escape_string($con, f($_POST['event_member_id'],'escapeAll'));
	$event_id = mysqli_real_escape_string($con, f($_POST['event_id'],'escapeAll'));	
	$invite_frinds = mysqli_real_escape_string($con, f($_POST['invite_frinds'],'escapeAll'));	
	$time = time();
	
	$esql = mysqli_query($con, "SELECT event_name FROM event WHERE id = '$event_id'");
	$eres = mysqli_fetch_array($esql);
	$event_name = $eres['event_name'];
	
		
	//Insert query
	//$gmquery = "select * from event_members where member_id = '$invite_member_id' and event_id = '$event_id'";
//echo $gmquery;
	//$gmsql = mysqli_query($con, $gmquery);
	
	$url = 'event_view.php?id='.$event_id.'';
		
	//if(mysqli_num_rows($gmsql)>0)
	//{
		$isql = "INSERT INTO event_members (member_id, event_id,status) VALUES('$invite_member_id','$event_id',0)";
		mysqli_query($con, $isql);
		
		$nquery = "INSERT INTO notifications (sender_id, received_id, type_of_notifications,title, href, is_unread, date_created)
				VALUES('$session_member_id','$invite_member_id',34,'wants you to join $event_name event in QuackBox','$url',0,'$time')";
	    mysqli_query($con, $nquery);
	//}
	
	$member = mysqli_query($con, "select * from members where member_id='$invite_member_id' order by member_id desc LIMIT 1");
	$member_res = mysqli_fetch_array($member);
	
	$msql = mysqli_query($con, "select * from members where member_id = '$session_member_id'");
	$mres = mysqli_fetch_array($msql);
	
	//mail function
$to = $member_res['email_id'];
$subject = "".ucfirst($mres['username'])." wants you to join qbdev quakbox event";
$mailTitle="You have a new event request";
$htmlbody = " 
        	<div style='width:100px;float:left;border:1px solid #ddd;'>
        		<a href='".$base_url.$mres['username']."' title='".$mres['username']."' target='_blank' style='text-decoration:none;'><img style='width:100%;' alt='".$mres['username']."' title='".$mres['username']."' src='".$base_url.$mres['profImage']."' /></a>
        	</div> 
        	<div style='float:left;padding:15px;'>
        		<div>
        			<a href='".$base_url.$mres['username']."' title='".$mres['username']."' target='_blank' style='text-decoration:none;color:#085D93;'>".$mres['username']." wants you to join qbdev quakbox event</a>
        		</div>
        		";
$obj = new QBEMAIL(); 
$mail=$obj->send_email($to,$subject,'',$mailTitle,$htmlbody,'');

	//Check whether the query was successful or not
		
	header("location:".$base_url."event_view.php?id=".$event_id."");
		//exit();		
	
?>