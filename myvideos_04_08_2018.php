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

	$session_member_id = $_SESSION['SESS_MEMBER_ID'];	

	date_default_timezone_set("Asia/Kolkata");	

		$sql = mysqli_query($con, "select * from member where member_id='".$session_member_id."'") or die(mysqli_error($con));

		$res = mysqli_fetch_array($sql);	

?>
<?php /*?><link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css" />
<link rel="stylesheet" type="text/css" href="css/responsive.css" />
<link rel="icon" href="images/favicon.ico" type="image" />
<link rel="shortcut icon" href="images/favicon.ico" type="image" />
<link rel="stylesheet" type="text/css" href="css/bootstrap-reset.css" /><?php */?>
<link rel="stylesheet" type="text/css" href="css/wall.css"/>
<link rel="stylesheet" type="text/css" href="css/search.css"/>
<link rel="stylesheet" type="text/css" href="css/my_videos_wall.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>font-awesome/css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="css/mobDesign_videoPage.css" />
<link rel="stylesheet" type="text/css" href="css/searchTextButton.css"/>



<script src="js/jquery.min.js"></script>

<script src="js/jquery-1.9.1.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="<?php echo $base_url;?>js/check.js"></script>
<script src="js/ibox.js"></script>

<link rel="stylesheet" type="text/css" href="css/jquery-ui.css" />

<script src="js/jquery-ui.js"></script>



 <link rel="stylesheet" type="text/css" href="css/youtube.css"/>

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

function hideShowOfCountryList(id)
{
document.getElementById("showCountOfCountries"+id).style.display = "none";
document.getElementById("showFullCountryList"+id).style.display = "inline";
}





</script>

<style type="text/css">
a:hover
{
	text-decoration:none;
}
</style>
<div class="insideWrapper container">
<?php 
 require_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_header.php');
