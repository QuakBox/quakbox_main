<?php

 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php'); 	 
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');
        require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_misc.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_header.php');
	

$member_id = $_SESSION['SESS_MEMBER_ID'];

$objMisc = new misc();    
        
$CountriesResult=$objMisc->getallcountries();
$Countries='';
$counter=0;
foreach($CountriesResult as $valueCountries){
	$Countries .='<div class="col-sm-3 col-lg-2 col-xs-6" style="padding-bottom: 5px;">';
	$Countries .='<a href="'.SITE_URL.'/country/'.$valueCountries['code'].'" >';
	$Countries .='<img src="images/Flags/flags_new/195x120flags/'.strtolower($valueCountries['code']).'.png"'." title=" .$valueCountries["country_title"].' height="36" style="border:0px none; background: none repeat scroll 0% 0% transparent;" />';
	$Countries .='<span style="font-size:11px; white-space: nowrap;" class="filter-country-list-name">&nbsp;&nbsp;'.substr($valueCountries['country_title'],0,6).'</span>';
	$Countries .='</a>';
        $Countries .='</div>';
}

?>

<!-- Favorite Countries -->
	<div class="row">
		<div class="col-md-12">
			<form style="box-sizing: border-box; padding: 10px 10px 10px 20px;">
				<input class="form-control" type="text" id="filter_country_list" name="search" value="" placeholder="Filter by Name" autocomplete="off">
			</form>
		</div>
	</div>

	<script>
		jQuery(function($){
			var prevCountryName = "";
			$(document).on('keyup', "#filter_country_list", function(){
				var val = $.trim($(this).val()).toLowerCase();
				if(val == prevCountryName){
					return;
				}

				if(val == ""){
					// Show all
					$('.filter-country-list-name').each(function(){
						$(this).parent().parent().show();
					});
				} else {
					// Filter
					$('.filter-country-list-name').each(function(){
						if($(this).html().toLowerCase().indexOf(val) > -1){
							$(this).parent().parent().show();
						} else {
							$(this).parent().parent().hide();
						}
					});
				}

				prevCountryName = val;
			});
		});
	</script>
<br/>
<?php echo $Countries;?>


<?php include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_footer.php');?>