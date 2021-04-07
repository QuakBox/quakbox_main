<?php
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php'); 	 
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');
	//require_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_header.php');
	
	$member_id = $QbSecurity->qbClean($_SESSION['SESS_MEMBER_ID'],$con);
	$q = $QbSecurity->qbClean(@$_REQUEST['q'], $con);
	$objMember = new member1();
	$lookupObject = new lookup();
	
	$sql = mysqli_query($con, "select * from member where member_id='".$member_id."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);	
	
?>
<script>
function delfriend(id)
{
//alert(id);
var r=confirm("Are you sure you want to delete this friend?");
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
			alert('Friend Deleted');
			 $("#mini-profile_"+id).hide();
			  
			 }
			 });
	//ocation.href="action/delete_friend.php?member_id="+id;
	}
}
</script>
<style type="text/css">
	#submenushead {
		float: left;
		padding-left: 5px;
		padding-bottom: 5px;
		padding-top: 20px;
		width: 100%;
		position: relative;
		bottom: 4px;
	}
	.mini-profile {
		padding: 10px 0 !important;
		border: solid 1px #ccc;
		margin: 25px 0 5px 10px;
		position: relative;
		-moz-border-radius: 10px;
		-webkit-border-radius: 10px;
		border-radius: 10px;
	}
	.mini-profile-details h3{
		padding:0;
		margin:0;
	}
	
	.mini-profile {
		width: 90%;
		float: left;
	}
	
	.mini-profile-avatar img {
		border: 1px solid #CCC;
		 border-radius: 3px;
	}
	
	.tooltip_
	 {
		padding: 10px 0 !important;
		border: solid 1px #ccc;
		margin: 25px 0 5px 10px;
		position: relative;
		-moz-border-radius: 10px;
		-webkit-border-radius: 10px;
		border-radius: 10px;
	}
	
	.mini-profile-avatar {
		float: left;
		padding: 0 10px;
	}
	
	.mini-profile-details {
		margin: 0 10px 0 90px;
	}
	
	.mini-profile-details-status {
		min-height: 18px;
		font-style: italic;
	}
	
	.mini-profile-details-action1 {
		margin-top: 4px;
		position: relative;
		display: table;
	}
	.mini-profile-details-action {
		margin-top: 4px;
		position: relative;
	}
	a.remove {
		background: transparent url(images/remove-button.gif) no-repeat 0 0;
		display: block;
		outline-style: none;
		text-indent: -9999px;
		float: right;
		width: 12px;
		height: 12px;
	}
	a.remove:hover {
		background: transparent url(images/remove-button.gif) no-repeat 0 -12px;
	}
	.icon-group {
		background: transparent url(images/icons-16x16.gif) no-repeat 0 -58px;
		line-height: 15px;
		margin: 10px 15px 0 0;
		padding: 3px 3px 3px 20px;
		display: inline;
		text-decoration: none;
	}
	.icon-write {
		background: transparent url(images/icons-16x16.gif) no-repeat 0 -118px;
		line-height: 15px;
		margin: 10px 15px 0 0;
		padding: 3px 3px 3px 20px;
		display: inline;
		text-decoration: none;
	}
	.icon-add-friend {
		background: transparent url(images/icons-16x16.gif) no-repeat 0 -179px;
		line-height: 15px;
		margin: 10px 15px 0 0;
		padding: 3px 3px 3px 20px;
		display: inline;
		text-decoration: none;
	}
</style>
<div class="insideWrapper container">
<div class="col-lg-2 hidden-xs"></div>  
 
 <div class="col-lg-6 col-md-8 col-sm-8">  
 <div class="componentheading">
    <div id="submenushead">Search People</div>
    <div id="vinod"></div>
    </div>
     
 <div id="border">
 <form name="find_friend" id="find_friend" method="get">
<input type="text" name="q" id="q" class="textbox" style="margin-left:0px; width:50%; padding:5px;" />
<input type="submit" name="submit" value="Search" />
</form>
 
