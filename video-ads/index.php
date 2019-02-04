<?php session_start();
require_once('../config.php');
$video_id = $_REQUEST['id'];//this.video.poster.show();
?>

<!doctype html>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html" content="video/*"  charset="utf-8">
  <title>Video ads demo</title>
  <link rel="stylesheet" href="css/videoPlayerMain.css" type="text/css">
  <link rel="stylesheet" href="css/videoPlayer.theme1.css" type="text/css">
  <link rel="stylesheet" href="css/preview.css" type="text/css" media="screen"/>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="js/IScroll4Custom.js" type="text/javascript"></script>
  <script src='js/THREEx.FullScreen.js'></script>
  <script src="js/videoPlayer.js" type="text/javascript"></script>
  <script src="js/Playlist.js" type="text/javascript"></script>
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
		window.console.log('title:'+title+'desc:'+desc1)
        videoPlayer = $("#video").Video({
            autoplay:false,
            autohideControls:4,
            videoPlayerWidth:746,
            videoPlayerHeight:420,
            posterImg:thumb,
            fullscreen_native:false,
            fullscreen_browser:true,
            share:[{
                show:true,
                facebookLink:"https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fwww.player.pageflip.com.hr%2FplayerFB%2Findex.html",
                twitterLink:"https://twitter.com/intent/tweet?source=webclient&text=Responsive+HTML5+video+player+with+Advertising+by+zac+http%3A%2F%2Fwww.player.pageflip.com.hr%2FplayerFB%2Findex.html",
                youtubeLink:"http://www.youtube.com/watch?v=sAFt_cb-Z7I",
                pinterestLink:"http://pinterest.com/pin/create/bookmarklet/?media=http%3A%2F%2Fwww.player.pageflip.com.hr%2FimgFB%2F%2Fpreview.png&url=http%3A%2F%2Fwww.player.pageflip.com.hr%2FplayerFB%2F&description=ResponsiveHTML5VideoPlayerWithAdvertising",
                linkedinLink:"http://www.linkedin.com/cws/share?url=http%3A%2F%2Fwww.player.pageflip.com.hr%2FplayerFB%2F&original_referer=http%3A%2F%2Fwww.pageflip.com.hr%2FplayerFB%2F&token=&isFramed=true&lang=en_US&_ts=1378818194488.6047",
                googlePlusLink:"https://plus.google.com/share?url=http://www.player.pageflip.com.hr/playerFB/index.html",
                deliciousLink:"https://delicious.com/post?url=http://www.pageflip.com.hr/playerFB/&title=Responsive%20HTML5%20Video%20Player%20with%20Advertising%20by%20zac",
                mailLink:"mailto:codecanyon@codecanyon.net"
            }],
            logo:[{
                show:true,
                clickable:true,
                path:"",
                goToLink:"",
                position:"top-right"
            }],
            embed:[{
                show:true,
                embedCode:'<iframe src="" width="746" height="420" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>'
            }],
            videos:[{
                id:0,
                title:"Oceans",
                mp4:mp4videopath,
                webm:webmvideopath,
                ogv:oggvideopath,
                info:desc1,

                popupAdvertisementShow:true,
                popupAdvertisementClickable:true,
                popupAdvertisementPath:"",
                popupAdvertisementGotoLink:"",
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
  <style type="text/css" media="screen">
    body
    {
      background: #000 url(images/5.png) repeat;
        /*margin: 0;*/
        /*width: 0px;*/
        /*height: 0px;*/
    }
    
    #video
    {
      -webkit-box-shadow: 2px 2px 10px #333;
      -moz-box-shadow: 2px 2px 10px #333;
      margin: 5% auto;
      width: 746px;
      height: 420px;
    }

  </style>
</head>
<body>
  <?php 
$pvquery = "SELECT v.location,v.location1,v.location2, v.thumburl, v.title, v.video_id, v.date_created, v.view_count,v.description,
				v.url_type, v.msg_id, v.category, m.username,v.title_color,v.title_size,v.ads,a.ads_name,
				a.location as adslocation,a.location1 as adslocation1,a.location2 as adslocation2, a.click_url
				FROM videos v LEFT JOIN members m ON m.member_id = v.user_id 
				LEFT JOIN videos_ads a ON v.ads_id = a.id
				WHERE v.video_id = '$video_id'";

