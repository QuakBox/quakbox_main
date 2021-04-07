<?php 
	
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php'); 	 
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');		
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/post_extra.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/time_stamp.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/video-time.php');
	
	$session_member_id = $QbSecurity->qbClean($_SESSION['SESS_MEMBER_ID'], $con);
	
	$objMember = new member1();
	
	$video_id = $_REQUEST['video_id'];
	 
	if(!(empty($video_id)||($qbValidation->qbIntegerCheck($video_id))))
	{
		$qb_err_msg="Oops Something Went Wrong...!";
           	$QbSecurity->qbErrorMessage($qb_err_msg,$homepage);
	}
	else
	{
	$video_id = $QbSecurity->qbClean($_REQUEST['video_id'], $con);
	$video_id=htmlspecialchars(trim($video_id));
			$msql = mysqli_query($con, "select * from member where member_id = '$session_member_id'");
	$mres_new = mysqli_fetch_array($msql);	
	
	$mresPic=$objMember->select_member_meta_value($mres_new['member_id'],'current_profile_image');
	if($mresPic){			
		$mresPic=SITE_URL.'/'.$mresPic;	
	}
	else{
		$mresPic=SITE_URL.'/images/default.png';
	}
	

	$wquery = "select m.messages_id,m.type , v.user_id from message as m, videos as v where v.video_id = '$video_id' AND m.messages_id = v.msg_id";

$wsql = mysqli_query($con, $wquery);

$wres = mysqli_fetch_array($wsql);
//echo "<pre>";
//print_r($wres);
//die();
$mres['member_id'] = $wres['user_id'];
$msg_id = $wres['messages_id'];

$pvquery = "SELECT v.location,v.location1,v.location2, v.thumburl, v.title, v.video_id, v.date_created, v.view_count,v.description,
				v.url_type, v.msg_id, v.category, v.duration, m.member_id, m.username,v.title_color,v.title_size,v.ads,a.ads_name,
				a.location as adslocation,a.location1 as adslocation1,a.location2 as adslocation2, a.click_url
				FROM videos v LEFT JOIN member m ON m.member_id = v.user_id 
				LEFT JOIN videos_ads a ON v.ads_id = a.id
				WHERE v.video_id = '$video_id' ";

$pvsql = mysqli_query($con, $pvquery) or die(mysqli_error($con));

$mrow = mysqli_fetch_array($pvsql);

	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_header.php');
?>
<?php /*?><!-- Twitter Card data -->
	<meta name="twitter:card" content="player">
	<meta name="twitter:site" content="@Quakbox">
	<meta name="twitter:title" content="<?php print substr($mrow['title'],0,69); ?>">	
	<meta name="twitter:image" content="<?php print $base_url.'uploadedvideo/videothumb/p400x225'.$mrow['thumburl'];?>">
	<meta name="twitter:player" content="<?php print $base_url.'player.php?video_id='.$video_id; ?>">
	<meta name="twitter:player:width" content="640">
	<meta name="twitter:player:height" content="360">
	<meta name="twitter:player:stream" content="<?php echo $base_url.$mrow['location']; ?>">
	<meta name="twitter:player:stream:content_type" content="video/mp4">
    
<!-- Open Graph data --> 
<meta property="og:title" content="<?php print substr($mrow['title'],0,90); ?>"/>
    <meta property="og:description" content="<?php print substr($mrow['description'],0,150); ?>"/>
    <meta property="og:image" content="<?php print $base_url.'uploadedvideo/videothumb/p400x225'.$mrow['thumburl'];?>"/>
    <meta property="og:type" content="movie"/>
    <meta property="og:video:height" content="270"/>
    <meta property="og:video:width" content="480"/>
    <meta property="og:url"  content="<?php print $base_url.'watch.php?video_id='.$video_id; ?>"/>
    <meta property="og:video"  content="<?php print $base_url.$mrow['location']; ?>"/>
    <meta property="og:video:type" content="video/mp4"/>
    
    <link rel="publisher" href="https://google.com/+rahul"><?php */?>

<?php /*?>

<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/style.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/jquery-ui.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/jquery.share.css"/>

<link rel="stylesheet" type="text/css" href="assets/jquery-alert-dialogs/css/jquery.alerts.css"/>
<link rel="stylesheet" href="assets/chosen-jquery/chosen.css">
<link rel="stylesheet"  type="text/css" href="<?php echo $base_url;?>css/token-input.css"/>
<link rel="stylesheet"  type="text/css" href="<?php echo $base_url;?>css/token-input-facebook.css"/>
<link rel="stylesheet"  type="text/css" href="<?php echo $base_url;?>css/token-input-mac.css"/><?php */?>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/wall.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/group.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/youtube.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/search.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/watch_video.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>font-awesome/css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/responsive.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/memberprofile.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/subscribeProfilePage.css" />

<style>
.video-thumbnail-duration {

    padding: 0px 4px;
    font-weight: bold;
    font-size: 11px;
    background-color: #000;
    color: #FFF !important;
    height: 14px;
    line-height: 14px;
    opacity: 0.75;
    vertical-align: top;
    display: inline-block;
    margin-left: -45px;
    margin-right: 263px;
    right: 108px;
    bottom: 0px;
    float: left;
    position: absolute;

}
#subscribe_btn{
	
	float:right !important;
	
	margin-top: -70px !important;
margin-left: 200px;
clear: both;
position: absolute;
float: right !important;
right: -100px;
}
.videoPlayer 
{
	background : grey !important; 
}
.playing{
	background : #000 !important;
} 
.paused{
	background : #000 !important;
}
</style>

