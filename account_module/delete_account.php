<?php
	error_reporting(-1);
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php'); 	 
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');
	//require_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_header.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_security.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
	$objMember = new member1(); 
	$lookupObject = new lookup();
	$member_id = htmlspecialchars(trim($_SESSION['SESS_MEMBER_ID']));
	$sql = mysqli_query($con, "select * from member where member_id='".$member_id."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);	
	if(isset($_POST['submit'])){				
	$code = md5(randomCode(6));
	$InactiveIDRem =  $lookupObject->getLookupKey("MEMBER STATUS", "INACTIVE");
	$memberResult = $objMember->update_member_columns($member_id,"status",$InactiveIDRem);
	$memberResult = $objMember->update_member_columns($member_id,"activation_key",$code);
	unset($_SESSION['SESS_MEMBER_ID']);
	session_destroy();
	$year = time() - 2592000;
	unset($_COOKIE['remember_me']);
	setcookie ("remember_me", "", $year);
		
		header("location: ".$base_url."index.php?deact=".$code."");
		exit();
	}
	
?>
	 <div class="insideWrapper container"> 
		<div class="col-lg-8" style="background:#fff;" >
			

<h2><?php echo $lang['Deactivate Account'];?></h2>
<ul class="nav nav-pills">
<li role="presentation"><a href="<?php echo SITE_URL;?>/privacy.php"><?php echo $lang['Privacy'];?></a></li>
<li role="presentation"> <a href="<?php echo SITE_URL;?>/blocking.php"><?php echo $lang['Blocking'];?></a></li>
<li role="presentation"><a href="<?php echo SITE_URL;?>/account_settings.php"><?php echo $lang['Account Settings'];?></a></li>
<li role="presentation" class="active"><a href="<?php echo SITE_URL;?>/delete_account.php"><?php echo $lang['Deactivate Account'];?></a></li>
</ul>





<form name="account_form" id="account_form" method="post"><br/>
<div class="alert alert-warning" role="alert"><?php echo $lang['Are you sure you want to deactivate your account'].'?';?></div>
<div class="alert alert-info" role="alert"><?php echo $lang['You can activate your account later'];?>.</div>

<input type="hidden" name="member_id" id="member_id" value="<?php echo $member_id;?>" />

<input type="submit" class="btn btn-warning" name="submit" value="<?php echo $lang['confirm'];?>" />

<input type="button" onclick="history.back(); return false;" value="<?php echo $lang['Cancel'];?>" class="btn btn-success" />

</form>

</div>
<?php
	include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_footer.php');
?>