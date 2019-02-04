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
	$query = "SELECT * FROM admins  WHERE id = '$id'";
	$sql = mysqli_query($conn,$query);
	$res = mysqli_fetch_array($sql);
	$res1= $res['email'];
	?>

	<?php
	$id1= $_GET['id'];
$sql1="SELECT * FROM member WHERE member_id='$id1'";
$result= mysqli_query($conn,$sql1);
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
	$organization_id = $edures['qb_cer_id'];
	$education_grade = $edures['education_grade'];
	$education_grade = $lookupObject->getValueByKey($education_grade);
	$education_year_from = $edures['education_year_from'];
	$education_year_to = $edures['education_year_to'];
	
	$city_id=$memberObject-> select_member_meta_value($id1,'city');
	$country_id=$memberObject-> select_member_meta_value($id1,'country');
	$state_id=$memberObject-> select_member_meta_value($id1,'state');
	
	$relationshipStatusId=$memberObject->select_member_meta_value($id1,'relationship_status');
	$language_id=$memberObject->select_member_meta_value($id1,'language_known');
	$political_views_id=$memberObject->select_member_meta_value($id1,'political_view');
	
	$lookupObject = new lookup();
	
	$activeID =  $lookupObject->getLookupKey("MEMBER STATUS", "ACTIVE");
	
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
						<form class="form-horizontal" action="user_action_edit.php" method="post">
						  <fieldset>
							
							<div class="control-group">
								<label class="control-label">First Name</label>
								<div class="controls">
								 <!-- <span class="input-xlarge uneditable-input">--><!--</span>-->
								  <input class="input-xlarge focused validate[required,custom[onlyLetterSp],minSize[5],maxSize[50]] input-medium primary" id="name" type="text" name="user_meta[first_name]" value="<?php echo $firstName;?>">
								  <input type="hidden" name="member_id" value="<?php echo $rows['member_id'];?>">
								</div>
							  </div>
                              
                             <div class="control-group" align="right">
							<!--	<label  class="control-label" style="float: right; position: absolute; margin-left: 650px;">Profile Image</label>-->
								<div class="controls">
                               
								 <!-- <span class="input-xlarge uneditable-input">--><!--</span>-->
								 <label class="control-label" style="float: right; position: absolute; margin-left: 650px;"><?php //echo "<img src='../".$rows['profImage']."' height='200' width='150'  style='border-radius:50%'>";?></label>
                                 
								</div>
							  </div>


							  <div class="control-group">
								<label class="control-label">Last Name</label>
								<div class="controls">
                                   <input class="input-xlarge focused validate[required,custom[onlyLetterSp],minSize[5],maxSize[50]] input-medium primary" id="name" type="text" name="user_meta[last_name]" value="<?php echo $last_name;?>">
								</div>
							  </div>

							  <div class="control-group">
								<label class="control-label">User Name</label>
								<div class="controls">
								  <label class="control-label"><?php echo $rows['username'];?><input type="hidden" name="uname" value="<?php echo $rows['username'];?>"></label>
								</div>
							  </div>

							  

							  <div class="control-group">
								<label class="control-label">Email ID</label>
								<div class="controls">
								  <input class="input-xlarge focused validate[required,custom[onlyLetterSp],minSize[5],maxSize[50]] input-medium primary" id="name" type="text" name="email" value="<?php echo $rows['email'];?>">
								</div>
							  </div>

							  <div class="control-group">
							  <label class="control-label">Address</label>
							  <div class="controls">
							  <textarea  name="user_meta[address]" class="input-xlarge focused validate[required,custom[onlyLetterSp],minSize[5],maxSize[50]] input-medium primary" ><?php echo $address;?></textarea>
							  </div>
							</div>
							 <div class="control-group">
							  <label class="control-label">City</label>
							  <div class="controls">
							  
							  <select name="user_meta[city]" data-rel="chosen">
								<?php
								$sql ="SELECT * FROM geo_city";
								$result = mysqli_query($conn,$sql);
								echo '<option   value="">---Select the City name---</option>';
								
								while($cityName = mysqli_fetch_array($result)) {
									if ($city_id == $cityName['city_id'])
									{
										$selected = 'selected="selected"';
									}
									else
									{
										$selected = '';
									}
									?>
								
								<option value=<?php echo $cityName['city_id'];?>  <?php  echo $selected;?>><?php echo $cityName['city_title'];?></option>
								<?php }
								echo "</select>";
								?>
							  
							  </div>
							</div>

							 <div class="control-group">
							  <label class="control-label">State</label>
							  <div class="controls">
							   <select name="user_meta[state]" data-rel="chosen">
								<?php
								$sql ="SELECT * FROM geo_state";
								$result = mysqli_query($conn,$sql);
								echo '<option   value="">---Select the State name---</option>';
								while($stateName = mysqli_fetch_array($result)) {
									if ($state_id == $stateName['state_id'])
									{
										$selected = 'selected="selected"';
									}
									else
									{
										$selected = '';
									}
									?>
								
								<option value=<?php echo $stateName['state_id'];?>  <?php  echo $selected;?>><?php echo $stateName['state_title'];?></option>
								<?php }
								echo "</select>";
								?>

							  </div>
							</div>
							 <div class="control-group">
							  <label class="control-label">Country</label>
							  <div class="controls">
							  <select name="user_meta[country]" data-rel="chosen">
								<?php
								$sql ="SELECT * FROM geo_country";
								$result = mysqli_query($conn,$sql);
								echo '<option   value="">---Select the Country name---</option>';
								while($countryName = mysqli_fetch_array($result)) {
									if ($country_id == $countryName['country_id'])
									{
										$selected = 'selected="selected"';
									}
									else
									{
										$selected = '';
									}
									?>
								
								<option value=<?php echo $countryName['country_id'];?> <?php  echo $selected;?>><?php echo $countryName['country_title'];?></option>
								<?php }
								echo "</select>";
								?>
							 <!--   <input  name="country" class="input-xlarge focused validate[required,custom[onlyLetterSp],minSize[5],maxSize[50]] input-medium primary" value="<?php //echo $country;?>">-->
							  </div>
							</div>

							<!--  <div class="control-group">
							  <label class="control-label">Zip</label>
							  <div class="controls">
							  <input  name="user_meta_zip" class="input-xlarge focused validate[required,custom[onlyLetterSp],minSize[5],maxSize[50]] input-medium primary"  value ="<?php //echo $zip;?>">
							  </div>
							</div>--> 

							  <div class="control-group">
								<label class="control-label">Mobile No.</label>
								<div class="controls">
								  <input class="input-xlarge focused validate[required,custom[onlyLetterSp],minSize[5],maxSize[50]] input-medium primary" id="user_meta[phone_mobile]" type="text" name="user_meta_phone_mobile" value="<?php echo $mobile_no;?>">
								</div>
							  </div>

							  <div class="control-group">
								<label class="control-label">Landline No.</label>
								<div class="controls">
								  <input class="input-xlarge focused validate[required,custom[onlyLetterSp],minSize[5],maxSize[50]] input-medium primary" id="user_meta[phone_landline]" type="text" name="user_meta_phone_landline" value="<?php echo $landline_no;?>">
								</div>
							  </div>

							  <div class="control-group">
								<label class="control-label">WebSite</label>
								<div class="controls">
								  <input class="input-xlarge focused validate[required,custom[onlyLetterSp],minSize[5],maxSize[50]] input-medium primary" id="website" type="text" name="user_meta[website]" value="<?php echo $website;?>">
								</div>
							  </div>

							  <div class="control-group">
								<label class="control-label">Birth Date</label>
								<div class="controls">
								  <input class="input-xlarge focused validate[required,custom[onlyLetterSp],minSize[5],maxSize[50]] input-medium primary" id="name" type="text" name="birthdate" value="<?php echo $birthdate;?>">
								</div>
							  </div>

							  <div class="control-group">
							  
								<label class="control-label">Gender</label>
								<div class="controls">
								<?php 
								  $result = $lookupObject->getLookupValue( "Gender" );
								  while($genderList = mysqli_fetch_array($result)) {
								  	if ($gender == $genderList['lookup_key'])
								  	{
								  		$checked = 'checked="checked"';
								  	}
								  	else
								  	{
								  		$checked = '';
								  	}
								
								  	?>
								  <label class="radio" for='gender_<?php echo $genderList['lookup_key'];?>'>
									<input class="input-xlarge focused"  style="padding:10px;" id="gender_<?php echo $genderList['lookup_key'];?>" type="radio" name="user_meta[gender]" value="<?php echo $genderList['lookup_key'];?>"  <?php echo $checked;?>>
									<?php echo $genderList['lookup_value'];?>
									
								  </label>
								  <div style="clear:both"></div>
								  <?php }?>
								   
								</div>
								  
								
							  </div>
							  
							  

							  <div class="control-group">
								<label class="control-label">Relationship</label>
								<div class="controls">
								   <select name="user_meta[relationship_status]" data-rel="chosen">
								<?php
								$result = $lookupObject->getLookupValue( "Relationship Status" );
								echo '<option   value="">---Select the Relationship name---</option>';
								while($relationshipStatus = mysqli_fetch_array($result)) {
									if ($relationshipStatusId == $relationshipStatus['lookup_key'])
									{
										$selected = 'selected="selected"';
									}
									else
									{
										$selected = '';
									}
									?>
								
								<option value=<?php echo $relationshipStatus['lookup_key'];?> <?php  echo $selected;?>><?php echo $relationshipStatus['lookup_value'];?></option>
								<?php }
								echo "</select>";
								?>
								  
								  
								 
								</div>
							  </div>

							  <div class="control-group">
								<label class="control-label">Current City</label>
								<div class="controls">
								
								 <select name="user_meta[current_city]" data-rel="chosen">
								<?php
								$sql ="SELECT * FROM geo_city";
								$result = mysqli_query($conn,$sql);
								echo '<option   value="">---Select the City name---</option>';
								
								while($cityName = mysqli_fetch_array($result)) {
									if ($city_id == $cityName['city_id'])
									{
										$selected = 'selected="selected"';
									}
									else
									{
										$selected = '';
									}
									?>
								
								<option value=<?php echo $cityName['city_id'];?>  <?php  echo $selected;?>><?php echo $cityName['city_title'];?></option>
								<?php }
								echo "</select>";
								?>					
								</div>
							  </div>

							  <div class="control-group">
								<label class="control-label">Hometown</label>
								<div class="controls">
								  <input class="input-xlarge focused validate[required,custom[onlyLetterSp],minSize[5],maxSize[50]] input-medium primary" id="name" type="text" name="user_meta[home_town]" value="<?php echo $hometown;?>">
								</div>
							  </div>


							  <div class="control-group">
								<label class="control-label">Language</label>
								<div class="controls">
								  
								   <select name="user_meta[language_known]" data-rel="chosen">
								<?php
								$result = $lookupObject->getLookupValue( "Languages Known" );
								echo '<option   value="">---Select the Language ---</option>';
								while($languageName = mysqli_fetch_array($result)) {
									if ($language_id == $languageName['lookup_key'])
									{
										$selected = 'selected="selected"';
									}
									else
									{
										$selected = '';
									}
									?>
								
								<option value=<?php echo $languageName['lookup_key'];?> <?php  echo $selected;?>><?php echo $languageName['lookup_value'];?></option>
								<?php }
								echo "</select>";
								?>
								  
								</div>
							  </div>

							  <div class="control-group">
								<label class="control-label">Political Views</label>
								<div class="controls">

								   <select name="user_meta[political_view]" data-rel="chosen">
								<?php
								$result = $lookupObject->getLookupValue( "Political View" );
								echo '<option   value="">---Select the Political View ---</option>';
								while($politicalView = mysqli_fetch_array($result)) {
									if ($political_views_id == $politicalView['lookup_key'])
									{
										$selected = 'selected="selected"';
									}
									else
									{
										$selected = '';
									}
									?>
								
								<option value=<?php echo $politicalView['lookup_key'];?> <?php  echo $selected;?>><?php echo $politicalView['lookup_value'];?></option>
								<?php }
								echo "</select>";
								?>								
								</div>
							  </div>

							  <div class="control-group">
								<label class="control-label">College</label>
								<div class="controls">
									<!--  select box  -->
									   <select name="education_organization" data-rel="chosen">
								<?php
								$sql ="SELECT * FROM qb_country_education_record";
								$result = mysqli_query($conn,$sql);
								echo '<option   value="">---Select the University ---</option>';
								while($organization = mysqli_fetch_array($result)) {
									if ($organization_id == $organization['qb_cer_id'])
									{
										$selected = 'selected="selected"';
									}
									else
									{
										$selected = '';
									}
									?>
								
								<option value=<?php echo $organization['qb_cer_id'];?> <?php  echo $selected;?>><?php echo $organization['organization_name'];?></option>
								<?php }
								echo "</select>";
								?>
								</div>
							  </div>


							  <div class="control-group">
								<label class="control-label">Education Grade</label>
								<div class="controls">
								 <input class="input-xlarge focused validate[required,custom[onlyLetterSp],minSize[5],maxSize[50]] input-medium primary" id="name" type="text" name="education_grade" value="<?php echo $education_grade;?>">
								</div>
							  </div>

							  <div class="control-group">
								<label class="control-label">From:</label>
								<div class="controls">
								  <input class="input-xlarge focused validate[required,custom[onlyLetterSp],minSize[5],maxSize[50]] input-medium primary" id="name" type="text" name="education_year_from" value="<?php echo $education_year_from;?>">
								</div>
							  </div>

							  <div class="control-group">
								<label class="control-label">To:</label>
								<div class="controls">
								  <input class="input-xlarge focused validate[required,custom[onlyLetterSp],minSize[5],maxSize[50]] input-medium primary" id="name" type="text" name="education_year_to" value="<?php echo $education_year_to;?>">
								</div>
							  </div>

		

							  <div class="control-group">
								<label class="control-label">About me</label>
								<div class="controls">
								  <input class="input-xlarge focused validate[required,custom[onlyLetterSp],minSize[5],maxSize[50]] input-medium primary" id="name" type="text" name="user_meta[about_me]" value="<?php echo $about_me;?>">
								</div>
							  </div>

							  <div class="control-group">
								<label class="control-label" for="selectError">Published</label>
								<div class="controls">
								  <select id="published" data-rel="chosen" class="input-xlarge" name="status">
								  <?php 
								  $result = $lookupObject->getLookupValue( "Member Status" );
								  while($statusList = mysqli_fetch_array($result)) {
								  	if ($rows['status'] == $statusList['lookup_key'])
								  	{
								  		$selected = 'selected="selected"';
								  	}
								  	else
								  	{
								  		$selected = '';
								  	}								
								  	?>
								  	<option value=<?php echo $statusList['lookup_key'];?> <?php  echo $selected;?>><?php echo $statusList['lookup_value'];?></option>
								  	<?php }?>
								  </select>
								</div>
							  </div>							  
							  
							  <div class="form-actions">
								<button type="submit" name="submit" class="btn btn-primary">Save</button>
								<a class="btn" href="user_table.php">Cancel</a>
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