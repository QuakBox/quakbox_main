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
	
	$member = mysqli_query($con,"select * from members where member_id = '$member_id'");
	$member_res = mysqli_fetch_array($member);
	$sql = mysqli_query($con,"select * from geo_country where country_title='".$country_code."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);
	$country_id = $res['country_id'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $res['country_title'];?></title>
<head>
<?php include('includes/files.php');?>
<link rel="stylesheet" type="text/css" href="css/news_feed.css" /> 
<link rel="stylesheet" type="text/css" href="css/slider.css" />
	<script type="text/javascript" src="js/jquery-1.2.6.min.js"></script>
	<script type="text/javascript" src="js/jquery-easing-1.3.pack.js"></script>
	<script type="text/javascript" src="js/jquery-easing-compatibility.1.2.pack.js"></script>
	<script type="text/javascript" src="js/coda-slider.1.1.1.pack.js"></script>
</head>
<body>
<div id="wrapper">
<?php 
include('includes/header.php');
include('news_header.php');
?>

<div style="margin:0px auto; width:1300px;">
<!--news feed for country-->
<div style="width:300px; min-height:500px; float:left; margin-left:10px;">

<?php include_once 'news_feed.php';?>

<!--end div news feed-->


</div>


<!--end news feed for country-->
<div style="display:inline; float:right;">

<div id="mainbody" >

<div class="column_left" style="border-left:1px solid #ccc">
    
<div class="column_internal_left" style="padding:10px;">

<div class="gmod headlines">
<h2><a href="news_category.php?country=<?php echo $country_code;?>&category=entertainment">Entertainment</a></h2>
<ul class="news-headlines">
<?php 
$xml = ("http://globalvoicesonline.org/-/topics/film/feed/");

$xmlDoc = new DOMDocument();
$xmlDoc->load($xml);


//get and output "<item>" elements
$x=$xmlDoc->getElementsByTagName('item');

for ($i=0; $i<=5; $i++)
{	  
  $item_title=$x->item($i)->getElementsByTagName('title')
  ->item(0)->childNodes->item(0)->nodeValue;
  $item_link=$x->item($i)->getElementsByTagName('link')
  ->item(0)->childNodes->item(0)->nodeValue;
  $item_desc=$x->item($i)->getElementsByTagName('description')
  ->item(0)->childNodes->item(0)->nodeValue; 
  
?>
<li><a href="<?php echo $item_link;?>" target="_blank"><?php echo $item_title;?></a></li>
<?php } ?>
</ul>
<a href="news_category.php?country=<?php echo $country_code;?>&category=entertainment">More..</a>
</div>

<div class="gmod headlines">
<h2><a href="news_category.php?country=<?php echo $country_code;?>&category=politics">Politics</a></h2>
<ul class="news-headlines">
<?php 
$xml = ("http://globalvoicesonline.org/-/topics/politics/feed/");

$xmlDoc = new DOMDocument();
$xmlDoc->load($xml);


//get and output "<item>" elements
$x=$xmlDoc->getElementsByTagName('item');

for ($i=0; $i<=5; $i++)
{	  
  $item_title=$x->item($i)->getElementsByTagName('title')
  ->item(0)->childNodes->item(0)->nodeValue;
  $item_link=$x->item($i)->getElementsByTagName('link')
  ->item(0)->childNodes->item(0)->nodeValue;
  $item_desc=$x->item($i)->getElementsByTagName('description')
  ->item(0)->childNodes->item(0)->nodeValue; 
  
?>
<li><a href="<?php echo $item_link;?>" target="_blank"><?php echo $item_title;?></a></li>
<?php } ?>
</ul>
<a href="news_category.php?country=<?php echo $country_code;?>&category=politics">More..</a>
</div>

<div class="gmod headlines">
<h2><a href="news_category.php?country=<?php echo $country_code;?>&category=sports">Sports</a></h2>
<ul class="news-headlines">
<?php 
$xml = ("http://globalvoicesonline.org/-/topics/sport/feed/");

$xmlDoc = new DOMDocument();
$xmlDoc->load($xml);


//get and output "<item>" elements
$x=$xmlDoc->getElementsByTagName('item');

for ($i=0; $i<=5; $i++)
{	  
  $item_title=$x->item($i)->getElementsByTagName('title')
  ->item(0)->childNodes->item(0)->nodeValue;
  $item_link=$x->item($i)->getElementsByTagName('link')
  ->item(0)->childNodes->item(0)->nodeValue;
  $item_desc=$x->item($i)->getElementsByTagName('description')
  ->item(0)->childNodes->item(0)->nodeValue; 
  
?>
<li><a href="<?php echo $item_link;?>" target="_blank"><?php echo $item_title;?></a></li>
<?php } ?>
</ul>
<a href="news_category.php?country=<?php echo $country_code;?>&category=sports">More..</a>
</div>

<div class="gmod headlines">
<h2><a href="news_category.php?country=<?php echo $country_code;?>&category=health">Health</a></h2>
<ul class="news-headlines">
<?php 
$xml = ("http://globalvoicesonline.org/-/topics/health/feed/");

$xmlDoc = new DOMDocument();
$xmlDoc->load($xml);


//get and output "<item>" elements
$x=$xmlDoc->getElementsByTagName('item');

for ($i=0; $i<=5; $i++)
{	  
  $item_title=$x->item($i)->getElementsByTagName('title')
  ->item(0)->childNodes->item(0)->nodeValue;
  $item_link=$x->item($i)->getElementsByTagName('link')
  ->item(0)->childNodes->item(0)->nodeValue;
  $item_desc=$x->item($i)->getElementsByTagName('description')
  ->item(0)->childNodes->item(0)->nodeValue; 
  
?>
<li><a href="<?php echo $item_link;?>" target="_blank"><?php echo $item_title;?></a></li>
<?php } ?>
</ul>
<a href="news_category.php?country=<?php echo $country_code;?>&category=health">More..</a>
</div>
	
<div class="gmod headlines">
<h2><a href="news_category.php?country=<?php echo $country_code;?>&category=bussiness">Bussiness</a></h2>
<ul class="news-headlines">
<?php 
$xml = ("http://globalvoicesonline.org/-/topics/economics-business/feed/");

$xmlDoc = new DOMDocument();
$xmlDoc->load($xml);


//get and output "<item>" elements
$x=$xmlDoc->getElementsByTagName('item');

for ($i=0; $i<=5; $i++)
{	  
  $item_title=$x->item($i)->getElementsByTagName('title')
  ->item(0)->childNodes->item(0)->nodeValue;
  $item_link=$x->item($i)->getElementsByTagName('link')
  ->item(0)->childNodes->item(0)->nodeValue;
  $item_desc=$x->item($i)->getElementsByTagName('description')
  ->item(0)->childNodes->item(0)->nodeValue; 
  
?>
<li><a href="<?php echo $item_link;?>" target="_blank"><?php echo $item_title;?></a></li>
<?php } ?>
</ul>
<a href="news_category.php?country=<?php echo $country_code;?>&category=bussiness">More..</a>
</div>

    
</div><!--end column internal-left -->

<?php include_once 'ads_column.php';?>

</div><!--End column left-->

<div class="column_right" >
	
    <div class="moduletable">
   
    
	<img alt='<?php echo strtoupper($res['country_title']);?>' src=<?php  echo "images/Flags/flags_new/flags".strtolower($res['code']).".png";?>  
    style="margin-top: 10px;margin-left: 5px;width: 150px;padding-left: 13px;"/>
	
	
   <div align="center" style="font-size:14px; font-weight:bold; color:#00C;"><?php echo strtoupper($res['country_title']);?></div>
   <div style="border-bottom: 1px solid #ecebeb;margin: 4px 7px;padding: 0 0 10px;"></div>
   </div>
    
    
    
    
	
</div><!--End column right-->

</div><!--end mainbody div-->
 </div>
 </div>
 <?php include 'includes/footer.php';?>
 </div><!--end wrapper div-->
 
<script type="text/javascript" src="js/wowslider.js"></script>
	<script type="text/javascript" src="js/sliderscript.js"></script>
</body>
</html>