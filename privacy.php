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

	
?>

	 <div class="insideWrapper container"> 
		<div class="col-lg-8" style="background:#fff;" >
			

<h2><?php echo $lang['Privacy'];?></h2>
<ul class="nav nav-pills">
<li role="presentation" class="active"><a href="<?php echo SITE_URL;?>/privacy.php"><?php echo $lang['Privacy'];?></a></li>
<li role="presentation"> <a href="<?php echo SITE_URL;?>/blocking.php"><?php echo $lang['Blocking'];?></a></li>
<li role="presentation"><a href="<?php echo SITE_URL;?>/account_settings.php"><?php echo $lang['Account Settings'];?></a></li>
<li role="presentation"><a href="<?php echo SITE_URL;?>/delete_account.php"><?php echo $lang['deactivate account'];?></a></li>
</ul>




<h2><?php echo $lang['Edit your privacy settings'];?></h2>
<div id="msg" class="alert alert-danger" role="alert" style="display:none;"></div>
<form name="find_friend" id="find_friend" action="action/privacy-exec.php" method="post">

<input type="hidden" name="member_id" value="<?php echo $member_id;?>" />

<div class="ctitle">


</div>



<?php

		$nquery = "SELECT * FROM privacy where privacy_member_id= '$member_id'";

		$nsql = mysqli_query($con, $nquery);

		$res= mysqli_fetch_array($nsql);

		

?>







<p><?php echo $lang['Configure who is able to view your information'];?>.</p>

<table class="formtable">

<tbody>

<tr><td colspan="2"></td></tr>

<tr>

<td style="font-weight: bold;text-align: right;width: 200px; padding:5px;vertical-align:top;">

<label style="font-weight: 700;text-align: right;"><?php echo $lang['Profile Photo'];?></label>

</td>

<td style="padding:5px; vertical-align:top;">

<input id="profile-public" type="radio" value="0" <?php echo ($res['profile'] == '0')? "checked='checked'" : "";?> name="privacyProfileView"></input>

<label class="lblradio" for="profile-public" style="display:inline;"><?php echo $lang['Public'];?></label>

<input id="profile-friends" type="radio" name="privacyProfileView" value="2" <?php echo ($res['profile'] == '2')? "checked='checked'" : "";?>></input>

<label class="lblradio" for="profile-friends" style="display:inline;"><?php echo $lang['Friends'];?></label>

<input id="profile-members" type="radio" name="privacyProfileView" value="1" <?php echo ($res['profile'] == '1')? "checked='checked'" : "";?>></input>

<label class="lblradio" for="profile-members" style="display:inline;"><?php echo $lang['only me'];?></label>



</td>

</tr>

<tr>

<td style="font-weight: bold;text-align: right;width: 200px; padding:5px;vertical-align:top;">

<label style="font-weight: 700;text-align: right;"><?php echo $lang['Friends'];?></label>

</td>

<td style="padding:5px; vertical-align:top;">

<input id="friends-public" type="radio" value="0" <?php echo ($res['friends'] == '0')? "checked='checked'" : "";?> name="privacyFriendsView"></input>

<label class="lblradio" for="friends-public" style="display:inline;"><?php echo $lang['Public'];?></label>

<input id="friends-friends" type="radio" name="privacyFriendsView" value="2" <?php echo ($res['friends'] == '2')? "checked='checked'" : "";?>></input>

<label class="lblradio" for="friends-friends" style="display:inline;"><?php echo $lang['Friends'];?></label>

<input id="friends-members" type="radio" name="privacyFriendsView" value="1" <?php echo ($res['friends'] == '1')? "checked='checked'" : "";?>></input>

<label class="lblradio" for="friends-members" style="display:inline;"><?php echo $lang['only me'];?></label>


</td>

</tr>

<tr>

<td style="font-weight: bold;text-align: right;width: 200px; padding:5px;vertical-align:top;">

<label style="font-weight: 700;text-align: right;"><?php echo $lang['Gender'];?></label>

</td>

<td style="padding:5px; vertical-align:top;">

<input id="gender-public" type="radio" value="0" <?php echo ($res['gender'] == '0')? "checked='checked'" : "";?> name="privacyGenderView"></input>

<label class="lblradio" for="gender-public" style="display:inline;"><?php echo $lang['Public'];?></label>


<input id="gender-friends" type="radio" name="privacyGenderView" value="2" <?php echo ($res['gender'] == '2')? "checked='checked'" : "";?>></input>

<label class="lblradio" for="gender-friends" style="display:inline;"><?php echo $lang['Friends'];?></label>


