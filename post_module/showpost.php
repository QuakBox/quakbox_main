<?php
	ob_start();
	session_start();
	require_once('config.php');
	
	$session_member_id = $_SESSION['SESS_MEMBER_ID'];
	include 'includes/time_stamp.php';
	
	
	$msg_id = $_REQUEST['mid'];
	
	$wquery = "select * from message where messages_id = '$msg_id'";
$wsql = mysqli_query($con, $wquery);
$wres = mysqli_fetch_array($wsql);
$video_id = $wres['video_id'];// 339
$type=$wres['type'];
$message22=$wres['messages'];
	
	//$msql = mysqli_query("select * from members where member_id = '$session_member_id'");
	//$mres = mysqli_fetch_array($msql);
	
	$pvquery = "SELECT v.location, v.thumburl, v.title, v.video_id, v.date_created, v.view_count,v.description,
				v.url_type, v.msg_id, v.category, m.username
				FROM videos v LEFT JOIN members m ON m.member_id = v.user_id 
				WHERE v.video_id = '$video_id'";
	$pvsql = mysqli_query($con, $pvquery) or die(mysqli_error($con));

$mrow = mysqli_fetch_array($pvsql);
$category = $mrow['category'];


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<title>Show Post</title>
<head>

<link rel="stylesheet" type="text/css" href="css/wall.css"/>
<link rel="stylesheet" type="text/css" href="css/group.css"/>
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="stylesheet" type="text/css" href="css/youtube.css"/>
<link rel="stylesheet" type="text/css" href="css/jquery-ui.css"/>
<link rel="icon" href="images/favicon.ico" type="image" />
<link rel="shortcut icon" href="images/favicon.ico" type="image" />

<script src="js/jquery.min.js"></script>
<script src="js/wall.js"></script>

<script src="js/jquery.livequery.js" type="text/javascript"></script>
<script src="js/jquery.oembed.js"></script>
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui.js"></script>

<script type="text/javascript" src="js/ibox.js"></script>
<script type="text/javascript" src="js/autocomplete.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/video-js.css">
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>font-awesome/css/font-awesome.css">
<!-- video.js must be in the <head> for older IEs to work.-->
<script src="<?php echo $base_url;?>js/video.js"></script>

<!-- Unless using the CDN hosted version, update the URL to the Flash SWF -->
<script>videojs.options.flash.swf = "<?php echo $base_url;?>videojs/video-js.swf";</script> 
<style>
#custom-message {
    position:absolute;
    z-index: 1;
    margin-top: 10px;
    margin-left: 10px;
}
.vjs-control.vjs-quakbox-button:before {
        content:url(<?php echo $base_url;?>images/watermark.png);
}
</style>
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
</style>
</head>
 
<body style="background-size:cover; background-image:url('<?php echo $base_url;?>images/emailimages.jpg')" >
 <?php
  if($type==1)
{
?>
<div align='center' style="margin-top:40px;background-image:images/emailimages.jpg">
<?php
$message23="<img src='$base_url.$message22' height='400' width='400'>";
echo $message23;
//$message23="<a href='".$base_url."showpost.php?mid=$mid'>Show Post</a>";
?>
</div>
<?php	
}
?>
<div id="wrapper" >
<?php 
//include('includes/header.php');

?>

<div id="mainbody" >

   
<div class="column_left_video" >

 
   <input type="hidden" id="user_id" value="<?php echo $session_member_id;?>" />
    <?php
	
$view_count = $mrow['view_count'];
$view_count = $view_count + 1;
$musql = "update videos set view_count = '$view_count' where video_id = '$video_id'";
//$mures = mysqli_query($musql) or die(mysqli_error());
$time = $mrow['date_created'];
if($mrow['url_type'] == 1)
{
?>
      
 <div id="divContainer" >
  <img src="../images/logo.png" />
 

 <div id="custom-message"><h3 class="video_title" style="color:#fff;"><?php echo $mrow['title'];?></h3></div>
 <video id="videojsidid" class="video-js vjs-default-skin" controls preload="none" width="640" height="400" 
      poster="<?php echo $mrow['thumburl'];?>"
      data-setup="{}">
    <source src="<?php echo $mrow['location'];?>" type='video/mp4' />
    <track kind="captions" src="uploadedvideo/captions/demo.captions.vtt" srclang="en" label="English"></track><!-- Tracks need an ending tag thanks to IE9 -->
    <track kind="subtitles" src="uploadedvideo/captions/demo.captions.vtt" srclang="en" label="English"></track><!-- Tracks need an ending tag thanks to IE9 -->
  </video>
  
  </div>
  <script>
   videojs.Quakbox = videojs.Button.extend({
      // @constructor 
        init: function(player, options){
          videojs.Button.call(this, player, options);
          this.on('click', this.onClick);
        }
      });

      videojs.Quakbox.prototype.onClick = function() {
        alert("quak");
      };

      // Note that we're not doing this in prototype.createEl() because
      // it won't be called by Component.init (due to name obfuscation).
      var createQuakboxButton = function() {
        var props = {
            className: 'vjs-quakbox-button vjs-control',
            innerHTML: '<div class="vjs-control-content"><span class="vjs-control-text">' + ('Quakbox') + '</span></div>',
            role: 'button',
            'aria-live': 'polite', // let the screen reader user know that the text of the button may change
            tabIndex: 0
          };
        return videojs.Component.prototype.createEl(null, props);
      };

      var quakbox;
      videojs.plugin('quakbox', function() {
        var options = { 'el' : createQuakboxButton() };
        quakbox = new videojs.Quakbox(this, options);
        this.controlBar.el().appendChild(quakbox.el());
      });

      var vid = videojs("videojsidid", {
        plugins : { quakbox : {} }
      });
    </script>
 <?php } 
 if($mrow['url_type'] == 2)
 {
 
  if (preg_match('![?&]{1}v=([^&]+)!', $mrow['location'] . '&', $m))
	$video_id = $m[1]; 
	$url = "http://gdata.youtube.com/feeds/api/videos/".$video_id;
	$doc = new DOMDocument;
	$doc->load($url);
	$title = $doc->getElementsByTagName("title")->item(0)->nodeValue;
	?>
       
    <embed src="http://www.youtube.com/v/<?php echo $video_id ?>&hl=en&fs=1&hd=1&showinfo=0&rel=0" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="80%" height="390" wmode="transparent"></embed>

  <?php } ?> 





<div class="commentupdate" style='display:none; width:99%;' id='reportbox<?php echo $msg_id;?>'>
<div class="stcommentimg">
<img src="<?php echo $res['profImage'];?>" class='small_face'/>
</div>


</div>
</div><!--End commentupdate div	--> 

</div><!--End column_left_video div-->


</div><!--End mainbody div-->

<?php //include 'includes/footer.php';?>
</div><!--End wrapper div-->


</body>
</html>