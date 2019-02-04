<?php  //Start session
	ob_start();
	session_start();
	
	//Include database connection details
	require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_lookup.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
	$memberObject = new member1();
	$lookupObject = new lookup();
	
	$member_id   = htmlspecialchars(trim($_SESSION['SESS_MEMBER_ID']));
	$location = "images/ImageGenderOther.png";
	$usernameRes = $memberObject->select_member_byID($member_id);
	foreach($usernameRes as $Result){
		$username =$Result['username'];			
	}
	$checkGender = $memberObject->select_member_meta_value_for_lookupID($member_id,"gender");
	if(strtolower($checkGender)=='male'){
	
	$location = "images/ImageGenderMale.png";
	
	}else if(strtolower($checkGender)=='female'){
	
	$location = "images/ImageGenderFemale.png";
	
	}
	
	$rsgender= $memberObject->update_member_meta($member_id,"current_profile_image",$location);
	
	header("location: ".$base_url."i/".$username);
	exit();
	

?>