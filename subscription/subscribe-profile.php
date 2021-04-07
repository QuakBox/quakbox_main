<?php

	ob_start();
	//error_reporting(0);
	session_start();
//die('profile');
	global $mres;
	  
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
	
	$channel_m_query = mysqli_query($con, "SELECT member_id FROM member WHERE username = '$username'");
	$channel_m_res = mysqli_fetch_array($channel_m_query);
	$channel_member_id = $channel_m_res['member_id'];

	$select_channel_query = mysqli_query($con, "SELECT id FROM videos_channel WHERE member_id = '$channel_member_id'");
	$channel_count = mysqli_num_rows($select_channel_query) ;
	if($channel_count == 0){
		$cover_channel = 'images/channel_cover.png';
	 //query for insert data into videos_channel table
	 mysqli_query($con, "INSERT INTO videos_channel (member_id,cover_photo) VALUES('$channel_member_id','$cover_channel')");
	}
	if(isset($_SESSION['SESS_MEMBER_ID']))	{

		$sql = mysqli_query($con, "select * from member where member_id='".$session_member_id."'") or die(mysqli_error($con));

		$res = mysqli_fetch_array($sql);	

	}
	
	$msql = mysqli_query($con, "select * from member a LEFT JOIN videos_channel b ON a.member_id = b.member_id 
where a.username='".$username."'");

	$mres = mysqli_fetch_array($msql);
	
	$vmember_id = $mres['member_id'];	
	
	
	$live_video_sql = mysqli_query($con, "select * from user_live_video where user_id='".$channel_member_id."' and status=1 order by id desc limit 0,1") or die(mysqli_error($con));

		$live_video_res = mysqli_fetch_array($live_video_sql);	
		$live_video_url = $live_video_res['live_video_url'];	
	//echo "<pre>details";
//print_r($mres);
//die();
?>


<!--
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<title><?php echo $mres['username'];?></title>

<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0">-->

<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/wall.css"/>

<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/search.css"/>

<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/style.css"/>

<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/searchTextButton.css"/>

<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/bootstrap.min.css" />

<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/bootstrap-theme.min.css" />

<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/my_videos_wall.css" />


<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>font-awesome/css/font-awesome.css">

<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/responsive.css" />

<link rel="icon" href="<?php echo $base_url;?>images/favicon.ico" type="image" />

<link rel="shortcut icon" href="<?php echo $base_url;?>images/favicon.ico" type="image" />

<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/bootstrap-reset.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/mobDesign_videoPage.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/subscribeProfilePage.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/video_gallery.css"/>

<script src="http://microsofttranslator.com/ajax/v3/widgetv3.ashx" type="text/javascript"></script>

<?php ?><script src="<?php echo $base_url;?>js/jquery.min.js"></script><?php ?>

<script src="<?php echo $base_url;?>js/jquery.livequery.js" type="text/javascript"></script>

<script src="<?php echo $base_url;?>js/jquery.oembed.js"></script>

<?php /*?><script src="<?php echo $base_url;?>js/jquery-ui.min.js"></script><?php */?>
<script src="js/respond.js"></script>

<script type="text/javascript" src="<?php echo $base_url;?>js/ibox.js"></script>

<script type="text/javascript" src="<?php echo $base_url;?>js/jquery.share.js"></script>

<script type="text/javascript" src="<?php echo $base_url;?>assets/jquery-alert-dialogs/js/jquery.alerts.js"></script>

<script src="<?php echo $base_url;?>js/qbox.js"></script>
<script src="<?php echo $base_url;?>js/check.js"></script>

<!--common scripts for all wall pages-->

<script src="<?php echo $base_url;?>js/translate.js"></script>

<?php /*?><script src="js/wall.js"></script><?php */?>

<script src="<?php echo $base_url;?>js/jquery.form.js"></script>

<script src="<?php echo $base_url;?>js/page-refresh.js"></script>

<script src="<?php echo $base_url;?>js/common-scripts.js"></script>





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




/*
$( document).on( 'click', '.dropdown-toggle', function( event ) {

 

   

      $( '.dropdown-menu' ).slideToggle();

 

   return false;

 

});
*/


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
  

/*unique*/
.r {
position: relative;
}
/*MUST BE ABSOLUTE TO STACKED*/
.rating, .transparent {
position: absolute;

}  .star {
background: url(../images/quickvote_item_active_big.png); cursor: pointer; float: left !important; /*KEEPS THE STAR NEXT TO EACH OTHER*/ height: 25px; width: 27px;
} .transparent .star {
opacity: .25; /*BASE STARS ARE TRANSPARENT UNTIL MOUSEOVER*/
} .rating .star {
opacity: 1.0; /*CURRENT RATING IS VISIBLE UNTIL MOUSEOVER*/
} 
div.video {
    width: 100%;
}
div.video ul li{
	padding:0 10px;
}
.row {
margin-left: 1px !important;
}

</style>



<div id="wrapper" class="subscribeProfileMain insideWrapper container">

<?php 

if(isset($session_member_id)){
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_header.php');



} else {
	include('qboxHeader.php');
}

if(isset($_GET['search'])) {

	$search = $_GET['search'];

$pvsql = mysqli_query($con, "SELECT v.location, v.thumburl, v.title, v.video_id, v.date_created, v.view_count,

			c.name, v.url_type, m.username, v.duration

			FROM videos v LEFT JOIN videos_category c ON v.category = c.id

			LEFT JOIN members m ON m.member_id = v.user_id 

			WHERE user_id = '$session_member_id' AND duration !=0

			AND v.title like '%$search%'
			GROUP BY v.parent_id
			ORDER BY v.video_id DESC");

} else {

	$pvsql = mysqli_query($con, "SELECT v.location, v.thumburl, v.title, v.video_id, v.date_created, v.view_count,

			c.name, v.url_type, m.username, v.duration

			FROM videos v LEFT JOIN videos_category c ON v.category = c.id

			LEFT JOIN members m ON m.member_id = v.user_id 

			WHERE user_id = '$vmember_id' AND duration !=0
			GROUP BY v.parent_id
			ORDER BY v.video_id DESC");

}

$channel_query = mysqli_query($con, "SELECT id FROM videos_subscribe WHERE member_id = ''");

?>

<div id="mainbody">
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
 <?php if($live_video_url != "") { ?>
 <li> <a href="<?php echo $live_video_url ;?>" target= "_blank"><img style="width: 50px;height: 50px;margin-bottom: 15px;" src="../images/live.gif" /></a> </li> <?php }?>
 </ul>
 </div>
 

    

    	<!--<ol id="video_list_container_ol" class="videoList">-->
		<div class="col-lg-9 col-md-12 col-sm-12">
            
		<div class="popular_video">
            
                <ul class="popular">

        <?php	
	

if(mysqli_num_rows($pvsql) > 0){


while($pvres = mysqli_fetch_array($pvsql))

{

	$time = $pvres['date_created'];
	$curenttime = $pvres['duration'];
	$msg_id = $pvres['video_id'];

?>

    		
			<li class="popular_list" id="popular_list-<?php echo $pvres['video_id'];?>">
                
               <a href="../watch.php?video_id=<?php echo $QbSecurity->qbClean($pvres['video_id'], $con);?>" class="watch" onclick="view_count()" id="<?php echo $QbSecurity->qbClean($pvres['video_id'], $con);?>">
                <?php
                if($pvres['url_type'] == 1)
                {
                   if($timedifference <= 7 )
                   {
                    ?><?php
                   }
                
                ?>
                <img src="<?php echo $base_url.'uploadedvideo/videothumb/p200x150'.$pvres['thumburl'];?>" width="200" height="150" class="mob_div_video"/>
                <span class="video-thumbnail-duration"><?php echo video_duration($curenttime); ?></span>
                <?php 
                
                
                } 
                if($pvres['url_type'] == 2)
                {
                    if (preg_match('![?&]{1}v=([^&]+)!', $pvres['location'] . '&', $m))
                $video_id = $m[1]; 
                $url = "http://img.youtube.com/vi/".$video_id."/default.jpg";	
                        
                ?>
                
                <?php 
                }
                
                ?>
               
               </a>
            <div class="video_Content">
            <div class="test" >
            <a href="../watch.php?video_id=<?php echo $QbSecurity->qbClean($pvres['video_id'], $con);?>">
            <h3 class="video_title"><?php echo $pvres['title'];?></h3></a>
            </div>
            
            <div class="video_data">
            
            <span class="view_count"><?php echo $pvres['view_count'];?> <?php echo $lang['views'];?></span>
            <span class="content_item_time"><?php echo time_stamp($time);?></span><br/>
            <!--<span class="view_count"> <?php echo $lang['By'];?> <a href="<?php //echo $base_url.'user/'.$pvres['username'];?>"><?php //echo $pvres['username'];?></a></span>-->
            
            </div>
             <?php 
                                $crsql = mysqli_query($con, "select rating from videos where video_id = '$msg_id'");
                                $crcount = mysqli_num_rows($crsql);
                                
                                $rating = 0;
                                $x = array(); //ARRAY TO COUNT STARS FOR EACH PIECE OF CONTENT
                                $stars = array(); //ARRAY TO SEPARATE THE TRANSPARENT 5-STAR BASE BETWEEN EACH PIECE OF CONTENT
                                                
                                //ADDS ALL THE STAR FOR EACH PIECE OF CONTENT
                                if($crcount > 0)
                                {
                while($crres=mysqli_fetch_array($crsql)){
                    
                    $r = $crres["rating"];
                    @$x[$msg_id] += $r;
                }
                $r = 0; //RESETS AS IT GOES TO THE NEXT PIECE OF CONTENT
                $a = $x[$msg_id]; //THE TOTAL NUMBER OF STARS
                
                //IF THERE ARE RATINGS...
                if($crcount){
                    $rating = $a/$crcount; //GETS THE AVERAGE RATING (UNROUNDED)
                }
                $dec_rating = round($rating, 1);
                }
                //LOOPS THE WHOLE NUMBER OF STARS THAT THE CONTENT HAS BEEN RATED
                for($i=1; $i<=floor($rating); $i++){
                    @$stars[$msg_id] .= '<div class="star s'.$msg_id.'" x="'.$msg_id.'" id="'.$i.'"></div>';
                }
                                
                //ALL CONTENT & ITS STARS SHOWN IN HTML
               echo '
                <div class="ajax'.$msg_id.'">';
               //THE CURRENT RATING & THE TRANSPARENT BASE RIGHT USER TO SUBMIT A NEW RATING
            echo '<div class="rating r'.$msg_id.'">'.@$stars[$msg_id].'</div>
            <div class="transparent">
            <div class="star s'.$msg_id.'" x="'.$msg_id.'" id="1"></div>
            <div class="star s'.$msg_id.'" x="'.$msg_id.'" id="2"></div>
            <div class="star s'.$msg_id.'" x="'.$msg_id.'" id="3"></div>
            <div class="star s'.$msg_id.'" x="'.$msg_id.'" id="4"></div>
            <div class="star s'.$msg_id.'" x="'.$msg_id.'" id="5"></div>
            
            </div>';
                echo '</div><br>
                ';
                ?>
            
            </div>
                    
                    </li>
                    

            <?php  }  }?>

    	</ul>
                
                
            </div>  </div>

        

    </div>

   
</div>
</div><!--End mainbody div-->



<?php 	include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_footer.php');?>


