<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/time_stamp.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/tolink.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_header.php');

if(!isset($_SESSION['SESS_MEMBER_ID'])) {
    header("location: ".$base_url."login.php?back=". urlencode($_SERVER['REQUEST_URI']));
    exit();
}
	
$member_id = $_SESSION['SESS_MEMBER_ID'];
?>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url; ?>css/wall.css"/>
<script type="text/javascript">
    var base_url  = "<?php echo $base_url; ?>"; 
</script>
<script src="<?php echo $base_url;?>js/jquery.min.js"></script>
<script src="http://microsofttranslator.com/ajax/v3/widgetv3.ashx" type="text/javascript"></script>
<script src="<?php echo $base_url;?>js/jquery.form.js"></script>
<script src="<?php echo $base_url;?>js/jquery.livequery.js" type="text/javascript"></script>
<script src="<?php echo $base_url;?>js/jquery.oembed.js"></script>
<script src="<?php echo $base_url;?>js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>js/ibox.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>js/jquery.share.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>js/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>assets/jquery-alert-dialogs/js/jquery.alerts.js"></script>
<script src="<?php echo $base_url;?>js/check.js"></script>
<script src="<?php echo $base_url;?>js/event.js"></script>
<script src="<?php echo $base_url;?>js/common-scripts.js"></script>
<link rel="stylesheet" href="<?php echo $base_url;?>video-ads/css/videoPlayerMain.css" type="text/css">
<link rel="stylesheet" href="<?php echo $base_url;?>video-ads/css/videoPlayer.theme1.css" type="text/css">
<link rel="stylesheet" href="<?php echo $base_url;?>video-ads/css/preview.css" type="text/css" media="screen"/>
<script src="<?php echo $base_url;?>video-ads/js/IScroll4Custom.js" type="text/javascript"></script>
<script src='<?php echo $base_url;?>video-ads/js/THREEx.FullScreen.js'></script>
<script src="<?php echo $base_url;?>video-ads/js/videoPlayer.js" type="text/javascript"></script>
<script src="<?php echo $base_url;?>video-ads/js/Playlist.js" type="text/javascript"></script> <!--video player files -->

<script type="text/javascript">
$(function() {
 $("#member_name").autocomplete({
	 source: "<?php echo $base_url; ?>load_data/member_names_ajax.php",			
			select: true
 });
 $('.remove_event').click (function () {
		return confirm ("<?php echo $lang['Are you sure you want to delete'];?>?") ;
	}) ;
});

//add as a friend
$("#cancel_request").click()
{
	$("#myform1").hide();
}
$(function() {
		$( "#datepicker" ).datepicker({
			showOtherMonths: true,
			selectOtherMonths: true
		});
	});
	function create_event_close(){
	location.reload();
}
</script>
 <style>
.PopupPanel
{
    border: solid 1px black;
    position: absolute;
    left: 50%;
    top: 50%;
    background-color: white;
    z-index: 100;
	overflow-y:scroll;

    height: 400px;
    margin-top: -200px;

    width: 600px;
    margin-left: -300px;
}

</style>
<?php
$id = $_REQUEST['id'];
$equery = "SELECT e.event_name, e.event_location, e.date_created, e.event_host,
			m.username, m.LastName, e.id, e.datepicker, e.cover, e.event_description,m.member_id			
			FROM event e LEFT JOIN members m ON e.event_host = m.member_id
			LEFT JOIN event_members em ON e.id = em.event_id 
			WHERE e.id = '$id'";
$esql = mysqli_query($con, $equery) or die(mysqli_error($con));
$eres = mysqli_fetch_array($esql);
?>
<div class="insideWrapper container">
    <div class="col-lg-9 col-md-9 col-sm-9">
<?php 
if($eres['cover'] == NULL)
{
?>
<div style="height:60px; background-color:#FFFFFF; margin-bottom:10px; border-bottom:dashed 1px #CCCCCC;">
<div style="top:20px; bottom:14px; position:absolute;">
<a href="#event_cover" rel="ibox" title="Change picture"><?php echo $lang['Add event photo'];?></a>
</div>

<form name="event_cover" id="event_cover" action="<?php echo $base_url; ?>action/event_cover-exec.php" enctype="multipart/form-data" method="post" style="padding: 11px;display:none">
<input type="hidden" name="event_id" id="event_id" value="<?php echo $id;?>" />
<div style="margin: 3px 0px -26px 84px; height: 19px; width: 194px;">
<?php echo $lang['No file selected']; ?>
              </div>
<input type="file" name="cover" style="width: 80px;"/>
<input type="submit" name="submit" value="<?php echo $lang['Change'];?>" style="margin-left: 132px;"/>
</form>
</div>
<?php } 
else
{
?>
<div style="height:250px; background-color:#FFFFFF; margin-bottom:10px; border-bottom:dashed 1px #CCCCCC;">
<img src="<?php echo $base_url.$eres['cover'];?>" style="width:100%; height:100%;" />
<?php	  
	 if($eres['event_host'] == $member_id)
	 {
	 ?> 
<div style="top:200px; bottom:14px; padding:2px; background:#000000; float:right;">
  
<a href="#change_cover" rel="ibox" style="color:#FFFFFF;" title="<?php echo $lang['Change Picture'];?>"><?php echo $lang['Change event photo'];?></a>
</div>
<?php } ?>
<form name="event_cover" id="change_cover" action="<?php echo $base_url; ?>action/event_cover-exec.php" enctype="multipart/form-data" method="post" style="display:none">
<input type="hidden" name="event_id" id="event_id" value="<?php echo $id;?>" />
<div style="margin: 3px 0px -26px 84px; height: 19px; width: 194px;">
<?php echo $lang['No file selected']; ?>
</div>
<input type="file" name="cover" style="width: 80px;" required="required" />
<input type="submit" name="submit" value="<?php echo $lang['Change'];?>" style="margin-left: 132px;"/>
</form>
</div>


<?php } ?>
	
    <div class="componentheading">
    <div id="submenushead" style="padding-top:0px;"><?php echo $eres['event_name'];?></div>    
    <div id="submenushead" style="padding-top:0px;"><?php echo $lang['Event for'];?> <?php echo $eres['event_name'];?> <?php echo $lang['By'];?> <a href="<?php echo $base_url.$eres['username'];?>"><?php echo $eres['username'];?></a></div>
    </div>
    <div id="submenushead">
   <ul class="submenu">
    <li><a href="create_event.php"><?php echo $lang['Events'];?></a></li>
     <?php	  
	 if($eres['event_host'] == $member_id)
	 {
	 ?>   
    <li><a href="<?php echo $base_url; ?>invite_event.php?id=<?php echo $id;?>"><?php echo $lang['Invite members'];?></a></li>
  	<?php /* <li><a href="#create_event_div" rel="ibox"><?php echo $lang['Edit'];?></a></li> */ ?>
    <li><a href="<?php echo $base_url; ?>action/delete_event.php?id=<?php echo $id;?>" class="remove_event"><?php echo $lang['Delete event'];?></a></li> 
    <?php } 
	$maquery = "SELECT member_id FROM event_members where event_id = '$id' AND member_id = '$member_id' AND status = 0";
	$masql = mysqli_query($con, $maquery);
	if(mysqli_num_rows($masql) != 0)
	{	
	?>
    <li><a href="<?php echo $base_url; ?>action/accept_event_request.php?id=<?php echo $id;?>"><?php echo $lang['Accept'];?></a></li>
  	<?php }
	$mjquery = "SELECT member_id FROM event_members where event_id = '$id' AND member_id = '$member_id'";
	$mjsql = mysqli_query($con, $mjquery);
	if(mysqli_num_rows($mjsql) == 0)
	{
		if($eres['event_host'] != $member_id)
	 {
	?>
    <li><a href="<?php echo $base_url; ?>action/accept_event_request.php?id=<?php echo $id;?>"><?php echo $lang['Join'];?></a></li> 
    <?php }
	}
	$mdquery = "SELECT member_id FROM event_members where event_id = '$id' AND member_id = '$member_id' AND status = 1";
	$mdsql = mysqli_query($con, $mdquery);
	if(mysqli_num_rows($mdsql) > 0)
	{
		if($eres['event_host'] != $member_id)
	 {
	?>
    <li><a href="<?php echo $base_url; ?>action/delete_event_request.php?id=<?php echo $id;?>"><?php echo $lang['Delete'];?></a></li> 
    <?php }
	}
	?>
	</ul>
   </div>
   
   <div class="wall_header" style="position:relative">
   <img src="<?php echo $base_url; ?>images/UmLbGfwEuH6.png" />
   <span style="color:#3B5998; font-size:15px;"><?php echo date('l, F d, Y',strtotime($eres['datepicker']));?></span>
   </div>
   <?php if($eres['event_description'] != NULL)
   {
   ?>
    <div class="wall_header" style="position:relative">
   <span style="font-size:13px;"><?php echo $eres['event_description'];?></span>
   </div>
   <?php } ?>
   <div class="wall_header" style="position:relative">
	<span class="memohead"><?php echo $lang['MEMO'];?></span>
    
    <div class="rightpanel">
   <div class="rightpanel">
    <span id="status_but" class="flatButton">
    <a href="javascript:void(0)" style="color: rgb(137, 0, 0); text-decoration:none;">
    <img src="<?php echo $base_url; ?>images/hand_stift.png" style="margin-right:4px;" />
    <span class="inner"><?php echo $lang['status'];?></span>
    </a>
    </span>
    <span id="photo_but" class="flatButton">
    <a href="javascript:void(0)" style="color: rgb(137, 0, 0); text-decoration:none;">
    <img src="<?php echo $base_url; ?>images/i_photo_small.gif" style="margin-right:4px;" />
    <span class="inner"><?php echo $lang['photo'];?></span>
    </a>
    </span>    
    
           
    <?php /*<span id="video_but" class="flatButton">
    <a href="javascript:void(0)" style="color: rgb(137, 0, 0); text-decoration:none;">
    <img src="<?php echo $base_url; ?>images/video_small.png" style="margin-right:4px;" />
    <span class="inner"><?php echo $lang['video'];?></span>
    </a>
    </span>*/ ?>

    </div>
    </div>
    
    <div style="padding: 4px;margin-top:40px;">
		<!--NEXT status button -->
        <script>
            jQuery(function($){
                $("#status_but").click(function () {
                    $("#myphoto").hide();
                    $("#mylink").hide();
                    $("#myvideo").hide();
                    $("#myrecent").hide();
                    $("#my_status").show();
                });
            });
        </script>
        <form name="comment" id="comment" method="post" action="<?php echo $base_url;?>action/event_post_ajax.php?id=<?php echo $event_id;?>">
		<div class="comment1" id="my_status" style="display: none;">
		<textarea name="mystatusx" id="update" placeholder="<?php echo $lang['WHAT ARE YOU THINKING']; ?>"></textarea>
        <input name="member_id" type="hidden" id="member_id" value="<?php echo $member_id;?>"/>
        <input name="event_id" type="hidden" id="event_id" value="<?php echo $id;?>"/>
        
         <div id="loader">
			
			<div align="center" id="load" style="display:none"><img src="<?php echo $base_url;?>images/loader1.gif" /></div>
			
		</div>          
		<input type="submit" value="<?php echo $lang['add']; ?>" name="update_button"  class="update_button" style="margin: 6px; background-color: #222; border: 1px solid #000; color: #fff; padding: 2px; cursor:pointer;"/>
        
		</div>
        </form>
		<!--NEXT photo button -->
        <script>
            jQuery(function($){
                $("#photo_but").click(function () {
                    $("#my_status").hide();
                    $("#mylink").hide();
                    $("#myvideo").hide();
                    $("#myrecent").hide();
                    $("#myphoto").show();
                    return false;
                });
            });
        </script>
        <form name="comment" id="comment" action="<?php echo $base_url;?>action/event_upload_image.php" method="post" enctype="multipart/form-data">
		<div class="comment1" id="myphoto" style="display: none;">
		 <div>
			<input type="text" name="photo_title" id="photo_title" style="padding:5px; width:460px;" placeholder="Title" autocomplete="off" />
        </div> 
        <div style="margin: 8px 0px -32px 84px; height: 19px; width: 194px;">
