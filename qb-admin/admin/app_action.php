<?php 

 session_start();

if(!isset($_SESSION['id']))
{
	header("location:login.php");
}
include("config.php");
$id = $_SESSION['id'];

$query = "SELECT * FROM admins WHERE id = '$id'";
$sql = mysqli_query($conn,$query);
$res = mysqli_fetch_array($sql);
$res1= $res['email'];
$id=$_REQUEST['id'];
if(isset($_REQUEST['delete']))
{
	mysqli_query($conn,"delete from app where id='$id'");
	header("location:apps_table.php");
	
}
else
{
	$query=mysqli_query($conn,"select * from app where id='$id'");
	$res=mysqli_fetch_assoc($query);
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
						<h2><i class="icon-info-sign"></i> New App</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                    
                    <div id="uploadPage"><!--Start upload form-->
                    
                    <form class="form-horizontal" method="post" action="app_add1.php"  enctype="multipart/form-data">
						<fieldset>
                        <legend>Input Apps Details</legend>
							<div class="control-group">
                            <table class="table table-striped table-bordered bootstrap-datatable datatable">
						    
						  <tbody>
                          
                          <tr>
								<td class="center"> <label >App Name</label></td>
                                <td class="center">  <input type="text" id="name" name="name" value="<?php echo $res['name'];?>"></td>
                                
                                </tr>
                                <tr>
                                
                                <td class="center"> <label  >App URL</label></td>
								<td class="center"> <input type="text" id="url" name="url" value="<?php echo $res['url'];?>"></td>
								</tr>
                                <tr>
                                <td class="center">Select Image</td>
                                <td class="center"><input id="file" name="file" type="file" accept="image/*"></td>
                                <!--<td class="center"></td>-->
                                </tr>
                                
                                <td class="center"> <label  >Published</label></td>
								<td > 
								<select id="published" data-rel="chosen" class="input-xlarge" name="status">
									<option value="1" <?php if($res['status'] == 1) echo 'selected' ?>>Published</option>
									<option value="0" <?php if($res['status'] == 0) echo 'selected' ?>>Unpublished</option>									
								  </select>
								</td>
								</tr>                                
							
						  </tbody>
					  </table>
                          
 							<div class="form-actions">
								<input type="hidden" name="update" id="update" value="<?php echo $id; ?>">

								<button type="submit" class="btn btn-primary" >Save changes</button>
								<button type="button" class="btn" onclick="window.open('apps_table.php','_self');">Cancel</button>
							  </div>                           
                           
                              
						</fieldset>
						
					</form>
                    
                    </div>
                    <!--end upload form-->
                    
                    <!--start processing form-->
                    
<div id="ProcessPage" style="display:none"><!--Second Division with Progress bar forms and thumbnails.-->

<div class="rightContainer">   

   <div class="progress progress-success" style="margin-bottom: 9px;" id="progress">
		<div class="bar" id="bar"></div>
   </div>

	<div class="progress progress-danger progress-striped" style="margin-bottom: 9px;" id="progress1">
		<div class="bar" id="bar1"></div>
	</div>

   <div id="status"></div> 

	<div id="video">

       		<span id="mesg"><h4><?php echo 'Preveiw will be available after processing the video';?></h4></span>

       		<div id="vidplayer">

		</div>

	</div>	

	

	<div id="videoTitle">
    
    <form class="form-horizontal">
						<fieldset>
                        <legend>Ad Settings </legend>
							<div class="control-group">
							  <label class="control-label" for="fileInput">Ads Name</label>
							  <div class="controls">
								<input type="text" name="title" id="ftitle" class="input-xlarge" value=""/>
							  </div>
							</div>
                            
                            <div class="control-group">
								<label class="control-label" for="selectError">Published</label>
								<div class="controls">
								  <select id="published" data-rel="chosen" class="input-xlarge" name="published">
									<option value="1">Published</option>
									<option value="0">Unpublished</option>									
								  </select>
								</div>
							  </div>
                              
                              <div class="control-group">
							  <label class="control-label" for="fileInput">Click url</label>
							  <div class="controls">
								<input type="text" name="click_url"  id="click_url" class="input-xlarge" value=""/>
							  </div>
							</div>
                            
                            <div class="form-actions">
								<button type="button" class="btn btn-primary" id="publish_video">Save changes</button>
								<button type="button" class="btn" onclick="window.open('video_ads.php','_self');">Cancel</button>
							  </div>

						</fieldset>
					</form>
    
		 


	</div>
</div>  

</div>

					<!--end processing form-->
                    
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
    <script src="../../js/form.js"></script>
    
    <script type="text/javascript">

 //Global Variables

 var videoname="";   //Container For Storing actual trimmed video name with time stamp with Extension.

 var logfileoutput = ""; //logfile of ffmpe conversion

 var logRunningConditionStatus = false;//for preventing set interval jquery post

 var nameWithoutExt = ""; //video name without extension

 var uploadBoolCheck = false;//for preventing page refresh while processing by window unload function

 var DefaultImageThumbnailName = "";//for storing default thumbnail name

 var sizefont=14;
 

 $(document).ready(function() {
 $('#publish_video').attr('disabled','disabled');
 
// This Function is called after clicking Upload Button.

$('#uploadFile').change(function(){         

         var fsize = $('#uploadFile')[0].files[0].size; //get file size
         var ftype = $('#uploadFile')[0].files[0].type; // get file type           
         var filename = $('#uploadFile').val();
		 var filename = filename.substr(0,filename.lastIndexOf("."));
		 //$('#ftitle').val(filename);

        //allow file types 

        //validation of mime types of uploaded video file

      switch(ftype)

           {

            case 'video/avi': 

            case 'video/mpeg': 

            case 'video/quicktime': 

            case 'video/webm':

            case 'video/ogg':

            case 'video/x-matroska':

            case 'video/x-ms-wmv':

            case 'video/x-flv':

            case 'video/flv':

            case 'video/mp4':

            break;

            default:

             alert(ftype + "Unsupported file type!");

             $(this).closest('form').preventDefault();

         //return false;

        

           }

    

       //Allowed file size is less than 1000 MB (1048576 = 1 mb)

       if(fsize> 1048576000) 

       {

         alert(fsize + "Too big file! File is too big, it should be less than 1000 MB");

         return false;

         

       }

         

         

         $(this).closest('form').trigger('submit'); //this button submits closest form and action page is action/video_upload.php

         $('#uploadPage').hide();//hiding upload page
    	 $('#ProcessPage').show();//showing process page  	 

    	 uploadBoolCheck = true;

    });
//function to uploAD video

 $('#publish_video').click(function(){

    var ftitle = $('#ftitle').val();
	var published = $('#published').val();
	var click_url = $('#click_url').val();

    $.post('action/video_ads_insert.php', { title : ftitle , published : published, click_url : click_url,nwe : nameWithoutExt}, function(data) {

    window.location.href= "video_ads.php";

     });
});



 

 var bar1 = $('#bar1');

 var percent1 = $('#percent1');

 //progress bar for processing and calling unload function

 setInterval(function(){       

        if(logRunningConditionStatus){

        $.post('action/ffmpegProgRes.php', { logfilepath : logfileoutput }, function(data) {        

        bar1.width(data);

        bar1.html(data);

        

    }); }

}, 100);

 var bar = $('#bar');  

 //var percent = $('.percent'); 

  var progress = $('#progress'); 

 var status = $('#status');


 $('form').ajaxForm({ 

 beforeSend: function() {

     progress.show();

     status.empty();  

     var percentVal = '0%';  

     bar.width(percentVal)  

     bar.html(percentVal);  

   },  

   uploadProgress: function(event, position, total, percentComplete) {  

     

     var percentVal = percentComplete + '%';  

     bar.width(percentVal)  

     bar.html(percentVal);

    

   },  

   complete: function(xhr) {  

     bar.width("100%");  

     bar.html("100%");  

     videoname = xhr.responseText;

     nameWithoutExt = videoname.substr(0,videoname.lastIndexOf("."));
     
     DefaultImageThumbnailName = "new"+ nameWithoutExt +"02.png";

     logfileoutput = nameWithoutExt + ".txt";

     progress.hide();

     logRunningConditionStatus = true;

     $('#bar1').width('1%');

     $('#bar1').html('1%');

     $('#progress1').show();

     $.post('action/video_ads_convert.php', { video_name: videoname, logFile: logfileoutput  }, function(result) {

	 $('#progress1').hide();

	 logRunningConditionStatus = false;
	 uploadBoolCheck = false;
$('#publish_video').removeAttr('disabled');
	 status.html(result);

	 $('#mesg').hide();	 

	 $('#vidplayer').append('<video id="videojsidid" class="" controls autoplay preload="none" width="200" height="150" data-setup="{}"><source id="mp4src" src="<?php  echo $base_url;?>uploadedvideo/ads/new'+ nameWithoutExt +'.mp4" type="video/mp4" /><source id="oggsrc" src="<?php  echo $base_url;?>uploadedvideo/ads/new'+ nameWithoutExt +'.ogg" type="video/ogg" /><source id="webmsrc" src="<?php  echo $base_url;?>uploadedvideo/ads/new'+ nameWithoutExt +'.webm" type="video/webm" /></video>');

	 $('#vidplayer').show();
	});

   }  

 });   

 });     		

        	window.onbeforeunload = function(){
				if(uploadBoolCheck){
	    		    return 'You have unsaved changes!';
		        }
			}

 </script>
	
		
</body>
</html>
	
    <?php 
}


?>