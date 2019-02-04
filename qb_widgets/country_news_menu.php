<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_misc.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');

class countryMenu
{
	function getCountryMenu($country_code,$countryID,$countryTitle)
	{
        global $lang;

        include($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php');
		$countrymenu  ='<div class="bg-primary clearfix" style="padding: 5px;">Activities</div>';
		$countrymenu .='<div>';
//		$countrymenu .='<div> <a class="cMenu" href="'.SITE_URL.'/country_groups.php?country='.$country_code.'"><img src="/images/country-menu/groups.png"> <span style="margin-left:5px;">'.$lang['Groups'].'</span></a> </div>';
//		$countrymenu .='<div> <a class="cMenu" href="'.SITE_URL.'/photo_gall/photogall.php?country_id='.$countryID.'"><img src="/images/country-menu/photos.png"> <span style="margin-left:5px;">'.$lang['Photos'].'</span></a> </div>';
//		$countrymenu .='<div> <a class="cMenu" href="'.SITE_URL.'/country_videos.php?country_id='.$countryTitle.'"><i class="fa fa-video-camera"></i><span style="margin-left:5px;">'.$lang['Videos'].'</span></a> </div>';
//		$countrymenu .='<div> <a class="cMenu" href="'.SITE_URL.'/country_event.php?country='.$countryID.'"><i class="fa fa-calendar "></i><span style="margin-left:5px;">'.$lang['Events'].'</span></a> </div>';
//		$countrymenu .='<div> <a class="cMenu" href="'.SITE_URL.'/invite_friends_for_country.php?country='.$country_code.'"><i class="fa fa-envelope "></i><span style="margin-left:5px;">'.$lang['Invite Friends'].'</span></a> </div>';
//		$countrymenu .='<div> <a class="cMenu" href="'.SITE_URL.'/add_news.php?country='.$country_code.'"><i class="fa fa-bullhorn "></i><span style="margin-left:5px;"> Add News</span></a> </div>';
//		$countrymenu .='<div> <a class="cMenu" href="'.SITE_URL.'/add_country_member.php?country=='.$country_code.'"><i class="fa fa-plus-square "></i><span style="margin-left:5px;">'.$lang['Add Country member'].'</span></a> </div>';
//		$countrymenu .='<div> <a class="cMenu" href="'.SITE_URL.'/create_country.php"><i class="fa fa-star"></i><span style="margin-left:5px;">'.$lang['Add Favourite Country'].'</span></a> </div>';

		$countrymenu .='<div> <a class="cMenu" href="'.SITE_URL.'/country_groups.php?country='.$country_code.'"><i class="fa fa-group "></i><span style="margin-left:5px;">'.$lang['Groups'].'</span></a> </div>';
		$countrymenu .='<div> <a class="cMenu" href="'.SITE_URL.'/photo_gall/photogall.php?country_id='.$countryID.'"><i class="fa fa-photo"></i><span style="margin-left:5px;">'.$lang['Photos'].'</span></a> </div>';
		$countrymenu .='<div> <a class="cMenu" href="'.SITE_URL.'/country_videos.php?country_id='.$countryTitle.'"><i class="fa fa-video-camera"></i><span style="margin-left:5px;">'.$lang['Videos'].'</span></a> </div>';
		$countrymenu .='<div> <a class="cMenu" href="'.SITE_URL.'/country_event.php?country='.$countryID.'"><i class="fa fa-calendar "></i><span style="margin-left:5px;">'.$lang['Events'].'</span></a> </div>';
		$countrymenu .='<div> <a class="cMenu" href="'.SITE_URL.'/invite_friends_for_country.php?country='.$country_code.'"><i class="fa fa-envelope "></i><span style="margin-left:5px;">'.$lang['Invite Friends'].'</span></a> </div>';
		$countrymenu .='<div> <a class="cMenu" href="'.SITE_URL.'/add_news.php?country='.$country_code.'"><i class="fa fa-bullhorn "></i><span style="margin-left:5px;"> Add News</span></a> </div>';
		$countrymenu .='<div> <a class="cMenu" href="'.SITE_URL.'/add_country_member.php?country=='.$country_code.'"><i class="fa fa-plus-square "></i><span style="margin-left:5px;">'.$lang['Add Country member'].'</span></a> </div>';
		$countrymenu .='<div> <a class="cMenu" href="'.SITE_URL.'/create_country.php"><i class="fa fa-star"></i><span style="margin-left:5px;">'.$lang['Add Favourite Country'].'</span></a> </div>';
		$countrymenu .='<div class="clearfix"></div>';
		$countrymenu .='</div>';
		
		return $countrymenu;
	}
	function getCountryFans($country_code,$countryID,$countryTitle){
		include($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php');
		$miscObjCountryMenu=new misc();
		$objMemberCountryFans = new member1(); 
		$logged_in_member_id_CountryFans = $_SESSION['SESS_MEMBER_ID'];
		$countryFansResult=$miscObjCountryMenu->getRandom3Countryfans($country_code);
		$countryFans ='';
		$countryFans .='<div class="bg-primary clearfix" style="padding: 5px;margin-top:2px;">'.$lang['FANS'].'</div>';
		$countryFans .='<div style="text-align: center;">';
		foreach($countryFansResult as $valueCountryFans){
			$countryFanMemberID=$valueCountryFans['member_id'];			 
			$countryFanMemberResult=$objMemberCountryFans->select_member_byID($countryFanMemberID);
			$countryFanMemberProfileLogo=$objMemberCountryFans->select_member_meta_value($countryFanMemberID,'current_profile_image');
			$countryFanUsername='';
			while($clMember = mysqli_fetch_array($countryFanMemberResult))
			{				
				$countryFanUsername=$clMember['username'];	
			}
			if($countryFanMemberProfileLogo){			
					$countryFanMemberProfileLogo=SITE_URL.'/'.$countryFanMemberProfileLogo;	
			}
			else{
				$countryFanMemberProfileLogo=SITE_URL.'/images/default.png';
			}
			$countryFanProfileURL=SITE_URL.'/'.$countryFanUsername;
			if($countryFanMemberID==$logged_in_member_id_CountryFans){
				$countryFanProfileURL=SITE_URL.'/i/'.$countryFanUsername;
			}
			$countryFans .='<a style="margin: 2px;display:inline-block" title="'.$countryFanUsername.'" href="'.$countryFanProfileURL.'"><img src="'.$countryFanMemberProfileLogo.'" style="border:1px solid #ccc; padding:2px;width: 50px; height: 50px;"/></a>';	

			
		}
		$countryFans .='<div class="clearfix"></div>';
             	$countryFans .='</div>';
		return $countryFans;
	}
	function getCountryPeoples($country_code,$countryID,$countryTitle){
		include($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php');
		$miscObjCountryMenu=new misc();
		$objMemberCountryPeoples = new member1(); 
		$logged_in_member_id_CountryPeople = $_SESSION['SESS_MEMBER_ID'];
		$countryPeoplesResult=$miscObjCountryMenu->getRandom3CountryPeoples($countryID);
		$countryPeoples ='';
		$countryPeoples .='<div class="bg-primary clearfix" style="padding: 5px;margin-top:2px;">'.$lang['People of'].' '.$countryTitle.'</div>';
		$countryPeoples .='<div style="text-align: center;">';
		foreach($countryPeoplesResult as $valueCountryPeople){
			$countryPeopleMemberID=$valueCountryPeople['member_id'];			 
			$countryPeopleUsername=$valueCountryPeople['username'];
			$countryPeopleDisplayName=$valueCountryPeople['displayname'];
			$countryPeopleMemberProfileLogo=$objMemberCountryPeoples->select_member_meta_value($countryPeopleMemberID,'current_profile_image');			
			
			if($countryPeopleMemberProfileLogo){			
					$countryPeopleMemberProfileLogo=SITE_URL.'/'.$countryPeopleMemberProfileLogo;	
			}
			else{
				$countryPeopleMemberProfileLogo=SITE_URL.'/images/default.png';
			}
			$countryPeopleProfileURL=SITE_URL.'/'.$countryPeopleUsername;
			if($countryPeopleMemberID==$logged_in_member_id_CountryPeople){
				$countryPeopleProfileURL=SITE_URL.'/i/'.$countryPeopleUsername;
			}
			$countryPeoples .='<a style="margin: 2px;display:inline-block" title="'.$countryPeopleDisplayName.'" href="'.$countryPeopleProfileURL.'"><img src="'.$countryPeopleMemberProfileLogo.'" style="border:1px solid #ccc; padding:2px;width: 50px; height: 50px;"/></a>';	

			
		}
		$countryPeoples .='<div class="clearfix"></div>';
             	$countryPeoples .='</div>';
		return $countryPeoples ;
	}




}

?>