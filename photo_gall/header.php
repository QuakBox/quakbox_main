<?php

require_once('../includes/time_stamp.php');

$smsql = mysqli_query($con, "select * from members where member_id = '".$_SESSION['SESS_MEMBER_ID']."'");

$smres = mysqli_fetch_array($smsql);

?>

<script src="<?php echo $base_url;?>js/menu.js"></script>

<script src="<?php echo $base_url;?>js/notification.js"></script>
<script src="<?php echo $base_url;?>js/jquery.nicescroll.min.js"></script>
<link href="<?php echo $base_url;?>css/portBox.css" rel="stylesheet" />
<script src="<?php echo $base_url;?>js/portBox.slimscroll.min.js"></script>
<div id="header">

<div id="hedaer-inner">

    <div class="loggedout_menubar">

        <div class="lfloat">

        <a href="<?php echo $base_url;?>mywall.php" title="Welcome to quakbox">

        <i class="qb_logo"></i>

        </a>        

        </div>

        <!--start div image_links-->

        <div class="image_links">

		<ul>

        <li>       

        <a href="<?php echo $base_url;?>mywall.php"><img src="<?php echo $base_url;?>images/wall.png" class="header-img"/><span class="header-label"><?php echo ucfirst($smres['username']);?></span></a>

        </li>

        <?php 

	$coun = mysqli_query($con, "select * from geo_country where country_id!=207 order by rand() LIMIT 3")or die(mysqli_error($con));	

	//echo $flag['code'];	

	?>

        <li>

		<div style="width:147px; height:40px;">



		<?php



		while($flag = mysqli_fetch_array($coun))

	 	{

			$file = $base_url."images/Flags/flags_new/30x20flags/".strtolower($flag['code']).".png";

			?>

				

				<a href="<?php echo $base_url;?>country_wall.php?country=<?php echo $flag['country_title'];?>" >

				<div class="flag_display" style="margin-bottom:0px; line-height:150%;">

                <img src="<?php echo $file; ?>" height="21" width="35" style="min-height:18px;"/>

                <font color="#FFFFFF"><?php echo substr($flag['country_title'],0,6);?></font>

                </div>

                </a>

<?php } ?>

		</div>

        

		<a class="connect_click" style="color:#FFF; text-align:center; font-weight:bold;">CONNECT</a>

		 

		<div class="country_more" style="display:none;width:auto; position:absolute;z-index:100; max-height:500px;

		background-color:#FFFFFF;color:#FFF;">

		<div style="overflow-y:scroll; max-height:inherit;">

	<?php 

	$country_sql = mysqli_query($con, "select * from geo_country where country_id!=207 order by country_id ")or die(mysqli_error($con));	

	//echo $flag['code'];

	

	$iMaxCols=6;

	$rowscount = mysqli_num_rows($country_sql);	

	if($rowscount > 0)

	{

	?>

    <table>

		<tbody>

		<?php 

		$iPos=0;

		for($i=0;$i<$rowscount;$i++)

		{

			$country_res = mysqli_fetch_array($country_sql);

			$country_name1 = str_replace(' ', '-', $country_res['country_title']);

			if ($iPos == 0){ echo "\n<tr>"; }

			$iPos++;

			echo '<td>';

			$file = $base_url."images/Flags/flags_new/50x50flags/".strtolower($country_res['code']).".png";

		?>

		<div class="imageContainer" style="text-align:center; margin:0px; width:80px; border:2px solid; height:80px; margin-top:5px;" >

		<div class="image" title="<?php echo $file; ?>">

		<a style="text-decoration:none;color:#000000;" href="<?php echo $base_url;?>country_wall.php?country=<?php echo $country_name1; ?>" >

		<div id="<?php echo $file; ?>" style="display:none; background:url(<?php echo $file; ?>) no-repeat ;

		height:80px;width:80px; position:absolute; background-size:80px 80px;">

		

		</div>

		<img src="<?php echo $file; ?>" height="50" width="50"/><br />

		<label style="font-size: 14px; margin-top:20px; color:#000000;"><?php echo substr($country_res['country_title'],0,6);  ?></label>

		</a>

		

		</div>

		</div>	

		</td>

      			

		<?php

	 

	 if ($iPos >= $iMaxCols){

                echo "\n</tr>";

                $iPos=0;

            }

        } //end-for

	if ($iPos > 0 && $iPos < $iMaxCols){

           for ($i=$iPos; $i<$iMaxCols; $i++){echo "<td>&nbsp;</td>";}

           echo "\n</tr>";

        }

        

        echo "\n</table>";

    } //end-if ($iTotalOther > 0)

