<?php
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php'); 	 
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');
	//require_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/time_stamp.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/video-time.php');
	//require_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_header.php');
	if(!isset($_SESSION['SESS_MEMBER_ID']))
	{	
		header("location: ".$base_url."login.php?back=". urlencode($_SERVER['REQUEST_URI']));
		exit();
	}
	
	if(isset($_SESSION['SESS_MEMBER_ID']))
	{	
		$session_member_id = $_SESSION['SESS_MEMBER_ID'];
		$sql = mysqli_query($con, "select * from member where member_id='".$session_member_id."'") or die(mysqli_error($con));
		$res = mysqli_fetch_array($sql);
	}
?>

<?php /*?>
<link rel="stylesheet" type="text/css" href="css/style.css"/>

<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>font-awesome/css/font-awesome.css">
<link rel="icon" href="images/favicon.ico" type="image" />
<link rel="shortcut icon" href="images/favicon.ico" type="image" />

<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css" />
<link rel="stylesheet" type="text/css" href="css/responsive.css" />

<link rel="stylesheet" type="text/css" href="css/bootstrap-reset.css" />
<?php */?>
<link rel="stylesheet" type="text/css" href="css/wall.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>font-awesome/css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/subscribeProfilePage.css" />
<link rel="stylesheet" type="text/css" href="css/video_gallery.css"/>
<link rel="stylesheet" type="text/css" href="css/mobDesign_videoPage.css" />
<link rel="stylesheet" type="text/css" href="css/searchTextButton.css"/>




<script src="js/jquery.min.js"></script>
<script src="js/jquery-1.9.1.js"></script>
<script src="js/ibox.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery-ui.css" />
<script src="js/jquery-ui.js"></script>

 <link rel="stylesheet" type="text/css" href="css/youtube.css"/>
