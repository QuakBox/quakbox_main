<?php session_start();

if(isset($_SESSION['id']))
{
$id = $_SESSION['id'];

include("config.php");

$query = "SELECT * FROM admins 
			WHERE id = '$id'";
			
			

	$sql = mysqli_query($con, $query);
	$res = mysqli_fetch_array($sql);
	$res1= $res['email'];
	
	
	
	
	//$res1= $res['id'];

$query1=mysqli_query($con, "SELECT member_id FROM member");
$totalmember=mysqli_num_rows($query1);

$query2=mysqli_query($con, "SELECT news_id FROM news");
$totalnews=mysqli_num_rows($query2);

$query_video=mysqli_query($con, "SELECT video_id FROM videos");
$totalvideos=mysqli_num_rows($query_video);

$query4=mysqli_query($con, "SELECT ads_id FROM ads");
$totaladds=mysqli_num_rows($query4);

//$query1=mysqli_query($conn, "SELECT date_created FROM message WHERE message_id='1'");
//$result= date('d/m/y', $query1);
//echo $result;
//exit();


$query1=mysqli_query($con, "SELECT messages_id FROM message WHERE date_created > UNIX_TIMESTAMP(DATE_SUB(CURDATE(), INTERVAL 7 DAY))");
$newmsg=mysqli_num_rows($query1);

//$query1=mysqli_query($conn, "SELECT member_id FROM members");
//$newmember=mysqli_num_rows($query1);

$query3=mysqli_query($con,"SELECT member_id FROM members WHERE registerDate > DATE_SUB(CURDATE(), INTERVAL 7 DAY)");
$newmember=mysqli_num_rows($query3);

$query1=mysqli_query($con,"SELECT video_id FROM videos WHERE date_created > UNIX_TIMESTAMP(DATE_SUB(CURDATE(), INTERVAL 7 DAY))");
$newvid=mysqli_num_rows($query1);
 
?>


<!DOCTYPE html>
<html lang="en">
<head>
	
	<meta charset="utf-8">
	<title>Quakbox</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	

	<!-- The styles -->
	<link id="bs-css" href="css/bootstrap-cerulean.css" rel="stylesheet">
	<style type="text/css">
	  body {
		padding-bottom: 40px;
	  }
	  .sidebar-nav {
		padding: 9px 0;
	  }
	</style>
	<link href="css/bootstrap-responsive.css" rel="stylesheet">
	<link href="css/charisma-app.css" rel="stylesheet">
	<link href="css/jquery-ui-1.8.21.custom.css" rel="stylesheet">
	<link href='css/fullcalendar.css' rel='stylesheet'>
	<link href='css/fullcalendar.print.css' rel='stylesheet'  media='print'>
	<link href='css/chosen.css' rel='stylesheet'>
	<link href='css/uniform.default.css' rel='stylesheet'>
	<link href='css/colorbox.css' rel='stylesheet'>
	<link href='css/jquery.cleditor.css' rel='stylesheet'>
	<link href='css/jquery.noty.css' rel='stylesheet'>
	<link href='css/noty_theme_default.css' rel='stylesheet'>
	<link href='css/elfinder.min.css' rel='stylesheet'>
	<link href='css/elfinder.theme.css' rel='stylesheet'>
	<link href='css/jquery.iphone.toggle.css' rel='stylesheet'>
	<link href='css/opa-icons.css' rel='stylesheet'>
	<link href='css/uploadify.css' rel='stylesheet'>

	<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- The fav icon -->
	<link rel="shortcut icon" href="images/favicon.ico">
		
</head>

<body>

	<?php include("include/header.php");
		  include("include/sidebar.php");

	 ?>

		
			
			
			
			<div id="content" class="span10">
			<!-- content starts -->
			

			<div>
				<ul class="breadcrumb">
					<li>
						<a href="#">Home</a> 
					</li>
					<li>
					<!--	<a href="#">Dashboard</a>-->
					</li>
				</ul>
			</div>
			<div class="sortable row-fluid">
				<a data-rel="tooltip" class="well span3 top-block" href="user_table.php">
					<!--<span class="icon32 icon-red icon-user"></span>-->
					<div>Total Users</div>
					<div><?php echo $totalmember; ?> </div>
					<!--<span class="notification"></span>-->
				</a>

						
				<a data-rel="tooltip" class="well span3 top-block" href="<?php echo $base_url; ?>qb-admin/admin/newstable.php">
					<!-- <span class="icon32 icon-color icon-envelope-closed"></span>-->
					<div>Total News</div>
					
                    <div><?php echo $totalnews; ?> </div>
					
				</a> 
                
                <a data-rel="tooltip" class="well span3 top-block" href="<?php echo $base_url; ?>qb-admin/admin/video.php">
	<!--				<span class="icon32 icon-color icon-envelope-closed"></span> -->
					<div>Total Videos</div>
					<div><?php echo $totalvideos; ?> </div>
					
				</a>
                
                <a data-rel="tooltip" class="well span3 top-block" href="#">
	<!--			<span class="icon32 icon-color icon-envelope-closed"></span>-->
					<div>Total Adds</div>
					<div><?php echo $totaladds; ?> </div>
					
				</a>
			</div>
			
			<div class="row-fluid">
				<div class="box span12">
					<div class="box-header well">
						<h2><i class="icon-info-sign"></i> Introduction</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<h1>Quakbox <small>Quakbox is a new kind of Social Networking site.</small></h1>
						<p>In this site you can experience lots of new and amzing features to use :)</p>
						
						
						
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
					
			<div class="row-fluid sortable">
				