<!--external js file-->



<?php /*?><script src="js/jquery-1.7.2.min.js"></script><?php */?>

<script src="http://microsofttranslator.com/ajax/v3/widgetv3.ashx" type="text/javascript"></script>

<?php /*?><script src="<?php echo $base_url;?>js/jquery.min.js"></script><?php */?>

<script src="<?php echo $base_url;?>js/jquery.livequery.js" type="text/javascript"></script>

<script src="<?php echo $base_url;?>js/jquery.oembed.js"></script>

<?php /*?><script src="<?php echo $base_url;?>js/jquery-ui.min.js"></script><?php */?>
<script src="js/respond.js"></script>

<script type="text/javascript" src="<?php echo $base_url;?>js/ibox.js"></script>

<script type="text/javascript" src="<?php echo $base_url;?>js/jquery.share.js"></script>

<script type="text/javascript" src="<?php echo $base_url;?>assets/jquery-alert-dialogs/js/jquery.alerts.js"></script>

<script src="<?php echo $base_url;?>js/qbox.js"></script>
<script src="<?php echo $base_url;?>js/check.js"></script>

<!--common scripts for all wall pages  Naresh shaw -->

<script src="js/translate.js"></script>

<?php /*?><script src="js/wall.js"></script><?php */?>

<script src="js/jquery.form.js"></script>

<script src="js/page-refresh.js"></script>

<script src="js/common-scripts.js"></script>

<?php /*?><script type="text/javascript" src="js/autocxxxomplete.js"></script><?php */?>

