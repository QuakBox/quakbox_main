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
		//$lan = $country_code . '.php';
		//include_once($_SERVER['DOCUMENT_ROOT'] . '/Languages/' . $lan);
		$countrymenu  ='<div class="clearfix" style="background:#C0C0C0;color:#fff;padding: 5px;">Activities</div>';
		$countrymenu .='<div class="vertical-menu">';
		$countrymenu .='<div> <a class="cMenu" href="'.SITE_URL.'/news_category.php?country='.$countryTitle.'&category=politics"><img src="'.SITE_URL.'/images/country-menu/news.png" /><span>'.'News'.'</span></a> </div>';
        $countrymenu .='<div> <a class="cMenu" href="'.SITE_URL.'/add_news.php?country='.$country_code.'"><img src="'.SITE_URL.'/images/country-menu/add-news.png"/><span> Add News</span></a> </div>';
		$countrymenu .='<div> <a class="cMenu" href="'.SITE_URL.'/country_groups.php?country='.$country_code.'"><img src="'.SITE_URL.'/images/country-menu/groups.png"/><span>'.$lang['Groups'].'</span></a> </div>';
		$countrymenu .='<div> <a class="cMenu" href="'.SITE_URL.'/photo_gall/photogall.php?country_id='.$countryID.'"><img  src="'.SITE_URL.'/images/country-menu/photos.png"/><span>'.$lang['Photos'].'</span></a> </div>';
		$countrymenu .='<div> <a class="cMenu" href="'.SITE_URL.'/country_videos.php?country_id='.$countryTitle.'"><img src="'.SITE_URL.'/images/country-menu/videos.png"/><span>'.$lang['Videos'].'</span></a> </div>';
		$countrymenu .='<div> <a class="cMenu" href="'.SITE_URL.'/country_event.php?country='.$countryID.'"><img  src="'.SITE_URL.'/images/country-menu/events.png"/><span>'.$lang['Events'].'</span></a> </div>';
		$countrymenu .='<div> <a class="cMenu" href="'.SITE_URL.'/invite_friends_for_country.php?country='.$country_code.'"><img src="'.SITE_URL.'/images/country-menu/invite-friends.png"/><span>'.$lang['Invite Friends'].'</span></a> </div>';
		$countrymenu .='<div> <a class="cMenu" href="'.SITE_URL.'/add_country_member.php?country='.$country_code.'"><img src="'.SITE_URL.'/images/country-menu/add-country-member.png"/><span>'.$lang['Add Country member'].'</span></a> </div>';
		$countrymenu .='<div> <a class="cMenu" href="'.SITE_URL.'/create_country.php"><img src="'.SITE_URL.'/images/country-menu/add-favorite-country.png"/><span>'.$lang['Add Favourite Country'].'</span></a> </div>';

		/*$countrymenu .='<div> <a class="cMenu" href="'.SITE_URL.'/news_category.php?country='.$countryTitle.'&category=politics"><img src="'.SITE_URL.'/images/ImageNews.png" style="width:25px; hieght:25px;" /><span style="margin-left:5px;">'.'News'.'</span></a> </div>';
		$countrymenu .='<div> <a class="cMenu" href="'.SITE_URL.'/country_groups.php?country='.$country_code.'"><img src="'.SITE_URL.'/images/ImageGroups.png"/><span style="margin-left:5px;">'.$lang['Groups'].'</span></a> </div>';
		$countrymenu .='<div> <a class="cMenu" href="'.SITE_URL.'/photo_gall/photogall.php?country_id='.$countryID.'"><img  src="'.SITE_URL.'/images/ImagePhotos.png"/><span style="margin-left:5px;">'.$lang['Photos'].'</span></a> </div>';
		$countrymenu .='<div> <a class="cMenu" href="'.SITE_URL.'/country_videos.php?country_id='.$countryTitle.'"><img src="'.SITE_URL.'/images/ImageCVideos.png"/><span style="margin-left:5px;">'.$lang['Videos'].'</span></a> </div>';
		$countrymenu .='<div> <a class="cMenu" href="'.SITE_URL.'/country_event.php?country='.$countryID.'"><img  src="'.SITE_URL.'/images/ImageEvents.png"/><span style="margin-left:5px;">'.$lang['Events'].'</span></a> </div>';
		$countrymenu .='<div> <a class="cMenu" href="'.SITE_URL.'/invite_friends_for_country.php?country='.$country_code.'"><img src="'.SITE_URL.'/images/ImageInviteFriends.png"/><span style="margin-left:5px;">'.$lang['Invite Friends'].'</span></a> </div>';
		$countrymenu .='<div> <a class="cMenu" href="'.SITE_URL.'/add_news.php?country='.$country_code.'"><img src="'.SITE_URL.'/images/ImageAddNews.png"/><span style="margin-left:5px;"> Add News</span></a> </div>';
		$countrymenu .='<div> <a class="cMenu" href="'.SITE_URL.'/add_country_member.php?country='.$country_code.'"><img src="'.SITE_URL.'/images/ImageAddCountryMember.png"/><span style="margin-left:5px;">'.$lang['Add Country member'].'</span></a> </div>';
		$countrymenu .='<div> <a class="cMenu" href="'.SITE_URL.'/create_country.php"><img src="'.SITE_URL.'/images/ImageAddFavCountry.png"/><span style="margin-left:5px;">'.$lang['Add Favourite Country'].'</span></a> </div>';*/
		$countrymenu .='<div class="clearfix"></div>';
		$countrymenu .='</div>';
		
		return $countrymenu;
	}
	function getCountryFans($country_code,$countryID,$countryTitle)
    {
		global $lang;
		include($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php');
		$miscObjCountryMenu=new misc();
		$objMemberCountryFans = new member1(); 
		$logged_in_member_id_CountryFans = $_SESSION['SESS_MEMBER_ID'];
		$countryFansResult=$miscObjCountryMenu->getRandom3Countryfans($country_code);
		$countryFans ='';
		$countryFans .='<div class="clearfix" style="background:#C0C0C0;color:#fff;padding: 5px;margin-top:2px;">'.$lang['FANS'].'</div>';
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
		global $lang;
		include($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php');
		$miscObjCountryMenu=new misc();
		$objMemberCountryPeoples = new member1(); 
		$logged_in_member_id_CountryPeople = $_SESSION['SESS_MEMBER_ID'];
		$countryPeoplesResult=$miscObjCountryMenu->getRandom3CountryPeoples($countryID);
		$countryPeoples ='';
		$countryPeoples .='<div class="clearfix" style="background:#C0C0C0;color:#fff; padding: 5px;margin-top:2px;">'.$lang['People of'].' '.$countryTitle.'</div>';
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