?>		



</tbody>



</table>

	</div></div>

	

			</li>

       

        <li>

		<a href="<?php echo $base_url;?>video_gallery.php"><img src="<?php echo $base_url;?>images/video_down_32.png" class="header-img"/><span class="header-label">QBOX</span></a></li>

        

        <li>

       <div id="admin"><div id="search-icon"></div></div>

       <div id="search-menu">

			    <div id="arrow"></div>

			      <input class="search" type="text" name="search" value="" placeholder="search" autocomplete="off"/>

  		  </div>

             

      <div id="divResult"></div>

       </li>

        </ul>

        </div>

        <!--end div image_links-->

        

        <!--start div settings-->

        <div id="admin"><div id="settings" class="fa fa-cog"></div></div>

        <div id="menu">

			    <div id="arrow"></div>

			      <a href="<?php echo $base_url;?>profile.php">Profile <i id="firstIcon" class="fa fa-user"></i></a>

			      <a href="<?php echo $base_url;?>account_settings.php">Account Settings <i id="secondIcon" class="fa fa-gears"></i></a>

			      <a href="<?php echo $base_url;?>privacy.php">Privacy Settings <i id="thirdIcon" class="fa fa-unlock-alt"></i></a>

			      <a href="<?php echo $base_url;?>logout.php">Logout <i id="fourthIcon" class="fa fa-power-off"></i></a>

  		  </div>

        <!--end div settings-->

        

        <!--start div notification-->

        <div class="notification">

        

<?php

$rcquery = "select * from friendlist f,members m 

where f.member_id = m.member_id AND f.member_id = '".$_SESSION['SESS_MEMBER_ID']."' AND is_unread = 0";

$rcsql = mysqli_query($con, $rcquery) or die(mysqli_error($con));

$rcount = mysqli_num_rows($rcsql);



 

$friend_request = mysqli_query($con, "select * from friendlist f,members m where m.member_id=f.added_member_id and f.status = 0 and f.member_id = '".$_SESSION['SESS_MEMBER_ID']."'");

$request_count = mysqli_num_rows($friend_request);



