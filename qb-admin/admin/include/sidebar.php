<div class="container-fluid">
		<div class="row-fluid">
				
			<!-- left menu starts -->
			<div class="span2 main-menu-span">
				<div class="well nav-collapse sidebar-nav">
					<ul class="nav nav-tabs nav-stacked main-menu">
						<li class="nav-header hidden-tablet">Main</li>
						<li><a class="ajax-link" href="index.php"><i class="icon-home"></i><span class="hidden-tablet"> Home</span></a></li>
						
						<?php if( AccessLevel::getInstance()->isSuperAdmin() ):?>
						<li><a class="ajax-link" href="member_table.php"><i class="icon-align-justify"></i><span class="hidden-tablet"> Members</span></a></li>
						<?php endif;?>
                        <li><a class="ajax-link" href="user_table.php"><i class="icon-align-justify"></i><span class="hidden-tablet"> Users</span></a></li>
						
						<li><a class="ajax-link" href="newstable.php"><i class="icon-th"></i><span class="hidden-tablet"> News</span></a></li>
						<li><a class="ajax-link" href="comment_report.php"><i class="icon-list-alt"></i><span class="hidden-tablet"> Report</span></a></li>
                        
                        <li><a class="ajax-link" href="video.php"><i class="icon-eye-open"></i><span class="hidden-tablet"> Videos</span></a></li>                      
                        
                        
                        <li><a class="ajax-link" href="video_ads.php"><i class="icon-eye-open"></i><span class="hidden-tablet"> Advertisement</span></a></li>
                         <li><a class="ajax-link" href="image_ads.php"><i class="icon-flag"></i><span class="hidden-tablet"> Image Advertisement</span></a></li>
                        <!--<li><a class="ajax-link" href="garbage.php"><i class="icon-trash"></i><span class="hidden-tablet"> Clean files</span></a></li>-->
                        <li><a class="ajax-link" href="apps_table.php"><i class="icon-list-alt"></i><span class="hidden-tablet"> Apps</span></a></li>
						
					</ul>
					
				</div><!--/.well -->
			</div><!--/span-->
			<!-- left menu ends -->