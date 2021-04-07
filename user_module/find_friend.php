<?php
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php'); 	 
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');
	//require_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_lookup.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_header.php');
	$objMember = new member1(); 
	$lookupObject = new lookup(); 
	$activeID =  $lookupObject->getLookupKey("MEMBER STATUS", "ACTIVE");
	$member_id = $QbSecurity->qbClean($_SESSION['SESS_MEMBER_ID'], $con);
	if(!isset($_SESSION['SESS_MEMBER_ID']))
	{
		header("location: ".$base_url."index.php");
		exit();
	}
	$sql = mysqli_query($con, "select * from member where member_id='".$member_id."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);
?>
<?php /*?><link rel="icon" href="images/favicon.ico" type="image" />
<link rel="shortcut icon" href="images/favicon.ico" type="image" />
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/style.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>font-awesome/css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/jquery-ui.css" />
<link rel="stylesheet"  type="text/css" href="<?php echo $base_url;?>css/token-input.css"/>
<link rel="stylesheet"  type="text/css" href="<?php echo $base_url;?>css/token-input-facebook.css"/>
<link rel="stylesheet"  type="text/css" href="<?php echo $base_url;?>css/token-input-mac.css"/>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css" />
<link rel="stylesheet" type="text/css" href="css/bootstrap-reset.css" /><?php */?>

<script src="<?php echo $base_url;?>js/jquery.min.js"></script>
<script src="<?php echo $base_url;?>js/jquery-1.9.1.js"></script>
<script src="<?php echo $base_url;?>js/ibox.js"></script>
<script src="<?php echo $base_url;?>js/jquery-ui.js"></script>
<script src="<?php echo $base_url;?>js/jquery.tokeninput.js"></script>
<script src="<?php echo $base_url;?>js/check.js"></script>

<script type="text/javascript">        

function delfriend(id)
{
//alert(id);
var r=confirm("<?php echo $lang['Are you sure you want to delete this friend'];?>?");
	if(r==true)
	{
	//alert('yes');
	
	           $.ajax({
			type: "POST",
			url: "action/del_friend.php",
			data: {member_id:id},
			cache: false,
			success: function(html){
			 $("#vinod").html(html);
			alert('<?php echo $lang['Friend Deleted'];?>');
			 $(".mini-profile").hide();
			  
			 }
			 });
	//ocation.href="action/delete_friend.php?member_id="+id;
	}
}

//add as a friend
$("#cancel_request").click()
{
	$("#myform1").hide();
}
/*$('.add_friend').live("click",function() 
{
var ID = $(this).attr("id");
var dataString = 'member_id='+ ID;

$.ajax({
type: "POST",
url: "action/add_friend_ajax.php",
data: dataString,
cache: false,
success: function(html){
 $("#add_friend").hide();
 
 }
 });

return false;
})*/;


function ajaxdemo()
{
var message=$("#add_friend_mesg").val();
var member_id=$('#add_friend_id').val();
 
//alert(mesg);
//alert('hi');
		$.ajax({
		type: "POST",
		url: "action/add_friend.php",
		data: {message:message,member_id:member_id},
		cache: false,
		success: function(html){
		 $("#vinod").html(html);
		  alert('<?php echo $lang['Friend Request Has Been Sent'];?>');
		 $("#ibox_wrapper").hide();
		  $("#fre_stat").text('Send Request');
		 }
		 });
		 return false;
}
</script>
<div class="insideWrapper container">
    <div class="col-lg-9 col-md-9 col-sm-8">
	
    <div class="componentheading">
    <div id="submenushead"><?php echo $lang['Search People'];?><div id="vinod" ></div></div>
    </div>
    <div id="submenushead">
   <ul class="submenu">
   <!-- <li><a href="friends.php?friend_id=<?php //echo $member_id;?>"><?php //echo $lang['Show all'];?></a></li>
    <li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="find_friend.php">Search</a></li>-->
    <li style="font-size:15px;"><a href="find_friend_advanced.php"><?php echo $lang['Advanced Search'];?></a></li>
  	<li style="font-size:15px;"><a href="invite_friends.php"><?php echo $lang['Invite Friends'];?></a></li>
    <li style="font-size:15px;"><a href="request_sent.php"><?php echo $lang['Request Sent'];?></a></li>
    <li style="font-size:15px;"><a href="pending_request.php" style="border-right:none;"><?php echo $lang['Pending my approval'];?></a></li>
	</ul>
   </div>
<form name="find_friend" id="find_friend" action="" method="get">
<input type="text" name="query" id="member_name" class="textbox" style="margin-left:0px; width:50%; padding:5px;" />
<input type="submit" name="submit" class="button" value="<?php echo $lang['Search'];?>" />
</form>
    
<?php 
if(isset($_REQUEST['submit']))
{	
	
	$first_name = $_REQUEST['query'];	
	$friend = mysqli_query($con, "select * from member where username like '%$first_name%' AND status ='$activeID'") ;
	
	while($row = mysqli_fetch_array($friend))
	
	{
	$member=$row['member_id'];
	$block=mysqli_query($con, "select * from blocklist where userid='$member' and blocked_userid='$member_id' ");
	$block_count = mysqli_num_rows($block);
if($block_count==0)
	{
		$member  = $row['member_id'];
		$count = mysqli_query($con, "select * from friendlist where added_member_id = '".$member."'");
		$count_res = mysqli_fetch_array($count);
		$count_row = mysqli_num_rows($count);
		
		$fcount = mysqli_query($con, "select * from friendlist where (added_member_id = '$member_id' AND member_id='$member') OR
		(member_id = '$member_id' AND added_member_id='$member')") or die(mysqli_error($con));				
		$fcount_row = mysqli_num_rows($fcount);
		$media = $objMember->select_member_meta_value($row['member_id'],'current_profile_image');
if(!$media)
$media = "images/default.png";
$media=$base_url.$media;
		
?>
<div class=" col-md-12">

<div class="mini-profile">

<div class="form-group">

<div class="mini-profile-avatar">

<div class="col-md-4">

<a href="<?php echo $base_url.$row['username'];?>" title="<?php echo $row['username'];?>"><img src="<?php echo $media;?>" width="68" height="68" /></a>

</div>

</div>



<div class="mini-profile-details">

<div class="col-md-4">

<h3 style="font-size:120%;"><a href="<?php echo $base_url.$row['username'];?>" title="<?php echo $row['username'];?>"><strong><?php echo $row['username'];?></strong></a></h3>

</div>

</div>

</div>

<div class="mini-profile-details-status"></div>

<div class="mini-profile-details-action">

<div class="form-group">

<div class="col-md-8">

<span class="icon-group"><?php echo $count_row.' ';?><?php echo $lang['Friends'];?></span>

<a href="write_message.php?id=<?php echo $row['username'];?>"><span class="icon-write"><?php echo $lang['write message'];?></span></a>

<?php

$add_friend =mysqli_query($con, "select * from friendlist where added_member_id = '".$member."' and member_id = '".$count_res['member_id']."'");

$add_res  = mysqli_fetch_array($add_friend);

$add_friend_status = $add_res['status'];

/*if($add_friend_status == 0)

{

if($row['member_id']!=$member_id)

{*/

?>


<?php 
if($fcount_row <= 0)
{

?>

<a href="#myform1<?php echo $member;?>" rel="ibox" id="" class="add_friend" title="<?php echo $lang['Add as friend'];?>"><span class="icon-add-friend"><?php echo $lang['Add as friend'];?></span></a>
<?php }
else if($fcount_row == 1)
	{
	
	 echo "<span class='icon-add-friend'>".$lang['Request Sent']."</span>";
	} 
else
{

?>

<?php echo $lang['friends'];?>

<?php }?>


</div>

</div>

</div>

<form id="myform1<?php echo $member;?>" style="display:none;" action="action/add_friend.php" method="post">
<p><?php echo $lang['Are you sure you want to add this friend'];?>?</p>
<textarea name="message" style="width:90%; margin:5px;" placeholder="<?php echo $lang['write message'];?>" ></textarea>

<input type="hidden" value="<?php echo $member;?>"  name="member_id"/>
<input type="submit" name="add_friend" value="<?php echo $lang['Add friend'];?>" class="button" style="margin:3px; margin-top:10px; margin-left:250px;"  />
<input type="button" class="button" name="cancel" id="cancel_request" onclick="javascript:{window.location.reload();}" value="<?php echo $lang['Cancel'];?>" style="margin:3px; margin-top:10px; float:right;"/>
</form>



<?php 

//}

//}



?>



</div>

</div>

	<?php	
	}
	}	
}
?>
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