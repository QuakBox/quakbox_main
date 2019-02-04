<?php
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php'); 	 
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');
	//require_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/time_stamp.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/video-time.php');
	
	if(!isset($_SESSION['SESS_MEMBER_ID']))
	{	
		header("location: ".$base_url."login.php?back=". urlencode($_SERVER['REQUEST_URI']));
		exit();
	}	
		//echo "<pre>";
		//print_r($_SESSION);
	$session_member_id = $_SESSION['SESS_MEMBER_ID'];
	if($session_member_id)
	{		
		$sql = mysqli_query($con, "select * from member where member_id='".$session_member_id."'") or die(mysqli_error($con));
		$res = mysqli_fetch_array($sql);
	}
?>

<link rel="stylesheet" type="text/css" href="css/wall.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>font-awesome/css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/subscribeProfilePage.css" />
<link rel="stylesheet" type="text/css" href="css/video_gallery.css"/>
<link rel="stylesheet" type="text/css" href="css/mobDesign_videoPage.css" />
<link rel="stylesheet" type="text/css" href="css/searchTextButton.css"/>

<script src="js/jquery.min.js"></script>
<script src="js/jquery-1.9.1.js"></script>
<script src="js/ibox.js"></script>
<script src="<?php echo $base_url;?>js/check.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery-ui.css" />
<script src="js/jquery-ui.js"></script>

 <link rel="stylesheet" type="text/css" href="css/youtube.css"/>
