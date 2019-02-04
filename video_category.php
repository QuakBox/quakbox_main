<?php 
	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php'); 	 
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');
	//require_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/time_stamp.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/video-time.php');
	
	
	
	if(isset($_SESSION['SESS_MEMBER_ID']))
	{	
		$session_member_id = $QbSecurity->qbClean($_SESSION['SESS_MEMBER_ID'], $con);
		$sql = mysqli_query($con, "select * from member where member_id='".$session_member_id."'") or die(mysqli_error($con));
		$res = mysqli_fetch_array($sql);
	}	
	$id1 = $QbSecurity->qbClean($_REQUEST['id'], $con);
	if(!(empty($id1 )||($qbValidation->qbIntegerCheck($id1))))
	{
	$qb_err_msg="Oops Something Went Wrong...!";
    $QbSecurity->qbErrorMessage($qb_err_msg,$homepage);
	}
	else
	{
	$csql = mysqli_query($con, "SELECT name FROM videos_category WHERE id ='$id1'");
	$cres = mysqli_fetch_array($csql);
	$category_name = $cres['name'];
?>
<?php /*?><link rel="stylesheet" type="text/css" href="css/style.css"/>

<link rel="icon" href="images/favicon.ico" type="image" />
<link rel="shortcut icon" href="images/favicon.ico" type="image" />

<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css" />
<link rel="stylesheet" type="text/css" href="css/responsive.css" />
<link rel="stylesheet" type="text/css" href="css/bootstrap-reset.css" /><?php */?>
<link rel="stylesheet" type="text/css" href="css/wall.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>font-awesome/css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/subscribeProfilePage.css" />
<link rel="stylesheet" type="text/css" href="css/video_gallery.css"/>
<link rel="stylesheet" type="text/css" href="css/mobDesign_videoPage.css" />
<link rel="stylesheet" type="text/css" href="css/searchTextButton.css"/>
<script src="js/bootstrap.min.js"></script>


<script src="js/jquery.min.js"></script>
<script src="js/jquery-1.9.1.js"></script>
<script src="<?php echo $base_url;?>js/check.js"></script>
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


<?php 
if(isset($_SESSION['SESS_MEMBER_ID'])) {
    require_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_header.php');
} else {
	include('qboxHeader.php');
}
?>
<div class="insideWrapper container">
    <div class="row">
	
       <!-- <div id="ad_creative" style="margin-top: -15px;">
         <div id="closeAdd" >
        <a href="javascript:void(0);" class="ads_close"><?php //echo $lang['Close Ad'];?></a>
        </div>
       <div class="embed-responsive embed-responsive-16by9">
        	<embed src="ads/quakbox.swf" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"  quality="high" allowscriptaccess="always" wmode="transparent" align="middle"></embed>
        </div>
        <?php /*?><embed src="ads/quakbox.swf" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"  quality="high" allowscriptaccess="always" wmode="transparent" align="middle" width="960" height="180"></embed><?php */?>
        </div>-->
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
                            <span class="icon-home">
                            <img src="images/uploadVideo.png" height="20" width="20" /> 
                            </span>
                               
                          </a>
                        </li>
                        <li>
                          <a href="myvideos.php">
                            <span class="icon-cog">
                                    <img src="images/folderIcon.png" height="20" width="20" /> 
                            </span>    
                          </a></li>
                        <li id="search_btn_list">
                            <a href="#">
                                <span class="icon-cw">
                                        <img src="images/searchBtn.png" height="20" width="20" class="trigger" /> 
                                        
                                        <script>
                                            $(document).ready(function() {
                                                 $('#search_btn_list .trigger').click(function(){
                                                    $('.search-bar').animate({width:'toggle'},1500);
                                                    
                                                 });
                                            });
                                        </script>
                                       </span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <div id="search_box_mobDesign" class="search-bar" style="width:280px; display:none;">
         <input id="searchbar" type="text" name="search" placeholder="<?php echo $lang['Type here'];?>" class="rounded searchbox">
         </div>
    
        <div class="col-lg-8 col-md-9 col-sm-12">
            <div class="video" style="float:none;">
            
            
            
            <div class="popular_video">
            <h1><?php echo $category_name.' '.$lang['Videos'];?></h1>
                <ul class="popular">
                <?php 
            
            $pvquery = "SELECT v.location, v.thumburl, v.title, v.video_id, v.date_created, v.view_count,
                        c.name, v.url_type, m.username,v.duration
                        FROM videos v LEFT JOIN videos_category c ON v.category = c.id
                        LEFT JOIN members m ON m.member_id = v.user_id 
                        WHERE v.type = 0 AND v.url_type != 2 AND v.category = '$id1'
                        GROUP BY v.parent_id
                        ORDER BY v.view_count DESC";
            $pvsql = mysqli_query($con, $pvquery) or die(mysqli_error($con));
            while($pvres = mysqli_fetch_array($pvsql))
            {
                $time = $pvres['date_created'];
                $msg_id = $pvres['video_id'];
                $timedifference = timedifferenceindays($time);
                $curenttime = $pvres['duration'];
            ?>
            
                <li class="popular_list" id="popular_list-<?php echo $pvres['video_id'];?>">
                
               <a href="watch.php?video_id=<?php echo $QbSecurity->qbClean($pvres['video_id'], $con);?>" class="watch" onclick="view_count()" id="<?php echo $QbSecurity->qbClean($pvres['video_id'], $con);?>">
                <?php
                if($pvres['url_type'] == 1)
                {
                   if($timedifference <= 7 )
                   {
                    ?><img class="newImg" src="<?php echo $base_url; ?>images/new.png" width="35" height="35" /><?php
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
                <img src="<?php echo $url;?>" width="200" height="150" />
                <?php 
                }
                
                ?>
               
               </a>
            <div class="video_Content">
            <div class="test" >
            <a href="watch.php?video_id=<?php echo $QbSecurity->qbClean($pvres['video_id'], $con);?>">
            <h3 class="video_title"><?php echo $pvres['title'];?></h3></a>
            </div>
            
            <div class="video_data">
            
            <span class="view_count"><?php echo $pvres['view_count'];?> <?php echo $lang['views'];?></span>
            <span class="content_item_time"><?php echo time_stamp($time);?></span><br/>
            <span class="view_count"> <?php echo $lang['By'];?> <a href="<?php echo $base_url.'user/'.$pvres['username'];?>"><?php echo $pvres['username'];?></a></span>
            
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
}
?>
                            
                            