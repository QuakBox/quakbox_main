<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_message_class.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_security.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');


class viewMessageExtraWidget{

	function getPanel($memberID){
		require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php');
		include($_SERVER['DOCUMENT_ROOT'].'/includes/time_stamp.php');
		$objMessage = new messages(); 
		$objMember= new member1(); 
		$totalMessageResult=$objMessage ->viewUnreadMessages($memberID);		
		$countofMessage=$objMessage->count_unread_messages($memberID);			
		$innerHtml='';		
		$innerHtml .='<div style="padding-right: 10px;" class="display_box clearfix">';               	
		$innerHtml .='<div class="pull-left" style="font-size:11px;">';
		if(isset($_SESSION['lang'])){$innerHtml .=nl2br($lang['messages']);}else{ $innerHtml .='messages';}
		$innerHtml .='</div>';
		$innerHtml .='<div class="clearfix"></div>';
		$innerHtml .='</div>';        	
        	if($countofMessage){
        		foreach($totalMessageResult as $valueMessage){
        		$messageSenderID=$valueMessage['from'];
        		
			$messageSenderProfileLogo=$objMember->select_member_meta_value($messageSenderID,'current_profile_image');
			if($messageSenderProfileLogo){			
						$messageSenderProfileLogo=SITE_URL.'/'.$messageSenderProfileLogo;	
			}
			else
			{
				$messageSenderProfileLogo=SITE_URL.'/images/default.png';
			}

				
			$SenderProfile=$objMember->select_member_byID($messageSenderID);
			while($senderDetails=mysqli_fetch_array($SenderProfile))
			{
				$username=$senderDetails['username'];	
			}
			$messageDate=time_stamp_vj($valueMessage['sent']);
			$message=$valueMessage['message'];
			/*$innerHtml .='<div class="clearfix"><a   href="'.$notificationHref.'" title="'.$notificationText.'">';
			$innerHtml .='<div class="display_box">';
			$innerHtml .='<div class="pull-left"><img src="'.$notificationSenderProfileLogo.'" style="width:50px; height:50px; float:left; margin-right:2px;border:1px solid #ccc;padding:2px;margin-bottom:2px;" /></div>';
			$innerHtml .='<div class="pull-left">';
			$innerHtml .='<div class="name1" style="padding: 5px;">'.$notificationDisplayname.' '.$notificationText.'</div>';
			$innerHtml .='<div class="name2" style="padding: 0 5px;text-align:left;">'.$notificationDate.'</div>';
			$innerHtml .='</div>';
			$innerHtml .='<div class="clearfix"></div>';			
			$innerHtml .='</div></a>'; 
			$innerHtml .='<div class="clearfix"></div>';
			$innerHtml .='</div>';     	*/
			$innerHtml .='<div class="clearfix"><a   href="'.SITE_URL.'/messages.php" title="'.$message.'">';
			$innerHtml .='<div class="display_box">';
			$innerHtml .='<div class="pull-left"><img src="'.$messageSenderProfileLogo.'" style="width:50px; height:50px; float:left; margin-right:2px;border:1px solid #ccc;padding:2px;margin-bottom:2px;" /></div>';
			$innerHtml .='<div class="pull-left">';
			$innerHtml .='<div class="name1" style="padding: 5px;">'.$username.' '.$message.'</div>';
			$innerHtml .='<div class="name2" style="padding: 0 5px;text-align:left;">'.$messageDate.'</div>';
			$innerHtml .='</div>';
			$innerHtml .='<div class="clearfix"></div>';			
			$innerHtml .='</div></a>'; 
			$innerHtml .='<div class="clearfix"></div>';
			$innerHtml .='</div>';     	
		}
		}
		else
		{
			$innerHtml .='<div class="clearfix">No New Message</div>';
		}
		$innerHtml .='<div class="clearfix"></div>';
		$innerHtml .='<div class="display_box">';
		$innerHtml .='<a href="'.SITE_URL.'/messages.php"> View All Messages</a>';
		$innerHtml .='</div>';			
		return $innerHtml;		
			
	}

}
?>