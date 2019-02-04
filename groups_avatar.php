<?php 
	session_start();
	require_once('config.php');
	$member_id = $_SESSION['SESS_MEMBER_ID'];
	$group_id = $_REQUEST['group_id'];
	if(isset($_SESSION['lang']))
	{	
		include('common.php');
	}
	else
	{
		include('Languages/en.php');
		
	}
	if(!isset($_SESSION['SESS_MEMBER_ID']))
	{
		header("location: ".$base_url."login.php?back=". urlencode($_SERVER['REQUEST_URI']));
		exit();
	}
	
	$sql = mysqli_query($con, "select * from members where member_id='".$member_id."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<title><?php echo $lang['Upload Group Avatar'];?></title>
<head>
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="icon" href="images/favicon.ico" type="image" />
<link rel="shortcut icon" href="images/favicon.ico" type="image" />

<link rel="stylesheet" type="text/css" href="css/format.css"/>
<link rel="stylesheet" type="text/css" href="css/search.css"/>
<link rel="stylesheet" type="text/css" href="css/dropdown.css"/>
<script src="js/jquery.livequery.js" type="text/javascript"></script>
<script src="js/jquery.oembed.js"></script>
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/jquery-1.7.2.min.js"></script>
<style type="text/css">
.group_created
{
	    border-left: 1px solid rgb(148, 163, 196);
    border-right: 1px solid rgb(148, 163, 196);
    bottom: 4px;
    float: left;
    padding-bottom: 5px;
    padding-left: 5px;
    padding-top: 20px;
    position: relative;
    min-height: 400px;
    width: 780px;
}
 .cModule, .community-events-results-item, .community-groups-results-item, body #community-wrap .album .album, body #community-wrap .video-item .video-item {
    border-radius: 0px 0px 0px 0px;
    margin: 0px auto;
    border: medium none;
}
 .cModule
 {
	 padding:5px;
	 position:relative;
 }
</style>
</head>
<body>
<div id="wrapper">
<?php include('includes/header.php');?>
<div id="mainbody">
	<div class="componentheading">
    <div id="submenushead"><?php echo $lang['Upload Group Avatar'];?></div>
    </div>
    <div id="submenushead">
    <ul class="dropDown">
    <li style="padding:0 8px;"><a href="groups_wall.php?group_id=<?php echo $group_id;?>"><?php echo $lang['Back to group'];?></a></li>
   	</ul>
   </div>

<div class="cModule_whole" style=" 
	border-left: 1px solid #94A3C4;
    border-right: 1px solid #94A3C4;
    bottom: 4px;
    float: left;
    margin: 0;
    padding: 0;
    position: relative;
    width: 785px;
}">
<div class="cModule">
	<p class="info" style="float: left; width: 75%; margin:1em 0px;"><?php echo $lang['Below is the current group avatar. You will be able to edit your own group avatar'];?>.</p>
	<form name="jsform-groups-uploadavatar" action="action/groups_avatar-exec.php" method="post" enctype="multipart/form-data">
	   	<input type="file" name="filedata" size="40" class="button" />		
	    <input type="submit" value="UPLOAD" class="button" />
	    <input type="hidden" name="groupid" value="<?php echo $group_id; ?>" />
	    <input type="hidden" name="action" value="avatar"/>
	</form>
	<p class="info"><?php echo $lang['Maximum file size for upload is'];?> <b>10MB</b></p>
</div>

<div class="cModule avatarPreview leftside">
	<h3><?php echo $lang['Large Avatar'];?></h3>
	<p><?php echo $lang['Automatically generated'];?>. (maximum width 160px)</p>
	<img src="images/groupAvatar.png.jpg" alt="" border="0" />
</div>

<div class="cModule avatarPreview rightside">
	<h3><?php echo $lang['Thumbnail Avatar'];?></h3>
	<p><?php echo $lang['Automatically generated'];?>. (64px x 64px)</p>
	<img src="images/groupThumbAvatar.jpg" alt="" border="0" />
</div>
</div>

</div><!--end main body-->
<?php include 'includes/footer.php';?>
</div><!--end wrapper div-->
</div>
</body>
</html>