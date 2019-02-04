<?php
ob_start();
require($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php');
	//Include database connection details
include($_SERVER['DOCUMENT_ROOT'].'/config.php');
	//Include mail template function
require($_SERVER['DOCUMENT_ROOT'].'/common/qb_email.php');
	//Sanitize the POST values
	$session_member_id = $_SESSION['SESS_MEMBER_ID'];
	$member_id = mysqli_real_escape_string($con, f($_POST['member_id'],'escapeAll'));
	$group_id = mysqli_real_escape_string($con, f($_POST['group_id'],'escapeAll'));	
	$invite_frinds = mysqli_real_escape_string($con, f($_POST['invite_frinds'],'escapeAll'));
	$event_member_id = mysqli_real_escape_string($con, f($_POST['event_member_id'],'escapeAll'));	
	$time = time();
	$url = 'groups_wall.php?group_id='.$group_id.'';
	
	$sql1 = mysqli_query($con, "select * from members where member_id='$event_member_id'");
	$res1 = mysqli_fetch_array($sql1);
		
	//select group name 
	$gsql = mysqli_query($con, "SELECT name,avatar from groups where id = '$group_id'") or die(mysqli_error($con));
	$gres = mysqli_fetch_array($gsql);
	$group_name = $gres['name'];
	
	$msql = mysqli_query($con, "select * from members where member_id = '$member_id'");
	$mres = mysqli_fetch_array($msql);
			
	//Insert query
$gmquery = "select * from groups_members where member_id = '$event_member_id' and groupid = '$group_id'";
$gmsql = mysqli_query($con, $gmquery);
	
if(mysqli_num_rows($gmsql) == 0)
{
		$sql = "insert into groups_invite(groupid,creator,userid) values('$group_id','$member_id','$event_member_id')";
		$result = mysqli_query($con, $sql) or die(mysqli_error($con));
				
		$isql = "INSERT INTO groups_members (member_id, groupid,approved,permissions) VALUES('$event_member_id','$group_id',1,0)";
		mysqli_query($con, $isql);
		
		$nquery = "INSERT INTO notifications (sender_id, received_id, type_of_notifications,title, href, is_unread, date_created)
				VALUES('$session_member_id','$event_member_id',33,' Invited you to join group $group_name','$url',0,'$time')";
		mysqli_query($con, $nquery);
}
	
	/************************************ mail function ********************************/

$to = $res1['email_id'];
$subject = "".ucfirst($mres['username'])." invited you to join group ".$group_name."";
$mailTitle="";
$htmlbody = " 
        	<div style='width:100px;float:left;border:1px solid #ddd;'>
        		<a href='".$base_url.$mres['username']."' title='".$mres['username']."' target='_blank' style='text-decoration:none;'><img style='width:100%;' alt='".$mres['username']."' title='".$mres['username']."' src='".$base_url.$mres['profImage']."' /></a>
        	</div> 
        	<div style='float:left;padding:15px;'>
        		<div>
        			<a href='".$base_url.$mres['username']."' title='".$mres['username']."' target='_blank' style='text-decoration:none;color:#085D93;'>".$mres['username']." invited you to join group ".$group_name."</a>
        		</div>
        		";
if($gres['avatar']!= ''){	
$htmlbody .="<div><a href=".$base_url.$url."><img style='border:0' height='50' width='50' src='".$base_url.$gres['avatar']."' /></a></div>";
}

$obj = new QBEMAIL(); 
$mail=$obj->send_email($to,$subject,'',$mailTitle,$htmlbody,'');


	/*********************************** end mail function *****************************/
	
		
header("location: ".$base_url.$url);		
exit();	
?>