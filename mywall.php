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
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/my_profile_menu.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/view_notification_extra.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/friends_request_notification_extra.php');
	
	$memberUsername=$_GET['uname'];	
	$appsWidgetObjMember=new appsWidget();
	$statusWidgetObjMember=new statusWidget();
	$viewNotifyWidgetObjMember=new viewNotificationExtraWidget();
	$frReqWidgetObjMember=new friendsRequestNotificationExtraWidget();
	$postWidgetObj=new postWidget();	
	$objLookupClass=new lookup();
	$objMember = new member1();	
	$activeID =  $objLookupClass->getLookupKey("MEMBER STATUS", "ACTIVE");			
	$lookupWallID=$objLookupClass->getLookupKey('Wall Type', 'My Wall');	
	//echo "<pre>My wall page";
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
	$checkDefault = false;
	
	$privacyProfileVisibility=0;
	$privacyPhoto=0;
	$privacyFriends=0;
	
	$defaultMale = 'images/ImageGenderMale.png';
	$defaultFemale = 'images/ImageGenderFemale.png';
	$defaultOthers = 'images/ImageGenderOther.png';
	
	foreach($memberResult as $valueMemberResult){
		$memberID=$valueMemberResult['member_id'];
		$memberDisplayName=$valueMemberResult['username'];
	}
	if($logged_in_member_id_member_profile != $memberID){
		header('location: '.SITE_URL.'/'.$memberUsername);
		exit();
	}
	
	$memberProfilePic=$objMember->select_member_meta_value($memberID,'current_profile_image');
	$encryptedMemberID=$QbSecurity->QB_AlphaID($memberID);
	if($memberProfilePic==$defaultMale)
		{$checkDefault = true;}
	if($memberProfilePic==$defaultFemale)
		{$checkDefault = true;}
	if($memberProfilePic==$defaultOthers)
		{$checkDefault = true;}
	if($memberProfilePic){			
		$memberProfilePic = SITE_URL.'/'.$memberProfilePic;
		if(isset($_REQUEST['refresh'])){
			$memberProfilePic .= '?refresh='.$_REQUEST['refresh'];
		} else if(false !== strpos($_SERVER['REQUEST_URI'], 'refresh=')) {
			$memberProfilePic .= '?refresh='.time();
		}
	}
	else{
		$memberProfilePic=SITE_URL.'/images/default.png';
	}
	$menuObjProfile=new myProfileMenu();
	$objMisc = new misc();
	$memberMenuResult=$menuObjProfile->getMenu($memberID,$memberUsername);
?>
 <?php if(!$checkDefault) { ?>
  
  <div id="confirmDel" class="modal fade" tabindex="-1"  role="dialog" aria-labelledby="mySmallModalLabel">
						  <div class="modal-dialog modal-sm" role="document">
						  <div class="modal-content" >
							  <div class="modal-body">
							    Are you sure?
							  </div>
							  <div class="modal-footer">
							    <form action="<?php echo $base_url;?>action/remove_photo.php" method="POST">
							    	<button type="submit" class="btn btn-primary" id="delete" name="delete" value="delete">Delete</button>
							    	<button type="button" data-dismiss="modal" class="btn">Cancel</button>
							    </form>
							  </div>
						  </div>
						  </div>
						</div>
						
	<?php } ?>
  
  <div id="change_profile"  class="modal fade" tabindex="-1"  role="dialog" aria-labelledby="mySmallModalLabel">
						  <div class="modal-dialog " role="document">
						  <div class="modal-content" >
							  <div class="modal-header">
							  	<div id="imageError"></div>
							  </div>
							  <div class="modal-body">
							  <form action="<?php echo $base_url;?>action/upload_file.php" method="post" id="change_profileForm" name="change_profileForm"  enctype="multipart/form-data" data-fv-framework="bootstrap"
	    data-fv-icon-valid="glyphicon glyphicon-ok"
	    data-fv-icon-invalid="glyphicon glyphicon-remove"
	    data-fv-icon-validating="glyphicon glyphicon-refresh">
									  <h6><?php echo $lang['Change Picture'];?></h6>
									 <span class="btn btn-primary btn-file">
										    Browse <input type="file" id="fileImage" name="file" data-fv-file="true"
	                data-fv-file-extension="jpeg,png"
	                data-fv-file-type="image/jpeg,image/png"
	                data-fv-file-maxsize="2097152"
	                data-fv-file-message="The selected file is not valid">
									 </span>
									 <div class="thumbnail" >
										      <img src="<?php echo $memberProfilePic.'?'.time();?>" id="photoUploadImagePreview" height="140" width="140"  alt="Profile Picture">
									 </div>
									
							  
							  <button type="submit" class="btn btn-primary" id="uploadImage" name="uploadImage" value="uploadImage">Upload</button>
						          <button type="button" data-dismiss="modal" class="btn">Cancel</button>
							  
							  </form>  
							  </div>
						  </div>
						  </div>
						</div>
