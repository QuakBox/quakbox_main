<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');

class myProfileMenu
{
	function getMenu($memberID,$username)
	{
		global $lang;

		include($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php');
		$logged_in_member_id_ProfileMenu= $_SESSION['SESS_MEMBER_ID'];
		$profileMenu  ='<div class="panel panel-primary">';
		$profileMenu .='<div class="panel-heading" style="padding-top: 1px; padding-bottom: 1px;">Activities</div>';
		$profileMenu .='<div class="panel-body">';	
		$profileMenu .='<div style="padding-bottom:3px; padding-top:3px;"> <a class="cMenu" href="'.SITE_URL.'/friends/'.$username.'"><img src="'.SITE_URL.'/images/ImageFriends3.png"/><span style="margin-left:5px;">'.$lang['Friends'].'</span></a> </div>';	
                $profileMenu .='<div style="padding-bottom:3px;"> <a class="cMenu" href="'.SITE_URL.'/profile.php"><img src="'.SITE_URL.'/images/ImageMyProfile3.png"/><span style="margin-left:5px;">'.'My Profile'.'</span></a> </div>';	
		$profileMenu .='<div style="padding-bottom:3px;"> <a class="cMenu" href="'.SITE_URL.'/groups/'.$username.'"><img src="'.SITE_URL.'/images/ImageMyGroups3.png" style="width:16px;hieght:16px;"/><span style="margin-left:5px;">'.$lang['My Groups'].'</span></a> </div>';
		$profileMenu .='<div style="padding-bottom:3px;"> <a class="cMenu" href="'.SITE_URL.'/photos/'.$username.'"><img src="'.SITE_URL.'/images/ImageMyPhotos3.png"/><span style="margin-left:5px;">'.$lang['My Photos'].'</span></a> </div>';
		$profileMenu .='<div style="padding-bottom:3px;"> <a class="cMenu" href="'.SITE_URL.'/myvideos.php"><img src="'.SITE_URL.'/images/ImageMyVideos3.png"/><span style="margin-left:5px;">'.$lang['My Videos'].'</span></a> </div>';
		$profileMenu .='<div style="padding-bottom:3px;"> <a class="cMenu" href="'.SITE_URL.'/create_event.php"><img src="'.SITE_URL.'/images/ImageMyEvents3.png"/><span style="margin-left:5px;">'.$lang['My Events'].'</span></a> </div>';
		$profileMenu .='<div style="padding-bottom:3px;"> <a class="cMenu" href="'.SITE_URL.'/invite_friends.php"><img src="'.SITE_URL.'/images/ImageInviteFriends3.png"/><span style="margin-left:5px;">'.$lang['Invite Friends'].'</span></a> </div>';
		$profileMenu .='<div style="padding-bottom:3px;"> <a class="cMenu" href="'.SITE_URL.'/create_country.php"><img src="'.SITE_URL.'/images/ImageAddFavoriteCountries3.png"/><span style="margin-left:5px;">'.$lang['Add Favourite Country'].'</span></a> </div>';			
		$profileMenu .='<div class="clearfix"></div>';
		$profileMenu .='</div>';
		$profileMenu .='</div>';
		return $profileMenu ;	
  
   
	}
	

}

?>