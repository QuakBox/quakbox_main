<?php
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php'); 	 
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');
	//require_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/video-time.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_header.php');
	
	if(isset($_SESSION['SESS_MEMBER_ID']))
	{	
	$session_member_id = $QbSecurity->qbClean($_SESSION['SESS_MEMBER_ID'], $con);
	$session_member_id=htmlspecialchars(trim($session_member_id));
	$sql = mysqli_query($con, "select * from member where member_id='".$session_member_id."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);
	}
?>
<?php /*?><link rel="stylesheet" type="text/css" href="css/search.css"/>
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="icon" href="images/favicon.ico" type="image" />
<link rel="shortcut icon" href="images/favicon.ico" type="image" />
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css" />
<link rel="stylesheet" type="text/css" href="css/bootstrap-reset.css" />
<link rel="stylesheet" type="text/css" href="css/responsive.css" /><?php */?>

<link rel="stylesheet" type="text/css" href="css/wall.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>font-awesome/css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="css/mobDesign_videoPage.css" />
<link rel="stylesheet" type="text/css" href="css/searchTextButton.css"/>
<link rel="stylesheet" type="text/css" href="css/video_gallery_search.css"/>
<script src="js/bootstrap.min.js"></script>

<script src="js/jquery.min.js"></script>
<script src="js/jquery-1.9.1.js"></script>
<script src="js/ibox.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery-ui.css" />
<script src="js/jquery-ui.js"></script>

 <link rel="stylesheet" type="text/css" href="css/youtube.css"/>

<script type="text/javascript">
$(function() {
 $("#searchbar").autocomplete({
	 source: "load_data/video_names_ajax.php",			
			select: true
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
<div class="insideWrapper container">
<?php
/*if(isset($_SESSION['SESS_MEMBER_ID'])) {
    include('includes/header.php');
} else {
	include('qboxHeader.php');
}*/
?>
    <div class="row profile_wrapper">
        <div id="searchSubmenu" class="videogallerysearch">
        
        <div class="searchmenu">
        <ul class="submenu" >    
        <li><form action="video_gallery_search.php" method="get" onSubmit="return searchCheck()">
        <input id="searchbar" type="text" name="search" style="margin-left:8px;" placeholder="<?php echo $lang['Type here'];?>" class="searchbar rounded">
            <button class="btn btn-default btn-lg searchBtn" type="submit">
        
            <div class="fa-search fa"></div>
        
        </button>
        <input type="button" name="add_video" class="submit myButton" value="<?php echo $lang['Add video'];?>" id="btn" onclick="window.open('add_video_gallery.php','_self');"  />
           
            <?php if(isset($session_member_id)){?>
           
           <input type="button" name="add_video" class="submit myButton" value="<?php echo $lang['My video'];?>" onclick="window.open('myvideos.php','_self');" id="btn" />
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
        
        <div class="col-lg-8 col-md-9 col-sm-12">
            <div class="column_left">
            <?php
             
            $search = $_REQUEST['search'];
            $vsql = mysqli_query($con, "select v.date_created, v.video_id, v.thumburl, v.title, m.member_id, m.username, v.view_count,
                                v.description, v.url_type, v.location,v.duration 
                                FROM videos v LEFT JOIN members m ON m.member_id = v.user_id where title like '%$search%'");
            
            
            ?>
            <span class="mysearch_div"><?php echo $lang['Records found'];?>: <b><?php echo $search;?></b></span>
            <span class="mysearch_div"><?php echo $lang['Records found'];?> : <b><?php echo mysqli_num_rows($vsql);?></b></span>
            <div style="margin-top:10px;">
            <ul class="popular">
            <?php 
            while($vres = mysqli_fetch_array($vsql))
            {
                $time = $vres['date_created'];
                $msg_id = $vres['video_id'];
                $curenttime = $vres['duration'];
            
            ?>
            <li class="popular_list myclass_search" id="popular_list-<?php echo $vres['video_id'];?>">
            
                <a href="watch.php?video_id=<?php echo $vres['video_id'];?>" class="watch myclass_watch_video" onclick="view_count()" id="<?php echo $vres['video_id'];?>">
                  
                
                <img class="mob_div_video" src="<?php echo $base_url.'uploadedvideo/videothumb/p200x150'.$vres['thumburl'];?>" width="200" height="150" >
                <span class="video-thumbnail-duration"><?php echo video_duration($curenttime); ?></span>
                </img>
                
                  
               </a>
              
            <div class="video_Content">
            <div class="test" >
            <a href="watch.php?video_id=<?php echo $vres['video_id'];?>">
            <h3 class="video_title"><?php echo $vres['title'];?></h3></a>
            </div>
            <div class="myclass_video_data">
            <div class="video_data">
            
            <span class="view_count"><?php echo $vres['view_count'];?> <?php echo $lang['views'];?></span>
            <span class="content_item_time"><?php echo time_stamp($time);?></span><br/>
            <span class="view_count"><?php echo $lang['By'];?> <a href="<?php echo $base_url.'user/'.$vres['username'];?>"><?php echo $vres['username'];?></a></span>
            <div class="vdescription">
            <?php echo $vres['description'];?>
            </div> 
            </div>
            </div>
            </div>
            </li>
            <?php }?>
            </ul>
            </div>
            </div><!--End column left div-->
        </div>
    </div><!--End mainbody div-->
</div><!--End wrapper div-->
<?php
	include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_footer.php');
?>