<script src="js/autoscroll.js"></script>
<?php /*?><script type="text/javascript" src="js/x"></script><?php */?>
<link rel="stylesheet" href="video-ads/css/videoPlayerMain.css" type="text/css">
  <link rel="stylesheet" href="video-ads/css/videoPlayer.theme1.css" type="text/css">
  <link rel="stylesheet" href="video-ads/css/preview.css" type="text/css" media="screen"/>

  
  <script src="video-ads/js/IScroll4Custom.js" type="text/javascript"></script>
  <script src='video-ads/js/THREEx.FullScreen.js'></script>
  <script src="video-ads/js/videoPlayer.js" type="text/javascript"></script>
  <script src="video-ads/js/Playlist.js" type="text/javascript"></script> 
  
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
		var pintereset = $('#fetch_url_pinterest').val();
		var fetch_url_fb = $('#fetch_url_fb').val();
        videoPlayer = $("#video").Video({
        preload:false,
        /*autobuffer:false,*/
            autoplay:true,						
            autohideControls:4,
            videoPlayerWidth:773,
            videoPlayerHeight:450,
            posterImg:thumb,
            fullscreen_native:true,
            fullscreen_browser:true,
            restartOnFinish:false,            
            rightClickMenu:true,
            share:[{
                show:true,
                facebookLink:"https://www.facebook.com/sharer/sharer.php?u="+fetch_url,
                twitterLink:"https://twitter.com/intent/tweet?source=webclient&text="+fetch_url,                
                pinterestLink:"http://pinterest.com/pin/create/bookmarklet/?media=" + pintereset,
                linkedinLink:"http://www.linkedin.com/cws/share?url="+fetch_url,
                googlePlusLink:"https://plus.google.com/share?url="+fetch_url,
                deliciousLink:"https://delicious.com/post?url="+fetch_url
            }],
            logo:[{
                show:false,
                clickable:true,
                /*path:"images/logo/logo.png",*/
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
                

                popupAdvertisementShow:false,
                popupAdvertisementClickable:false,
               /* popupAdvertisementPath:"images/advertisement_images/ad2.jpg",*/
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

$(function() {

    $(".cancel_custom").click(function() {

	$("#popup").hide();

	});

	

	 $(".cancel_share").click(function() {

	$("#share_popup").hide();

	$(".share_body").children('div').remove();

	});

});
</script>

<script>

$(function(){

   $(".star").mouseover(function(){ //SELECTING A STAR   

     var id = $(this).attr("x"); //ID OF THE CONTENT BEING RATED			 	  

     $(".r"+id).hide(); //HIDES THE CURRENT RATING WHEN MOUSE IS OVER A STAR

     var d = $(this).attr("id"); //GETS THE NUMBER OF THE STAR	 

     //HIGHLIGHTS EVERY STAR BEHIND IT	 

     for(i=(d-1); i>=0; i--){

       $(".transparent .s"+id+":eq("+i+")").css({"opacity":"1.0"});

     }

   }).click(function(){ //RATING PROCESS

     var id = $(this).attr("x"); //ID OF THE CONTENT BEING RATED	

	 var user_id = $("#user_id").val(); //ID OF THE CONTENT BEING RATED

     var rating = $(this).attr("id"); //GETS THE NUMBER OF THE STAR

     var data = 'video_id='+id+'&rating='+rating+'&user_id='+user_id; //ID OF THE CONTENT

	

     $.ajax({

       type: "POST",

       data: data,

       url: "load_data/rate.php", //CALLBACK FILE

       success: function(e){

	

         $(".ajax"+id).html(e); //DISPLAYS THE NEW RATING IN HTML

       }

     });

   }).mouseout(function(){ //WHEN MOUSE IS NOT OVER THE RATING

     var id = $(this).attr("x"); //ID OF THE CONTENT BEING RATED

     $(".r"+id).show(); //SHOWS THE CURRENT RATING

     $(".transparent .s"+id).css({"opacity":"0.25"}); //TRANSPARENTS THE BASE

   });
$(".videoPlayer").bind("play", myFunction);
$(".videoPlayer").bind("ended", myFunction1);
$(".videoPlayer").bind('loadeddata', function(e) {
  $('.loading').hide();
  $('#custom-message').hide();
  $('.videoPlayer').css('background', '');
  $('.videoPlayer').css('background', '#000');
});
function myFunction() {
    //alert('video has started');
	//$('#custom-message').hide();
	// $('.loading').hide();  
}
function myFunction1() {
   // alert('video has ended');
	var nexthref = $( ".video_list li a" ).first().attr('href');
	console.log(nexthref);
	if(nexthref != undefined)
		window.location.href= "/"+nexthref;
	//$('#custom-message').hide();
}
});

</script>



   

<style>

.r {

position: relative;

}

/*MUST BE ABSOLUTE TO STACKED*/

.rating, .transparent {

position: absolute;



} .rating {

z-index: 1;

} .star {

background: url(images/quickvote_item_active_big.png); cursor: pointer; float: left !important; /*KEEPS THE STAR NEXT TO EACH OTHER*/ height: 25px; width: 27px;

} .transparent .star {

opacity: .25; /*BASE STARS ARE TRANSPARENT UNTIL MOUSEOVER*/

} .rating .star {

opacity: 1.0; /*CURRENT RATING IS VISIBLE UNTIL MOUSEOVER*/

} .votes {

float: left; /*KEEPS THE NUMBER OF VOTES NEXT TO THE RATING & BASE*/

}

#error-quick{
	color:#F00;	
	border-bottom:5px solid #CCC;
	display:none;
}
.quicktime-download-title, .quicktime-download-text{
	display:block;
}
.quicktime-download-title{
	font-size:22px;
	font-weight:bold;
}
.quicktime-download-text{
	font-size:16px;	
}
#custom_privacy {
	top: -65px;

position: relative;
} 
</style>



   



<script type="text/javascript">

function showHide() 

{

				

   if(document.getElementById("privacy").selectedIndex == 1) 

   {

	    document.getElementById("mvm1").style.display = "block"; // This line makes the DIV visible

		document.getElementById("mvm").style.display = "none";

	   	document.getElementById("mvm2").style.display = "none";

   }

   else

   {

	   document.getElementById("mvm1").style.display = "none";	   

   } 

   if(document.getElementById("privacy").selectedIndex == 2)

   {            

        document.getElementById("mvm2").style.display = "block";

		document.getElementById("mvm").style.display = "none"; 

		document.getElementById("mvm1").style.display = "none"; 

   }

   else

   {

	   document.getElementById("mvm2").style.display = "none";	   

   }

   

   if(document.getElementById("privacy").selectedIndex == 3)

   {            

        document.getElementById("world").value = "world";

		document.getElementById("mvm2").style.display = "none";

		document.getElementById("mvm").style.display = "none"; 

		document.getElementById("mvm1").style.display = "none";

 }

  

   

}

//document.getElementById("video").onended = function() {myFunction()};


</script>

<style type="text/css">

#share_popup{

	width: 100%;

	height: 100%;

	position: fixed;

	top: 0;	

	background-color: rgba(0,0,0,0.7);

	color:#fff;

	z-index:2;

}

.PopupPanel {

border: solid 1px black;

position: absolute;

left: 50%;

top: 50%;

background-color: white;

z-index: 100;

overflow-y: scroll;

height: 400px;

margin-top: -200px;

width: 600px;

margin-left: -300px;

}
#warning{position:relative; top:0px; width:100%; height:40px; background-color:#fff; margin-top:0px; padding:4px; border-bottom:solid 4px #000066;margin-top:10px;}


/* Absolute Center Spinner */
.loading {
  position: relative;
  z-index: 999;
  height: 5em;
  width: 5em;
  overflow: show;
  margin: auto;
  top: 200px;
  left: 0;
  bottom: 0;
  right: 0;
}



/* :not(:required) hides these rules from IE9 and below */
.loading:not(:required) {
  /* hide "loading..." text */
  font: 0/0 a;
  color: transparent;
  text-shadow: none;
  background-color: transparent;
  border: 0;
}

.loading:not(:required):after {
  content: '';
  display: block;
  font-size: 10px;
  width: 1em;
  height: 1em;
  margin-top: -0.5em;
  -webkit-animation: spinner 1500ms infinite linear;
  -moz-animation: spinner 1500ms infinite linear;
  -ms-animation: spinner 1500ms infinite linear;
  -o-animation: spinner 1500ms infinite linear;
  animation: spinner 1500ms infinite linear;
  border-radius: 0.5em;
  -webkit-box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.5) -1.5em 0 0 0, rgba(0, 0, 0, 0.5) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
  box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) -1.5em 0 0 0, rgba(0, 0, 0, 0.75) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
}

