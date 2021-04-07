<?php 
	session_start();
	require_once('config.php');
	$member_id = $_SESSION['SESS_MEMBER_ID'];
	$sql = mysqli_query($con, "select * from members where member_id='".$member_id."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<title>Search People</title>
<head>
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="icon" href="images/favicon.ico" type="image" />
<link rel="shortcut icon" href="images/favicon.ico" type="image" />

<link rel="stylesheet" type="text/css" href="css/format.css"/>
<link rel="stylesheet" type="text/css" href="css/search.css"/>
<link rel="stylesheet" type="text/css" href="css/dropdown.css"/>
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript">
$(document).ready (function () {
	$('.add_friend').click (function () {
		return confirm ("Are you sure you want to add this friend?") ;
	}) ; 
}) ;
</script>
</head>
<body>
<div id="wrapper">
<?php include('includes/header.php');?>
<div id="mainbody">
<div class="column_left">

    <div class="componentheading">
    <div id="submenushead">Request</div>
    </div>
    
<?php 
$friend_request = mysqli_query($con, "select m.username,m.member_id,m.profImage,f.added_member_id from friendlist f,members m where f.member_id=m.member_id and f.status = 0 and f.member_id = '".$_SESSION['SESS_MEMBER_ID']."' and f.request_status = 1");

while($request_res = mysqli_fetch_array($friend_request))
{
	$add_friend1 =mysqli_query($con, "select * from friendlist where added_member_id = '".$request_res['member_id']."'");
	$request_count = mysqli_num_rows($add_friend1);	
?>
<div class="mini-profile">

<div class="mini-profile-avatar">
<a href="member_profile.php?member_id=<?php echo $request_res['member_id'];?>" title="<?php echo $request_res['username'];?>"><img src="<?php echo $request_res['profImage'];?>" width="68" height="68" /></a>
</div>
<div class="mini-profile-details">
<h3 style="font-size:120%;"><a href="member_profile.php?member_id=<?php echo $request_res['member_id'];?>" title="<?php echo $request_res['username'];?>"><strong><?php echo $request_res['username'];?></strong></a></h3>
</div>
<div class="mini-profile-details-status"></div>
<div class="mini-profile-details-action">
<span class="icon-group"><?php echo $request_count;?>Friends</span>
<a href="#"><span class="icon-write">Write Message</span></a>


<a href="action/accept_request.php?member_id=<?php echo $request_res['added_member_id'];?>" class="add_friend"><span class="icon-add-friend">Confirm</span></a>
</div>
<?php	
}

?>

</div><!--end column_left div-->

<!--Start column right-->
<div class="column_right">
   <div id="ads" style="width:220; float:left;">
   <h3>Partners
   <a href="add_ads.php" style="margin-left:55px;">Create Ads</a>   
   </h3>
   </div>
		<div style="border-bottom: 1px solid #DDDDDD;float: left;margin: 0px;padding-top: 0px;width: 220px;">
        <div style="font-size: 13px;font-weight: bold;padding: 5px 0;color: #005689;">
        <a href="">ad title goes here</a>
        </div>
        <div style="float: left;padding-right: 8px;">
        <a href="" target="_blank">
        <img src="images/add1_1317138137.jpg"/>
        </a>
        </div>
        <div style="font-size: 12px;padding: 0 5px 5px;line-height: 13px; float:left !important">
        ad body goes here...ad body goes here...ad body goes here...ad body goes here...
        </div>
        <div style="float:left"><img src="images/6.jpg" /></div>
          <div style="float: left;width: 18%;color: #005689;cursor: pointer;position: relative;top: 2px;margin-left: 10px;">Like        </div>
        </div>
        <div style="border-bottom: 1px solid #DDDDDD;float: left;margin: 0px;padding-top: 0px;width: 220px;">
        <div style="font-size: 13px;font-weight: bold;padding: 5px 0;color: #005689;">
        <a href="">ad title goes here</a>
        </div>
        <div style="float: left;padding-right: 8px;">
        <a href="" target="_blank">
        <img src="images/add1_1317138137.jpg"/>
        </a>
        </div>
         <div style="font-size: 12px;padding: 0 5px 5px;line-height: 13px; float:left !important">
        ad body goes here...ad body goes here...ad body goes here...ad body goes here...
        </div>
        <div style="float:left"><img src="images/6.jpg" /></div>
          <div style="float: left;width: 18%;color: #005689;cursor: pointer;position: relative;top: 2px;margin-left: 10px;">Like        </div>
        </div>
        <?php //@readfile('http://output63.rssinclude.com/output?type=php&id=731231&hash=d8599a7081893730dd46d6627357163f')?>
	</div><!--end column_right div-->
</div><!--end mainbody div-->
<?php include 'includes/footer.php';?>
</div><!--end wrapper div-->
</body>
</html>