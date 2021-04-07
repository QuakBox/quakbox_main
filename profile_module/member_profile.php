<?php
 	error_reporting(-1);
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php'); 	 
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');		
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_header.php');
	//require_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/apps.php');	
	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_security.php');	
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/posts.php');	
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/status.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_lookup.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_misc.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/member_profile_menu.php');
        require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member.php');
	
	
	
	$memberUsername=$_REQUEST['uname'];
	$appsWidgetObjMember=new appsWidget();
	$statusWidgetObjMember=new statusWidget();
	$postWidgetObj=new postWidget();	
	$objLookupClass=new lookup();
	$objMember = new member1();	
	$activeID =  $objLookupClass->getLookupKey("MEMBER STATUS", "ACTIVE");			
	$lookupWallID=$objLookupClass->getLookupKey('Wall Type', 'Member Wall');		
	//echo "<pre>Member Wall";
//print_r($lookupWallID);
//die();
	$encryptedWallID=$QbSecurity->QB_AlphaID($lookupWallID); 
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
				$memberProfilePic=SITE_URL.'/'.$memberProfilePic.'?'.time();	
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
		$checkFriendsrequestCount1=$objMisc->getFriendsRequestStatus($logged_in_member_id_member_profile,$memberID);
		$checkFriendsrequestCount2=$objMisc->getFriendsRequestStatusCount2($logged_in_member_id_member_profile,$memberID);
		$checkfriendListCount =$objMisc->getFriendsListCount($memberID);
		foreach($checkFriendsrequestTime as $valuecheckFriendsrequestTime){
			$countOfFriendsRequestStatus=$valuecheckFriendsrequestTime['count'];
		}
		foreach($checkFriendsrequestCount1 as $valuecheckFriendsrequestCount1){
			$countOfFriendsrequestCount1 =$valuecheckFriendsrequestCount1['count'];
		}
		foreach($checkFriendsrequestCount2 as $valuecheckFriendsrequestCount2){
			$countOfFriendsrequestCount2 =$valuecheckFriendsrequestCount2['count'];
		}
		foreach($checkfriendListCount as $valuecheckfriendListCount){
			$countOffriendListCount =$valuecheckfriendListCount['count'];
		}
		
		$checkPrivacyOfMember=$objMisc->checkPrivacyOfMember($memberID);
		foreach($checkPrivacyOfMember as $valuecheckPrivacyOfMember){
			$privacyProfileVisibility=$valuecheckPrivacyOfMember['profile'];
			$privacyPhoto=$valuecheckPrivacyOfMember['photo'];
			$privacyFriends=$valuecheckPrivacyOfMember['friends'];
		}
		//$checkPrivacyOfMember=$objMisc->getFriendsListCount($memberID);
		//foreach($checkPrivacyOfMember as $valuecheckPrivacyOfMember){
		//	$countOffriends=
		//}
		//$checkPrivacyOfMember=$objMisc->getFriendsRequestStatus($logged_in_member_id_member_profile,$memberID);
		//$groupMembers=$menuObjGroup->getGroupMembers($groupID,6);
		//$countryPeoples=$menuObjCountry->getCountryPeoples($countryCode,$countryID,$countryTitle);
	}
		
	
	
