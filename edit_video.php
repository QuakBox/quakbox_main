<?php
	ob_start();
	session_start();
	
	if(isset($_SESSION['lang']))
	{	
		include('common.php');
	}
	else
	{
		include('Languages/en.php');
		
	}

	require_once('config.php');
	if(!isset($_SESSION['SESS_MEMBER_ID']))
	{
		header("location: ".$base_url."login.php?back=". urlencode($_SERVER['REQUEST_URI']));
		exit();
	}
	$session_member_id = $_SESSION['SESS_MEMBER_ID'];
	include 'includes/time_stamp.php';
	$video_id = $_REQUEST['id'];
	
	$check_query = mysqli_query($con, "SELECT user_id FROM videos WHERE video_id = '$video_id'");
	$check_res = mysqli_fetch_array($check_query);
	$video_user_id = $check_res['user_id'];	
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_header.php');
?>


<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/wall.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/search.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/style.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/editVideo.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/invalid_link.css"/>

<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>font-awesome/css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/responsive.css" />
<link rel="icon" href="<?php echo $base_url;?>images/favicon.ico" type="image" />
<link rel="shortcut icon" href="<?php echo $base_url;?>images/favicon.ico" type="image" />

<script src="<?php echo $base_url;?>js/jquery1.7.2.js"></script>
<script src="<?php echo $base_url;?>js/form.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>jscolor/jscolor.js"></script>
<script src="<?php echo $base_url;?>js/youtube.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/youtube.css"/>


<style>
html {
	background-color:rgba(233, 234, 237, 0.67) !important;
}
#custom-message {
    position:absolute;
    z-index: 1;
    margin-top: 10px;
    margin-left: 10px;
}

.thumb-active{
	box-shadow:10px 10px 5px #888;
	-ms-box-shadow:10px 10px 5px #888;
	-webkit-box-shadow:10px 10px 5px #888;
	-moz-box-shadow:10px 10px 5px #888;
	-o-box-shadow:10px 10px 5px #888;
	border:2px solid;
	border-radius:20px;
}
#ftitle {
	height:20px!important;
}
</style>
<script type="text/javascript" src="<?php echo $base_url;?>jscolor/jscolor.js"></script>
<link rel="stylesheet" href="<?php echo $base_url;?>video-ads/css/videoPlayerMain.css" type="text/css">
  <link rel="stylesheet" href="<?php echo $base_url;?>video-ads/css/videoPlayer.theme1.css" type="text/css">
  <link rel="stylesheet" href="<?php echo $base_url;?>video-ads/css/preview.css" type="text/css" media="screen"/>

  
  <script src="<?php echo $base_url;?>video-ads/js/IScroll4Custom.js" type="text/javascript"></script>
  <script src='<?php echo $base_url;?>video-ads/js/THREEx.FullScreen.js'></script>
  <script src="<?php echo $base_url;?>video-ads/js/videoPlayer.js" type="text/javascript"></script>
  <script src="<?php echo $base_url;?>video-ads/js/Playlist.js" type="text/javascript"></script> 


  
