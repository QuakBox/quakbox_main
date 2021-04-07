<?php 

	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php'); 	 
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');		
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_header.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_security.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_lookup.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
	$objMember = new member1(); 
	$lookupObject = new lookup(); 
	$session_member_id = $QbSecurity->qbClean($_SESSION['SESS_MEMBER_ID'],$con);
	$member_username = $QbSecurity->qbClean($_REQUEST['username'], $con);

        
	$activeID =  $lookupObject->getLookupKey("MEMBER STATUS", "ACTIVE");
	$member_username =htmlspecialchars(trim($member_username ));
	$sql = mysqli_query($con, "select * from member where username='".$member_username."'") or die(mysqli_error($con));	
	$res = mysqli_fetch_array($sql);
	
	if(mysqli_num_rows($sql) == 0){ exit;}

	$friends_member_id = $QbSecurity->qbClean($res['member_id'], $con);

?>
<div class="insideWrapper container">
<div class="col-lg-5">

<h3><?php echo ucwords($res['username'])."&#039;s";?> <?php echo $lang['Friends'];?></h3>
<ul class="nav nav-pills">
<li role="presentation" class="active"><a href="<?php echo $base_url.$member_username;?>"><?php echo $lang['Back To Profile'];?></a></li>
<li role="presentation" class="active"> <a href="<?php echo $base_url.'photos/'.$member_username;?>"><?php echo $lang['Photos'];?></a></li>
<li role="presentation" class="active"><a href="<?php echo $base_url.'videos/'.$member_username;?>"><?php echo $lang['Videos'];?></a></li>
</ul>