/* Animation */

@-webkit-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-moz-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-o-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}



</style>


<?php 
	// Comment section
	$postExtra = new post_extra();
?>
<div class="insideWrapper container">
    <div class="col-lg-8 col-md-8 col-sm-8">

<!--[if lte IE 8]>
<div id="warning">
<h4 class="red">Your Browser Is Not Supported to play video!</h4>
<p>Please upgrade to <a href='http://www.microsoft.com/windows/downloads/ie/getitnow.mspx' target='_blank'>Internet Explorer 9</a>. Thank You!&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" onClick="document.getElementById('warning').style.display = 'none';"><b>Close Window</b></a></p>
</div>
<![endif]-->

<div id="error-quick">
<a href="http://www.apple.com/quicktime/download/">
<span class="quicktime-download-title">Get Quicktime</span>
<span class="quicktime-download-text">Download QuickTime to view this video.</span>
</a>
<a href="javascript:void(0)" onClick="document.getElementById('error-quick').style.display = 'none';"><b>Close Window</b></a>
</div>

<?php if(isset($session_member_id)){ ?>
 <!--<div id="submenushead">

   <ul class="submenu">

    <li><input type="button" name="add_video" class="button" value="<?php echo $lang['My Videos'];?>" 

    onclick="window.open('myvideos.php','_self')" /></li>

   

	</ul>

   </div>-->
<?php  }?>
   <input type="hidden" id="user_id" value="<?php echo $session_member_id;?>" />

    <?php

