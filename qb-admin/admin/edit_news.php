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
	?>


<!DOCTYPE html>
<html lang="en">
<head>
	<!--
		Charisma v1.0.0

		Copyright 2012 Muhammad Usman
		Licensed under the Apache License v2.0
		http://www.apache.org/licenses/LICENSE-2.0

		http://usman.it
		http://twitter.com/halalit_usman
	-->
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
						<a href="index.php">Home</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#">News</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2>News</h2>
						
					</div>

					<?php
						  			
									$id = $_GET['id'];
									
									 $query1= "SELECT news.url, news.image_url, news.video_url,  news.news_id,  news.country_id, news.member_id, news.category_id, news.title, news_category.name, members.FirstName,
									 geo_country.country_title, news.date_created, news.status FROM news 
									 INNER JOIN news_category ON news.category_id=news_category.id
									 INNER JOIN members ON news.member_id=members.member_id
									 INNER JOIN geo_country ON news.country_id= geo_country.country_id where news_id=".$id ;
									 

									  
									$sql1 = mysqli_query($conn,$query1);
									  $res = mysqli_fetch_array($sql1);
									 ?>	

						<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> News details</h2>
						
					</div>
					<div class="box-content">
						<form class="form-horizontal" action="news_action_edit.php" method="post">
						  <fieldset>
							
							<div class="control-group">
								<label class="control-label">Title</label>
								<div class="controls">
								<input class="input-xlarge focused validate[required,custom[onlyLetterSp],minSize[5],maxSize[50]] input-medium primary" id="title_name" type="text" name="title_name" value="<?php echo $res['title'];?>">
								  <input type="hidden" name="news_id" value="<?php echo $res['news_id'];?>">
								</div>
							  </div>
							  
							  <div class="control-group">
								<label class="control-label">Category</label>
								<div class="controls">
								 <select name="category_id" data-rel="chosen">
								<?php
								$sql ="SELECT * FROM news_category";
								$result = mysqli_query($conn,$sql);
								echo '<option   value="">---Select the Category name---</option>';
								while($categoryName = mysqli_fetch_array($result)) {
								 if ($res['category_id'] == $categoryName['id'])
								    {
								        $selected = 'selected="selected"';
								    }
								    else{
								    	$selected = '';
								    
								    }
																	//echo '<option   value="'.$categoryName['id'].'">'.$categoryName['name'].'</option>';
								?>
								<option   value=<?php  echo $categoryName['id'];?> <?php  echo $selected;?>><?php  echo $categoryName['name'];?></option>
								<?php }
								echo "</select>";
								?>
								</div>
							  </div>
							 
							  <div class="control-group">
								<label class="control-label">Member</label>
								<div class="controls">
								 <select name="members_id" data-rel="chosen">
								<?php
								$sql ="SELECT * FROM members";
								$result = mysqli_query($conn,$sql);
								echo '<option   value="">---Select the Members name---</option>';
								while($membersName = mysqli_fetch_array($result)) {
									if ($res['member_id'] == $membersName['member_id'])
									{
										$selected = 'selected="selected"';
									}
									else
									{
										$selected = '';
									}
									?>
								
								<option   value=<?php echo $membersName['member_id'];?>  <?php  echo $selected;?>><?php echo $membersName['FirstName'];?></option>
								<?php }
								echo "</select>";
								?>
								</div>
							  </div>
							  
							   <div class="control-group">
								<label class="control-label">Country</label>
								<div class="controls">
								 <select name="country_id" data-rel="chosen">
								<?php
								$sql ="SELECT * FROM geo_country";
								$result = mysqli_query($conn,$sql);
								echo '<option   value="">---Select the Country name---</option>';
								while($countryName = mysqli_fetch_array($result)) {
									if ($res['country_id'] == $countryName['country_id'])
									{
										$selected = 'selected="selected"';
									}
									else
									{
										$selected = '';
									}
									?>
								
								<option value=<?php echo $countryName['country_id'];?>  <?php  echo $selected;?>><?php echo $countryName['country_title'];?></option>
								<?php }
								echo "</select>";
								?>
								</div>
							  </div>
							<div class="control-group">
								<label class="control-label">Url</label>
								<div class="controls">
								<textarea class="input-xlarge focused medium primary" id="url" type="text" name="url"><?php echo $res['url'];?></textarea>
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label">Image Url</label>
								<div class="controls">
								<textarea class="input-xlarge focused medium primary" id="image_url" type="text" name="image_url"><?php echo $res['image_url'];?></textarea>
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label">Video Url</label>
								<div class="controls">
								<textarea class="input-xlarge focused medium primary" id="video_url" type="text" name="video_url"><?php echo $res['video_url'];?></textarea>
								</div>
							  </div>
								<div class="control-group">
								<label class="control-label" for="selectError">Published</label>
								<div class="controls">
								  <select id="published" data-rel="chosen" class="input-xlarge" name="status">
									<option value="1" <?php if($res['status'] == 1) echo 'selected' ?>>Published</option>
									<option value="0" <?php if($res['status'] == 0) echo 'selected' ?>>Unpublished</option>									
								  </select>
								</div>
							  </div>							  
							
							  <div class="form-actions">
								<button type="submit" name="submit" class="btn btn-primary">Save</button>
								<a class="btn" href="newstable.php">Cancel</a>
							  </div>
							
							
						  </fieldset>
						</form>   

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
