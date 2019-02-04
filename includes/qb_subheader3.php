<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_misc.php');

$logged_in_member_id_header2 = $_SESSION['SESS_MEMBER_ID'];
$objMemberHeader1 = new member1(); 
$objMisc = new misc(); 

$currentMemberResultHeader1=$objMemberHeader1->select_member_byID($logged_in_member_id_header2);
$currentMemberResultHeader1ProfileLogo=$objMemberHeader1->select_member_meta_value($logged_in_member_id_header2,'current_profile_image');

$currentUsername = '';
$currentUserProfilePic = '';
while($clMember = mysqli_fetch_array($currentMemberResultHeader1)) {
	$currentUsername=$clMember['username'];
}

if($currentMemberResultHeader1ProfileLogo){			
    $currentUserProfilePic = SITE_URL.'/'.$currentMemberResultHeader1ProfileLogo;
    if(isset($_REQUEST['refresh'])){
        $currentUserProfilePic .= '?refresh='.$_REQUEST['refresh'];
    }
} else {
	$currentUserProfilePic = SITE_URL.'/images/default.png';
}


$favarioteCountriesResult=$objMisc->getFavCountry($logged_in_member_id_header2);
$favCountries='';


foreach($favarioteCountriesResult as $valueFavCountries){
	//$flagURL=SITE_URL."/images/Flags/flags_new/30x20flags/".strtolower($valueFavCountries['code']).".png";
	$favCountries .='<a class="thumbnail headerflagthumbs" style="margin-right:3px;padding:0px;display:inline-block;margin-bottom:0px;" href="'.SITE_URL.'/country/'.$valueFavCountries['code'].'" >';
	//$favCountries .='<div class="flag_display" style="margin-bottom:0px; line-height:150%;">';
	$favCountries .='<i class="sprite sprite-'.strtolower($valueFavCountries['code']).'" style="min-height:18px;"></i>';
	//$favCountries .='<img src="'.$flagURL.'" title="'.$valueFavCountries["country_title"].'" height="20" width="30" style="min-height:18px;"/>';
	$favCountries .='<span style="font-size:9px;">'.substr($valueFavCountries['country_title'],0,6).'</span>';
	//$favCountries .='</div>';
	$favCountries .='</a>';
	
}
?>

<!-- Script for images tool tip -->
<script>
$(document).ready(function(){
$('[data-toggle="tooltip"]').tooltip(); 
});
</script>



<ul class="nav navbar-nav right-navbar-nav ulHeader">
  
 
    

<!-- Setting Icon -->    
<li class="liHeader" style="padding-top: 12px; padding-left: 25px;" data-toggle="tooltip" title="Settings" data-placement="bottom">
<div class="dropdown notification_inline">
    <a href="#" class="dropdown-toggle user-menu" data-toggle="dropdown" style="background-color:#337ab7;outline: none !important;">
    <i style="font-size: 20px; color: white;" class="glyphicon glyphicon-cog"></i>
</a>                                                    
<ul class="dropdown-menu">
<li> <a href="<?php echo $base_url;?>profile.php" style="white-space: nowrap;text-overflow: ellipsis;font-size: 14px; display: block; "><?php echo $lang['Profile'];?><i id="firstIcon" class="fa fa-user" style="padding-left: 5px;"></i></a></li><li role="separator" class="divider"></li>
<li><a href="<?php echo $base_url;?>account_settings.php"  style="white-space: nowrap;text-overflow: ellipsis;font-size: 14px; display: block;"><?php echo nl2br($lang['Account Settings']);?> <i id="secondIcon" class="fa fa-gears" style="padding-left: 5px;"></i></a></li>
<li role="separator" class="divider"></li>
<li><a href="<?php echo $base_url;?>privacy.php" style="white-space: nowrap;text-overflow: ellipsis;font-size: 14px; display: block;"><?php if(isset($_SESSION['lang']))
{echo nl2br($lang['Privacy Settings']);}else{?>Privacy Settings<?php }?> <i id="thirdIcon" class="fa fa-unlock-alt" style="padding-left: 5px;"></i></a></li>
<li role="separator" class="divider"></li>
<li><a href="<?php echo $base_url;?>logout.php" style="white-space: nowrap;text-overflow: ellipsis;font-size: 14px; display: block;"><?php if(isset($_SESSION['lang']))
{echo nl2br($lang['Logout']);}else{?>Logout<?php }?><i id="fourthIcon" class="fa fa-power-off" style="padding-left: 5px;"></i></a>
</li>
</ul>                                                         
</div>
</li>


<!-- World Icon -->
<li class="liHeader" style="padding-top: 10px;padding-left: 25px;">    
<a href="<?php echo SITE_URL.'/';?>home" style="margin-right:3px;display:inline-block;padding:0px;font-size: 7px;color:#FFF; text-align:center;white-space: nowrap;text-overflow: ellipsis;cursor:pointer;" data-toggle="tooltip" title="World" data-placement="bottom">
    <i style="font-size: 20px;" class="glyphicon glyphicon-globe"></i>   
</a>
</li>


<!-- My Favorite Countries Icon -->
<li class="liHeader" style="padding-top: 10px;padding-left: 25px;">
<a href="<?php echo SITE_URL;?>/create_country.php" style="margin-right:3px;display:inline-block;padding:0px;font-size: 7px;color:#FFF; text-align:center;white-space: nowrap;text-overflow: ellipsis;cursor:pointer;" data-toggle="tooltip" title="Favorite Countries" data-placement="bottom">
    <img src="<?php echo SITE_URL;?>/images/header_icons/add-heart.png" style="width:20px;height: 20px;" />
</a>
</li>


<!-- Favorite Countries -->							
<li class="liHeader" style="text-align: center;padding-left: 25px;">
<?php echo $favCountries;?>
</li>


<!-- User Name and profile image with link to user page-->
<li class="liHeader">
  <a href="<?php echo SITE_URL."/i/".$currentUsername;?>" style="padding-top: 0px; padding:0px;font-size: 15px;color:#FFF; text-align:center;white-space: nowrap;text-overflow: ellipsis;cursor:pointer;" data-toggle="tooltip" title="Profile" data-placement="bottom">
  <img src="<?php echo $currentUserProfilePic;?>" style="height: 43px;width: 50px"/> 
  <!--<strong><?php echo ucfirst($currentUsername);?></strong>-->
  </a>
</li> 

</ul>