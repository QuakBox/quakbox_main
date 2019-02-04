<?php session_start();

if(!isset($_SESSION['id']))
{
	header("location:login.php");
}
$id = $_SESSION['id'];

include("config.php");

$query = "SELECT * FROM admins WHERE id = '$id'";
$sql = mysqli_query($conn,$query);
$res = mysqli_fetch_array($sql);
$res1= $res['email'];

if(isset($_POST['submit'])){	
	
//remove unwanted videos from directory
$videodirectory  = "../../uploadedvideo/";
$thumbdirectory  = "../../uploadedvideo/videothumb/";
$uploaddirectory = "../../uploads/";
$adsvideodirectory  = "../../uploadedvideo/ads/";

//get all image files with a .jpg extension.
$mp4videos = glob($videodirectory . "*.mp4");
$oggvideos = glob($videodirectory . "*.ogg");
$webmvideos = glob($videodirectory . "*.webm");
$thumbs = glob($thumbdirectory . "*.png");
$uploadimage = glob($uploaddirectory.'*.*');
$mp4adsvideos = glob($adsvideodirectory . "*.mp4");
$oggadsvideos = glob($adsvideodirectory . "*.ogg");
$webmadsvideos = glob($adsvideodirectory . "*.webm");

//remove mp4 videos
foreach($mp4videos as $mp4video)
{      
	$name = substr($mp4video, 6);
    $sql = mysqli_query($conn,"SELECT video_id FROM videos WHERE location='$name'");
    if(mysqli_num_rows($sql) == 0)
        unlink($mp4video);
}

//remove ogg videos
foreach($oggvideos as $oggvideo)
{      
	$name = substr($oggvideo, 6);
    $sql = mysqli_query($conn,"SELECT video_id FROM videos WHERE location1='$name'");
    if(mysqli_num_rows($sql) == 0)
        unlink($oggvideo);	
}

//remove ogg videos
foreach($webmvideos as $webmvideo)
{      
	$name = substr($webmvideo, 6);
    $sql = mysqli_query($conn,"SELECT video_id FROM videos WHERE location2='$name'");
    if(mysqli_num_rows($sql) == 0)
        unlink($webmvideo);	
}

//remove thumb images
foreach($thumbs as $thumb)
{      
	$name = substr($thumb, 6);
    $sql = mysqli_query($conn,"SELECT video_id FROM videos WHERE thumburl1='$name' OR thumburl2='$name'
	                    OR thumburl3='$name' OR thumburl4='$name' OR thumburl5='$name'");
    if(mysqli_num_rows($sql) == 0)
        unlink($thumb);	
}

//remove images from uploads
/*foreach($uploadimage as $upload)
{      
	$name = substr($upload, 6);
    $sql = mysqli_query($conn,"SELECT messages_id FROM message m INNER JOIN upload_data u
	                    ON m.messages_id = u.msg_id WHERE messages='$name'");
    if(mysqli_num_rows($sql) == 0)
        unlink($upload);	
}*/

//remove ads mp4 videos
foreach($mp4adsvideos as $mp4video)
{      
	$name = substr($mp4video, 6);
    $sql = mysqli_query($conn,"SELECT id FROM videos_ads WHERE location='$name'");
    if(mysqli_num_rows($sql) == 0)
        unlink($mp4video);
}

//remove ads ogg videos
foreach($oggadsvideos as $oggvideo)
{      
	$name = substr($oggvideo, 6);
    $sql = mysqli_query($conn,"SELECT id FROM videos_ads WHERE location1='$name'");
    if(mysqli_num_rows($sql) == 0)
        unlink($oggvideo);	
}

//remove ads ogg videos
foreach($webmadsvideos as $webmvideo)
{      
	$name = substr($webmvideo, 6);
    $sql = mysqli_query($conn,"SELECT id FROM videos_ads WHERE location2='$name'");
    if(mysqli_num_rows($sql) == 0)
        unlink($webmvideo);	
}
header("location:garbage.php?err=");

} 
?>


<!DOCTYPE html>
<html lang="en">
<head>
	
	<meta charset="utf-8">
	<title>Quakbox</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Charisma, a fully featured, responsive, HTML5, Bootstrap admin template.">
	<meta name="author" content="Muhammad Usman">

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
						<form class="form-horizontal" method="post">
						<fieldset>
							<p class="center span5">
								<button type="submit" name="submit" class="btn btn-primary">Clean</button>
							</p>

                           <?php
								if(isset($_GET['err']))
								{
									if($_GET['err'] == null)
										{ 
							?>

											<div class="alert alert-success">
							<button type="button" class="close" data-dismiss="alert">×</button>
							<strong>Well done!</strong> You successfully clean files.
						</div>
 							<?php
										}
								}
							?> 

						</fieldset>
					</form>		
						
						
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
					
			<!--/span-->
						
				

		  
       
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