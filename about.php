<?php
/*
Author: Abhinav
*/
	error_reporting(-1);
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php'); 	 
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');		
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_header.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_security.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_lookup.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/member_profile_menu.php');
	$objMember = new member1(); 
	$lookupObject = new lookup();
	//$session_member_id = $QbSecurity->qbClean($_SESSION['SESS_MEMBER_ID'],$con);
	$memberUsername = $QbSecurity->qbClean($_REQUEST['member_id'], $con);
	$activeID =  $lookupObject->getLookupKey("MEMBER STATUS", "ACTIVE");
	$logged_in_member_id_member_profile = $_SESSION['SESS_MEMBER_ID'];	
	$memberResult=$objMember->getMemberByUsernameandStatus($memberUsername,$activeID);
	$countOfMemberResult=count($memberResult);
	$memberID=0;
	$encryptedMemberID=0;
	$memberProfilePic='';
	$memberDisplayName='';
	$memberMenuResult='';	
	$countOfBlockedResult=0;
	$countOfFriendsRequestStatus=0;
	$countOffriends=0;
	
	$privacyProfileVisibility=0;
	$privacyPhoto=0;
	$privacyFriends=0;
	
	if(!(empty($memberUsername) || $QbSecurity->qbCheckSpecialChars($memberUsername)))
	{
	$qb_err_msg="Oops Something Went Wrong...!";
$QbSecurity->qbErrorMessage($qb_err_msg,$homepage);
	}
	
	foreach($memberResult as $valueMemberResult){
		$memberID=$valueMemberResult['member_id'];
		$memberDisplayName=$valueMemberResult['displayname'];			
	}
	if($logged_in_member_id_member_profile == $memberID){
		header('location: '.SITE_URL.'/i/'.$memberUsername);
		exit();
	}
	if($countOfMemberResult>0){
		$memberProfilePic=$objMember->select_member_meta_value($memberID,'current_profile_image');
		$encryptedMemberID=$QbSecurity->QB_AlphaID($memberID);
		if($memberProfilePic){			
				$memberProfilePic=SITE_URL.'/'.$memberProfilePic;	
		}
		else{
			$memberProfilePic=SITE_URL.'/images/default.png';
		}
		$blockedResult=$objMember->get_member_blocked_status($logged_in_member_id_member_profile,$memberID);
		$countOfBlockedResult=count($blockedResult);
		$menuObjProfile=new memberProfileMenu();
		$objMisc = new misc();
		$memberMenuResult=$menuObjProfile->getMenu($memberID,$memberUsername);
		$checkFriendsrequestTime=$objMisc->getCountOfFriendsRequestStatus($logged_in_member_id_member_profile,$memberID);
		foreach($checkFriendsrequestTime as $valuecheckFriendsrequestTime){
			$countOfFriendsRequestStatus=$valuecheckFriendsrequestTime['count'];
		}
		$checkPrivacyOfMember=$objMisc->checkPrivacyOfMember($memberID);
		foreach($checkPrivacyOfMember as $valuecheckPrivacyOfMember){
			$privacyProfileVisibility=$valuecheckPrivacyOfMember['profile'];
			$privacyPhoto=$valuecheckPrivacyOfMember['photo'];
			$privacyFriends=$valuecheckPrivacyOfMember['friends'];
		}
		$sql = mysqli_query($con, "select * from member where username='".$memberUsername."'") or die(mysqli_error($con));	
		$res = mysqli_fetch_array($sql);
		$country=$objMember-> select_member_meta_value_for_GeoCountry($memberID);
		$state=$objMember-> select_member_meta_value_for_GeoState($memberID);
		$city=$objMember-> select_member_meta_value_for_GeoCity($memberID);	
		$gender= $objMember->select_member_meta_value_for_lookupID($memberID,"Gender");
		$birthdate= $res['dob'];
		$relationship=$objMember->select_member_meta_value_for_lookupID($memberID,"relationship_status");
		$language=$objMember->select_member_meta_value_for_lookupID($memberID,"language_known");
		$political_views=$objMember->select_member_meta_value_for_lookupID($memberID,"political_view");
		$displayName = $res['displayname'];
		$about_me  = $objMember->select_member_meta_value($memberID,"about_me");
		$mobile_no= $objMember->select_member_meta_value($memberID,"phone_mobile");
		$landline_no= $objMember->select_member_meta_value($memberID,"phone_landline");
		$address=$objMember->select_member_meta_value($memberID,"address");
		$zip=$objMember->select_member_meta_value($memberID,"zip");
		$curcity=$objMember->select_member_meta_value($memberID,"current_city");
		$hometown=$objMember->select_member_meta_value($memberID,"home_town");
		$website=$objMember->select_member_meta_value($memberID,"website");
		
		$educationResult = $objMember->select_member_Education_history($memberID);
		$edures = mysqli_fetch_array($educationResult);
		$organization_name = $edures['organization_name'];
		$education_grade = $edures['education_grade'];
		$education_grade = $lookupObject->getValueByKey($education_grade);
		$education_year_from = $edures['education_year_from'];
		$education_year_to = $edures['education_year_to'];
		
			
			//$checkPrivacyOfMember=$objMisc->getFriendsListCount($memberID);
			//foreach($checkPrivacyOfMember as $valuecheckPrivacyOfMember){
			//	$countOffriends=
			//}

//        $groupMembers=$menuObjGroup->getGroupMembers($groupID,6);
//        $countryPeoples=$menuObjCountry->getCountryPeoples($countryCode,$countryID,$countryTitle);

        $canIAccess = $objMisc->canIAccessMember($logged_in_member_id_member_profile, $memberID);
	}