<div id="change_profile_mobile" style="z-index:10001;" class="modal fade" tabindex="-1"  role="dialog" aria-labelledby="mySmallModalLabel">
						  <div class="modal-dialog modal-sm " role="document">
						  <div class="modal-content" >
							  <div class="modal-header">
							  	<div id="imageError"></div>
							  </div>
							  <div class="modal-body">
							  <form action="<?php echo $base_url;?>action/upload_file.php" method="post" id="change_profileForm" name="change_profileForm"  enctype="multipart/form-data" data-fv-framework="bootstrap"
	    data-fv-icon-valid="glyphicon glyphicon-ok"
	    data-fv-icon-invalid="glyphicon glyphicon-remove"
	    data-fv-icon-validating="glyphicon glyphicon-refresh">
									  <h6><?php echo $lang['Change Picture'];?></h6>
									 <span class="btn btn-primary btn-file">
										    Browse <input type="file" id="fileImage" name="file" data-fv-file="true"
	                data-fv-file-extension="jpeg,png"
	                data-fv-file-type="image/jpeg,image/png"
	                data-fv-file-maxsize="2097152"
	                data-fv-file-message="The selected file is not valid">
									 </span>
									 <div class="thumbnail" >
										      <img src="<?php echo $memberProfilePic."?".time();?>" id="mphotoUploadImagePreview" height="140" width="140"  alt="Profile Picture">
									 </div>
									
							  
							  <button type="submit" class="btn btn-primary" id="uploadImage" name="uploadImage" value="uploadImage">Upload</button>
						          <button type="button" data-dismiss="modal" class="btn">Cancel</button>
							  
							  </form>  
							  </div>
						  </div>
						  </div>
						</div>

<!-- Left Panel -->     
    <div class="col-lg-3 col-md-3 hidden-sm-3 hidden-xs" style="padding-left:0px;padding-right:0px;"> 
        <div class="LeftPanel">
        <?php 
            //print $viewNotifyWidgetObjMember->getPanel2($memberID);
            print $appsWidgetObjMember->getApps();
        ?>

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
                                            <img src="'.SITE_URL.'/'.$member1->select_member_meta_value($friend_id,'current_profile_image').'" style="border:1px solid #ccc; padding:2px;width:75px;height: 75px;">
                                            </a>';
						}
						if (++$i == 13) break;
					}
					?>
				</div>
			</div>

        </div>
    </div>
                        
    
     
     <!-- !! -->
    <div class="col-lg-3 col-md-3 hidden-lg hidden-xl hidden-md visible-xs visible-xs">  
      <div> 
        <div style="text-align:center;background: #fff;" class="moduletable">
             <a data-toggle="modal" data-target="#change_profile_mobile">
             <img src="<?php echo $memberProfilePic.'?'.time(); ?>" style="max-height: 200px; padding: 0px;"/> 
             </a>
             <div style="background:#C0C0C0; padding: 5px;color:#fff;"><?php echo strtoupper($memberDisplayName);?></div>
        

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
            <div id="addTabsC" class="navbar-collapse collapse" style="max-height:400px;background: #fff;">
                <?php print $memberMenuResult;?>			
        </div>
        </nav>
      </div> 

    </div> 


     <!-- Center Panel -->
     <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 " style="padding: 0px; margin: 0px;">
        <div class="MemoBar">			
        <?php print $statusWidgetObjMember->getStatusWidget($encryptedWallID,$lookupWallID);?>
    </div>

  <div class="wallvwe wordlwall">
    <?php print $postWidgetObj->getPosts($encryptedWallID, '','get');?>       	
  </div>
  <?php if($postWidgetObj->getCountIntialPost()>9){?>
            <div style="text-align: center; z-index: 99999; font-size: 25px; margin: 80px 0px 30px;" id="wall_loader"> <i class="fa fa-spinner fa-spin" style="margin-right: 5px;"></i>Loading ...
            </div>
            <?php }?>
    </div>

     <!-- Ads & friends requests bar-->
    <div class="col-lg-2 col-md-2 col-sm-2 hidden-xs"> 
