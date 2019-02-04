<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_misc.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_security.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');

class friendsRequestNotificationWidget{

	function getPanel($memberID){
		require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php');
		$objMisc = new misc(); 	
			
		$countFriendsRequestUnreadResult=$objMisc->getcountOfUnreadedFriendsRequest($memberID);
		$countFriendsRequestUnread=0;		
		foreach($countFriendsRequestUnreadResult as $valueCountFriendsRequestUnreadResult){
			$countFriendsRequestUnread=$valueCountFriendsRequestUnreadResult['count'];
		}
		$innerHtml='';
		$innerHtml .='<div style="padding: 2px 5px;cursor:pointer;" class="admin"><div style=" display: block; font-size: 24px;" class="fa fa-smile-o" id="friendsRequest" data-toggle="tooltip" data-original-title="Friendship Requests" data-placement="bottom"></div>';
		if($countFriendsRequestUnread>0){
			$innerHtml .='<div class="alert" id="request_count_wrapper"><span id="request_count_value" class="laers">'.$countFriendsRequestUnread.'</span></div>';
		}		
		$innerHtml .='</div>';
		$innerHtml .='<div style="display:none;background-color: white; overflow: hidden; z-index: 4; box-shadow: 0px 0px 5px rgb(153, 153, 153); margin-top: 2px; position: absolute; width: 180px;" id="friendsReqMenu">';				
		$innerHtml .='</div>';		
		print $innerHtml;		
						
	}
}
?>