?>


<div class="insideWrapper container">
    <?php if(!$canIAccess){ ?>
        <div class="col-lg-12">You should have this user as your friend to view his profile page.</div>
    <?php } else { ?>
    <?php if($countOfMemberResult>0){?>
	 <?php if($countOfBlockedResult==0){?>	 	
	 	
		<div class="col-lg-3 visible-xs"> 
  	  <?php if($countOfFriendsRequestStatus!=0){ ?>  	   
		  <div> 
			<div style="text-align:center;background: #fff;" class="moduletable">
				<img src="<?php echo $memberProfilePic; ?>" style="width: 100%; padding: 5px;"/>
				<div style="background:#C0C0C0; padding: 5px;margin-bottom: 5px;color:#fff;"><?php echo strtoupper($memberDisplayName);?></div> 
	 
			</div>
			<nav class="navbar navbar-default">
			<div class="navbar-header">
  			<button type="button" data-toggle="collapse" data-target="#addTabsC" aria-expanded="false" aria-controls="navbar" class="navbar-toggle collapsed  btn-warning">
			            <span class="sr-only">Toggle navigation</span>
			            <span class="icon-bar"></span>
			            <span class="icon-bar"></span>
			            <span class="icon-bar"></span>
			</button>
			</div>
  			<div id="addTabsC" class="navbar-collapse collapse" style="background: #fff;">
			  	<?php print $memberMenuResult;?>			
			</div>
  			</nav>
		  </div> 	  
	  <?php } ?>
  		</div>
		
		<div class="col-lg-6">	
		<?php if($countOfFriendsRequestStatus==0){ ?>
			<div class="mini-profile" style="border: 1px solid #ccc;padding: 10px; margin-top: 10px;">
				<div class="pull-left">
					<img src="<?php echo $memberProfilePic; ?>" style="padding: 1px; height: 100px; width: 100px;"/>
				</div>
				<div class="pull-left">
					<div style="color: #095e95;font-weight: bold;margin: 5px;">
						<?php echo ucwords($memberDisplayName);?>
					</div>
					<div>
						<div class="pull-left" style="margin: 5px;"> <a class="" href="<?php SITE_URL;?>/about/<?php echo $res['username'];?>"><span style="margin-left:5px;"><?php echo $lang['About'];?></span></a> </div>
						<?php if($privacyPhoto== 0){ ?>
							<div class="pull-left" style="margin: 5px;"> <a href="<?php echo SITE_URL;?>/photos/<?php echo $res['username'];?>"><span class="icon-write"><?php echo $lang['Photos']; ?></span></a></div>
						<?php }	else { ?>
							<div class="pull-left" style="margin: 5px;"> <span class="icon-write"><?php echo $lang['Photos']; ?></span></div>
						<?php } ?>
						<?php if($privacyFriends== 0)
						{ ?>						
						<div class="pull-left" style="margin: 5px;"><a href="<?php echo SITE_URL;?>/friends/<?php echo $res['username'];?>"><span class="icon-group"><?php echo $lang['friends']; ?></span></div>
						<?php }
						else { ?>
						<div class="pull-left" style="margin: 5px;"><span class="icon-group"> <?php echo $lang['friends']; ?></span></div>
						<?php } ?>
						<div class="pull-left" style="margin: 5px;"><a href="<?php echo SITE_URL;?>/write_message.php?id=<?php echo $res['username'];?>"><span class="icon-write"><?php echo $lang['write message']; ?></span></a></div>
						<div class="clearfix"></div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		
		<?php }else{ ?>	
			
			<?php
$add_friend =mysqli_query($con, "select * from friendlist where  ( ( added_member_id = '".$logged_in_member_id_member_profile."' and member_id='$memberID' ) 
						or (  member_id= '".$logged_in_member_id_member_profile."' and added_member_id ='$memberID' ) ) ");

$add_friend1 =mysqli_query($con, "select * from friendlist where added_member_id = '".$memberID."'");

$add_res  = mysqli_fetch_array($add_friend);
mysqli_num_rows($add_friend);
$friend_privacy =mysqli_query($con, "select * from privacy where privacy_member_id = '".$memberID."'");
$add_frnd  = mysqli_fetch_array($friend_privacy);
$senttime = intval(floor((time() - $add_res['sent']) / 3600));
/*echo $sentquery = ("select * from friendlist 
                       where  (  ( added_member_id = '".$logged_in_member_id_member_profile."' and member_id='$memberID' )
					   or (  member_id= '".$logged_in_member_id_member_profile."' and added_member_id ='$memberID' ) ) 
					   AND sent >= UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 24 HOUR))");

$sentsql = mysql_query($sentquery) or die(mysql_error());
$senttime = mysql_num_rows($sentsql);*/
if($senttime >= 24) {}
?>


<div id='info_box'>

<?php 
$fsql1 = mysqli_query($con, "select m.username,m.member_id,f.added_member_id from friendlist f,member m where f.added_member_id=m.member_id and f.member_id='".$memberID."' AND f.status != 0");

$psql = mysqli_query($con, "select USER_CODE from upload_data where USER_CODE='$memberID'");
?>

<div class="favourite_country" >
<div class="fav_country_width"><?php echo $lang['Favourite country'];?></div>
 <div id="flag_mod" align="center" class="flag_mod1">
       <table>
       <tr>
		<?php 
	$fav = mysqli_query($con, "select c.code,c.country_title from favourite_country f,geo_country c where f.code=c.code and f.favourite_country=1 and member_id = '".$memberID."'");
		
		while($fav_res = mysqli_fetch_array($fav))
		{			
		?>
        <td class="td_class1">
        <div class="flag_display">
        <a href="<?php echo $base_url;?>country_wall.php?country=<?php echo $fav_res['country_title'];?>" class="a_color12">
		<img src="<?php echo $base_url."images/Flags/".strtoupper($fav_res['code']).".gif";?>" height="20" width="30"/>
        <br/><?php $a = strtoupper($fav_res['country_title']); echo substr($a,0,6); ?>
	</a>        
        </div>
        </td>
	<?php	} ?>
        </tr>
      </table>      
        </div>
</div>
<div class='div_clear'></div>

</div>



<div class="column_internal_left">

<div id="about">
<div id="about-title"><?php echo $lang['About'];?></div>

</div>

<div class="infoGroup" >
<h4 class="infoGroupTitle"><?php echo $lang['Basic Information'];?></h4>
<dl class="profile-right-info">


<dt><?php echo $lang['Gender'];?></dt>
<?php if(mysqli_num_rows($add_friend) == 0 or mysqli_num_rows($add_friend) == 1)
{
if($add_frnd['gender']== 0)
{ ?>
<dd><?php echo $gender;?></dd>
<?php } }
else if($add_frnd['gender'] != 1){ ?>
<dd><?php echo $gender;?></dd>
<?php } ?>


<dt><?php echo $lang['Birthday'];?></dt>
<?php if(mysqli_num_rows($add_friend) == 0 or mysqli_num_rows($add_friend) == 1)
{
if($add_frnd['birthday'] == 0)
{ ?>
<dd><?php echo date('l jS F Y',strtotime($birthdate))?></dd>
<?php } }
else if($add_frnd['birthday'] != 1) { 
?>
<dd><?php echo date('l jS F Y',strtotime($birthdate))?></dd>
<?php } ?>
<?php 
if($about_me != NULL) {
?>
<dt><?php echo $lang['About me'];?></dt>
<dd><?php echo $about_me;?></dd>
<?php  } 
if($relationship != NULL) {
?>
<dt><?php echo $lang['Relationship'];?></dt>
<dd><?php echo $relationship;?></dd>
<?php  }  
if($language != NULL) {
?>
<dt><?php echo $lang['Languages']?></dt>
<dd><?php echo $language;?></dd>
<?php  } 
if($political_views != NULL) {
?>
<dt><?php echo $lang['Political Views']?></dt>
<dd><?php echo $political_views;?></dd>
<?php  } 
?>
</dl>
</div>

    
    
    
    
    
    
    
<!-- Contact Information -->
<?php 
$show_contact_info = 0;
if($show_contact_info !=0)
{
?>
<div class="infoGroup" >
<h4 class="infoGroupTitle"><?php echo $lang['Contact Information']?></h4>
<dl class="profile-right-info">
<?php 
if($mobile_no != NULL) {
?>
<dt><?php echo $lang['Mobile Phone']?></dt>

<?php if(mysqli_num_rows($add_friend) == 0 or mysqli_num_rows($add_friend) == 1)
{
if($add_frnd['mobileno']== 0)
{ ?>

<dd><?php echo $mobile_no;?></dd>
<?php } }
else if($add_frnd['mobileno'] != 1) { ?>
<dd><?php echo $mobile_no;?></dd>
<?php } ?>
<?php } if($country != NULL || $state || $city) {?>
<dt><?php echo $lang['Address']?></dt>
<dd>
<p><?php echo $address;?></p>
<p><?php echo $city.', '.$state.', '.$country;?></p>
<?php if($zip != 0) {?>
<p><?php echo ' '.$zip;?></p>
<?php  }?>
</dd>
<?php } ?>

<dt>Quakbox</dt>
<dd><a href="<?php echo $base_url.$res['username']?>"><?php echo $base_url.$res['username']?></a></dd>

<?php if($website != NULL) {?>
<dt><?php echo $lang['Website']?></dt>
<dd><?php echo $website;?></dd>
<?php } ?>
</dl>
</div>
<?php }?>
<!-- End show contact info if statment -->
<!-- End Contact Information -->
    
    
    
    
    
    
    
    

<div class="infoGroup" >
<h4 class="infoGroupTitle"><?php echo $lang['Education']?></h4>
<dl class="profile-right-info">
<?php if($organization_name != NULL) {?>
<dt><?php echo $lang['College/University']?></dt>
<dd><?php echo $organization_name;?></dd>
<?php } if($education_year_from != 0) {?>
<dt><?php echo $lang['Graduation Year']?></dt>
<dd><?php echo $education_year_from;?></dd>
<?php } 
 ?>
</dl>
</div>

</div>


			
      		
      		<?php } ?>	
  	</div>
  <div class="col-lg-3 hidden-xs"> 
     <div style="" class="adsQBxzqw"> <?php include($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/ads.php');?></div>
  </div>
  <div class="col-lg-3 hidden-xs"> 
  	  <?php if($countOfFriendsRequestStatus!=0){ ?>  	   
		  <div id="fixedapp" class="fixedapp"> 
			<div style="text-align:center;background: #fff;" class="moduletable">
				<img src="<?php echo $memberProfilePic; ?>" style="width: 100%; padding: 5px;"/>
				<div style="background:#C0C0C0; padding: 5px;margin-bottom: 5px; color:#fff;"><?php echo strtoupper($memberDisplayName);?></div> 
	 
			</div>
			<div id="addTabsC" style="max-height:400px;background: #fff;">
			  	<?php print $memberMenuResult;?>			
			</div>
		  </div> 	  
	  <?php } ?>
  </div>
<input type="hidden" id="twnEC" class="twnEC" value="<?php echo $encryptedMemberID;?>"/>
  <?php }
  else{ 
			print '<div class="col-lg-12" style="font-size:30px;padding:10px;"> <span style="margin-left:10px;">You are Blocked by this user</span> </div>';
		}
 }
		else{ 
			print '<div class="col-lg-12" style="font-size:30px;padding:10px;"> <i class="fa fa-search"></i> <span style="margin-left:10px;">Sorry we don\'t have any active users..</span> </div>';
		}
  	?>
    <?php } ?>

</div><!--End insideWrapper div-->

<?php
//include_once 'share.php';

include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_footer.php');
?>