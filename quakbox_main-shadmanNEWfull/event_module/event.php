<?php 
//error_reporting(E_ALL);
	session_start();
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
<title>Event</title>
<head>
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="icon" href="images/favicon.ico" type="image" />
<link rel="shortcut icon" href="images/favicon.ico" type="image" />
<script src="js/jquery.min.js"></script>
<script src="js/jquery-1.9.1.js"></script>
<script src="js/ibox.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery-ui.css" />
<script src="js/jquery-ui.js"></script>
<script type="text/javascript">
$(function() {
 $("#member_name").autocomplete({
	 source: "load_data/member_names_ajax.php",			
			select: true
 });
});

//add as a friend
$("#cancel_request").click()
{
	$("#myform1").hide();
}
</script>

</head>
<body>
<div id="wrapper">
<?php include('includes/header.php');
$id = $_REQUEST['id'];
$equery = "SELECT e.event_name, e.event_location, e.date_created, e.event_host
			FROM event e LEFT JOIN members m ON e.event_host = m.member_id 
			WHERE e.id = '$id'";
$esql = mysqli_query($con, $equery) or die(mysqli_error($con));
$eres = mysqli_fetch_array($esql);
?>
<div id="mainbody">
<div class="column_left">
	
    <div class="componentheading">
    <div id="submenushead">Search People</div>
    </div>
    <div id="submenushead">
   <ul class="submenu">
    <li><a href="create_event.php">Event</a></li>    
    <li><a href="#">Invite members</a></li>
  	<li><a href="#">Edit</a></li>   
	</ul>
   </div>

<div class="column_internal_right">
<div style="margin-top:5px">
<strong>Going</strong>
</div>
<?php 
$emquery = "SELECT m.member_id, m.username, m.LastName, m.profImage
			FROM event_members em LEFT JOIN members m ON em.member_id = m.member_id
			WHERE em.event_id = '$id'";
$emsql = mysqli_query($con, $emquery) or die(mysqli_error($con));
while($emres = mysqli_fetch_array($emsql))
{

?>
<div style="height:50px; margin-top:10px;">
<a href="" style="float:left;">
<img src="<?php echo $emres['profImage'];?>" height="32" width="32" />
</a>
<div style="margin-left:37px;">
<a href="">
<?php echo $emres['username'];?>
</a>
</div>
</div>
<?php }?>
</div>
</div><!--end column_left div-->

</div><!--end mainbody div-->
<?php include 'includes/footer.php';?>
</div><!--end wrapper div-->


</body>
</html>