<?php
	ob_start();
	session_start();

	require_once('config.php');
	if(!isset($_SESSION['SESS_MEMBER_ID']))
	{
		header("location:index.php");
	}
	$session_member_id = $_SESSION['SESS_MEMBER_ID'];
	include 'includes/time_stamp.php';
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<title>Video Upload</title>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="css/wall.css"/>
<link rel="stylesheet" type="text/css" href="css/search.css"/>
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="stylesheet" type="text/css" href="css/uploadVideo.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>font-awesome/css/font-awesome.css">
<link rel="icon" href="images/favicon.ico" type="image" />
<link rel="shortcut icon" href="images/favicon.ico" type="image" />


<link rel="stylesheet" type="text/css" href="css/responsive.css" />


<script src="js/jquery1.7.2.js"></script>
<script type="text/javascript" src="jscolor/jscolor.js"></script>
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
 $("#fontsizeid").change(function(){
	 
	   switch(this.selectedIndex)
	   {
         	
		 case 1:  sizefont=14;
		 	 break;
		 case 2:  sizefont=16;
		 		  break;
		 case 3:  sizefont=18;
		 		  break;
		 case 4:  sizefont=20;
		 		  break;
		 case 5:  sizefont=22;
		 		  break;
		 case 6:  sizefont=24;
		 		  break;
		 case 7:  sizefont=26;
         		  break;	
         	 case 8:  sizefont=28;
         		  break;	  
                 default: sizefont=14;
		 		  break;
		}
		
            $("#ftitle").css('font-size', sizefont+'px');
           
}); 


$( ".color" ).change(function() {
  var value = $(this).val();
  $("#ftitle").css('color', '#'+value);
   
});


 
 
 
  $("#streamingid").change(function(){

var favcountries = document.getElementById("favouriteCountries"); 
	 
	   if(this.selectedIndex === 2) {
                favcountries.style.display = 'block';
            } else {
                favcountries.style.display = 'none';
            }
            
           
}); 
// This Function is called after clicking Upload Button.
$('#uploadFile').change(
    function(){
         
         var fsize = $('#uploadFile')[0].files[0].size; //get file size
           var ftype = $('#uploadFile')[0].files[0].type; // get file type
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
             alert(ftype+" Unsupported file type!");
         return false
        
           }
    
       //Allowed file size is less than 1000 MB (1048576 = 1 mb)
       if(fsize> 1048576000) 
       {
         alert(fsize +"Too big file! <br />File is too big, it should be less than 1000 MB.");
         return false
         
       }
         
         
         $(this).closest('form').trigger('submit'); //this button submits closest form and action page is action/video_upload.php
         $('#uploadPage').hide();//hiding upload page
         
    	 $('#ProcessPage').show();//showing process page
    	 
    	 uploadBoolCheck = true;
    });

 $('div.thumb').click(function(){
    var opt = $(this).attr("abc");
   if(opt==01)
    {
    $('#thumb1').addClass('thumb-active');
    $('#thumb2').removeClass('thumb-active');
	$('#thumb3').removeClass('thumb-active');
	$('#thumb4').removeClass('thumb-active');
	$('#thumb5').removeClass('thumb-active');
    }
    else if(opt==02)
    {
    $('#thumb1').removeClass('thumb-active');
    $('#thumb2').addClass('thumb-active');
	$('#thumb3').removeClass('thumb-active');
	$('#thumb4').removeClass('thumb-active');
	$('#thumb5').removeClass('thumb-active');
    }
    else if(opt==03)
    {
    $('#thumb1').removeClass('thumb-active');
    $('#thumb2').removeClass('thumb-active');
	$('#thumb3').addClass('thumb-active');
	$('#thumb4').removeClass('thumb-active');
	$('#thumb5').removeClass('thumb-active');
    }
	else if(opt==04)
    {
     $('#thumb1').removeClass('thumb-active');
    $('#thumb2').removeClass('thumb-active');
	$('#thumb3').removeClass('thumb-active');
	$('#thumb4').addClass('thumb-active');
	$('#thumb5').removeClass('thumb-active');
    }
     else if(opt==05)
    {
    $('#thumb1').removeClass('thumb-active');
    $('#thumb2').removeClass('thumb-active');
	$('#thumb3').removeClass('thumb-active');
	$('#thumb4').removeClass('thumb-active');
	$('#thumb5').addClass('thumb-active');
    }
    
    DefaultImageThumbnailName = "new"+ nameWithoutExt + opt +".png"; 
});
//function to uploAD video
 $('#publish_video').click(function(){
 uploadBoolCheck = false;
    var ftitle = $('#ftitle').val();
	var title_color = $('.color').val();
    var title_size = $('#fontsizeid').val();
    var fdescription = $('#fdescription').val();
    var fcategory = $('#fcategory').val();
    var type = $('#type').val();
    var streaming = $("#streamingid").val();
    var countries = "";
	var custom_thumb = $("#custom_hidden_value").val();
    if(streaming == "countrywall"){
    countries = $("#countries").val();}
    
    $.post('action/videoUpExec.php', { title : ftitle , desc : fdescription, category : fcategory, tpe : type, strm : streaming, country : countries, defaultthumbnail : DefaultImageThumbnailName, nwe : nameWithoutExt,title_size:title_size, title_color:title_color,custom_thumb: custom_thumb }, function(data) {
    window.location.href= "qcast.php";
     });
    
    
    
});

 
 var bar1 = $('#bar1');
 var percent1 = $('#percent1');
 //progress bar for processing and calling unload function
 setInterval(function(){
        
        if(logRunningConditionStatus){
        $.post('action/ffmpegProgRes.php', { logfilepath : logfileoutput }, function(data) {
        
        bar1.width(data);
        percent1.html(data);
        
    }); }
}, 100);
		
 });
 </script>