<script type="text/javascript">
$(function() {
 $("#search").autocomplete({
	 source: "load_data/video_names_ajax.php",			
			select: true
 });
 
 $(".ads_close").click(function()
 {
	 $("#ad_creative").hide();
 });
 
});
function searchCheck(){
	var searchvar  = document.getElementById("searchbar").value;
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
/*unique*/
.r {
position: relative;
}
/*MUST BE ABSOLUTE TO STACKED*/
.rating, .transparent {
position: absolute;

}  .star {
background: url(images/quickvote_item_active_big.png); cursor: pointer; float: left !important; /*KEEPS THE STAR NEXT TO EACH OTHER*/ height: 25px; width: 27px;
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

</style>
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_header.php');?>
<div class="insideWrapper container">
    <div class="row"></div>
    <br/>
<div id="searchSubmenu">

<div class="searchmenu">
<ul class="submenu" >    
<li><form action="video_gallery_search.php" method="get" onSubmit="return searchCheck()">
<input id="searchbar" type="text" name="search" placeholder="<?php echo $lang['Type here'];?>" class="searchbar rounded" style="margin-left: 5px;">
    <button class="btn btn-default btn-lg searchBtn" type="submit">

    <div class="fa-search fa"></div>

</button>

   </form></li>
	</ul>
</div>

</div>


<div class="videogallery_mobView">
<div id="mobDesign_videoPage" >
		<nav>
		    <ul class="nav">
                <li>
                <a href="add_video_gallery.php">
             <div style="float:left;">
		          
		            <span class="icon-home">
                   	<img src="images/uploadVideo.png" height="20" width="20" /> 
                    </span>
		          
                 </div>
                  
                  </a>
		      	</li>
                
		        <li>
		          <a href="myvideos.php">
                <div style="float:left;">
		        
		            <span class="icon-cog">
                    		<img src="images/folderIcon.png" height="20" width="20" /> 
                    </span>    
		         
                  </div>
                  
                   </a>
                  </li>
                  
		        <li id="search_btn_list">
		        <a href="#">
                		<div style="float:left;">
		      		
			            <span class="icon-cw">
                        		<img src="images/searchBtn.png" height="20" width="20" class="trigger" /> 
                                
                                
                        	   </span>
		           
                    </div>	
                    
                     </a>
		      </li>
		    </ul>
		</nav>
	</div>
</div>
<div id="search_box_mobDesign" class="search-bar" style="width:280px; display:none;">
 <input id="searchbar" type="text" name="search" placeholder="<?php echo $lang['Type here'];?>" class="rounded searchbox">
 </div>
<script>
	$(document).ready(function() {
  		$('#search_btn_list').click(function(){
        		$('.search-bar').animate({width:'toggle'},1500);
        									
   		});
	});
</script>
<div class="col-lg-9 col-md-9 col-sm-12">
<div class="video" style="float:none;">


<div class="popular_video">
<h1>Recent Videos</h1>
    <ul class="popular">
    <?php 
$rvquery = "SELECT v.location, v.thumburl, v.title, v.video_id, v.date_created, v.view_count,
			c.name, v.url_type, m.username,v.duration 
			FROM videos v LEFT JOIN videos_category c ON v.category = c.id
			LEFT JOIN member m ON m.member_id = v.user_id 
			LEFT JOIN message msg ON msg.video_id = v.video_id 
			WHERE v.type = 0 AND v.url_type != 2 AND msg.share = 0 
			GROUP BY v.parent_id
			ORDER BY v.video_id DESC";
$rvsql = mysqli_query($con, $rvquery) or die(mysqli_error($con));

while($rvres = mysqli_fetch_array($rvsql))
{
	$msg_id2 = $rvres['video_id'];
	$time = $rvres['date_created'];
	$timedifference = timedifferenceindays($time);
	$curenttime = $rvres['duration'];
?>

     <li class="popular_list" id="popular_list-<?php echo $rvres['video_id'];?>">
    <a href="watch.php?video_id=<?php echo $rvres['video_id'];?>" class="watch" id="<?php echo $rvres['video_id'];?>">
    <?php
    if($rvres['url_type'] == 1)
	{
	if($timedifference <= 7 )
	   {
	    ?><img class="newImg" src="<?php echo $base_url; ?>images/new.png" width="35" height="35" /><?php
	   }
	?>
    <img src="<?php echo $base_url.'uploadedvideo/videothumb/p200x150'.$rvres['thumburl'];?>" width="200" height="150" class="mob_div_video">
    <span class="video-thumbnail-duration"><?php echo video_duration($curenttime); ?></span>
    </img>
    <?php } 
	if($rvres['url_type'] == 2)
	{
		if (preg_match('![?&]{1}v=([^&]+)!', $rvres['location'] . '&', $mr))
	$video_idr = $mr[1]; 
	$urlr = "http://img.youtube.com/vi/".$video_idr."/default.jpg";	
			
	?>
    <img src="<?php echo $urlr;?>" width="200" height="150" />
    <?php 
	}
	
	?>
   </a>
<div class="video_Content">
<div class="test" >
<a href="watch.php?video_id=<?php echo $rvres['video_id'];?>">
<h3 class="video_title"><?php echo $rvres['title'];?></h3></a>
</div>
<div class="video_data">

<span class="view_count"><?php echo $rvres['view_count'];?> views</span>
<span class="content_item_time"><?php echo time_stamp($time);?></span>
<br/>
<span class="view_count"> By <a href="<?php echo $base_url.'user/'.$rvres['username'];?>"><?php echo $rvres['username'];?></a></span>

</div>
 <?php 
					$rrsql = mysqli_query($con, "select rating from videos where video_id = '$msg_id2'");
					$rrcount = mysqli_num_rows($rrsql);
					
					$rrating = 0;
					$rx = array(); //ARRAY TO COUNT STARS FOR EACH PIECE OF CONTENT
					$rstars = array(); //ARRAY TO SEPARATE THE TRANSPARENT 5-STAR BASE BETWEEN EACH PIECE OF CONTENT
									
					//ADDS ALL THE STAR FOR EACH PIECE OF CONTENT
					if($rrcount > 0)
					{
    while($rrres=mysqli_fetch_array($rrsql)){
		
        $rr = $rrres["rating"];
        @$rx[$msg_id2] += $rr;
    }
    $rr = 0; //RESETS AS IT GOES TO THE NEXT PIECE OF CONTENT
    $ra = $rx[$msg_id2]; //THE TOTAL NUMBER OF STARS
    
    //IF THERE ARE RATINGS...
    if($rrcount){
        $rrating = $ra/$rrcount; //GETS THE AVERAGE RATING (UNROUNDED)
    }
	$rdec_rating = round($rrating, 1);
	}
	//LOOPS THE WHOLE NUMBER OF STARS THAT THE CONTENT HAS BEEN RATED
    for($i=1; $i<=floor($rrating); $i++){
        @$rstars[$msg_id2] .= '<div class="star s'.$msg_id2.'" x="'.$msg_id2.'" id="'.$i.'"></div>';
    }
					
    //ALL CONTENT & ITS STARS SHOWN IN HTML
   echo '
    <div class="ajax'.$msg_id2.'">';
   //THE CURRENT RATING & THE TRANSPARENT BASE RIGHT USER TO SUBMIT A NEW RATING
echo '<div class="rating r'.$msg_id2.'">'.@$rstars[$msg_id2].'</div>
<div class="transparent">
<div class="star s'.$msg_id2.'" x="'.$msg_id2.'" id="1"></div>
<div class="star s'.$msg_id2.'" x="'.$msg_id2.'" id="2"></div>
<div class="star s'.$msg_id2.'" x="'.$msg_id2.'" id="3"></div>
<div class="star s'.$msg_id2.'" x="'.$msg_id2.'" id="4"></div>
<div class="star s'.$msg_id2.'" x="'.$msg_id2.'" id="5"></div>

</div>';
    echo '</div><br>
    ';
	?>

</div>
        
        </li>   
        
        
<?php } ?>        
    </ul>
    
  

</div>
</div><!--End column left div-->

</div>

<div class="col-lg-2 col-md-3 hidden-sm hidden-xs">
<?php include ('leftSidebarPannelSubscribe.php');?>
</div>
</div>

<?php
	include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_footer.php');
?>                    