<script type="text/javascript">
$(document).ready(function() {
var nua = navigator.userAgent;
var is_android = ((nua.indexOf('Mozilla/5.0') > -1 && nua.indexOf('Android ') > -1 &&     nua.indexOf('AppleWebKit') > -1) && !(nua.indexOf('Chrome') > -1));
//check browser is safari or not
if(!is_android){
//check browser is safari or not
if (navigator.userAgent.search("Safari") >= 0 && navigator.userAgent.search("Chrome") < 0) 
{ 
var haveqt = false;
if (navigator.plugins) {
    for (i=0; i < navigator.plugins.length; i++ ) {
        if (navigator.plugins[i].name.indexOf
        ("QuickTime") >= 0)
        { haveqt = true; }
    }
}

if ((navigator.appVersion.indexOf("Mac") > 0)
    && (navigator.appName.substring(0,9) == "Microsoft")
    && (parseInt(navigator.appVersion) < 5) )
{ haveqt = true; }   
if(!haveqt){	
	$('#error-quick').show();
}        
}
}


});
</script>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function($)
    {
    var title1 = $('#title').val();
		var desc1 = $('#description').val();
		var mp4videopath = $('#mp4video').val()
		var oggvideopath = $('#oggvideo').val()
		var webmvideopath = $('#webmvideo').val()
		var thumb = $('#thumb').val()
		var adsmp4videopath = $('#adsmp4video').val()
		var adsoggvideopath = $('#adsoggvideo').val()
		var adswebmvideopath = $('#adswebmvideo').val()
		var ads = $('#ads').val();
		if(ads == 1){
			var adsFlag = true;
		}else {
			var adsFlag = false;
		}
		var click_url = $('#click_url').val();
		var fetch_url = $('#fetch_url').val();
		
        videoPlayer = $("#video-edit").Video({
            autoplay:false,
            autohideControls:4,
            videoPlayerWidth:640,
            videoPlayerHeight:320,
            posterImg:thumb,
            fullscreen_native:false,
            fullscreen_browser:true,
            share:[{
                show:true,
                facebookLink:"https://www.facebook.com/sharer/sharer.php?u="+fetch_url,
                twitterLink:"https://twitter.com/intent/tweet?source=webclient&text="+fetch_url,                
                pinterestLink:"http://pinterest.com/pin/create/bookmarklet/?url="+fetch_url,
                linkedinLink:"http://www.linkedin.com/cws/share?url="+fetch_url,
                googlePlusLink:"https://plus.google.com/share?url="+fetch_url,
                deliciousLink:"https://delicious.com/post?url="+fetch_url
            }],
            logo:[{
                show:false,
                clickable:true,
                path:"images/logo/logo.png",
                goToLink:"http://codecanyon.net/",
                position:"top-right"
            }],
             embed:[{
                show:false,
                embedCode:'<iframe src="www.yoursite.com/player/index.html" width="746" height="420" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>'
            }],
            videos:[{
                id:0,
                title:"Oceans",
                mp4:mp4videopath,
                webm:webmvideopath,
                ogv:oggvideopath,
                info:desc1,

                popupAdvertisementShow:false,
                popupAdvertisementClickable:false,
                popupAdvertisementPath:"images/advertisement_images/ad2.jpg",
                popupAdvertisementGotoLink:"http://codecanyon.net/",
                popupAdvertisementStartTime:"00:02",
                popupAdvertisementEndTime:"00:10",

                videoAdvertisementShow:adsFlag,
                videoAdvertisementClickable:true,
                videoAdvertisementGotoLink:click_url,
                videoAdvertisement_mp4:adsmp4videopath,
                videoAdvertisement_webm:adswebmvideopath,
                videoAdvertisement_ogv:adsoggvideopath
            }]
        });

    });

  </script>

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

DefaultImageThumbnailName = "new"+ nameWithoutExt +"02.png";
 $('div.thumb').click(function(){
    var opt = $(this).attr("abc");
	var thumb_value = $(this).attr("data-value");
    if(opt==01)

    {

    $('#thumb1').addClass('thumb-active');

    $('#thumb2').removeClass('thumb-active');

	$('#thumb3').removeClass('thumb-active');

	$('#thumb4').removeClass('thumb-active');

	$('#thumb5').removeClass('thumb-active');
	
	$('#thumb6').removeClass('thumb-active');

    }

    else if(opt==02)

    {

    $('#thumb1').removeClass('thumb-active');

    $('#thumb2').addClass('thumb-active');

	$('#thumb3').removeClass('thumb-active');

	$('#thumb4').removeClass('thumb-active');

	$('#thumb5').removeClass('thumb-active');
	
	$('#thumb6').removeClass('thumb-active');

    }

    else if(opt==03)

    {

    $('#thumb1').removeClass('thumb-active');

    $('#thumb2').removeClass('thumb-active');

	$('#thumb3').addClass('thumb-active');

	$('#thumb4').removeClass('thumb-active');

	$('#thumb5').removeClass('thumb-active');
	
	$('#thumb6').removeClass('thumb-active');

    }

	else if(opt==04)

    {

     $('#thumb1').removeClass('thumb-active');

    $('#thumb2').removeClass('thumb-active');

	$('#thumb3').removeClass('thumb-active');

	$('#thumb4').addClass('thumb-active');

	$('#thumb5').removeClass('thumb-active');
	
	$('#thumb6').removeClass('thumb-active');

    }

     else if(opt==05)

    {

    $('#thumb1').removeClass('thumb-active');

    $('#thumb2').removeClass('thumb-active');

	$('#thumb3').removeClass('thumb-active');

	$('#thumb4').removeClass('thumb-active');

	$('#thumb5').addClass('thumb-active');
	
	$('#thumb6').removeClass('thumb-active');

    }
	
	else if(opt==06)

    {
		$('#thumb1').removeClass('thumb-active');
    	 $('#thumb2').removeClass('thumb-active');
	 	 $('#thumb3').removeClass('thumb-active');
	     $('#thumb4').removeClass('thumb-active');
	     $('#thumb5').removeClass('thumb-active');	
	     $('#thumb6').addClass('thumb-active');    

    }
    $('#dthumb').val(thumb_value);    
});
//function to uploAD video
 $('#publish_video').click(function(){
    var ftitle = $('#ftitle').val();
    var title_color = $('.color').val();
    var title_size = $('#fontsizeid').val();
    var fdescription = $('#fdescription').val();
    var fcategory = $('#fcategory').val();
    var type = $('#type').val();
    var video_id = $('#video_id').val();
    var dthumb = $('#dthumb').val();
	var custom_thumb = $("#custom_hidden_value").val();
   
    $.post('action/edit-video-exec.php', { title : ftitle , desc : fdescription, category : fcategory, tpe : type, defaultthumbnail : dthumb , title_size:title_size, title_color:title_color, video_id : video_id,custom_thumb: custom_thumb }, function(data) {    
    
     });
	 alert("Successfully updated");
    window.location.href= "myvideos.php"; 
    
});