</head>
<body id="upload_mob_page">
<div id="wrapper" class="videoWrapper">
<?php 
include('includes/header.php');

?>
<div id="mainbody"> 
<div id="uploadPage"><!--First Division with upload button present-->

  
<div id="button">
<form id="video_upload_form" name="video_upload" method="post" enctype="multipart/form-data" action="action/video_upload.php">
<div id="typefile" >
<div class="file_upload">
		<input type="file" id="uploadFile" class="inputbox" type="file" size="45" name="uploadedfile" required="required" accept="video/*" capture="camcorder" value="Start Recording">
	</div>
<!--<input id="uploadFile" class="inputbox" type="file"  name="uploadedfile" required="required" accept="video/*" capture="camcorder" value="Start Recording" >-->
</div><!--end of typefile div-->

</form>
</div>


</div><!-- End UploadPage -->

<div id="ProcessPage"><!--Second Division with Progress bar forms and thumbnails.-->
<!-- Left Column -->

<div id="leftContainer">
	
 <!--<form name="Basic_Data" method="post" action="action/updateThumbnail.php"> -->
 <input type="hidden" name="member_id" value="<?php echo $session_member_id;?>" />
	   	
	 
	    <select name="category" id="fcategory" class="required inputbox text3">
	    
	  	  <?php $group_sql = mysql_query("select * from videos_category");
			while($group_res = mysql_fetch_array($group_sql))
			{
			?>
		<option value="<?php echo $group_res['id'];?>"><?php echo $group_res['name'];?></option>
    		<?php } ?>    
	    
		    </select><br /><br />
		    
		    <input type="radio" checked="checked" value="0" name="type" id="type"/> Public 
	    	  <input type="radio" id="type" name="type" value="1"  /> Private
          <br /> <br />
          
         <select id="streamingid" class="required inputbox text3" name="streaming" >
		
		<option value="countrywall">Country</option> 
    	</select>
        <br /> <br />
        <div id="favouriteCountries"  >
