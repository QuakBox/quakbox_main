<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_misc.php');


$logged_in_member_id_header1 = $_SESSION['SESS_MEMBER_ID'];
$objMemberHeader1 = new member1(); 
$objMisc = new misc();  


$randomCountriesResult=$objMisc->getRandom3countries();
$randomCountries='';
foreach($randomCountriesResult as $valueRandomCountries){
	//$flagURL=SITE_URL."/images/Flags/flags_new/30x20flags/".strtolower($valueRandomCountries['code']).".png";
	$randomCountries .='<a class="thumbnail headerflagthumbs" style="margin-right:3px;padding:0px;display:inline-block;margin-bottom:0px;" href="'.SITE_URL.'/country/'.$valueRandomCountries['code'].'" >';
	//$randomCountries .='<div class="flag_display" style=" ">';
	//$randomCountries .='<img src="'.$flagURL.'" title="'.$valueRandomCountries["country_title"].'" height="20" width="30" style="min-height:18px;"/>';
	$randomCountries .='<i class="sprite sprite-'.strtolower($valueRandomCountries['code']).'" style="min-height:10px;"></i>';
	$randomCountries .='<span style="font-size:9px;">'.substr($valueRandomCountries['country_title'],0,6).'</span>';
	//$randomCountries .='</div>';
	$randomCountries .='</a>';
	
}
$allCountriesResult=$objMisc->getallcountries();
$iMaxCols=6;
$rowscount = count($allCountriesResult);
$allCountries='';
//$allCountries .='<table style="width: 100%;">';
$allCountries .='<ul class="dropdown-menu scrollable-menu" role="menu" aria-labelledby="dropdownMenu1" style="background: #FFF none repeat scroll 0% 0%;">';
//$allCountries .='<li><form><input class="form-control"  type="text" name="search" value="" placeholder="'.$lang['search'].'" autocomplete="off"></form></li>';
foreach($allCountriesResult as $valueAllCountries){
	$country_name1 = str_replace(' ', '-', $valueAllCountries['country_title']);
	//$file = SITE_URL."/images/Flags/flags_new/50x50flags/".strtolower($valueAllCountries['code']).".png";
	$allCountries .='<li>';
	$allCountries .='<a href="'.SITE_URL.'/country/'.$valueAllCountries['code'].'" >';
	//if(file_exists($file)) {
	//   $allCountries .='<img src="'.$file.'" height="15" width="25"/>&nbsp;';
	//}
	$allCountries .='<i class="sprite sprite-'.strtolower($valueAllCountries['code']).'"></i>';
	$allCountries .='<label style="font-size: 14px; margin-top:4px; color:#000000;">'.$valueAllCountries["country_title"].'</label>';
	$allCountries .='</a>';
	$allCountries .='</li>';
	
}

$allCountries .='</ul>';

?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
    <head>
    	<meta charset="utf-8">
        <title>QuakBox</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="<?php echo SITE_URL ?>/images/favicon.ico" type="image" />
        <link rel="apple-touch-icon" href="<?php echo $base_url; ?>images/apple-touch-icon.png">
    <title>Quakbox</title>    
    <?php include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_style.php'); ?>
    <script src="<?php echo $base_url; ?>js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    <?php include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_script.php'); ?>
    
    
    
    
<style>
/* CSS for the user drop down list */
.navbar-login
{
    width: 305px;
    padding: 10px;
    padding-bottom: 0px;
}

.navbar-login-session
{
    padding: 10px;
    padding-bottom: 0px;
    padding-top: 0px;
}

.icon-size
{
    font-size: 87px;
}
</style>

    
</head>

<body>
<!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<?php if(isset($_COOKIE['lang'])){echo '<input type="hidden" name="locales" id="locales" value="'.$_COOKIE['lang'].'"/>'; }?>





<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
        	<a class="navbar-brand" href="#">
        	<img class="logo_img" style="display: inline-block;height:20px ;" src="<?php echo $base_url; ?>images/quakboxSmall.png"  alt="Image of QuakBox Logo" />
        	<span class="logoText hidden-xs" style="display: inline-block;">QuakBox</span>
        	</a>
          <button type="button" data-toggle="collapse" data-target=".navbarForCollapse" aria-expanded="false" aria-controls="navbar" class="navbar-toggle collapsed  btn-warning">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
          
          
          
     <ul class="nav navbar-nav right-navbar-nav ulHeader">    
     <li class="liHeader" style="padding-top: 2px;margin-top: 2px;padding-left: 2px; margin-left: 2px;">
        <?php echo $randomCountries ;?>
		
      </li>
      
      
      <li class="liHeader" style="padding-left: 2px; margin-left: 2px;">
          <div class="dropdown" style="text-align: center;">
		  <button class="btn btn-default dropdown-toggle connectbutton" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
		    <?php echo 'country';?>
		    <span class="caret"></span>
		  </button>
		  <?php echo $allCountries;?>
	</div>
      </li>
      
      
      <li class="liHeader" style="padding-left: 2px; margin-left: 2px;"> 
		<a href="<?php echo SITE_URL.'/';?>qcast.php" style="padding:0px;padding-left: 5px;">
			<img  style="height: 20px;width: 20px" src="<?php echo SITE_URL.'/';?>images/ButtonQcast.png" class="header-img"/>
			<div class="header-label" style="font-size: 11px;color:#fff;"><?php echo $lang['QCast'];?></div>
		</a>
      </li>
      </ul>

      

		     <?php include_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_subheader2.php'); 
		     ?>
		 
	
            
		   <?php include_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_subheader3.php'); 
		     ?>
		  
	 
          
        
	
	       
      </div>
    </nav>


<div>









    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <?php //if(isset($_COOKIE['lang'])){echo '<input type="hidden" name="locales" id="locales" value="'.$_COOKIE['lang'].'"/>'; }
        ?>

		