$vvsql = mysqli_query($con, "SELECT id FROM videos_views WHERE member_id = '$session_member_id' AND video_id = '$video_id'");

$vvcount = mysqli_num_rows($vvsql);



if($vvcount == 0) {	

mysqli_query($con, "INSERT INTO videos_views(video_id, member_id) VALUES('$video_id', '$session_member_id')");

$view_count = $mrow['view_count'];

$view_count = $view_count + 1;

$musql = "update videos set view_count = '$view_count' where video_id = '$video_id'";

$mures = mysqli_query($con, $musql) or die(mysqli_error($con));

}

$category = $mrow['category'];
$time = $mrow['date_created'];
$uploadedby = $mrow['member_id'];

$title = $mrow['title'];
$description = $mrow['description'];
$mp4videopath = $mrow['location'];
$oggvideopath = $mrow['location1'];
$webmvideopath = $mrow['location2'];
$thumb = $mrow['thumburl'];
$ads = $mrow['ads'];
$adsmp4videopath = $mrow['adslocation'];
$adsoggvideopath = $mrow['adslocation1'];
$adswebmvideopath = $mrow['adslocation2'];
$click_url = $mrow['click_url'];

?>

        

 <div id="divContainer">

 <div id="custom-message" style="z-index:1;position: absolute;margin: 10px; width:auto;"><h3 style="color:#<?php if($mrow['title_color'] != ''){ echo $mrow['title_color']; } else { echo 'FFF'; }?>;font-size:<?php echo $mrow['title_size']; ?>px;overflow:hidden; text-overflow:ellipsis; white-space:nowrap;width:100%; margin:120px 10px 0px 300px;wordwrap:break-word; "><?php echo $mrow['title'];?></h3></div>
<div class="loading" style="z-index:999;position: absolute;margin: 10px; width:auto;margin-left:400px!important;">Loading&#8230;</div> 
 

 <div class="videocontent" style="width: 100%; height:auto;">

    <?php 
 $mobile = Detect_mobile();
 if ($mobile === true)
				{
 ?>
  <video controls id="video" poster="<?php echo $base_url.'uploadedvideo/videothumb/p400x225'.$thumb; ?>"  >
<source src="<?php echo $base_url.$mp4videopath; ?>" type="video/mp4">
<source src="<?php echo $base_url.$oggvideopath; ?>" type="video/ogg">
<source src="<?php echo $base_url.$webmvideopath; ?>" type="video/webm">

		Html5 Not support This video Format.
</video>
                            <?php } else { ?>
                           <div controls id="video" ></div>
                            
                            <?php } ?>                        
                            
                            
 
 

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
  <input type="hidden" name="fetch_url" id="fetch_url" value="<?php echo urlencode($base_url.$_SERVER['REQUEST_URI']) ?>">
