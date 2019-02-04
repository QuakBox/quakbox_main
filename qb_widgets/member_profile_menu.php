<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');

class memberProfileMenu
{
	function getMenu($memberID,$username)
	{
		
		include($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php');
		$logged_in_member_id_ProfileMenu= $_SESSION['SESS_MEMBER_ID'];
		$profileMenu  ='<div class="clearfix" style="background:#C0C0C0;color:#fff;padding: 5px;text-alin:center;">Activities</div>';
		$profileMenu .='<div class="inline-menu">';
		$profileMenu .='<div class="inline-menu-item"> <a class="cMenu" href="'.SITE_URL.'/videos/'.$username.'"><img src="'.SITE_URL.'/images/youtube.png" title="Profile Videos" /></a></div>';
		$profileMenu .='<div class="inline-menu-item"> <a class="cMenu" href="'.SITE_URL.'/photos/'.$username.'"><img src="'.SITE_URL.'/images/photo-camera.png" title="Photos" /></a> </div>';
		$profileMenu .='<div class="inline-menu-item"> <a class="cMenu" href="'.SITE_URL.'/user/'.$username.'"><img src="'.SITE_URL.'/images/videos-icon.png" title="Videos" /></a> </div>';
		$profileMenu .='<div class="inline-menu-item"> <a class="cMenu" href="'.SITE_URL.'/write_message.php?id='.$username.'"><img src="'.SITE_URL.'/images/chat.png" title="Write a Message" /></div>';
		$profileMenu .='<div class="inline-menu-item"> <a class="cMenu" href="'.SITE_URL.'/about/'.$username.'"><img src="'.SITE_URL.'/images/id-card.png" title="View Profile" /></a></div>';

//		$profileMenu .='<div> <a class="cMenu" href="'.SITE_URL.'/videos/'.$username.'"><img src="'.SITE_URL.'/images/ImageMyProfileVideo.png"/><span style="margin-left:5px;">Profile Videos</span></a> </div>';
//		$profileMenu .='<div> <a class="cMenu" href="'.SITE_URL.'/photos/'.$username.'"><img src="'.SITE_URL.'/images/ImagePhotos-2.png"/><span style="margin-left:5px;">'.$lang['Photos'].'</span></a> </div>';
//		$profileMenu .='<div> <a class="cMenu" href="'.SITE_URL.'/user/'.$username.'"><img src="'.SITE_URL.'/images/ImageVideos-1.png"/><span style="margin-left:5px;">'.$lang['Videos'].'</span></a> </div>';
//		$profileMenu .='<div> <a class="cMenu" href="'.SITE_URL.'/write_message.php?id='.$username.'"><img src="'.SITE_URL.'/images/ImageWriteMessage.png"/><span style="margin-left:5px;">'.$lang['write message'].'</span></a> </div>';
//		$profileMenu .='<div> <a class="cMenu" href="'.SITE_URL.'/about/'.$username.'"><img src="'.SITE_URL.'/images/ImageViewProfile2.png"/><span style="margin-left:5px;">'.$lang['view profile'].'</span></a> </div>';
		$profileMenu .='<div class="clearfix"></div>';
		$profileMenu .='</div>';
		
		return $profileMenu ;	
  
   
	}
	

}

?>