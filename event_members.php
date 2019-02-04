<?php 
	session_start();
	//error_reporting(0);
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
	
	require_once('config.php');
	$member_id = $_SESSION['SESS_MEMBER_ID'];
	if(!isset($_SESSION['SESS_MEMBER_ID']))
	{
		header("location: ".$base_url."index.php");
		exit();
	}
	$sql = mysqli_query($con, "select * from members where member_id='".$member_id."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<title><?php echo $lang['Events'];?></title>
<head>
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="icon" href="images/favicon.ico" type="image" />
<link rel="shortcut icon" href="images/favicon.ico" type="image" />
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>font-awesome/css/font-awesome.css">
<script src="js/jquery.min.js"></script>
<script src="js/jquery-1.9.1.js"></script>
<script src="js/ibox.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery-ui.css" />
<script src="js/jquery-ui.js"></script>


</head>
<body>
<div id="wrapper">
<?php include('includes/header.php');
$id = $_REQUEST['id'];
$equery = "SELECT e.event_name, e.event_location, e.date_created, e.event_host,
			m.username, m.LastName, e.id, e.datepicker, e.cover, e.event_description
			FROM event e LEFT JOIN members m ON e.event_host = m.member_id 
			WHERE e.id = '$id'";
$esql = mysqli_query($con, $equery) or die(mysqli_error($con));
$eres = mysqli_fetch_array($esql);
?>
<div id="mainbody">
<div class="column_left">

	
    <div class="componentheading">
    <div id="submenushead" style="padding-top:0px;"><?php echo $eres['event_name'];?></div>    
    <div id="submenushead" style="padding-top:0px;"><?php echo $lang['Event for'];?> <?php echo $eres['event_name'];?> <?php echo $lang['By'];?> <?php echo $eres['username']." ".$eres['LastName'];?></div>
    </div>
    <div id="submenushead">
   <ul class="submenu">
    <li><a href="event_view.php?id=<?php echo $id;?>"><?php echo $lang['Events'];?></a></li>    
      
	</ul>
   </div>

<div style="margin-top:5px">
<?php 
$emquery = "SELECT m.member_id, m.username, m.LastName, m.profImage
			FROM event_members em LEFT JOIN members m ON em.member_id = m.member_id
			WHERE em.event_id = '$id' order by em.id DESC";
$emsql = mysqli_query($con, $emquery) or die(mysqli_error($con));
?>
<strong><?php echo $lang['Event members'];?> (<?php echo mysqli_num_rows($emsql);?>) </strong>
</div>
<?php 
while($emres = mysqli_fetch_array($emsql))
{

?>
<div style="height:35px; margin-top:10px;">
<a href="member_profile.php?member_id=<?php echo $emres['member_id'];?>" style="float:left;">
<img src="<?php echo $emres['profImage'];?>" height="32" width="32" />
</a>
<div style="margin-left:37px;">
<a href="member_profile.php?member_id=<?php echo $emres['member_id'];?>">
<?php echo $emres['username']." ".$emres['LastName'];?>
</a>
</div>
</div>
<?php }?>
</div>


</div><!--end column_left div-->

</div><!--end mainbody div-->
<?php include 'includes/footer.php';

?>
</div><!--end wrapper div-->


</body>
</html>