<input type="hidden" name="fetch_url_pinterest" id="fetch_url_pinterest" value="<?php echo urlencode($base_url.'uploadedvideo/videothumb/p200x150'.$thumb); ?>&url=<?php echo urlencode($base_url.$_SERVER['REQUEST_URI']); ?>&is_video=true&description=<?php echo $description; ?>">
<input type="hidden" name="fetch_url_fb" id="fetch_url_fb" value="<?php echo "http://www.facebook.com/sharer/sharer.php?s=100&amp;p%5Btitle%5D="
							. $title . "&amp;p%5Bsummary%5D="
							. "&amp;p%5Burl%5D=" . urlencode($base_url.$_SERVER['REQUEST_URI'])
							. "&amp;p%5Bimages%5D%5B0%5D=" . urlencode($base_url.'uploadedvideo/videothumb/p200x150'.$thumb); ?>">
  </div>

  </div>
<span style="font-size: 19px;color: #999;font-family: Arial,Helvetica,sans-serif;margin-top: 5px; height:150px;" ><?php echo $description;?> </span>

 <div class="video_Content">
<div class="video_data">
<span class="view_count"><?php echo $mrow['view_count'];?> <?php echo $lang['views'];?></span>

<span class="content_item_time"><?php echo time_stamp($time);?></span>

<br/>

<span class="view_count"><?php echo $lang['By'].' ';?><a href="<?php echo $base_url.'user/'.$mrow['username'];?>"><?php echo $mrow['username'];?></a></span>

</div>



<div>

<?php 

if($_SESSION['SESS_MEMBER_ID'] != $mres['member_id']){
?>
<div id="subscribe_btn">
<?php 
$vmember_id = $mres['member_id'];
$subtotsql = mysqli_query($con, "SELECT id FROM videos_subscribe WHERE member_id = '$vmember_id'");
$subtotcount = mysqli_num_rows($subtotsql);


$subsql = mysqli_query($con, "SELECT id FROM videos_subscribe WHERE member_id = '$vmember_id' AND subscriber_member_id = '".$_SESSION['SESS_MEMBER_ID']."'");
$subcount = mysqli_num_rows($subsql);


if($subcount > 0){
?>
 <button class="subscribe_btn btn-danger" id="<?php echo $mres['member_id']; ?>" rel="unsubscribe"><?php echo $lang['UnSubscribe'];?></button> 
<?php } else { if(isset($_SESSION['SESS_MEMBER_ID'])){?>
 <button class="subscribe_btn btn-success" id="<?php echo $mres['member_id']; ?>" rel="subscribe"><?php echo $lang['Subscribe'];?></button>

 <?php } else { ?>
 <button class="subscribe_btn btn-success" onClick="window.open('<?php echo $base_url.'login.php?back='.urlencode($_SERVER['REQUEST_URI']); ?>','_self');"><?php echo $lang['Subscribe'];?></button>
 <?php }} ?>
 
 
 <?php 
 $username = $_REQUEST['username'];
 
 ?>
 <div class="subscribe_no_box">
 <span class="speech-bubble"></span>
 <span id="channel_subscribers_count" class="subscribers-nr"><?php echo $subtotcount; ?></span>
 </div>
 </div>
 
 
 <?php  } ?>
 <?php 

					$crsql = mysqli_query($con, "select rating from videos where video_id = '$video_id' and user_id = '$session_member_id'");

					$crcount = mysqli_num_rows($crsql);

					

					$rating = 0;

					$x = array(); //ARRAY TO COUNT STARS FOR EACH PIECE OF CONTENT

					$stars = array(); //ARRAY TO SEPARATE THE TRANSPARENT 5-STAR BASE BETWEEN EACH PIECE OF CONTENT

									

					//ADDS ALL THE STAR FOR EACH PIECE OF CONTENT

					if($crcount > 0)

					{

    while($crres=mysqli_fetch_array($crsql)){

		

        $r = $crres["rating"];

        @$x[$video_id] += $r;

    }

    $r = 0; //RESETS AS IT GOES TO THE NEXT PIECE OF CONTENT

    $a = $x[$video_id]; //THE TOTAL NUMBER OF STARS

    

    //IF THERE ARE RATINGS...

    if($crcount){

        $rating = $a/$crcount; //GETS THE AVERAGE RATING (UNROUNDED)

    }

	$dec_rating = round($rating, 1);

	}

	//LOOPS THE WHOLE NUMBER OF STARS THAT THE CONTENT HAS BEEN RATED

    for($i=1; $i<=floor($rating); $i++){

        @$stars[$video_id] .= '<div class="star s'.$video_id.'" x="'.$video_id.'" id="'.$i.'"></div>';

    }

					

    //ALL CONTENT & ITS STARS SHOWN IN HTML

   echo '

    <div  class="ajax'.$video_id.'">';

   //THE CURRENT RATING & THE TRANSPARENT BASE RIGHT USER TO SUBMIT A NEW RATING

