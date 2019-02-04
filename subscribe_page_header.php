<?php 
//error_reporting(0);

//echo "<pre>";
//print_r($mres);
//echo $_SESSION['SESS_MEMBER_ID'];
//die();

require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
	  $objMemberHeader1 = new member1(); 
$MessageMemberProfileLogo =$objMemberHeader1->select_member_meta_value($mres['member_id'],'current_profile_image');
if($MessageMemberProfileLogo){			
		$MessageMemberProfilePic =SITE_URL.'/'.$MessageMemberProfileLogo;	
}
else{
	$MessageMemberProfilePic =SITE_URL.'/images/default.png';
}  
if($_SESSION['SESS_MEMBER_ID'] == $mres['member_id']){
	$svquery = mysqli_query($con, "SELECT id FROM videos_subscribe WHERE member_id = '".$_SESSION['SESS_MEMBER_ID']."'");
	$scount = mysqli_num_rows($svquery);
?>
<div id="headLink" class="headLink">
	<div class="subNo"> <a href="<?php echo $base_url;?>subscriber-list.php">
	<span class="sub_no"> <?php echo $scount; ?></span><?php echo $lang['Subscriber'];?> </a></div>
    <div class="myvideo_link"> <a href="<?php echo $base_url;?>myvideos.php"><?php echo $lang['My Video'];?></a></div>
</div>
<?php } ?>


<div class="Profileheader">
<div class="coverImg">
<img src="<?php echo $base_url.$mres['cover_photo']; ?>" alt="<?php echo $mres['username']; ?>" width="100%" height="100%" style="object-fit: cover;"  />
  <!--<img src="<?php echo $MessageMemberProfilePic;?>" alt="<?php //echo $mres['username']; ?>"  class="cover_img_hdr"/> -->
<?php 

if($_SESSION['SESS_MEMBER_ID'] == $mres['member_id']){
?>
<form action="<?php echo $base_url;?>action/change_cover.php" method="post" enctype="multipart/form-data">
<div class="custom_file_upload">	
	<div class="file_upload">
		<input type="file" id="file_upload" name="file_upload" onchange="this.form.submit()">
        <input type="hidden" name="channel_id" value="<?php echo $mres['id']; ?>">
        <input type="hidden" name="username" value="<?php echo $mres['username']; ?>">
	</div>
</div>
</form>
<?php } ?>
</div>
<div style="clear:both;">
<?php 

if($_SESSION['SESS_MEMBER_ID'] != $mres['member_id']){
?>
<div id="subscribe_btn">
<?php 
$subtotsql = mysqli_query($con, "SELECT id FROM videos_subscribe WHERE member_id = '$vmember_id'");
$subtotcount = mysqli_num_rows($subtotsql);


$subsql = mysqli_query($con, "SELECT id FROM videos_subscribe WHERE member_id = '$vmember_id' AND subscriber_member_id = '".$_SESSION['SESS_MEMBER_ID']."'");
$subcount = mysqli_num_rows($subsql);


if($subcount > 0){
?>
 <button class="subscribe_btn btn-danger" id="<?php echo $mres['member_id']; ?>" rel="unsubscribe"><?php echo $lang['UnSubscribe'];?></button> 
<?php } else { if(isset($_SESSION['SESS_MEMBER_ID'])){?>
 <button class="subscribe_btn btn-success" id="<?php echo $mres['member_id']; ?>" rel="subscribe"><?php echo $lang['Subscribe'];?></button>

 <?php } else { ?>
 <button class="subscribe_btn btn-success" onClick="window.open('<?php echo $base_url.'login.php?back='.urlencode($_SERVER['REQUEST_URI']); ?>','_self');"><?php echo $lang['Subscribe'];?></button>
 <?php }} ?>
 
 
 <?php 
 $username = $_REQUEST['username'];
 
 ?>
 <div class="subscribe_no_box">
 <span class="speech-bubble"></span>
 <span id="channel_subscribers_count" class="subscribers-nr"><?php echo $subtotcount; ?></span>
 </div>
 </div>
 
  <div class="userProfile">
 	<?php echo $username ?>
 </div>
 <?php  } ?>
 </div>

 
<div class="prof_img_hdr">
   <!-- <img src="<?php echo $base_url.$mres['profImage']; ?>" alt="<?php echo $mres['username']; ?>" class="profile_img" />-->
   <img src="<?php echo $MessageMemberProfilePic;?>" alt="<?php echo $mres['username']; ?>"  class="profile_img"/> 
</div>




</div>