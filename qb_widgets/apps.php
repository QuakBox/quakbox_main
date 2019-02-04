<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_apps.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
class appsWidget
{

function getApps(){

	return '';

	$objApps = new apps(); 
	$appResult=$objApps->view_apps();
	

	
	$innerhtml ='<div class="panel panel-info">';
	$innerhtml .='<div class="panel-heading" style="padding-top: 1px; padding-bottom: 1px;">';
	$innerhtml .='<a href="'.SITE_URL.'/app.php">Apps</a></div>';
	
	$innerhtml .='<div class="panel-body">';
	foreach($appResult as $column => $value) {
		$innerhtml .='<div style="font-size: 10px; height: 100px;" class="pull-left col-lg-6 ">';
			$innerhtml .='<a href="'.SITE_URL.'/app1.php?code='.$value['id'].'" style="text-overflow: ellipsis;" >';
				$innerhtml .='<img src="'.SITE_URL.'/'.$value['image'].'"  class="img-rounded" style="width: 100%; margin: 5px 0px;" />';
				$innerhtml .='<div>'.$value['name'].'</div>';
			$innerhtml .='</a>';
		$innerhtml .='</div>';
	} 
	
	//$innerhtml .='<div class="clearfix"></div>';
	$innerhtml .='</div>';
	$innerhtml .='</div>';
	//$innerhtml .='<div class="bg-primary clearfix" style="padding: 5px;background-color: #C0C0C0;background-image: none;background-repeat: repeat-x;">';
	
	
	return $innerhtml;

}










}

?>