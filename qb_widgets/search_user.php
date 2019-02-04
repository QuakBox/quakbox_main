<?php 

if(isset($_POST['searchtext'])){
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');

$objMemberSearch = new member1(); 
$searchtext=$_POST['searchtext'];
$memeberID=$_POST['memeberID'];

$searchResult=$objMemberSearch->searchUser($searchtext,$memeberID);
$innerContent='';
foreach($searchResult as $valuesearch){	
	$searchedMemberID=$valuesearch['member_id'];
	$searchedMemberDisplayName=$valuesearch['displayname'];
	$searchedMemberUserName=$valuesearch['username'];
	$searchedMemberResultProfileLogo=$objMemberSearch->select_member_meta_value($searchedMemberID,'current_profile_image');
	if($searchedMemberResultProfileLogo){			
		$searchedMemberResultProfileLogo=SITE_URL.'/'.$searchedMemberResultProfileLogo;	
	}
	else{
		$searchedMemberResultProfileLogo=SITE_URL.'/images/default.png';
	}
	$innerContent .='<div class="clearfix"><a   href="'.SITE_URL.'/'.$searchedMemberUserName .'" title="'.$searchedMemberDisplayName.'">';
	$innerContent .='<div class="display_box">';
	$innerContent .='<div class="pull-left"><img src="'.$searchedMemberResultProfileLogo.'" style="width:50px; height:50px; float:left; margin-right:2px;border:1px solid #ccc;padding:2px;margin-bottom:2px;" /></div>';
	$innerContent .='<div class="pull-left"><div class="name1" style="padding: 10px;">'. ucwords( $searchedMemberUserName ) .'</div></div>';
	$innerContent .='<div class="clearfix"></div>';
	$innerContent .='</div></a></div>'; 

}

if($innerContent==''){
	 $innerContent .='<div>No results</div>';
}
else{
	 $innerContent .='<div><a id="search-all" href="'.SITE_URL.'/search.php?q='.$searchtext.'">Show all results</a></div>';
}
print $innerContent;

}
else{
	print "Error";
}