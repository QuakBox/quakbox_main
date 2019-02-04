<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_misc.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/friends_request_notification.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/view_notification.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_security.php');

$logged_in_member_id_header1 = $_SESSION['SESS_MEMBER_ID'];
$objMemberHeader1 = new member1(); 
$objMisc = new misc(); 
$objFriendsRequest = new friendsRequestNotificationWidget(); 
$objViewNotification = new viewNotificationWidget(); 

$currentMemberResultHeader1=$objMemberHeader1->select_member_byID($logged_in_member_id_header1);
$currentUsername='';
while($clMember = mysqli_fetch_array($currentMemberResultHeader1))
{
	//print_r($clMember);
	$currentUsername=$clMember['username'];	
}

?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $("#notifications_icon").click(function(){
            $.ajax( {
            type : "POST",
            url : "action/see_all_notifications.php"
            });
            
            $("#noti_bubble").hide();
            
        });
    });
</script>






<link href="<?php echo $base_url;?>css/qb_custom_style.css" type="text/css"rel="stylesheet" media="screen"/>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.3.2/css/bootstrap-responsive.css" rel="stylesheet" media="screen" />
        
        <script src="<?php echo $base_url; ?>js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
        <?php include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_script.php'); ?>
 
<ul class="nav navbar-nav ulHeader text-center" style="width: 100%;text-align: center;margin: 0 auto;"> 
     
    <!-- QKass Icon -->
    <li  class="liHeader" style="padding-top: 10px;padding-left: 30px;"  data-toggle="tooltip" title="qkass" data-placement="bottom">
        <a href="<?php echo SITE_URL.'/';?>qcast.php" style="padding:0px;padding-left: 5px;">
            <img  style="height: 20px;width: 20px" src="<?php echo SITE_URL.'/';?>images/ButtonQcast.png" class="header-img"/>
        </a>
    </li>
    

    <!-- Friends Icon -->
     <li  class="liHeader" style="padding-top: 10px;padding-left: 30px;"  data-toggle="tooltip" title="Friends Requests" data-placement="bottom">
        <?php
           $rcquery = "select * from friendlist f,member m 
           where f.member_id = m.member_id AND f.member_id = '".$_SESSION['SESS_MEMBER_ID']."' AND is_unread = 0";
           $rcsql = mysqli_query($con, $rcquery) or die(mysqli_error($con));
           $rcount = mysqli_num_rows($rcsql);
           $friend_request = mysqli_query($con, "select * from friendlist f,member m where m.member_id=f.added_member_id and f.status = 0 and f.member_id = '".$_SESSION['SESS_MEMBER_ID']."'");
           $request_count = mysqli_num_rows($friend_request);
           $ResultMemberProfileLogo = '';
           $ResultMemberProfilePic = '';
           ?>



           <div class="dropdown notification_inline">
                   <a id="notifications"  href="#" class="dropdown-toggle" data-toggle="dropdown" style="background-color:#337ab7">
                   <div id="noti_Container">
                           <img style="height: 20px;width: 20px" alt="Friend Request" src="<?php echo SITE_URL.'/';?>images/header_icons/add-friend.png" />
                            
                           <?php if($request_count > 0){ 
                           echo '<div class="noti_bubble"> <span style="margin-left:0px !important" >'.($request_count>100?"99+":$request_count).'</span> </div>';
                           }?>
                           
