<?php
	//Start session
	ob_start();
	session_start();
	
	//Include database connection details
	require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_lookup.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
	$memberObject = new member1();
	$lookupObject = new lookup();
	
	//Array to store validation errors
	$errmsg_arr = array();
	
	//Validation error flag
	$errflag = false;
	
	
$member_id   = htmlspecialchars(trim($_SESSION['SESS_MEMBER_ID']));

if( isset($_POST['name']) && (trim($_POST['name']) != '') )
{
	$key = clean($_POST['name'],$con);
	$value = clean($_POST['value'],$con);
	$value	 = 	f($value, 'strip');
	$value	 = 	f($value, 'escapeAll'); 
	$value   = mysqli_real_escape_string($con, $value);
	$rs = '';

	$eductaionQuery = "UPDATE member_education_history SET $key='$value' WHERE member_id='$member_id'";
	$db_Obj = new database();	
	$rs = $db_Obj->execQuery($eductaionQuery);
	echo $rs;
}

 // udpate eduction history
 /* $eductaionQuery = "UPDATE member_education_history SET education_organization='$education_organization', education_grade = '$education_grade', education_year_from = '$education_year_from', education_year_to = '$education_year_to' WHERE member_id='$member_id'";
  mysqli_query( $conn, $eductaionQuery);

if(isset($_POST['company']))
{
	$company = clean($_POST['company'],$con);
	$company	 = 	f($company, 'strip');
	$company	 = 	f($company, 'escapeAll'); 
	$company   = mysqli_real_escape_string($con, $company);
	
	$checkCompany = $memberObject->select_member_meta_value_for_lookupID($member_id,"organization_name");
	if($checkCompany==null)
	{ $rscompany = $memberObject->insert_member_meta($member_id,"organization_name",$company);
	}else{
	$rscompany= $memberObject->update_member_meta($member_id,"organization_name",$company); 
	}
}
if(isset($_POST['education_grade']))
{
	$education_grade = clean($_POST['education_grade'],$con);
	$education_grade	 = 	f($education_grade, 'strip');
	$education_grade	 = 	f($education_grade, 'escapeAll'); 
	$education_grade   = mysqli_real_escape_string($con, $education_grade);
	
	$checkEducation_grade = $memberObject->select_member_meta_value_for_lookupID($member_id,"education_grade");
	if($checkEducation_grade==null)
	{ $rseducation_grade = $memberObject->insert_member_meta($member_id,"education_grade",$education_grade);
	}else{
	$rseducation_grade= $memberObject->update_member_meta($member_id,"education_grade",$education_grade); 
	}
}
if(isset($_POST['education_year_from']))
{
	$education_year_from = clean($_POST['education_year_from'],$con);
	$education_year_from	 = 	f($education_year_from, 'strip');
	$education_year_from	 = 	f($education_year_from, 'escapeAll'); 
	$education_year_from   = mysqli_real_escape_string($con, $education_year_from);
	
	$checkEducation_year_from = $memberObject->select_member_meta_value_for_lookupID($member_id,"education_year_from");
	if($checkEducation_year_from==null)
	{ $rseducation_year_from = $memberObject->insert_member_meta($member_id,"education_year_from",$education_year_from);
	}else{
	$rseducation_year_from= $memberObject->update_member_meta($member_id,"education_year_from",$education_year_from); 
	}
}
if(isset($_POST['education_year_to']))
{
	$education_year_to = clean($_POST['education_year_to'],$con);
	$education_year_to	 = 	f($education_year_to, 'strip');
	$education_year_to	 = 	f($education_year_to, 'escapeAll'); 
	$education_year_to   = mysqli_real_escape_string($con, $education_year_to);
	
	$checkEducation_year_to = $memberObject->select_member_meta_value_for_lookupID($member_id,"education_year_to");
	if($checkEducation_year_to==null)
	{ $rseducation_year_to = $memberObject->insert_member_meta($member_id,"education_year_to",$education_year_to);
	}else{
	$rseducation_year_to= $memberObject->update_member_meta($member_id,"education_year_to",$education_year_to); 
	}
}*/
		
	//Sanitize the POST values
	/*$session_uid = $_SESSION['SESS_MEMBER_ID'];
	$member_id = clean($_POST['member_id'],$con);
	$company = clean($_POST['company'],$con);
	$college = clean($_POST['college'],$con);
	$college_year = clean($_POST['college_year'],$con);
	$school = clean($_POST['school'],$con);
	$school_year = clean($_POST['school_year'],$con);	
	$designation = clean($_POST['designation'],$con);
	
	//Create Update query
	 $sql = "update members set company='$company', college='$college', college_year='$college_year',highschool='$school',school_year='$school_year',designation='$designation' where member_id = '$session_uid'";
	$result = mysqli_query($con, $sql) or die(mysqli_error($con));
	
	//Check whether the query was successful or not
	if($result) 
	{
	 $_SESSION['SESS_MEMBER_ID'] = $member_id;		
		header("location: ".$base_url."profile.php");
		exit();
	}*/
?>