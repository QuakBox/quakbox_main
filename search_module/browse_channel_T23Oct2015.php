<?php

	ob_start();

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

	@$session_member_id = $_SESSION['SESS_MEMBER_ID'];	

	include 'includes/time_stamp.php';
	include 'includes/video-time.php';		
	
	if($session_member_id)
	{		
		$sql = mysqli_query($con, "select * from members where member_id='".$session_member_id."'") or die(mysqli_error($con));
		$res = mysqli_fetch_array($sql);
	}

		

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<title><?php echo "Browse Stations";?></title>

<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" type="text/css" href="css/wall.css"/>

<link rel="stylesheet" type="text/css" href="css/search.css"/>

<link rel="stylesheet" type="text/css" href="css/searchTextButton.css"/>

<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />

<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css" />

<link rel="stylesheet" type="text/css" href="css/my_videos_wall.css" />


<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>font-awesome/css/font-awesome.css">

<link rel="stylesheet" type="text/css" href="css/responsive.css" />

<link rel="icon" href="images/favicon.ico" type="image" />

<link rel="shortcut icon" href="images/favicon.ico" type="image" />
<link rel="stylesheet" type="text/css" href="css/style.css"/>

<link rel="stylesheet" type="text/css" href="css/bootstrap-reset.css" />
<link rel="stylesheet" type="text/css" href="css/mobDesign_videoPage.css" />
<link rel="stylesheet" type="text/css" href="css/subscribeProfilePage.css" />




<script src="js/bootstrap.min.js"></script>

<script src="js/jquery.min.js"></script>

<script src="js/jquery-1.9.1.js"></script>
<script src="<?php echo $base_url;?>js/check.js"></script>
<script src="js/ibox.js"></script>

<link rel="stylesheet" type="text/css" href="css/jquery-ui.css" />

<script src="js/jquery-ui.js"></script>



 <link rel="stylesheet" type="text/css" href="css/youtube.css"/>

<script type="text/javascript">

$(document).ready (function () {

	
 

    // add multiple select / deselect functionality

    $("#selectall").click(function () {	
	$(".video-checkbox").prop("checked",$("#selectall").prop("checked"))
         
    }); 

    // if all checkbox are selected, check the selectall checkbox

    // and viceversa

    $(".video-checkbox").click(function(){ 

        if($(".video-checkbox").length == $(".video-checkbox:checked").length) {
            $("#selectall").attr('checked',true);

        } else {

            $("#selectall").removeAttr("checked");

        }

 

    });

}) ;





$( document).on( 'click', '.dropdown-toggle', function( event ) {

 

   

      $( '.dropdown-menu' ).slideToggle();

 

   return false;

 

});



function searchCheck(){
	var searchvar  = document.getElementById("search-q").value;
	if(searchvar == ''){
		alert("Enter search query");
		return false;
	}
	else {
		return true;
	}
}







</script>

<style type="text/css">

a:hover

{

	text-decoration:none;

}

</style>

</head>

<body id="browse_channel">

<div id="wrapper" class="subscribeProfileMain">

<?php 
if(isset($session_member_id)){
include('includes/header.php');} else {
	include('qboxHeader.php');
}


if(isset($_GET['search'])) {

	$search = $_GET['search'];
	
	
$clicks =mysqli_query($con, "select * from members

			WHERE username like '%$search%'");



} else {


$clicks =mysqli_query($con, "select * from members ORDER BY username asc");

}


?>

<div id="mainbody">
<div class="profile_wrapper">

<?php include ('leftSidebarPannelSubscribe.php');?>
<div id="rightSidePannel">
<?php //include ('subscribe_page_header.php');?>
 
</div>
 <div id="video_list_container">
 <!--<ul class="video_menu_list">
 <li> <a href=""> Uploads</a> </li>
 <li> <a href=""> About </a> </li>
 <li> <a href=""> Stations </a> </li>
 </ul>-->
<?php 

$uname1=mysqli_query($con, "select * from members where member_id='$session_member_id'");
$unameresult=mysqli_fetch_array($uname1);



?>

 

    
<div class="componentheading">
    <div id="submenushead"><?php echo "Browse Stations";?></div>
    <div id="vinod" ></div>
    </div>
      
<div id="searchdiv" style="margin-top: 10px;">

    <form method="get" onSubmit="return searchCheck()" style="width: 65%; float: right;">

    	<div class="row">

    	    <div class="col-lg-12">

		    <div class="input-group" style="margin-right: 34px;">

		      <input type="text" class="form-control" name="search" id="search-q" style="margin-right: 96px;" value="<?php if(isset($_GET['search'])) { echo $_GET['search'];} ?>">

			      <span class="input-group-btn  ">

			        <button class="btn btn-default myBtn" type="submit" style=" margin-left:32px;"><?php echo $lang['Go'];?>!</button>

			      </span>

			    </div><!-- /input-group -->

	  </div><!-- /.col-lg-6 -->

	</div><!-- /.row -->

    

   	

    </form>

    </div>

<div id="border">
<?php 
		
	//$clicks =("select vs.subcriber_member_id, m.username, m.profImage from members m INNER JOIN  videos_subscribe vs on m.member_id='vs.subcriber_member_id' where vs.member_id='$session_member_id'");
	
	
	while($clicks_res = mysqli_fetch_array($clicks))
	{
	 $member  = $clicks_res['member_id'];
		$desc=mysqli_query($con, "select * from videos_channel where member_id='$member'");
		$description=mysqli_fetch_array($desc);
		$upload=mysqli_query($con, "select * from videos where user_id='$member'");
		$uploadno=mysqli_num_rows($upload);
		
		$subs=mysqli_query($con, "select * from videos_subscribe where subscriber_member_id='$member'");
		$subno=mysqli_num_rows($subs);
		
?>
        
<div class="mini-profile" id="mini-profile_<?php echo $clicks_res['member_id'];?>">
<div class="mini-profile-avatar">
<a href="<?php echo $base_url.'user/'.$clicks_res['username'];?>" title="<?php echo ucfirst($clicks_res['username']);?>"><img src="<?php echo $clicks_res['profImage'];?>" width="68" height="68" /></a>
</div>
<div class="mini-profile-details">
<h3 style="font-size:120%;"><a href="<?php echo $base_url.'user/'.$clicks_res['username'];?>" 
title="<?php echo ucfirst($clicks_res['username']);?>"><div<strong><?php echo ucfirst($clicks_res['username']);?></strong></a></h3>

<div class="mini-profile-details-action">
<span><?php echo $description['description'];?></span>
<div class="mini-profile-details-status"></div>

<div class="mini-profile-details-status">
<?php echo $subno.' ';?><?php echo "Subscribers";?></span>
<span style="margin-left:25px;"><?php echo $uploadno.' ';?><?php echo "Uploads";?></span>
</div>

</div>
</div>

</div><!--end mini profile-->
<?php  }
?>
</div>



    </div>

    
</div>
</div><!--End mainbody div-->

</div>

<?php include 'includes/footer.php';?>

</div><!--End wrapper div-->

</body>

</html>