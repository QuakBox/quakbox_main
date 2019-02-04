<?php 

	session_start();

	//error_reporting(0);

	if(isset($_SESSION['lang']))

	{	

		include('common.php');

	}

	else

	{

		include('Languages/en.php');

		

	}

	require_once('config.php');

	$member_id = $_SESSION['SESS_MEMBER_ID'];

	if(!isset($_SESSION['SESS_MEMBER_ID']))

	{

		header("location: ".$base_url."login.php?back=". urlencode($_SERVER['REQUEST_URI']));
		exit();

	}

	$sql = mysqli_query($con, "select * from members where member_id='".$member_id."'") or die(mysqli_error($con));

	$res = mysqli_fetch_array($sql);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<title><?php echo $lang['Search Groups'];?></title>

<head>



<link rel="icon" href="images/favicon.ico" type="image" />

<link rel="shortcut icon" href="images/favicon.ico" type="image" />

<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>font-awesome/css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/responsive.css" />


<link rel="stylesheet" type="text/css" href="css/group.css"/>

<script src="js/jquery.livequery.js" type="text/javascript"></script>

<script src="js/jquery.oembed.js"></script>

<script src="js/jquery-1.9.1.js"></script>

<script src="js/jquery-ui.js"></script>

<script src="js/jquery-1.7.2.min.js"></script>
<script src="<?php echo $base_url;?>js/check.js"></script>
</head>

<body>

<div id="wrapper">

<?php include('includes/header.php');?>

<div id="mainbody">

<div class="column_left">

	

    <div class="componentheading">

    <div id="submenushead"><?php echo $lang['Search Groups'];?></div>

    </div>

    <div id="submenushead">

    <ul class="dropDown">

    <li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="groups_all.php"><?php echo $lang['All Groups'];?></a></li>

    <li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="<?php echo $base_url.'groups/'.$res['username'];?>"><?php echo $lang['My Groups'];?></a></li>

    <li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href=""><?php echo $lang['Pending Invitations'];?></a></li>

  	<li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="create_groups.php"><?php echo $lang['Create'];?></a></li>

    <li style="padding:0 8px;"><a href="groups_search.php"><?php echo $lang['Search'];?></a></li>    

	</ul>

   </div>



<div id="border"> 

<form name="find_friend" id="find_friend srch_grp" action="" method="post">

<input type="text" name="group_name" class="textbox srch_txt" size="50" style="margin-left:0px;" />

<input type="submit" name="submit" class="button srch_btn" value="<?php echo $lang['Search'];?>" />

</form>

<br />

<br />



   

<?php 

if(isset($_REQUEST['submit']))

{	

	$first_name = $_REQUEST['group_name'];	

	$friend = mysqli_query($con, "select * from groups where name like '%$first_name%'") ;

	$group_count = mysqli_num_rows($friend);

?>

	<!--SEARCH DETAIL-->

		<div class="group-search-detail">

			<span class="search-detail-left">

				<?php echo $lang['Search Result for'].$first_name; ?>

			</span>

			<span class="search-detail-right">

				<?php echo $lang['Total Groups Found:'].$group_count; ?>

			</span>

			<div style="clear:both;"></div>

		</div>

		<!--SEARCH DETAIL-->

<?php	

while($row = mysqli_fetch_array($friend))

{	

		

?>

<div class="community-groups-results-item" style="border:medium none; line-height:1.5em;">

<div class="community-events-results-left">

<a href="view_groups.php?group_id=<?php echo $row['id'];?>">

<img src="<?php echo $row['avatar'];?>" height="68" width="68" />

</a>

</div>

<div class="community-events-results-right">

<h3><a href="view_groups.php?group_id=<?php echo $row['id'];?>"><?php echo $row['name'];?></a></h3>



<div class="groupDescription"><?php echo $row['description'];?></div>

<div class="small"><?php echo $lang['Created on: Thursday, 18 July 2013'];?></div>

<div class="groupActions">

<span class="icon-group" style="margin-right:5px;"><a href="">1 <?php echo $lang['Member'];?></a></span>

<span class="icon-discuss" style="margin-right:5px;"><a href="">0 <?php echo $lang['Discusions'];?></a></span>

<span class="icon-wall" style="margin-right:5px;"><a href="">0 <?php echo $lang['Wall Posts'];?></a></span>

</div>

</div>

<?php

	}

}

?>

</div>

</div><!--end column_left div-->

<?php include 'ads_right_column.php';?>

<!--end column_right div-->



</div><!--end mainbody div-->

<?php include 'includes/footer.php';?>

</div><!--end wrapper div-->





</body>

</html>