echo '<div style="display:inline;" class="rating r'.$video_id.'">'.@$stars[$video_id].'</div>

<div class="transparent">

<div class="star s'.$video_id.'" x="'.$video_id.'" id="1"></div>

<div class="star s'.$video_id.'" x="'.$video_id.'" id="2"></div>

<div class="star s'.$video_id.'" x="'.$video_id.'" id="3"></div>

<div class="star s'.$video_id.'" x="'.$video_id.'" id="4"></div>

<div class="star s'.$video_id.'" x="'.$video_id.'" id="5"></div>



</div><div style="display:inline;margin-left:230px;">';



if(isset($session_member_id)){ 
    echo $postExtra->extra_widget("", $msg_id, $QbSecurity->QB_AlphaID($msg_id), 1).'</div></div>';
	?>
	

 </div>
	<?php
}else
{
	echo '<h4>You need to <a href="'.$base_url."login.php?back=".urlencode($_SERVER['REQUEST_URI']).'" ?>">Login</a> to comment ,like video.</h4>';
}
   

	?>
	</div>
<?php 
/*if(isset($session_member_id)){ ?>



<div style ="" class="comment-menu rp<?php echo $QbSecurity->QB_AlphaID($msg_id);?>">
<?php  echo  $postExtra->extra_widget("", $msg_id, $QbSecurity->QB_AlphaID($msg_id), 1);?>
</div>

<?php
} else {
?>
<div style ="border:1px solid red;float:right;">
<h4>You need to <a href="<?php echo $base_url."login.php?back=".urlencode($_SERVER['REQUEST_URI']); ?>">Login</a> to comment ,like video.</h4></div>
<?php	
}*/
?>






<!--End commentupdate div	--> 
<?php	
//echo "SELECT * FROM postcomment WHERE msg_id=" . $msg_id . " ORDER BY comment_id DESC";
$query1  = mysqli_query($con, "SELECT * FROM postcomment WHERE msg_id='" . $msg_id . "' ORDER BY comment_id DESC");

$records = mysqli_num_rows($query1);

$s = mysqli_query($con, "SELECT * FROM postcomment WHERE msg_id='" . $msg_id . "' ORDER BY comment_id DESC limit 4,$records");

$y = mysqli_num_rows($s);

if ($records > 4)

{

	$collapsed = true;?>

    <input type="hidden" value="<?php echo $records?>" id="totals-<?php  echo $msg_id;?>" />

	<div class="commentPanel" id="collapsed-<?php  echo $msg_id;?>" align="left">

	<img src="<?php echo $base_url;?>images/cicon.png" style="float:left;" alt="" />

	<a href="javascript: void(0)" class="ViewComments" id="<?php echo $msg_id;?>">

	<?php echo $lang['View'];?> <?php echo $y;?> <?php echo $lang['more comments'];?> 

	</a>

	<span id="loader-<?php  echo $msg_id?>">&nbsp;</span>

	</div>

<?php

}

?>


 



<!-- LIke users display panel -->

