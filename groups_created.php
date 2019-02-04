<?php 
	session_start();
	require_once('config.php');
	$member_id = $_SESSION['SESS_MEMBER_ID'];
	$group_id = $_REQUEST['group_id'];
	if(!isset($_SESSION['SESS_MEMBER_ID']))
	{
		header("location: ".$base_url."index.php");
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
	$sql = mysqli_query($con, "select * from groups where id='".$group_id."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<title><?php echo $res['name'];?></title>
<head>
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="icon" href="images/favicon.ico" type="image" />
<link rel="shortcut icon" href="images/favicon.ico" type="image" />

<link rel="stylesheet" type="text/css" href="css/group.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>font-awesome/css/font-awesome.css">
<script src="js/jquery.livequery.js" type="text/javascript"></script>
<script src="js/jquery.oembed.js"></script>
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/jquery-1.7.2.min.js"></script>

</head>
<body>
<div id="wrapper">
<?php include('includes/header.php');?>
<div id="mainbody">
<div class="column_left">
	
    <div class="componentheading">
    <div id="submenushead"><?php echo $res['name'];?></div>
    </div>
    <div id="submenushead">
    <ul class="dropDown">
    <li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="groups_all.php"><?php echo $lang['All Groups'];?></a></li>
    <li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="groups.php"><?php echo $lang['My Groups'];?></a></li>
    <li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href=""><?php echo $lang['Pending Invitations'];?></a></li>
  	<li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="create_groups.php"><?php echo $lang['Create'];?></a></li>
    <li style="padding:0 8px;"><a href="groups_search.php"><?php echo $lang['Search'];?></a></li>    
	</ul>
   </div>

<div class="group_created">
<div class="empty-message" style=" float:left; width:710px;">
<?php echo $lang["Congratulations! You have created a new group. Here's what you can do with your group"];?>
</div>
<ul class="linklist" style="float:left; list-style:none;">
    <li class="upload_avatar"> <a href="groups_avatar.php?group_id=<?php echo $group_id;?>"><?php echo $lang['Upload a new avatar for your group'];?></a> </li>    
    <li class="group_edit"> <a href="edit_groups.php?group_id=<?php echo $group_id;?>"><?php echo $lang['Edit your group details'];?> </a></li>
    <li class="group_view"> <a href="groups_wall.php?group_id=<?php echo $group_id;?>"><?php echo $lang['View your group now'];?> . </a> </li>
</ul>
</div>

</div><!--end column_left div-->
<!--Start column right-->
<?php include 'ads_right_column.php';?>
<!--end column_right div-->
</div><!--end mainbody div-->
<?php include 'includes/footer.php';?>
</div><!--end wrapper div-->
</body>
</html>