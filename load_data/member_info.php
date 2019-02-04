<?php ob_start();
session_start();

if(!isset($_SESSION['SESS_MEMBER_ID']))
	{
echo "1";	
	}
	else
	{
include_once '../config.php';
$session_member_id = $_SESSION['SESS_MEMBER_ID'];
$member_id = (int)$_POST['member_id'];

$sql = mysqli_query($con, "select * from members where member_id = '$member_id'");
$res = mysqli_fetch_array($sql);
if ($res)
{
	$first_name = $res['username'];	
	$photo = $res['profImage'];


$add_friend =mysqli_query($con, "select * from friendlist where  (  ( added_member_id = '".$session_member_id."' and member_id='$member_id' ) 
						or (  member_id= '".$session_member_id."' and added_member_id ='$member_id' ) ) ");

		
$add_friend1 =mysqli_query($con, "select * from friendlist where added_member_id = '".$member_id."'");

$add_res  = mysqli_fetch_array($add_friend);
	
?>
<div class="tooltip_show" id="tooltip_show<?php echo $member_id;?>" style="right:40px; top:520px; width:450px; position:absolute; background:#000; z-index:29900; ">

<div class="mini-profile-avatar">
<a href="member_profile.php?member_id=<?php echo $res['member_id'];?>" title="<?php echo $res['username'];?>"><img src="<?php echo $res['profImage'];?>" width="68" height="68" /></a>
</div>
<div class="mini-profile-details">
<h3 style="font-size:120%;"><a href="member_profile.php?member_id=<?php echo $res['member_id'];?>" title="<?php echo $res['username'];?>"><strong><?php echo $res['username'];?></strong></a></h3>
</div>
<div class="mini-profile-details-status"></div>
<div class="mini-profile-details-action">
<span class="icon-group" style="color:#FFF;"><strong><?php echo mysqli_num_rows($add_friend1);?></strong> Friends</span>
<a href="#"><span class="icon-write">Write Message</span></a>
<?php 
if(mysqli_num_rows($add_friend) == 0 or mysqli_num_rows($add_friend) == 1)
{
	if($session_member_id != $member_id)
	{
?>
<a href="#myform2" class="add_as" rel="ibox" title="Add as Friend" ><span class="icon-add-friend">Add as friend</span></a>
<?php 
	}
	
}?>
</div>
<form id="myform2" style="display:none;" action="action/add_friend.php" method="post">
<p>Are you sure you want to add this friend?</p>
<textarea name="message" style="width:90%; margin:5px;" placeholder="Write message" ></textarea>
<input type="hidden" value="<?php echo $res['member_id'];?>"  name="member_id"/>
<input type="submit" name="add_friend" value="Add friend" class="button" style="margin:3px; margin-top:10px; margin-left:250px;"  />

<a href="member_profile.php?member_id=<?php echo $member_id;?>"><input type="button" class="button" name="cancel" value="Cancel" style="margin:3px; margin-top:10px; float:right;"/></a>
</form>

</div>
<?php
}}
?>
