<?php
	ob_start();
	session_start();
	require_once('config.php');
	if(!isset($_SESSION['SESS_MEMBER_ID']))
	{
		header("location: ".$base_url."login.php?back=". urlencode($_SERVER['REQUEST_URI']));
		exit();
	}
	if(isset($_SESSION['lang']))
	{	
		include('common.php');
	}
	else
	{
		include('Languages/en.php');
		
	}

	
	
	$session_member_id = $_SESSION['SESS_MEMBER_ID'];
	$username = $_REQUEST['username'];
	include 'includes/time_stamp.php';		
		
		$sql = mysqli_query($con, "select * from members where username='".$username."'") or die(mysqli_error($con));
		$res = mysqli_fetch_array($sql);
		$member_id = $res['member_id'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<title>My Videos</title>
<head>

<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/wall.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/search.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/style.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/group.css"/>

<link rel="icon" href="<?php echo $base_url;?>images/favicon.ico" type="image" />
<link rel="shortcut icon" href="<?php echo $base_url;?>images/favicon.ico" type="image" />

<script src="<?php echo $base_url;?>js/jquery.min.js"></script>
<script src="<?php echo $base_url;?>js/jquery-1.9.1.js"></script>
<script src="<?php echo $base_url;?>js/check.js"></script>
<script src="<?php echo $base_url;?>js/youtube.js"></script>
    <script type="text/javascript" src="<?php echo $base_url;?>flowplayer/flowplayer.min.js"></script>
 <link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>flowplayer/skin/minimalist.css">
 <link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/youtube.css"/>


<body>
<div id="wrapper">
<?php 
include('includes/header.php');

?>
<div id="mainbody">

<div class="column_left">
<div class="componentheading">
    <div id="submenushead"><?php echo $res['username'];?>'s <?php echo  $lang['Videos'];?></div>
    </div>
    
    <ul class="submenu">    
   <li></li>
   <li><form id="searchbox" action="<?php echo $base_url;?>video_gallery_search.php" method="post">
        
    <input id="search" type="text" name="search" placeholder="<?php echo  $lang['Type here'];?>">
    <input class="submit" type="submit" value="<?php echo  $lang['Search'];?>">
</form></li>
	</ul>

<div class="popular_video">

<?php 
$pvsql = mysqli_query($con, "SELECT v.location, v.thumburl, v.title, v.video_id, v.date_created, v.view_count,v.url_type 
			FROM videos v LEFT JOIN members m ON m.member_id = v.user_id 
			WHERE v.user_id = '$member_id'") or die(mysqli_error($con));
if(mysqli_num_rows($pvsql) > 0)
{
?>
    <ul class="popular">
    <?php 

while($pvres = mysqli_fetch_array($pvsql))
{
	 $time = $pvres['date_created'];
?>

        <li class="popular_list" id="popular_list-<?php echo $pvres['video_id'];?>">
        <a href="<?php echo $base_url;?>watch.php?video_id=<?php echo $pvres['video_id'];?>" class="view_video" onclick="view_count()" id="<?php echo $pvres['video_id'];?>">
        <?php
    if($pvres['url_type'] == 1)
	{
	?>
    <img src="<?php echo $base_url.'uploadedvideo/videothumb/p200x150'.$pvres['thumburl'];?>" width="145" height="80" />
    <?php } 
	if($pvres['url_type'] == 2)
	{
		if (preg_match('![?&]{1}v=([^&]+)!', $base_url.$pvres['location'] . '&', $mr))
	$video_idr = $mr[1]; 
	$urlr = "http://img.youtube.com/vi/".$video_idr."/default.jpg";	
			
	?>
    <img src="<?php echo $base_url.$urlr;?>" width="145" height="80" />
    <?php 
	}
	
	?>
   </a>
<div class="video_Content">
<h3 class="video_title">
<a href="<?php echo $base_url;?>watch.php?video_id=<?php echo $pvres['video_id'];?>" class="view_video" id="<?php echo $pvres['video_id'];?>">
<?php echo $pvres['title'];?></a></h3>

<div class="video_data" style="padding:0 5px 5px 0;">
<span class="view_count"><?php echo $pvres['view_count'];?><?php echo  $lang['views'];?></span>
<span class="content_item_time"><?php echo time_stamp($time);?></span>
</div>

</div>
        
        </li>
        
        
<?php } ?>        
    </ul>
    <?php } 
	else
	{
		?>
        <div class="community-empty-list">No videos</div>
        <?php
	}
	?>
</div>

</div><!--End column left div-->
</div><!--End mainbody div-->

<?php include 'includes/footer.php';?>
</div><!--End wrapper div-->
</body>
</html>