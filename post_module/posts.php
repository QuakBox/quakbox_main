<?php 
	
	require_once('common/common.php');
	
	$member_id = $QbSecurity->qbClean($_SESSION['SESS_MEMBER_ID'], $con);
        
        if(isset($_GET['notid']))
        {
        $notificationid=$_GET['notid'];
	$updatesql = "UPDATE notifications SET notifications.is_unread=1 where notifications.id=$notificationid";
	$runupdatesql = mysqli_query($con, $updatesql) or die(mysqli_error($con));
        }

	$msg_id = $_REQUEST['id'];
	if(!(empty($msg_id )||($qbValidation->qbIntegerCheck($msg_id))))
	{
            $qb_err_msg="Oops Something Went Wrong...!";
            $QbSecurity->qbErrorMessage($qb_err_msg,$homepage);
	}
	else
	{
	$msg_id = $QbSecurity->qbClean($_REQUEST['id'], $con);
	$msg_id=htmlspecialchars(trim($msg_id));
	$sql = mysqli_query($con, "select * from members where member_id='".$member_id."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);
	
	$msql = mysqli_query($con, "SELECT msg.messages_id, msg.messages, msg.date_created, msg.type, msg.wall_privacy, 				                                                  m.member_id,msg.msg_album_id, m.profImage, msg.country_flag,
	                     u.upload_data_id,msg.share
		                 , msg.share_by,m.username,msg.share_msg,
						 v.location,v.location1,v.location2, v.thumburl, v.title, v.video_id, v.description,
 			             v.msg_id, v.category, v.title_color,v.title_size,v.ads,a.ads_name,
				         a.location as adslocation,a.location1 as adslocation1,a.location2 as adslocation2, a.click_url
		                 FROM message msg 
						 INNER JOIN members m ON msg.member_id = m.member_id 
		                 LEFT JOIN upload_data u on msg.messages_id = u.msg_id
						 LEFT JOIN videos v ON v.msg_id = msg.messages_id
						 LEFT JOIN videos_ads a ON v.ads_id = a.id		  		  
		                 WHERE msg.messages_id = '$msg_id'") or die(mysqli_error($con));
    $mres = mysqli_fetch_array($msql);
	
	/*if(mysqli_num_rows($msql) == 0 || (!isset($msg_id))) {
		header('location:error.html');
	}*/

?>








<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-jp">
<title>QuakBox</title>
<meta name="description" content="<?php if($mres['type'] == 0) { echo substr($mres['messages'],0,150); }if($mres['type'] == 2){ echo substr($mres['description'],0,150); }?>" />
<!-- Twitter Card data -->
<meta name="twitter:card" content="summary">
<meta name="twitter:site" content="@qb">
<meta name="twitter:title" content="QuakBox">
<meta name="twitter:description" content="<?php if($mres['type'] == 0) { echo substr($mres['messages'],0,150); }if($mres['type'] == 2){ echo substr($mres['description'],0,150); }?>">
<meta name="twitter:creator" content="@omkar">
<!-- Twitter Summary card images must be at least 200x200px -->
<meta name="twitter:image" content="<?php if($mres['type'] == 1) { echo $base_url.$mres['messages']; }if($mres['type'] == 2) {echo $base_url.'uploadedvideo/videothumb/p200x150'.$mres['thumburl'];}?>">
<!-- Open Graph data --> 
<meta property="og:title" content="Quakbox">
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<meta property="og:image" content="<?php if($mres['type'] == 1) { echo $base_url.$mres['messages']; }if($mres['type'] == 2) {echo $base_url.'uploadedvideo/videothumb/p200x150'.$mres['thumburl'];}?>">
<meta property="og:description" content="<?php if($mres['type'] == 0) { echo substr($mres['messages'],0,150); }if($mres['type'] == 2){ echo substr($mres['description'],0,150); }?>">

<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css" />
<link rel="stylesheet" type="text/css" href="css/jquery-ui.css"/>

<script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
<script src="sjs/jquery.min.js"></script>

<?php //include('includes/files.php');?>
</head>
    
    

<body onload="onLoad();">
<div id="wrapper">


<?php include('includes/qb_header.php'); ?>



<div class="row" style="padding:5px; margin:3px ; margin-top: 15px;">   
     
    
    
    
    
    <div class="col-md-3 hidden-xs">
        <div class="panel panel-primary" style="height: 200px;border: 0px">
          <div class="panel-heading" style="height: 20px;padding: 1px;">Video</div>
          <div class="panel-body">...</div>
        </div>  
        
        <div class="panel panel-info" style="height: 200px; border: 0px">
          <div class="panel-heading" style="height: 20px;padding: 1px;">Popular on QuakBox</div>
          <div class="panel-body">...</div>
        </div> 
        
        <div class="panel panel-default" style="height: 200px; border: 0px">
          <div class="panel-heading" style="height: 20px;padding: 1px;">Apps</div>
          <div class="panel-body">...</div>
        </div>
        
        <div class="panel panel-warning" style="height: 200px; border: 0px">
          <div class="panel-heading" style="height: 20px;padding: 1px;">Games</div>
          <div class="panel-body">
              ...
          </div>
        </div>
        
    </div>
    
    
    
    
    
    
    
    
    <div class="col-md-6" >
        
    <?php
    require_once('qb_widgets/posts.php');
    $postWidgetObjHome=new postWidget();
    print $postWidgetObjHome->getPostById($_REQUEST['id']);
    ?>
        
    </div>


    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
<div class="col-md-2 hidden-xs"  style="float: right !important;">
    <?php include($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/ads.php');?></div>

 </div>

    
    <!--end wrapper div-->

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
    <h3 class="app-box-title">Don't Share this with</h3>
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
<?php include 'includes/qb_footer.php';?>
</div>
    



</body>
</html>






<?php 
}
?>
