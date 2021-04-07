<?php 
	ob_start();
	session_start();	
	
	require_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/time_stamp.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/tolink.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
	if(isset($_SESSION['lang']))
	{	
		include($root_folder_path.'public_html/common.php');
	}
	else
	{		
		include($root_folder_path.'public_html/Languages/en.php');		
	}
	if(!isset($_SESSION['SESS_MEMBER_ID'])){
		$member_id="";
	}
	else
	{
		$member_id = $_SESSION['SESS_MEMBER_ID'];
	}
	$objMember = new member1();
	$msg_id = $_REQUEST['id'];
	$sql = mysqli_query($con, "select * from member where member_id='".$member_id."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);
	
	$logMemPic=$objMember->select_member_meta_value($res['member_id'],'current_profile_image');
	if($logMemPic){			
		$logMemPic=$base_url.$logMemPic;	
	}
	else{
		$logMemPic=$base_url.'images/default.png';
	}
	
	$msql = mysqli_query($con, "SELECT msg.messages_id, msg.messages, msg.date_created, msg.type, msg.wall_privacy, m.member_id,msg.msg_album_id, msg.country_flag,
	                     u.upload_data_id,msg.share
		                 , msg.share_by,m.username,msg.share_msg,
						 v.location,v.location1,v.location2, v.thumburl, v.title, v.video_id, v.description,
 		  v.msg_id, v.category, v.title_color,v.title_size,v.ads,a.ads_name,
	      a.location as adslocation,a.location1 as adslocation1,a.location2 as adslocation2, a.click_url
		                 FROM message msg 
						 INNER JOIN member m ON msg.member_id = m.member_id 
		                 LEFT JOIN upload_data u on msg.messages_id = u.msg_id
						 LEFT JOIN videos v ON v.msg_id = msg.messages_id
						 LEFT JOIN videos_ads a ON v.ads_id = a.id			  		  
		                 WHERE msg.messages_id = '$msg_id'") or die(mysqli_error($con));
    $mres = mysqli_fetch_array($msql);
	
	if(mysqli_num_rows($msql) == 0 || (!isset($_REQUEST['id']))) {
		header('location:error.html');
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#"
      xmlns:fb="https://www.facebook.com/2008/fbml">
<head>
<title>QuakBox</title>
<!-- Open Graph data --> 
<meta property="og:title" content="Quakbox" />
<?php 
	$ogImage = "";
	if($mres['type'] == 1) { 
		$ogImage = $base_url.$mres['messages'];
		$size = getimagesize($ogImage);
		if(!empty($size)){
			if($size[0] < 200 || $size[1] < 200){
				$ogImage = '';
			}
		}
	}
	if($mres['type'] == 2) {
		$ogImage = $base_url. "common/qb_share_image.php?i=" . base64_encode('uploadedvideo/videothumb/p400x225'.$mres['thumburl']);
	}

	if( $ogImage == "" ){
		$ogImage = $base_url . "assets/images/ogimage.png";
	} 
	
?>
<meta property="og:image" content="<?php echo $ogImage;?>" />
<meta property="og:image:secure_url" content="<?php echo $ogImage;?>" />
<meta property="og:description" content="<?php if($mres['type'] == 0) { echo substr($mres['messages'],0,150); }if($mres['type'] == 2){ echo substr($mres['description'],0,150); }?>" />
<!-- Twitter Card data -->
<meta name="twitter:card" content="summary" />
<meta name="twitter:site" content="@qb" />
<meta name="twitter:title" content="QuakBox" />
<meta name="twitter:description" content="<?php if($mres['type'] == 0) { echo substr($mres['messages'],0,150); }if($mres['type'] == 2){ echo substr($mres['description'],0,150); }?>" />
<meta name="twitter:creator" content="@omkar" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="<?php if($mres['type'] == 0) { echo substr($mres['messages'],0,150); }if($mres['type'] == 2){ echo substr($mres['description'],0,150); }?>" />
<!-- Twitter Summary card images must be at least 200x200px -->
<meta name="twitter:image" content="<?php if($mres['type'] == 1) { echo $base_url.$mres['messages']; }if($mres['type'] == 2) {echo $base_url.'uploadedvideo/videothumb/p400x225'.$mres['thumburl'];}?>" />
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<!--<meta charset="utf-8">-->
<meta name="google-translate-customization" content="8b141b4044eaadae-34d0daded713c076-gf3a3a33322f73d44-10"></meta>
<meta http-equiv="X-UA-Compatible" content="IE=edge">   

<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/wall.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/group.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/style.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/search.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/youtube.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/jquery-ui.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/video-js.css">
<link href="<?php echo $base_url;?>css/videojs.addThis.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/jquery.share.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>font-awesome/css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/responsive.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/memberprofile.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>assets/jquery-alert-dialogs/css/jquery.alerts.css"/>
<link rel="icon" href="<?php echo $base_url;?>images/favicon.ico" type="image" />
<link rel="shortcut icon" href="<?php echo $base_url;?>images/favicon.ico" type="image" />
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/keyboard.css"/>
<link rel="stylesheet" href="<?php echo $base_url;?>assets/chosen-jquery/chosen.css">
<link rel="stylesheet"  type="text/css" href="<?php echo $base_url;?>css/token-input.css"/>
<link rel="stylesheet"  type="text/css" href="<?php echo $base_url;?>css/token-input-facebook.css"/>
<link rel="stylesheet"  type="text/css" href="<?php echo $base_url;?>css/token-input-mac.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/bootstrap-theme.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/about.css" />
<!--external js file-->
<script src="<?php echo $base_url;?>js/modernizr.custom.91332.js"></script>
<script src="<?php echo $base_url;?>js/jquery.min.js"></script>
<script src="<?php echo $base_url;?>js/selectivizr.js"></script>
<script src="<?php echo $base_url;?>js/html5shiv-printshiv.js"></script>
<script src="<?php echo $base_url;?>js/respond.js"></script>
<script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>js/ibox2.2.js"></script>
<!--<script src="https://www.microsofttranslator.com/ajax/v3/widgetv3.ashx" type="text/javascript"></script>-->
<script src="<?php echo $base_url;?>js/jquery.form.js"></script>
<script src="<?php echo $base_url;?>js/jquery.livequery.js" type="text/javascript"></script>
<script src="<?php echo $base_url;?>js/jquery.oembed.js"></script>
<script src="<?php echo $base_url;?>js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>js/jquery.share.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>js/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>assets/jquery-alert-dialogs/js/jquery.alerts.js"></script>
<!--<script type="text/javascript" src="<?php echo $base_url;?>js/keyboard.js"></script>-->
<!--common scripts for all wall pages-->
<?php if(isset($_SESSION['SESS_MEMBER_ID'])){?>
		<script src="<?php echo $base_url;?>js/translate.js"></script><?php } ?>
<?php 
  //include "js/wall-js.php";
 ?>

<script type="text/javascript" src="<?php echo $base_url;?>js/jquery.tokeninput.js"></script>
<script src="<?php echo $base_url;?>js/wall.js"></script>

<script src="<?php echo $base_url;?>js/common-scripts.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>js/autocomplete.js"></script>

<!--video player files -->
<link rel="stylesheet" href="<?php echo $base_url;?>video-ads/css/videoPlayerMain.css" type="text/css">
  <link rel="stylesheet" href="<?php echo $base_url;?>video-ads/css/videoPlayer.theme1.css" type="text/css">
  <link rel="stylesheet" href="<?php echo $base_url;?>video-ads/css/preview.css" type="text/css" media="screen"/>

  
  <script src="<?php echo $base_url;?>video-ads/js/IScroll4Custom.js" type="text/javascript"></script>
  <script src='<?php echo $base_url;?>video-ads/js/THREEx.FullScreen.js'></script>
  <script src="<?php echo $base_url;?>video-ads/js/videoPlayer.js" type="text/javascript"></script>
  <script src="<?php echo $base_url;?>video-ads/js/Playlist.js" type="text/javascript"></script> <!--video player files -->
  <?php if(isset($_SESSION['SESS_MEMBER_ID'])){?>
  <script src="<?php echo $base_url;?>js/check.js"></script><?php } ?>
</head>
<body onload="onLoad();">

<div id="wrapper">
<?php if(isset($_SESSION['SESS_MEMBER_ID'])){ include 'includes/header.php'; } 
else{ include 'includes/front_header.php'; } ?>

 <div id="mainbody">

<div class="column_left" style="border:none; width:850px;">
 
     
 <div class="column_internal_left" style="margin-top:0" >
    

<div class="post" style="border:1px solid #CCC">
 
<?php
$query  = "SELECT msg.messages_id, msg.messages, msg.date_created, msg.type, msg.wall_privacy, m.member_id,
		  msg.msg_album_id, m.username, msg.country_flag, u.upload_data_id,msg.share,
		  msg.share_by,m.username , msg.share_msg,
		  v.location,v.location1,v.location2, v.thumburl, v.title, v.video_id, v.description,
 		  v.msg_id, v.category, v.title_color,v.title_size,v.ads,a.ads_name,
	      a.location as adslocation,a.location1 as adslocation1,a.location2 as adslocation2, a.click_url
		  FROM message msg LEFT JOIN member m ON msg.member_id = m.member_id 
		  LEFT JOIN upload_data u on msg.messages_id = u.msg_id	
		  LEFT JOIN videos v ON v.msg_id = msg.messages_id 
		  LEFT JOIN videos_ads a ON v.ads_id = a.id		  
		  WHERE msg.messages_id = '$msg_id'";		  
		  

$result = mysqli_query($con, $query) or die(mysqli_error($con));

while($row = mysqli_fetch_assoc($result))
{
	$msg_id           = $row['messages_id'];
	$orimessage       = $row['messages'];
	$time             = $row['date_created']; 
	$share_member_id  = $row['share_by'];	
	
	$smquery = "SELECT member_id,username FROM member WHERE member_id = '$share_member_id'";
	$smsql = mysqli_query($con, $smquery);
	$smres = mysqli_fetch_array($smsql);
	
	$title = $row['title'];
$description = $row['description'];
$mp4videopath = $row['location'];
$oggvideopath = $row['location1'];
$webmvideopath = $row['location2'];
$thumb = $row['thumburl'];
$ads = $row['ads'];
$adsmp4videopath = $row['adslocation'];
$adsoggvideopath = $row['adslocation1'];
$adswebmvideopath = $row['adslocation2'];
$click_url = $row['click_url'];

$memberPic=$objMember->select_member_meta_value($row['member_id'],'current_profile_image');
if($memberPic){			
	$memberPic=$base_url.$memberPic;	
}
else{
	$memberPic=$base_url.'images/default.png';
}
		
?>
<script type="text/javascript"> 
$(document).ready(function(){$("#stexpand<?php echo $msg_id;?>").oembed("<?php echo  $orimessage; ?>",{maxWidth: 400, maxHeight: 300});});
</script>	
<div class="stbody" id="stbody<?php echo $row['messages_id'];?>" style="border:none;">

<div class="stimg">
<?php if($member_id == $row['member_id'])
{
   
?>



<a href="<?php echo $base_url.'i/'.$row['username']; ?>"><img src="<?php echo $memberPic;?>" class='big_face' original-title="<?php echo $row['username'];?>"/></a> 

<?php } 
else
{
?>
<a href="<?php echo $base_url.$row['username'];?>"><img src="<?php echo $memberPic;?>" class='big_face' original-title="<?php echo $row['username'];?>"/></a> 
<?php } ?>

</div><!--End stimg div	-->

<div class="sttext">
<?php 
if($member_id == $row['member_id'])
{
?>
<a class="stdelete" href="#" id="<?php echo $row['messages_id'];?>" original-title="Delete update" title="Delete update"></a>
<?php }
if($row['share'] != 1)
	{
if($member_id == $row['member_id'])
{

?>


<a href="<?php echo $base_url.'i/'.$row['username']; ?>"><b><?php echo $row['username'];?></b></a> 

<?php } 
else
{
?>
<a href="<?php echo $base_url.$row['username'];?>"><b><?php echo $row['username'];?></b></a> 
<?php }

	}
if($row['country_flag'] != NULL)
{
	if($row['share'] == 1)
	{
	echo "<a href='".$base_url.$smres['username']."'><b>".$smres['username']."</b></a>" ;		
echo " share a ";
//echo "<a href='".$base_url.$smres['username']."'><b>".$row['username']."</b></a>" ;	

if($row['type'] == 0)
{
	echo '<a href="posts.php?id='.$row['messages_id'].'"> status</a>';
}
else if($row['type'] == 1)
{
	echo '<a href="albums.php?back_page=country_wall.php?country='.$row['country_flag'].'&member_id='.$row['member_id'].'&album_id='.$row['msg_album_id'].'&image_id='.$row['upload_data_id'].'"> photo</a>';
}
else
{
	echo '<a href="watch.php?video_id='.$row['video_id'].'"> video</a>';
}
} 
else
{
?>
<img style="margin:0px 3px;" src="images/arrow_png.jpg" /> 
<a href="<?php echo $homepage;?>"><b><?php echo strtoupper($row['country_flag']);?></b></a>
<?php } 
}
?>

<div style="margin:5px 0px;">
 <?php if($row['type']==0)
 {
	echo tolink(htmlentities($row['messages']));
?> 
<div tabindex="1" id="posttranslatemenu<?php echo $row['messages_id'];?>" class="posttranslatemenu" style="display:none; position:absolute; "> <select id="postlangs<?php echo $row['messages_id'];?>" class="postlangs" onchange="selectOption(this.value, <?php echo $row['messages_id'];?>,2)">
            <option value="">Select Language</option> 
            </select>
            </div> 
            
<textarea class="postsource" id="postsource<?php echo $row['messages_id']; ?>"  style="display:none;"><?php echo $row['messages']; ?></textarea>
<div class="posttarget" style="font:bold;" id="posttarget<?php echo $row['messages_id']; ?>"></div>
<?php
} 
if($row['type']==1){?>
<a href="albums.php?back_page=<?php echo $homepage;?>&member_id=<?php echo $row['member_id']; ?>&album_id=<?php echo $row['msg_album_id']; ?>&image_id=<?php echo $row['upload_data_id'];?>" >
<?php 
	list($width, $height) = getimagesize($row['messages']);
	if($width > 600)
	{
	?>
    <img src="<?php echo $row['messages'];?>" class="stimage"/>
    <?php } 
	else if($width <= 600)
	{
	?>
	<img src="<?php echo $row['messages'];?>" class="stimage"/>
	<?php } 
	else
	{
	?>
    <img src="<?php echo $row['messages'];?>" class="stimage"/>
    <?php } ?>
</a>

<?php } if($row['type']==2){ $video_id=$row['video_id'];?>
<a href="watch.php?video_id=<?php echo $row['video_id'];?>" style="color:#993300;">
<h3 class="video_title"  ><?php echo $row['title'];?></h3></a>
<div id="videoplayerid<?php echo $row['video_id'];?>"> </div>
 <?php 
 $videoid="videoplayerid".$row['video_id'];
 $mp4videopath1 = $base_url.$mp4videopath;
 $oggpath = $base_url.$oggvideopath;
 $webmpath = $base_url.$webmvideopath;
 $thumwala = $base_url."uploadedvideo/videothumb/p400x225".$thumb;
 $adsmp4 = $base_url.$adsmp4videopath;
 $adsogg = $base_url.$adsoggvideopath;
 $adswebm = $base_url.$adswebmvideopath;
 $fetch = $base_url."fetch_posts.php?id=".$video_id;
 ?>
<script type="text/javascript" charset="utf-8">
       var videoidqw = "<?php Print($videoid); ?>";
    var title1 = "<?php Print($title); ?>";
		var desc1 = "<?php Print($description); ?>";
		var mp4videopath = "<?php Print($mp4videopath1); ?>";
		var oggvideopath = "<?php Print($oggpath); ?>";
		var webmvideopath = "<?php Print($webmpath); ?>";
		var thumb = "<?php Print($thumwala); ?>";
		var adsmp4videopath = "<?php Print($adsmp4); ?>";
		var adsoggvideopath = "<?php Print($adsogg); ?>";
		var adswebmvideopath = "<?php Print($adswebm); ?>";
		var ads = "<?php Print($ads); ?>";
		if(ads == 1){
			var adsFlag = true;
		}else {
			var adsFlag = false;
		}
		var click_url = "<?php Print($click_url); ?>";
		var fetch_url = "<?php Print($fetch); ?>";
		
        videoPlayer = $("#"+videoidqw).Video({
            autoplay:false,
            autohideControls:4,
            videoPlayerWidth:400,
            videoPlayerHeight:250,
            posterImg:thumb,
            fullscreen_native:false,
            fullscreen_browser:true,
            restartOnFinish:false,            
            rightClickMenu:true,
            
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
                id:"0",
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

    

  </script>

<?php }?>

</div>

<div><span class="sttime" title="<?php echo date($time);?>"><?php echo time_stamp($time);?></span>
<br />
<!-- LIke users display panel -->
<?php 

$sql = mysqli_query($con, "SELECT * FROM bleh WHERE remarks='". $row['messages_id'] ."'");
$like_count = mysqli_num_rows($sql);

if($like_count > 0) 
{ 
$query=mysqli_query($con, "SELECT m.username,m.member_id FROM bleh b, member m WHERE m.member_id=b.member_id AND b.remarks='".$row['messages_id']."' LIMIT 3");
$like = mysqli_num_rows($query);
?>
<div class="commentPanel">
<!-- LIke users display panel -->
<div class='likeUsers' id="likes<?php echo $row['messages_id']; ?>">
<?php
while($row1 = mysqli_fetch_array($query))
{
$like_uid = $row1['member_id'];
$likeusername = $row1['username'];
$newlike_count = $like_count - 3; 
if($like_uid == $member_id)
{
	if($like_count > 1)
	{
		echo '<span id="you'.$row['messages_id'].'">You and </span>';
	}
	else
	{
		echo '<span id="you'.$row['messages_id'].'">You</span>';
	}
}
else
{ 
echo '<a id="likeuser'.$row['messages_id'].'" href="'.$likeusername.'">'.$likeusername.' </a>';
}  
}
if($like_count > 3)
{
echo '<span id="likeuser'.$row['messages_id'].'">'.$likeusername.' </span>others like this';
}
else
{
	echo ' like this';
}
?> 
</div>
</div>
<?php 
}
else 
{ 
	echo '<div class="likeUsers" id="elikes'.$row['messages_id'].'"></div>';
} 

?>
<br />
<!--Dislike users display panel-->

<!--
<?php 

$sql1 = mysqli_query("SELECT * FROM blehdis WHERE remarks='". $row['messages_id'] ."'");
$dislike_count = mysqli_num_rows($sql1);

if($dislike_count > 0) 
{ 
$query1=mysqli_query("SELECT m.username,m.member_id FROM blehdis b, member m WHERE m.member_id=b.member_id AND b.remarks='".$row['messages_id']."' LIMIT 3");
$dislike = mysqli_num_rows($query1);
?>
<div class="commentPanel">
<!--Like users display panel 
<div class='dislikeUsers' id="dislikes<?php echo $row['messages_id']; ?>">
<?php
while($row12 = mysqli_fetch_array($query1))
{
$dislike_uid = $row12['member_id'];
$dislikeusername = $row12['username'];
$disnewlike_count = $dislike_count - 3; 
if($dislike_uid == $member_id)
{
	if($dislike_count > 1)
	{
echo '<span id="you'.$row['messages_id'].'">You and </span>';
	}
	else
	{
		echo '<span id="you'.$row['messages_id'].'">You</span>';
	}
}
else
{ 
echo '<a href="'.$dislikeusername.'">'.$dislikeusername.' </a>';
}  
}
if($dislike_count > 3)
{
echo ' and '.$disnewlike_count.' other friends dislike this';
}
else
{
	echo ' Dislike this';
}
?> 
</div></div>
<?php 
}
else 
{ 
	echo '<div class="dislikeUsers" id="diselikes'.$row['messages_id'].'"></div>';
} 

?>-->

</div> <!-- End of timestamp div -->
<?php
$query1  = mysqli_query($con, "SELECT * FROM postcomment WHERE msg_id=" . $row['messages_id'] . " ORDER BY comment_id DESC");
$records = mysqli_num_rows($query1);
$s = mysqli_query($con, "SELECT * FROM postcomment WHERE msg_id=" . $row['messages_id'] . " ORDER BY comment_id DESC limit 4,$records");
$y = mysqli_num_rows($s);
if ($records > 4)
{
	$collapsed = true;?>
    <input type="hidden" value="<?php echo $records?>" id="totals-<?php  echo $row['messages_id'];?>" />
	<div class="commentPanel" id="collapsed-<?php  echo $row['messages_id'];?>" align="left">
	<img src="images/cicon.png" style="float:left;" alt="" />
	<a href="javascript: void(0)" class="ViewComments" id="<?php echo $row['messages_id'];?>">
	View <?php echo $y;?> more comments 
	</a>
	<span id="loader-<?php  echo $row['messages_id']?>">&nbsp;</span>
	</div>
<?php
}
?>
<div id="stexpandbox">
<div id="stexpand<?php echo $msg_id;?>"></div>
</div><!--End stexpandbox div	--> 

<div class="commentcontainer" id="commentload<?php echo $row['messages_id'];?>">
<?php
$comment  = mysqli_query($con, "SELECT * FROM postcomment p,member m  WHERE p.post_member_id=m.member_id and p.msg_id=" . $row['messages_id'] . " ORDER BY comment_id DESC limit 0,4");
while($row1 = mysqli_fetch_assoc($comment))
{
$memberPic1=$objMember->select_member_meta_value($row1['member_id'],'current_profile_image');
if($memberPic1){			
	$memberPic1=$base_url.$memberPic1;	
}
else{
	$memberPic1=$base_url.'images/default.png';
}
?>
<div class="stcommentbody" id="stcommentbody<?php echo $row1['comment_id']; ?>">
<div class="stcommentimg">
<a href="<?php echo $base_url.$row['username'];?>"><img src="<?php echo $memberPic1; ?>" class='small_face'/></a>
</div> 
<div class="stcommenttext">
<?php 
if($member_id == $row1['member_id'])
{
?>
<a class="stcommentdelete" href="#" id='<?php echo $row1['comment_id']; ?>' title='Delete Comment'></a>
<?php } ?>
<a href="<?php echo $base_url.$row1['username'];?>"><b><?php echo $row1['username']; ?></b> </a>
<?php 
if($row1['type']==1){ echo '.'.$row1['content'];
	?>
	
	<div id="translatemenu<?php echo $row1['comment_id'];?>" class="translatemenu" style="display:none; position:absolute;"> <select id="langs<?php echo $row1['comment_id'];?>" class="langs" onchange="selectOption(this.value, <?php echo $row1['comment_id'];?>,1)">
            <option value="">Select Language</option> 
            </select></div> 
            
	<textarea class="source" id="source<?php echo $row1['comment_id']; ?>"  style="display:none;"><?php echo $row1['content']; ?></textarea>
	<?php
}
if($row1['type']==2) echo '<img src="'.$row1["content"].'" >';
?>
<div class="target" style="font:bold;" id="target<?php echo $row1['comment_id']; ?>"></div>
<div class="stcommenttime"><?php time_stamp($row1['date_created']); ?>
<!--  like button  -->
<span style="padding-left:5px;">
<!--like block-->
<div>
<?php
$sql = mysqli_query($con, "SELECT * FROM comment_like WHERE comment_id='". $row1['comment_id'] ."'");
$comment_like_count = mysqli_num_rows($sql);

$comment_like_query1 = mysqli_query($con, "SELECT m.username,m.member_id FROM comment_like c, member m WHERE m.member_id=c.member_id 
AND c.comment_id='".$row1['comment_id']."' AND c.member_id='$member_id' ");
$comment_like_res1 = mysqli_num_rows($comment_like_query1);
if($comment_like_res1==1)
{
$comment_like_query = mysqli_query($con, "SELECT m.username,m.member_id FROM comment_like c, member m WHERE m.member_id=c.member_id 
AND c.comment_id='".$row1['comment_id']."' AND c.member_id!='$member_id' LIMIT 2");
$clike_count = mysqli_num_rows($comment_like_query);
$new_clike_count=$comment_like_count-2; 
}
else
{
$comment_like_query = mysqli_query($con, "SELECT m.username,m.member_id FROM comment_like c, member m WHERE m.member_id=c.member_id 
AND c.comment_id='".$row1['comment_id']."' LIMIT 3");
$clike_count = mysqli_num_rows($comment_like_query);
$new_clike_count=$comment_like_count-3; 
}

?>
<div class="clike" id="clike<?php echo $row1['comment_id'];?>" style="display:<?php if($comment_like_count <= 0) { echo 'none'; } else { echo 'block'; }?>">
<?php 

if($comment_like_res1==1)
{?><span id="you<?php echo $row1['comment_id'];?>"><a href="#">You</a><?php if($comment_like_count>1)
echo ','; ?> </span><?php
}

?>
<!-- <input type="hidden" value="<?php if($comment_like_res1==1)echo 1;else echo 0; ?>" id="youcount<?php echo $row1['comment_id'];?>" > -->
<input type="hidden"  value="<?php echo $comment_like_count; ?>" id="commacount<?php echo $row1['comment_id'];?>" >
<?php

$i = 0;
while($comment_like_res = mysqli_fetch_array($comment_like_query)) {
$i++; 	  
?>

<a href="#" id="likeuser<?php echo $row1['comment_id'];?>"><?php echo $comment_like_res['username']; ?></a>
<?php
	//}
if($i <> $clike_count) { echo ',';}
//} 
} 
if($clike_count > 3) {
?>
 and <span id="like_count<?php echo $row1['comment_id'];?>" class="numcount"><?php echo $new_clike_count;?></span> others<?php } ?> like this.</div> 
<!--<span id="commentlikecout_container<?php echo $row1['comment_id'];?>" style="display:<?php if($comment_like_count <= 0) { echo 'none'; } else { echo 'block'; }?>">

<span id="commentlikecount<?php echo $row1['comment_id'];?>">
<?php
echo $comment_like_count;
?>
</span>
Like this
</span>
-->
</div>
<!--end like block-->

<!--dislie block-->
<div>
<?php
$cdquery = "SELECT * FROM comment_dislike WHERE comment_id='". $row1['comment_id'] ."'";
$cdsql  = mysqli_query($con, $cdquery) or die(mysqli_error($con));
$comment_dislike_count = mysqli_num_rows($cdsql);

$cdquery1 = mysqli_query($con, "SELECT m.username,m.member_id FROM comment_dislike c, member m WHERE m.member_id=c.member_id 
AND c.comment_id='".$row1['comment_id']."' LIMIT 3");
?>
<span id="dislikecout_container<?php echo $row1['comment_id'];?>" style="display:<?php if($comment_dislike_count <= 0) { echo 'none'; } else { echo 'block'; }?>">
<span id="dislikecout<?php echo $row1['comment_id'];?>">
<?php
echo $comment_dislike_count;
?>
</span>
Person Dislike this
</span>
</div>
<!--end dislike block-->
</span>
<span style="top:2px;">
<?php
$comment_like = mysqli_query($con, "select * from comment_like where comment_id = '".$row1['comment_id']."' and member_id = '".$member_id."'");
if(mysqli_num_rows($comment_like) > 0)
{
	echo '<a href="javascript: void(0)" class="comment_like" id="comment_like'.$row1['comment_id'].'" msg_id = '.$row['messages_id'].' title="Unlike" rel="Unlike">Unlike</a>';
} 
else 
{ 
	echo '<a href="javascript: void(0)" class="comment_like" id="comment_like'.$row1['comment_id'].'" msg_id = '.$row['messages_id'].' title="Like" rel="Like">Like</a>';
}
?>
</span>
<!-- End of like button -->
<!-- Dislike button -->
<span style="top:2px; padding-left:5px;">
<?php
$cdquery1 = "SELECT * FROM comment_dislike WHERE comment_id='". $row1['comment_id'] ."' and member_id = '".$member_id."'";
$cdsql1  = mysqli_query($con, $cdquery1) or die(mysqli_error($con));
$comment_dislike_count1 = mysqli_num_rows($cdsql1);
if($comment_dislike_count1 > 0) {
echo '<a href="javascript: void(0)" class="comment_dislike" id="comment_dislike'.$row1['comment_id'].'" title="disLike" rel="disLike">DisLike</a>';
} else {
echo '<a href="javascript: void(0)" class="comment_dislike" id="comment_dislike'.$row1['comment_id'].'" title="disLike" rel="disLike">DisLike</a>';
}
?>
</span> 
<!-- End of dislike  button -->
<!-- Reply Button -->
<span style="top:2px; margin-left:5px;">
<a href="" id="<?php echo $row1['comment_id'];?>" class="replyopen">Reply</a>
</span>
<!-- <?php if($row1['type']==1){?><span style="top:2px; left:3px;"><a class="translatebutton" onclick="translateSourceTarget(<?php echo $row1['comment_id'];?>);" href="javascript:void(0)" >Translate </a> </span><?php } ?> -->

<?php if($row1['type']==1)
{ ?>
<span style="top:2px; margin-left:3px;" > <a class="translateButton" href="javascript:void(0);" id="translateButton<?php echo $row1['comment_id'];?>"  >Translate</a></span>

       
<?php 
} ?>


<!--View more reply-->
<?php
$query12  = mysqli_query($con, "SELECT * FROM comment_reply WHERE comment_id=" . $row1['comment_id'] . " ORDER BY reply_id DESC");
$records1 = mysqli_num_rows($query12);
$p = mysqli_query($con, "SELECT * FROM comment_reply WHERE comment_id=" . $row1['comment_id'] . " ORDER BY reply_id DESC limit 2,$records1");
$q = mysqli_num_rows($p);
if ($records1 > 2)
{
	$collapsed1 = true;?>
    <input type="hidden" value="<?php echo $records1?>" id="replytotals-<?php  echo $row1['comment_id'];?>" />
	<div class="replyPanel" id="replycollapsed-<?php  echo $row1['comment_id'];?>" align="left">
	<img src="images/cicon.png" style="float:left;" alt="" />
	<a href="javascript: void(0)" class="ViewReply">
	View <?php echo $q;?> more replys 
	</a>
	<span id="loader-<?php  echo $row1['comment_id']?>">&nbsp;</span>
	</div>
<?php
}
?>
</div>

</div>
<div class="replycontainer" style="margin-left:40px;" id="replyload<?php echo $row1['comment_id'];?>">

<?php
$reply_sql  = mysqli_query($con, "SELECT * FROM comment_reply c,member m WHERE c.member_id = m.member_id and comment_id=" . $row1['comment_id'] . " ORDER BY reply_id DESC limit 0,2");

while($reply_res = mysqli_fetch_assoc($reply_sql))
{
$memberPic2=$objMember->select_member_meta_value($reply_res['member_id'],'current_profile_image');
if($memberPic2){			
	$memberPic2=$base_url.$memberPic2;	
}
else{
	$memberPic2=$base_url.'images/default.png';
}
?>
<div class="streplybody" id="streplybody<?php echo $reply_res['reply_id']; ?>">
<div class="stcommentimg">
<a href="<?php echo $base_url.$row['username'];?>"><img src="<?php echo $memberPic2; ?>" class='small_face'/></a>
</div>
<div class="streplytext">
 <?php 
if($member_id == $reply_res['member_id'])
{
?>
<a class="streplydelete" href="#" id='<?php echo $reply_res['reply_id']; ?>' title='Delete Reply'></a>
<?php } ?>
<a href="<?php echo $base_url.$reply_res['username'];?>"><b><?php echo $reply_res['username']; ?> 
 
 </b></a>
<?php 
 
 if($row1['member_id'] <> $reply_res['member_id'])
 {
	 echo '@'; 
	?> <a href="<?php echo $base_url.$row1['username'];?>"><b><?php echo $row1['username']; ?> 
 
 </b></a>
	 
<?php
 }
   ?> 
 

<?php 
echo $reply_res['content'];
?>
<div class="streplytime"><?php time_stamp($reply_res['date_created']); ?></div>
</div><!--End streplytext div-->
</div><!--End streplybody div-->
<?php } ?>
<!--Start replyupdate -->
<div class="replyupdate" style='display:none' id='replybox<?php echo $row1['comment_id'];?>'>
<div class="streplyimg">
<img src="<?php echo $logMemPic;?>" class='small_face'/>
</div>

<div class="streplytext" >
<form method="post" action="">
<textarea name="reply" class="reply" maxlength="200"  id="rtextarea<?php echo $row1['comment_id'];?>"></textarea>
<br /> 
<input type="submit" abcd="<?php echo $row1['member_id']; ?>"  title="<?php echo $row1['username']; ?>" value="    @    "  id="<?php echo $row1['comment_id'];?>" class="reply_button"/>
<input type="button"  value=" Cancel "  id="<?php echo $row['messages_id'];?>" onclick="closereply('replybox<?php echo $row1['comment_id'];?>')" class="cancel"/>
</form>
</div>
</div><!--End replyupdate div	--> 
</div><!--End replycontainer div-->
</div>
<?php } 
$q = mysqli_query($con, "SELECT * FROM bleh WHERE member_id='". $member_id ."' and remarks='".$row['messages_id']."' ");
?>

</div><!--End commentcontainer div	--> 

<div class="commentupdate" style='display:none;' id='commentbox<?php echo $row['messages_id'];?>'>
<div class="stcommentimg">
<img src="<?php echo $logMemPic;?>" class='small_face'/>
</div>

<div class="stcommenttext" >
<form method="post" action="">
<textarea name="comment" class="comment" maxlength="200"  id="ctextarea<?php echo $row['messages_id'];?>"></textarea>
<br />
<input type="submit"  value=" Comment "  id="<?php echo $row['messages_id'];?>" class="button"/>
<input type="button"  value=" Cancel "  id="<?php echo $row['messages_id'];?>" onclick="cancelclose('commentbox<?php echo $row['messages_id'];?>')" class="cancel"/>

</form>
</div>
</div><!--End commentupdate div	--> 
<div class="commentupdate" style='display:none' id='reportbox<?php echo $row['messages_id'];?>'>
<div class="stcommentimg">
<img src="<?php echo $logMemPic;?>" class='small_face'/>
</div>

<div class="stcommenttext" >
<form method="post" action="">
<textarea name="comment" class="comment" maxlength="200"  id="rptextarea<?php echo $row['messages_id'];?>" placeholder="Flag this status.."></textarea>
<br />
<input type="submit"  value=" Report "  id="<?php echo $row['messages_id'];?>" class="report"/>
<input type="button"  value=" Cancel "  id="<?php echo $row['messages_id'];?>" onclick="canclose('reportbox<?php echo $row['messages_id'];?>')" class="cancel"/>
</form>
</div>
</div><!--End commentupdate div	-->
 
<div class="emot_comm">
    <div id="normal-button" class="settings-button" title="0" value="<?php echo $row['messages_id']; ?>" >
    <span style="bottom: 2px;float: left;position: relative;width: 33px;cursor: pointer;" class="">
	<img src="images/Glad.png"/>
	</span>
    </div>
	<div class="submenu12" id="<?php echo $row['messages_id']; ?>-submenu12" style="display: none; position: absolute; background:#ffffff; margin-top:15px;">
	  
	      <a href="action/commentpost.php?postid=<?php echo $row['messages_id']; ?>&member_id=<?php echo $member_id; ?>&postcomment=images/1.jpg&type=2" ><img src="images/1.jpg"></a>
	    
	      <a href="action/commentpost.php?postid=<?php echo $row['messages_id']; ?>&member_id=<?php echo $member_id; ?>&postcomment=images/2.jpg&type=2" ><img src="images/2.jpg"></a>
	    
	      <a href="action/commentpost.php?postid=<?php echo $row['messages_id']; ?>&member_id=<?php echo $member_id; ?>&postcomment=images/3.jpg&type=2" ><img src="images/3.jpg"></a>
	    
	      <a href="action/commentpost.php?postid=<?php echo $row['messages_id']; ?>&member_id=<?php echo $member_id; ?>&postcomment=images/4.jpg&type=2" ><img src="images/4.jpg"></a>
	      
	      <a href="action/commentpost.php?postid=<?php echo $row['messages_id']; ?>&member_id=<?php echo $member_id; ?>&postcomment=images/5.jpg&type=2" ><img src="images/5.jpg"></a>
	    
	     <a href="action/commentpost.php?postid=<?php echo $row['messages_id']; ?>&member_id=<?php echo $member_id; ?>&postcomment=images/6.jpg&type=2" ><img src="images/6.jpg"></a>
	    
	      <a href="action/commentpost.php?postid=<?php echo $row['messages_id']; ?>&member_id=<?php echo $member_id; ?>&postcomment=images/1.gif&type=2" ><img src="images/1.gif"></a>
	   
	</div>
    
	<span class="show-cmt">
 <?php
	if(mysqli_num_rows($q) > 0)
	{
		echo '<a href="javascript: void(0)" class="like" id="like'.$row['messages_id'].'" title="Unlike" rel="Unlike">Unlike</a>';
	} 

	else 
	{ 
		echo '<a href="javascript: void(0)" class="like" id="like'.$row['messages_id'].'" title="Like" rel="Like">Like</a>';
	}
	
?>
</span>



<span class="show-cmt">
<a href="javascript:void(0)" id="<?php echo $row['messages_id'];?>" class="commentopen">Comment</a>
</span>

<span class="show-cmt">
<a href="javascript:void(0)" rowtype="<?php echo $row['type'];?>" class="share_open" id="<?php echo $row['messages_id'];?>" title="Share">Share</a>
</span>

<span class="show-cmt hidden">
<a href="javascript:void(0)" id="<?php echo $row['messages_id'];?>" class="flagopen">Flag this Status</a>
</span>
<?php if($row['type']==0)
 {
	 if(substr($row['messages'],0,4) != 'http' )
{ ?>
<span style="top:2px; left:3px;" >
<a class="posttranslateButton" href="javascript:void(0);" id="posttranslateButton<?php echo $row['messages_id'];?>"  >Translate</a>
</span>
<?php } } ?>
</div>

</div><!--End sttext div	--> 
</div><!--End stbody div	-->

<?php
		//}
		}
 
?>

</div>

</div>

<!--Start column right-->
<?php include 'ads_right_column.php';?>
<!--end column_right div-->
	
</div><!--end left column div-->
 
</div><!--end mainbody div-->
<?php if(isset($_SESSION['SESS_MEMBER_ID'])){ include 'includes/footer.php'; } else { include 'includes/footer_front.php';} ?>
 
 </div><!--end wrapper div-->

<div id="popup" style="display:none;">

    <div id="custom_privacy" style="width:445px; height:200px; margin:10% 40%; background:#FFF; border-radius:2px;">
    <div style="background:#999; border:solid 1px #000000; width:445; text-align:center; padding:5px; font-weight:bold;">Custom Privacy</div>
    <div style="padding:10px">
    <div style="padding:0px 20px;">
    <div>    
    <h3 class="app-box-title">Share this with</h3>
    
    <table cellpadding="0" cellspacing="1">
    <tbody>
<tr>
<td colspan="2"></td>
</tr>
<tr>
<td style="font-weight: bold;text-align: right;width: 140px; padding:5px;vertical-align:top;">
<label style="font-weight: 700;text-align: right; color:#000;">Friends Name</label>
</td>
<td style="padding:5px; vertical-align:top;">
<div class="ui-widget">
<input name="member_name" id="post_friend" style="padding:5px;" />

</div>

</td>
</tr>
</tbody>
</table>
    </div>
    <div>
    <h3 class="app-box-title">Dont Share this with</h3>
        <table cellpadding="0" cellspacing="1">
    <tbody>
<tr>
<td colspan="2"></td>
</tr>
<tr>
<td style="font-weight: bold;text-align: right;width: 140px; padding:5px;vertical-align:top;">
<label style="font-weight: 700;text-align: right; color:#000;">Friends Name</label>
</td>
<td style="padding:5px; vertical-align:top;">
<div class="ui-widget">
<input name="member_name" id="unpost_friend" style="padding:5px;" />
</div>
</td>
</tr>
</tbody>
</table>
    </div>
    </div>
    </div>
    <div style="background:#999; border:solid 1px #000000; width:auto; height:30px; padding:3px;">
    <div style="float:right">
    <input type="button" class="submit" name="submit" value="Save Changes" style="height:26px;"/>
    <input type="button" class="cancel_custom" name="submit" value="Cancel" style="height:26px;" />
    </div>
    </div>
    
    </div>
</div>


<?php include_once 'share.php';?>


</div>
   
<script >
$('.like').live("click", function (e) {

	e.preventDefault();

if (!$(this).data('isClicked')) {
        var link = $(this);

        // Your code on successful click
 
        var ID = $(this).attr("id");
        
        var sid = ID.split("like");
        
        var New_ID = sid[1];
        var REL = $(this).attr("rel");
        
        var URL = '<?php echo $base_url;?>load_data/message_like_ajax.php';
        var dataString = 'msg_id=' + New_ID + '&rel=' + REL;
        $.ajax({
            type: "POST",
            url: URL,
            data: dataString,
            cache: false,
	    dataType: 'json',
            success: function (html,status) {
            
             //var json = jQuery.parseJSON(html) ;
            
            
         	var likecount = html.likecount;
         	//alert(likecount);
                var dislikecount = html.dislikecount;
                
                if(likecount=='expired')
                {
                window.location.assign("<?php echo $base_url;?>login.php");
                }
                else
                {
				
                if (REL == 'Like') {
					if(likecount == 1) {
					
						$("#likes" + New_ID).prepend("<span id='you" + New_ID + "'><?php echo $lang['You'];?> </span>");
						
					}
					if(likecount == 2) {
						$("#likes" + New_ID).prepend("<span id='you" + New_ID + "'><?php echo $lang['You'];?> <?php echo $lang['and'];?></span>");
					}
					if(likecount > 2){
						$("#likes" + New_ID).prepend("<span id='you" + New_ID + "'><?php echo $lang['You'];?>, </span>");
					}
					
                                        
                    $('#' + ID).html('<?php echo $lang['Unlike'];?>').attr('rel', 'Unlike').attr('title', '<?php echo $lang['Unlike'];?>');
                } else {
                    $("#youlike" + New_ID).slideUp('slow');
                    $("#you" + New_ID).remove();
                    $('#' + ID).attr('rel', 'Like').attr('title', '<?php echo $lang['Like'];?>').html('<?php echo $lang['Like'];?>');
                }
				
				if (dislikecount > 0) {					
                    $('#postdislikecount' + New_ID).html(dislikecount);
                } else {
                    $('#postdislike_container' + New_ID).fadeOut('fast');
                }
				
				if (likecount > 0) {
                    $('#likes' + New_ID).fadeIn('fast');
                } else {
                    $('#likes' + New_ID).fadeOut('fast');
                }}
            },
             error: function (jqXHR, textStatus, errorThrown) {
             
            if (typeof errorFn !== 'undefined') {
                errorFn(jqXHR, textStatus, errorThrown);
            }
        },
             complete: function (html,status)
             {   
            
             }
        });
        // Set the isClicked value and set a timer to reset in 3s
        link.data('isClicked', true);
        setTimeout(function() {
            link.removeData('isClicked')
        }, 3000);
    } else {
        // Anything you want to say 'Bad user!'
    }
    return false;
        
    });
	
	//post dislike 
	$('.post_dislike').live("click", function (e) {
	
	e.preventDefault();

if (!$(this).data('isClicked')) {
        var link = $(this);

        // Your code on successful click
	
        var ID = $(this).attr("id");
        var sid = ID.split("post_dislike");
        var New_ID = sid[1];
        var REL = $(this).attr("rel");
        var URL = '<?php echo $base_url;?>load_data/post_dislike_ajax.php';
        var dataString = 'msg_id=' + New_ID + '&rel=' + REL;
        $.ajax({
            type: "POST",
            url: URL,
            data: dataString,
            cache: false,
            dataType: 'json',
            success: function (data) {
            
          
                var likecount = data.likecount;
                var dislikecount = data.dislikecount;
                if(likecount=='expired')
                {
                window.location.assign("<?php echo $base_url;?>login.php");
                }
                else
                {
                $("#you" + New_ID).remove();
                $('#like' + New_ID).html('<?php echo $lang['Like'];?>').attr('rel', 'Like').attr('title', '<?php echo $lang['Like'];?>');
                $("#postdislike_container" + New_ID).fadeIn('slow');
                
                if (dislikecount > 0) {					
                    $('#postdislikecount' + New_ID).html(dislikecount);
                } else {
                    $('#postdislike_container' + New_ID).fadeOut('fast');
                } 
				if (likecount > 0 ) {
                    //$('#commentlikecount' + New_ID).html(likecount);
                } else {
                    $('#likes' + New_ID).fadeOut('fast');
                }               
            }},
             error: function (jqXHR, textStatus, errorThrown) {
             alert(textStatus);
            if (typeof errorFn !== 'undefined') {
                errorFn(jqXHR, textStatus, errorThrown);
            }
        },
            
            
            
        });
        
        // Set the isClicked value and set a timer to reset in 3s
        link.data('isClicked', true);
        setTimeout(function() {
            link.removeData('isClicked')
        }, 3000);
    } else {
        // Anything you want to say 'Bad user!'
    }
    return false;
    });
	
    $('.comment_dislike').live("click", function (e) {
  <?php 

	
	 if(!isset($_SESSION['SESS_MEMBER_ID']))
		
	?>
		//window.location.assign("<?php echo $base_url;?>login.php");
	  	e.preventDefault();

if (!$(this).data('isClicked')) {
        var link = $(this);

        // Your code on successful click
        var ID = $(this).attr("id");
        var sid = ID.split("comment_dislike");
        //alert(sid);
        var New_ID = sid[1];
        var REL = $(this).attr("rel");
        var URL = '<?php echo $base_url;?>load_data/comment_dislike_ajax.php';
        var dataString = 'comment_id=' + New_ID + '&rel=' + REL;
        //alert("dislike");
        $.ajax({
            type: "POST",
            url: URL,
            data: dataString,
            cache: false,
            dataType: 'json',
            success: function (data) {
            //alert(data);
                var likecount = data.likecount;
                var dislikecount = data.dislikecount;
                if(likecount=='expired')
                {
                window.location.assign("<?php echo $base_url;?>login.php");
                }
                else
                {
               //alert(likecount);
               //alert(dislikecount);
                $("#you" + New_ID).remove();
                $('#comment_like' + New_ID).html('<?php echo $lang['Like'];?>').attr('rel', 'Like').attr('title', '<?php echo $lang['Like'];?>');
                $("#dislikecout_container" + New_ID).fadeIn('slow');
                $('#dislikecout' + New_ID).html(dislikecount);
                $('#commentlikecount' + New_ID).html(likecount);
                //alert(likecount);
                if (dislikecount > 0) {
                    $('#dislikecout' + New_ID).html(dislikecount);
                    //$("#clike" + New_ID).hide('slow');
                    //alert(dislikecount);
                } else {
                    $('#dislikecout_container' + New_ID).fadeOut('slow');
                     //alert(dislikecount);
                }
                if (likecount > 0) {
                    $('#commentlikecount' + New_ID).html(likecount);
                } else  {
                    //$('#commentlikecout_container' + New_ID).fadeOut('slow');
                    $("#clike" + New_ID).hide('slow');
                }
            }}
        });
        
         // Set the isClicked value and set a timer to reset in 3s
        link.data('isClicked', true);
        setTimeout(function() {
            link.removeData('isClicked')
        }, 3000);
    } else {
        // Anything you want to say 'Bad user!'
    }
    return false;
        
    });
    $('.comment_like').die('click').live("click", function (e) {
   <?php 

	
	 if(!isset($_SESSION['SESS_MEMBER_ID']))
		
	?>
		//window.location.assign("<?php echo $base_url;?>login.php");
   	e.preventDefault();

if (!$(this).data('isClicked')) {
        var link = $(this);

        // Your code on successful click
        var ID = $(this).attr("id");
        var sid = ID.split("comment_like");
        var New_ID = sid[1];
        var msg_id = $(this).attr("msg_id");
        var comma = "";
        var youcount = $("#commacount" + New_ID).val();
        //alert(ID);
        if (youcount > 0) {
            comma = ", ";
        }
        var REL = $(this).attr("rel");
        var URL = '<?php echo $base_url;?>load_data/comment_like_ajax.php';
        var dataString = 'comment_id=' + New_ID + '&rel=' + REL + '&msg_id=' + msg_id;
        $.ajax({
            type: "POST",
            url: URL,
            data: dataString,
            cache: false,
            dataType: "json",
            success: function (data) {
           
                var likecount = data.likecount;
                var dislikecount = data.dislikecount;
                if(likecount=='expired')
                {
                window.location.assign("<?php echo $base_url;?>login.php");
                }
                else
                {
                
                if (REL == 'Like') {
                    $("#clike" + New_ID).show('slow').prepend("<span id='you" + New_ID + "'><?php echo $lang['You'];?>" + comma + "</span>");
                    $('#' + ID).html('<?php echo $lang['Unlike'];?>').attr('rel', 'Unlike').attr('title', '<?php echo $lang['Unlike'];?>');
                } else {
                    if (youcount == 0) $("#clike" + New_ID).hide('slow');
                    $("#you" + New_ID).remove();
                    $('#' + ID).attr('rel', 'Like').attr('title', '<?php echo $lang['Like'];?>').html('<?php echo $lang['Like'];?>');
                }
                if (dislikecount > 0) {
                    $('#dislikecout' + New_ID).html(dislikecount);
                } else {
                    $('#dislikecout_container' + New_ID).fadeOut('slow');
                }
                if (likecount > 0) {
                    $('#commentlikecount' + New_ID).html(likecount);
                } else {
                    $('#commentlikecout_container' + New_ID).fadeOut('slow');
                }
            }}
        });
        
         // Set the isClicked value and set a timer to reset in 3s
        link.data('isClicked', true);
        setTimeout(function() {
            link.removeData('isClicked')
        }, 3000);
    } else {
        // Anything you want to say 'Bad user!'
    }
    return false;
    });
	//reply dislike function
	$('.reply_dislike').live("click", function (e) {
	<?php 

	
	 if(!isset($_SESSION['SESS_MEMBER_ID']))
		
	?>
		//window.location.assign("<?php echo $base_url;?>login.php");
        e.preventDefault();

if (!$(this).data('isClicked')) {
        var link = $(this);

        // Your code on successful click
        
        var ID = $(this).attr("id");
        var sid = ID.split("reply_dislike");
        var New_ID = sid[1];
        var REL = $(this).attr("rel");
        var URL = '<?php echo $base_url;?>load_data/reply_dislike_ajax.php';
        var dataString = 'reply_id=' + New_ID + '&rel=' + REL;
        $.ajax({
            type: "POST",
            url: URL,
            data: dataString,
            cache: false,
            dataType: 'json',
            success: function (data) {
                var likecount = data.likecount;
                var dislikecount = data.dislikecount;
                
                 if(likecount=='expired')
                {
                window.location.assign("<?php echo $base_url;?>login.php");
                }
                else
                {
                $("#you" + New_ID).remove();
                $('#reply_like' + New_ID).html('<?php echo $lang['Like'];?>').attr('rel', 'Like').attr('title', '<?php echo $lang['Like'];?>');
                $("#rdislikecout_container" + New_ID).fadeIn('slow');
                $('#rdislikecout' + New_ID).html(dislikecount);
                //$('#commentlikecount' + New_ID).html(likecount);
                if (dislikecount > 0) {
                    $('#rdislikecout' + New_ID).html(dislikecount);
                } else {
                    $('#rdislikecout_container' + New_ID).fadeOut('slow');
                }
                /*if (likecount > 0) {
                    $('#commentlikecount' + New_ID).html(likecount);
                } else {
                    $('#commentlikecout_container' + New_ID).fadeOut('slow');
                }*/
            }}
        });
        
        // Set the isClicked value and set a timer to reset in 3s
        link.data('isClicked', true);
        setTimeout(function() {
            link.removeData('isClicked')
        }, 3000);
    } else {
        // Anything you want to say 'Bad user!'
    }
    return false;
    });
	
	//reply like function
    $('.reply_like').live("click", function (e) {
  
		//window.location.assign("<?php echo $base_url;?>login.php");
        e.preventDefault();
   
if (!$(this).data('isClicked')) {
        var link = $(this);

        // Your code on successful click
        <?php 

	
	 if(!isset($_SESSION['SESS_MEMBER_ID']))
		
	?>
        var ID = $(this).attr("id");
        var sid = ID.split("reply_like");
        var New_ID = sid[1];        
        
        var REL = $(this).attr("rel");
        var URL = '<?php echo $base_url;?>load_data/reply_like_ajax.php';
        var dataString = 'reply_id=' + New_ID + '&rel=' + REL ;
		var comma = "";
        var youcount = $("#rcommacount" + New_ID).val();
        if (youcount > 0) {
            comma = ", ";
        }
       
        $.ajax({
            type: "POST",
            url: URL,
            data: dataString,
            cache: false,
            dataType: "json",
            success: function (data) {
                var likecount = data.likecount;
                var dislikecount = data.dislikecount;
		 if(likecount=='expired')
                {
                window.location.assign("<?php echo $base_url;?>login.php");
                }
                else
                {		                
          	 if (REL == 'Like') {
          	alert('like');
                    $("#rlike" + New_ID).show('slow').prepend("<span id='you" + New_ID + "'><?php echo $lang['You'];?>" + comma + "</span>");                
                    $('#' + ID).html('<?php echo $lang['Unlike'];?>').attr('rel', 'Unlike').attr('title', '<?php echo $lang['Unlike'];?>');
                
                } else {
                    if (youcount == 0) $("#rlike" + New_ID).hide('slow');
                    $("#you" + New_ID).remove();
                    $('#' + ID).attr('rel', 'Like').attr('title', '<?php echo $lang['Like'];?>').html('<?php echo $lang['Like'];?>');
                }
                if (dislikecount > 0) {
                    $('#rdislikecout' + New_ID).html(dislikecount);
                } else {
                    $('#rdislikecout_container' + New_ID).fadeOut('slow');
                }
                if (likecount > 0) {
                    $('#commentlikecount' + New_ID).html(likecount);
                } else {
                    $('#commentlikecout_container' + New_ID).fadeOut('slow');
                }
            }}
        });
        
        // Set the isClicked value and set a timer to reset in 3s
        link.data('isClicked', true);
        setTimeout(function() {
            link.removeData('isClicked')
        }, 3000);
    } else {
        // Anything you want to say 'Bad user!'
    }
    return false;
    });
    $('.ads_like').live("click", function (e) {
   <?php 

	
	 if(!isset($_SESSION['SESS_MEMBER_ID']))
		
	?>
		//window.location.assign("<?php echo $base_url;?>login.php");
        e.preventDefault();

if (!$(this).data('isClicked')) {
        var link = $(this);

        // Your code on successful click
        var ID = $(this).attr("id");
        var sid = ID.split("like_ads");
        var New_ID = sid[1];
        var REL = $(this).attr("rel");
        var URL = '<?php echo $base_url;?>load_data/ads_like_ajax.php';
        var dataString = 'msg_id=' + New_ID + '&rel=' + REL;
        $.ajax({
            type: "POST",
            url: URL,
            data: dataString,
            cache: false,
            success: function (html) {
             if(html=='expired')
                {
                window.location.assign("<?php echo $base_url;?>login.php");
                }
                else
                {
            
            
                if (REL == 'Like') {
                    $("#youlike" + New_ID).slideDown('slow').prepend("<span id='you" + New_ID + "'><?php echo $lang['You'];?><?php echo $lang['like this'];?>.</span>.");
                    $("#ads_likes" + New_ID).prepend("<span id='you" + New_ID + "'><?php echo $lang['You'];?>, </span>");
                    $('#' + ID).html('<?php echo $lang['Unlike'];?>').attr('rel', 'Unlike').attr('title', '<?php echo $lang['Unlike'];?>');
                } else {
                    $("#youlike" + New_ID).slideUp('slow');
                    $("#you" + New_ID).remove();
                    $('#' + ID).attr('rel', 'Like').attr('title', '<?php echo $lang['Like'];?>').html('<?php echo $lang['Like'];?>');
                }
                if(html > 0){
					$("#likes" + New_ID).show();                
                }else {
					$("#likes" + New_ID).hide();
                }
				$("#ads_like_count" + New_ID).html(html);
            }}
        });
        // Set the isClicked value and set a timer to reset in 3s
        link.data('isClicked', true);
        setTimeout(function() {
            link.removeData('isClicked')
        }, 3000);
    } else {
        // Anything you want to say 'Bad user!'
    }
    return false;
    });
</script>
<style>
.vjs-control.vjs-tweet-button:before {
        content:url(<?php echo $base_url;?>images/watermark.png);
}
</style>
</body>
</html>
<?php 
/*}
else
{
	include('post.php');
}*/
?>