<div class="box span4" style="pointer-events: none;">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-list"></i> Weekly Stat</h2>
						<!--<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>-->
					</div>
					<div class="box-content">
						<ul class="dashboard-list">
							<li>
								<a href="#">
									<i class="icon-arrow-up"></i>                               
									<span class="green"><?php echo $newmember; ?></span>
									New Registrations                                    
								</a>
							</li>
						  <li>
							<a href="#">
							  <i class="icon-comment"></i>
							  <span class="red"><?php echo $newmsg; ?></span>
							  New Status
							</a>
						  </li>
						  <li>
							<a href="#">
							  <i class="icon-eye-open"></i> 
							  <span class="blue"><?php echo $newvid; ?></span>
							  New Videos                                    
							</a>
						  </li>
						  
						  
						  
						  
						  
						</ul>
					</div>
				</div><!--/span-->


				</div><!--/span-->
						
				

		  
       
					<!-- content ends -->
			</div><!--/#content.span10-->
				</div><!--/fluid-row-->
				
		<hr>

		<div class="modal hide fade" id="myModal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Settings</h3>
			</div>
			<div class="modal-body">
				<p>Here settings can be configured...</p>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Close</a>
				<a href="#" class="btn btn-primary">Save changes</a>
			</div>
		</div>

		
		<!--<footer>
			<p class="pull-left">&copy; <a href="http://usman.it" target="_blank">Muhammad Usman</a> 2012</p>
			<p class="pull-right">Powered by: <a href="http://usman.it/free-responsive-admin-template">Charisma</a></p>
		</footer>  -->
		
	</div><!--/.fluid-container-->

	<!-- external javascript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->

	<!-- jQuery -->
	<script src="js/jquery-1.7.2.min.js"></script>
	<!-- jQuery UI -->
	<script src="js/jquery-ui-1.8.21.custom.min.js"></script>
	<!-- transition / effect library -->
	<script src="js/bootstrap-transition.js"></script>
	<!-- alert enhancer library -->
	<script src="js/bootstrap-alert.js"></script>
	<!-- modal / dialog library -->
	<script src="js/bootstrap-modal.js"></script>
	<!-- custom dropdown library -->
	<script src="js/bootstrap-dropdown.js"></script>
	<!-- scrolspy library -->
	<script src="js/bootstrap-scrollspy.js"></script>
	<!-- library for creating tabs -->
	<script src="js/bootstrap-tab.js"></script>
	<!-- library for advanced tooltip -->
	<script src="js/bootstrap-tooltip.js"></script>
	<!-- popover effect library -->
	<script src="js/bootstrap-popover.js"></script>
	<!-- button enhancer library -->
	<script src="js/bootstrap-button.js"></script>
	<!-- accordion library (optional, not used in demo) -->
	<script src="js/bootstrap-collapse.js"></script>
	<!-- carousel slideshow library (optional, not used in demo) -->
	<script src="js/bootstrap-carousel.js"></script>
	<!-- autocomplete library -->
	<script src="js/bootstrap-typeahead.js"></script>
	<!-- tour library -->
	<script src="js/bootstrap-tour.js"></script>
	<!-- library for cookie management -->
	<script src="js/jquery.cookie.js"></script>
	<!-- calander plugin -->
	<script src='js/fullcalendar.min.js'></script>
	<!-- data table plugin -->
	<script src='js/jquery.dataTables.min.js'></script>

	<!-- chart libraries start -->
	<script src="js/excanvas.js"></script>
	<script src="js/jquery.flot.min.js"></script>
	<script src="js/jquery.flot.pie.min.js"></script>
	<script src="js/jquery.flot.stack.js"></script>
	<script src="js/jquery.flot.resize.min.js"></script>
	<!-- chart libraries end -->

	<!-- select or dropdown enhancer -->
	<script src="js/jquery.chosen.min.js"></script>
	<!-- checkbox, radio, and file input styler -->
	<script src="js/jquery.uniform.min.js"></script>
	<!-- plugin for gallery image view -->
	<script src="js/jquery.colorbox.min.js"></script>
	<!-- rich text editor library -->
	<script src="js/jquery.cleditor.min.js"></script>
	<!-- notification plugin -->
	<script src="js/jquery.noty.js"></script>
	<!-- file manager library -->
	<script src="js/jquery.elfinder.min.js"></script>
	<!-- star rating plugin -->
	<script src="js/jquery.raty.min.js"></script>
	<!-- for iOS style toggle switch -->
	<script src="js/jquery.iphone.toggle.js"></script>
	<!-- autogrowing textarea plugin -->
	<script src="js/jquery.autogrow-textarea.js"></script>
	<!-- multiple file upload plugin -->
	<script src="js/jquery.uploadify-3.1.min.js"></script>
	<!-- history.js for cross-browser state change on ajax -->
	<script src="js/jquery.history.js"></script>
	<!-- application script for Charisma demo -->
	<script src="js/charisma.js"></script>
	
		
</body>
</html>

<?php
}

else
header("Location: login.php");
?>