<?php 
 $sqlclick = "select DISTINCT a.member_id, a.username from member a, member_meta b WHERE (a.username like '$q%' OR a.email like '$q%' OR (b.meta_key ='first_name'  AND b.meta_value like '$q%')) AND a.member_id= b.member_id  AND a.member_id != '$member_id'  ORDER BY a.member_id";
 $clicks = mysqli_query($con, $sqlclick);

	if(mysqli_num_rows($clicks) > 0)
	{
	while($clicks_res = mysqli_fetch_array($clicks))
	{
		$member  = $clicks_res['member_id'];
		$count = mysqli_query($con, "select m.member_id,m.username,f.added_member_id from friendlist f,member m where f.added_member_id=m.member_id and f.member_id = '".$member."'");
		$count_res = mysqli_fetch_array($count);		
		$count_row = mysqli_num_rows($count);
		
		$fcount = mysqli_query($con, "select * from friendlist where (added_member_id = '$member_id' AND member_id='$member') OR
		(member_id = '$member_id' AND added_member_id='$member')") or die(mysqli_error($con));				
		$fcount_row = mysqli_num_rows($fcount);	
		$media = $objMember->select_member_meta_value($clicks_res['member_id'],'current_profile_image');
if(!$media)
$media = "images/default.png";
$media=$base_url.$media;
		
?>
        
<div class="mini-profile" id="mini-profile_<?php echo $clicks_res['member_id'];?>">
<div class="mini-profile-avatar">
<a href="<?php echo $base_url.$clicks_res['username'];?>" title="<?php echo ucfirst($clicks_res['username']);?>"><img src="<?php echo $media;?>" width="68" height="68" /></a>
</div>
<div class="mini-profile-details">
<h3 style="font-size:120%;"><a href="<?php echo $base_url.$clicks_res['username'];?>" 
title="<?php echo ucfirst($clicks_res['username']);?>"><strong><?php echo ucfirst($clicks_res['username']);?></strong></a></h3>
<div class="mini-profile-details-status"></div>
<div class="mini-profile-details-action">
<span class="icon-group"><?php echo $count_row.' ';?>Friends</span>
<a href="write_message.php?id=<?php echo $clicks_res['username'];?>"><span class="icon-write">Write Message</span></a>
<!--<a class="remove" href="action/delete_friend.php?member_id=<?php echo $clicks_res['member_id'];?>" title="Remove Friend" ></a>-->
<?php 
if($fcount_row <= 0)
{
?>
<a href="#myform1" onclick="$('#myform1').show(); return false;" rel="ibox" id="" class="add_friend" title="Add as Friend"><span class="icon-add-friend">Add as friend</span></a>
<?php }
else if($fcount_row == 1)
	{
	 echo "<span class='icon-add-friend'>Request sent</span>";
	} 
else
{
?>
<a class='remove' action='#!' style='padding-left:78px;' onclick='delfriend(<?php echo $clicks_res["member_id"];?>)'>Delete Friend</a>
<?php }?>
<form id="myform1" style="display:none;" action="action/add_friend.php" method="post">
<p>Are you sure you want to add this friend?</p>
<textarea name="message" style="width:90%; margin:5px;" placeholder="Write message" ></textarea>
<input type="hidden" value="<?php echo $member;?>"  name="member_id"/>
<input type="submit" name="add_friend" value="Add friend" class="button" style="margin:3px; margin-top:10px; margin-left:250px;"  />
<input type="button" class="button" name="cancel" id="cancel_request" onClick="javascript:{window.location.reload();}" value="Cancel" style="margin:3px; margin-top:10px; float:right;"/>
</form>
</div>
</div>

</div><!--end mini profile-->
<?php } }
else
{
?>
<div class="community-empty-list" style="width: 300px;float: left;margin: 20px 20px 20px 0px;">
No search found
</div>
<?php } ?>
</div><!--end border-->

</div><!--end left column div-->

<!--Start column right-->
<div class="col-lg-2 col-md-3 col-sm-3 hidden-xs"> 
	<div style="" class="adsQBxzqw"> <?php include($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/ads.php');?></div>
</div>

<!--end column_right div-->
 
</div><!--end mainbody div-->
 
<?php
	include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_footer.php');
?>