if(isset($_GET['search'])) {
	$search = $_GET['search'];
	$pvsql = mysqli_query($con, "SELECT v.location, v.thumburl, v.title, v.video_id, v.date_created, v.view_count,
			c.name, v.url_type, m.username, v.duration
			FROM videos v LEFT JOIN videos_category c ON v.category = c.id
			LEFT JOIN member m ON m.member_id = v.user_id 
			WHERE user_id = '$session_member_id'
			AND v.title like '%$search%'
			ORDER BY v.video_id DESC");
} else {
	$pvsql = mysqli_query($con, "SELECT v.location, v.thumburl, v.title, v.video_id, v.date_created, v.view_count,
			c.name, v.url_type, m.username, v.duration, v.country_id
			FROM videos v LEFT JOIN videos_category c ON v.category = c.id
			LEFT JOIN member m ON m.member_id = v.user_id 
			WHERE user_id = '$session_member_id'
			ORDER BY v.video_id DESC");
}
?>
<div class="row">
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
                          <a href="qcast.php">
                        <div style="float:left;">
                        
                            <span class="icon-cog">
                                    <img src="images/folderIcon.png" height="20" width="20" /> 
                            </span>    
                         
                          </div>
                          
                           </a>
                          </li>
                          
                      </ul>
                </nav>
            </div>
        </div>
</div>
<div class="col-lg-12 col-md-12 col-sm-12">
    <div class="componentheading">
        <div id="submenushead" class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <h2><?php echo $lang['My Videos'];?></h2>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div id="add-video-btn">
             
                    <input class="myButton" type="button" onclick="window.open('qcast.php','_self');" value="<?php echo $lang['Video Gallery'];?>" name="add_video"></input>
            
                    <input class="myButton" type="button" onclick="window.open('add_video_gallery.php','_self');" value="<?php echo $lang['Add video'];?>" name="add_video"></input>
            
                 </div>
            </div>
        </div>
    </div>
    <div id="headinfo"></div>
    <div class="row" id="upload-search-div">
        <div class="col-lg-5 col-md-4 col-sm-4" id="uploadsno">
    
            <h2> <?php echo $lang['Uploads'];?></h2>
    
            <?php if(!isset($_GET['search'])) {  ?>
    
            <span><?php echo mysqli_num_rows($pvsql);?></span>
    
            <?php  }?>
    
         </div>   
        <div class="col-lg-7 col-md-8 col-sm-8" id="searchdiv">
    
        <form method="get" onSubmit="return searchCheck()">
    
            <div class="row">
    
                <div class="col-lg-12">
    
                <div class="input-group">
                <input id="search-q" type="text" name="search" placeholder="<?php echo $lang['Type here'];?>" class="searchbar rounded" value="">
        <button class="btn btn-default btn-lg searchBtn" type="submit">
    
        <div class="fa-search fa"></div>
    
    </button>
    
                <!--  <input type="text" class="form-control" name="search" id="search-q" value="<?php if(isset($_GET['search'])) { echo $_GET['search'];} ?>">
    
                      <span class="input-group-btn  ">
    
                        <button class="btn btn-default myBtn" type="submit"><?php echo $lang['Go'];?>!</button>
    
                      </span> -->
    
                    </div><!-- /input-group -->
    
          </div><!-- /.col-lg-6 -->
    
        </div><!-- /.row -->
    
        
    
        
    
        </form>
    
        </div>
    </div>
    <?php if(mysqli_num_rows($pvsql) > 0) {  ?>

    <div id="actions">

	<div>

	<input type="checkbox" value="all" name="selectall" id="selectall" />

	</div>

 

 

 <div id="select-type">

 <a onclick="document.getElementById('delete-video').submit()">

 <img src="../images/Windows-recycle-bin-350.png" height="50" width="50"></a>

 

<!--<div class="btn-group btn-input clearfix">

  <button type="button" class="btn btn-default dropdown-toggle form-control" data-toggle="dropdown">

    <span data-bind="label">Select One</span> <span class="caret"></span>

  </button>

  <ul class="dropdown-menu" role="menu">

   <li><a href="#">Public</a></li>

    <li><a href="#">Private</a></li>

    <li><a href="#">Delete</a></li>

  </ul>

</div>-->

</div>

 <?php } ?>	

          

    

    <hr />

    <?php	

if(mysqli_num_rows($pvsql) > 0){

	?>	

    <div id="video_list_container">

    
<form name="delete_video" id="delete-video" action="action/delete_multiple_video.php" method="POST">
    	<ol id="video_list_container_ol" class="videoList">

        <?php	


$i = 0;
while($pvres = mysqli_fetch_array($pvsql))

{

	$time = $pvres['date_created'];
	$curenttime = $pvres['duration'];

?>

    		<li id="videoli">

           

            	<div id="video_content">

                 <span class="checkbox_input">

                	<div>

						<input type="checkbox" value="<?php echo $pvres['video_id'];?>" class="video-checkbox" name="check[]" />

						

					</div>

                       </span>                       

                    <div class="videoThumb">

                    <a href="watch.php?video_id=<?php echo $pvres['video_id'];?>" class="view_video" id="<?php echo $pvres['video_id'];?>">

                    <img width="150" height="130" src="<?php echo $base_url.'uploadedvideo/videothumb/p200x150'.$pvres['thumburl']; ?>" >
                    <span class="video-thumbnail-duration"><?php echo video_duration($curenttime); ?></span>
    </img>

                    </a>

                    </div>

                    <div class="video_info">

                    <a href="watch.php?video_id=<?php echo $pvres['video_id'];?>" class="view_video" id="<?php echo $pvres['video_id'];?>">

                    <?php echo $pvres['title'];?>

                    </a>

                     <br />   
                    <?php 
                    if($pvres['country_id'] != 0){
					
$count_c = explode(",",$pvres['country_id']);
	
	//echo count($count_c)."<br />";
	?> Streamed Video on <?php
	if(count($count_c)==1){
	$civfsql = mysqli_query($con, "select * from geo_country where country_id='".$count_c[0]."'") or die(mysqli_error($con));
	$civfres = mysqli_fetch_array($civfsql);
	$country_name_video = str_replace(' ', '-', $civfres['country_title']); ?>
	<span><a href="<?php echo $base_url.'country_wall.php?country='.$country_name_video;?>" ><?php echo $civfres['country_title'];?></a></span><?php
	}else{ ?>
	<span id="showCountOfCountries<?php echo $pvres['video_id'];?>" onclick="hideShowOfCountryList(<?php echo $pvres['video_id'];?>);"><a href="javascript:void(0)"><?php echo count($count_c).' Countries';?></a></span><?php
	$andCount=intval(count($count_c))-2;
	$lastCount=intval(count($count_c))-1;
	?>
	<span style="display:none;" id="showFullCountryList<?php echo $pvres['video_id'];?>">
	<?php
	for($i=0;$i<=count($count_c);$i++){ 
//video country id fetch
	$civfsql = mysqli_query($con, "select * from geo_country where country_id='".$count_c[$i]."'") or die(mysqli_error($con));
	$civfres = mysqli_fetch_array($civfsql);
	$country_name_video = str_replace(' ', '-', $civfres['country_title']); ?>
	<a href="<?php echo $base_url.'country_wall.php?country='.$country_name_video;?>" ><?php 
	echo $civfres['country_title'];
	if($i==$andCount)
	{ echo ' and'; }
	else if($i==count($count_c)){ echo '.';}
	else{  if($i!=$lastCount)echo ', ';}
	?></a><?php
} ?></span><?php } }
                    ?>
                     <br />

                    <label><?php echo date('M d, Y g:i A',$pvres['date_created']);?></label> <br /> <br />

                    <a href="edit_video.php?id=<?php echo $pvres['video_id'];?>"><img src="../images/editwrite.png" height="35" width="35"></a>

		    <a href="action/delete_video.php?id=<?php echo $pvres['video_id'];?>" class="remove_video"><img src="../images/Windows-recycle-bin-350.png" height="35" width="35"></a>   &nbsp;&nbsp;&nbsp;

               

                    </div>

                </div>

            </li>

            <?php $i++; } ?>

    	</ol>

        
</form>
    </div>

    <?php  } else {?>

        <div class="no-videos-found"><?php echo $lang['No videos were found'];?>. </div>

        <?php  } ?>

</div><!--End mainbody div-->
</div>
</div><!--End wrapper div-->
<?php
	include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_footer.php');
?>