<script type="text/javascript">
$(function() {
 $("#searchbar").autocomplete({
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

</style>


<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_header.php');?>

<div class="insideWrapper container">
    <div class="row">
<!--<div id="searchDiv">

<ul class="submenu" >    
   <li></li>
   <li><form id="searchbox" action="video_gallery_search.php" method="get" onSubmit="return searchCheck()">
  
   <input type="button" name="add_video" class="submit myButton" value="<?php echo $lang['Add video'];?>" id="btn" onclick="window.open('add_video_gallery.php','_self');"  />
   
    <?php if(isset($session_member_id)){?>
   
   <input type="button" name="add_video" class="submit myButton" value="<?php echo $lang['My video'];?>" onclick="window.open('myvideos.php','_self');" id="btn" />
   <?php } ?>
    <input id="searchbar" type="text" name="search" placeholder="<?php echo $lang['Type here'];?>" class="rounded">
    <input class="submit myButton" type="submit" value="<?php echo $lang['Search'];?>">
</form></li>
	</ul>
 </div> -->

<?php /*?><embed src="ads/quakbox.swf" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"  quality="high" allowscriptaccess="always" wmode="transparent" align="middle" width="960" height="180"></embed><?php */?>

</div>
<br/>
<div id="searchSubmenu">

<div class="searchmenu">
<ul class="submenu" >    
<li><form action="video_gallery_search.php" method="get" onSubmit="return searchCheck()">
<input id="searchbar" type="text" name="search" placeholder="<?php echo $lang['Type here'];?>" class="searchbar rounded" style="margin-left: 5px;">
    <button class="btn btn-default btn-lg searchBtn" type="submit">

    <div class="fa-search fa"></div>

</button>
<!--<input type="button" name="add_video" class="submit myButton" value="<?php echo $lang['Add video'];?>" id="btn" onclick="window.open('add_video_gallery.php','_self');"  />-->
   
    <?php if(isset($session_member_id)){?>
   
  <!-- <input type="button" name="add_video" class="submit myButton" value="<?php echo $lang['My video'];?>" onclick="window.open('myvideos.php','_self');" id="btn" />-->
   <?php } ?>
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

<style>
div.video{
	width:100%;
}
</style>

<div class="col-lg-8 col-md-9 col-sm-12">
<div class="video" style="float:none;">

<!--Start subscribe channel videos-->
<?php /*if(isset($session_member_id)){?>
<div class="popular_video">
<?php
$channel_query =mysqli_query($con, "select * from videos_subscribe a INNER JOIN member b ON a.member_id= b.member_id where a.subscriber_member_id='$session_member_id'");
while($channel_res = mysqli_fetch_array($channel_query)){
	$channel_id = $channel_res['member_id'];
?>

<a href="<?php echo $base_url.'user/'.$channel_res['username']; ?>"><h1><?php echo $channel_res['username'];?>
</h1></a>
    <ul class="popular" style="width:105%;">
    <?php 

$pvquery = "SELECT v.location, v.thumburl, v.title, v.video_id, v.date_created, v.view_count,
			c.name, v.url_type, m.username,v.duration
			FROM videos v LEFT JOIN videos_category c ON v.category = c.id
			LEFT JOIN member m ON m.member_id = v.user_id 
			WHERE v.type = 0 AND v.url_type != 2 AND v.user_id = '$channel_id' AND duration !=0
			GROUP BY v.parent_id
			ORDER BY v.video_id DESC
			LIMIT 10";
$pvsql = mysqli_query($con, $pvquery) or die(mysqli_error($con));
while($pvres = mysqli_fetch_array($pvsql))
{
	$time = $pvres['date_created'];
	$msg_id = $pvres['video_id'];
	$timedifference = timedifferenceindays($time);
	$curenttime = $pvres['duration'];
	
?>

    <li class="popular_list" id="popular_list-<?php echo $pvres['video_id'];?>">
    
   <a href="watch.php?video_id=<?php echo $pvres['video_id'];?>" class="watch" onclick="view_count()" id="<?php echo $pvres['video_id'];?>">
    <?php
    if($pvres['url_type'] == 1)
	{
	   if($timedifference <= 7 )
	   {
	    ?><img class="newImg" src="<?php echo $base_url; ?>images/new.png" width="35" height="35" /><?php
	   }
	
	?>
    <img src="<?php echo $base_url.'uploadedvideo/videothumb/p200x150'.$pvres['thumburl'];?>" width="150" height="120" class="mob_div_video">
    <span class="video-thumbnail-duration"><?php echo video_duration($curenttime); ?></span>
    </img>
    
    
    <?php 
    
    
    } 
	if($pvres['url_type'] == 2)
	{
		if (preg_match('![?&]{1}v=([^&]+)!', $pvres['location'] . '&', $m))
	$video_id = $m[1]; 
	$url = "http://img.youtube.com/vi/".$video_id."/default.jpg";	
			
	?>
    <img src="<?php echo $url;?>" width="200" height="150" />
    <?php 
	}
	
	?>
   
   </a>
<div class="video_Content">
<div class="test" >
<a href="watch.php?video_id=<?php echo $pvres['video_id'];?>">
<h3 class="video_title"><?php echo $pvres['title'];?></h3></a>
</div>

<div class="video_data">

<span class="view_count"><?php echo $pvres['view_count'];?> <?php echo $lang['views'];?></span>
<span class="content_item_time"><?php echo time_stamp($time);?></span><br/>
<span class="view_count"> <?php echo $lang['By'];?> <a href="<?php echo
 $base_url.'user/'.$pvres['username'];?>"><?php echo $pvres['username'];?></a></span>

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
        
        
<?php } ?>        
    </ul>
   
    <a href="<?php echo $base_url.'user/'.$channel_res['username']; ?>" class="morevideos" ><?php echo $lang['More videos'];?> ></a> <?php } ?> 
</div>
<?php } */?>
<!--Start popular videos-->
<div class="popular_video">
<a href="popular_videos.php"><h1><?php echo $lang['Popular Videos'];?></h1></a>
    <ul class="popular">
    <?php 
$pvquery = "SELECT v.location, v.thumburl, v.title, v.video_id, v.date_created, v.view_count,
			c.name, v.url_type, v.user_id, m.username,v.duration
			FROM videos v LEFT JOIN videos_category c ON v.category = c.id
			LEFT JOIN member m ON m.member_id = v.user_id 
			LEFT JOIN message msg ON msg.video_id = v.video_id 
			WHERE v.type = 0 AND v.url_type != 2 AND msg.share = 0 
			GROUP BY v.parent_id
			ORDER BY v.view_count DESC LIMIT 10";
$pvsql = mysqli_query($con, $pvquery) or die(mysqli_error($con));
while($pvres = mysqli_fetch_array($pvsql))
{
	$time = $pvres['date_created'];
	$msg_id = $pvres['video_id'];
	$timedifference = timedifferenceindays($time);
	$curenttime = $pvres['duration'];
	
	$vuser_id= $pvres['user_id'];
	$filter= mysqli_query($con, "SELECT * from videos_subscribe WHERE subscriber_member_id='$session_member_id' AND member_id = '$vuser_id'");
	
	if(mysqli_num_rows($filter)=='0')
	{
	
?>

    <li class="popular_list" id="popular_list-<?php echo $pvres['video_id'];?>">
    
   <a href="watch.php?video_id=<?php echo $pvres['video_id'];?>" class="watch" onclick="view_count()" id="<?php echo $pvres['video_id'];?>">
    <?php
    if($pvres['url_type'] == 1)
	{
	   if($timedifference <= 7 )
	   {
	    ?><img class="newImg" src="<?php echo $base_url; ?>images/new.png" width="35" height="35" /><?php
	   }
	
	?>
    <img src="<?php echo $base_url.'uploadedvideo/videothumb/p200x150'.$pvres['thumburl'];?>" width="150" height="120" class="mob_div_video">
    <span class="video-thumbnail-duration"><?php echo video_duration($curenttime); ?></span>
    </img>
    
    
    <?php 
    
    
    } 
	if($pvres['url_type'] == 2)
	{
		if (preg_match('![?&]{1}v=([^&]+)!', $pvres['location'] . '&', $m))
	$video_id = $m[1]; 
	$url = "http://img.youtube.com/vi/".$video_id."/default.jpg";	
			
	?>
    <img src="<?php echo $url;?>" width="200" height="150" />
    <?php 
	}
	
	?>
   
   </a>
<div class="video_Content">
<div class="test" >
<a href="watch.php?video_id=<?php echo $pvres['video_id'];?>">
<h3 class="video_title"><?php echo $pvres['title'];?></h3></a>
</div>

<div class="video_data">

<span class="view_count"><?php echo $pvres['view_count'];?> <?php echo $lang['views'];?></span>
<span class="content_item_time"><?php echo time_stamp($time);?></span><br/>
<span class="view_count"> <?php echo $lang['By'];?> <a href="<?php echo 
$base_url.'user/'.$pvres['username'];?>"><?php echo $pvres['username'];?></a></span>

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
        
        
<?php } } ?>        
    </ul>
    
    <a href="popular_videos.php" class="morevideos" ><?php echo $lang['More videos'];?> ></a> 
</div>

<!--Start featured videos-->
<div class="popular_video">
<a href="featured_videos.php" ><h1><?php echo $lang['Featured Videos'];?></h1></a>
    <ul class="popular">
    <?php 
$fvquery = "SELECT v.location, v.thumburl, v.user_id, v.title, v.video_id, v.date_created, v.view_count,
			c.name, v.url_type, m.username,v.duration 
			FROM videos v LEFT JOIN videos_category c ON v.category = c.id
			LEFT JOIN member m ON m.member_id = v.user_id 
			LEFT JOIN message msg ON msg.video_id = v.video_id 
			WHERE v.type = 0 AND v.url_type != 2 AND msg.share = 0 			
 			AND v.featured = 1
			GROUP BY v.parent_id
			 LIMIT 10";
$fvsql = mysqli_query($con, $fvquery) or die(mysqli_error($con));

while($fvres = mysqli_fetch_array($fvsql))
{
	$msg_id1 = $fvres['video_id'];
	$time = $fvres['date_created'];
	$timedifference = timedifferenceindays($time);
	$curenttime = $fvres['duration'];
	
	$fvuser_id= $fvres['user_id'];
	$ffilter= mysqli_query($con, "SELECT * from videos_subscribe WHERE subscriber_member_id='$session_member_id' AND member_id = '$fvuser_id'");
	
	if(mysqli_num_rows($ffilter)=='0')
	{
	
	
	
	
	
	
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
    <img src="<?php echo $base_url.'uploadedvideo/videothumb/p200x150'.$fvres['thumburl'];?>" width="150" height="120" class="mob_div_video">
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

<span class="view_count"><?php echo $fvres['view_count'];?> <?php echo $lang['views'];?></span>
<span class="content_item_time"><?php echo time_stamp($time);?></span>
<br/>
<span class="view_count"> <?php echo $lang['By'];?> <a href="<?php echo
 $base_url.'user/'.$fvres['username'];?>"><?php echo $fvres['username'];?></a></span>

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
        
        
<?php } } ?>        
    </ul>
    
   <a href="featured_videos.php" class="morevideos" ><?php echo $lang['More videos'];?> ></a> 
</div>

<!--Start recent videos-->
<div class="popular_video">
<a href="recent_videos.php"><h1><?php echo $lang['Recent Videos'];?></h1></a>
    <ul class="popular">
    <?php 
$rvquery = "SELECT v.location, v.thumburl, v.user_id, v.title, v.video_id, v.date_created, v.view_count,
			c.name, v.url_type, m.username,v.duration
			FROM videos v LEFT JOIN videos_category c ON v.category = c.id
			LEFT JOIN member m ON m.member_id = v.user_id 
			LEFT JOIN message msg ON msg.video_id = v.video_id 
			WHERE v.type = 0 AND v.url_type != 2 AND msg.share = 0 
			GROUP BY v.parent_id
			ORDER BY v.video_id DESC LIMIT 10";
$rvsql = mysqli_query($con, $rvquery) or die(mysqli_error($con));

while($rvres = mysqli_fetch_array($rvsql))
{
	$msg_id2 = $rvres['video_id'];
	$time = $rvres['date_created'];
	$timedifference = timedifferenceindays($time);
	$curenttime = $rvres['duration'];
	
	$rvuser_id= $rvres['user_id'];
	$rfilter= mysqli_query($con, "SELECT * from videos_subscribe WHERE subscriber_member_id='$session_member_id' AND member_id = '$rvuser_id'");
	
	if(mysqli_num_rows($rfilter)=='0')
	{
	
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
    <img src="<?php echo $base_url.'uploadedvideo/videothumb/p200x150'.$rvres['thumburl'];?>" width="150" height="120" class="mob_div_video">
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

<span class="view_count"><?php echo $rvres['view_count'];?> <?php echo $lang['views'];?></span>
<span class="content_item_time"><?php echo time_stamp($time);?></span>
<br/>
<span class="view_count"> <?php echo $lang['By'];?> <a href="<?php echo $base_url.'user/'.$rvres['username'];?>"><?php echo $rvres['username'];?></a></span>

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
        
        
<?php } } ?>        
    </ul>
    
    <a href="recent_videos.php" class="morevideos" ><?php echo $lang['More videos'];?> ></a> 

</div>

</div><!--End column left div-->
</div>

<div class="col-lg-3 col-md-3 hidden-sm hidden-xs">
<?php include ('leftSidebarPannelSubscribe.php');?>
</div>

</div>
<?php
	include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_footer.php');
?>
                            
                            