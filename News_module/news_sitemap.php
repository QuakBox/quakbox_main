<?php

/**
 * News Category page
 */
require_once('common/core.php');
require_once('includes/time_stamp.php');
require_once('qb_classes/qb_news.php');
require_once('qb_classes/qb_misc.php');
require_once('qb_widgets/country_menu.php');

$news = new QB_News();
$res = $news->dataToArray();
$country_code = $news->getCountryTitle();
$category = '';
$countryID = 0;
if(isset($_GET['category'])){
	$category = $_GET['category'];
}
if(isset($_GET['country'])){
	$_GET['country'] = $_GET['country'];
} else{
	$_GET['country'] = '';
}
$countryCode =$_GET['country'];
$miscObjCountry = new misc();
$countryID = $miscObjCountry->getcountryIdByName(trim($countryCode));


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo "Sitemap";?></title>
<head>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css" />
<link rel="stylesheet" type="text/css" href="css/jquery-ui.css"/>
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css"/>
<link rel="stylesheet" type="text/css" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"/>

<script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
<script src="sjs/jquery.min.js"></script>

<style>
    
    .nopadding {
   padding: 0 !important;
   margin: 0 !important;
}
</style>
</head>
<body>
<div id="wrapper">
<?php 
 include('includes/qb_header.php');
?>

<div class="row" style="padding:0.1px; margin:0.1px ; margin-top:15px;">   
   
    <div class="col-md-2" >
        <?php include 'includes/news_left_panel.php'; ?>
    </div>
    <div class="col-md-8" > 
        <!--div class="well fixed-header">
            <?php //include 'includes/qb_header_news_sitemap.php'; ?>
        </div-->
        <br/><br/>
        <div class="panel panel-primary" style="border: 0;">
            <div class="panel-body">
                <div class="news-list">
					<ul class="news">
                    <?php $newsCategory = $news->getNewsCategory(); 
					foreach($newsCategory as $id=>$value){ ?>
						<li><b><?php echo ucfirst($value); ?></b></li>
						<?php $list = $news->getSitemapNews($id,$countryID,$value);?>
							
                            <?php foreach($list as $newsItem) { ?>
                                    <li>
                                        <h3><a href="<?php echo $newsItem['url'] ?>" target="_blank"><?php echo $newsItem['title'] ?></a></h3>
                                    </li>
                            <?php } ?>
                           
					<?php }?>
					 </ul>
				  </div>	 
            </div>
        </div> 
    </div>
    <div class="col-md-2 nopadding"  style="float: right !important;">
        <?php include 'includes/news_right_panel.php'; ?>
    </div>
</div>
 <?php include 'includes/qb_footer.php';?>
 </div>
 <!--end wrapper div-->

</body>
</html>