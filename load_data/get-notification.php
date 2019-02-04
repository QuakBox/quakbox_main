<?php 
ob_start();
	if(!isset($_SESSION)){
		session_start();
	}
	include_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	if(isset($_SESSION['lang']))

	{
		include($_SERVER['DOCUMENT_ROOT'].'/common.php');
	}
	else

	{
		include($_SERVER['DOCUMENT_ROOT'].'/Languages/en.php');
	}	
		
		include_once($_SERVER['DOCUMENT_ROOT'].'/includes/time_stamp.php');		
		$member_id = $_SESSION['SESS_MEMBER_ID'];
		$output = array();
		
		$nquery = "SELECT n.type_of_notifications, n.href, n.received_id,m.username,m.member_id,
	  			   n.date_created, n.title,n.id,m.profImage 
	  			   FROM notifications n JOIN members m ON m.member_id = n.sender_id 
	  			   AND n.received_id = '$member_id'
				   AND n.is_unread = 0
				   ORDER BY id DESC LIMIT 1";
	  $nsql = mysqli_query($con, $nquery);
	  $ncount[] = mysqli_num_rows($nsql);
	  if(mysqli_num_rows($nsql) > 0)
	  {
		  while($nres = mysqli_fetch_array($nsql))
	      {			  
			  $receiver_id = $nres['received_id'];
			  $rmquery = mysqli_query($con, "SELECT username, member_id FROM members WHERE member_id = '$receiver_id'");
			  $rmres = mysqli_fetch_array($rmquery);
			  if($receiver_id == $member_id) {
			  $id= $nres['id'];
			  if($member_id == $rmres['member_id']) {
				  $usernamer1 = 'Your';
			  } else {
				  $usernamer1 = $rmres['username'];
			  }
			  $usernamer[ = $usernamer1;	
				$member_idr = $rmres['member_id'];
				$type_of_notifications= $nres['type_of_notifications'];				
				$href = $nres['href'];
				$title[ = $nres['title'];
				$username = $nres['username'];
				$cface[ = $nres['profImage'];	
				//$member_id[] = $nres['member_id'];
				$date_created = time_stamp($nres['date_created']);
				
				// update message read flag to=1 
				mysqli_query($con, "update notifications set is_unread='1' where id=".$nres['id']);
				
				$output['id']=$id;
			$output['type']=$type_of_notifications;			
			$output['href']=$href;
			$output['title']=$title;
			$output['usernamer']=$usernamer;
			$output['member_idr']=$member_idr;
			$output['username']=$username;
			$output['cface']=$cface;
			$output['member_id']=$member_id;
			$output['date_created']=$date_created;
			$output['ncount']=$ncount;
		  }
		  }
		  
		  		  
	  }
	  if(count($output)>0) {		//prepare for JSON 
			echo json_encode($output);
		}else
		echo null;
		
?>