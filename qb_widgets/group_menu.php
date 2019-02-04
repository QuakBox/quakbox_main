<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_groups.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');

class groupMenu
{
	function getGroupMenu($groupID,$groupOwner)
	{
		
		include($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php');
		$logged_in_member_id_GroupMenu = $_SESSION['SESS_MEMBER_ID'];
		$groupMenu  ='<div class="clearfix" style="background:#C0C0C0;color:#fff;padding: 5px;text-alin:center;">Activities</div>';
		$groupMenu .='<div>';
		if($groupOwner==$logged_in_member_id_GroupMenu){
		$groupMenu .='<div> <a class="cMenu" href="'.SITE_URL.'/edit_groups.php?group_id='.$groupID.'"><i class="fa fa-pencil-square "></i><span style="margin-left:5px;">'.$lang['Edit group'].'</span></a> </div>';
		}
		$groupMenu .='<div> <a class="cMenu" href="'.SITE_URL.'/group_photos.php?group_id='.$groupID.'"><i class="fa fa-photo"></i><span style="margin-left:5px;">'.$lang['Photos'].'</span></a> </div>';
		$groupMenu .='<div> <a class="cMenu" href="'.SITE_URL.'/group_videos.php?group_id='.$groupID.'"><i class="fa fa-video-camera"></i><span style="margin-left:5px;">'.$lang['Videos'].'</span></a> </div>';
		$groupMenu .='<div> <a class="cMenu" href="'.SITE_URL.'/group_event.php?group_id='.$groupID.'"><i class="fa fa-calendar "></i><span style="margin-left:5px;">'.$lang['Events'].'</span></a> </div>';
		$groupMenu .='<div> <a class="cMenu" href="'.SITE_URL.'/invite_friends_for_group.php"><i class="fa fa-envelope "></i><span style="margin-left:5px;">'.$lang['Invite Friends'].'</span></a> </div>';		
		$groupMenu .='<div> <a class="cMenu" href="'.SITE_URL.'/invite_group_friends.php?group_id='.$groupID.'"><i class="fa fa-plus-square "></i><span style="margin-left:5px;">'.$lang['Add member'].'</span></a> </div>';
		$groupMenu .='<div class="clearfix"></div>';
		$groupMenu .='</div>';
		
		return $groupMenu;
	}
	function getGroupMembers($groupID,$limit){
		include($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php');
		$groupObjGroupMenu=new groups();
		$objMemberGroupMembers = new member1(); 
		$logged_in_member_id_groupMember = $_SESSION['SESS_MEMBER_ID'];
		$groupMembersResult=$groupObjGroupMenu->getGroupMembersByID($groupID,$limit);
		$groupMembers  ='';
		$groupMembers .='<div class="clearfix" style="background:#C0C0C0;color:#fff;padding: 5px;text-alin:center;margin-top:5px;">'.$lang['GROUP MEMBERS'].'</div>';
		$groupMembers .='<div style="text-align: center;">';
		foreach($groupMembersResult as $valueGroupMember){
			$groupMemberID=$valueGroupMember['member_id'];			 
			$groupMemberResult=$objMemberGroupMembers->select_member_byID($groupMemberID);
			$groupMemberProfileLogo=$objMemberGroupMembers->select_member_meta_value($groupMemberID,'current_profile_image');
			$groupMemberUsername='';
			while($clMember = mysqli_fetch_array($groupMemberResult))
			{				
				$groupMemberUsername=$clMember['username'];	
			}
			if($groupMemberProfileLogo){			
					$groupMemberProfileLogo=SITE_URL.'/'.$groupMemberProfileLogo;	
			}
			else{
				$groupMemberProfileLogo=SITE_URL.'/images/default.png';
			}
			$groupMemberProfileURL=SITE_URL.'/'.$groupMemberUsername;
			if($groupMemberID==$logged_in_member_id_groupMember){
				$groupMemberProfileURL=SITE_URL.'/i/'.$groupMemberUsername;
			}
			$groupMembers .='<a style="margin: 2px;display:inline-block" title="'.$groupMemberUsername.'" href="'.$groupMemberProfileURL.'"><img src="'.$groupMemberProfileLogo.'" style="border:1px solid #ccc; padding:2px;width: 50px; height: 50px;"/></a>';	

			
		}
		$groupMembers .='<div><a href="'.SITE_URL.'/group_members.php?group_id='.$groupID.'" style="float:right;">'.$lang['Show All'].'</a></div>';
		$groupMembers .='<div class="clearfix"></div>';
             	$groupMembers .='</div>';
		return $groupMembers;
	}
	




}

?>