<?php
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php'); 	 
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');
	//require_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_header.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_security.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
	$objMember = new member1(); 
	$member_id = htmlspecialchars(trim($_SESSION['SESS_MEMBER_ID']));
	$sql = mysqli_query($con, "select * from member where member_id='".$member_id."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);	
	
?>
<link href="<?php SITE_URL ?>/css/jquery-ui.css" rel="Stylesheet"></link>
<script src="<?php SITE_URL ?>/js/jquery-ui.js"></script>
<script type="text/javascript">
jQuery(document).ready(function($) {

 $(".user_search").autocomplete({

	 source: window.location.origin+"/load_data/member_names_ajax.php",			

			select: true

 });

});
</script>
	 
	 <div class="insideWrapper container"> 
		<div class="col-lg-8" style="background:#fff;" >
			

<h2><?php echo $lang['Blocking'];?></h2>
<ul class="nav nav-pills">
<li role="presentation"><a href="<?php echo SITE_URL;?>/privacy.php"><?php echo $lang['Privacy'];?></a></li>
<li role="presentation" class="active"> <a href="<?php echo SITE_URL;?>/blocking.php"><?php echo $lang['Blocking'];?></a></li>
<li role="presentation"><a href="<?php echo SITE_URL;?>/account_settings.php"><?php echo $lang['Account Settings'];?></a></li>
<li role="presentation"><a href="<?php echo SITE_URL;?>/delete_account.php"><?php echo $lang['deactivate account'];?></a></li>
</ul>




<h2><?php echo $lang['Manage Blocking'];?></h2>

<form name="find_friend" id="find_friend" action="<?php echo $base_url;?>action/add_block_friend.php" method="post">

<input name="user_search" id="user_search" class="form-control user_search" type="text" value="" placeholder="<?php echo $lang['search'];?>" autocomplete="off"/>

<input type="submit" name="submit" class="btn btn-success" value="<?php echo $lang['block'];?>" />

</form>
<div class="app-box" style="margin-top:20px;">

<h2 class="app-box-title"><?php echo $lang['My block List'];?></h2>

</div>

<ul class="list-group">

<?php 

$block_sql = mysqli_query($con, "select * from blocklist b,member m where b.blocked_userid=m.member_id and b.userid = '$member_id'");

while($block_res = mysqli_fetch_array($block_sql))

{
$encryptedUnblockMemberID=$QbSecurity->QB_AlphaID($block_res['member_id']);
?>

<li class="list-group-item" >

<span><?php echo $block_res['username'];?></span>

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

</li>

<?php 

}

?>

</ul>
</div>
<script type="text/javascript">
	$(document).ready(function() {
   
    
    
    $('#find_friend').formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            user_search: {
                validators: {
                    notEmpty: {
                        message: 'This feild is required'
                    }
                }
            }
        }
    });
    
    
});
</script>
<?php
	include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_footer.php');
?>