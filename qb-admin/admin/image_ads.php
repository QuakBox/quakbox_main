<?php 
session_start();

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

if(isset($_GET['delete_id'])){
    
$delete_id = 	$_GET['delete_id'];
mysqli_query($conn,"DELETE FROM ads WHERE ads_id = '$delete_id'");

header("location:image_ads.php?err=");

} 

if(isset($_GET['publish_id'])){
    
$publish_id=$_GET['publish_id'];
mysqli_query($conn,"UPDATE ads set status='0'  WHERE ads_id = '$publish_id'");

header("location:image_ads.php");

} 

if(isset($_GET['unpublish_id'])){
    
$unpublish_ads=$_GET['unpublish_id'];
mysqli_query($conn,"UPDATE ads set status='1'  WHERE ads_id = '$unpublish_ads'");

header("location:image_ads.php");

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
						<h2><i class="icon-info-sign"></i> Image ads</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                    <p><a href="add_image_ads.php"><button class="btn btn-small btn-success"><i class="icon icon-plus icon-white"></i> New Image ad</button></a></p>
                     <?php
								if(isset($_GET['err']))
								{
									if($_GET['err'] == null)
										{ 
							?>

											<div class="alert alert-success">
							<button type="button" class="close" data-dismiss="alert">×</button>
							<strong>Well done!</strong> You successfully delete ad.
						</div>
 							<?php
										}
								}
							?> 

						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
                                                                   <th>creator</th>
								  <th>Ads name</th>
                                  <th>Image</th>
                                 
                                  <th>Country</th>
                                  <th>State</th>
                                  <th>City</th>
                                  <th>Published</th>
				  <th>Actions</th>			  </tr>
						  </thead>   
						  <tbody>
						  <?php 
                                                 $sql="
	SELECT `ads_id`,`username`, `ad_creator`, `ads_title`, `ads_content`, `ads_pic`, `typeofadd`, `url`, `targetgender`, `targetmob`, `targetstate`, `targetcity`, `targetcountry`, `targetdob`, `targetadd`, `targetgrad`, `pricingperclick`, `pricingbuy`, `pricingpay`, `pricinggateway`, a.status,`country_title`,`state_title`,`city_title` FROM ads a 
        INNER JOIN member m
	on a.ad_creator=m.member_id  
        INNER JOIN geo_country gc
	on a.targetcountry=gc.country_id  
	INNER JOIN geo_state gs
	ON a.targetstate=gs.state_id
	INNER JOIN geo_city gci
	ON a.targetcity=gci.city_id
	WHERE a.ads_pic!='' ORDER BY a.ads_id DESC 	
	";
                                               //   echo $sql
						  $ads_sql = mysqli_query($conn,$sql);	
						 
                                                  
                                                  
                                                  while($ads_res = mysqli_fetch_array( $ads_sql )) { 
                                                      
                                                      //`ads_id`, `ad_creator`, `ads_title`, `ads_content`, `ads_pic`, `typeofadd`, `url`, `targetgender`, `targetmob`, `targetstate`, `targetcity`, `targetcountry`, `targetdob`, `targetadd`, `targetgrad`, `pricingperclick`, `pricingbuy`, `pricingpay`, `pricinggateway`, `status`, `add_date`, `agelimit`, `start_date`, `end_date`
                                                      ?>


							<tr>
                                                            <td class="center"><?php echo $ads_res['username']; ?></td>
								<td class="center"><?php echo $ads_res['ads_title']; ?></td>
                                                                <td class="center"><img src="<?php echo $base_url;?><?php echo  $ads_res['ads_pic']; ?>" height="150px" width="150px"></td>
                                                                 <td class="center"><?php echo  $ads_res['country_title']; ?></td>
                                                                <td class="center"><?php echo  $ads_res['state_title']; ?></td>
                                                                <td class="center"><?php echo  $ads_res['city_title']; ?></td>                               
                                                                <td class="center">
															<?php 
									if($ads_res['status'] == "1" )
										{?>
									<a href="image_ads.php?publish_id=<?php echo $ads_res['ads_id']?>" class="btn btn-warning" title="Unpublish ads">Unublish</a>
									<?php } else {
									?>
                                                                        <a href=image_ads.php?unpublish_id=<?php echo $ads_res['ads_id']?>" class="btn btn-success" title="Publish ads">Publish</a>									<?php } ?>
								</td>
                                                               
                                                                <td>
								<?php if( AccessLevel::getInstance()->isAllowed('videoads', 'edit_access' )):?>
                                                                        <a class="btn btn-info" href="edit_image_ads.php?id=<?php echo $ads_res['ads_id']?>">
										<i class="icon-edit icon-white"></i>  
										Edit                                            
									</a>
									<?php endif;?>
									<?php if( AccessLevel::getInstance()->isAllowed('videoads', 'delete_access' )):?>
									<a class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this advertisement?')"  href="image_ads.php?delete_id=<?php echo $ads_res['ads_id']?>">
										<i class="icon-trash icon-white"></i> 
										Delete
									</a>
                                                                <?php endif;?>
                                                                </td>
                               
							</tr>
                                                        
   
   
							<?php } ?>
						  </tbody>
					  </table>		
						
						
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
					
			<!--/span-->
						
				

		  
       
					<!-- content ends -->
			</div><!--/#content.span10-->
				<!--/fluid-row-->
				
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