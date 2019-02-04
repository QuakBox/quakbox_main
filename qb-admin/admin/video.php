<?php session_start();

if(isset($_SESSION['id']))
{
	include("config.php");
	$id = $_SESSION['id'];
	$query = "SELECT * FROM admins 
			WHERE id = '$id'";
			
			

	$sql = mysqli_query($conn,$query);
	$res = mysqli_fetch_array($sql);
	$res1= $res['email'];

if(isset($_GET['delete_id'])){	
$delete_id = $_REQUEST['delete_id'];
$sqlforthumburl = mysqli_query($conn,"select * from videos where video_id = '$delete_id'");
$mres1 = mysqli_fetch_array($sqlforthumburl);

$msql = mysqli_query($conn,"select * from message where video_id = '$delete_id'");
$mres = mysqli_fetch_array($msql);
$messages_id = $mres['messages_id'];

$parent_id = $mres1['parent_id'];

$parent_sql = mysqli_query($conn,"SELECT video_id FROM videos WHERE parent_id = '$parent_id'");
$parent_count = mysqli_num_rows($parent_sql);
//fetch videos files url
$urlforMP4 = '../../'.$mres1['location'];
$urlforOGG = '../../'.$mres1['location1'];
$urlforWEBM = '../../'.$mres1['location2'];
//fetch video thumb files url
$pathforthumbimage1 = '../../'.$mres1['thumburl1'];
$pathforthumbimage2 = '../../'.$mres1['thumburl2'];
$pathforthumbimage3 = '../../'.$mres1['thumburl3'];
if($parent_count == 1){
//remove videos file from server
@unlink($urlforMP4);
@unlink($urlforOGG);
@unlink($urlforWEBM);

//remove videos thumb file from server
@unlink($pathforthumbimage1);
@unlink($pathforthumbimage2);
@unlink($pathforthumbimage3);
}
if(mysqli_num_rows($msql) > 0)
{
$csql = mysqli_query($conn,"select comment_id from postcomment where msg_id = '$messages_id'");
$cres = mysqli_fetch_array($csql);
$comment_id = $cres['comment_id'];

$rsql = mysqli_query($conn,"select reply_id from comment_reply where comment_id = '$comment_id'");
$rres = mysqli_fetch_array($csql);
$reply_id = $cres['comment_id'];

mysqli_query($conn,"DELETE FROM message WHERE messages_id='$messages_id'");
mysqli_query($conn,"DELETE FROM postcomment WHERE msg_id='$messages_id'");
mysqli_query($conn,"DELETE FROM bleh WHERE remarks='$messages_id'");
mysqli_query($conn,"DELETE FROM comment_like WHERE comment_id='$comment_id'");
mysqli_query($conn,"DELETE FROM comment_reply WHERE comment_id='$comment_id'");
mysqli_query($conn,"DELETE FROM comment_report WHERE msg_id='$messages_id'");
}
mysqli_query($conn,"DELETE FROM videos_views WHERE video_id='$delete_id'");
mysqli_query($conn,"DELETE FROM videos WHERE video_id='$delete_id'");

header("location:video.php");

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
		<!-- topbar starts -->
	<?php include("include/header.php");

		  include("include/sidebar.php");

	 ?>
	<!-- topbar ends -->
		
			<!-- left menu ends -->
			
			<noscript>
				<div class="alert alert-block span10">
					<h4 class="alert-heading">Warning!</h4>
					<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
				</div>
			</noscript>
			
			<div id="content" class="span10">
			<!-- content starts -->
			

			<div>
				<ul class="breadcrumb">
					<li>
						<a href="#">Home</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#">Videos</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2>News</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
					</div>

					<?php
						  			
									
									
									 /*$query1= "SELECT news.news_id, news.title, news_category.name, members.FirstName,
									 geo_country.country_title, news.date_created, news.status FROM news 
									 INNER JOIN news_category ON news.category_id=news_category.id
									 INNER JOIN members ON news.member_id=members.member_id
									 INNER JOIN geo_country ON news.country_id= geo_country.country_id";*/
                               $query1= "select video_id,category,featured,title,videos_category.name,ads from videos 
							   INNER JOIN videos_category ON videos.category=videos_category.id";
									  
									$sql1 = mysqli_query($conn,$query1);
									 // $res = mysqli_fetch_array($sql);


                     ?>	

					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th>Title</th>
                                  <th>Category</th>
                                  <th>Featured</th>
                                  <th>Ads</th>
								  <th>Actions</th>
								  
							  </tr>
						  </thead>   
						  <tbody>
						  <?php 	
						  while($row = mysqli_fetch_array( $sql1 )) { ?>


							<tr>
								<td class="center"><?php echo $row['title']; ?></td>
								
								 <td class="center"><?php echo $row['name']; ?></td>
                                 
                                 
                                
                                 <td class="center">
															<?php 
									if($row['featured'] == "1" )
										{?>
									<a href="vidactive.php?id=<?php echo $row['video_id']?>" class="btn btn-success">Add</a>
									<?php } else {
									?>
									<a href="vidinactive.php?id=<?php echo $row['video_id']?>" class="btn btn-warning">Remove</a>								<?php } ?>
								</td>
                                <td class="center">
															<?php 
									if($row['ads'] == "1" )
										{ echo 'Enable'; } else {
									echo 'Disable'; } ?>
								</td>
                                 <td>
								 <?php if( AccessLevel::getInstance()->isAllowed('videos', 'edit_access' )):?>
                                <a class="btn btn-info" href="edit_video.php?id=<?php echo $row['video_id']?>">
										<i class="icon-edit icon-white"></i>  
										Edit 
                                   <?php endif;?>										
									</a>
									<?php if( AccessLevel::getInstance()->isAllowed('videos', 'delete_access' )):?>
									<a onclick ="return confirm('Are you sure you want to delete this video?')" class="btn btn-danger" href="video.php?delete_id=<?php echo $row['video_id']?>">
										<i class="icon-trash icon-white"></i> 
										Delete
									<?php endif;?>	
									</a>
                                
                                </td>
                                
                               
							</tr>
							<?php } ?>
						  </tbody>
					  </table>            
					</div>
				</div><!--/span-->
			
			</div><!--/row-->

			
				
		

		<?php 
				include("include/footer.php");
			?>
		
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
