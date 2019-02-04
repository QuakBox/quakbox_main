<?php session_start();

if(isset($_SESSION['id']))
{
	include("config.php");
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_lookup.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
	$memberObject = new member1();
	$lookupObject = new lookup();

	$id = $_SESSION['id'];
	//$id1= $_GET['id'];
	$query = "SELECT * FROM admins 
			WHERE id = '$id'";
			
			

	$sql = mysqli_query($conn,$query);
	$res = mysqli_fetch_assoc($sql);
	$res1= $res['email'];
	?>

	<?php
	$id1 = htmlspecialchars(trim($_GET['id']));


$sql1="SELECT * FROM member WHERE member_id='$id1'";
$result=mysqli_query($conn, $sql1) or die(mysqli_error($con));
$rows=mysqli_fetch_array($result);


	$firstName= $memberObject-> select_member_meta_value($id1,"first_name");
	$last_name=$memberObject-> select_member_meta_value($id1,"last_name");
	$address=$memberObject->select_member_meta_value($id1,"address");
	$country=$memberObject-> select_member_meta_value_for_GeoCountry($id1);
	$state=$memberObject-> select_member_meta_value_for_GeoState($id1);
	$city=$memberObject-> select_member_meta_value_for_GeoCity($id1);
	$zip=$memberObject->select_member_meta_value($id1,"zip");
	$gender= $memberObject->select_member_meta_value_for_lookupID($id1,"Gender");
	$birthdate= $rows['dob'];
	$relationship=$memberObject->select_member_meta_value_for_lookupID($id1,"relationship_status");
	$language=$memberObject->select_member_meta_value_for_lookupID($id1,"language_known");
	$political_views=$memberObject->select_member_meta_value_for_lookupID($id1,"political_view");
	$displayName = $rows['displayname'];
	$current_profile_image = $memberObject->select_member_meta_value($id1,"current_profile_image");
	$current_profile_image = $base_url.$current_profile_image;
	$member_registered_on = $memberObject->select_member_meta_value($id1,"member_registered_on");
	$last_visited_on =$memberObject-> select_member_meta_value($id1,"last_visited_on");
	
	$mobile_no= $memberObject->select_member_meta_value($id1,"phone_mobile");
	$landline_no= $memberObject->select_member_meta_value($id1,"phone_landline");
	$address=$memberObject->select_member_meta_value($id1,"address");
	$country=$memberObject-> select_member_meta_value_for_GeoCountry($id1);
	$state=$memberObject-> select_member_meta_value_for_GeoState($id1);
	$city=$memberObject-> select_member_meta_value_for_GeoCity($id1);
	$zip=$memberObject->select_member_meta_value($id1,"zip");
	$curcity=$memberObject->select_member_meta_value($id1,"current_city");
	$hometown=$memberObject->select_member_meta_value($id1,"home_town");
	$website=$memberObject->select_member_meta_value($id1,"website");
	$about_me =$memberObject->select_member_meta_value($id1,"about_me");
	$ip =$memberObject->select_member_meta_value($id1,"ip");

	
	$educationResult = $memberObject->select_member_Education_history($id1);
	$edures = mysqli_fetch_array($educationResult);
	$organization_name = $edures['organization_name'];
	$education_grade = $edures['education_grade'];
	$education_grade = $lookupObject->getValueByKey($education_grade);
	$education_year_from = $edures['education_year_from'];
	$education_year_to = $edures['education_year_to'];
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
						<a href="#">Users</a><span class="divider">/</span>
					</li>
                    <li>
						<a href="#">User Details</a><span class="divider">/</span>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> User details</h2>
						
					</div>
					<div class="box-content">
						<form class="form-horizontal">
						  <fieldset>
							
							<div class="control-group">
								<label class="control-label">First Name</label>
								<div class="controls">
								 <!-- <span class="input-xlarge uneditable-input">--><!--</span>-->
								 <label class="control-label"><?php echo $firstName;?></label>
								</div>
							  </div>
                              
                             <div class="control-group" align="right">
							<!--	<label  class="control-label" style="float: right; position: absolute; margin-left: 650px;">Profile Image</label>-->
								<div class="controls">
                               
								 <!-- <span class="input-xlarge uneditable-input">--><!--</span>-->
								 <label class="control-label" style="float: right; position: absolute; margin-left: 650px;"><img src='<?php echo $current_profile_image;?>' height='200' width='150'  style='border-radius:50%'></label>
                                 
								</div>
							  </div>


							  <div class="control-group">
								<label class="control-label">Last Name</label>
								<div class="controls">
								  <label class="control-label"><?php echo $last_name;?></label>
								</div>
							  </div>

							  <div class="control-group">
								<label class="control-label">User Name</label>
								<div class="controls">
								  <label class="control-label"><?php echo $rows['username'];?></label>
								</div>
							  </div>

							  

							  <div class="control-group">
								<label class="control-label">Email ID</label>
								<div class="controls">
								  <label class="control-label"><?php echo $rows['email'];?></label>
								</div>
							  </div>

							  <div class="control-group">
							  <label class="control-label">Address</label>
							  <div class="controls">
								 <label class="control-label"><?php echo $address.', '.$city.', '.$state.', '.$country.', '.$zip;?></label>
							  </div>
							</div>

							  <div class="control-group">
								<label class="control-label">Mobile No.</label>
								<div class="controls">
								  <label class="control-label"><?php echo $mobile_no;?></label>
								</div>
							  </div>

							  <div class="control-group">
								<label class="control-label">Landline No.</label>
								<div class="controls">
								  <label class="control-label"><?php echo $landline_no;?></label>
								</div>
							  </div>

							  <div class="control-group">
								<label class="control-label">WebSite</label>
								<div class="controls">
								  <label class="control-label"><?php echo $website;?></label>
								</div>
							  </div>

							  <div class="control-group">
								<label class="control-label">Birth Date</label>
								<div class="controls">
								  <label class="control-label"><?php echo $birthdate;?></label>
								</div>
							  </div>

							  <div class="control-group">
								<label class="control-label">Gender</label>
								<div class="controls">
								  <label class="control-label"><?php echo $gender;?></label>
								</div>
							  </div>

							  <div class="control-group">
								<label class="control-label">RegisterDate</label>
								<div class="controls">
								  <label class="control-label"><?php echo $member_registered_on;?></label>
								</div>
							  </div>

							  <div class="control-group">
								<label class="control-label">LastvisitDate</label>
								<div class="controls">
								  <label class="control-label"><?php echo $last_visited_on;?></label>
								</div>
							  </div>

							  <div class="control-group">
								<label class="control-label">Relationship</label>
								<div class="controls">
								  <label class="control-label"><?php echo $relationship;?></label>
								</div>
							  </div>

							  <div class="control-group">
								<label class="control-label">Current City</label>
								<div class="controls">
								  <label class="control-label"><?php echo $curcity;?></label>
								</div>
							  </div>

							  <div class="control-group">
								<label class="control-label">Hometown</label>
								<div class="controls">
								  <label class="control-label"><?php echo $hometown;?></label>
								</div>
							  </div>


							  <div class="control-group">
								<label class="control-label">Language</label>
								<div class="controls">
								  <label class="control-label"><?php echo $language;?></label>
								</div>
							  </div>

							  <div class="control-group">
								<label class="control-label">Political Views</label>
								<div class="controls">
								  <label class="control-label"><?php echo $political_views;?></label>
								</div>
							  </div>

							  <div class="control-group">
								<label class="control-label">College</label>
								<div class="controls">
								  <label class="control-label"><?php echo $organization_name;?></label>
								</div>
							  </div>

							  <div class="control-group">
								<label class="control-label">Education Grade </label>
								<div class="controls">
								  <label class="control-label"><?php echo $education_grade;?></label>
								</div>
							  </div>

							  <div class="control-group">
								<label class="control-label">From :</label>
								<div class="controls">
								  <label class="control-label"><?php echo $education_year_from;?></label>
								</div>
							  </div>

							  <div class="control-group">
								<label class="control-label">To :</label>
								<div class="controls">
								  <label class="control-label"><?php echo $education_year_to;?></label>
								</div>
							  </div>

							  <div class="control-group">
								<label class="control-label">About me</label>
								<div class="controls">
								  <label class="control-label"><?php echo $about_me;?></label>
								</div>
							  </div>

						

							  <div class="control-group">
								<label class="control-label">Last Activity</label>
								<div class="controls">
								  <label class="control-label"></label>
								</div>
							  </div>

							  <div class="control-group">
								<label class="control-label">IP</label>
								<div class="controls">
								  <label class="control-label"><?php echo $ip;?></label>
								</div>
							  </div>

							 









							
							
						  </fieldset>
						</form>   

					</div>
				</div><!--/span-->

			</div><!--/row-->


			
			
			
    
					<!-- content ends -->
			</div><!--/#content.span10-->
				</div><!--/fluid-row-->
				
		<hr>

		<?php 
				include("include/footer.php");
			?>

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