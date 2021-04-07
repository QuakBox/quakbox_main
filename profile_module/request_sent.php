<?php
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php'); 	 
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');
	//require_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_lookup.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_header.php');
	$objMember = new member1(); 
	$lookupObject = new lookup(); 

	$member_id = $QbSecurity->qbClean($_SESSION['SESS_MEMBER_ID'], $con);

	if(!isset($_SESSION['SESS_MEMBER_ID']))
	{
		header("location: ".$base_url."index.php");
		exit();
	}

	$sql = mysqli_query($con, "select * from member where member_id='".$member_id."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);

?>
<?php /*?><link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="icon" href="images/favicon.ico" type="image" />
<link rel="shortcut icon" href="images/favicon.ico" type="image" />
<link rel="stylesheet" type="text/css" href="css/format.css"/>
<link rel="stylesheet" type="text/css" href="css/search.css"/>
<link rel="stylesheet" type="text/css" href="css/dropdown.css"/><?php */?>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>assets/jquery-alert-dialogs/css/jquery.alerts.css"/>
<script src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>assets/jquery-alert-dialogs/js/jquery.alerts.js"></script>
<?php /*?><link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css" />
<link rel="stylesheet" type="text/css" href="css/responsive.css" />
<link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.css" />
<link rel="stylesheet" type="text/css" href="css/bootstrap-reset.css" /><?php */?>
<script src="js/bootstrap.min.js"></script>
<script src="<?php echo $base_url;?>js/check.js"></script>
<script type="text/javascript">

function deleteFriendRequest(memberId, sessionMemberId)
{


var r = confirm("Are you sure you want to cancel this request?");
	 //jConfirm('Are you sure you want to delete this?', 'Delete Post', function(r)  
	 {   
    if(r == true){
    $.post('action/delete_friend_request.php', { id : memberId , sessId : sessionMemberId }, function() {
   alert("Request cancel successfully");
    $("#mini"+memberId).css("display","none");
    
     });
    } 
     return false;
}
}

</script>
<div class="insideWrapper container">
    <div class="col-lg-9 col-md-9 col-sm-8">



	<div class="column_internal_left" style="width: 90%;">

    <div class="componentheading">

    <div id="submenushead"><?php echo $lang['Connection request sent: Waiting for authorization'];?></div>

    </div>

    <div id="submenushead" style="margin-bottom: 30px;">

    <ul class="submenu">
<!--
     <li style="font-size: 15px;"><a href="friends.php?friend_id=<?php //echo $member_id;?>"><?php //echo $lang['Show all'];?></a></li>

    <li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="find_friend.php">Search</a></li>-->

    <li style="font-size: 15px;"><a href="find_friend_advanced.php"><?php echo $lang['Advanced Search'];?></a></li>

  	<li style="font-size: 15px;"><a href="invite_friends.php"><?php echo $lang['Invite Friends'];?></a></li>

    <li style="font-size: 15px;"><a href="request_sent.php"><?php echo $lang['Request Sent'];?></a></li>

    <li style="font-size: 15px;"><a href="pending_request.php" style="border-right:none;"><?php echo $lang['Pending my approval'];?></a></li>

	</ul>

   </div>





<div id="border">

<?php 

	$clicks = mysqli_query($con, "select * from friendlist where added_member_id = '".$member_id."' and status = 0");


	$count = mysqli_num_rows($clicks);

	if($count)

	{

	while($clicks_res = mysqli_fetch_array($clicks))

	{

		$member  = $clicks_res['member_id'];

		$count = mysqli_query($con, "select * from friendlist where added_member_id = '".$member."'");

		$count_row = mysqli_num_rows($count);

		$member_detail = mysqli_query($con, "select * from member where member_id = $member");

		$member_detail_res = mysqli_fetch_array($member_detail);
		$media = $objMember->select_member_meta_value($member_detail_res['member_id'],'current_profile_image');
if(!$media)
$media = "images/default.png";
$media=$base_url.$media;

?>

 

<div class="mini-profile" id="mini<?php echo $member;?>" style="width: 65%;">

<div class="form-group">

<div class="mini-profile-avatar">

<div class="col-md-4">

<a href="<?php echo $base_url.$member_detail_res['username'];?>" title="<?php echo $member_detail_res['username'];?>"><img src="<?php echo $media;?>" width="68" height="68" /></a>

</div>

</div>

<div class="mini-profile-details">

<div class="col-md-4">

<h3 style="font-size:120%;"><a href="<?php echo $base_url.$member_detail_res['username'];?>" title="<?php echo $member_detail_res['username'];?>"><strong><?php echo $member_detail_res['username'];?></strong></a></h3>

</div>

</div>

<div class="mini-profile-details-status"></div>

<div class="mini-profile-details-action">

<div class="col-md-8" style="margin-top: 15px; width: 68.667%;">

<span class="icon-group"><?php echo $count_row;?><?php echo $lang['Friends'];?></span>

<a href="write_message.php?id=<?php echo $member_detail_res['username'];?>"><span class="icon-write"><?php echo $lang['write message'];?></span></a>


<a  href="javascript:void(0)" onclick="deleteFriendRequest(<?php echo $member;?>,<?php echo $member_id;?>)"><?php echo $lang['cancel request'];?></a>

<!--<a class="remove" onclick="deleteFriendRequest(<?php echo $member;?>,<?php echo $member_id;?>)" href="javascript:void(0)" title="<?php echo $lang['Remove Friend'];?>"></a>-->

</div>

</div>

</div>.

</div>

<?php } ?>

<?php }

else

{

?>



<div class="form-group">

<div class="col-md-6">

<div class="community-empty-list">

<?php echo $lang['You have no pending request'];?> 

</div>

</div>

</div>

<?php  }?>

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