</div>
                   </a>
           <ul class="dropdown-menu dropMenu1">
                   <li>
                   <div style="float:right; font-size:15px;"><?php if(isset($_SESSION['lang']))
           {echo nl2br($lang['friend request']);}else{?>Friend Requests<?php }?></div>
                   <div style="font-size:15px;">
                   <a href="<?php echo $base_url;?>find_friend.php" style=""><?php if(isset($_SESSION['lang']))
           {echo nl2br($lang['Search People']);}else{?>Find Friend<?php }?></a></div>
                   </li>
                   <li role="separator" class="divider"></li>
                                   <?php 

           if($request_count > 0){
           ?>      
           <?php 
           while($request_res = mysqli_fetch_array($friend_request))
           {

           $ResultMemberProfileLogo =$objMemberHeader1->select_member_meta_value($request_res['member_id'],'current_profile_image');
           if($ResultMemberProfileLogo){			
           $ResultMemberProfilePic =SITE_URL.'/'.$ResultMemberProfileLogo;	
           }
           else{
           $ResultMemberProfilePic =SITE_URL.'/images/default.png';
           }
           $encryptedMemberID=$QbSecurity->QB_AlphaID($request_res['member_id']);
           ?>
           <li id="mini_prof<?Php echo $encryptedMemberID;?>" style="display:block; margin-bottom:5px;">
           <div style="float:left; width:50px; height:50px; margin-right:8px;">
           <a href="<?php echo $base_url.$request_res['username'];?>" title="<?php echo $request_res['username'];?>"><img src="<?php echo $ResultMemberProfilePic;?>" width="50" height="50"/> </a>
           </div>
           <div style="overflow:hidden;">
           <div class="author"><strong><a href="<?php echo $base_url.$request_res['username'];?>" title="<?php echo $request_res['username'];?>"><?php echo $request_res['username'];?></a></strong>
           </div>
           <div style="float:right" id="friends1<?Php echo $encryptedMemberID;?>">
           <div style="display:inline;"><input type="button" name="accept_request" value="<?Php echo $lang['confirm'];?>" custoMid ="<?Php echo $encryptedMemberID;?>" 
           class="accept_request btn btn-info" 
           onclick="location.href='<?php  echo $base_url."action/accept_request.php?member_id=".$request_res['member_id']; ?>';"></div>
           <div style="display:inline;"><input type="button" name="cancel_request" value="<?Php echo $lang['not now'];?>" custoMid ="<?Php echo $encryptedMemberID;?>" class="cancel_request btn btn-danger"></div>
           </div>
           <div style="display:none; float:right" id="friends<?Php echo $encryptedMemberID;?>">
           <input type="button" name="accept_request" value="Friends" class="friends btn btn-success">
           </div>

           </div>

           </li>
           <li role="separator" class="divider"></li>
           <?php } ?> 

           <?php }
           else {?>
           <div class="community-empty-list"> <?php echo $lang['No new Request'];?></div>
           <li role="separator" class="divider"></li>
           <?php } ?>




                           <li><a href="<?php echo $base_url;?>friends/<?php echo $currentUsername;?>">
           <?php if(isset($_SESSION['lang']))
           {echo nl2br($lang['Show all']);}else{?>Show All Friends<?php }?>
           </a></li>
                   </ul> <!-- / .dropdown-menu -->
           </div>     
     </li>
     
    
    <!-- Notification Icon -->
    <li class="liHeader" style="padding-top: 10px; padding-left: 30px;"  data-toggle="tooltip" title="Notifications" data-placement="bottom">
        <?php 
            $ncquery = "SELECT * FROM notifications n LEFT JOIN member m ON m.member_id = n.sender_id
                            WHERE n.is_unread = 0 AND received_id = '".$_SESSION['SESS_MEMBER_ID']."'  ORDER BY id DESC";
            $ncsql = mysqli_query($con, $ncquery) or die(mysqli_error($con));
            $ncount = mysqli_num_rows($ncsql);
        ?>	
        