<?php echo $lang['No file selected']; ?>
              </div>
             
             
			<input type="file" name="image" value="" style="width: 80px;" required="required"/>
			
            <input name="member_id" type="hidden"  value="<?php echo $_SESSION['SESS_MEMBER_ID'];?>"/>
           <input name="event_id" type="hidden" id="event_id" value="<?php echo $id;?>"/>
			<input type="submit" value="<?php echo $lang['add']; ?>" name="Add" class="upload_image" style="background-color: rgb(34, 34, 34); border: 1px solid rgb(0, 0, 0); color: rgb(255, 255, 255); padding: 2px; margin: 6px 0px 0px 161px; cursor:pointer;"/>
            
		</div>
        </form>		
		<!--NEXT video button -->
        <script>
            $("#video_but").click(function () {
                $("#myphoto").hide(300);
                $("#mylink").hide(300);
                $("#my_status").hide(300);
                $("#myrecent").hide(300);
                $("#myvideo").toggle(300);
                $("#myvideo").show();
            });
        </script>
        <form name="comment" id="video_form" action="<?php echo $base_url;?>action/video_upload.php" method="post" enctype="multipart/form-data">
		<div class="comment1" id="myvideo" style="display: none;">
            
              <input type="text" name="title" id="title" placeholder="<?php echo $lang['title'];?>" style="height: 20px; margin-bottom: 10px; width:100%; padding:2px;"/>
              <div id="uploadPage">
              <div style="height: 16px; margin: 5px 0px -22px 83px; min-width: 118px;">
<?php echo $lang['No file selected']; ?>
              </div>
			<input type="file" name="uploadedfile" id="video" required style="width: 80px;height:25px; margin:0;" accept="video/*"/>
              </div>
              <input name="member_id" type="hidden"  value="<?php echo $member_id;?>"/>
              <input type="hidden" name="country" id="country" value="<?php echo 'world';?>" />
              <input type="hidden" name="privacy" id="video_privacy" value="1"/>
              <input type="hidden" name="photo_custom_share" id="video_custom_share" />
              <input type="hidden" name="photo_custom_unshare" id="video_custom_unshare" />
              
              <div id="ProcessPage" style="display:none">
              <div class="progress">
   	<span style="position:absolute;"><?php echo $lang['Uploading'];?>..</span>  
     <div class="bar"></div >  
     <div class="percent">0%</div >  
   </div>
   <div id="progress1" >  
     <span style="position:absolute;"><?php echo $lang['Processing'];?>..</span>
     <div id="bar1" ></div >  
     <div id="percent1">1%</div >  
   </div>    
   
   <div id="status"></div> 
              </div>
              <input type="button" value="<?php echo $lang['add']; ?>" name="Add" class="update_video" id="update_video"  style="margin: 6px; background-color: #222; border: 1px solid #000; color: #fff; padding: 2px; cursor:pointer;border-radius: 4px; "/>                         
              
            </div>
        </form>

	</div>
    
	</div>
   
   <div class="column_internal_left">
   
    
    
    
   
<div id='flashmessage'>
<div id="flash" align="left"  ></div>
</div>
<div class="post">
<?php   
$query  = "SELECT msg.messages_id, msg.messages, msg.date_created, msg.type, m.member_id,
		  msg.photo_id, m.username, m.profImage, u.upload_data_id,
		  v.location,v.location1,v.location2, v.thumburl, v.title, v.video_id, v.description,
 		  v.msg_id, v.category, v.title_color,v.title_size,v.ads 
		  FROM event_wall msg LEFT JOIN members m ON msg.member_id = m.member_id 
		  LEFT JOIN upload_data u on msg.messages_id = u.msg_id
		  LEFT JOIN event_videos v ON v.msg_id = msg.messages_id
		  WHERE msg.event_id = '$id'
		  ORDER BY messages_id DESC";

$result = mysqli_query($con, $query) or die(mysqli_error($con));

