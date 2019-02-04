<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_notification_class.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_security.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');


class viewNotificationExtraWidget{

	function getPanel($memberID){
		require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php');
		include($_SERVER['DOCUMENT_ROOT'].'/includes/time_stamp.php');
		$objNotification = new notification(); 
		$objMember= new member1(); 		
		$totalNotificationResult=$objNotification->getNotification($memberID,5);		
		$countofNotification=count($totalNotificationResult);		
		$innerHtml='';		
		$innerHtml .='<div class="panel panel-info" style="padding-right: 10px;">';               	
//		$innerHtml .='<div class="panel-heading" style="font-size:11px;">';
		if(isset($_SESSION['lang'])){$innerHtml .=nl2br($lang['Notifications']);}else{ $innerHtml .='Notifications';}
	//	$innerHtml .='</div>';
		$innerHtml .='<div></div>';
		$innerHtml .='</div>';        	
        	if($countofNotification){
        		foreach($totalNotificationResult as $valueNotification){
        		$notificationSenderID=$valueNotification['sender_id'];
			$notificationSenderUsername=$valueNotification['username'];
			$notificationDisplayname=$valueNotification['displayname'];
			
			$notificationDate=time_stamp_vj($valueNotification['date_created']);
			$notificationType=$valueNotification['type_of_notifications'];
			//$notificationText='';
			
			$notificationSenderProfileLogo=$objMember->select_member_meta_value($notificationSenderID,'current_profile_image');
			if($notificationSenderProfileLogo){			
						$notificationSenderProfileLogo=SITE_URL.'/'.$notificationSenderProfileLogo;	
			}
			else
			{
				$notificationSenderProfileLogo=SITE_URL.'/images/default.png';
			}
			$notificationHref=$valueNotification['href'];			
								
								 	 	    
			$notificationText=$valueNotification['title'];
			
					
	//Edited by Mushira Ahmad--Check for different types of notifications
	if ($valueNotification['type_of_notifications']==30)
    		$append_notid="?notid=".$valueNotification['id'];
    	else
	if ($valueNotification['type_of_notifications']==37)
    		$append_notid="?notid=".$valueNotification['id'];
    	else
    	        $append_notid="&notid=".$valueNotification['id'];
    	//End of handling different types of notifications
    	
			
			$innerHtml .='<div class="clearfix"><a href="'.SITE_URL.'/'.$notificationHref.$append_notid.'">';
			$innerHtml .='<div class="display_box">';
			$innerHtml .='<div class="pull-left"><img src="'.$notificationSenderProfileLogo.'" style="width:50px; height:50px; float:left; margin-right:2px;border:1px solid #ccc;padding:2px;margin-bottom:2px;" /></div>';
			$innerHtml .='<div class="pull-left">';
			$innerHtml .='<div class="name1" style="padding: 5px;">'.$notificationDisplayname.' '.$notificationText.'</div>';
			$innerHtml .='<div class="name2" style="padding: 0 5px;text-align:left;">'.$notificationDate.'</div>';
			$innerHtml .='</div>';
			$innerHtml .='<div class="clearfix"></div>';			
			$innerHtml .='</div></a>'; 
			$innerHtml .='<div class="clearfix"></div>';
			$innerHtml .='</div>';     	
		}
		}
		else
		{
			$innerHtml .='<div class="clearfix">No notifications</div>';
		}
		$innerHtml .='<div class="clearfix"></div>';
		$innerHtml .='<div class="display_box">';
		$innerHtml .='<a href="'.SITE_URL.'/notifications.php"> See All Notifications</a>';
		$innerHtml .='</div>';			
		return $innerHtml;		
			
	}
	
	function getPanel2($memberID){
		/*require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php');
		include($_SERVER['DOCUMENT_ROOT'].'/includes/time_stamp.php');*/
		$objNotification = new notification(); 
		$objMember= new member1(); 		
		$totalNotificationResult=$objNotification->getNotification($memberID,5);		
		$countofNotification=count($totalNotificationResult);		
		$innerHtml='';		
		$innerHtml .='<div class="panel panel-primary">';               	
	//	$innerHtml .='<div class="panel-heading">';
		if(isset($_SESSION['lang'])){$innerHtml .=nl2br($lang['Notifications']);}else{ $innerHtml .='Notifications';}
	//	$innerHtml .='</div>';
		
		$innerHtml .='<div class="panel-body">';  
		       	
        	if($countofNotification){
        		foreach($totalNotificationResult as $valueNotification){
        		$notificationSenderID=$valueNotification['sender_id'];
			$notificationSenderUsername=$valueNotification['username'];
			$notificationDisplayname=$valueNotification['displayname'];
			
			$notificationDate=time_stamp_vj($valueNotification['date_created']);
			$notificationType=$valueNotification['type_of_notifications'];
			$notificationText='';
			
			$notificationSenderProfileLogo=$objMember->select_member_meta_value($notificationSenderID,'current_profile_image');
			if($notificationSenderProfileLogo){			
						$notificationSenderProfileLogo=SITE_URL.'/'.$notificationSenderProfileLogo;	
			}
			else
			{
				$notificationSenderProfileLogo=SITE_URL.'/images/default.png';
			}
			$notificationHref=$valueNotification['href'];			
								
								 	 	    
			$notificationText=$valueNotification['title'];
			
			//Edited by Mushira Ahmad--Check for different types of notifications
	if ($valueNotification['type_of_notifications']==30)
    		$append_notid="?notid=".$valueNotification['id'];
    	else
	if ($valueNotification['type_of_notifications']==37)
    		$append_notid="?notid=".$valueNotification['id'];
    	else
    	        $append_notid="&notid=".$valueNotification['id'];
    	//End of handling different types of notifications
    	
	
			//$innerHtml .='<div class="clearfix"><a   href="'.SITE_URL.'/'.$notificationHref.'" title="'.$notificationText.'">';
			$innerHtml .='<div class="clearfix"><a href="'.SITE_URL.'/'.$notificationHref.$append_notid.'">';
			$innerHtml .='<div class="display_box">';
			$innerHtml .='<div class="pull-left"><img src="'.$notificationSenderProfileLogo.'" style="width:50px; height:50px; float:left; margin-right:2px;border:1px solid #ccc;padding:2px;margin-bottom:2px;" /></div>';
			$innerHtml .='<div class="" style="font-size:11px;">';
			$innerHtml .='<div class="name1" style="padding: 5px;">'.$notificationDisplayname.' '.$notificationText.'</div>';
			$innerHtml .='<div class="name2" style="padding: 0 5px;text-align:left;">'.$notificationDate.'</div>';
			$innerHtml .='</div>';
			$innerHtml .='<div class="clearfix"></div>';			
			$innerHtml .='</div></a>'; 
			$innerHtml .='<div class="clearfix"></div>';
			$innerHtml .='</div>';  
			  	
		}
		}
		else
		{
			$innerHtml .='<div class="clearfix">No notifications</div>';
		}
		$innerHtml .='<div class="clearfix"></div>';
		$innerHtml .='<div class="display_box">';
		$innerHtml .='<a href="'.SITE_URL.'/notifications.php"> See All Notifications</a>';
		$innerHtml .='</div>';	
		$innerHtml .='</div>';
		$innerHtml .='</div>'; 	
		
		
		return $innerHtml;		
			
	}

}
?>