<select id="countries" class="inputbox" name="countries" >
<option value="0">Select</option>
<?php $favcountries_sql = mysql_query("select * from geo_country where country_id!=207 ") or die(mysql_error());
while($favcountries_res = mysql_fetch_array($favcountries_sql))
{
?>
<option value="<?php echo $favcountries_res['country_id'];?>"><?php echo $favcountries_res['country_title'];?></option>
<?php } ?>    
</select>
</div>
    
     <textarea name="description" rows="5" placeholder="Description" id="fdescription" class="inputbox text3" type="text" value="" placeholder="Description">Sample description</textarea><br /><br />
     
</form>

 <div id="publish">
		
		    <a href="#" class="myButton" id="publish_video">Save</a> &nbsp; &nbsp; &nbsp;
		     <input type="button" name="add_video" class="myButton" value="BACK TO MYVIDEOS" onclick="window.open('myvideos.php','_self');" />
    
	   </div>  

	
</div><!-- end leftContainer -->


<div class="rightContainer"> 
   
   <div class="progress">
   	<span style="position:absolute;">Uploading..</span>  
     <div class="bar"></div >  
     <div class="percent">0%</div >  
   </div>
   <div id="progress1" >  
     <span style="position:absolute;">Processing..</span>
     <div id="bar1" ></div >  
     <div id="percent1">1%</div >  
   </div>    
   
   <div id="status"></div> 
   


 

	<div id="video">
       		<span id="mesg"><h4>Preveiw will be available after processing the video</h4></span>
       		<div id="vidplayer">
		</div>
	</div>	
	
	<div id="videoTitle">
		 <input type="text" name="title" placeholder="Title" id="ftitle" class="required text3 inputbox" value="Mobile Upload"/>
		
		 <select id="fontsizeid" class="required inputbox text3" name="fontsize" style="width:90px; padding:0px;" >
		 	<option value="12">Size</option>
			<option value="14">14px</option>
			<option value="16">16px</option>
			<option value="18">18px</option> 
			<option value="20">20px</option>
			<option value="22">22px</option>
			<option value="24">24px</option>
			<option value="26">26px</option>
			<option value="28">28px</option>
			
	    	</select>
	    	
		  <input id="colorpickbuts" class="color" value=""><label for="colorpickbuts"><img id="colorpicks" src="../images/DigitalColor Meter.png" alt="..." height="40px" width="40px" style="margin-bottom: -15px;"/></label>
		
	</div>
	    
	    
      
	 

<input type="hidden" value="save" name="action"></input>
<input type="hidden" value="" name="groupid"></input>
<!--<input class="button validateSubmit" type="submit" value="Upload" style="width:80px;padding:0px;"></input>
<input class="button" type="button" value="Cancel" onclick="history.go(-1);return false;" style="width:80px;padding:0px;"></input>-->
<input type="hidden" value="1" name="326e4f73c340f29d8ce547ad40dc0e1b"></input>


 <!--</form>-->
 <div id="para">
 <h4>Thumbnails</h4><br/>
 <span id="thumbmesg">Thumbnail selections will appear when the video has finished processing.</span>
 </div>
 
  
 <div class="thumbnails">
     <div id="thumb1" class="thumb" abc="01">
       <div id="overlay101" class="overlay1">
       <span id="plus01" class="plus">SELECT</span>
       </div>
     </div>
     <div id="thumb2" class="thumb" abc="02">
       <div id="overlay102" class="overlay1">
       <span id="plus02" class="plus">SELECT</span>
       </div>
     </div>
     <div id="thumb3" class="thumb" abc="03">
       <div id="overlay103" class="overlay1">
       <span id="plus03" class="plus">SELECT</span>
       </div>
     </div>
      <div id="thumb4" class="thumb" abc="04">
       <div id="overlay104" class="overlay1">
       <span id="plus04" class="plus">SELECT</span>
       </div>
     </div>
     <div id="thumb5" class="thumb" abc="05">
       <div id="overlay105" class="overlay1">
       <span id="plus05" class="plus">SELECT</span>
       </div>
     </div>
     <input type="hidden" id="custom_hidden_value" value="" />
   </div><!--thumbnails -->
      <script src="js/form.js"></script>
      
       <!-- select or dropdown enhancer -->

	<script src="assets/chosen-jquery/chosen.jquery.js"></script> 

