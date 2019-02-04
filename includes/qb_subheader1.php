<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
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