<?php 
/*
if($post_like_count1==1)

{

$post_like_sql2 = mysqli_query($con, "SELECT m.username,m.member_id FROM bleh b, member m WHERE m.member_id=b.member_id AND b.remarks='".$msg_id."' AND b.member_id!='".$_SESSION['SESS_MEMBER_ID']."' LIMIT 2");

$plike_count = mysqli_num_rows($post_like_sql2);

$new_plike_count=$post_like_count-2; 

}

else

{

$post_like_sql2 = mysqli_query($con, "SELECT m.username,m.member_id FROM bleh b, member m WHERE m.member_id=b.member_id AND b.remarks='".$msg_id."' LIMIT 3");

$plike_count = mysqli_num_rows($post_like_sql2);

$new_plike_count=$post_like_count-3; 

}

?>

 



<!-- LIke users display panel -->





<!--Dislike users display panel-->

<?php 



$sql1 = mysqli_query($con, "SELECT * FROM post_dislike WHERE msg_id='". $msg_id ."'") or die(mysqli_error($con));

$dislike_count = mysqli_num_rows($sql1);

 

$query1=mysqli_query($con, "SELECT m.username,m.member_id FROM post_dislike b, member m WHERE m.member_id=b.member_id AND b.msg_id='".$msg_id."' LIMIT 3");

$dislike = mysqli_num_rows($query1);*/

?>
<!-- End of timestamp div -->
</div>
    <div class="col-lg-4 col-md-4 col-sm-4 hidden-xs"> 

<div class="videolist">
<span><?php echo $lang['Suggested Videos'];?> </span>
</div>

<ul class="video_list">

<?php 

$rvquery = "select v.date_created, v.video_id, v.thumburl,v.title, v.view_count,
			m.username, v.url_type, v.location,v.duration
			from videos v left join videos_category c ON c.id = v.category
			LEFT JOIN member m ON m.member_id = v.user_id 
			LEFT JOIN message msg ON msg.messages_id = v.msg_id 
			where v.video_id != '$video_id'
			AND v.user_id = '$uploadedby' AND v.duration != 0 
			GROUP BY v.parent_id
			ORDER BY v.view_count DESC LIMIT 6";

$rvsql = mysqli_query($con, $rvquery) or die(mysqli_error($con));

while($pvres = mysqli_fetch_array($rvsql))

{

	$time = $pvres['date_created'];

?>



<li class="video_list_item">

<a href="watch.php?video_id=<?php echo $pvres['video_id'];?>">

<span class="video_thumb">

 <?php

    if($pvres['url_type'] == 1)

	{

	?>

    <img src="<?php echo $base_url.'uploadedvideo/videothumb/p200x150'.$pvres['thumburl']; ?>" width="145" height="80" /><span class="video-thumbnail-duration"><?php echo video_duration($pvres['duration']); ?></span>

    <?php } 

	if($pvres['url_type'] == 2)

	{

		if (preg_match('![?&]{1}v=([^&]+)!', $pvres['location'] . '&', $mr))

	$video_idr = $mr[1]; 

	$urlr = "http://img.youtube.com/vi/".$video_idr."/default.jpg";	

			

	?>

    <img src="<?php echo $urlr;?>" width="145" height="80" />

    <?php 

	}

	?>

</span>

<span class="title">

<?php echo $pvres['title'];?>

</span>

<span class="stat attribution"><?php echo $lang['By'];?> <?php echo $pvres['username'];?></span>

<span class="stat view_count"><?php echo $pvres['view_count']?> <?php echo $lang['views'];?></span>

</a>

</li>

<?php } ?>
<li class="video_list_item">&nbsp;&nbsp;</li><li class="video_list_item">&nbsp;&nbsp;</li>
</ul>

</div><!--End column_left_video div-->

</div><!--End wrapper div-->

<br /><br /><br />
<!-- Modified by Naresh Shaw -->

<?php include_once 'share.php';?>
<?php //include_once 'smiley.php';?>
<?php
	include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_footer.php');
}
?>




     