<input id="gender-members" type="radio" name="privacyGenderView" value="1" <?php echo ($res['gender'] == '1')? "checked='checked'" : "";?>></input>

<label class="lblradio" for="gender-members" style="display:inline;"><?php echo $lang['only me'];?></label>

</td>

</tr>

<tr>

<td style="font-weight: bold;text-align: right;width: 200px; padding:5px;vertical-align:top;">

<label style="font-weight: 700;text-align: right;"><?php echo $lang['Email'];?></label>

</td>

<td style="padding:5px; vertical-align:top;">

<input id="email-public" type="radio" value="0" <?php echo ($res['email'] == '0')? "checked='checked'" : "";?> name="privacyEmailView"></input>

<label class="lblradio" for="email-public" style="display:inline;"><?php echo $lang['Public'];?></label>


<input id="email-friends" type="radio" name="privacyEmailView" value="2" <?php echo ($res['email'] == '2')? "checked='checked'" : "";?>></input>

<label class="lblradio" for="email-friends" style="display:inline;"><?php echo $lang['Friends'];?></label>


<input id="email-members" type="radio" name="privacyEmailView" value="1" <?php echo ($res['email'] == '1')? "checked='checked'" : "";?>></input>

<label class="lblradio" for="email-members" style="display:inline;"><?php echo $lang['only me'];?></label>

</td>

</tr>
<tr>

<td style="font-weight: bold;text-align: right;width: 200px; padding:5px;vertical-align:top;">

<label style="font-weight: 700;text-align: right;"><?php echo $lang['Birthday'];?></label>

</td>

<td style="padding:5px; vertical-align:top;">

<input id="birthday-public" type="radio" value="0" <?php echo ($res['birthday'] == '0')? "checked='checked'" : "";?> name="privacyBirthdayView"></input>

<label class="lblradio" for="birthday-public" style="display:inline;"><?php echo $lang['Public'];?></label>


<input id="birthday-friends" type="radio" name="privacyBirthdayView" value="2" <?php echo ($res['birthday'] == '2')? "checked='checked'" : "";?>></input>

<label class="lblradio" for="birthday-friends" style="display:inline;"><?php echo $lang['Friends'];?></label>


<input id="birthday-members" type="radio" name="privacyBirthdayView" value="1" <?php echo ($res['birthday'] == '1')? "checked='checked'" : "";?>></input>

<label class="lblradio" for="birthday-members" style="display:inline;"><?php echo $lang['only me'];?></label>

</td>

</tr>

<tr>

<td style="font-weight: bold;text-align: right;width: 200px; padding:5px;vertical-align:top;">

<label style="font-weight: 700;text-align: right;"><?php echo $lang['Mobile No'];?></label>

</td>

<td style="padding:5px; vertical-align:top;">

<input id="mobileno-public" type="radio" value="0" <?php echo ($res['mobileno'] == '0')? "checked='checked'" : "";?> name="privacyMobileNoView"></input>

<label class="lblradio" for="mobileno-public" style="display:inline;"><?php echo $lang['Public'];?></label>


<input id="mobileno-friends" type="radio" name="privacyMobileNoView" value="2" <?php echo ($res['mobileno'] == '2')? "checked='checked'" : "";?>></input>

<label class="lblradio" for="mobileno-friends" style="display:inline;"><?php echo $lang['Friends'];?></label>


<input id="mobileno-members" type="radio" name="privacyMobileNoView" value="1" <?php echo ($res['mobileno'] == '1')? "checked='checked'" : "";?>></input>

<label class="lblradio" for="mobileno-members" style="display:inline;"><?php echo $lang['only me'];?></label>

</td>

</tr>

<tr>

<td style="font-weight: bold;text-align: right;width: 200px; padding:5px;vertical-align:top;">

<label style="font-weight: 700;text-align: right;"><?php echo $lang['Work and Education'];?></label>

</td>

<td style="padding:5px; vertical-align:top;">
 
<input id="WorkandEducation-public" type="radio" value="0" <?php echo ($res['workandeducation'] == '0')? "checked='checked'" : "";?> name="privacyWorkandEducationView"></input>

<label class="lblradio" for="WorkandEducation-public" style="display:inline;"><?php echo $lang['Public'];?></label>


<input id="WorkandEducation-friends" type="radio" name="privacyWorkandEducationView" value="2" <?php echo ($res['workandeducation'] == '2')? "checked='checked'" : "";?>></input>

<label class="lblradio" for="WorkandEducation-friends" style="display:inline;"><?php echo $lang['Friends'];?></label>


<input id="WorkandEducation-members" type="radio" name="privacyWorkandEducationView" value="1" <?php echo ($res['workandeducation'] == '1')? "checked='checked'" : "";?>></input>

