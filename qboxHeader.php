
<div id="header">
<div id="hedaer-inner">
    <div class="loggedout_menubar">
        <div class="lfloat">
        <a href="<?php echo $base_url;?>qcast.php" title="<?php echo $lang['Welcome to quakbox'];?>">
        <i class="qb_logo"></i>
        </a>        
        </div>
        
        <div id="loginBtn" class="loginBtn">
        <a href="<?php echo $base_url.'login.php?back='.urlencode($_SERVER['REQUEST_URI']); ?>"><input type="submit" value="<?php echo $lang['Log In'];?>" class="btn-success qbLogBtn" id="loginbuttonwa" style="margin-top: 10px; margin-left: 100px;" /></a>
        </div>
        
        
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
                      <a href="<?php echo $base_url;?>mob_messages.php">
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
                      <a href="<?php echo $base_url;?>create_country-mob.php">
                          <i class="fa fa-star inbox-started"></i>
                          <span>Favourite country</span>
                      </a>
                  </li>
                  
                  <li>
                      <a href="<?php echo $base_url;?>qcast.php">
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
                      <a href="<?php echo $base_url;?>mob_my_event.php">
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