while($row = mysqli_fetch_assoc($result))
{
    $time = $row['date_created'];
    $orimessage = $row['messages'];
    $msg_id = $row['messages_id'];
    $title = $row['title'];
    $description = $row['description'];
    $mp4videopath = $row['location'];
    $oggvideopath = $row['location1'];
    $webmvideopath = $row['location2'];
    $thumb = $row['thumburl'];
    $ads = $row['ads'];
    $adsmp4videopath = "";
    $adsoggvideopath = "";
    $adswebmvideopath = "";
    $click_url = "";
?>
	
<script type="text/javascript"> 
$(document).ready(function(){$("#stexpand<?php echo $msg_id;?>").oembed("<?php echo  $orimessage; ?>",{maxWidth: 400, maxHeight: 300});});
</script>	
<div class="stbody" id="stbody<?php echo $row['messages_id'];?>" data-id="<?php echo $row['messages_id'];?>" wall-type="1">

<div class="stimg">
    <?php
    if(!empty($row['profImage'])) {
    if ($_SESSION['SESS_MEMBER_ID'] == $row['member_id']) {
    ?>
        <a href="<?php echo $base_url . "i/" . $row['username']; ?>"><img
                src="<?php echo $base_url . $row['profImage']; ?>" class='big_face'
                original-title="<?php echo $row['username']; ?>"/></a>
    <?php } else {
        ?>
        <a href="<?php echo $base_url . $row['username']; ?>"><img src="<?php echo $base_url . $row['profImage']; ?>"
                                                                   class='big_face'
                                                                   original-title="<?php echo $row['username']; ?>"/></a>
    <?php }} ?>

</div><!--End stimg div	-->

<div class="sttext">
<?php 
if($_SESSION['SESS_MEMBER_ID'] == $row['member_id'])
{
?>
<a class="stdelete" href="#" id="<?php echo $row['messages_id'];?>" original-title="Delete update" title="<?php echo $lang['Delete update'];?>"></a>
<?php }

if($_SESSION['SESS_MEMBER_ID'] == $row['member_id']){
?>
<a href="<?php echo $base_url."i/".$row['username'];?>"><b><?php echo $row['username'];?></b></a> 

<?php } else {?>
<a href="<?php echo $base_url.$row['username'];?>"><b><?php echo $row['username'];?></b></a> 
<?php } ?>

<div style="margin:5px 0px;">

<?php if($row['type']==0)
 
 {
	if(isset($_SESSION['lang'])&&($_SESSION['lang']<>"en"))
	{	
		
		$sql = mysqli_query($con, "select * from message1 where msg_id='".$row['messages_id']."' and tr_id='".$_SESSION['lang']."'")or die(mysqli_error($con));
$r_count = mysqli_num_rows($sql);
//echo $r_count;
if($r_count>0)
{

$row_post = mysqli_fetch_assoc($sql);


	echo $row_post['message'];

}
	
	else
	{
		//$i++;
		
		
	include "test9.php";	
		//sleep(3);
	}
	$sql1 =  mysqli_query($con, "select * from message1 where msg_id='".$row['messages_id']."' and tr_id='".$_SESSION['lang']."'")or die(mysqli_error($con));
	$r_count1 = mysqli_num_rows($sql1);
	if($r_count1==0)
{

	echo tolink(htmlentities($row['messages']));

}		
	}
	
	else
	{
		echo tolink(htmlentities($row['messages']));
		
	}
?> 
<div tabindex="1" id="posttranslatemenu<?php echo $row['messages_id'];?>" class="posttranslatemenu" style="display:none; position:absolute;margin-left: 34%; "> <select id="postlangs<?php echo $row['messages_id'];?>" class="postlangs" onchange="selectOption(this.value, <?php echo $row['messages_id'];?>,2)">
            <option value=""><?php echo $lang['select language'];?></option> 
            </select>
            </div> 
            
<textarea class="postsource" id="postsource<?php echo $row['messages_id']; ?>"  style="display:none;"><?php echo $row['messages']; ?></textarea>
<div class="posttarget" style="font:bold;" id="posttarget<?php echo $row['messages_id']; ?>"></div>
<?php
} 
if($row['type']==1){?>
<a href="<?php echo $base_url;?>albums.php?back_page=<?php echo $base_url.'events/'.$id;?>&member_id=<?php echo $row['member_id']; ?>&album_id=<?php echo $row['msg_album_id']; ?>&image_id=<?php echo $row['upload_data_id'];?>" >
<?php 
	list($width, $height) = getimagesize($row['messages']);
	if($width > 600)
	{
	?>
    <img src="<?php echo $base_url.$row['messages'];?>" class="stimage"/>
    <?php } 
	else if($width <= 600)
	{
	?>
	<img src="<?php echo $base_url.$row['messages'];?>" class="stimage"/>
	<?php } 
	else
	{
	?>
    <img src="<?php echo $base_url.$row['messages'];?>" class="stimage"/>
    <?php } ?>
</a>

<?php } if($row['type']==2){?>
<a href="<?php echo $base_url;?>watch.php?video_id=<?php echo $row['video_id'];?>" style="color:#993300;">
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

  <br/>
  <span class="sttime"  > <h3><?php echo $row['description']; ?></h3></span>
  
 
<?php }?>
</div>

<div><span class="sttime" title="<?php echo date($time);?>"><?php echo time_stamp($time);?></span>
<br />
<!-- LIke users display panel -->
<?php 

$post_like_sql = mysqli_query($con, "SELECT * FROM event_wall_like WHERE remarks='". $row['messages_id'] ."'");
$post_like_count = mysqli_num_rows($post_like_sql);

$post_like_sql1 = mysqli_query($con, "SELECT m.username,m.member_id FROM event_wall_like b, members m WHERE m.member_id=b.member_id AND b.remarks='".$row['messages_id']."' AND b.member_id='".$_SESSION['SESS_MEMBER_ID']."'");
$post_like_count1 = mysqli_num_rows($post_like_sql1);

if($post_like_count1==1)
{
$post_like_sql2 = mysqli_query($con, "SELECT m.username,m.member_id FROM event_wall_like b, members m WHERE m.member_id=b.member_id AND b.remarks='".$row['messages_id']."' AND b.member_id!='".$_SESSION['SESS_MEMBER_ID']."' LIMIT 2");
$plike_count = mysqli_num_rows($post_like_sql2);
$new_plike_count=$post_like_count-2; 
}
else
{
$post_like_sql2 = mysqli_query($con, "SELECT m.username,m.member_id FROM event_wall_like b, members m WHERE m.member_id=b.member_id AND b.remarks='".$row['messages_id']."' LIMIT 3");
$plike_count = mysqli_num_rows($post_like_sql2);
$new_plike_count=$post_like_count-3; 
}
?>
<div class="commentPanel" id="likes<?php echo $row['messages_id'];?>" style="display:<?php if($post_like_count <= 0) { echo 'none'; } else { echo 'block'; }?>">
<?php 

if($post_like_count1==1)
{?><span id="you<?php echo $row['messages_id'];?>"><a href="#"><?php echo $lang['You'];?></a><?php if($post_like_count>1)
echo ','; ?> </span><?php
}
?>

<input type="hidden"  value="<?php echo $post_like_count; ?>" id="commacount<?php echo $row['messages_id'];?>" >
<?php

$i = 0;
while($post_like_res = mysqli_fetch_array($post_like_sql2)) {
$i++; 	  
?>

<a href="#" id="likeuser<?php echo $row['messages_id'];?>"><?php echo $post_like_res['username']; ?></a>
<?php if($i <> $plike_count) { echo ',';}

} 
if($plike_count > 3) {
?>
 <?php echo $lang['and'];?> <span id="plike_count<?php echo $row['messages_id'];?>" class="pnumcount"><?php echo $new_plike_count;?></span> <?php echo $lang['others'];?><?php } ?> <?php echo $lang['like this'];?>.</div> 

<!-- LIke users display panel -->


<!--Dislike users display panel-->
<?php 

$sql1 = mysqli_query($con, "SELECT * FROM event_wall_dislike WHERE msg_id='". $row['messages_id'] ."'") or die(mysqli_error($con));
$dislike_count = mysqli_num_rows($sql1);
 
$query1=mysqli_query($con, "SELECT m.username,m.member_id FROM event_wall_dislike b, members m WHERE m.member_id=b.member_id AND b.msg_id='".$row['messages_id']."' LIMIT 3");
$dislike = mysqli_num_rows($query1);
?>

<span class="commentPanel" id="postdislike_container<?php echo $row['messages_id'];?>" style="display:<?php if($dislike_count <= 0) { echo 'none'; } else { echo 'block'; }?>">
<span id="postdislikecount<?php echo $row['messages_id'];?>">
<?php
echo $dislike_count;
?>
</span>
<?php echo $lang['Person Dislike this'];?>
</span>

</div> <!-- End of timestamp div -->
<?php
$query1  = mysqli_query($con, "SELECT * FROM event_wall_comment WHERE msg_id=" . $row['messages_id'] . " ORDER BY comment_id DESC");
$records = mysqli_num_rows($query1);
$s = mysqli_query($con, "SELECT * FROM event_wall_comment WHERE msg_id=" . $row['messages_id'] . " ORDER BY comment_id DESC limit 4,$records");
$y = mysqli_num_rows($s);
if ($records > 4)
{
	$collapsed = true;?>
    <input type="hidden" value="<?php echo $records?>" id="totals-<?php  echo $row['messages_id'];?>" />
	<div class="commentPanel" id="collapsed-<?php  echo $row['messages_id'];?>" align="left">
	<img src="images/cicon.png" style="float:left;" alt="" />
	<a href="javascript: void(0)" class="ViewComments" id="<?php echo $row['messages_id'];?>">
	<?php echo $lang['View'];?> <?php echo $y;?> <?php echo $lang['more comments'];?> 
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
$comment  = mysqli_query($con, "SELECT * FROM event_wall_comment p,members m  WHERE p.member_id=m.member_id and p.msg_id=" . $row['messages_id'] . " ORDER BY comment_id DESC limit 0,4");
while($row1 = mysqli_fetch_assoc($comment))
{
?>
<div class="stcommentbody" id="stcommentbody<?php echo $row1['comment_id']; ?>">
<div class="stcommentimg">

</div> 
<div class="stcommenttext">
<?php 
if($_SESSION['SESS_MEMBER_ID'] == $row1['member_id'])
{
?>
<a class="stcommentdelete" href="#" id='<?php echo $row1['comment_id']; ?>' title='<?php echo $lang['Delete Comment'];?> '></a>
<?php } ?>
<a href="<?php echo $base_url.$row1['username'];?>"><b><?php echo $row1['username']; ?></b> </a>
<br />
<?php 
if($row1['type']==1){ 


if(isset($_SESSION['lang'])&&($_SESSION['lang']<>"en"))
	{	
		
		$sql = mysqli_query($con, "select * from postcomment1 where msg_id='".$row1['comment_id']."' and tr_id='".$_SESSION['lang']."'")or die(mysqli_error($con));
$r_count = mysqli_num_rows($sql);
//echo $r_count;
if($r_count>0)
{
$row_comment = mysqli_fetch_assoc($sql);

	echo $row_comment['message'];

}
	
	else
	{
			include "test8.php";
		
	}
	$sql1 =  mysqli_query($con, "select * from postcomment1 where msg_id='".$row1['comment_id']."' and tr_id='".$_SESSION['lang']."'")or die(mysqli_error($con));
$r_count1 = mysqli_num_rows($sql1);
	if($r_count1==0)
{



	echo $row1['content'];

}		
	}
	
	else
	{
		echo $row1['content']; ;
		
	}
	?>
	
	<div id="translatemenu<?php echo $row1['comment_id'];?>" class="translatemenu" style="display:none; position:absolute;margin-left: 34%; "> <select id="langs<?php echo $row1['comment_id'];?>" class="langs" onchange="selectOption(this.value, <?php echo $row1['comment_id'];?>,1)">
            <option value=""><?php echo $lang['select language'];?></option> 
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
$sql = mysqli_query($con, "SELECT * FROM event_wall_comment_like WHERE comment_id='". $row1['comment_id'] ."'");
$comment_like_count = mysqli_num_rows($sql);

$comment_like_query1 = mysqli_query($con, "SELECT m.username,m.member_id FROM event_wall_comment_like c, members m WHERE m.member_id=c.member_id 
AND c.comment_id='".$row1['comment_id']."' AND c.member_id='".$_SESSION['SESS_MEMBER_ID']."' ");
$comment_like_res1 = mysqli_num_rows($comment_like_query1);
if($comment_like_res1==1)
{
$comment_like_query = mysqli_query($con, "SELECT m.username,m.member_id FROM event_wall_comment_like c, members m WHERE m.member_id=c.member_id 
AND c.comment_id='".$row1['comment_id']."' AND c.member_id!='".$_SESSION['SESS_MEMBER_ID']."' LIMIT 2");
$clike_count = mysqli_num_rows($comment_like_query);
$new_clike_count=$comment_like_count-2; 
}
else
{
$comment_like_query = mysqli_query($con, "SELECT m.username,m.member_id FROM event_wall_comment_like c, members m WHERE m.member_id=c.member_id 
AND c.comment_id='".$row1['comment_id']."' LIMIT 3");
$clike_count = mysqli_num_rows($comment_like_query);
$new_clike_count=$comment_like_count-3; 
}

?>
<div class="clike" id="clike<?php echo $row1['comment_id'];?>" style="display:<?php if($comment_like_count <= 0) { echo 'none'; } else { echo 'block'; }?>">
<?php 

if($comment_like_res1==1)
{?><span id="you<?php echo $row1['comment_id'];?>"><a href="#"><?php echo $lang['You'];?> </a><?php if($comment_like_count>1)
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
 <?php echo $lang['and'];?>  <span id="like_count<?php echo $row1['comment_id'];?>" class="numcount"><?php echo $new_clike_count;?></span> <?php echo $lang['others'];?><?php } ?> <?php echo $lang['like this'];?>.</div> 
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
$cdquery = "SELECT * FROM event_wall_comment_dislike WHERE comment_id='". $row1['comment_id'] ."'";
$cdsql  = mysqli_query($con, $cdquery) or die(mysqli_error($con));
$comment_dislike_count = mysqli_num_rows($cdsql);

$cdquery1 = mysqli_query($con, "SELECT m.username,m.member_id FROM event_wall_comment_dislike c, members m WHERE m.member_id=c.member_id 
AND c.comment_id='".$row1['comment_id']."' LIMIT 3");
?>
<span id="dislikecout_container<?php echo $row1['comment_id'];?>" style="display:<?php if($comment_dislike_count <= 0) { echo 'none'; } else { echo 'block'; }?>">
<span id="dislikecout<?php echo $row1['comment_id'];?>">
<?php
echo $comment_dislike_count;
?>
</span>
<?php echo $lang['Person Dislike this'];?>
</span>
</div>
<!--end dislike block-->
</span>
<span style="top:2px;">
<?php
$comment_like = mysqli_query($con, "select * from  event_wall_comment_like where comment_id = '".$row1['comment_id']."' and member_id = '".$member_id."'");
if(mysqli_num_rows($comment_like) > 0)
{
	echo '<a href="javascript: void(0)" class="comment_like show_cmt_linkClr" id="comment_like'.$row1['comment_id'].'" msg_id = '.$row['messages_id'].' title="'.$lang['Unlike'].'" rel="Unlike">'.$lang['Unlike'].'</a>';
} 
else 
{ 
	echo '<a href="javascript: void(0)" class="comment_like show_cmt_linkClr" id="comment_like'.$row1['comment_id'].'" msg_id = '.$row['messages_id'].' title="'.$lang['Like'].'" rel="Like">'.$lang['Like'].'</a>';
}
?>

</span>
<!-- End of like button -->
<!-- Dislike button -->
<span style="top:2px; padding-left:2px;">
<span class="mySpan_dot_class"> · </span>
<?php
$cdquery1 = "SELECT * FROM event_wall_comment_dislike WHERE comment_id='". $row1['comment_id'] ."' and member_id = '".$member_id."'";
$cdsql1  = mysqli_query($con, $cdquery1) or die(mysqli_error($con));
$comment_dislike_count1 = mysqli_num_rows($cdsql1);
if($comment_dislike_count1 > 0) {
echo '<a href="javascript: void(0)" class="comment_dislike show_cmt_linkClr" id="comment_dislike'.$row1['comment_id'].'" title="'.$lang['dislike'].'" rel="disLike">'.$lang['dislike'].'</a>';
} else {
echo '<a href="javascript: void(0)" class="comment_dislike show_cmt_linkClr" id="comment_dislike'.$row1['comment_id'].'" title="'.$lang['Undislike'].'" rel="disLike">'.$lang['Undislike'].'</a>';
}
?>

</span> 
<!-- End of dislike  button -->
<!-- Reply Button -->
<span style="top:2px; margin-left:2px;">
<span class="mySpan_dot_class"> · </span>
<a href="" id="<?php echo $row1['comment_id'];?>" class="replyopen show_cmt_linkClr"><?php echo $lang['Reply'];?></a>

</span>
<!-- <?php if($row1['type']==1){?><span style="top:2px; left:3px;"><a class="translatebutton" onclick="translateSourceTarget(<?php echo $row1['comment_id'];?>);" href="javascript:void(0)" >Translate </a> </span><?php } ?> -->

<?php if($row1['type']==1)
{ ?>



<span style="top:2px; margin-left:2px;" >
<span class="mySpan_dot_class"> · </span>
 <a class="translateButton show_cmt_linkClr" href="javascript:void(0);" id="translateButton<?php echo $row1['comment_id'];?>"  ><?php echo  $lang['Translate'];?></a>

</span>

       
<?php 
} ?>


<!--View more reply-->
<?php
$query12  = mysqli_query($con, "SELECT * FROM event_wall_comment_reply WHERE comment_id=" . $row1['comment_id'] . " ORDER BY reply_id DESC");
$records1 = mysqli_num_rows($query12);
$p = mysqli_query($con, "SELECT * FROM event_wall_comment_reply WHERE comment_id=" . $row1['comment_id'] . " ORDER BY reply_id DESC limit 2,$records1");
$q = mysqli_num_rows($p);
if ($records1 > 2)
{
	$collapsed1 = true;?>
    <input type="hidden" value="<?php echo $records1?>" id="replytotals-<?php  echo $row1['comment_id'];?>" />
	<div class="replyPanel" id="replycollapsed-<?php  echo $row1['comment_id'];?>" align="left">
	<img src="images/cicon.png" style="float:left;" alt="" />
	<a href="javascript: void(0)" class="ViewReply">
	<?php  echo $lang['View'];?> <?php echo $q;?> <?php  echo $lang['more replys'];?>
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
$reply_sql  = mysqli_query($con, "SELECT * FROM event_wall_comment_reply c,members m WHERE c.member_id = m.member_id and comment_id=" . $row1['comment_id'] . " ORDER BY reply_id DESC limit 0,2");

while($reply_res = mysqli_fetch_assoc($reply_sql))
{
?>
<div class="streplybody" id="streplybody<?php echo $reply_res['reply_id']; ?>">
<div class="stcommentimg">
<a href="<?php echo $base_url.$row['username'];?>"><img src="<?php echo $base_url.$reply_res['profImage']; ?>" class='small_face'/></a>
</div>
<div class="streplytext">
 <?php 
if($_SESSION['SESS_MEMBER_ID'] == $reply_res['member_id'])
{
?>
<a class="streplydelete" href="#" id='<?php echo $reply_res['reply_id']; ?>' title='<?php echo $lang['Delete Reply'];?>'></a>
<?php } ?>
<a href="<?php echo $base_url.$reply_res['username'];?>"><b><?php echo $reply_res['username']; ?> 
 
 </b></a>
<?php 
 
 if($row1['member_id'] <> $reply_res['member_id'])
 {
	 echo '@'; 
	?> <a href="<?php echo $base_url.$row1['username'];?>"><b><?php echo $row1['username']; ?> 
 
 </b></a>
 <br />	 
<?php
 }
   ?> 
 
<br />	 
<?php 
if(isset($_SESSION['lang'])&&($_SESSION['lang']<>"en"))
	{	
		
		$sql = mysqli_query($con, "select * from comment_reply1 where msg_id='".$reply_res['reply_id']."' and tr_id='".$_SESSION['lang']."'")or die(mysqli_error($con));
$r_count = mysqli_num_rows($sql);
if($r_count>0)
{
$row_comment = mysqli_fetch_assoc($sql);


	echo $row_comment['message'];

}
	
	else
	{
		
	include "test7.php";
		
	}
	$sql1 = mysqli_query($con, "select * from comment_reply1 where msg_id='".$reply_res['reply_id']."' and tr_id='".$_SESSION['lang']."'")or die(mysqli_error($con));
$r_count1 = mysqli_num_rows($sql1);
	if($r_count1==0)
{



	echo $reply_res['content'];

}		
	}
	
	else
	{
		echo $reply_res['content'];
		
	}
	


?>
<div class="replytarget" style="font:bold;" id="replytarget<?php echo $reply_res['reply_id'];?>"></div>


<div class="streplytime"><?php time_stamp($reply_res['date_created']); ?></div><div tabindex="1" id="replytranslatemenu<?php echo $reply_res['reply_id'];?>" class="replytranslatemenu" style="display:none; position:absolute;margin-left: 34%; "> <select id="replylangs<?php echo $reply_res['reply_id'];?>" class="postlangs" onchange="selectOption(this.value, <?php echo $reply_res['reply_id'];?>,3)">
            <option value=""><?php echo $lang['select language'];?></option> 
            </select>
            </div> 
<span style="padding-left:5px;">
<!--like block-->
<div><br>
<?php
$reply_like_query = mysqli_query($con, "SELECT * FROM event_wall_comment_reply_like WHERE reply_id='". $reply_res['reply_id'] ."'");
$reply_like_count = mysqli_num_rows($reply_like_query);

$reply_like_query1 = mysqli_query($con, "SELECT m.username,m.member_id 
								  FROM reply_like c, members m 
								  WHERE m.member_id = c.member_id 
								  AND c.reply_id = '".$reply_res['reply_id']."' 
								  AND c.member_id = '".$_SESSION['SESS_MEMBER_ID']."' ");
$reply_like_count = mysqli_num_rows($reply_like_query1);
if($reply_like_count == 1)
{
$reply_like_query2 = mysqli_query($con, "SELECT m.username,m.member_id 
								  FROM event_wall_comment_reply_like c, members m 
								  WHERE m.member_id=c.member_id 
								  AND c.reply_id='".$reply_res['reply_id']."' 
								  AND c.member_id!='".$_SESSION['SESS_MEMBER_ID']."' LIMIT 2");
$rlike_count = mysqli_num_rows($reply_like_query2);
$new_rlike_count = $reply_like_count - 2; 
}
else
{
$reply_like_query2 = mysqli_query($con, "SELECT m.username,m.member_id 
                                 FROM event_wall_comment_reply_like c, members m 
								 WHERE m.member_id=c.member_id 
								 AND c.reply_id='".$reply_res['reply_id']."' LIMIT 3");
$rlike_count = mysqli_num_rows($reply_like_query2);
$new_rlike_count=$reply_like_count - 3; 
}

?>
<div class="rlike" id="rlike<?php echo $reply_res['reply_id'];?>" style="display:<?php if($reply_like_count <= 0) { echo 'none'; } else { echo 'block'; }?>">
<?php 

if($reply_like_count == 1)
{?><span id="you<?php echo $reply_res['reply_id'];?>"><a href="#"><?php echo $lang['You'];?></a><?php if($reply_like_count>1)
echo ','; ?> </span><?php
}

?>

<input type="hidden"  value="<?php echo $reply_like_count; ?>" id="rcommacount<?php echo $reply_res['reply_id'];?>" >
<?php

$i = 0;
while($reply_like_res = mysqli_fetch_array($reply_like_query2)) {
$i++; 	  
?>

<a href="#" id="likeuser<?php echo $reply_res['reply_id'];?>"><?php echo $reply_like_res['username']; ?></a>
<?php
	//}
if($i <> $rlike_count) { echo ',';}
//} 
} 
if($rlike_count > 3) {
?>
<?php echo $lang['and'];?> <span id="rlike_count<?php echo $reply_res['reply_id'];?>" class="rnumcount"><?php echo $new_rlike_count;?></span><?php echo $lang['others'];?><?php } ?> <?php echo $lang['like this'];?>.</div> 

</div>
<!--end like block-->

<!--dislie block-->
<div>
<?php
$rdquery = "SELECT * FROM event_wall_comment_reply_dislike WHERE reply_id='". $reply_res['reply_id'] ."'";
$rdsql  = mysqli_query($con, $rdquery) or die(mysqli_error($con));
$reply_dislike_count = mysqli_num_rows($rdsql);

$rdquery1 = mysqli_query($con, "SELECT m.username,m.member_id FROM event_wall_comment_reply_dislike c, members m WHERE m.member_id=c.member_id 
AND c.comment_id='".$reply_res['reply_id']."'");
?>
<span id="rdislikecout_container<?php echo $reply_res['reply_id'];?>" style="display:<?php if($reply_dislike_count <= 0) { echo 'none'; } else { echo 'block'; }?>">
<span id="rdislikecout<?php echo $reply_res['reply_id'];?>">
<?php
echo $reply_dislike_count;
?>
</span>
<?php echo $lang['Person Dislike this'];?>
</span>
</div>
<!--end dislike block-->
</span>
<span style="top:2px;">

<?php
$reply_like = mysqli_query($con, "select like_id from event_wall_comment_reply_like where reply_id = '".$reply_res['reply_id']."' and member_id = '".$member_id."'");
if(mysqli_num_rows($reply_like) > 0)
{
	echo '<a href="javascript: void(0)" class="reply_like show_cmt_linkClr" id="reply_like'.$reply_res['reply_id'].'"  title="'.$lang['Unlike'].'" rel="Unlike">'.$lang['Unlike'].'</a>';
} 
else 
{ 
	echo '<a href="javascript: void(0)" class="reply_like show_cmt_linkClr" id="reply_like'.$reply_res['reply_id'].'"  title="'.$lang['like'].'" rel="Like">'.$lang['like'].'</a>';
}
?>
</span>
<!-- End of like button -->
<!-- Dislike button -->
<span style="top:2px; padding-left:5px;">
<span class="mySpan_dot_class"> · </span>
<?php
$reply_dislike_query = "SELECT dislike_reply_id FROM  event_wall_comment_reply_dislike WHERE reply_id='". $reply_res['reply_id'] ."' and member_id = '".$member_id."'";
$reply_dislike_sql  = mysqli_query($reply_dislike_query) or die(mysqli_error($con));
$reply_dislike_count = mysqli_num_rows($reply_dislike_sql);
if($reply_dislike_count > 0) {
echo '<a href="javascript: void(0)" class="reply_dislike show_cmt_linkClr" id="reply_dislike'.$reply_res['reply_id'].'" title="'.$lang['dislike'].'" rel="disLike">'.$lang['dislike'].'</a>';
} else {
echo '<a href="javascript: void(0)" class="reply_dislike show_cmt_linkClr" id="reply_dislike'.$reply_res['reply_id'].'" title="'.$lang['Undislike'].'" rel="disLike">'.$lang['Undislike'].'</a>';
}
?>
</span> 
<!-- End of dislike  button -->
<!-- Reply Button -->
<span style="top:2px; margin-left:5px;">
<span class="mySpan_dot_class"> · </span>
<a href="" id="<?php echo $reply_res['reply_id'];?>" class="reply-replyopen show_cmt_linkClr"><?php echo $lang['Reply']; ?></a>

</span>
<span style="top:2px; margin-left:3px;" >
<span class="mySpan_dot_class"> · </span>
 <a class="replytranslateButton show_cmt_linkClr" href="javascript:void(0);" id="replytranslateButton<?php echo $reply_res['reply_id'];?>"  ><?php echo $lang['Translate']; ?></a>

</span>
<!---------------- Vinayak----------------------------->




            
<textarea class="replysource" id="replysource<?php echo $reply_res['reply_id'];?>"  style="display:none;"><?php echo $reply_res['content'];?></textarea>
<div class="replytarget" style="font:bold;" id="replytarget<?php echo $reply_res['reply_id'];?>"></div>


<?php if($row1['type']==1)
{ ?>

       
<?php 
} ?>

</div><!--End streplytext div-->
<!--reply@reply-->
<div class="replycontainer" style="margin-left:40px;" id="reply-reply-load<?php echo $reply_res['reply_id'];?>">
<?php
$reply_r_sql  = mysqli_query($con, "SELECT m.username,m.member_id,m.profImage,
						   a.content, a.date_created,a.id
						   FROM event_wall_reply_reply a 
						   LEFT JOIN members m ON a.member_id = m.member_id 
						   WHERE reply_id=" . $reply_res['reply_id'] . " 
						   ORDER BY id DESC limit 0,2");

while($reply_r_res = mysqli_fetch_assoc($reply_r_sql))
{
?>
<div class="reply-reply-body" id="reply-reply-body<?php echo $reply_r_res['id']; ?>">
<div class="stcommentimg">
<a href="<?php echo $base_url.$reply_r_res['username'];?>"><img src="<?php echo $base_url.$reply_r_res['profImage']; ?>" class='small_face'/></a>
</div>

<div class="reply-reply-text">
 <?php 
if($_SESSION['SESS_MEMBER_ID'] == $reply_r_res['member_id'])
{
?>
<a class="reply-reply-delete" href="#" id='<?php echo $reply_r_res['reply_id']; ?>' title='<?php echo $lang['Delete Reply']; ?>'></a>
<?php } ?>
<a href="<?php echo $base_url.$reply_r_res['username'];?>"><b><?php echo $reply_r_res['username']; ?> 
 
 </b></a>
<?php 
 
 if($reply_res['member_id'] <> $reply_r_res['member_id'])
 {
	 echo '@'; 
	?> <a href="<?php echo $base_url.$reply_res['username'];?>"><b><?php echo $reply_res['username']; ?> 
 
 </b></a>
 <br />	 
<?php
 }
?> 
 <br />	

<?php 
if(isset($_SESSION['lang'])&&($_SESSION['lang']<>"en"))
	{	
		
		$sql = mysqli_query($con, "select * from reply_reply1 where msg_id='".$reply_r_res['id']."' and tr_id='".$_SESSION['lang']."'")or die(mysqli_error($con));
$r_count = mysqli_num_rows($sql);
if($r_count>0)
{
$row_reply_reply = mysqli_fetch_assoc($sql);


	echo $row_reply_reply['message'];

}
	
	else
	{
		
include "test6.php";
		
	
		
	}
	$sql1 = mysqli_query($con, "select * from reply_reply1 where msg_id='".$reply_r_res['id']."' and tr_id='".$_SESSION['lang']."'")or die(mysqli_error($con));
$r_count1 = mysqli_num_rows($sql1);
	if($r_count1==0)
{



	echo $reply_r_res['content'];

}	
	}
	
	else
	{
		echo $reply_r_res['content'];
		
	}
?>
<div class="streplytime"><?php time_stamp($reply_r_res['date_created']); ?></div>

</div><!--End reply-reply div-->
<!--reply@reply-->

</div><!--End streplybody div-->
<?php } ?>
</div>
<!--Start replyupdate -->
<div class="reply-reply-update" style='display:none' id='reply-reply-update<?php echo $reply_res['reply_id'];?>'>
<div class="streplyimg">
<img src="<?php echo $base_url.$res['profImage'];?>" class='small_face'/>
</div>

<div class="reply-reply-text" >
<form method="post" action="">
<textarea name="reply" class="reply-reply" maxlength="200"  id="reply-reply<?php echo $reply_res['reply_id'];?>"></textarea>
<br /> 
<input type="submit" abcd="<?php echo $reply_res['member_id']; ?>"  title="<?php echo $reply_res['username']; ?>" value="    @    "  id="<?php echo $reply_res['reply_id'];?>" class="reply-reply"/>
<input type="button"  value=" <?php echo $lang["Cancel"];?>"  onclick="closereplyreply('reply-reply-update<?php echo $reply_res['reply_id'];?>')" class="cancel"/>
</form>
</div>
</div>
<!--End replyupdate div	--> 
</div><!--End streplybody div-->
<?php } ?>

<!--Start replyupdate -->
<div class="replyupdate" style='display:none' id='replybox<?php echo $row1['comment_id'];?>'>
<div class="streplyimg">
<img src="<?php echo $base_url.$res['profImage'];?>" class='small_face'/>
</div>

<div class="streplytext" >
<form method="post" action="">
<textarea name="reply" class="reply" maxlength="200"  id="rtextarea<?php echo $row1['comment_id'];?>"></textarea>
<br /> 
<input type="submit" abcd="<?php echo $row1['member_id']; ?>"  title="<?php echo $row1['username']; ?>" value="    @    "  id="<?php echo $row1['comment_id'];?>" class="reply_button"/>
<input type="button"  value=" <?php echo $lang["Cancel"];?> "  id="<?php echo $row['messages_id'];?>" onclick="closereply('replybox<?php echo $row1['comment_id'];?>')" class="cancel"/>
</form>
</div>
</div>
<!--End replyupdate div	--> 
</div><!--End replycontainer div-->
</div>
<?php } 
$q = mysqli_query($con, "SELECT * FROM event_wall_like WHERE member_id='". $_SESSION['SESS_MEMBER_ID'] ."' and remarks='".$row['messages_id']."' ");
?>

</div><!--End commentcontainer div--> 

<div class="commentupdate" style='display:none' id='commentbox<?php echo $row['messages_id'];?>'>
<div class="stcommentimg">
<img src="<?php echo $currentUserProfilePic ?>" class='small_face'/>
</div>

<div class="stcommenttext" >
<form method="post" action="">
<!--<textarea name="comment" class="comment" maxlength="200"  id="ctextarea<?php echo $row['messages_id'];?>"></textarea>!-->
<!-- code for smiley!-->
<div id="ctextarea<?php echo $row['messages_id'];?>" onkeyup="checkdata(this.id)" onclick="checkdata(this.id)" contenteditable="true" name="comment" class="comment" style="height:70px; border:1px solid black; overflow-y:scroll;"></div>
<div id="showimg2_<?php echo $row['messages_id'];?>" name="actcomment" style="display:none;" ></div>
<input type="hidden" id="currentid" value="<?php echo $row['messages_id'];?>" />
<!--<input type="button" value="show smiley" id="<?php echo $row['messages_id'];?>" onclick="show(this.id)"  />!--><a herf="#!" style="cursor:pointer;" onclick="show(this.id)" id="<?php echo $row['messages_id'];?>"><img src="<?php echo $base_url; ?>images/Glad.png"></a>
<!--code for smiley!-->

<br />
<input type="submit"  value="<?php echo $lang['Comment'];?>"  id="<?php echo $row['messages_id'];?>" class="button22 cancel"/>



<!--<input type="submit"  value=" Comment "  id="<?php echo $row['messages_id'];?>" class="button"/>!-->
<input type="button"  value=" <?php echo $lang["Cancel"];?> "  id="<?php echo $row['messages_id'];?>" onclick="cancelclose('commentbox<?php echo $row['messages_id'];?>')" class="cancel"/>

</form>
</div>
</div><!--End commentupdate div	--> 
<div class="commentupdate" style='display:none' id='reportbox<?php echo $row['messages_id'];?>'>
<div class="stcommentimg">
<img src="<?php echo $base_url.$res['profImage'];?>" class='small_face'/>
</div>

<div class="stcommenttext" >
<form method="post" action="">
<textarea name="comment" class="comment" maxlength="200"  id="rptextarea<?php echo $row['messages_id'];?>" placeholder="<?php echo $lang['Flag this status'];?>.."></textarea>
<br />
<input type="submit"  value=" <?php echo $lang['Report'];?>"  id="<?php echo $row['messages_id'];?>" class="report"/>
<input type="button"  value=" <?php echo $lang['Cancel'];?>"  id="<?php echo $row['messages_id'];?>" onclick="canclose('reportbox<?php echo $row['messages_id'];?>')" class="cancel"/>
</form>
</div>
</div><!--End commentupdate div	-->
 
<div class="emot_comm">
    
	<span class="show-cmt">
 <?php
	if(mysqli_num_rows($q) > 0)
	{
		echo '<a href="javascript: void(0)" class="like show_cmt_linkClr" id="like'.$row['messages_id'].'" title="'.$lang['Unlike'].'" rel="Unlike">'.$lang['Unlike'].' </a>';
	} 

	else 
	{ 
		echo '<a href="javascript: void(0)" class="like show_cmt_linkClr" id="like'.$row['messages_id'].'" title="'.$lang['Like'].'" rel="Like">'.$lang['Like'].'</a>';
	}
	
?>

</span>

<span class="show-cmt">
<span class="mySpan_dot_class"> · </span>
 <?php
 $pdislikequery = "SELECT dislike_id FROM event_wall_dislike WHERE member_id='$member_id'";
 $pdislikesql = mysqli_query($con, $pdislikequery);
 
 
	if(mysqli_num_rows($pdislikesql) > 0)
	{
		echo '<a href="javascript: void(0)" class="post_dislike show_cmt_linkClr" id="post_dislike'.$row['messages_id'].'" title="'.$lang['dislike'].'" rel="disLike">'.$lang['dislike'].'</a>';
	} 

	else 
	{ 
		echo '<a href="javascript: void(0)" class="post_dislike show_cmt_linkClr" id="post_dislike'.$row['messages_id'].'" title="'.$lang['Undislike'].'" rel="disLike">'.$lang['Undislike'].'</a>';
	}
	
?>

</span>


<span class="show-cmt">
<span class="mySpan_dot_class"> · </span>
<a href="javascript:void(0)" id="<?php echo $row['messages_id'];?>" class="commentopen show_cmt_linkClr"><?php echo $lang['Comment'];?></a>

</span>

<span class="show-cmt hidden">
<span class="mySpan_dot_class"> · </span>
<a href="javascript:void(0)" id="<?php echo $row['messages_id'];?>" class="flagopen show_cmt_linkClr"><?php echo $lang['Flag this Status'];?></a>

</span>

<?php if($row['type']==0)
 {
	 if(substr($row['messages'],0,4) != 'http' )
{ ?>
<span style="top:2px; left:3px;" >
<span class="mySpan_dot_class"> · </span>
<a class="posttranslateButton show_cmt_linkClr" href="javascript:void(0);" id="posttranslateButton<?php echo $row['messages_id'];?>"  ><?php echo $lang['Translate'];?></a>
</span>
<?php } } ?>
</div>

</div><!--End sttext div	--> 
</div><!--End stbody div	-->

<?php }?>
</div>
</div><!--end column internal left-->

<div class="column_internal_right">
<div style="margin-top:5px">
<?php 
$emquery = "SELECT m.member_id, m.username, m.LastName, m.profImage
			FROM event_members em LEFT JOIN members m ON em.member_id = m.member_id
			WHERE em.event_id = '$id' AND em.status != 0 order by em.id DESC LIMIT 10";
$emsql = mysqli_query($con, $emquery) or die(mysqli_error($con));
?>
<a href="event_members.php?id=<?php echo $id;?>"><strong><?php echo $lang['Event members'];?> (<?php echo mysqli_num_rows($emsql);?>) </strong></a>
</div>
<?php 
while($emres = mysqli_fetch_array($emsql))
{

?>
<div style="height:35px; margin-top:10px;">
<a href="<?php echo $base_url.$emres['username'];?>" style="float:left;">
<img src="<?php echo $base_url.$emres['profImage'];?>" height="32" width="32" />
</a>
<div style="margin-left:37px;">
<a href="<?php echo $base_url.$emres['username'];?>">
<?php echo $emres['username'];?>
</a>
</div>
</div>
<?php }?>
</div>
</div><!--end column_left div-->

<!--Start column right-->
    <div class="col-lg-2 col-md-2 col-sm-3 hidden-xs"> 
        <div style="" class="adsQBxzqw"> <?php include($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/ads.php');?></div>
    </div>
<!--end column_right div-->
<?php
//modal event
echo "<div class='create_event_div' id='create_event_div' style='display:none;'>
<form id='frm_create_event' action='action/edit_event-exec.php' method='post' > 
<input type='hidden' name='event_id' value=".$id." />
<div style='background-color:#CCC'>
<table height='10%'>
<tr>
	<td colspan='2' align='left'><b>
    ".$lang['Edit Event']."</b>
    </td>    
</tr>
</table>

</div>
<br>
<div>
<table height='80%'>
<tr>
	<td align='right'>".$lang['Name']."</td>
    <td><input name='event_input' id='event_input' value='".$eres['event_name']."' type='text'></td>
</tr>
<tr>
	<td align='right'>".$lang['Details']."</td>
    <td><textarea name='event_description' id='event_description' >".$eres['event_description']."</textarea></td>
</tr>
<tr>
	<td align='right'>".$lang['Date']."</td>
    <td><input name='event_date' type='text' id='datepicker' value='".$eres['datepicker']."' /></td>
</tr>
<tr>
	<td align='right'>".$lang['Where']."</td>
    <td><input name='where_event' id='where_event' value='".$eres['event_location']."' type='text'></td>
</tr>
</table>
</div>
<br>
<div style='background-color:#CCC'>
<table height='10%'>
<tr>
	<td colspan='2' align='right'>
    <input type='submit' name='create_event' value='".$lang['Save']."'>

    <input type='button' name='btn_cancel' onclick='create_event_close()' value='".$lang['Cancel']."'>
    </td>    
</tr>
</table>
</div>
</form>

</div>";
?>
</div><!--end mainbody div-->

<!--start smily block-->
<script>
$('.button22').live("click", function () {
    var ID = $(this).attr("id");
	//alert(ID);
	//alert($("#ctextarea" + ID).text());
    var comment = $("#ctextarea"+ID).html();
	//alert(comment);
    var dataString = 'comment=' + comment + '&msg_id=' + ID;
    if (comment == '') {
        alert("Please Enter Comment Text");
    } else {
        $.ajax({
            type: "POST",
            url: base_url + "action/event_wall_comment_ajax.php",
            data: dataString,
            cache: false,
            success: function (html) {
                $("#commentload" + ID).append(html);
                $("#ctextarea" + ID).text('');
				$("#ctextarea" + ID).html('');
				$("#showimg2_"+ID).text('');
                $("#ctextarea" + ID).focus();
            }
        });
    }
    return false;
});

function show(id)
{
	//alert(id);
	$("#currentid").val(id);
	//alert('hi');
	$("#vinod").show();
	var scrol=$(document).scrollTop();
		//alert(scrol);
		$("#vinod").css('top', scrol+300);
}

function closesmiley()
{
	$("#vinod").hide();
}

function addsmiley(path)
{
	//alert(path);
	var currentid=$("#currentid").val();
	//alert(currentid);
	
	var olddata=$("#showimg2_"+currentid).html();
	//alert(olddata);
	//$("#ctextarea"+currentid).html("<img src="+path+" height='20' width='20'>");
	$("#ctextarea"+currentid ).append("<img src="+path+" height='20' width='20'>");
	//alert($("#showimg").text());
	//alert($("#ctextarea"+currentid).text());
	 //$("#showimg2_"+currentid).append($("#ctextarea"+currentid).text());
	 //var acttext= $('#anothertext').html();
	// alert(acttext);
	//alert($("#ctextarea"+currentid ).html());
	 $("#showimg2_"+currentid).append($("#ctextarea"+currentid ).html());
	 $("#vinod").hide();
	
}

function checkdata(id)
{
	//alert(id);
	var str=id.split('ctextarea');
	//alert(str[1]);
	var typecontent=$("#"+id).text();
	//alert(typecontent);
	$("#showimg2_"+str[1]).text(typecontent);
}

</script>

<div id="vinod" class="PopupPanel" style="display:none;">

<div align="right"><a href="javascript:void(0)" onclick="closesmiley()"><img src="<?php echo $base_url; ?>images/closebox.png"></a></div>
<table width="100%" cellpadding="4" cellspacing="4">
<tr><td><img src='<?php echo $base_url; ?>img/smiley/kiss.jpg' style="border-radius:50%" height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='<?php echo $base_url; ?>img/smiley/laugh.jpg' height="40" style="border-radius:50%" width="40" onclick="addsmiley(this.src)" ></td><td><img src='<?php echo $base_url; ?>img/smiley/wakulya.png' style="border-radius:50%" height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='<?php echo $base_url; ?><?php echo $base_url; ?>img/smiley/cry.png' style="border-radius:50%" height="40" width="40" onclick="addsmiley(this.src)" ></td></tr>
<tr><td><img src='<?php echo $base_url; ?>img/smiley/fg.jpg' style="border-radius:50%" height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='<?php echo $base_url; ?>img/smiley/images.jpg' height="40" style="border-radius:50%" width="40" onclick="addsmiley(this.src)" ></td><td><img src='<?php echo $base_url; ?>img/smiley/images0.jpg' style="border-radius:50%" height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='<?php echo $base_url; ?>img/smiley/images1.jpg' style="border-radius:50%" height="40" width="40" onclick="addsmiley(this.src)" ></td></tr>

<tr><td><img src='<?php echo $base_url; ?>img/smiley/images2.jpg' style="border-radius:50%" height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='<?php echo $base_url; ?>img/smiley/images3.jpg' height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img style="border-radius:50%" src='<?php echo $base_url; ?>img/smiley/images4.jpg' height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='<?php echo $base_url; ?>img/smiley/images5.jpg' style="border-radius:50%" height="40" width="40" onclick="addsmiley(this.src)" ></td></tr>


<tr><td><img src='<?php echo $base_url; ?>img/smiley/surprised.png' style="border-radius:50%" height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='<?php echo $base_url; ?>img/smiley/images7.jpg' height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='<?php echo $base_url; ?>img/smiley/images8.jpg' style="border-radius:50%" height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='<?php echo $base_url; ?>img/smiley/images9.jpg' style="border-radius:50%" height="40" width="40" onclick="addsmiley(this.src)" ></td></tr>

<tr><td><img src='<?php echo $base_url; ?>img/smiley/images/smiley-1.JPG' style="border-radius:50%" height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='<?php echo $base_url; ?>img/smiley/images/smiley-2.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='<?php echo $base_url; ?>img/smiley/images/smiley-3.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='<?php echo $base_url; ?>img/smiley/images/smiley-4.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td></tr>



<tr><td><img src='<?php echo $base_url; ?>img/smiley/images/smiley-5.JPG' style="border-radius:50%" height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='<?php echo $base_url; ?>img/smiley/images/smiley-6.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='<?php echo $base_url; ?>img/smiley/images/smiley-7.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='<?php echo $base_url; ?>img/smiley/images/smiley-8.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td></tr>

<tr><td><img src='<?php echo $base_url; ?>img/smiley/images/smiley-9.JPG' style="border-radius:50%" height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='<?php echo $base_url; ?>img/smiley/images/smiley-10.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='<?php echo $base_url; ?>img/smiley/images/smiley-11.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='<?php echo $base_url; ?>img/smiley/images/smiley-12.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td></tr>


<tr><td><img src='<?php echo $base_url; ?>img/smiley/images/smiley-13.JPG' style="border-radius:50%" height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='<?php echo $base_url; ?>img/smiley/images/smiley-14.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='<?php echo $base_url; ?>img/smiley/images/smiley-15.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='<?php echo $base_url; ?>img/smiley/images/smiley-16.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td></tr>


<tr><td><img src='<?php echo $base_url; ?>img/smiley/images/smiley-17.JPG' style="border-radius:50%" height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='<?php echo $base_url; ?>img/smiley/images/smiley-18.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='<?php echo $base_url; ?>img/smiley/images/smiley-19.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='<?php echo $base_url; ?>img/smiley/images/smiley-20.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td></tr>


<tr><td><img src='<?php echo $base_url; ?>img/smiley/images/smiley-21.JPG' style="border-radius:50%" height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='<?php echo $base_url; ?>img/smiley/images/smiley-22.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='<?php echo $base_url; ?>img/smiley/images/smiley-23.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='<?php echo $base_url; ?>img/smiley/images/smiley-24.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td></tr>


<tr><td><img src='<?php echo $base_url; ?>img/smiley/images/smiley-25.JPG' style="border-radius:50%" height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='<?php echo $base_url; ?>img/smiley/images/smiley-26.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='<?php echo $base_url; ?>img/smiley/images/smiley-27.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='<?php echo $base_url; ?>img/smiley/images/smiley-28.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td></tr>

<tr><td><img src='<?php echo $base_url; ?>img/smiley/images/smiley-29.JPG' style="border-radius:50%" height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='<?php echo $base_url; ?>img/smiley/images/smiley-30.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='<?php echo $base_url; ?>img/smiley/images/smiley-31.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='<?php echo $base_url; ?>img/smiley/images/smiley-32.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td></tr>


<tr><td><img src='<?php echo $base_url; ?>img/smiley/images/smiley-33.JPG' style="border-radius:50%" height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='<?php echo $base_url; ?>img/smiley/images/smiley-34.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='<?php echo $base_url; ?>img/smiley/images/smiley-35.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='<?php echo $base_url; ?>img/smiley/images/smiley-36.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td></tr>

</table>


</div>
<?php
	include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_footer.php');
?>
                            