<?php 

	session_start();

	//error_reporting(0);

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

	$member_sql = mysql_query("select * from members where member_id='".$member_id."'");

	$member_res = mysql_fetch_array($member_sql);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<title><?php echo $lang['Deactivate Account'];?></title>

<head>



<link rel="icon" href="images/favicon.ico" type="image" />

<link rel="shortcut icon" href="images/favicon.ico" type="image" />

<link rel="stylesheet" type="text/css" href="css/style.css"/>

<link rel="stylesheet" type="text/css" href="css/group.css"/>

<link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.css"/>

<link rel="stylesheet" type="text/css" href="css/responsive.css"/>


<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>

<script src="js/jquery.livequery.js" type="text/javascript"></script>

<script src="js/jquery.oembed.js"></script>

<script src="js/jquery-1.9.1.js"></script>

<script src="js/jquery-ui.js"></script>

<script src="js/jquery-1.7.2.min.js"></script>

<script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>

	<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript">

jQuery(function(){

        $("#submit").click(function(){

        $(".error").hide();

        var hasError = false;

        var passwordVal = $("#password").val();

        var checkVal = $("#cpassword").val();

        

		if(passwordVal.length != 0)

		{

		if(passwordVal.length < 6)

		{

			$("#password").after('<span class="error"><?php echo $lang['Your password is too short! Please enter a minimum of 6 characters'];?>.</span>');

            hasError = true;

		}

        else if (passwordVal != checkVal ) {

            $("#cpassword").after('<span class="error"><?php echo $lang['Passwords do not match'];?>.</span>');

            hasError = true;

        }

		}

        if(hasError == true) {return false;}

    });





$('#boxclose').click(function(){	

	$('.box').hide();

});

});		

</script>

<style type="text/css">

.error {

    margin-left: 10px;

	 color: rgb(204, 0, 0);

    font-size: 12px;

}

</style>

</head>

<body id="delete_acc">

<div id="wrapper">

<?php include('includes/header.php');?>

<div id="mainbody">

<div class="column_left"  style="position:relative;">

	<?php 

	if(isset($_GET['err'])){

if($_GET['err'] == null){ 

?>

<div class="box" id="box">

<a class="boxclose" id="boxclose"></a>

<div class="alert-box"><span><?php echo $lang['Your settings have been saved'];?>.</span></div>

</div>

<?php

}

}

?>

    <div class="componentheading">

    <div id="submenushead"><?php echo $lang['Deactivate Account'];?></div>

    </div>

    <div id="submenushead">

    <ul class="dropDown">

    <li><a href="mob_privacy.php"><?php echo $lang['Privacy'];?></a></li>

    <li><a href="mob_blocking.php"><?php echo $lang['Blocking'];?></a></li>

   <li><a href="mob_account_settings.php"><?php echo $lang['Account Settings'];?></a></li>

   <li><a href="mob_delete_account.php"><?php echo $lang['delete account'];?></a></li>

    <!--<li style="padding:0 8px;"><a href="groups_search.php">Search</a></li>    -->

	</ul>

   </div>



<div id="border"> 

<form name="account_form" id="account_form" action="action/delete_account.php" method="post">

<input type="hidden" name="member_id" value="<?php echo $member_id;?>" />

<div class="ctitle">

<h2 style="font-size:110%;"><?php echo $lang['Are you sure you want to deactivate your account'];?></h2>

</div>

<p style="color:#FF0000; font-weight:bold"><?php echo $lang['This action is permanent. You cannot undo this process'];?>.</p>

<br /><br /><br />

<input type="hidden" name="member_id" id="member_id" value="<?php echo $member_id;?>" />

<input type="submit" class="button" value="<?php echo $lang['confirm'];?>" />

<input type="button" onclick="history.back(); return false;" value="<?php echo $lang['Cancel'];?>" class="button" />

</form>



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

echo '<span id="'.$lang['You'].$ads_res['ads_id'].'"><a href="'.$ads_likeusername.'">'.$lang['You'].'</a></span>';

}

else

{ 

echo '<a href="'.$ads_likeusername.'">'.$ads_likeusername.'</a>';

}  

}

echo $lang['and'].$ads_like_count.$lang[' other friends like this'];

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