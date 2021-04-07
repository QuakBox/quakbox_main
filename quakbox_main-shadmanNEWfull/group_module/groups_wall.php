<?php
 	error_reporting(-1);
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php'); 	 
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');		
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_header.php');
	//require_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/apps.php');	
	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_security.php');	
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/posts.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_groups.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/group_menu.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/status.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_lookup.php');
	
	
	$groupCode=$_GET['group_id'];
	$groupID=0;
	$appsWidgetObjHome=new appsWidget();
	$statusWidgetObjGroup=new statusWidget();
	$postWidgetObj=new postWidget();	
	$groupsClassObj=new groups();
	$objLookupClass=new lookup();
	$lookupWallID=$objLookupClass->getLookupKey('Wall Type', 'Group Wall');
		
	$encryptedWallID=$QbSecurity->QB_AlphaID($lookupWallID); 
	$groupID=$groupCode;
	$groupResult=$groupsClassObj->getGroupByID($groupID);
	$countOfGroupResult=count($groupResult);
	$groupAvatar='';
	$groupName='';
	$groupMenuResult='';	
	$groupMembers='';
	$groupOwner='';
	$encryptedGroupID=0;
	foreach($groupResult as $valueGroupResult){
		$groupAvatar=SITE_URL.'/'.$valueGroupResult['avatar'];
		$groupName=$valueGroupResult['name'];
		$groupOwner=$valueGroupResult['ownerid'];		
	}
	
	if($countOfGroupResult>0){
		$encryptedGroupID=$QbSecurity->QB_AlphaID($groupID);
		$menuObjGroup=new groupMenu();
		$groupMenuResult=$menuObjGroup->getGroupMenu($groupID,$groupOwner);
		$groupMembers=$menuObjGroup->getGroupMembers($groupID,6);
		//$countryPeoples=$menuObjCountry->getCountryPeoples($countryCode,$countryID,$countryTitle);
	}
	
	if(isset($_GET['notid']))
        {
                $notificationid=$_GET['notid'];
		$updatesql = "UPDATE notifications SET notifications.is_unread=1 where notifications.id=$notificationid";
		$runupdatesql = mysqli_query($con, $updatesql) or die(mysqli_error($con));
        }
?>
	 <div class="insideWrapper container">
	 <?php if($countOfGroupResult>0){?>
	 <div class="col-lg-2 hidden-xs"> 
     		</div>
	 <div class="col-lg-3 visible-xs">  
	  <div> 
		<div style="text-align:center;background: #fff;" class="moduletable">
			  
			<img src="<?php echo $groupAvatar; ?>" style="width: 100%; padding: 5px;"/>
			<div style="background:#C0C0C0; padding: 5px;margin-bottom: 5px; color:#fff;"><?php echo strtoupper($groupName);?></div>
 
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
  			<div id="addTabsC" style="max-height:400px;background: #fff;">
			<?php print $groupMenuResult;?>
			<?php print $groupMembers;?>
			<?php //print $countryPeoples;?>  				
			</div>
  		</nav>
		
	</div> 
  </div>
		<div class="col-lg-5">
		<div class="MemberWallmemo">			
			<?php print $statusWidgetObjGroup->getStatusWidget($encryptedWallID);?>
		</div>
      <div class="wallvwe groupwall">
      	      	<?php print $postWidgetObj->getPosts($encryptedWallID,$encryptedGroupID,'get');?>
      </div>
      <?php if($postWidgetObj->getCountIntialPost()>9){?>
		        <div style="text-align: center; z-index: 99999; font-size: 25px; margin: 80px 0px 30px;" id="wall_loader"> <i class="fa fa-spinner fa-spin" style="margin-right: 5px;"></i>Loading ...
		        </div>
		        <?php }?>
  	</div>
  <div class="col-lg-2 hidden-xs"> 
     <div style="" class="adsQBxzqw"> <?php include($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/ads.php');?></div>
  </div>
  <div class="col-lg-3 hidden-xs">  
	  <div id="fixedapp" class="fixedapp"> 
		<div style="text-align:center;background: #fff;" class="moduletable">
			  
			<img src="<?php echo $groupAvatar; ?>" style="width: 100%; padding: 5px;"/>
			<div style="background:#C0C0C0; padding: 5px;margin-bottom: 5px; color:#fff;"><?php echo strtoupper($groupName);?></div>
 
		</div>
		<div id="addTabsC" style="max-height:400px;background: #fff;">
		<?php print $groupMenuResult;?>
		<?php print $groupMembers;?>
		<?php //print $countryPeoples;?>  				
		</div>
	</div> 
  </div>
  <input type="hidden" id="twn" class="twn" value="<?php echo $encryptedWallID;?>"/>
<input type="hidden" id="twnEC" class="twnEC" value="<?php echo $encryptedGroupID;?>"/>
  <?php }
		else{ 
			print '<div class="col-lg-12" style="font-size:30px;padding:10px;"> <i class="fa fa-search"></i> <span style="margin-left:10px;">Sorry No results</span> </div>';
		}
  	
  	
  	?>
  </div>  
  
  



<?php
	include($_SERVER['DOCUMENT_ROOT'].'/share.php');
	include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_footer.php');
	
?>