<?php 
	require_once('common/common.php');

	
	$member_id = $_SESSION['SESS_MEMBER_ID'];
	$sql = mysqli_query($con, "select * from members where member_id='".$member_id."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);
	
	$group_id = $QbSecurity->qbClean($_REQUEST['group_id'], $con);
	if(!(empty($group_id )||($qbValidation->qbIntegerCheck($group_id ))))
	{
		$qb_err_msg="Oops Something Went Wrong...!";
$QbSecurity->qbErrorMessage($qb_err_msg,$homepage);
	}
	else
	{
	
	$gquery = "select name,ownerid from groups where id = '$group_id'";
	$gsql = mysqli_query($con, $gquery);
	$gres = mysqli_fetch_array($gsql);
	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<title><?php echo ucfirst($gres['name']);?></title>
<head>
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="icon" href="images/favicon.ico" type="image" />
<link rel="shortcut icon" href="images/favicon.ico" type="image" />

<link rel="stylesheet" type="text/css" href="css/format.css"/>
<link rel="stylesheet" type="text/css" href="css/search.css"/>
<link rel="stylesheet" type="text/css" href="css/dropdown.css"/>
<link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.css" />
<script src="js/jquery.livequery.js" type="text/javascript"></script>
<script src="js/jquery.oembed.js"></script>
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/wall.js"></script>
<script src="js/jquery.fastLiveFilter.js"></script>
<script type="text/javascript">
$(document).ready (function () {
	$('.remove').click (function () {
		return confirm ("<?php echo $lang['Are you sure you want to delete this friend'];?>?") ;
	}) ; 
}) ;

 $(function() {
        $('#search_input').fastLiveFilter('#border',{
			callback: function(total) { $('#num_results').html(total); }
		});
    });
</script>

</head>
<body>
<div id="wrapper">
<?php include('includes/header.php');?>
<div id="mainbody">
<div class="column_left">

<div class="componentheading">
    <div id="submenushead"><?php echo ucfirst($gres['name']);?> <?php echo $lang['Members'];?></div>
    </div>
    <div id="submenushead">
    <ul class="submenu">
    <li><a href="groups_wall.php?group_id=<?php echo $group_id;?>"><?php echo ucfirst($gres['name']);?></a></li>    
	</ul>
   </div>
   
<div class="cFilterBar_inner">

<div class="innerwrap">
<span class="uiSearchInput textinput">
<span>
<input type="text" id="search_input" placeholder="<?php echo $lang['search your friends'];?>" />
<button><span></span></button>
</span>
</span>
</div>
<div style="border-bottom:1px solid rgb(204, 204, 204); padding:10px 5px; padding-bottom:10px;"><?php echo $lang['search found'];?>: <span id="num_results" style="font-weight:bold;"></span></div>
</div>

<div id="border">
<?php 
	$gmquery = "select m.member_id,m.username,m.profImage 
				from groups_members gm inner join members m 
				ON gm.member_id=m.member_id 
				where gm.approved != 0
				and gm.groupid = '".$group_id."'";
				
	$gmsql = mysqli_query($con, $gmquery);
	if(mysqli_num_rows($gmsql) > 0)
	{
	while($clicks_res = mysqli_fetch_array($gmsql))
	{
?>
        
<div class="mini-profile">
<div class="mini-profile-avatar">
<a href="<?php echo $base_url.$clicks_res['username'];?>" title="<?php echo $clicks_res['username'];?>"><img src="<?php echo $clicks_res['profImage'];?>" width="68" height="68" /></a>
</div>
<div class="mini-profile-details">
<h3 style="font-size:120%;"><a href="<?php echo $base_url.$clicks_res['username'];?>" title="<?php echo $clicks_res['username'];?>"><strong><?php echo ucfirst($clicks_res['username']);?></strong></a></h3>
<div class="mini-profile-details-status"></div>
<div class="mini-profile-details-action">
<?php 
if($gres['ownerid'] == $clicks_res['member_id'] or $gres['ownerid'] == $member_id)
{
?>
<a class="remove" href="action/delete_group_member.php?member_id=<?php echo $clicks_res['member_id'];?>" title="<?php echo $lang['Remove Friend'];?>" ></a>

<?php } ?>
</div>
</div>

</div><!--end mini profile-->
<?php } }
else
{
?>
<div class="community-empty-list" style="width: 300px;float: left;margin: 20px 20px 20px 0px;">
<?php echo $lang['No friends'];?>
</div>
<?php } ?>
</div><!--end border-->

</div><!--end column_left div-->

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
        <div style="font-size: 12px;padding: 0 5px 5px;line-height: 13px; float:left !important">
        <?php echo $lang['ad body goes here'];?>...<?php echo $lang['ad body goes here'];?>...<?php echo $lang['ad body goes here'];?>...<?php echo $lang['ad body goes here'];?>...
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
       <?php echo $lang['ad body goes here'];?>...<?php echo $lang['ad body goes here'];?>...<?php echo $lang['ad
        body goes here'];?>...<?php echo $lang['ad body goes here'];?>...
        </div>
        <div style="float:left"><img src="images/6.jpg" /></div>
          <div style="float: left;width: 18%;color: #005689;cursor: pointer;position: relative;top: 2px;margin-left: 10px;"><?php echo $lang['Like'];?>        </div>
        </div>
        <?php //@readfile('http://output63.rssinclude.com/output?type=php&id=731231&hash=d8599a7081893730dd46d6627357163f')?>
	</div><!--end column_right div-->
</div><!--end mainbody div-->
<?php include 'includes/footer.php';?>
</div>
<?php } ?>
<!--end wrapper div-->
</body>
</html>