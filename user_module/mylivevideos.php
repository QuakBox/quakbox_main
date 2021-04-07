<?php
session_start();
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

	$session_member_id = $_SESSION['SESS_MEMBER_ID'];	

	date_default_timezone_set("Asia/Kolkata");	

		$sql = mysqli_query($con, "select * from member where member_id='".$session_member_id."' ") or die(mysqli_error($con));

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
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>font-awesome/css/font-awesome.css" />
<link rel="stylesheet" type="text/css" href="css/mobDesign_videoPage.css" />
<link rel="stylesheet" type="text/css" href="css/searchTextButton.css"/>
<link rel="stylesheet" type="text/css" href="css/video_gallery.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/subscribeProfilePage.css" />

<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/jquery-1.9.1.js"></script>
<script src="<?php echo $base_url;?>js/check.js"></script>
<script src="js/ibox.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery-ui.css" />
<script src="js/jquery-ui.js"></script>

 <link rel="stylesheet" type="text/css" href="css/youtube.css"/>


<link rel="stylesheet" type="text/css" href="css/search.css"/>
<link rel="stylesheet" type="text/css" href="css/my_videos_wall.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>font-awesome/css/font-awesome.css">



<link rel="stylesheet" type="text/css" href="css/uploadVideo.css"/>

<link rel="stylesheet" href="assets/chosen-jquery/chosen.css">
<style type="text/css">
.thumb-active{
	box-shadow:10px 10px 5px #888;
	-ms-box-shadow:10px 10px 5px #888;
	-webkit-box-shadow:10px 10px 5px #888;
	-moz-box-shadow:10px 10px 5px #888;
	-o-box-shadow:10px 10px 5px #888;
	border:2px solid;
	border-radius:20px;
}
</style>
<script src="js/jquery1.7.2.js"></script>
<script src="<?php echo $base_url;?>js/check.js"></script>
<script type="text/javascript" src="jscolor/jscolor.js"></script>
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

/*
 $('div.thumb').click(function(){

    var opt = $(this).attr("abc");
	var thumb_value = $(this).attr("data-value");

    if(opt==01)

    {

    $('#thumb1').addClass('thumb-active');

    $('#thumb2').removeClass('thumb-active');

	$('#thumb3').removeClass('thumb-active');

	$('#thumb4').removeClass('thumb-active');

	$('#thumb5').removeClass('thumb-active');
	
	$('#thumb6').removeClass('thumb-active');

    }

    else if(opt==02)

    {

    $('#thumb1').removeClass('thumb-active');

    $('#thumb2').addClass('thumb-active');

	$('#thumb3').removeClass('thumb-active');

	$('#thumb4').removeClass('thumb-active');

	$('#thumb5').removeClass('thumb-active');
	
	$('#thumb6').removeClass('thumb-active');

    }

    else if(opt==03)

    {

    $('#thumb1').removeClass('thumb-active');

    $('#thumb2').removeClass('thumb-active');

	$('#thumb3').addClass('thumb-active');

	$('#thumb4').removeClass('thumb-active');

	$('#thumb5').removeClass('thumb-active');
	
	$('#thumb6').removeClass('thumb-active');

    }

	else if(opt==04)

    {

     $('#thumb1').removeClass('thumb-active');

    $('#thumb2').removeClass('thumb-active');

	$('#thumb3').removeClass('thumb-active');

	$('#thumb4').addClass('thumb-active');

	$('#thumb5').removeClass('thumb-active');
	
	$('#thumb6').removeClass('thumb-active');

    }

     else if(opt==05)

    {

    $('#thumb1').removeClass('thumb-active');

    $('#thumb2').removeClass('thumb-active');

	$('#thumb3').removeClass('thumb-active');

	$('#thumb4').removeClass('thumb-active');

	$('#thumb5').addClass('thumb-active');
	
	$('#thumb6').removeClass('thumb-active');

    }
	
	else if(opt==06)

    {

    $('#thumb1').removeClass('thumb-active');

    $('#thumb2').removeClass('thumb-active');

	$('#thumb3').removeClass('thumb-active');

	$('#thumb4').removeClass('thumb-active');

	$('#thumb5').removeClass('thumb-active');
	
	$('#thumb6').addClass('thumb-active');

    }

    
$('#dthumb').val(thumb_value);
     

});*/

}) ;




