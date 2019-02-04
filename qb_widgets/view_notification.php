<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_notification_class.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_security.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');

class viewNotificationWidget{

	function getPanel($memberID){
		require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php');
		$objNotification = new notification(); 	
			
		$countUnreadResult=$objNotification->getCountOfUnreadNotification($memberID);
		$countUnread=0;		
		foreach($countUnreadResult as $valueCountUnreadResult){
			 $countUnread=$valueCountUnreadResult['count'];
		}
		$innerHtml='';
		$innerHtml .='<div style=" display: block; font-size: 24px;" class="fa fa-bell" id="viewNotification" data-toggle="tooltip" data-original-title="Notifications" data-placement="bottom"></div>';
		if($countUnread>0){
			$innerHtml .='<div class="alert" id="notification_count_wrapper"><span id="notification_count_value" class="laers">'.$countUnread.'</span></div>';
		}			
		print $innerHtml;		
						
	}
}

?>