?>
	
	 <?php if($countOfMemberResult>0){?>
	 <?php if($countOfBlockedResult==0){?>

                <!-- Left Side-->
	 	<div class="col-lg-3 col-md-3 col-xs-2 hidden-xs" style="padding-left:0px;padding-right:0px;"> 
                    <div class="LeftPanel" > 
                        <?php print $appsWidgetObjMember->getApps(); ?>
                        
                      <!-- Member Friends Panel -->
                      <div class="panel panel-primary" style="padding: 0 !important;margin: 0 !important;border: 0;">
                              <div class="panel-heading" style="padding-top: 1px; padding-bottom: 1px;">Friends</div>
                              <div class="panel-body" style="padding: 0px !important;">
                              <?php 
                                $member = new Member();
                                $member1 = new member1();			
                                $friends_ids = explode(",", $member->get_member_friends_ids($memberID, 13));
                                $i=0;
                                foreach( $friends_ids as $friend_id)
                                {
                                      if ($i > 0)
                                      {
                                      echo '<a style="margin: 0px;display:inline-block; width:25%" title="'.$member->get_member_name($friend_id).'" href="'.SITE_URL.'/'.$member->get_username_by_id($friend_id).'">
                                            <img src="'.SITE_URL.'/'.$member1->select_member_meta_value($friend_id,'current_profile_image').'?'.time().'" style="border:1px solid #ccc; padding:2px;width:75px;height: auto;">
                                            </a>';
                                      }
                                      if (++$i == 13) break;
                                }
                                ?>
                            </div>
                          </div>

						<?php
							$friends_ids = explode(",", $member->get_member_friends_friends_ids($friends_ids, $memberID, 13));
							if(sizeof($friends_ids) > 1){
						?>
						<br>

                      <!-- Member Friends Friends Panel -->
                      <div class="panel panel-primary" style="padding: 0 !important;margin: 0 !important;border: 0;">
                              <div class="panel-heading" style="padding-top: 1px; padding-bottom: 1px;">Friend's Friends</div>
                              <div class="panel-body" style="padding: 10px;">
                              <?php
                                $i=0;
                                foreach( $friends_ids as $friend_id)
                                {
									if ($i > 0) {
										echo '<a style="margin-right: 3px;display:inline-block; title="' . $member->get_member_name($friend_id) . '" href="' . SITE_URL . '/' . $member->get_username_by_id($friend_id) . '">
                                            <img src="' . SITE_URL . '/' . $member1->select_member_meta_value($friend_id, 'current_profile_image') .'?'.time().'" style="border:1px solid #ccc; padding:2px;width: 32px; height: auto;">
                                            </a>';
									}
									$i++;
                                }
                                ?>
                            </div>
                          </div>
					<?php } ?>
                    </div>

                </div>

		<div class="col-lg-2 col-md-2 col-sm-2 visible-xs"> 
		  <?php if($countOfFriendsRequestStatus!=0){ ?>  	   
              <div> 
                <div style="text-align:center;background: #fff;" class="moduletable">
                    <img src="<?php echo $memberProfilePic; ?>" style="width: 300px;height: auto; padding: 5px;"/>
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
		
			
		<?php if($countOfFriendsRequestStatus==0){ ;?>
		<div class="col-lg-5 col-md-5 col-sm-5" >
			<div class="mini-profile" style="border: 1px solid #ccc;padding: 10px; margin-top: 10px;border-radius: 10px;background: #FFF none repeat scroll 0% 0%;">
				<div class="pull-left">
					<img src="<?php echo $memberProfilePic; ?>" style="padding: 1px; height: auto; width: 100px;"/>
				</div>
				<div class="pull-left">
					<div style="color: #095e95;font-weight: bold;margin: 5px;">
						<?php echo ucwords($memberDisplayName);?>
					</div>
					<div>
						<div class="pull-left"> <a class="" href="<?php echo SITE_URL;?>/about/<?php echo $memberUsername;?>"><span style="margin-left:5px;" class="btn btn-link btn-xs"><?php echo $lang['About'];?></span></a> </div>
						<?php if($privacyPhoto== 0){ ?>
							<div class="pull-left"> <a href="<?php echo SITE_URL;?>/photos/<?php echo $memberUsername;?>"><span class="icon-write btn btn-link btn-xs"><?php echo $lang['Photos']; ?></span></a></div>
						<?php }	else { ?>
							<div class="pull-left" style="margin: 1px;"> <span class="icon-write"><?php echo $lang['Photos']; ?></span></div>
						<?php } ?>
						<?php if($privacyFriends== 0)
						{ ?>						
						<div class="pull-left"><a href="<?php echo SITE_URL;?>/friends/<?php echo $memberUsername;?>"><span class="icon-write btn btn-link btn-xs" ><?php echo $countOffriendListCount." ".$lang['friends']; ?></span></a></div>
						<?php }
						else { ?>
						<div class="pull-left" style="margin: 1px;"><span class="icon-write"> <?php echo $countOffriendListCount." ".$lang['friends']; ?></span></div>
						<?php } ?>
						<div class="pull-left"><a href="<?php echo SITE_URL;?>/write_message.php?id=<?php echo $memberUsername;?>"><span class="icon-write btn btn-link btn-xs"><?php echo $lang['write message']; ?></span></a>
						</div>
						
				 		<?php if($countOfFriendsrequestCount1 == 1)
						{
						
							if($countOfFriendsrequestCount2 ==1)
							{ ?>
							<div id="fri<?Php echo $encryptedMemberID;?>">
								<div class="pull-left" style="margin: 5px;">
									<input type="button" name="accept_request" value="<?Php echo $lang['confirm'];?>" custoMid="<?Php echo $encryptedMemberID;?>" class="accept_request btn btn-info btn-xs">
								</div>
								
								<div class="pull-left" style="margin: 5px;">
									<input type="button" name="cancel_request" value="<?Php echo $lang['not now'];?>" custoMid="<?Php echo $encryptedMemberID;?>" class="cancel_request btn btn-danger btn-xs">
								</div>
							
							</div>
								<div class="pull-left" style="margin: 5px;display:none;" id="friend<?Php echo $encryptedMemberID;?>">
									<input type="button" name="accept_request" value="Friends" class="friends btn btn-success btn-xs">
								</div>
							
							<?php }
							else 
							{?>
							
							<div class="pull-left">
								<button type="button" class='btn btn-danger btn-xs'  name="delete_request" data-toggle="modal" data-target="#delete_requestFriend" ><?php echo  $lang['cancel request']; ?></button>
							</div>
							<?php }
						
							//echo "<span class='icon-add-friend'>".$lang['Request Sent']."</span>";
						}
						else if($countOfFriendsRequestStatus ==0)
						{ ?>
							<div class="pull-left">
							<button type="button" class='btn btn-link btn-xs' id="remove_levels" data-toggle="modal" data-target="#addFriendRequest" ><?php echo  $lang['Add as friend']; ?></button>
							</div>
						<?php }
						else
						{
						echo $lang['friends'];
						}
						?>
						<div class="clearfix"></div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<?php }else{ ?>	
		<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 NoSidepadding">
			<div class="MemoBar">			
				<?php print $statusWidgetObjMember->getStatusWidget($encryptedWallID,$lookupWallID);?>
			</div>
			<div style="position:relative;top:75px;" class="wallvwe memberwall">
			      	<?php print $postWidgetObj->getPosts($encryptedWallID,$encryptedMemberID,'get');?>
			</div>
			
			<?php if($postWidgetObj->getCountIntialPost()>9){?>
		        <div style="text-align: center; z-index: 99999; font-size: 25px; margin: 80px 0px 30px;" id="wall_loader"> <i class="fa fa-spinner fa-spin" style="margin-right: 5px;"></i>Loading ...
		        </div>
		        <?php }?>
      		</div>
      		<?php } ?>	
  	
  <div class="col-lg-2 col-md-2 hidden-sm hidden-xs"> 
     <div class="RightPanel"> <?php include($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/ads.php');?></div>
  </div>
   
  	  <?php //if($countOfFriendsRequestStatus!=0){ ?>  
  	  <div class="col-lg-2 col-md-2 hidden-sm hidden-xs">	   
		  <div id="fixedapp" class="RightPanel"> 
			<div style="text-align:center;background: #fff;" class="moduletable">
				<img src="<?php echo $memberProfilePic; ?>" style="width: 100%;max-height: 300px; padding: 0px;"/>
				<div style="background:#C0C0C0; padding: 5px;margin-bottom: 5px; color:#fff;"><?php echo strtoupper($memberDisplayName);?></div> 
	 
			</div>
			<div id="addTabsC" style="max-height:400px;background: #fff;">
			  	<?php print $memberMenuResult;?>			
			</div>

		  </div> 	  
	   </div>
	  <?php //} //modal for add friend
if($countOfFriendsRequestStatus==0){
 if($countOfFriendsrequestCount1 == 1)
{
if($countOfFriendsrequestCount2 ==1)
{}else{ ?>
<div id="delete_requestFriend" class="modal fade" tabindex="-1"  role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content" >
			<div class="modal-body">
				Are you sure you want to cancel this request?
			</div>
			<div class="modal-footer">
				<form action="<?php echo $base_url;?>action/delete_friend_request.php" method="POST">
					<button type="submit" class="btn btn-primary" id="delete" name="delete" value="delete">Delete</button>
					<button type="button" data-dismiss="modal" class="btn">Cancel</button>
					<input type="hidden" value="<?php echo $encryptedMemberID;?>" id="memEnc"  name="memEnc"/>
				</form>
			</div>
		</div>
	</div>
</div>
<?php }
}else if($countOfFriendsRequestStatus ==0)
{ ?>
  <div id="addFriendRequest" class="modal fade" tabindex="-1"  role="dialog" aria-labelledby="mySmallModalLabel">
						  <div class="modal-dialog modal-sm" role="document">
						  <div class="modal-content" >
							  <div class="modal-body">
							    <?php echo $lang['Are you sure you want to add this friend']; ?>?
							  </div>
							  <div class="modal-footer">
							    <form action="<?php echo $base_url;?>action/add_friend.php" method="POST">
							    	<label for="message"><?php echo $lang['write message']; ?>?</label>
							    	<textarea class="form-control" rows="5" id="message" placeholder="<?php echo $lang['write message']; ?>"></textarea>
							    	<button type="submit" class="btn btn-primary" id="add_friend" name="add_friend" value="<?php echo $lang['Add friend']; ?>"><?php echo $lang['Add friend']; ?></button>
							    	<button type="button" data-dismiss="modal" class="btn">Cancel</button>
							    	<input type="hidden" value="<?php echo $encryptedMemberID;?>" id="memEnc"  name="memEnc"/>
							    </form>
							  </div>
						  </div>
						  </div>
						</div>
<?php }} ?>
  <input type="hidden" id="twn" class="twn" value="<?php echo $encryptedWallID;?>"/>
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

  
  



<?php
	include($_SERVER['DOCUMENT_ROOT'].'/share.php');
	include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_footer.php');
	
?>