//function to delete custom  video thumb
 $('#delete_custom_thumb').click(function(){
	var video_id = $('#video_id').val();
	    
    $.post('action/delete_custom_thumb.php', { video_id : video_id}, function(data) { 
	window.location.href= "edit_video.php?id=" + video_id;       
    });	     
});

$('#thumbfile').change(function(){
	 
	 $('#custom_thumb_form').ajaxForm({ 
	 
     beforeSend: function() {
		  $("#imageloadstatus").show();
          $("#imageloadbutton").hide();    

     },  

     success: function (html) {		 
		 $("#imageloadstatus").hide();
         $("#imageloadbutton").hide();
		 $("#preview").show();
		 
		 $('#thumb1').removeClass('thumb-active');
    	 $('#thumb2').removeClass('thumb-active');
	 	 $('#thumb3').removeClass('thumb-active');
	     $('#thumb4').removeClass('thumb-active');
	     $('#thumb5').removeClass('thumb-active');	
	     $('#thumb6').addClass('thumb-active');
		 
		 $('#thumb6').css("background", "url(uploadedvideo/videothumb/p200x150"+ html +") no-repeat");
		 $('#thumb6').css("background-size", "195px 120px");
		 $("#custom_hidden_value").val(html);
		 $('#dthumb').val(html);
     }

 }).submit();  
 });
 $('#change_custom_thumb').change(function(){
	 
	 $('#change_custom_thumb_form').ajaxForm({ 
	 
     beforeSend: function() {
		  $("#imageloadstatus").show();
            $("#imageloadbutton").show();    

     },  

     success: function (html) {		 
		 $("#imageloadstatus").hide();
         $("#imageloadbutton").show();
		 //$("#preview").show();
		 
		 $('#thumb1').removeClass('thumb-active');
    	 $('#thumb2').removeClass('thumb-active');
	 	 $('#thumb3').removeClass('thumb-active');
	     $('#thumb4').removeClass('thumb-active');
	     $('#thumb5').removeClass('thumb-active');	
	     $('#thumb6').addClass('thumb-active');
		 
		 $('#thumb6').css("background", "url(uploadedvideo/videothumb/p200x150"+ html +") no-repeat");
		 $('#thumb6').css("background-size", "195px 120px");
		 $('#thumb6').show();
		 $("#custom_hidden_value").val(html);
		 $('#dthumb').val(html);
		 
     }

 }).submit();    
 });
});
 </script>
</head>
<?php ?>
<body style="background-color:rgba(233, 234, 237, 0.67) !important;">
<div id="insideWrapper container">
<?php 

//include('includes/header.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_header.php');

