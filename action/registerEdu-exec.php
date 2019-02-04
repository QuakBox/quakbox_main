<?php ob_start();
	//Start session
	session_start();
	
	//Include database connection details
		require_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_log.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_registration_class.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_lookup.php');
	$lookupObject = new lookup();
	$RegistrationObject = new registration();
	//Array to store validation errors
	$errmsg_arr = array();
	
	//Validation error flag
	$errflag = false;
	
	//Sanitize the POST values	
	$organizationType = 0;
	$member_id = $_SESSION['SESS_MEMBER_ID'];
	$clg = clean($_POST['clg'], $con);
	$education_grade = clean($_POST['education_grade'], $con);
	$starting_year = clean($_POST['starting_year'], $con);
	$ps_year = clean($_POST['ps_year'], $con);
	$country = clean($_POST['country'], $con);
	$state = clean($_POST['state'], $con);
	$city = clean($_POST['city'], $con);
	if($education_grade!=0)
	{
	$schoolCheck = $lookupObject->getValueByKey($education_grade);
	$schoolCheck = strtolower($schoolCheck);
	if($schoolCheck == "high school")
	{
	$organizationType = $lookupObject->getKeyByValue("School");	
	}
	else
	{
	$organizationType = $lookupObject->getKeyByValue("College");
	}
        
        $education_organization = $RegistrationObject->insert_country_education_record($country,$state,$city,$clg,$organizationType);
        
        $rs = $RegistrationObject->insert_member_education_record($member_id,$education_organization,$education_grade,$starting_year,$ps_year);
        
        if($rs) 
	{
	 	$RegistrationObject->skipChekPoints($member_id, 'Education Information');
	 	$_SESSION['SESS_MEMBER_ID'] = $member_id;		
		header("location: ".$base_url."registerSuccess.php");
		exit();
	}
	else
	{die("query failed");}
        }
	else
	{
	$RegistrationObject->skipChekPoints($member_id, 'Education Information');
	header("location: ".$base_url."registerSuccess.php");
	exit();
	}
	//Create Update query
	/*$sql = "update members set college='$clg', college_year='$gd_year', highschool='$school', school_year='$ps_year' where member_id = '$member_id'";
	$result = mysqli_query($con, $sql) or die(mysqli_error($con));
	
	//Check whether the query was successful or not
	if($result) 
	{
	 $_SESSION['SESS_MEMBER_ID'] = $member_id;		
		header("location: ".$base_url."registerSuccess.php");
		exit();
	}*/
?>