<?php 
	session_start();
	require_once('config.php');
	$member_id = $_SESSION['SESS_MEMBER_ID'];
	if(!isset($_SESSION['SESS_MEMBER_ID']))
	{
		header("location: ".$base_url."index.php");
		exit();
	}
	$group_id = $_REQUEST['group_id'];
	$sql = mysqli_query($con, "select * from groups where id='".$group_id."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);
	$categoryid = $res['categoryid'];
	$ownerid = $res['ownerid'];
	
	$cat_sql = mysqli_query($con, "select * from groups_category where id='$categoryid'") or die(mysqli_error($con));
	$cat_res = mysqli_fetch_array($cat_sql);
	
	$member_sql = mysqli_query($con, "select * from members where member_id='$ownerid'") or die(mysqli_error($con));
	$member_res = mysqli_fetch_array($member_sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<title><?php echo $res['name'];?></title>
<head>
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="icon" href="images/favicon.ico" type="image" />
<link rel="shortcut icon" href="images/favicon.ico" type="image" />

<link rel="stylesheet" type="text/css" href="css/group.css"/>
<script src="js/jquery.livequery.js" type="text/javascript"></script>
<script src="js/jquery.oembed.js"></script>
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript">
$(document).ready (function () {
	$('.group-delete').click (function () {
		return confirm ("Are you sure you want to delete this group?") ;
	}) ; 
}) ;
</script>
</head>
<body>
<div id="wrapper">
<?php include('includes/header.php');?>
<div id="mainbody">
<div class="column_left">	
    <div class="componentheading">
    <div id="submenushead"><?php echo $res['name'];?></div>
    </div>
    <div id="submenushead">
    <ul class="dropDown">
    <li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="groups_all.php">All Groups</a></li>
    <li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="groups.php">My Groups</a></li>
    <li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="">Pending Invitations</a></li>
  	<li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="create_groups.php">Create</a></li>
    <li style="padding:0 8px;"><a href="groups_search.php">Search</a></li>    
	</ul>
   </div>
   
	<div class="group">
	
    <div class="page-actions"> 
    <div id="report-this" class="page-action"><a class="icon-report"><span>Report Group</span></a></div>
    <div id="social-bookmarks" class="page-action"><a class="icon-bookmark"><span>Share this</span></a></div>   
    </div>
    
    <!-- begin: .cLayout -->
<div class="cLayout clrfix" style="width:750px !important;">

		<!-- begin: .cSidebar -->
		<div class="cSidebar clrfix">		
			
			 <!-- Group Menu -->
			 <div id="community-group-action" class="cModule">
		
					<h3 class="app-box-title">Group Option</h3>
					
					<div class="app-box-content">
                    	<ul class="group-menus cResetList clrfix">								
                    	<?php if($member_id = $res['ownerid']) { ?>                    		
                            <!-- Edit Group Avatar -->
                            <li><a class="group-edit-avatar" href="">Edit Avatar</a></li>
                            
                            <!-- Edit Group -->
                            <li><a class="group-edit-info" href="">Edit</a></li>
                    	<?php } ?>
                    	
                    	<?php if($member_id = $res['ownerid']): ?>
                        	<!-- Add Bulletin -->
                            <li><a class="group-add-bulletin" href="add_news.php?group_id=<?php echo $group_id;?>">Create Bulletin</a></li>
                    	<?php endif; ?>
                    	
                    	<?php if($member_id): ?>
                        	<!-- Add Discussion -->
                        	<li><a class="group-add-discussion" href="add_discussion.php?group_id=<?php echo $group_id;?>">Create Discussion</a></li>
                    	<?php endif; ?>
                    	
                    	<?php
                    	if($member_id)
                    	{
                    	//if( $albums )
                    	//{
                    	?>
                        <!-- Add Photo -->
                        <li><a class="group-add-photo" href="">Add Photo</a></li>
                    	<?php //} ?>
                    	<!-- Add Album -->
                        <li><a class="group-add-album" href="">Create Album</a></li>
                    	<?php } ?>
                    	
                    	<?php
                    	if($member_id)
                    	{
                    	?>
                        <!-- Add Video -->
                        <li><a class="group-add-video" href="javascript:void(0)" onclick="">Add Video</a></li>
                    	<?php 
                    	//}
                    	?>
                    	
                    	<?php if($member_id ) { ?>
                        	<!-- Unpublish Group -->
                        	<!--<li>
                        	<a class="group-unpublish" href="javascript:void(0);" onclick="">Group Unpublish</a></li>-->
                    	<?php } ?>
                    	
                    	<?php if($member_id) { ?>
                        	<!-- Delete Group -->
                        	<li class="important"><a class="group-delete" href="action/delete_group.php?group_id=<?php echo $group_id;?>" title="Delete Group">Delete Group</a></li>
                    	<?php } ?>
                    	
                    	<?php if($member_id){ ?>
                        	<!-- Join Group -->
                        	<li><a class="group-join" href="action/add_group_member.php?group_id=<?php echo $group_id;?>" onclick="">Join Group</a></li>
                    	<?php } ?>
                    	
                    	<?php if($member_id) { ?>
                        	<!-- Invite Friend -->            
                        	<li>
                        	<a class="group-invite-friend" href="invite_group_friends.php?group_id=<?php echo $group_id;?>" title="Invite Friends">Invite Friends</a></li>
                    	<?php } ?>
                    	
                    	<?php if($member_id) { ?>
                        	<!-- Leave Group -->            
                        	<li><a class="group-leave" href="action/leave_group.php?group_id=<?php echo $group_id;?>&member_id=<?php echo $member_id;?>">Leave Group</a></li>
                    	<?php } ?>
                    	</ul>
					</div>
					<div style="clear: right;"></div>
			</div>
			<!-- Group Menu -->
							
		<?php //if( $group->approvals=='0' || $isMine || $isMember || $isCommunityAdmin ) { ?>
			<!-- Group Admins -->
			<div id="community-group-admins" class="app-box">
				<div class="app-box-header"><h2 class="app-box-title">Admins</h2></div>
		
					<div class="app-box-content">
							<ul class="cThumbList clrfix">
							<?php
							$admin_sql = mysqli_query($con, "select * from groups g,members m where g.ownerid=m.member_id and id = '$group_id'");
							$admin_count = mysqli_num_rows($admin_sql);
							while($admin_res = mysqli_fetch_array($admin_sql))
							{
							?>
									<li>
											<a href="">
													<img border="0" height="45" width="45" class="avatar" src="<?php echo $admin_res['profImage'];?>" 
                                                    title="<?php echo $admin_res['username'];?>" />
											</a>
									</li>
							<?php
							}
							
							?>
							</ul>
					</div>
					<div class="app-box-footer">
							<a href="">Show All(<?php echo $admin_count;?>)</a>
					</div>
			</div>
			<!-- Group Admins -->
		<?php //} ?>
		
		<?php //if( $group->approvals=='0' || $isMine || $isMember || $isCommunityAdmin ) { ?>
			<!-- Group Members -->
			<div id="community-group-members" class="app-box">
				<div class="app-box-header"><h2 class="app-box-title">Members</h2></div>
		
					<div class="app-box-content">
							<ul class="cThumbList clrfix">
							<?php
							$a = mysqli_query($con, "select * from groups_members g,members m where g.member_id=m.member_id and groupid = '$group_id'");
							$c = mysqli_num_rows($a);
							while($b = mysqli_fetch_array($a))
							{
							?>
									<li>
											<a href="member_profile.php?member_id=<?php echo $b['member_id'];?>" title="<?php echo $b['username'];?>">
													<img border="0" height="45" width="45" class="avatar" src="<?php echo $b['profImage'];?>" alt="" />
											</a>
									</li>
							<?php
							}							
							?>
							</ul>
					</div>
					<div class="app-box-footer">
							<a href="">Show All(<?php echo $c;?>)</a>
					</div>
			</div>
			<!-- Group Members -->
		
		</div>
		<!-- end: .cSidebar -->
		
    
    <!-- begin: .cMain -->
    <div class="cMain clrfix">    
			<div class="group-top">
				<!-- Group Top: Group Left -->
				<div class="group-left">
						<!-- Group Avatar -->
						<div id="community-group-avatar" class="group-avatar">
								<img src="<?php echo $res['avatar'];?>" border="0" alt="" style="width:164px; height:100px;" />
								<!-- Group Buddy -->
								<?php //if( $isAdmin && !$isMine ) { ?>
										<div class="cadmin tag-this" title="">
												
										</div>
								<?php //} else if( $isMine ) { ?>
										<div class="cowner tag-this" title="">
												
										</div>
								<?php //} ?>
								 <!-- Group Buddy -->
						</div>
						<!-- Group Avatar -->   
				</div>
				<!-- Group Top: Group Left -->
				
				<!-- Group Top: Group Main -->
				<div class="group-main">
						
								
						<!-- Group Information -->
						<div id="community-group-info" class="group-info">
								<div class="ctitle">Group Information
										<!-- Group Owner & Admin -->
										<?php //if( $isAdmin && !$isMine ) { ?>
											<!--<span class="cadmin"><span>-->
										<?php //} else if( $isMine ) { ?>
											</span class="cowner"></span>
										<?php //} ?>
										<!-- Group Owner & Admin -->										
								</div>
								
								<div class="cparam group-category">
										<div class="clabel">Category:</div>
										<div class="cdata" id="community-group-data-category">
												<a href=""><?php echo $cat_res['name'];?></a>
										</div>
								</div>
								<div class="cparam group-name">
										<div class="clabel">Name:</div>
										<div class="cdata" id="community-group-data-name">
										<?php echo $res['name'];?>
												<?php
														/*if($group->approvals == COMMUNITY_PRIVATE_GROUP)
														{
																if( $isMine || $isCommunityAdmin )
																{
																		echo '<a href="' . CRoute::_('index.php?option=com_community&view=groups&task=edit&groupid=' . $group->id) . '"> ' . '('. JText::_('CC PRIVATE GROUP') . ')' . '</a>';
																}
																else
																{
																		echo '('. JText::_('CC PRIVATE GROUP') . ')';
																}							
														}*/
												?>									
										</div>
								</div>
								
								<!--<div class="cparam group-description">
										<div class="clabel">Desciption:</div>
										<div class="cdata" id="community-group-data-description"><?php echo $res['description'];?></div>
								</div>-->
								
								<div class="cparam group-created">
										<div class="clabel">Created:</div>
										<div class="cdata"><?php echo date("l, j F Y",$res['created']);?></div>
								</div>            
								<div class="cparam group-owner">
										<div class="clabel">
												Creater:
										</div>
										<div class="cdata">
												<a href="member_profile.php?member_id=<?php echo $member_res['member_id'];?>"><?php echo $member_res['username'];?></a>
										</div>
								</div>
						</div>
						<!-- Group Information -->
						<div style="clear: left;"></div>
				</div>
				
				<!-- Event Top: Event Description -->
				<div class="group-desc">
						<h2>Desciption</h2>
                 <?php echo $res['description'];?>						
				</div>
				<!-- Event Top: Event Description -->
				
				<!-- Group Top: Group Main -->
			</div>
        
        
        <?php //if( $group->approvals=='0' || $isMine || $isMember || $isCommunityAdmin ) { ?>
        
        <!-- Group News -->
        <div id="community-group-news" class="app-box">
            <div class="app-box-header">
            <div class="app-box-header">            
                <h2 class="app-box-title">Announcements</h2>
                <div class="app-box-menus">
                    <div class="app-box-menu toggle">
                        <a class="app-box-menu-icon" href="javascript: void(0)" onclick="">
                            <span class="app-box-menu-title"></span>
                        </a>
                    </div>
                </div>
            </div>                
            </div>
            <div class="app-box-content">
            <?php 
			$nsql = mysqli_query($con, "select * from groups_bulletins g,members m where m.member_id=g.created_by and g.groupid='$group_id'") or die(mysqli_error($con));
			$nrow = mysqli_num_rows($nsql);
			if($nrow > 0)
			{
			while($nres = mysqli_fetch_array($nsql))
			{
			?>  
            
            <div class="group-news-row">
            <div class="groups-news-title"><a href="view_bulletine.php?bulletine_id=<?php echo $nres['id'];?>"><?php echo $nres['title'];?></a></div>
            <div class="groups-news-meta">
            <span><?php echo date("l, j F Y",$nres['date']);?></span>
            <span>by <a href="member_profile.php?member_id=<?php echo $nres['member_id'];?>"><?php echo $nres['username'];?></a></span>
            </div>
            <div class="groups-news-text"><?php echo $nres['message'];?></div>
            </div>
            <?php }
			}
			else
			{
			?>
            <div class="empty">No bulletin added yet</div>
            <?php } ?>
            </div>
            <div class="app-box-footer">
            	<div class="app-box-info"><?php echo "Displaying ".$nrow." of ". $nrow." bulletins";?></div>
                <div class="app-box-actions">
                    <?php //if( $isAdmin || $isSuperAdmin ): ?>
                    <a class="app-box-action" href="add_news.php?group_id=<?php echo $group_id;?>">Create Bulletin</a>
                    <?php //endif; ?>
                    <a class="app-box-action" href="view_all_bulletine.php?group_id=<?php echo $group_id;?>">Show all bulletins</a>
                </div>                
            </div>
        </div>
        <!-- Group News -->    

        <!-- Group Discussion -->
        <?php //if($config->get('creatediscussion')): ?>
        <div id="community-group-dicussion" class="app-box">
            <div class="app-box-header">
            <div class="app-box-header">            
                <h2 class="app-box-title">Discussions</h2>
                <div class="app-box-menus">
                    <div class="app-box-menu toggle">
                        <a class="app-box-menu-icon" href="javascript: void(0)" onclick="joms.apps.toggle('#community-group-dicussion');">
                            <span class="app-box-menu-title"></span>
                        </a>
                    </div>
                </div> 
            </div>
            </div>
            <div class="app-box-content">
            <?php 
			$dsql = mysqli_query($con, "select * from groups_discuss g,members m where m.member_id=g.creator and g.groupid='$group_id'");
			$drow = mysqli_num_rows($dsql);
			if($drow > 0)
			{
			while($dres = mysqli_fetch_array($dsql))
			{
			?>  
            
            <div class="group-discussion">
            <div class="group-discussion-title"><a href="view_discussion.php?discuss_id=<?php echo $dres['id'];?>"><?php echo $dres['title'];?></a>
            <div class="group-discussion-replies"><a href="">0 Replies</a></div>
            </div>
            <div class="groups-news-meta">
            <span><?php echo date("l, j F Y",$dres['created']);?></span>
            <span>by <a href="member_profile.php?member_id=<?php echo $dres['member_id'];?>"><?php echo $dres['username'];?></a></span>
            </div>
            <div class="groups-news-text"><?php echo $dres['message'];?></div>
            </div>
            <?php }
			}
			else
			{
			?>
            <div class="empty">No discussion added yet</div>
            <?php } ?>
            
            </div>
            <div class="app-box-footer">
				<div class="app-box-info"><?php echo "Displaying ".$drow." of ". $drow." bulletins";?></div>
                <div class="app-box-actions">
                    <?php //if( $isMember && !($waitingApproval) || $isSuperAdmin): ?>
					<a class="app-box-action" href="add_discussion.php?group_id=<?php echo $group_id;?>">Create Discussion</a>
                    <?php //endif; ?>
                    <a class="app-box-action" href="view_all_discussion.php?group_id=<?php echo $group_id;?>">Show all discussions</a>
                </div>                
            </div>        
        </div>
        <?php //endif; ?>    
        <!-- Group Discussion -->
        
        <!-- Group Photos -->
        <?php //if($config->get('enablephotos') && $config->get('groupphotos') && $showPhotos): ?>
        <?php //if($this->params->get('groupsPhotosPosition') == 'content'): ?>
        <div id="community-group-photos" class="app-box">
            <div class="app-box-header">
			<div class="app-box-header">    
                <h2 class="app-box-title">Photo Albumns</h2>
                <div class="app-box-menus">
                    <div class="app-box-menu toggle">
                        <a class="app-box-menu-icon" href="javascript: void(0)" onclick="joms.apps.toggle('#community-group-photos');">
                            <span class="app-box-menu-title"></span>
                        </a>
                    </div>
                </div> 
            </div>
            </div>
            <div class="app-box-content">
						<?php
						//if( $albums )
						//{
						?>
						<div class="album-list clrfix">
						<?php //foreach($albums as $album ) { ?>
						<a href=""><img class="avatar jomTips" title="" src="" alt="" /></a>
						<?php //} ?>
						</div>
						
						<?php
						//}
						//else
						//{
						?>
						<div class="empty">No album created yet.</div>
						<?php
						//}
						?>
            </div>
            <div class="app-box-footer">
							<div class="app-box-info">
								 Displaying 0 of 0 albums
							</div>
							
							<div class="app-box-actions">
							<?php
							//if( $allowManagePhotos )
							//{
							//if( $albums )
							//{
							?>
							<a class="app-box-action" href="">
								Create Album
							</a>
							<?php
							//}
							?>
							<!--<a class="app-box-action" href="">
								Create Album
							</a>-->
							<?php 
							//}
							?>
							<a class="app-box-action" href="">
								Show all Albumns
							</a>
							</div>
            </div>
        </div>
        <?php //endif; ?> 
        <?php //endif; ?>    
        <!-- Group Photos -->
        
				<?php //if($config->get('enablevideos') && $config->get('groupvideos') && $showVideos) { ?>
				<?php //if($this->params->get('groupsVideosPosition') == 'content'){ ?>
				<!-- Latest Group Video -->
				<div id="community-group-videos" class="app-box">
					<div class="app-box-header">
						<div class="app-box-header">
							<h2 class="app-box-title">Videos</h2>
							<div class="app-box-menus">
									<div class="app-box-menu toggle">
											<a class="app-box-menu-icon"
												 href="javascript: void(0)"
												 onclick="joms.apps.toggle('#community-group-videos');"><span class="app-box-menu-title"></span></a>
									</div>
							</div>
						</div>
					</div>
						
					<div class="app-box-content">
						<div id="community-group-container">
						<?php //if($videos) { ?>
						<?php //foreach( $videos as $video ) { ?>
						<!--VIDEO ITEMS-->
						<div class="video-items video-item jomTips" id="" title="">
							<!--VIDEO ITEM-->
							<div class="video-item clrfix">
				
									<!--VIDEO THUMB-->
									<div class="video-thumb">
									<a class="video-thumb-url" href="" style="width: px; height:px;">
									<img src="" style="width: px; height:px;" alt="" />
									</a>
									<span class="video-durationHMS"></span>
									</div>
									<!--VIDEO THUMB-->
									
									<!--VIDEO SUMMARY-->
									<div class="video-summary">
										<div class="video-title"><a href=""></a></div>									
										<div class="video-details small">
											<div class="video-hits"></div>
											<div class="video-lastupdated"></div>
											<div class="video-creatorName">
												<a href="">
												
												</a>
											</div>											
										</div>										
									</div>
									<!--VIDEO SUMMARY-->
									
								</div>
								<!--VIDEO ITEM-->
						</div>
						
						<?php //} ?>
						<!--VIDEO ITEMS-->
						
								<div class="clr"></div>
						<?php //} else { ?>
								<div class="empty">There are no videos added yet</div>
						<?php //} ?>
							</div>
						</div>
						
						<div class="app-box-footer">
							<div class="app-box-info">There are no videos added yet</div>
								<div class="app-box-actions">
										<?php
										//if( $allowManageVideos )
										//{
										?>
										<a class="app-box-action" href="javascript:void(0)" onclick="">
										Add video		
										</a>
										<?php 
										//}
										?>
										<a class="app-box-action" href="">
										View all videos
										</a>
								</div>                
						</div> 
				</div>
				<!-- Latest Group Video -->
				<?php //} ?>
				<?php //} ?>
        
        <!-- Group Walls -->
        <div id="community-group-wall" class="app-box group-wall">
            <div class="app-box-header">
            <div class="app-box-header">            
                <h2 class="app-box-title">Wall</h2>
                <div class="app-box-menus">
                    <div class="app-box-menu toggle">
                        <a class="app-box-menu-icon" href="javascript: void(0)" onclick="joms.apps.toggle('#community-group-wall');">
                            <span class="app-box-menu-title"></span>
                        </a>
                    </div>
                </div>            
            </div>
            </div>            
            <div class="app-box-content">
            	<div id="wallForm"></div>
                <div id="wallContent">
                <div><a href="">Older Posts</a>
                 <a href="" style="float:right; bottom:16px;">Recent activities</a>
                </div>
               
                </div>
            </div>
        </div>
        <!-- Group Walls -->
        
        <?php }  //if( $group->approvals == '0' || $isMine || $isMember || $isCommunityAdmin ) ?>
		</div>
		<!-- end: .cMain -->

</div>
<!-- end: .cLayout -->

    
    
	</div><!--End group div-->

</div><!--end column_left div-->
<br />
<div class="column_right">
   <div id="ads" style="width:220; float:left;">
   <h3>Partners
   <a href="add_ads.php" style="margin-left:55px;">Create Ads</a>   
   </h3>
   </div>
		<div style="border-bottom: 1px solid #DDDDDD;float: left;margin: 0px;padding-top: 0px;width: 220px;">
        <div style="font-size: 13px;font-weight: bold;padding: 5px 0;color: #005689;">
        <a href="">ad title goes here</a>
        </div>
        <div style="float: left;padding-right: 8px;">
        <a href="" target="_blank">
        <img src="images/add1_1317138137.jpg"/>
        </a>
        </div>
        <div style="font-size: 12px;padding: 0 5px 5px;line-height: 13px; float:left !important">
        ad body goes here...ad body goes here...ad body goes here...ad body goes here...
        </div>
        <div style="float:left"><img src="images/6.jpg" /></div>
          <div style="float: left;width: 18%;color: #005689;cursor: pointer;position: relative;top: 2px;margin-left: 10px;">Like        </div>
        </div>
        <div style="border-bottom: 1px solid #DDDDDD;float: left;margin: 0px;padding-top: 0px;width: 220px;">
        <div style="font-size: 13px;font-weight: bold;padding: 5px 0;color: #005689;">
        <a href="">ad title goes here</a>
        </div>
        <div style="float: left;padding-right: 8px;">
        <a href="" target="_blank">
        <img src="images/add1_1317138137.jpg"/>
        </a>
        </div>
         <div style="font-size: 12px;padding: 0 5px 5px;line-height: 13px; float:left !important">
        ad body goes here...ad body goes here...ad body goes here...ad body goes here...
        </div>
        <div style="float:left"><img src="images/6.jpg" /></div>
          <div style="float: left;width: 18%;color: #005689;cursor: pointer;position: relative;top: 2px;margin-left: 10px;">Like        </div>
        </div>
        <?php //@readfile('http://output63.rssinclude.com/output?type=php&id=731231&hash=d8599a7081893730dd46d6627357163f')?>
	</div><!--end column_right div-->

</div><!--end mainbody div-->
<?php include 'includes/footer.php';?>
</div><!--end wrapper div-->
</body>
</html>