<?php 
	require_once('common/common.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_lookup.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
	$objMember = new member1(); 
	$lookupObject = new lookup(); 
	$member_id = $QbSecurity->qbClean($_SESSION['SESS_MEMBER_ID'], $con);

	$sql = mysqli_query($con, "select * from member where member_id='".$member_id."'") or die(mysqli_error($con));

	$res = mysqli_fetch_array($sql);	

	if(isset($_REQUEST['friend_id'])){$friends_member_id = $QbSecurity->qbClean($_REQUEST['friend_id'], $con);}else{$friends_member_id = 0;}
	if(!(empty($friends_member_id )||($qbValidation->qbIntegerCheck($friends_member_id ))))
	{
		$qb_err_msg="Oops Something Went Wrong...!";
$QbSecurity->qbErrorMessage($qb_err_msg,$homepage);
	}
	else
	{
	

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?php echo ucfirst($res['username'])."'s";?> <?php echo $lang['friends'];?></title>

<link rel="stylesheet" type="text/css" href="css/style.css"/>

<link rel="icon" href="images/favicon.ico" type="image" />

<link rel="shortcut icon" href="images/favicon.ico" type="image" />


<link rel="stylesheet" type="text/css" href="css/bootstrap-reset.css" />
<link rel="stylesheet" type="text/css" href="css/format.css"/>

<link rel="stylesheet" type="text/css" href="css/search.css"/>

<link rel="stylesheet" type="text/css" href="css/dropdown.css"/>

<link rel="stylesheet" type="text/css" href="css/responsive.css"/>

<link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.css">

<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>assets/jquery-alert-dialogs/css/jquery.alerts.css"/>





<script src="js/jquery.livequery.js" type="text/javascript"></script>

<script src="js/jquery.oembed.js"></script>

<script src="js/jquery-1.9.1.js"></script>

<script src="js/jquery-ui.js"></script>

<script src="js/jquery.fastLiveFilter.js"></script>

<script type="text/javascript" src="<?php echo $base_url;?>assets/jquery-alert-dialogs/js/jquery.alerts.js"></script>

<script type="text/javascript">

$(function() {

	$('.remove1').click (function () {

		return confirm('<?php echo $lang["Are you sure you want to delete this friend"];?>?', 'Confirmation Dialog');

						

	}) ; 



        $('#search_input').fastLiveFilter('#border',{

			callback: function(total) { $('#num_results').html(total); }

		});

    });

</script>



</head>

<body id="all_friends">

<div id="wrapper">

<?php include('includes/header.php');?>

<div id="mainbody">

<div class="column_left">



<div class="componentheading">

    <div id="submenushead"><?php echo ucfirst($res['username'])."'s ";?><?php echo $lang['friends'];?></div>

    </div>

    <div id="submenushead" style="margin-bottom: 30px;">

    <ul class="submenu">

    <li style="font-size: 15px;"><a href="friends.php?friend_id=<?php echo $member_id;?>"><?php echo  $lang['Show all'];?></a></li>

    <!--<li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="find_friend.php">Search</a></li>-->

    <li style="font-size: 15px;"><a href="find_friend_advanced.php"><?php echo  $lang['Advanced Search'];?></a></li>

  	<li style="font-size: 15px;"><a href="invite_friends.php"><?php echo  $lang['Invite Friends'];?></a></li>

    <li style="font-size: 15px;"><a href="request_sent.php"><?php echo   $lang['Request Sent'];?></a></li>

    <li style="font-size: 15px;"><a href="pending_request.php" style="border-right:none;"><?php echo   $lang['Pending my approval'];?></a></li>

	</ul>

   </div>

   

<div class="cFilterBar_inner" style=" clear:both;">



<div class="innerwrap">

<div class="form-group">

<div class="col-md-4">

<span class="uiSearchInput textinput">

<span>

<input type="text" id="search_input" placeholder="<?php echo $lang['search your friends'];?>" />

<button><span></span></button>

</span>

</span>

</div>

</div>



<div class="for-group">
<?php 
$clicks = mysqli_query($con, "select * from friendlist f,member m where f.added_member_id = m.member_id and f.member_id = '".$friends_member_id."' AND f.status != 0");
?>

<label for="name" class="control-label col-md-4 margin"><?php echo $lang['search found'];?>: <span  ><?php echo mysqli_num_rows($clicks);?></span></label>

</div>

</div>

</div>



<div id="border">

<?php 

	
	
	if(mysqli_num_rows($clicks) > 0)

	{

	while($clicks_res = mysqli_fetch_array($clicks))

	{
	
	
	$media = $objMember->select_member_meta_value($clicks_res['member_id'],'current_profile_image');
if(!$media)
$media = "images/default.png";
$media=$base_url.$media;

?>



<div class="mini-profile">

<div class=" form-group">



<div class="mini-profile-avatar">

<div class=" col-md-4">

<a href="<?php echo $base_url.$clicks_res['username'];?>" title="<?php echo $clicks_res['username'];?>"><img src="<?php echo $media;?>" width="68" height="68" /></a>

</div>

</div>

<div class="mini-profile-details">

<div class=" col-md-4">

<h3 style="font-size:120%;"><a href="<?php echo $base_url.$clicks_res['username'];?>" title="<?php echo $clicks_res['username'];?>"><strong><?php echo ucfirst($clicks_res['username']);?></strong></a></h3>

</div>

<div class="mini-profile-details-status"></div>

<div class="mini-profile-details-action">
<div class="col-md-8" style="margin-top: 15px; width: 68.667%;">



<a class="remove1" href="action/delete_friend.php?member_id=<?php echo $clicks_res['member_id'];?>"><?php echo $lang['Remove Friend'];?></a>
<?php 

$block_sql = mysqli_query($con, "select * from blocklist  where blocked_userid='".$clicks_res['added_member_id']."' and userid ='$member_id'");
if(mysqli_num_rows($block_sql) == 1)
{
?>
<a class="blocka" href="action/remove_block_friend.php?member_id=<?php echo $block_res['member_id'];?>"><?php echo $lang['Unblock'];?></a>
<?php }
else
{
 ?>
 <form name="blockFriend" id="blockFriend" action="<?php echo $base_url;?>action/add_block_friend.php" method="post">

<input type="hidden" name="member_name" id="member_name" value="<?php echo $clicks_res['username'];?>" />

<input type="hidden" name="member_id" id="member_id" value="<?php echo $member_id;?>" />

<input class="submitLink" type="submit" name="submit" class="button" value="<?php echo $lang['block friend'];?>" />

</form>
 
<?php } ?>

</div>
<!--<div class=" col-md-4">

<a class="remove" href="action/delete_friend.php?member_id=<?php echo $clicks_res['member_id'];?>" title="<?php echo $lang['Remove Friend'];?>" ></a>

</div>-->



</div>

</div>

</div>



</div><!--end mini profile-->



<?php } }

else

{

?>

<div class="community-empty-list" style="width: 300px;float: left;margin: 20px 20px 20px 0px;">

No friends

</div>

<?php } ?>

</div><!--end border-->



</div><!--end column_left div-->



<?php include 'ads_right_column.php';?>

</div><!--end mainbody div-->

<?php include 'includes/footer.php';?>

</div><!--end wrapper div-->
<?php
}
?>

</body>

</html>