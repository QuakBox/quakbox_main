<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_misc.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_security.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');

class friendsRequestNotificationExtraWidget{

	function getPanel($memberID){
		require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php');
		$objMisc = new misc(); 
		$objMember= new member1(); 
		$currentMemberResult=$objMember->select_member_byID($memberID);
		$currentUsername='';		
		while($clMember = mysqli_fetch_array($currentMemberResult))
		{			
			$currentUsername=$clMember['username'];	
		}
		$totalFriendsRequestResult=$objMisc->getFriendsRequest($memberID,5);		
		$countofFriendsRequest=count($totalFriendsRequestResult);		
		$innerHtml='';		
		$innerHtml .='<div class="bg-primary display_box clearfix" style="margin-top:10px; padding: 5px;z-index:99999;background-color: #C0C0C0;background-image: none;background-repeat: repeat-x;">';
        	$innerHtml .='<div class="pull-right" ><a href="'.SITE_URL.'/find_friend.php">';
        	if(isset($_SESSION['lang'])){$innerHtml .=nl2br($lang['Search People']);}else{$innerHtml .='Find Friend';}
        	$innerHtml .='</a></div>';
		$innerHtml .='<div class="pull-left" >';
		if(isset($_SESSION['lang'])){$innerHtml .=nl2br($lang['friend request']);}else{ $innerHtml .='Friend Requests';}
		$innerHtml .='</div>';
		$innerHtml .='<div class="clearfix"></div>';
		$innerHtml .='</div>';        	
		$innerHtml .='<div style="padding: 5px 0;border-bottom:1px solid #ccc;border-left:1px solid #ddd;border-right:1px solid #ddd;">';
        	if($countofFriendsRequest){
			foreach($totalFriendsRequestResult as $valueFriendsRequest){
				$requestedmemberID=$valueFriendsRequest['member_id'];
				$requestedmemberUsername=$valueFriendsRequest['username'];
				$requestedmemberDisplayname=$valueFriendsRequest['displayname'];
				$requestedmemberProfileLogo=$objMember->select_member_meta_value($requestedmemberID,'current_profile_image');
				if($requestedmemberProfileLogo){			
						$requestedmemberProfileLogo=SITE_URL.'/'.$requestedmemberProfileLogo;	
				}
				else{
					$requestedmemberProfileLogo=SITE_URL.'/images/default.png';
				}
				
				$innerHtml .='<div class="clearfix">';
				$innerHtml .='<div class="display_box">';				
				$innerHtml .='<div class="pull-left">';
				$innerHtml .='<a title="'.$requestedmemberDisplayname.'" href="'.SITE_URL.'/'.$requestedmemberUsername.'">';				
				$innerHtml .='<img style="width:50px; height:50px; float:left; margin-right:2px;border:1px solid #ccc;padding:2px;margin-bottom:2px;" src="'.$requestedmemberProfileLogo.'">';
				$innerHtml .='</a>';
				$innerHtml .='</div>';
				$innerHtml .='<div class="pull-left">';
				$innerHtml .='<a title="'.$requestedmemberDisplayname.'" href="'.SITE_URL.'/'.$requestedmemberUsername.'">';
				$innerHtml .='<div style="text-align: left; padding: 5px;" class="name1">'.$requestedmemberDisplayname.'</div>';
				$innerHtml .='</a><div class="clearfix"></div>';				
				$innerHtml .='<a style="margin-right: 5px;margin-left: 5px; cursor:pointer;text-decoration:none;" id="'.$requestedmemberID.'" class="accept_request pull-left"><div style="display: block; font-size: 20px;" class="fa fa-check-square" id="friendsRequest" data-toggle="tooltip" data-original-title="Confirm" data-placement="bottom"></div></a>';
        			$innerHtml .='<a style="margin-right: 5px;cursor:pointer;text-decoration:none;" id="'. $requestedmemberID.'" class="cancel_request pull-left"> <div style="display: block; font-size: 20px;" class="fa fa-remove" id="friendsRequest" data-toggle="tooltip" data-original-title="Not now" data-placement="bottom"></div></a>';
				$innerHtml .='<div class="clearfix"></div></div><div class="clearfix"></div></div></a></div>';
			}
		}
		else{
			$innerHtml .='<div class="clearfix">No new Request</div>';
		}
		$innerHtml .='<div class="clearfix"></div>';
		$innerHtml .='<div class="display_box">';
			$innerHtml .='<a href="'.SITE_URL.'/friends/'.$currentUsername.'"> Show All Friends</a>';
		$innerHtml .='</div>';
		$innerHtml .='</div>';
		return $innerHtml;		
						
	}
}


?>