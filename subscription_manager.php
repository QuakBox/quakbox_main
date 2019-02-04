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

	$session_member_id = $_SESSION['SESS_MEMBER_ID'];	
	
	$sql = mysqli_query($con, "select * from member where member_id='".$session_member_id."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);	
	$uname=$res['username'];


	if(isset($_GET['delete_id'])){	
		$delete_id = $_REQUEST['delete_id'];
		mysqli_query($con, "DELETE FROM videos_subscribe WHERE member_id='$delete_id'");
		header("location: ".$base_url."subscription_manager.php?err=");
		exit();
	} 	
?>
<?php /*?><link rel="stylesheet" type="text/css" href="css/search.css"/>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css" />
<link rel="stylesheet" type="text/css" href="css/responsive.css" />
<link rel="icon" href="images/favicon.ico" type="image" />
<link rel="shortcut icon" href="images/favicon.ico" type="image" />
<link rel="stylesheet" type="text/css" href="css/bootstrap-reset.css" />
<link rel="stylesheet" type="text/css" href="css/style.css"/><?php */?>

<link rel="stylesheet" type="text/css" href="css/wall.css"/>
<link rel="stylesheet" type="text/css" href="css/my_videos_wall.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>font-awesome/css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="css/searchTextButton.css"/>
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

</style>
<div class="insideWrapper container">
<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_header.php');
if(isset($_GET['search'])) {
	$search = $_GET['search'];
	$clicks =mysqli_query($con, "select * from videos_subscribe a INNER JOIN members b ON a.member_id= b.member_id where a.subscriber_member_id='$session_member_id' AND b.username like '%$search%'");
} else {
	$clicks =mysqli_query($con, "select * from videos_subscribe a INNER JOIN members b ON a.member_id= b.member_id where a.subscriber_member_id='$session_member_id' ORDER BY b.username asc");
}
?>
    <div class="row profile_wrapper">
        <div id="rightSidePannel">
         
        </div>
        <div class="col-lg-8 col-md-9 col-sm-12">
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
            
             
            
                
            <div class="componentheading channelHd">
                <div id="submenushead"><?php echo $lang['My Stations'];?></div>
                <div id="vinod" ></div>
                </div>
              <?php	
            
            if(mysqli_num_rows($clicks) > 0){
            
                ?>	
                
            <div id="searchdiv" style="float: none;">
            
                <form method="get" onSubmit="return searchCheck()" class="searchBox">
            
                    <div class="row">
            
                        <div class="col-lg-12">
            
                        <div class="input-group">
                        
                        <input id="search-q" style="width: 300px;" type="text" name="search" placeholder="<?php echo $lang['Type here'];?>" class="searchbar rounded" value="<?php if(isset($_GET['search'])) { echo $_GET['search'];} ?>">
                <button class="btn btn-default btn-lg searchBtn" type="submit">
            
                <div class="fa-search fa"></div>
            
            </button>
            
                          
            
                            </div><!-- /input-group -->
            
                  </div><!-- /.col-lg-6 -->
            
                </div><!-- /.row -->
            
                
            
                
            
                </form>
            
                </div>
                
              <?php } ?>
                
                
                
                
            
            <div id="border" class="sub_manager">
            <?php	
            
            if(mysqli_num_rows($clicks) > 0){
            
                ?>	
              
             <div class="dlt_chk_all">
            
                <input type="checkbox" value="all" name="selectall" id="selectall" class="selectAll" style="margin-top: 24px;" />
             <div id="select-type">
            
             <a onclick="document.getElementById('delete-video').submit()">
            
             <img src="images/delete.png" height="15" width="15"></a>
            
             
            </div>
            </div>    <?php } ?>
               
               <?php 
               if(mysqli_num_rows($clicks) > 0){
            
                ?>	
            
            <form name="delete_video" id="delete-video" action="action/delete_multiple_sub.php" method="POST">
                    <ol id="video_list_container_ol" class="videoList">
            
            
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
                
            <ul>
            <li>
            <span class="onecheck">
            <input type="checkbox" value="<?php echo $member;?>" class="video-checkbox" name="check[]" />
            </span>                       
            
            <a href="<?php echo $base_url.$clicks_res['username'];?>" title="<?php echo ucfirst($clicks_res['username']);?>" class="onecheck"><img src="<?php echo $clicks_res['profImage'];?>" width="68" height="68" style="vertical-align: middle;" /></a>
            <span class="user_name"><a href="<?php echo $base_url.$clicks_res['username'];?>" 
            title="<?php echo ucfirst($clicks_res['username']);?>"><div<strong><?php echo ucfirst($clicks_res['username']);?></strong></a></span>
            <a href="subscription_manager.php?delete_id=<?php echo $clicks_res['member_id']?>"><img src="images/delete.png" height="15" width="15" class="delete_img"></a>
            </li><br /><!--end mini profile-->
            <?php  }
            ?>
            </div>
            
            </form>
            
            <?php } ?>
            
                </div>
            
                
            </div>
        </div>
        <div class="col-lg-3 col-md-3 hidden-sm hidden-xs">
        	<?php include ('leftSidebarPannelSubscribe.php');?>
        </div>
    </div><!--End mainbody div-->
</div>
<?php
	include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_footer.php');
?>