$pvsql = mysqli_query($con, "SELECT v.location,v.location1,v.location2, v.thumburl, v.title, v.video_id, v.date_created, v.view_count,
			c.name, v.url_type, m.username,v.description, v.title_size,v.title_color,v.type,
			v.thumburl1,v.thumburl2,v.thumburl3,v.thumburl4,v.thumburl5,v.custom_thumb,
			v.ads,a.ads_name,a.location as adslocation,a.location1 as adslocation1,
			a.location2 as adslocation2, a.click_url
			FROM videos v LEFT JOIN videos_category c ON v.category = c.id
			LEFT JOIN members m ON m.member_id = v.user_id 
			LEFT JOIN videos_ads a ON v.ads_id = a.id
			WHERE v.video_id = '$video_id'
			ORDER BY v.video_id DESC") or die(mysqli_error($con));
$pvres = mysqli_fetch_array($pvsql);

$category = $pvres['category'];
$time = $pvres['date_created'];
$uploadedby = $pvres['member_id'];

$title = $pvres['title'];
$description = $pvres['description'];
$mp4videopath = $pvres['location'];
$oggvideopath = $pvres['location1'];
$webmvideopath = $pvres['location2'];
$thumb = $pvres['thumburl'];
$ads = $pvres['ads'];
$adsmp4videopath = $pvres['adslocation'];
$adsoggvideopath = $pvres['adslocation1'];
$adswebmvideopath = $pvres['adslocation2'];
$click_url = $pvres['click_url'];

?>
<?php
if($video_user_id <> $session_member_id){
?>
<div id="mainbody"  style="position:relative;top:-50px !important; ">
<div class="msg_pannel">
<div class="invalid_msg">

	<div class="msg_head">
    <span>Invalid Link</span>
    </div>
<hr />
	<div class="containt">
   	<span>
    The page you requested cannot be displayed right now. It may be temporarily unavailable, the link you clicked on may have expired, or you may not have permission to view this page. 
    </span> 
    </div>
    
    <ul class="back_link">
    <li class="return">
    <a href="<?php echo $base_url.'home.php'; ?>">Return Home</a>
    </li>
    </ul>
</div>
</div>
</div>	
<?php } else {
?>
<div id="mainbody" style="position:relative;top:-50px !important; ">

<div id="submenushead">
<div class="componentheading">
    <div id="submenushead" style="width:300px;"><h2>
    Video Upload</h2></div>
    
    </div>
   
   </div>
	<div id="videoHead">
    	<div id="videoName" style="top:-20px;position:relative;">
        	<h2><a href="watch.php?video_id=<?php echo $pvres['video_id']; ?>"><?php echo $pvres['title']; ?></a></h2> 
        </div>
        <div id="save-edit-btn">
        	<a href="myvideos.php" class="myButton">Back To My Videos</a>
            <a class="myButton" id="publish_video">Save Changes</a>
        </div>
    </div>
 
  <div id="video-player-and-info-panel">
       		
            <div id="video-edit">
            <div id="divContainer">
 <div id="custom-message"><h3 class="video_title" style="color:#<?php if($pvres['title_color'] != ''){ echo $pvres['title_color']; } else { echo 'FFF'; }?>;font-size:<?php echo $pvres['title_size']; ?>px;"><?php echo $pvres['title'];?></h3></div>
 
 
 
 <input type="hidden" name="title" id="title" value="<?php echo $title; ?>">
  <input type="hidden" name="description" id="description" value="<?php echo $description; ?>">
  <input type="hidden" name="mp4video" id="mp4video" value="<?php echo $base_url.$mp4videopath; ?>">
  <input type="hidden" name="oggvideo" id="oggvideo" value="<?php echo $base_url.$oggvideopath; ?>">
  <input type="hidden" name="webmvideo" id="webmvideo" value="<?php echo $base_url.$webmvideopath; ?>">
  <input type="hidden" name="thumb" id="thumb" value="<?php echo $base_url.'uploadedvideo/videothumb/p400x225'.$thumb; ?>">
  <input type="hidden" name="ads" id="ads" value="<?php echo $ads; ?>">
  <input type="hidden" name="adsmp4video" id="adsmp4video" value="<?php echo $base_url.$adsmp4videopath; ?>">
  <input type="hidden" name="adsoggvideo" id="adsoggvideo" value="<?php echo $base_url.$adsoggvideopath; ?>">
  <input type="hidden" name="adswebmvideo" id="adswebmvideo" value="<?php echo $base_url.$adswebmvideopath; ?>">
  <input type="hidden" name="click_url" id="click_url" value="<?php echo $click_url; ?>">
  <input type="hidden" name="fetch_url" id="fetch_url" value="<?php echo $base_url.'fetch_posts.php?id='.$video_id; ?>">
  
  </div>
            </div>
             
           		
 
    </div>
	<div id="video_thumb" >
            
			<div id="thumb_div">     		
		       		<div id="thumb1" class="thumb <?php if($pvres['thumburl'] == $pvres['thumburl1']) echo 'thumb-active';?>" abc="01" data-value = "<?php echo $pvres['thumburl1']; ?>" style="background:url(<?php echo $base_url.'uploadedvideo/videothumb/p200x150'.$pvres['thumburl1']; ?>) no-repeat; background-size:170px 120px;">
		       		    <div id="overlay101" class="overlay1">
			            <span id="plus01" class="plus">SELECT</span>
			        </div>
		       		
		                </div>
		            <div id="thumb2" class="thumb <?php if($pvres['thumburl'] == $pvres['thumburl2']) echo 'thumb-active';?>" abc="02" data-value = "<?php echo $pvres['thumburl2']; ?>" style="background:url(<?php echo $base_url.'uploadedvideo/videothumb/p200x150'.$pvres['thumburl2']; ?>) no-repeat; background-size:170px 120px;"> 
		            	<div id="overlay102" class="overlay1">
			                    <span id="plus02" class="plus">SELECT</span>
			                 </div>
			            
		            </div>
		            
		            <div id="thumb3" class="thumb <?php if($pvres['thumburl'] == $pvres['thumburl3']) echo 'thumb-active';?>" abc="03" data-value = "<?php echo $pvres['thumburl3']; ?>" style="background:url(<?php echo $base_url.'uploadedvideo/videothumb/p200x150'.$pvres['thumburl3']; ?>) no-repeat; background-size:170px 120px;">
		            	<div id="overlay103" class="overlay1">
			                    <span id="plus03" class="plus">SELECT</span>
			                 </div>
			  	       	
		            </div>
                    
                    <div id="thumb4" class="thumb <?php if($pvres['thumburl'] == $pvres['thumburl4']) echo 'thumb-active';?>" abc="04" data-value = "<?php echo $pvres['thumburl4']; ?>" style="background:url(<?php echo $base_url.'uploadedvideo/videothumb/p200x150'.$pvres['thumburl4']; ?>) no-repeat; background-size:170px 120px;">
		            	<div id="overlay104" class="overlay1">
			                    <span id="plus04" class="plus">SELECT</span>
			                 </div>
			  	       	
		            </div>
                    
                    <div id="thumb5" class="thumb <?php if($pvres['thumburl'] == $pvres['thumburl5']) echo 'thumb-active';?>" abc="05" data-value = "<?php echo $pvres['thumburl5']; ?>" style="background:url(<?php echo $base_url.'uploadedvideo/videothumb/p200x150'.$pvres['thumburl5']; ?>) no-repeat; background-size:170px 120px;">
		            	<div id="overlay105" class="overlay1">
			                    <span id="plus05" class="plus">SELECT</span>
			                 </div>
			  	       	
		            </div>
                    
                     
                    <div id="thumb6" class="thumb <?php if($pvres['thumburl'] == $pvres['custom_thumb']) echo 'thumb-active';?>" abc="06" data-value = "<?php echo $pvres['custom_thumb']; ?>" style="background:url(<?php echo $base_url.'uploadedvideo/videothumb/p200x150'.$pvres['custom_thumb']; ?>) no-repeat; background-size:170px 120px; <?php if($pvres['custom_thumb'] != ''){ echo 'display:block';} else { echo 'display:none'; }?>;">
		            	<div id="overlay106" class="overlay1">
			                    <span id="plus06" class="plus">SELECT</span>
			            </div>
                        			  	       	
		            </div>
                    <form id="change_custom_thumb_form" name="change_custom_thumb_form" action="action/change_custom_thumb.php" method="post" enctype="multipart/form-data" style="margin-bottom: 50px; width:170px;">
                    <div id='imageloadstatus'>
     <img src='images/ajax-loader.gif'/> <?php echo $lang['Uploading please wait']; ?> ....
   </div>
   <div id='imageloadbutton'>
   <div class="thumbfile_upload">
                    <input type="file" name="change_custom_thumb" id="change_custom_thumb" required="required" accept="image/*" 
                    style="content: <?php if($pvres['custom_thumb'] != ''){ echo 'Custom Thumb'; } else { echo 'Change cover'; }?>"/>
                    </div>
       
       <input type="hidden" id="custom_hidden_value" value="" />
   </div>
                    </form>
                    
                    
                    <?php  //} else {?>
                    
                    <!--<div class="custom_thumb">
   
   <form id="custom_thumb_form" name="custom_thumb_form" action="action/custom_thumb.php" method="post" enctype="multipart/form-data">
   <div id='imageloadstatus'>
     <img src='images/ajax-loader.gif'/> <?php echo $lang['Uploading please wait']; ?> ....
   </div>
   <div id='imageloadbutton'>   
       <div class="thumbfile_upload">
		<input type="file" id="thumbfile" value=""  name="thumbfile" required="required" accept="image/*" style="content:Custom Thumb">
	</div>
       
       <input type="hidden" id="custom_hidden_value" value="" />
   </div>
   <div id="preview" style="display:none">
       <div id="thumb6" class="thumb" abc="06">

       <div id="overlay106" class="overlay1">

       <span id="plus06" class="plus"><?php echo $lang['SELECT'];?></span>

       </div>

     </div>
   </div>
   </form>
</div>-->
                    
                    <?php //} ?>
                </div>
                 
      <div id="video_edit_info">    
      
  			
           <input type="hidden" name="video_id" id="video_id" value="<?php echo $video_id; ?>" />
           <input type="hidden" name="dthumb" id="dthumb" value="<?php echo $pvres['thumburl'];?>" />
            <h2> Video Information </h2><br /><br />
           <input type="text" name="title" placeholder="Title" id="ftitle" class="required text3 inputbox" value="<?php echo $pvres['title']; ?>" style="font-size:<?php echo $pvres['title_size']; ?>px; color:#<?php echo $pvres['title_color']; ?>;"/><br /><br />
            <select id="fontsizeid" class="required inputbox text3" name="fontsize" style="width:90px;" >
					 	<option value="12" <?php if($pvres['title_size'] == 12) echo 'selected'; ?>>Size</option>
			<option value="14" <?php if($pvres['title_size'] == 14) echo 'selected'; ?>>14px</option>
			<option value="16" <?php if($pvres['title_size'] == 16) echo 'selected'; ?>>16px</option>
			<option value="18" <?php if($pvres['title_size'] == 18) echo 'selected'; ?>>18px</option> 
			<option value="20" <?php if($pvres['title_size'] == 20) echo 'selected'; ?>>20px</option>
			<option value="22" <?php if($pvres['title_size'] == 22) echo 'selected'; ?>>22px</option>
			<option value="24" <?php if($pvres['title_size'] == 24) echo 'selected'; ?>>24px</option>
			<option value="26" <?php if($pvres['title_size'] == 26) echo 'selected'; ?>>26px</option>
			<option value="28" <?php if($pvres['title_size'] == 28) echo 'selected'; ?>>28px</option>		
			    	</select> 
<br /><br />
          <input id="colorpickbuts" class="color" value="<?php echo $pvres['title_color']; ?>"/><label for="colorpickbuts"><img id="colorpicks" src="<?php echo $base_url; ?>images/DigitalColor Meter.png" alt="..." height="40px" width="40px" style="margin-bottom: -15px;"/></label><br /><br />
           
                    
                  <br /> <textarea name="description" rows="5" placeholder="Description" id="fdescription" class="inputbox text3" type="text" value="" placeholder="Description"><?php echo $pvres['description']; ?></textarea><br /><br />
                  
              <input type="radio" id="type" name="type" value="0" <?php if($pvres['type'] == 0) echo 'checked="checked"'; ?>/> Public 
	    	  <input type="radio" id="type" name="type" value="1" <?php if($pvres['type'] == 1) echo 'checked="checked"'; ?> /> Private
          <br /> <br />
          
                   <select name="category" id="fcategory" class="required inputbox text3" style="width:200px;">
	    
	  	  <?php $group_sql = mysqli_query($con, "select * from videos_category");
			while($group_res = mysqli_fetch_array($group_sql))
			{
			?>
		<option value="<?php echo $group_res['id'];?>" <?php if($group_res['name'] == $pvres['name']) echo 'selected'; ?>><?php echo $group_res['name'];?></option>
    		<?php } ?>    
	    
		    </select>
                   </div>
                
	       </div>
</div>

<?php } //include 'includes/footer.php';?>


<?php
	include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_footer.php');
?>
</div><!--End wrapper div-->
