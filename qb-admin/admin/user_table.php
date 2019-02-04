<?php session_start();

if(isset($_SESSION['id']))
{
	include("config.php");
	$id = $_SESSION['id'];
	$query = "SELECT * FROM admins 	WHERE id = '$id'";
	$sql = mysqli_query($conn, $query);
	$res = mysqli_fetch_assoc($sql);
	$res1= $res['email'];
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_lookup.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
	$memberObject = new member1();
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
						<a href="index.php">Home</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#">Users</a>
					</li>
				</ul>
			</div>
			
			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i> Users</h2>
						<div class="box-icon">
							</div>
					</div>

					<?php
						  			$query = "SELECT * FROM member";
									$sql = mysqli_query($conn, $query);
                     ?>	

					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th>Username</th>
								  <th>Date registered</th>
								  <th>Email</th>
								  <th>Status</th>
								  <th>Actions</th>
							  </tr>
						  </thead>   
						  <tbody>
                    <!--      <button onclick="myFunction()">Try it</button>   -->
                          
                          <script>
function toggleActivate(mem_id,status) {
	if (confirm("Are You Sure??") == true) {
       if(status==1)
	   window.location.href = 'active.php?id='+mem_id;
	   else 
	   window.location.href = 'inactive.php?id='+mem_id;
	    
    }     
}
</script>

						  <?php 	
						  while($row = mysqli_fetch_array( $sql )) { 
					$registeredDate=$memberObject->select_member_meta_value_for_lookupID($row['member_id'],"member_registered_on");
						  ?>


							<tr>
								<td><?php echo $row['username']; ?></td>
								<td class="center"><?php echo $registeredDate; ?></td>
								<td class="center"><?php echo $row['email']; ?></td>
								<td class="center">
									<?php 
									if($row['status'] == $activeID )
										{?>
                                        
									<a href="#"  onClick="toggleActivate(<?php echo $row['member_id']?>,0)" id="activebutton" class="btn btn-success">Deactivate</a>
									<?php } else {
									?>
									<a href="#"  id="inactivebutton" onClick="toggleActivate(<?php echo $row['member_id']?>,1)" class="btn btn-warning">Activate</a>									<?php } ?>
								</td>
								<td class="center">
									<a class="btn btn-success" href="user_details.php?id=<?php echo $row['member_id'];?>">
										<i class="icon-zoom-in icon-white"></i>  
										View                                            
									</a>
									<?php if( AccessLevel::getInstance()->isAllowed('users', 'edit_access' )):?>
									<a class="btn btn-info" href="user_edit.php?id=<?php echo $row['member_id']?>">
										<i class="icon-edit icon-white"></i>  
										Edit                                            
									</a>
									<?php endif;?>
									<?php if( AccessLevel::getInstance()->isAllowed('users', 'delete_access' )):?>
									<a  onclick ="return confirm('Are you sure you want to delete this user?')"" class="btn btn-danger" href="user_delete.php?id=<?php echo $row['member_id']?>">
										<i class="icon-trash icon-white"></i> 
										Delete
									</a>
									<?php endif;?>									
									
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