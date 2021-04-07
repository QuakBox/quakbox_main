<?php
	ob_start();
	session_start();
	
	if(!isset($_SESSION['SESS_MEMBER_ID']))
	{
		header("location: ".$base_url."index.php");
		exit();
	}

	require_once('config.php');
	require_once('includes/time_stamp.php');

	$member_id = $_SESSION['SESS_MEMBER_ID'];
	$country_code = $_REQUEST['country'];
	$category = $_REQUEST['category'];

    if(empty($category) || $category == 'qbnews'){
        $defaultCategory = 'politics';
        header("Location: ".$base_url."news_category.php?country=".$country_code."&category=".$defaultCategory);
        exit();
    }
	
	$member = mysqli_query($con, "select * from members where member_id = '$member_id'");
	$member_res = mysqli_fetch_array($member);
	$sql = mysqli_query($con, "select * from geo_country where country_title='".$country_code."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);
	$country_id = $res['country_id'];
?>

<link rel="stylesheet" type="text/css" href="css/jquery-ui.css"/>
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css"/>
<link rel="stylesheet" type="text/css" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"/>
<script src="js/jquery.min.js"></script>
<style>
.nopadding {
   padding: 0 !important;
   margin: 0 !important;
}
.videowrapper {
    float: none;
    clear: both;
    width: 100%;
    position: relative;
    padding-bottom: 56.25%;
    /*padding-top: 25px;*/
    height: 0;
}
.videowrapper iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}
</style>

<style>
    
/*  bhoechie tab */
div.bhoechie-tab-container{
  z-index: 10;
  background-color: #ffffff;
  padding: 0 !important;
  border-radius: 4px;
  -moz-border-radius: 4px;
  border:1px solid #ddd;
  margin-top: 0px;
  margin-left: 0px;
  -webkit-box-shadow: 0 6px 12px rgba(0,0,0,.175);
  box-shadow: 0 6px 12px rgba(0,0,0,.175);
  -moz-box-shadow: 0 6px 12px rgba(0,0,0,.175);
  background-clip: padding-box;
  opacity: 0.97;
  filter: alpha(opacity=97);
}
div.bhoechie-tab-menu{
  padding-right: 0;
  padding-left: 0;
  padding-bottom: 0;
}
div.bhoechie-tab-menu div.list-group{
  margin-bottom: 0;
}
div.bhoechie-tab-menu div.list-group>a{
  margin-bottom: 0;
}
div.bhoechie-tab-menu div.list-group>a .glyphicon,
div.bhoechie-tab-menu div.list-group>a .fa {
  color: #5A55A3;
}
div.bhoechie-tab-menu div.list-group>a:first-child{
  border-top-right-radius: 0;
  -moz-border-top-right-radius: 0;
}
div.bhoechie-tab-menu div.list-group>a:last-child{
  border-bottom-right-radius: 0;
  -moz-border-bottom-right-radius: 0;
}
div.bhoechie-tab-menu div.list-group>a.active,
div.bhoechie-tab-menu div.list-group>a.active .glyphicon,
div.bhoechie-tab-menu div.list-group>a.active .fa{
  background-color: #5A55A3;
  background-image: #5A55A3;
  color: #ffffff;
}
div.bhoechie-tab-menu div.list-group>a.active:after{
  /*content: '';*/
  position: absolute;
  left: 50%;
  top: 50%;
  margin-top: -13px;
  border-left: 0;
  border-top: 13px solid transparent;
  border-left: 10px solid #5A55A3;
}

div.bhoechie-tab-content{
  background-color: #ffffff;
  /* border: 1px solid #eeeeee; */
  /*padding-left: 20px;*/
  padding-top: 10px;
}

div.bhoechie-tab div.bhoechie-tab-content:not(.active){
  display: none;
}
</style>
<script>
$(document).ready(function() {
    $("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
        e.preventDefault();
        $(this).siblings('a.active').removeClass("active");
        $(this).addClass("active");
        var index = $(this).index();
        $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
        $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
    });
});
</script>


<?php include('includes/qb_header.php');?>
<div clas="row">
    <div class="col-lg-2 col-lg-2 col-md-2 hidden-sm hidden-xs" >
        <?php include 'includes/news_left_panel.php'; ?>
    </div>
    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12" >
        <div class="well">
            <?php include 'includes/qb_header_news.php'; ?>
        </div>

        <div class="bhoechie-tab-container" height="200">
            <div class="bhoechie-tab" style="padding: 0px !important;margin: 0px !important">
                <!-- flight section -->
                <div class="bhoechie-tab-content active nopadding">
                    <center>
                        <div class="videowrapper">
                        <iframe class="nopadding" height="200"  allowfullscreen="" src="https://www.youtube.com/embed/h_90gqvlmoM?autoplay=1"></iframe>
                        </div>
                    </center>
                </div>
                <!-- train section -->
                <div class="bhoechie-tab-content">
                    <center>
                      <h1 class="glyphicon glyphicon-fire" style="font-size:12em;color:#55518a"></h1>
                    </center>
                </div>
    
                <!-- hotel search -->
                <div class="bhoechie-tab-content">
                    <center>
                      <h1 class="fa fa-slack" style="font-size:12em;color:#55518a"></h1>
                    </center>
                </div>
                <div class="bhoechie-tab-content">
                    <center>
                      <h1 class="fa fa-bullhorn" style="font-size:12em;color:#55518a"></h1>
                    </center>
                </div>
                <div class="bhoechie-tab-content">
                    <center>
                      <h1 class="fa fa-star" style="font-size:12em;color:#55518a"></h1>
                    </center>
                </div>
            </div>
        
             <div class="col-md-12 bhoechie-tab-menu">
              <div class="list-group">
                <a href="#" class="col-md-2 list-group-item active text-center">
                  <h4 class="glyphicon glyphicon-facetime-video"></h4><br/>Streams 
                </a>
                <a href="#" class=" col-md-2 list-group-item text-center">
                  <h4 class="glyphicon glyphicon-fire"></h4><br/>Top News
                </a>
                <a href="#" class=" col-md-3 list-group-item text-center">
                  <h4 class="fa fa-slack"></h4><br/>Most Popular 
                </a>
                <a href="#" class="col-md-2  list-group-item text-center">
                  <h4 class="fa fa-bullhorn"></h4><br/>Top Buzz
                </a>
                <a href="#" class="col-md-3  list-group-item text-center">
                  <h4 class="fa fa-star"></h4><br/>Suggested for You
                </a>
              </div>
            </div>
        
        </div>             
            
          </div>
    
    <div class="col-md-2 col-lg-2 hidden-sm hidden-xs pull-right">
        <?php include 'includes/news_right_panel.php'; ?>
    </div>

</div>
 <?php include 'includes/qb_footer.php';?>
