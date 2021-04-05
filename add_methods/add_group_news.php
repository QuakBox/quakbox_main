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
	$sql = mysqli_query($con, "select * from groups where id='".$group_id."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<title><?php echo $lang['Add Group News'];?></title>
<head>
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="icon" href="images/favicon.ico" type="image" />
<link rel="shortcut icon" href="images/favicon.ico" type="image" />

<link rel="stylesheet" type="text/css" href="css/group.css"/>

</head>
<body>
<div id="wrapper">
<?php include('includes/header.php');?>
<div id="mainbody">
<div class="column_left">
	
    <div class="componentheading">
    <div id="submenushead"><?php echo $lang['Add Group News'];?></div>
    </div>
    <div id="submenushead">
    <ul class="dropDown">
    <li style="border-left:1px solid #C2CDDE; padding:0 8px;"><a href="view_groups.php?group_id=<?php echo $group_id;?>"><?php echo $lang['Back to Group'];?></a></li>
   <!-- <li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="groups.php"><?php echo $lang['My Groups'];?></a></li>
    <li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href=""><?php echo $lang['Pending Invitations'];?></a></li>
  	<li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="create_groups.php"><?php echo $lang['Create'];?></a></li>
    <li style="padding:0 8px;"><a href="groups_search.php"><?php echo $lang['Search'];?></a></li> -->   
	</ul>
   </div>
<div id="border">
<form name="find_friend" id="find_friend" action="action/add_news-exec.php" method="post">
<input type="hidden" name="member_id" id="member_id" value="<?php echo $member_id;?>" />
<input type="hidden" name="group_id" id="group_id" value="<?php echo $group_id;?>" />

<table class="formtable">
<tbody>
<tr>
<td colspan="2"></td>
</tr>
<tr>
<td style="font-weight: bold;text-align: right;width: 130px; padding:5px;vertical-align:top;">
<label style="font-weight: 700;text-align: right;">*<?php echo $lang['News Title'];?></label>
</td>
<td style="padding:5px; vertical-align:top;"><input id="title" class="required inputbox" type="text" value="" size="40" name="title" style="width:90%;"></td>
</tr>
<tr>
<td style="font-weight: bold;text-align: right;width: 130px; padding:5px;vertical-align:top;">
<label style="font-weight: 700;text-align: right;">*<?php echo $lang['News Description'];?></label>
</td>
<td style="padding:5px; vertical-align:top;"><textarea style="rgb(255, 0, 0) !important; width:95%; height:450px;" id="name" class="required inputbox" type="text" value="" size="45" name="desciption"></textarea></td>
</tr>

    <tr>
<td style="font-weight: bold;text-align: right;width: 130px; padding:5px;vertical-align:top;">
</td>
<td style="padding:5px; vertical-align:top;"><span style="font-style:italic; line-height:140%;"><?php echo $lang['Fields marked with an asterisk (*) are required'];?>.</span></td>
</tr>
<tr>
<td colspan="2"></td>
</tr>
    <tr>
<td style="font-weight: bold;text-align: right;width: 130px; padding:5px;vertical-align:top;">
</td>
<td style="padding:5px; vertical-align:top;">
<input type="hidden" value="save" name="action"></input>
<input type="hidden" value="" name="groupid"></input>
<input class="button validateSubmit" type="submit" value="ADD NEWS"></input>
<input class="button" type="button" value="CANCEL" onclick="history.go(-1);return false;"></input>
<input type="hidden" value="1" name="326e4f73c340f29d8ce547ad40dc0e1b"></input>
</td>
</tr>
<tr>
</tbody>
</table>
</div>

</div><!--end column_left div-->
<br />
<!--Start column right-->
<div class="column_right">
   <div id="ads" style="width:220; float:left;">
   <h3><?php echo $lang['Partners'];?>
   <a href="add_ads.php" style="margin-left:55px;"><?php echo $lang['Create Ads'];?></a>   
   </h3>
   </div>
		<div style="border-bottom: 1px solid #DDDDDD;float: left;margin: 0px;padding-top: 0px;width: 220px;">
        <div style="font-size: 13px;font-weight: bold;padding: 5px 0;color: #005689;">
        <a href=""><?php echo $lang['ad title goes here'];?></a>
        </div>
        <div style="float: left;padding-right: 8px;">
        <a href="" target="_blank">
        <img src="images/add1_1317138137.jpg"/>
        </a>
        </div>
        <div style="font-size: 12px;padding: 0 5px 5px;line-height: 13px; float:left !important"><?php echo $lang['ad body goes here'];?>
        ...<?php echo $lang['ad body goes here'];?>...<?php echo $lang['ad body goes here'];?>...<?php echo $lang['ad body goes here'];?>...
        </div>
        <div style="float:left"><img src="images/6.jpg" /></div>
          <div style="float: left;width: 18%;color: #005689;cursor: pointer;position: relative;top: 2px;margin-left: 10px;"><?php echo $lang['Like'];?>        </div>
        </div>
        <div style="border-bottom: 1px solid #DDDDDD;float: left;margin: 0px;padding-top: 0px;width: 220px;">
        <div style="font-size: 13px;font-weight: bold;padding: 5px 0;color: #005689;">
        <a href=""><?php echo $lang['ad title goes here'];?></a>
        </div>
        <div style="float: left;padding-right: 8px;">
        <a href="" target="_blank">
        <img src="images/add1_1317138137.jpg"/>
        </a>
        </div>
         <div style="font-size: 12px;padding: 0 5px 5px;line-height: 13px; float:left !important">
        <?php echo $lang['ad body goes here'];?>
        ...<?php echo $lang['ad body goes here'];?>...<?php echo $lang['ad body goes here'];?>...<?php echo $lang['ad body goes here'];?>...
        </div>
        <div style="float:left"><img src="images/6.jpg" /></div>
          <div style="float: left;width: 18%;color: #005689;cursor: pointer;position: relative;top: 2px;margin-left: 10px;"><?php echo $lang['Like'];?>        </div>
        </div>
        <?php //@readfile('http://output63.rssinclude.com/output?type=php&id=731231&hash=d8599a7081893730dd46d6627357163f')?>
	</div><!--end column_right div-->
</div><!--end mainbody div-->
<?php include 'includes/footer.php';?>
</div><!--end wrapper div-->
</body>
</html>