/*
$( document).on( 'click', '.dropdown-toggle', function( event ) {

 

   

      $( '.dropdown-menu' ).slideToggle();

 

   return false;

 

});*/



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
 
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_header.php');

?>
<div class="insideWrapper container">
<?php 

if(isset($_GET['search'])) {
	$search = $_GET['search'];
	$pvsql = mysqli_query($con, "SELECT v.location, v.thumburl, v.title, v.video_id, v.date_created, v.view_count,
			c.name, v.url_type, m.username, v.duration
			FROM videos v LEFT JOIN videos_category c ON v.category = c.id
			LEFT JOIN member m ON m.member_id = v.user_id 
			WHERE user_id = '$session_member_id' 
			AND v.title like '%$search%' AND  live_video_id IS NOT NULL 
			ORDER BY v.video_id DESC");
} else {
	
	  $pvsql = mysqli_query($con, "SELECT v.location, v.thumburl, v.title, v.video_id, v.date_created, v.view_count,
			c.name, v.url_type, m.username, v.duration, v.country_id
			FROM videos v LEFT JOIN videos_category c ON v.category = c.id
			LEFT JOIN member m ON m.member_id = v.user_id  
			WHERE user_id = '$session_member_id'   AND  live_video_id IS NOT NULL
			ORDER BY v.video_id DESC");
}
//echo $pvsql;
//die('testing12345');

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
                <h2><?php echo "My Live video";?></h2>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div id="add-video-btn">
             
                   <!-- <input class="myButton" type="button" onclick="window.open('qcast.php','_self');" value="<?php echo $lang['Video Gallery'];?>" name="add_video"></input>-->
            
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
<div style="width:100% !important;">
    <div id="video_list_container" class="col-lg-8 col-md-9 col-sm-12"  >

    
<form name="delete_video" id="delete-video" action="action/delete_multiple_video.php" method="POST">
    	<ul id="video_list_container_ol" class="popular">

        <?php	


$i = 0;
while($pvres = mysqli_fetch_array($pvsql))

{

	$time = $pvres['date_created'];
	$curenttime = $pvres['duration'];

?>

    		<li id="videoli" class="popular_list" style="height:300px;">

           

            	<div>

                 <span class="checkbox_input" style="top: -10px;
position: relative;">

                	

						<input type="checkbox" value="<?php echo $pvres['video_id'];?>" class="video-checkbox" name="check[]" />

						

					

                       </span>                       

                    
					<span>
                    <a href="watch.php?video_id=<?php echo $pvres['video_id'];?>" class="view_video" id="<?php echo $pvres['video_id'];?>">

                    <img width="200" height="150" src="<?php echo $base_url.'uploadedvideo/videothumb/p200x150'.$pvres['thumburl']; ?>" />
                    <span class="video-thumbnail-duration" style="margin-right:30px;!important;"><?php echo video_duration($curenttime); ?></span>
    

                    </a></span>
					</div>
                   

                    <div class="video_Content" style="width:200px !important;">
					<div class="test">
                    <a href="watch.php?video_id=<?php echo $pvres['video_id'];?>" class="view_video" id="<?php echo $pvres['video_id'];?>">

                    <?php if(strlen($pvres['title']) >20) echo substr($pvres['title'],0,20)."..."; else  echo $pvres['title'];?>

                    </a>
					</div>
                      <div class="video_data">
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
                    


                    <label><?php echo date('M d, Y g:i A',$pvres['date_created']);?></label> <br /> <br />

                    <a href="edit_video.php?id=<?php echo $pvres['video_id'];?>"><img src="../images/editwrite.png" height="35" width="35"></a>

		    <a href="action/delete_video.php?id=<?php echo $pvres['video_id'];?>" class="remove_video"><img src="../images/Windows-recycle-bin-350.png" height="35" width="35"></a>   &nbsp;&nbsp;&nbsp;

               </div>

                    </div>

                

            </li>

            <?php $i++; } ?>

    	</ul>

        
</form>

    </div>
	<div class="col-lg-3 col-md-3 hidden-sm hidden-xs">
	<?php include ('leftSidebarPannelSubscribe.php');?>
</div>
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