<label class="lblradio" for="WorkandEducation-members" style="display:inline;"><?php echo $lang['only me'];?></label>

</td>

</tr>


<tr>

<td style="font-weight: bold;text-align: right;width: 200px; padding:5px;vertical-align:top;">

<label style="font-weight: 700;text-align: right;"><?php echo $lang['Photos'];?></label>

</td>

<td style="padding:5px; vertical-align:top;">

<input id="photo-public" type="radio" value="0" <?php echo ($res['photo'] == '0')? "checked='checked'" : "";?> name="privacyPhotoView"></input>

<label class="lblradio" for="photo-public" style="display:inline;"><?php echo $lang['Public'];?></label>


<input id="photo-friends" type="radio" name="privacyPhotoView" value="2" <?php echo ($res['photo'] == '2')? "checked='checked'" : "";?>></input>

<label class="lblradio" for="photo-friends" style="display:inline;"><?php echo $lang['Friends'];?></label>


<input id="photo-members" type="radio" name="privacyPhotoView" value="1" <?php echo ($res['photo'] == '1')? "checked='checked'" : "";?>></input>

<label class="lblradio" for="photo-members" style="display:inline;"><?php echo $lang['only me'];?></label>

</td>

</tr>

</tbody>

</table>

<div class="ctitle">

<h2><?php echo $lang['Emails and notifications'];?></h2>

</div>

<table class="formtable">

<tbody>

<tr><td colspan="2"></td></tr>

<tr>

<td style="font-weight: bold;text-align: right;width: 200px; padding:5px;vertical-align:top;">

<label style="font-weight: 700;text-align: right;"><?php echo $lang['Receive system emails'];?></label>

</td>

<td style="padding:5px; vertical-align:top;">

<input id="email-privacy-yes" type="radio" value="1" <?php echo ($res['receive_email'] == '1')? "checked='checked'" : "";?> name="notifyEmailSystem"> </input>

<label class="lblradio" for="email-privacy-yes" style="display:inline;"><?php echo $lang['Yes'];?></label>

<input id="email-privacy-no" type="radio" name="notifyEmailSystem" value="0" <?php echo ($res['receive_email'] == '0')? "checked='checked'" : "";?>></input>

<label class="lblradio" for="email-privacy-no" style="display:inline;"><?php echo $lang['No'];?></label>

</td>



</tr>

<tr>

<td style="font-weight: bold;text-align: right;width: 200px; padding:5px;vertical-align:top;">

<label style="font-weight: 700;text-align: right;"><?php echo $lang['Receive application notifications'];?>	</label>

</td>

<td style="padding:5px; vertical-align:top;">

<input id="email-app-yes" type="radio"  value="1" <?php echo ($res['receive_notification'] == '1')? "checked='checked'" : "";?> name="notifyEmailAps"></input>

<label class="lblradio" for="email-app-yes" style="display:inline;"><?php echo $lang['Yes'];?></label>

<input id="email-app-no" type="radio" name="notifyEmailAps" value="0" <?php echo ($res['receive_notification'] == '0')? "checked='checked'" : "";?>></input>

<label class="lblradio" for="email-app-no" style="display:inline;"><?php echo $lang['No'];?></label>

</td>

</tr>

<tr>

<td style="font-weight: bold;text-align: right;width: 200px; padding:5px;vertical-align:top;">

<label style="font-weight: 700;text-align: right;"><?php echo $lang['Receive wall comment notification'];?></label>

</td>

<td style="padding:5px; vertical-align:top;">

<input id="email-wallcomment-yes" type="radio"  value="1" <?php echo ($res['comment_notification'] == '1')? "checked='checked'" : "";?> name="notifyWallComment"></input>

<label class="lblradio" for="email-wallcomment-yes" style="display:inline;"><?php echo $lang['Yes'];?></label>

<input id="email-wallcomment-no" type="radio" name="notifyWallComment" value="0" <?php echo ($res['comment_notification'] == '0')? "checked='checked'" : "";?>></input>

<label class="lblradio" for="email-wallcomment-no" style="display:inline;"><?php echo $lang['No'];?></label>

</td>

</tr>

<tr>

<td colspan="2"></td>

</tr>

 <tr>

<td style="font-weight: bold;text-align: right;width: 130px; padding:5px;vertical-align:top;">

</td>

<td style="padding:5px; vertical-align:top;">

<input type="submit" value="<?php echo $lang['Save'];?>" name="action" class="btn btn-success"></input>

</td>

</tr>

</tbody>

</table>

</form>

</div>
<?php
	include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_footer.php');
?>