<?php  $sqlClicksq ="select * from friendlist f,member m where f.added_member_id = m.member_id and f.member_id = '".$friends_member_id."' AND m.status = '$activeID'";
 $clicks = mysqli_query($con, $sqlClicksq);

	if(mysqli_num_rows($clicks) > 0)

	{

	while($clicks_res = mysqli_fetch_array($clicks))

	{
$member=$clicks_res['member_id'];
$encryptedMemberID=$QbSecurity->QB_AlphaID($member);
$encryptedAddedMemberID=$QbSecurity->QB_AlphaID($clicks_res['added_member_id']);
$media = $objMember->select_member_meta_value($clicks_res['member_id'],'current_profile_image');
if(!$media)
$media = "images/default.png";
$media=$base_url.$media;
		$b = mysqli_query($con, "select * from friendlist where member_id = '".$_SESSION['SESS_MEMBER_ID']."'");
		
		$fcount = mysqli_query($con, "select * from friendlist where (added_member_id = '".$_SESSION['SESS_MEMBER_ID']."' AND member_id='$member')  OR (member_id = '".$_SESSION['SESS_MEMBER_ID']."' AND added_member_id='$member')") or die(mysqli_error($con));				
		$fcount_row = mysqli_num_rows($fcount);

		$c = mysqli_num_rows($b);

		

?>

        

<div class="mini-profile" style="border: 1px solid #ccc;padding: 10px; margin-top: 10px;border-radius: 10px;background: #FFF none repeat scroll 0% 0%;">

<div class="pull-left">
	<?php if($_SESSION['SESS_MEMBER_ID'] == $clicks_res['added_member_id']){ ?>
		<a href="<?php echo $base_url."i/".$clicks_res['username'];?>" title="<?php echo $clicks_res['username'];?>"><img src="<?php echo $media;?>" style="padding: 1px; height: 100px; width: 100px;" /></a>
	<?php }else
	{ ?>
		<a href="<?php echo $base_url.$clicks_res['username'];?>" title="<?php echo $clicks_res['username'];?>"><img src="<?php echo $media;?>" style="padding: 1px; height: 100px; width: 100px;" /></a>
	<?php } ?>
</div>
<div class="pull-left">
<h4>
	<?php if($_SESSION['SESS_MEMBER_ID'] == $clicks_res['added_member_id']){ ?>
	<a href="<?php echo $base_url."i/".$clicks_res['username'];?>" style="margin: 5px;" title="<?php echo $clicks_res['username'];?>"><strong><?php echo ucwords($clicks_res['username']);?></strong></a>
	<?php }else
	{
	?>
	<a href="<?php echo $base_url.$clicks_res['username'];?>" style="margin: 5px;" title="<?php echo $clicks_res['username'];?>"><?php echo  ucwords($clicks_res['username']);?></a>
	<?php } ?>
</h4>
<?php
if($_SESSION['SESS_MEMBER_ID'] == $clicks_res['added_member_id'])
{/*?>
<!--<a class="remove1" href="<?php echo $base_url;?>action/delete_friend.php?member_id=<?php echo $clicks_res['added_member_id'];?>"><?php echo $lang['Remove Friend'];?></a>

<a class="remove" href="<?php echo $base_url;?>action/delete_friend.php?member_id=<?php echo $clicks_res['added_member_id'];?>" title="<?php echo $lang['Remove Friend'];?>" ></a>--><?php*/ } 

else if($clicks_res['added_member_id'] != $_SESSION['SESS_MEMBER_ID'] && $fcount_row <= 0)

{


$sql_block=mysqli_query($con, "select * from blocklist where userid='".$clicks_res['added_member_id']."' and blocked_userid='".$_SESSION['SESS_MEMBER_ID']."'");
$count_block=mysqli_num_rows($sql_block);
if($count_block==0)
{
?>
<div class="pull-left">
	<button type="button" class='btn btn-link' id="remove_levels1" data-toggle="modal" data-target="#addFriend<?php echo $encryptedAddedMemberID;?>" >   <?php echo  $lang['Add as friend']; ?></button>
  <div id="addFriend<?php echo $encryptedAddedMemberID;?>" class="modal fade" tabindex="-1"  role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content" >
			<div class="modal-body">
				<?php echo $lang['Are you sure you want to add this friend']; ?>?
			</div>
			<div class="modal-footer">
				<form action="<?php echo $base_url;?>action/add_friend.php" method="POST">
					<label for="message"><?php echo $lang['write message']; ?>?</label>
					<textarea class="form-control" rows="5" id="message" placeholder="<?php echo $lang['write message']; ?>"></textarea>
					<button type="submit" class="btn btn-primary" id="add_friend" name="add_friend" value="<?php echo $lang['Add friend']; ?>"><?php echo $lang['Add friend']; ?></button>
					<button type="button" data-dismiss="modal" class="btn">Cancel</button>
					<input type="hidden" value="<?php echo $encryptedAddedMemberID;?>" id="memEnc"  name="memEnc"/>
				</form>
			</div>
		</div>
	</div>
  </div>
</div>
<?php
}
else
{
echo "blocked";
}
 }

else if($clicks_res['added_member_id'] != $_SESSION['SESS_MEMBER_ID'] && $fcount_row == 1)
{
	$fcount1 = mysqli_query($con, "select * from friendlist where (member_id = '".$_SESSION['SESS_MEMBER_ID']."' AND added_member_id='$member')") or die(mysqli_error($con));				
		$fcount_row1 = mysqli_num_rows($fcount1);
		if($fcount_row1==1)
		{
		?>
		<div id="fri<?Php echo $encryptedMemberID;?>">
			<div class="pull-left" style="margin: 5px;">
				<input type="button"  name="accept_request" value="<?Php echo $lang['confirm'];?>" custoMid="<?Php echo $encryptedMemberID;?>" 
				class="accept_request btn btn-info" 
				onclick="location.href='<?php  echo $base_url."action/accept_request.php?member_id=".$clicks_res['member_id']; ?>';">
			</div>
			<div class="pull-left" style="margin: 5px;">
				<input type="button"  name="cancel_request" value="<?Php echo $lang['not now'];?>" custoMid="<?Php echo $encryptedMemberID;?>" class="cancel_request btn btn-danger">
			</div>
		</div>
		<div class="pull-left" style="margin: 5px;display:none;" id="friend<?Php echo $encryptedMemberID;?>">
			<input type="button" name="accept_request" value="Friends" class="friends btn btn-success">
		</div>
		<?php }
		else
		{
			echo "<span class='btn btn-success'>".$lang['Request Sent']."</span>";
		}
} 
else
{
?>
<div class="pull-left">
<button type="button" class='btn btn-link' id="remove_levels2" data-toggle="modal" data-target="#deleteFriend<?php echo $encryptedAddedMemberID;?>" ><?php echo  $lang['Remove Friend']; ?></button>
<div id="deleteFriend<?php echo $encryptedAddedMemberID;?>" class="modal fade" tabindex="-1"  role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content" >
			<div class="modal-body">
				Are you sure you want to remove this Friend?
			</div>
			<div class="modal-footer">
				<form action="<?php echo $base_url;?>action/delete_friend.php" method="POST">
					<button type="submit" class="btn btn-primary" id="Remove" name="Remove" value="Remove">Remove</button>
					<button type="button" data-dismiss="modal" class="btn">Cancel</button>
					<input type="hidden" value="<?php echo $encryptedMemberID;?>" id="memEnc"  name="memEnc"/>
				</form>
			</div>
		</div>
	</div>
</div>
</div>
<?php 

$block_sql = mysqli_query($con, "select * from blocklist  where blocked_userid='".$clicks_res['added_member_id']."' and userid ='$session_member_id'");
if(mysqli_num_rows($block_sql) == 1)
{ 
$encryptedUnblockMemberID=$QbSecurity->QB_AlphaID($block_res['member_id']);
?>
<div class="pull-left">
<button type="button"  class='btn btn-link' id="remove_levels3" data-toggle="modal" data-target="#unblockFriend<?php echo $encryptedUnblockMemberID;?>" ><?php echo  $lang['Unblock']; ?></button>
<div id="unblockFriend<?php echo $encryptedUnblockMemberID;?>" class="modal fade" tabindex="-1"  role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content" >
			<div class="modal-body">
				Are you sure you want to Unblock this Friend?
			</div>
			<div class="modal-footer">
				<form action="<?php echo $base_url;?>action/remove_block_friend.php" method="POST">
					<button type="submit" class="btn btn-primary" id="delete" name="delete" value="delete"><?php echo  $lang['Unblock']; ?></button>
					<button type="button" data-dismiss="modal" class="btn">Cancel</button>
					<input type="hidden" value="<?php echo $encryptedUnblockMemberID;?>" id="memEnc"  name="memEnc"/>
				</form>
			</div>
		</div>
	</div>
</div>
</div>
<?php }
else
{
 ?>
 <div class="pull-left">
<button type="button"  class='btn btn-link' id="remove_levels4" data-toggle="modal" data-target="#blockFriend<?php echo $encryptedAddedMemberID;?>" ><?php echo  $lang['block friend']; ?></button>
<div id="blockFriend<?php echo $encryptedAddedMemberID;?>" class="modal fade" tabindex="-1"  role="dialog" aria-labelledby="mySmallModalLabel">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content" >
			<div class="modal-body">
				Are you sure you want to Block this Friend?
			</div>
			<div class="modal-footer">
				<form action="<?php echo $base_url;?>action/add_block_friend.php" method="POST">
					<button type="submit" class="btn btn-primary" id="block" name="block" value="block"><?php echo $lang['block friend']; ?></button>
					<button type="button" data-dismiss="modal" class="btn">Cancel</button>
					<input type="hidden" value="<?php echo $clicks_res['username'];?>" id="user_search"  name="user_search"/>
				</form>
			</div>
		</div>
	</div>
</div>
</div>
<?php  }}?>
<div class="clearfix"></div>
</div>
<div class="clearfix"></div>


</div><!--end mini profile-->

<?php } 

}

else

{

?>

<div class="community-empty-list" style="width: 300px;float: left;margin: 20px 20px 20px 0px;">

<?php echo $lang['No friends'];?>

</div>

<?php } ?>


</div>


<?php 
	include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_footer.php');
	
?>