<div class="dropdown" id="notifications_icon">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="background-color:#337ab7;">
        <div id="noti_Container">
            <img style="height: 20px; width: 20px;" class="media-object" alt="Notification" src="<?php echo SITE_URL.'/';?>images/header_icons/notification.png" />
            <?php if($ncount > 0){ echo '<div id="noti_bubble" class="noti_bubble"> <span style="margin-left:0px !important" >'.($ncount>100?"99+":$ncount).'</span> </div>';}?>
        </div>
    </a>
    <!-- Notifications Menu Drop down -->
    <ul class="dropdown-menu dropMenu1">
    <li>
    <div style="font-size:15px;"><?php if(isset($_SESSION['lang']))
    {echo $lang['Notifications'];}else{?>Notifications<?php }?></div>
                                                                    </li>
                                                                    <li role="separator" class="divider"></li>

            <?php 
              $nquery = "SELECT * FROM notifications n 
              LEFT JOIN member m ON m.member_id = n.sender_id 
              WHERE received_id = '".$_SESSION['SESS_MEMBER_ID']."'
              ORDER BY id DESC LIMIT 5";
              $nsql = mysqli_query($con, $nquery);
              $NotificationMemberProfileLogo='';
              $NotificationMemberProfilePic='';

              if(mysqli_num_rows($nsql) > 0)
              {
                      ?>




          <?php 

              while($nres = mysqli_fetch_array($nsql))
              {



                      $NotificationMemberProfileLogo =$objMemberHeader1->select_member_meta_value($nres['member_id'],'current_profile_image');
    if($NotificationMemberProfileLogo){			
                    $NotificationMemberProfilePic =SITE_URL.'/'.$NotificationMemberProfileLogo;	
    }
    else{
            $NotificationMemberProfilePic =SITE_URL.'/images/default.png';
    }
                      $receiver_id = $nres['received_id'];
                      $rmquery = mysqli_query($con, "SELECT username, member_id FROM member WHERE member_id = '$receiver_id'");
                      $rmres = mysqli_fetch_array($rmquery);

            //Edited by Mushira Ahmad--Check for different types of notifications
            if ($nres['type_of_notifications']==30)
                    $append_notid="?notid=".$nres['id'];
            else
            if ($nres['type_of_notifications']==37)
                    $append_notid="?notid=".$nres['id'];
            else
                    $append_notid="&notid=".$nres['id'];
             //End of handling different types of notifications
              ?>

            <li class="notili" id="<?php echo $nres['id'];?>">
            <a href="<?php echo $base_url.$nres['href'].$append_notid;?>" style="display:block; padding: 7px 27px 7px 8px;">
            <div style="float:left; width:50px; height:50px; margin-right:8px;">
            <img src="<?php echo $NotificationMemberProfilePic;?>" width="50" height="50"/> 
            </div>
            <div>
            <div><strong><?php echo $nres['username'];?></strong>

                    <?php echo $nres['title']; ?>














            </div> 
            <div><span style="color:gray;"><?php echo time_stamp($nres['date_created']);?></span></div>

            </div>
            </a>
            </li>
            <li role="separator" class="divider"></li>
          <?php } 	 

              ?>


          <?php } 
              else
              {
              ?>
          <div class="community-empty-list"><?php echo $lang['No notifications'];?></div><li role="separator" class="divider"></li><?php } ?>



                                                                            <li><a href="<?php echo $base_url;?>notifications.php">
          <?php if(isset($_SESSION['lang']))
    {echo $lang['see all'];}else{?>See All<?php }?></a></li>
                                                                    </ul> 
    
    <!-- / .dropdown-menu -->
            </div>
    </li>
   
    
    <!-- Messages Icon -->
    <li  class="liHeader" style="padding-top: 10px; padding-left: 30px;"  data-toggle="tooltip" title="Messages" data-placement="bottom">
        <?php
            $mcquery = mysqli_query($con, "SELECT id FROM cometchat WHERE cometchat.to = '".$_SESSION['SESS_MEMBER_ID']."' AND cometchat.read != 1") or die(mysqli_error($con));
            $mcount = mysqli_num_rows($mcquery);
            /*$msg_sql = mysqli_query($con, "select * from messages msg, members m where msg.msg_from=m.member_id and msg.parent='".$_SESSION['SESS_MEMBER_ID']."'") or die(mysqli_error($con));
            $msg_count = mysqli_num_rows($msg_sql);*/
            ?>




            <div class="dropdown notification_inline">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="background-color:#337ab7">
                   <div id="noti_Container">
                    <img style="height: 20px;width: 20px;" class="media-object" alt="Messages" src="<?php echo SITE_URL.'/';?>images/header_icons/messages.png" />
            <?php if($mcount > 0){ 
                echo '<div class="noti_bubble"> <span style="margin-left:0px !important" >'.($mcount>100?"99+":$mcount).'</span> </div>';
            }?>
