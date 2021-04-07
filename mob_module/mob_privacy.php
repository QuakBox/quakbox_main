<?php 

	session_start();

	

	error_reporting(0);

	if(!isset($_SESSION['SESS_MEMBER_ID']))

	{

		header("location:login.php?back=". urlencode($_SERVER['REQUEST_URI']));

	}

	if(isset($_SESSION['lang']))

	{	

		include('common.php');

	}

	else

	{

		include('en.php');

		

	}

	require_once('config.php');

	$member_id = $_SESSION['SESS_MEMBER_ID'];

	if(!isset($_SESSION['SESS_MEMBER_ID']))

	{

		header("location:index.php");

	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<title><?php echo $lang['Privacy'];?></title>

<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0">


<link rel="icon" href="images/favicon.ico" type="image" />

<link rel="shortcut icon" href="images/favicon.ico" type="image" />

<link rel="stylesheet" type="text/css" href="css/style.css"/>

<link rel="stylesheet" type="text/css" href="css/group.css"/>

<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>font-awesome/css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="css/responsive.css"/>

<script src="js/jquery.livequery.js" type="text/javascript"></script>

<script src="js/jquery.oembed.js"></script>

<script src="js/jquery-1.9.1.js"></script>

<script src="js/jquery-ui.js"></script>

<script src="js/jquery-1.7.2.min.js"></script>

<script type="text/javascript">

jQuery(function(){

$('#boxclose').click(function(){	

	$('.box').hide();

});

});

</script>

</head>

<body id="mob_privacy">

<div id="wrapper">

<?php include('includes/header.php');?>

<div id="mainbody">

<div class="column_left">



	<?php 

	if(isset($_GET['err'])){

if($_GET['err'] == null){ 

?>

<div class="box" id="box" style="left:13%; right:16%">

<a class="boxclose" id="boxclose"></a>

<div class="alert-box" style="padding:10px 26px 10px 36px"><span><?php echo $lang['Your settings have been saved'];?>.</span></div>

</div>

<?php

}

}

?>

    <div class="componentheading">

    <div id="submenushead"><?php echo $lang['Privacy'];?></div>

    </div>

    <div id="submenushead">

    <ul class="dropDown">

    <li><a href="mob_privacy.php"><?php echo $lang['Privacy'];?></a></li>

    <li><a href="mob_blocking.php"><?php echo $lang['Blocking'];?></a></li>

  <li><a href="mob_account_settings.php"><?php echo $lang['Account Settings'];?></a></li>

  <li><a href="mob_delete_account.php"><?php echo $lang['delete account'];?></a></li>

   <!-- 	<li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="create_groups.php">Create</a></li>

    <li style="padding:0 8px;"><a href="groups_search.php">Search</a></li>    -->

	</ul>

   </div>



<div id="border"> 

<div>

<form name="find_friend" id="find_friend" action="action/privacy-exec.php" method="post">

<input type="hidden" name="member_id" value="<?php echo $member_id;?>" />

<div class="ctitle">

<h2 style="font-size:110%;"><?php echo $lang['Edit your privacy settings'];?></h2>
<br />
</div>



<?php

		$nquery = "SELECT * FROM privacy where privacy_member_id= '$member_id'";

		$nsql = mysql_query($nquery);

		$res= mysql_fetch_array($nsql);

		

?>







<p><?php echo $lang['Configure who is able to view your information'];?>.</p>
<br />
<div class="formtable" style="width:100% !important;">

<div style="clear:both;">
<div style="font-weight: bold; text-align: left; padding: 5px; vertical-align: top; float: left; width: 22%;">

<label style="font-weight: 700;text-align: right;"><?php echo $lang['Profile'];?></label>

</div>

<div style="padding:5px; vertical-align:top;">

<input id="profile-public" type="radio" value="0" <?php echo ($res['profile'] == '0')? "checked='checked'" : "";?> name="privacyProfileView"></input>

<label class="lblradio" for="profile-public" style="display:inline;"><?php echo $lang['Public'];?></label>

<input id="profile-members" type="radio" name="privacyProfileView" value="1" <?php echo ($res['profile'] == '1')? "checked='checked'" : "";?>></input>

<label class="lblradio" for="profile-members" style="display:inline;"><?php echo $lang['Site Members'];?></label>

<input id="profile-friends" type="radio" name="privacyProfileView" value="2" <?php echo ($res['profile'] == '2')? "checked='checked'" : "";?>></input>

<label class="lblradio" for="profile-friends" style="display:inline;"><?php echo $lang['Friends'];?></label>

</div>
</div>


<div style="clear:both;">

<div style="font-weight: bold; text-align: left; padding: 5px; vertical-align: top; float: left; width: 22%;">

<label style="font-weight: 700;text-align: right;"><?php echo $lang['Friends'];?></label>

</div>

<div style="padding:5px; vertical-align:top;">

<input id="friends-public" type="radio" value="0" <?php echo ($res['friends'] == '0')? "checked='checked'" : "";?> name="privacyFriendsView"></input>

<label class="lblradio" for="friends-public" style="display:inline;"><?php echo $lang['Public'];?></label>

<input id="friends-members" type="radio" name="privacyFriendsView" value="1" <?php echo ($res['friends'] == '1')? "checked='checked'" : "";?>></input>

<label class="lblradio" for="friends-members" style="display:inline;"><?php echo $lang['Site Members'];?></label>

<input id="friends-friends" type="radio" name="privacyFriendsView" value="2" <?php echo ($res['friends'] == '2')? "checked='checked'" : "";?>></input>

<label class="lblradio" for="friends-friends" style="display:inline;"><?php echo $lang['Friends'];?></label>

</div>
</div>


<div style="clear:both;">

<div style="font-weight: bold; text-align: left; padding: 5px; vertical-align: top; float: left; width: 22%;">

<label style="font-weight: 700;text-align: right;"><?php echo $lang['Photos'];?></label>

</div>

<div style="padding:5px; vertical-align:top;">

<input id="photo-public" type="radio" value="0" <?php echo ($res['photo'] == '0')? "checked='checked'" : "";?> name="privacyPhotoView"></input>

<label class="lblradio" for="photo-public" style="display:inline;"><?php echo $lang['Public'];?></label>

<input id="photo-members" type="radio" name="privacyPhotoView" value="1" <?php echo ($res['photo'] == '1')? "checked='checked'" : "";?>></input>

<label class="lblradio" for="photo-members" style="display:inline;"><?php echo $lang['Site Members'];?></label>

<input id="photo-friends" type="radio" name="privacyPhotoView" value="2" <?php echo ($res['photo'] == '2')? "checked='checked'" : "";?>></input>

<label class="lblradio" for="photo-friends" style="display:inline;"><?php echo $lang['Friends'];?></label>
<br />
</div>
</div>
</div>

<br />

<div class="ctitle">

<h2 style="font-size:110%;"><?php echo $lang['Emails and notifications'];?></h2>

</div>

<div class="formtable" style="width:100% !important;>
<div style="clear:both;">
<div style="font-weight: bold; text-align: left; width: 200px; padding: 5px; vertical-align: top; float: left;">

<label style="font-weight: 700;text-align: right;"><?php echo $lang['Receive system emails'];?></label>

</div>

<div style="padding:5px; vertical-align:top;">

<input id="email-privacy-yes" type="radio" value="1" <?php echo ($res['receive_email'] == '1')? "checked='checked'" : "";?> name="notifyEmailSystem"></input>

<label class="lblradio" for="email-privacy-yes" style="display:inline;"><?php echo $lang['Yes'];?></label>

<input id="email-privacy-no" type="radio" name="notifyEmailSystem" value="0" <?php echo ($res['receive_email'] == '0')? "checked='checked'" : "";?>></input>

<label class="lblradio" for="email-privacy-no" style="display:inline;"><?php echo $lang['No'];?></label>

</div>
</div>

<div style="clear:both;">

<div style="font-weight: bold; text-align: left; width: 200px; padding: 5px; vertical-align: top; float: left;">

<label style="font-weight: 700;text-align: right;"><?php echo $lang['Receive application notifications'];?>	</label>

</div>

<div style="padding:5px; vertical-align:top;">

<input id="email-app-yes" type="radio"  value="1" <?php echo ($res['receive_notification'] == '1')? "checked='checked'" : "";?> name="notifyEmailAps"></input>

<label class="lblradio" for="email-app-yes" style="display:inline;"><?php echo $lang['Yes'];?></label>

<input id="email-app-no" type="radio" name="notifyEmailAps" value="0" <?php echo ($res['receive_notification'] == '0')? "checked='checked'" : "";?>></input>

<label class="lblradio" for="email-app-no" style="display:inline;"><?php echo $lang['No'];?></label>

</div>
</div>
<div style="clear:both;">


<div style="font-weight: bold; text-align: left; width: 200px; padding: 5px; vertical-align: top; float: left;">

<label style="font-weight: 700;text-align: right;"><?php echo $lang['Receive wall comment notification'];?></label>

</div>

<div style="padding:5px; vertical-align:top;">

<input id="email-wallcomment-yes" type="radio"  value="1" <?php echo ($res['comment_notification'] == '1')? "checked='checked'" : "";?> name="notifyWallComment"></input>

<label class="lblradio" for="email-wallcomment-yes" style="display:inline;"><?php echo $lang['Yes'];?></label>

<input id="email-wallcomment-no" type="radio" name="notifyWallComment" value="0" <?php echo ($res['comment_notification'] == '0')? "checked='checked'" : "";?>></input>

<label class="lblradio" for="email-wallcomment-no" style="display:inline;"><?php echo $lang['No'];?></label>

</div>
</div>
</div>
<div style="padding:5px; vertical-align:top; margin-top: 20px;">

<input type="submit" value="<?php echo $lang['Save'];?>" name="action" class="button"></input>

</div>

</form>
</div>

<br>
<div class="app-box" style="margin-bottom:25px;">
<br>
<h2 class="app-box-title"><?php echo $lang['My block List'];?></h2>

</div>

<ul>

<?php 

$block_sql = mysql_query("select * from blocklist b,members m where b.blocked_userid=m.member_id and userid = '$member_id'");

while($block_res = mysql_fetch_array($block_sql))

{

?>

<li style="list-style:square;">

<div style="">

<span><?php echo $block_res['username'];?></span>

<a href="action/remove_block_friend.php?member_id=<?php echo $block_res['member_id'];?>"><?php echo $lang['Unblock'];?></a>

</div>

</li>

<?php 

}

?>

</ul>



</div><!--end border div-->

</div><!--end column_left div-->



<!--<div class="column_right">

   <div id="ads" style="width:220; float:left;">

   <h3>Partners

   <a href="add_ads.php" style="margin-left:55px;">Create Ads</a>   

   </h3>

   </div>

   <?php 

   $ads_sql = mysql_query("select * from ads order by ads_id");

   while($ads_res = mysql_fetch_array($ads_sql))

   {

   ?>

      

		<div style="border-bottom: 1px solid #DDDDDD;float: left;margin: 0px;padding-top: 0px;width: 220px;">

        <div style="font-size: 13px;font-weight: bold;padding: 5px 0;color: #005689;">

        <a href=""><?php echo $ads_res['ads_title'];?></a>

        </div>

        <div style="float: left;padding-right: 8px; padding-top:3px; display:inline;">        

        <a href="" target="_blank">

        <img src="<?php echo $ads_res['ads_pic'];?>" width="100" height="72"/>

        </a>

         <div style="font-size: 12px;padding: 0 5px 5px;line-height: 13px;">

        <?php echo $ads_res['ads_content'];?>

        </div>

               

        <?php 



$ads_like_sql = mysql_query("SELECT * FROM ads_like WHERE ads_id='". $ads_res['ads_id'] ."'");

$ads_like_count = mysql_num_rows($ads_like_sql);



if($ads_like_count > 0) 

{ 

$ads_query=mysql_query("SELECT m.username,m.member_id FROM ads_like a, members m WHERE m.member_id=a.member_id AND a.ads_id='".$ads_res['ads_id']."' LIMIT 3");

$ads_like = mysql_num_rows($ads_query);

?>

<div class="adsPanel">

<div class='likeUsers' id="ads_likes<?php echo $ads_res['ads_id']; ?>">

<?php

while($ads_query_res = mysql_fetch_array($ads_query))

{

$ads_like_uid=$ads_query_res['member_id']; 

$ads_likeusername=$ads_query_res['username']; 

if($ads_like_uid==$ads_res['ad_creator'])

{

echo '<span id="'.$lan['You'].$ads_res['ads_id'].'"><a href="'.$ads_likeusername.'">'.$lan['You'].'</a></span>';

}

else

{ 

echo '<a href="'.$ads_likeusername.'">'.$ads_likeusername.'</a>';

}  

}

echo $lang['AND'].$ads_like_count.$lang['other friends like this'];

?> 

</div></div>

<?php }

else { 

echo '<div class="likeUsers" id="ads_elikes'.$ads_res['ads_id'].'"></div>';



} 

$q1 = mysql_query("SELECT * FROM ads_like WHERE member_id='". $_SESSION['SESS_MEMBER_ID'] ."' and ads_id='".$ads_res['ads_id']."' ");



if(mysql_num_rows($q1) <= 0)

{

?>



          <div style="float: left;width: 18%;color: #005689;cursor: pointer;position: relative;top: 2px;margin-left: 10px;">

                 

          <a href="javascript:void(0)" class="ads_like" id="like_ads<?Php echo $ads_res['ads_id'];?>" title="Like" rel="Like">Like</a>

          </div>

          <?php } else

		  {?>

          

          <div style="float: left;width: 18%;color: #005689;cursor: pointer;position: relative;top: 2px;margin-left: 10px;">

                

          <a href="javascript:void(0)" class="ads_like" id="like_ads<?Php echo $ads_res['ads_id'];?>" title="Unlike" rel="Unlike">Unlike</a>

          </div>

<?php } ?>

        </div>

        </div>

       

       

     <?php 

   }

	 ?>

  	</div><!--end column_right div-->



</div><!--end mainbody div-->

<?php include 'includes/footer.php';?>

</div><!--end wrapper div-->





</body>

</html>