<?php
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php'); 	 
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');
	//require_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_lookup.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_header.php');
	
	$objMember = new member1(); 
	$lookupObject = new lookup(); 
	if(!isset($_SESSION['SESS_MEMBER_ID']))
	{	
		header("location: ".$base_url."login.php?back=". urlencode($_SERVER['REQUEST_URI']));
		exit();
	}

	$member_id = $_SESSION['SESS_MEMBER_ID'];
	$sql = mysqli_query($con, "select * from member where member_id='".$member_id."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);
?>
<?php /*?><link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="icon" href="images/favicon.ico" type="image" />
<link rel="shortcut icon" href="images/favicon.ico" type="image" />
<link rel="stylesheet" type="text/css" href="css/bootstrap-reset.css" />
<link rel="stylesheet" type="text/css" href="css/format.css"/>
<link rel="stylesheet" type="text/css" href="css/search.css"/>
<link rel="stylesheet" type="text/css" href="css/dropdown.css"/>
<link rel="stylesheet" type="text/css" href="css/responsive.css" />
<link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.css" /><?php */?>
<script src="js/jquery-1.9.1.js"></script>
<script src="<?php echo $base_url;?>js/check.js"></script>
<div class="insideWrapper container">
    <div class="col-lg-9 col-md-9 col-sm-8">

	<div class="column_internal_left" style="width:90%;">

    <div class="componentheading">

    <div id="submenushead"><?php echo $lang['Pending Request'];?></div>

    </div>

    <div id="submenushead">

   <ul class="submenu">

    <!--<li style="font-size: 15px;"><a href="friends.php?friend_id=<?php //echo $member_id;?>"><?php //echo $lang['Show all'];?></a></li>

    <li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="find_friend.php">Search</a></li>-->

    <li style="font-size: 15px;"><a href="find_friend_advanced.php"><?php echo $lang['Advanced Search'];?></a></li>

  	<li style="font-size: 15px;"><a href="invite_friends.php"><?php echo $lang['Invite Friends'];?></a></li>

    <li style="font-size: 15px;"><a href="request_sent.php"><?php echo $lang['Request Sent'];?></a></li>

    <li style="font-size: 15px;"><a href="pending_request.php" style="border-right:none;"><?php echo $lang['Pending my approval'];?></a></li>

	</ul>

   </div>



<div id="border">

<?php 
	$clicks = mysqli_query($con, "select * from friendlist f INNER JOIN member m ON f.added_member_id = m.member_id where f.member_id = '".$member_id."' and f.status=0") or die(mysqli_error($con));

	$count = mysqli_num_rows($clicks);
?>
<input type="hidden" id="count" value="<?php echo $count;?>" />
<?php
	if($count)

	{

	while($clicks_res = mysqli_fetch_array($clicks))

	{
	
	$media = $objMember->select_member_meta_value($clicks_res['member_id'],'current_profile_image');
if(!$media)
$media = "images/default.png";
$media=$base_url.$media;

?>

        

<div class="mini-profile" id="mini-profile<?Php echo $clicks_res['member_id'];?>">

<div class="mini-profile-avatar">

<a href="<?php echo $base_url.$clicks_res['username'];?>" title="<?php echo $clicks_res['username'];?>"><img src="<?php echo $media;?>" width="68" height="68" /></a>

</div>

<div class="mini-profile-details">

<h3 style="font-size:120%;"><a href="<?php echo $base_url.$clicks_res['username'];?>" title="<?php echo $clicks_res['username'];?>"><strong><?php echo $clicks_res['username'];?></strong></a></h3>

<div class="mini-profile-details-status"></div>

<div class="mini-profile-details-action">

<div style="float:right" id="fri<?Php echo $clicks_res['member_id'];?>" data-id="<?Php echo $clicks_res['member_id'];?>">

<div style="display:inline;"><input type="button" name="accept_request" value="<?Php echo $lang['confirm'];?>" id="<?Php echo $clicks_res['member_id'];?>" 
        class="accept_request" onclick="location.href='<?php  echo $base_url."action/accept_request.php?member_id=".$clicks_res['member_id']; ?>';"></div>
		

		
        <div style="display:inline;"><input type="button" name="cancel_request" value="<?Php echo $lang['not now'];?>" id="<?Php echo $clicks_res['member_id'];?>" class="cancel_request"></div>

</div>
<div style="display:none; float:right" id="friend<?Php echo $clicks_res['member_id'];?>">
        <input type="button" name="accept_request" value="friends" class="friends">
        </div>




</div>

</div>

</div>



<?php } ?>



<?php }

else

{

?>

<div class="community-empty-list" style="width: 465px;margin-top: 60px;margin-left: 66px;">

<?Php echo $lang['You have no pending approval'];?>

</div>



<?php }?>
<div class="community-empty-list" style="width: 465px;margin-top: 60px;margin-left: 66px;display:none;" id="community">

<?Php echo $lang['You have no pending approval'];?>

</div>

</div><!--end border div-->

</div><!--end column_internal_left div-->



</div><!--end column_left div-->

<!--Start column right-->
    <div class="col-lg-2 col-md-3 col-sm-3 hidden-xs"> 
        <div style="" class="adsQBxzqw"> <?php include($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/ads.php');?></div>
    </div>
<!--end column_right div-->

</div><!--end mainbody div-->
<?php
	include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_footer.php');
?>

</html>