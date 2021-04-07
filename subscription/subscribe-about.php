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

	

	$session_member_id = $_SESSION['SESS_MEMBER_ID'];

	
    $username = $_REQUEST['username'];
	include 'includes/time_stamp.php';
	include 'includes/video-time.php';

		
if(isset($_SESSION['SESS_MEMBER_ID']))

	{

		$sql = mysqli_query($con, "select * from members where member_id='".$session_member_id."'") or die(mysqli_error($con));

		$res = mysqli_fetch_array($sql);

	}
		
		
		$msql = mysqli_query($con, "select * from members a LEFT JOIN videos_channel b ON a.member_id = b.member_id 
where a.username='".$username."'");

	$mres = mysqli_fetch_array($msql);
	
	$vmember_id = $mres['member_id'];

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<title><?php echo $mres['username'];?></title>

<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/wall.css"/>

<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/search.css"/>

<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/style.css"/>

<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/searchTextButton.css"/>

<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/bootstrap.min.css" />

<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/bootstrap-theme.min.css" />

<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/my_videos_wall.css" />


<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>font-awesome/css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>sport-font/sport-font.css">

<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/responsive.css" />

<link rel="icon" href="<?php echo $base_url;?>images/favicon.ico" type="image" />

<link rel="shortcut icon" href="<?php echo $base_url;?>images/favicon.ico" type="image" />

<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/bootstrap-reset.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/mobDesign_videoPage.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/subscribeProfilePage.css" />



<script src="<?php echo $base_url;?>js/jquery-1.9.1.js"></script>
<script src="<?php echo $base_url;?>js/bootstrap.min.js"></script>
<script src="<?php echo $base_url;?>js/qbox.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/youtube.css"/>


<script type="text/javascript">

$(document).ready (function () {

	$('.remove_video').click (function () {		

		return confirm ("<?php echo $lang['Are you sure you want to delete this video'];?>?") ;

	}) ; 	

 

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

<body>

<div id="wrapper" class="subscribeProfileMain">

<?php 
if(isset($session_member_id)){
include('includes/header.php');} else {
	include('qboxHeader.php');
}


?>

<div id="mainbody" style="overflow: hidden;">
<div class="profile_wrapper">

<?php include ('leftSidebarPannelSubscribe.php');?>
<div id="rightSidePannel">
<?php include ('subscribe_page_header.php');?>
 
</div>

 <div id="video_list_container">
 <ul class="video_menu_list">
 <li> <a href="<?php echo $base_url.'user/'.$mres['username'];?>"><?php echo $lang['Uploads'];?></a> </li>
 <li> <a href="<?php echo $base_url.'user/about/'.$mres['username'];?>"><?php echo $lang['About'];?></a> </li>
 <li> <a href="<?php echo $base_url.'user/channel/'.$mres['username'];?>"><?php echo $lang['Stations'];?></a> </li>
 </ul>
 
 <div class="video_desc">
 <div id="edit_desc">
 <div id="desc"><?php echo $mres['description'];?></div>
 <?php 
 if($session_member_id == $vmember_id){
 	if($mres['description'] != ''){
 ?>
 <div id="edit_btn" style="margin-left: 747px;"> <a><img src="<?php echo $base_url;?>images/pencilEdit.png" ></img></a>	
 <?php } }?>
 </div>
 <?php 
 if($session_member_id == $vmember_id){
     if($mres['description'] == ''){ 
 ?>
 <div id="add_desc">
 <div class="comment_add_btn" id="comment_desc_btn"> <a href="javascript:"><?php echo $lang['Add Description'];?></a> </div>
 </div>
 <?php } ?>
 </div>
 <div id="video_description" style="display:none">

	<div id="comment_textarea">
    <textarea rows="6" cols="150" id="description"></textarea>
    <input type="hidden" id="channel_id" value="<?php echo $mres['id']; ?>" />
    </div>

<div id="save_cancelBtn">
    <button id="comment_add_btn" class="comment_add_btn save-desc"><?php echo $lang['Save'];?></button>
	<button id="comment_edit_btn" class="comment_add_btn save-canecl"><?php echo $lang['Cancel'];?></button>
</div>
</div>

    </div>
    <?php } ?>
   

</div>
</div><!--End mainbody div-->


<?php include 'includes/footer.php';?>

</div><!--End wrapper div-->

</body>

</html>