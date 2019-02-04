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

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<title><?php echo $lang['Manage Blocking'];?></title>

<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0">


<link rel="icon" href="images/favicon.ico" type="image" />

<link rel="shortcut icon" href="images/favicon.ico" type="image" />

<link rel="stylesheet" type="text/css" href="css/style.css"/>

<link rel="stylesheet" type="text/css" href="css/group.css"/>

<link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.css"/>

<link rel="stylesheet" type="text/css" href="css/jquery-ui.css"/>

<link rel="stylesheet" type="text/css" href="css/responsive.css"/>


<script src="js/jquery.livequery.js" type="text/javascript"></script>

<script src="js/jquery.oembed.js"></script>

<script src="js/jquery-1.9.1.js"></script>

<script src="js/jquery-ui.js"></script>

<script type="text/javascript">

$(function() {

 $("#member_name").autocomplete({

	 source: "load_data/member_names_ajax.php",			

			select: true

 });

});

</script>

</head>

<body id="acc_privacy">

<div id="wrapper">

<?php include('includes/header.php');?>

<div id="mainbody">

<div class="column_left"  style="position:relative;">

	

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

<form name="find_friend" id="find_friend" action="action/add_block_friend.php" method="post">

<input type="text" name="member_name" id="member_name" class="textbox" style="margin-left:0px; width:50%; padding:5px;" />

<input type="hidden" name="member_id" id="member_id" value="<?php echo $member_id;?>" />

<input type="submit" name="submit" class="button" value="<?php echo $lang['block'];?>" />

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