<script type="text/javascript">

    var config = {

      '.chosen-select'           : {},

      '.chosen-select-deselect'  : {allow_single_deselect:true},

      '.chosen-select-no-single' : {disable_search_threshold:10},

      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},

      '.chosen-select-width'     : {width:"95%"}

    }

    for (var selector in config) {

      $(selector).chosen(config[selector]);

    }

  </script>    
    
   <script>  
 (function() {  
 
 var bar = $('.bar');  
 var percent = $('.percent'); 
  var progress = $('.progress'); 
 var status = $('#status');
 $('form').ajaxForm({ 
 beforeSend: function() {
     progress.show();
     status.empty();  
     var percentVal = '0%';  
     bar.width(percentVal)  
     percent.html(percentVal);  
   },  
   uploadProgress: function(event, position, total, percentComplete) {  
     
     var percentVal = percentComplete + '%';  
     bar.width(percentVal)  
     percent.html(percentVal);
    
   },  
   complete: function(xhr) {  
     bar.width("100%");  
     percent.html("100%");  
     videoname = xhr.responseText;
     nameWithoutExt = videoname.substr(0,videoname.lastIndexOf("."));
     DefaultImageThumbnailName = "new"+ nameWithoutExt +"02.png";
     logfileoutput = nameWithoutExt + ".txt";
     progress.hide();
     logRunningConditionStatus = true;
     $('#bar1').width('1%');
     $('#percent1').html('1%');
     $('#progress1').show();
     $.post('action/video_convert.php', { video_name: videoname, logFile: logfileoutput  }, function(result) {
	 $('#progress1').hide();
	 logRunningConditionStatus = false;
	 
	 $('#publish_video').removeAttr('disabled');
	 status.html(result);
	 $('#mesg').hide();
	 $('#vidplayer').append('<video id="videojsidid" class="" controls autoplay preload="none" width="200" height="150" poster="uploadedvideo/videothumb/new'+ nameWithoutExt +'02.png" data-setup="{}"><source id="mp4src" src="uploadedvideo/new'+ nameWithoutExt +'.mp4" type="video/mp4" /><source id="oggsrc" src="uploadedvideo/new'+ nameWithoutExt +'.ogg" type="video/ogg" /><source id="webmsrc" src="uploadedvideo/new'+ nameWithoutExt +'.webm" type="video/webm" /></video>');
	 $('#vidplayer').show();
	$('#thumb1').css("background", "url(uploadedvideo/videothumb/new"+ nameWithoutExt +"01.png) no-repeat");
	 $('#thumb2').css("background", "url(uploadedvideo/videothumb/new"+ nameWithoutExt +"02.png) no-repeat");
	 $('#thumb3').css("background", "url(uploadedvideo/videothumb/new"+ nameWithoutExt +"03.png) no-repeat");
	 $('#thumb4').css("background", "url(uploadedvideo/videothumb/new"+ nameWithoutExt +"04.png) no-repeat");
	 $('#thumb5').css("background", "url(uploadedvideo/videothumb/new"+ nameWithoutExt +"05.png) no-repeat");
	 $('#thumb1').css("background-size", "195px 120px");
	 $('#thumb2').css("background-size", "195px 120px");
	 $('#thumb3').css("background-size", "195px 120px");
	 $('#thumb4').css("background-size", "195px 120px");
	 $('#thumb5').css("background-size", "195px 120px");
	 $('#thumbmesg').hide();
	 $('#para').hide();
	 $('.thumbnails').show();
	 
	}); 
	
    
   }  
 });   
 })(); 
 window.onbeforeunload = function(){
				if(uploadBoolCheck){
	    		    return '<?php echo $lang['You have unsaved changes'];?>!';
		        }
			}    
 </script>
     
 
   </div>  
     </div><!--basicInfo Eniv><!--End column left div-->
</div><!--End ProcessPage div-->
</div><!--End mainbody div-->

<?php include 'includes/footer.php';?>
</div><!--End wrapper div-->
</body>
</html>