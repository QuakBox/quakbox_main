<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_message_class.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_security.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
 
class viewMessageWidget{

	function getPanel($memberID){
		require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php');
		$objMessage = new messages(); 	
			
		$countUnreadMessage=$objMessage->count_unread_messages($memberID);
		$messageCountUnread=0;		
		foreach($countUnreadMessage as $valueCountUnreadResult){
			$messageCountUnread=$valueCountUnreadResult['count'];
		}
		$innerHtml='';
		$innerHtml .='<div style=" display: block; font-size: 24px;" class="fa fa-bell" id="viewMessage" data-toggle="tooltip" data-original-title="Messages" data-placement="bottom"></div>';
		if($messageCountUnread>0){
			$innerHtml .='<div class="alert" id="message_count_wrapper"><span id="message_count_value" class="laers">'.$messageCountUnread.'</span></div>';
		}			
		print $innerHtml;		
						
	}
}
?>