</div>
            </a>

            <!-- MESSAGES -->
            <ul class="dropdown-menu dropMenu1" >
            <li padding-left: 10px;>
                <div style="float:right; font-size:15px;"><?php if(isset($_SESSION['lang']))
    {echo $lang['inbox'];}else{?>Inbox<?php }?></div>
		<div style="font-size:15px;"><a href="<?php echo $base_url;?>write_message.php">
        <?php if(isset($_SESSION['lang']))
    {echo $lang['send a new message'];}else{?>Send a New Message<?php }?>
        </a></div>
		</li>
		<li role="separator" class="divider"></li>
        			<?php 
	 $msg_query = "SELECT SQL_CALC_FOUND_ROWS
       u.member_id ,
       i.from,
       i.to,
       u.username ,
       i.sent,
       i.message
    FROM cometchat AS i,
         member  AS u,
         (SELECT MAX(id) AS id_max,
                 id_with
              FROM (
                    SELECT id,
                           c.from AS id_with
                        FROM cometchat c
                        WHERE c.to = '".$_SESSION['SESS_MEMBER_ID']."'
                    UNION ALL
                    SELECT id,
                           o.to
                        FROM cometchat o
                        WHERE o.from = '".$_SESSION['SESS_MEMBER_ID']."'
                   ) AS t
              GROUP BY id_with) AS m
    WHERE i.id  = m.id_max
      AND u.member_id = m.id_with
    ORDER BY i.id DESC LIMIT 5";
			 $msg_sql = mysqli_query($con, $msg_query) or die(mysqli_error($con));
		$msg_count = mysqli_num_rows($msg_sql);
		$MessageMemberProfileLogo='';
		$MessageMemberProfilePic='';
		if($msg_count > 0)
		{
		?>
        <?php
		while($msg_res = mysqli_fetch_array($msg_sql))
		{	
		
		$MessageMemberProfileLogo =$objMemberHeader1->select_member_meta_value($msg_res['member_id'],'current_profile_image');
if($MessageMemberProfileLogo){			
		$MessageMemberProfilePic =SITE_URL.'/'.$MessageMemberProfileLogo;	
}
else{
	$MessageMemberProfilePic =SITE_URL.'/images/default.png';
}  
	  ?>
		<li style="display:block; margin-bottom:5px;">
        <a href="<?php echo $base_url.'messages.php?username='.$msg_res['member_id'];?>">
        <div style="float:left; width:50px; height:50px; margin-right:8px;">
        <img src="<?php echo $MessageMemberProfilePic;?>" width="50" height="50"/> 
        </div>
        <div style="overflow:hidden;">
        <div class="author"><strong><?php echo $msg_res['username'];?></strong>
        </div> 
        <div style="overflow: hidden;text-overflow: ellipsis;white-space: nowrap;"><span style="color:gray;">
        <?php if($msg_res['from'] == $_SESSION['SESS_MEMBER_ID'] && $msg_res['to'] == $msg_res['member_id']){?>
<img src='<?php echo $base_url;?>images/send.png'  class='con_send'/>	
<?php }
         echo $msg_res['message'];?></span></div>
        
        </div>
        <div><span style="color:gray;"><?php echo time_stamp($msg_res['sent']);?></span></div>
        </a>
        </li>
        <li role="separator" class="divider"></li>
        <?php } 				
		 } else { ?>
	   <div class="community-empty-list"><?php echo $lang['No New Message']?></div><li role="separator" class="divider"></li><?php } ?>
										
									

									
									<li><a href="<?php echo $base_url;?>messages.php">
	     <?php if(isset($_SESSION['lang']))
{echo $lang['view all my messages'];}else{?> View All My Messages<?php }?>
	    </a></li>
								</ul> <!-- / .dropdown-menu -->
							</div>

  
    </li>
    
    
    
        
   <!-- Search bar-->
    <li class="liHeader" style="padding-top: 10px; padding-left: 30px;">
    
              <form>
                     <input class="hidden-md-down visible-lg visible-xl form-control search" style="height: 25px;width: 300px; padding-bottom: 10px;" role="search" type="text" name="search" value="" placeholder="<?php echo $lang['search'];?>" autocomplete="off">
             </form>
             
        <div  id="divResult" class="hidden-sm hidden-xs visible-lg visible-xl dropdown" style="background-color: white;margin-left: 40px;"> </div>
        
         
  </li> 
  
  
</ul>

<style >
#noti_Container {
    position:relative;     /* This is crucial for the absolutely positioned element */
    /*border:1px solid blue;*/ /* This is just to show you where the container ends */
    width:16px;
    height:16px;
}
.noti_bubble {
    position:absolute;    /* This breaks the div from the normal HTML document. */
    top: -6px;
    right:-6px;
    padding:1px 2px 1px 2px;
    background-color:red; /* you could use a background image if you'd like as well */
    color:white;
    font-weight:bold;
    font-size:0.55em;

    /* The following is CSS3, but isn't crucial for this technique to work. */
    /* Keep in mind that if a browser doesn't support CSS3, it's fine! They just won't have rounded borders and won't have a box shadow effect. */
    /* You can always use a background image to produce the same effect if you want to, and you can use both together so browsers without CSS3 still have the rounded/shadow look. */
    border-radius:30px;
    box-shadow:1px 1px 1px gray;
}
</style>							