<!-- <div id="chatlist" class="RightPanel">-->
     <div class="RightPanel">
        <?php include($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/ads.php');?>
        <?php echo $frReqWidgetObjMember->getPanel($memberID); ?>
     </div>
    </div>

    
     
     
     <!-- profile image and activities right panel-->
      	  <div class="col-lg-2 col-md-2 hidden-sm hidden-xs">	    
        <div  id="fixedapp" class="RightPanel"> 
        <div style="text-align:center;background: #fff;" class="moduletable">
            <a data-toggle="modal" data-target="#change_profile"><img src="<?php echo $memberProfilePic.'?'.time() ?>" style="max-height: 200px; padding: 0px;"/></a>
            <div style="background:#C0C0C0; padding: 5px;color:#fff;"><?php echo strtoupper($memberDisplayName);?></div>
            
            
            
            
            <div class="panel-group" id="accordion">
                <div class="panel panel-primary" id="panel1">
                        <div class="panel-heading" style="padding:0px 0px;">
                                <h5 class="panel-title">
                        <a data-toggle="collapse" data-target="#collapseOne" href="javascript:void(0)">Change Picture</a>
                            </h5>
                    </div>
                        <div id="collapseOne" class="panel-collapse collapse">
                            <div class="panel-body">
                            <button type="button" class='btn btn-info btn-xs' data-toggle="modal" data-target="#change_profile" ><?php echo $lang['Upload file'];?>...</button>

                            <?php if(!$checkDefault)
                            { ?>
                            <button type="button" class='btn btn-danger btn-xs' id="remove_levels" data-toggle="modal" data-target="#confirmDel" ><?php echo  $lang['Remove photos']; ?></button>

                        <?php } ?>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        <div id="addTabsC" style="max-height:400px;background: #fff;">
                <?php print $memberMenuResult;?>			
        </div>
      </div> 
 
    
    
    
    
    
    
    
    
    
    
    
    
 

				        	
<script type="text/javascript">
$(document).ready( function() {

//$('#change_profileForm').formValidation();

	$(document).on('change', '.btn-file :file', function() {
    var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
});
	
    $('.btn-file :file').on('fileselect', function(event, numFiles, label) {
        console.log(numFiles);
        console.log(label);
        if($('.imagePreviewError').length)
     {$('.imagePreviewError').remove();}
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
 
        if (/^image/.test( files[0].type)){ // only image file
            var reader = new FileReader(); // instance of the FileReader
            reader.readAsDataURL(files[0]); // read the local file
 
            reader.onloadend = function(e){ // set image data as background of div
                $("#photoUploadImagePreview").attr('src', e.target.result);
                $("#mphotoUploadImagePreview").attr('src',e.target.result);
            }
        }else
        {
        $("#imageError").append('<div class="imagePreviewError alert alert-danger" role="alert">Please Upload a Valid Image File!!</div');
        }
    }); 
  
    
});
</script>
<input type="hidden" id="twn" class="twn" value="<?php echo $encryptedWallID;?>"/>
<input type="hidden" id="twnEC" class="twnEC" value="<?php echo $encryptedMemberID;?>"/>

</div>
<?php
	include($_SERVER['DOCUMENT_ROOT'].'/share.php');
	include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_footer.php');
	
?>