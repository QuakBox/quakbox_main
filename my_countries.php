<?php

 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php'); 	 
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');
        require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_misc.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_header.php');
	

$member_id = $_SESSION['SESS_MEMBER_ID'];

$objMisc = new misc();    
        
$favarioteCountriesResult=$objMisc->getFavCountry($member_id);
$favCountries='';
foreach($favarioteCountriesResult as $valueFavCountries){
	$favCountries .='<div class="col-sm-4 col-xs-4">';
	$favCountries .='<a href="'.SITE_URL.'/country/'.$valueFavCountries['code'].'" >';
	$favCountries .='<img src="images/Flags/flags_new/195x120flags/'.strtolower($valueFavCountries['code']).'.png"'." title=" .$valueFavCountries["country_title"].' height="36" style="border:0px none; background: none repeat scroll 0% 0% transparent;" />';
	$favCountries .='<font style="font-size:10px;">'.substr($valueFavCountries['country_title'],0,6).'</font>';
	$favCountries .='</a>';
        $favCountries .='</div>';
}

?>

<!-- Favorite Countries -->							
<br/>
<?php echo $favCountries;?>

<br/><br/><br/><br/><br/><br/>
<!-- Manage favorite countries -->
<a href="/create_country.php" class="btn btn-primary"style="padding: 5px;">Edit favorite countries</a>
	
<?php include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_footer.php');?>