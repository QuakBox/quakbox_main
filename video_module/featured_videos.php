<?php ob_start();
	session_start();
	require_once('config.php');
	
	if(isset($_SESSION['lang']))
	{	
		include('common.php');
	}
	else
	{
		include('Languages/en.php');
		
	}
	
	include 'includes/time_stamp.php';
	include 'includes/video-time.php';
	if(isset($_SESSION['SESS_MEMBER_ID']))
	{	
		$session_member_id = $_SESSION['SESS_MEMBER_ID'];
		$sql = mysqli_query($con, "select * from member where member_id='".$session_member_id."'") or die(mysqli_error($con));
		$res = mysqli_fetch_array($sql);
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<title>Browse Video</title>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="css/wall.css"/>
<!-- <link rel="stylesheet" type="text/css" href="css/style.css"/> -->

<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>font-awesome/css/font-awesome.css">
<link rel="icon" href="images/favicon.ico" type="image" />
<link rel="shortcut icon" href="images/favicon.ico" type="image" />

<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css" />
<link rel="stylesheet" type="text/css" href="css/responsive.css" />
<link rel="stylesheet" type="text/css" href="css/bootstrap-reset.css" />
<link rel="stylesheet" type="text/css" href="css/mobDesign_videoPage.css" />
<link rel="stylesheet" type="text/css" href="css/searchTextButton.css"/>
<link rel="stylesheet" type="text/css" href="css/video_gallery.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/subscribeProfilePage.css" />

<script src="js/bootstrap.min.js"></script>


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
.row {
margin-left: 1px !important;
}
</style>
</head>

<?php 
if(isset($_SESSION['SESS_MEMBER_ID'])) {
    require_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_header.php');
} else {
	include('qboxHeader.php');
}
?>


<div class="insideWrapper container">

    <div class="row">
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

 


<div class="col-lg-8 col-md-9 col-sm-12">

<div class="video" style="float:none;">


<div class="popular_video">
<h1>Featured Videos</h1>
    <ul class="popular">
    <?php 
$fvquery = "SELECT v.location, v.thumburl, v.title, v.video_id, v.date_created, v.view_count,
			c.name, v.url_type, m.username,v.duration 
			FROM videos v LEFT JOIN videos_category c ON v.category = c.id
			LEFT JOIN member m ON m.member_id = v.user_id 
			LEFT JOIN message msg ON msg.video_id = v.video_id 
			WHERE v.type = 0 AND v.url_type != 2 AND msg.share = 0 
			GROUP BY v.parent_id
 			AND v.featured = 1";
$fvsql = mysqli_query($con, $fvquery) or die(mysqli_error($con));


while($fvres = mysqli_fetch_array($fvsql))
{
	$msg_id1 = $fvres['video_id'];
	$time = $fvres['date_created'];
	$timedifference = timedifferenceindays($time);
	$curenttime = $fvres['duration'];
?>

     <li class="popular_list" id="popular_list-<?php echo $fvres['video_id'];?>">
    <a href="watch.php?video_id=<?php echo $fvres['video_id'];?>" class="watch" onclick="view_count()" id="<?php echo $fvres['video_id'];?>">
    <?php
    if($fvres['url_type'] == 1)
	{
	
	if($timedifference <= 7 )
	   {
	    ?><img class="newImg" src="<?php echo $base_url; ?>images/new.png" width="35" height="35" /><?php
	   }
	?>
    <img src="<?php echo $base_url.'uploadedvideo/videothumb/p200x150'.$fvres['thumburl'];?>" width="200" height="150" class="mob_div_video">
    <span class="video-thumbnail-duration"><?php echo video_duration($curenttime); ?></span>
    </img>
    <?php } 
	if($fvres['url_type'] == 2)
	{
		if (preg_match('![?&]{1}v=([^&]+)!', $fvres['location'] . '&', $mf))
	$video_idf = $mf[1]; 
	$urlf = "http://img.youtube.com/vi/".$video_idf."/default.jpg";	
			
	?>
    <img src="<?php echo $urlf;?>" width="200" height="150" />
    <?php 
	}
	
	?>
   </a>
<div class="video_Content">
<div class="test">
<a href="watch.php?video_id=<?php echo $fvres['video_id'];?>" >
<h3 class="video_title"><?php echo $fvres['title'];?></h3></a>
</div>

<div class="video_data">

<span class="view_count"><?php echo $fvres['view_count'];?> views</span>
<span class="content_item_time"><?php echo time_stamp($time);?></span>
<br/>
<span class="view_count"> By <a href="<?php echo $base_url.'user/'.$pvres['username'];?>"><?php echo $fvres['username'];?></a></span>

</div>
 <?php 
					$frquery = "select rating from videos where video_id = '$msg_id1'";
					$frsql = mysqli_query($con, $frquery);
					$frcount = mysqli_num_rows($frsql);
					
					$frating = 0;
					$fx = array(); //ARRAY TO COUNT STARS FOR EACH PIECE OF CONTENT
					$fstars = array(); //ARRAY TO SEPARATE THE TRANSPARENT 5-STAR BASE BETWEEN EACH PIECE OF CONTENT
									
					//ADDS ALL THE STAR FOR EACH PIECE OF CONTENT
					if($frcount > 0)
					{
    while($frres=mysqli_fetch_array($frsql)){
		
        $fr = $frres["rating"];
        @$fx[$msg_id1] += $fr;
    }
    $fr = 0; //RESETS AS IT GOES TO THE NEXT PIECE OF CONTENT
    $fa = $fx[$msg_id1]; //THE TOTAL NUMBER OF STARS
    
    //IF THERE ARE RATINGS...
    if($frcount){
        $frating = $fa/$frcount; //GETS THE AVERAGE RATING (UNROUNDED)
    }
	$fdec_rating = round($frating, 1);
	}
	//LOOPS THE WHOLE NUMBER OF STARS THAT THE CONTENT HAS BEEN RATED
    for($i=1; $i<=floor($frating); $i++){
        @$fstars[$msg_id1] .= '<div class="star s'.$msg_id1.'" x="'.$msg_id1.'" id="'.$i.'"></div>';
    }
					
    //ALL CONTENT & ITS STARS SHOWN IN HTML
   echo '
    <div class="ajax'.$msg_id1.'">';
   //THE CURRENT RATING & THE TRANSPARENT BASE RIGHT USER TO SUBMIT A NEW RATING
echo '<div class="rating r'.$msg_id1.'">'.@$fstars[$msg_id1].'</div>
<div class="transparent">
<div class="star s'.$msg_id1.'" x="'.$msg_id1.'" id="1"></div>
<div class="star s'.$msg_id1.'" x="'.$msg_id1.'" id="2"></div>
<div class="star s'.$msg_id1.'" x="'.$msg_id1.'" id="3"></div>
<div class="star s'.$msg_id1.'" x="'.$msg_id1.'" id="4"></div>
<div class="star s'.$msg_id1.'" x="'.$msg_id1.'" id="5"></div>

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

<div class="col-lg-3 col-md-3 hidden-sm hidden-xs">
	<?php include ('leftSidebarPannelSubscribe.php');?>
</div>

</div>
</div>
<?php
	include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_footer.php');
?>
        
                            
                            