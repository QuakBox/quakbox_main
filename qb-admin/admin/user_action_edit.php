<?php
session_start ();
include("config.php");
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_lookup.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
	$memberObject = new member1();
	$lookupObject = new lookup();
if (isset ( $_POST['submit'] )) {
	$member_id = $_POST['member_id'];
	
	
	
	/*$firstName= $memberObject-> update_member_meta($member_id,"first_name",$_POST["user_meta_first_name"]);
	$last_name=$memberObject-> update_member_meta($member_id,"last_name",$_POST["user_meta_last_name"]);
	$address=$memberObject->update_member_meta($member_id,"address",$_POST["user_meta_address"]);
	$country=$memberObject-> update_member_meta($member_id,"country",$_POST["country"]);
	$state=$memberObject-> update_member_meta($member_id,"state",$_POST["state"]);
	$city=$memberObject-> update_member_meta($member_id,"city",$_POST["city"]);
	$zip=$memberObject->update_member_meta($member_id,"zip",$_POST["user_meta_zip"]);
	//$gender= $memberObject->update_member_meta_for_lookupID($member_id,"Gender",$_POST["gender"]);
	$birthdate= $_POST["birthdate"];
	//$relationship=$memberObject->update_member_meta_for_lookupID($member_id,"relationship_status",$_POST["relationship_status"]);
	//$language=$memberObject->update_member_meta_for_lookupID($member_id,"language_known",$_POST["language_known"]);
	//$political_views=$memberObject->update_member_meta($member_id,"political_view",$_POST["political_view"]);
	//$political_views=$memberObject->update_member_meta_for_lookupID($member_id,"political_view");
	$displayName = $rows['displayname'];

	
	$mobile_no= $memberObject->update_member_meta($member_id,"phone_mobile",$_POST["user_meta_phone_mobile"]);
	$landline_no= $memberObject->update_member_meta($member_id,"phone_landline",$_POST["user_meta_phone_landline"]);	
	
	$curcity=$memberObject->update_member_meta($member_id,"current_city",$_POST["user_meta_current_city"]);
	$hometown=$memberObject->update_member_meta($member_id,"home_town",$_POST["user_meta_home_town"]);
	$website=$memberObject->update_member_meta($member_id,"website",$_POST["user_meta_website"]);
	$about_me =$memberObject->update_member_meta($member_id,"about_me",$_POST["user_meta_about_me"]);
	$ip =$memberObject->update_member_meta($member_id,"ip",$_POST["user_meta_ip"]);
	*/

	

	
	
	
	
	$uname = $_POST['uname'];
	$email = $_POST ['email'];
	$status = $_POST['status'];

  $updateUserQuery = "UPDATE `member` SET 
		`username`='$uname',
		`displayname`='$uname',
		`email`='$email',
		`status` = '$status'
		 WHERE member_id = '$member_id'";
  
  mysqli_query ( $conn,$updateUserQuery );
 // exit( $updateUserQuery );
  
  /// update user meta table 
  $userMeta = $_POST['user_meta'];
  //print_r( $userMeta );
  //exit;
  foreach( $userMeta as $meta_key => $meta_value ){
  	$memberObject-> update_member_meta($member_id, $meta_key, $meta_value );
  }
  
  // udpate eduction history
  $eductaionQuery = "UPDATE member_education_history SET education_organization='$education_organization', education_grade = '$education_grade', education_year_from = '$education_year_from', education_year_to = '$education_year_to' WHERE member_id='$member_id'";
  mysqli_query( $conn, $eductaionQuery);
  
  // 	$educationResult = $memberObject->select_member_Education_history($member_id);
  // 	$edures = mysqli_fetch_array($educationResult);
  // 	$organization_name = $edures['organization_name'];
  // 	$education_grade = $edures['education_grade'];
  // 	$education_grade = $lookupObject->getValueByKey($education_grade);
  // 	$education_year_from = $edures['education_year_from'];
  // 	$education_year_to = $edures['education_year_to'];  
  header ( "location:user_table.php" );
}
?>
