<?php
	ob_start();
	session_start();
	require_once('config.php');
	if(!isset($_SESSION['SESS_MEMBER_ID']))
	{
		header("location: ".$base_url."index.php");
		exit();
	}
	$session_member_id = $_SESSION['SESS_MEMBER_ID'];
	include 'includes/time_stamp.php';
	if(isset($_REQUEST['member_id']))
	{	
	$member_id = $_REQUEST['member_id'];
	$sql = mysqli_query($con, "select * from members where member_id='".$member_id."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<title>Browse Video</title>
<head>

<link rel="stylesheet" type="text/css" href="css/wall.css"/>
<link rel="stylesheet" type="text/css" href="css/search.css"/>
<link rel="stylesheet" type="text/css" href="css/style.css"/>


<link rel="icon" href="images/favicon.ico" type="image" />
<link rel="shortcut icon" href="images/favicon.ico" type="image" />

<script src="js/jquery.min.js"></script>
<script src="js/jquery-1.9.1.js"></script>
<script src="js/youtube.js"></script>
    <script type="text/javascript" src="flowplayer/flowplayer.min.js"></script>
 <link rel="stylesheet" type="text/css" href="flowplayer/skin/minimalist.css">
 <link rel="stylesheet" type="text/css" href="css/youtube.css"/>

 <link rel="stylesheet" href="http://www.jacklmoore.com/colorbox/example1/colorbox.css" />
    <script src="http://www.jacklmoore.com/colorbox/jquery.colorbox.js"></script>


<body>
<div id="wrapper">
<?php 
include('includes/header.php');

?>
<div id="mainbody">
<div id="ad_creative">
<embed src="ads/quakbox.swf" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"  quality="high" allowscriptaccess="always" wmode="transparent" align="middle" width="960" height="180"></embed>
</div>

<div class="column_left">
<div class="popular_video">
<h1>Popular Videos</h1>
    <ul class="popular">
    <?php
	if(isset($_REQUEST['member_id']))
	{
		$member_id = $_REQUEST['member_id'];
	}
$pvsql = mysqli_query($con, "select video,url,messages,url_title,date_created,messages_id,view_count from message where type = 2 order by view_count desc");
while($pvres = mysqli_fetch_array($pvsql))
{
	$time = $pvres['date_created'];
?>

        <li class="popular_list" id="popular_list-<?php echo $pvres['messages_id'];?>">
        <a href="view_video.php?video_id=<?php echo $pvres['messages_id'];?>" class="view_video" onclick="view_count()" id="<?php echo $pvres['messages_id'];?>">
       <!-- <div class="flowplayer" data-swf="flowplayer/flowplayer.swf" data-ratio="0.4167">
      <video>
         
         <source type="video/mp4" src="<?php echo $pvres['messages'];?>">

      </video>
   </div>-->
   
   <img src="images/videos_pl.png" />
   </a>
<div class="video_Content">
<h3 class="video_title"><?php echo $pvres['url_title'];?></h3>
<div class="video_data">

<span class="view_count"><?php echo $pvres['view_count'];?> views</span>
<span class="content_item_time"><?php echo time_stamp($time);?></span>

</div>
</div>
        
        </li>
        
        
<?php } ?>        
    </ul>
</div>

<div class="popular_video">
<h1>Recent Videos</h1>
    <ul class="popular">
    <?php 
$rvsql = mysqli_query($con, "select video,url,messages,url_title,date_created,messages_id,view_count from message where type = 2 order by date_created desc");
while($rvres = mysqli_fetch_array($rvsql))
{
	$time = $rvres['date_created'];
?>

        <li class="popular_list" id="popular_list-<?php echo $rvres['messages_id'];?>">
        <a href="view_video.php?video_id=<?php echo $rvres['messages_id'];?>" class="view_video" onclick="view_count()" id="<?php echo $rvres['messages_id'];?>">
       <!-- <div class="flowplayer" data-swf="flowplayer/flowplayer.swf" data-ratio="0.4167">
      <video>
         
         <source type="video/mp4" src="<?php echo $rvres['messages'];?>">

      </video>
   </div>-->
   
   <img src="images/videos_pl.png" />
   </a>
<div class="video_Content">
<h3 class="video_title"><?php echo $rvres['url_title'];?></h3>
<div class="video_data">

<span class="view_count"><?php echo $rvres['view_count'];?> views</span>
<span class="content_item_time"><?php echo time_stamp($time);?></span>

</div>
</div>
        
        </li>
        
        
<?php } ?>        
    </ul>
</div>


</div><!--End column left div-->
</div><!--End mainbody div-->

<?php include 'includes/footer.php';?>
</div><!--End wrapper div-->
</body>
</html>