$pvsql = mysqli_query($con, $pvquery) or die(mysqli_error($con));



$mrow = mysqli_fetch_array($pvsql);

$category = $mrow['category'];
$time = $mrow['date_created'];

$title = $mrow['title'];
$description = $mrow['description'];
$mp4videopath = $mrow['location'];
$oggvideopath = $mrow['location1'];
$webmvideopath = $mrow['location2'];
$thumb = $mrow['thumburl'];
$thumb = 'uploadedvideo/videothumb/p400x225'.$thumb;
$ads = $mrow['ads'];
$adsmp4videopath = $mrow['adslocation'];
$adsoggvideopath = $mrow['adslocation1'];
$adswebmvideopath = $mrow['adslocation2'];
$click_url = $mrow['click_url'];
$checkmp4 = $base_url.$mp4videopath;

?>

  <div id="video"></div>
   <?php 
  if($title){ ?>
 <input type="hidden" name="title" id="title" value="<?php echo $title; ?>">
 <?php }else
  { ?>
 <input type="hidden" name="title" id="title" value="">
 <?php }
  ?>
  
   
   <?php 
  if($description){ ?>
  <input type="hidden" name="description" id="description" value="<?php echo $description; ?>"> 
 <?php }else
  { ?>
  <input type="hidden" name="description" id="description" value=""> 
 <?php }
  ?>
  
  
  <?php
  if($mp4videopath){ ?>
  <input type="hidden" name="mp4video" id="mp4video" value="<?php echo $base_url.$mp4videopath; ?>"> 
 <?php }else
  { ?>
  <input type="hidden" name="mp4video" id="mp4video" value=""> 
 <?php }
  ?>
  
  <?php 
  if($oggvideopath){ ?>
  <input type="hidden" name="oggvideo" id="oggvideo" value="<?php echo $base_url.$oggvideopath; ?>">
 <?php }else
  { ?>
 <input type="hidden" name="oggvideo" id="oggvideo" value="">
 <?php }
  ?>
  
  
  <?php 
  if($webmvideopath){ ?>
  <input type="hidden" name="webmvideo" id="webmvideo" value="<?php echo $base_url.$webmvideopath; ?>">
 <?php }else
  { ?>
  <input type="hidden" name="webmvideo" id="webmvideo" value="">
 <?php }
  ?>
  
  
  
   <?php  if($thumb){ ?>
  <input type="hidden" name="thumb" id="thumb" value="<?php echo $base_url.$thumb; ?>">
 <?php }else
  { ?>
  <input type="hidden" name="thumb" id="thumb" value="">
 <?php }
  ?>
  
  <?php  if($ads){ ?>
  <input type="hidden" name="ads" id="ads" value="<?php echo $ads; ?>">
 <?php }else
  { ?>
  <input type="hidden" name="ads" id="ads" value="">
 <?php }
  ?>
  
  
  <?php  if($adsmp4videopath){ ?>
 <input type="hidden" name="adsmp4video" id="adsmp4video" value="<?php echo $base_url.$adsmp4videopath; ?>">
 <?php }else
  { ?>
  <input type="hidden" name="adsmp4video" id="adsmp4video" value="">
   <?php }
  ?>
  
  
  <?php  if($adsoggvideopath){ ?>
  <input type="hidden" name="adsoggvideo" id="adsoggvideo" value="<?php echo $base_url.$adsoggvideopath; ?>">
 <?php }else
  { ?>
  <input type="hidden" name="adsoggvideo" id="adsoggvideo" value="">
   <?php }
  ?>
  
  
  <?php  if($adswebmvideopath){ ?>
   <input type="hidden" name="adswebmvideo" id="adswebmvideo" value="<?php echo $base_url.$adswebmvideopath; ?>">
 <?php }else
  { ?>
   <input type="hidden" name="adswebmvideo" id="adswebmvideo" value="">
 <?php }
  ?>
 
  
  <?php  if($click_url){ ?>
  <input type="hidden" name="click_url" id="click_url" value="<?php echo $click_url; ?>">
 <?php }else
  { ?>
<input type="hidden" name="click_url" id="click_url" value="">
 <?php }
  ?>
  
</body>

<!-- Mirrored from 0.s3.envato.com/files/72887546/theme1.html by HTTrack Website Copier/3.x [XR&CO'2013], Fri, 25 Jul 2014 07:34:16 GMT -->
</html>