?>

	<div class="notifi" id="friendreq">

        <div class="request">

		<a title="Friendship Requests" id="notifi_request" onclick="notification('','submenu1')" style="display:block;width:20px;height:20px;text-decoration:none;" href="javascript:void(0)">	

        <div class="alert" id="request_count_wrapper"><span class="laers" id="request_count_value">

		<?php if($rcount > 0){ echo $rcount;}?></span></div></a>

        </div>

        <div class="submenu1" id="submenu1"  style="display: none;" >

        <div class="beeperNub"></div>

        <div style="padding:5px;">
        <div>
        <div style="float:right; font-size:11px;"><a href="<?php echo $base_url;?>find_friend.php" style="color:#FFF;"><?php if(isset($_SESSION['lang']))
{echo nl2br($lang['Search People']);}else{?>Find Friend<?php }?></a></div>
        <div style="font-size:11px;"><?php if(isset($_SESSION['lang']))
{echo nl2br($lang['friend request']);}else{?>Friend Requests<?php }?></div>
        </div>
        </div>

        <?php 

		 if($request_count > 0){

		?>

        <ul class="root" id="request-post">        

        <?php 

			while($request_res = mysqli_fetch_array($friend_request))

			{

			?>

            <li style="display:block; margin-bottom:5px;">

            <div style="float:left; width:50px; height:50px; margin-right:8px;">

        <a href="<?php echo $base_url.$request_res['username'];?>" title="<?php echo $request_res['username'];?>"><img src="<?php echo $base_url.$request_res['profImage'];?>" width="50" height="50"/> </a>

        </div>

        <div style="overflow:hidden;">

        <div class="author"><strong><a href="<?php echo $base_url.$request_res['username'];?>" title="<?php echo $request_res['username'];?>"><?php echo $request_res['FirstName'];?></a></strong>

        </div>

        <div style="float:right" id="friends1">

        <div style="display:inline;"><input type="button" name="accept_request" value="Confirm" id="<?Php echo $request_res['member_id'];?>" 

        class="accept_request"></div>

        <div style="display:inline;"><input type="button" name="cancel_request" value="Not Now" id="<?Php echo $request_res['member_id'];?>" class="cancel_request"></div>

        </div>

        <div style="display:none; float:right" id="friends">

        <input type="button" name="accept_request" value="Friends" class="friends">

        </div>

       

        </div>

	      <!--<a href="request.php" class="request_div" style="color:#FFF;"><?php echo $request_count;?> New Request</a>-->

          </li>

          <?php } ?> 

          </ul>

          <?php }

		  else {?>

        <div class="community-empty-list" >No new Request</div><?php } ?>





	      <div class="community-empty-list" style="padding:5px;"><a href="<?php echo $base_url;?>friends.php?friend_id=<?php echo $_SESSION['SESS_MEMBER_ID'];?>" style="color:#FFF;">Show All Friends</a></div>

	 

	</div>

       </div>

       

    <div class="notifi">

     <?php

	 $mcquery = mysqli_query($con, "SELECT id FROM cometchat WHERE cometchat.to = '".$_SESSION['SESS_MEMBER_ID']."' AND cometchat.read != 1") or die(mysqli_error($con));

	$mcount = mysqli_num_rows($mcquery);

	 

	  

	  	/*$msg_sql = mysql_query("select * from messages msg, members m where msg.msg_from=m.member_id and msg.parent='".$_SESSION['SESS_MEMBER_ID']."'") or die(mysql_error());

		$msg_count = mysql_num_rows($msg_sql);*/

		?>

        <div class="contact">

		<a title="Messages" id="notifi_msg" onclick="notification1('','submenu2')" style="display:block;width:20px;height:20px;text-decoration:none;" href="javascript:void(0)">		

        <div class="alert" id="msg_count_wrapper"><span class="laers" id="msg_count_value">

		<?php if($mcount > 0){ echo $mcount;}?></span></div></a>

        </div>

        <div class="submenu2" id="submenu2"  style="display: none;">

        <div class="beeperNub"></div>

	  <div style="padding:5px">

        <div>

        <div style="float:right; font-size:11px;">Inbox</div>

        <div style="font-size:11px;"><a href="<?php echo $base_url;?>write_message.php" style="color:#FFF;">Send a New Message</a></div>

        </div>

        </div>

           

      <?php 

	  	$msg_sql = mysqli_query($con, "select distinct msg.from ,m.username, msg.read,m.profImage,m.member_id,

		     msg.message,msg.sent,count(*)

		     from cometchat msg, members m	 	     

			 WHERE 

			 CASE

			 WHEN msg.to = '".$_SESSION['SESS_MEMBER_ID']."'

			 THEN msg.from = m.member_id

			 WHEN msg.from = '".$_SESSION['SESS_MEMBER_ID']."'

			 THEN msg.to = m.member_id

			 END

			 AND

			 (msg.from ='".$_SESSION['SESS_MEMBER_ID']."' OR msg.to ='".$_SESSION['SESS_MEMBER_ID']."')

			 GROUP BY m.member_id ORDER BY msg.sent desc LIMIT 5") or die(mysqli_error($con));

		$msg_count = mysqli_num_rows($msg_sql);

		if($msg_count > 0)

		{

		?>

        <ul class="root" style="padding-top:5px;" id="message-post"> 

        <?php

		while($msg_res = mysqli_fetch_array($msg_sql))

		{	  

	  ?>

		<li style="display:block; margin-bottom:5px;">
        <a href="<?php echo $base_url.'messages.php?username='.$msg_res['member_id'];?>">
        <div style="float:left; width:50px; height:50px; margin-right:8px;">
        <img src="<?php echo $base_url.$msg_res['profImage'];?>" width="50" height="50"/> 
        </div>
        <div style="overflow:hidden;">
        <div class="author"><strong><?php echo $msg_res['username'];?></strong>
        </div> 
        <div style="overflow: hidden;text-overflow: ellipsis;white-space: nowrap;"><span style="color:gray;"><?php echo $msg_res['message'];?></span></div>
        
        </div>
        </a>
        </li>

        <?php } 				

		?>

		</ul>

        <?Php } else { ?>

	   <div class="community-empty-list">No New Message</div><?php } ?>

	     <div class="community-empty-list" style="padding:5px;"> <a href="<?php echo $base_url;?>messages.php" style="color:#FFF;">View All My Messages</a></div>	   

	</div>   

        

       </div>

       

     <div class="notifi">

        <div class="notify">

         <?php 

	  $ncquery = "SELECT * FROM notifications n LEFT JOIN members m ON m.member_id = n.sender_id

	  			WHERE n.is_unread = 0 AND received_id = '".$_SESSION['SESS_MEMBER_ID']."'  ORDER BY id DESC LIMIT 5";

	  $ncsql = mysqli_query($con, $ncquery) or die(mysqli_error($con));

	  $ncount = mysqli_num_rows($ncsql);

	  ?>

		<a title="Notification" id="notifi_count" onclick="notification2('','wallidid')" style="display:block;width:20px;height:20px;text-decoration:none;" href="javascript:void(0)">		

        <div id="notifi_count_wrapper" class="alert"><span id="notifi_count_value" class="laers">

		<?php if($ncount > 0){ echo $ncount;}?></span></div></a>

        </div>

        

        <div id="wallidid">

        <div class="beeperNub"></div>

        

        <div style="padding:5px">

        <div>        

        <div style="font-size:11px;">Notifications</div>

        </div>

        </div>

        

        <?php 

	  $nquery = "SELECT * FROM notifications n 

	  LEFT JOIN members m ON m.member_id = n.sender_id 

	  WHERE received_id = '".$_SESSION['SESS_MEMBER_ID']."'

	  ORDER BY id DESC LIMIT 5";

	  $nsql = mysqli_query($con, $nquery);

	  

	  if(mysqli_num_rows($nsql) > 0)

	  {

		  ?>

          

        

	  <ul class="root" id="notifi-post">

      

      <?php 

	  

	  while($nres = mysqli_fetch_array($nsql))

	  {

		  $receiver_id = $nres['received_id'];

		  $rmquery = mysqli_query($con, "SELECT username, member_id FROM members WHERE member_id = '$receiver_id'");

		  $rmres = mysqli_fetch_array($rmquery);

		  

	  ?>

		

        <li class="notili" id="<?php echo $nres['id'];?>">

        <a href="<?php echo $base_url.$nres['href'];?>" style="display:block; color:#FFFFFF; font-size:11px; padding: 7px 27px 7px 8px;">

        <div style="float:left; width:50px; height:50px; margin-right:8px;">

        <img src="<?php echo $base_url.$nres['profImage'];?>" width="50" height="50"/> 

        </div>

        <div style="overflow:hidden;">

        <div><strong><?php echo $nres['username'];?></strong>

        

         <?php 

        if($nres['type_of_notifications'] == 1)

		{

		?>

		<span>likes</span>        

         <?php 

		if($rmres['member_id'] != $member_id)

		{

		

		

		echo $rmres['username'];

		

		

		?>'s

        

        <?php

		}

        else

		{

			echo 'your';

		}

		?>

        status

		<?php

		}

        else if($nres['type_of_notifications'] == 2)

		{

		?>

        <span>commented on</span>        

         <?php 

		if($rmres['member_id'] != $member_id)

		{		

			echo $rmres['username'];		

		?>'s

        

        <?php

		}

        else

		{

			echo 'your';

		}

		?>

        status

        <?php } 

		else if($nres['type_of_notifications'] == 3)

		{

		?>

		<span>commented on</span>        

         <?php 

		if($rmres['member_id'] != $member_id)

		{

		

		

		echo $rmres['username'];

		

		

		?>'s

        

        <?php

		}

        else

		{

			echo 'your';

		}

		?>status

        <?php } 

		else if($nres['type_of_notifications'] == 4)

		{

		?>

		<span>invited you to join</span>        

        <strong><?php echo $nres['title'];?></strong>

		<?php } 

		else if($nres['type_of_notifications'] == 5)

		{

		?>

		<span>added you to the group</span>        

        <strong><?php echo $nres['title'];?></strong>

		<?php } 

		 else if($nres['type_of_notifications'] == 6)

		{

		?>

		<span> invited you to join event</span>        

        <strong><?php echo $nres['title'];?><strong>

		<?php } 

		 else if($nres['type_of_notifications'] == 7)

		{

		?>

		<span>Accepted your request</span>                

        <?php }

		?>

	

        

        </div> 

        <div><span style="color:gray;"><?php echo time_stamp($nres['date_created']);?></span></div>

        

        </div>

        </a>

        </li>

        

      <?php } 	 

	  

	  ?>

        	   

	  </ul>

      <?php } 

	  else

	  {

	  ?>

      <div class="community-empty-list">No notifications</div><?php } ?>

      <div class="community-empty-list" style="padding:5px;"> <a href="<?php echo $base_url;?>notifications.php" style="color:#FFF;">See All</a></div>	   

     

	</div> 

       </div>

        

		</div>

        <!--end div notification-->

        

        <!--start div flag_mod-->

        <div id="flag_mod">

       <table>

       <tr>

		<?php 

		$fav = mysqli_query($con, "select c.code,c.country_title from favourite_country f,geo_country c where f.code=c.code and f.favourite_country=1 and member_id = '".$_SESSION['SESS_MEMBER_ID']."'");

		while($fav_res = mysqli_fetch_array($fav))

		{

			$country_name = str_replace(' ', '-', $fav_res['country_title']);

			

		?>

        <td>

        <div class="flag_display">

        <a href="<?php echo $base_url;?>country_wall.php?country=<?php echo $country_name;?>" style="color:#FFF;">

		<img src="<?php echo $base_url."images/Flags/flags_new/30x20flags/".strtolower($fav_res['code']).".png";?>" height="20" width="30"/>

        <br/><?php $a = strtoupper($fav_res['country_title']); echo substr($a,0,6); 

		} ?>

        </a>        

      </div>

      </td>

      </tr>

      </table>

      <span id="flag-fav">

        MY FAVOURITE COUNTRIES</span>      

        </div>

        <!--end div flag_mod-->

        

        <!--end div globe-->

        <div id="globe">

        <a href="<?php echo $homepage;?>">

			<img src="<?php echo $base_url;?>images/ww50x50.gif"/>

			<p>WORLD</p>

         </a>

		</div>

        <!--end div globe-->

        

    </div>    

    </div>

</div>

<script>



$(function() {

	function responsiveView() {

            var wSize = $(window).width();

            if (wSize <= 768) {                

                $('#sidebar > ul').hide();

				$('#sidebar').hide();

            }



            if (wSize > 768) {                

                $('#sidebar > ul').hide();

				$('#sidebar').hide();

				$('#mainbody').css({

                'margin-left': 'auto'

            });

            }

        }

        $(window).on('load', responsiveView);

        $(window).on('resize', responsiveView);

$('.fa-bars').click(function () {

        if ($('#sidebar > ul').is(":visible") === true) {

            $('#mainbody').css({

                'margin-left': '0px'

            });

            $('#sidebar').css({

                'margin-left': '-210px'

            });

			$('#sidebar').hide();

            $('#sidebar > ul').hide();

            $("#wrapper").addClass("sidebar-closed");

        } else {

            $('#mainbody').css({

                'margin-left': '210px'

            });

			$('#sidebar').show();

            $('#sidebar > ul').show();			

            $('#sidebar').css({

                'margin-left': '0'

            });

            $("#wrapper").removeClass("sidebar-closed");

        }

    });

});

</script>

<div class="header-mob">

<div class="sidebar-toggle-box">

<div class="fa-bars fa"></div>

</div>

<a class="logo" href="<?php echo $base_url;?>home.php"><img src="<?php echo $base_url;?>images/quack-mob.png"></a>

</div>



<aside>

          <div id="sidebar"  class="nav-collapse ">

              <!-- sidebar menu start-->

              <ul class="sidebar-menu" id="nav-accordion" style="display:none;">

                  <li>

                      <a href="<?php echo $base_url;?>home.php">

                          <i class="fa fa-dashboard"></i>

                          <span>Home</span>

                      </a>

                  </li>

                  

                  <li>

                      <a href="<?php echo $base_url;?>mywall.php">

                          <i class="fa fa-user"></i>

                          <span><?php echo $smres['username'];?></span>

                      </a>

                  </li>

                  

                  <li>

                      <a href="<?php echo $base_url;?>messages.php">

                          <i class="fa fa-envelope-o"></i>

                          <span>Messages</span>

                      </a>

                  </li>

                  

                  <li>

                      <a href="<?php echo $base_url;?>friends.php?friend_id=<?php echo $_SESSION['SESS_MEMBER_ID'];?>">

                          <i class="fa fa-users"></i>

                          <span>Friends</span>

                      </a>

                  </li>

                  

                  <li>

                      <a href="<?php echo $base_url;?>latest_members.php">

                          <i class="fa fa-users"></i>

                          <span>Latest members</span>

                      </a>

                  </li>

                  

                  <li>

                      <a href="<?php echo $base_url;?>create_country.php">

                          <i class="fa fa-star inbox-started"></i>

                          <span>Favourite country</span>

                      </a>

                  </li>

                  

                  <li>

                      <a href="<?php echo $base_url;?>video_gallery.php">

                          <i class="fa fa-video-camera"></i>

                          <span>QBox</span>

                      </a>

                  </li>

                  

                  <li>

                      <a href="<?php echo $base_url.'photos/'.$username;?>">

                          <i class="fa fa-camera"></i>

                          <span>My Photos</span>

                      </a>

                  </li>

                  

                  <li>

                      <a href="<?php echo $base_url.'videos/'.$username;?>">

                          <i class="fa fa-video-camera"></i>

                          <span>My Videos</span>

                      </a>

                  </li>

                  

                  <li>

                      <a href="<?php echo $base_url;?>create_event.php">

                          <i class="fa fa-calendar"></i>

                          <span>My Events</span>

                      </a>

                  </li>

                  

                  <li>

                      <a href="<?php echo $base_url;?>account_settings.php">

                          <i class="fa fa-cog"></i>

                          <span>Settings</span>

                      </a>

                  </li>

                  

                  <li>

                      <a  href="<?php echo $base_url;?>logout.php">

                          <i class="fa fa-power-off"></i>

                          <span>Logout</span>

                      </a>

                  </li>



              </ul>

              <!-- sidebar menu end-->

          </div>

      </aside>