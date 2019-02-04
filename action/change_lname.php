<?php
	//Start session
	ob_start();
	session_start();
	
	//Include database connection details
	require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
	$memberObject = new member1();
	
	//Array to store validation errors
	$errmsg_arr = array();
	
	//Validation error flag
	$errflag = false;
	
	$member_id   = htmlspecialchars(trim($_SESSION['SESS_MEMBER_ID']));

	$name = clean($_POST['name'], $con);

	
	$value = clean($_POST['value'], $con);
	$value	 = 	f($value, 'strip');
	$value	 = 	f($value, 'escapeAll'); 
	$value   = mysqli_real_escape_string($con, $value);
	
	$checkValue = $memberObject->select_member_meta_value($member_id,"last_name");
	if($name=='l_member_name' && $value != ''){
	
		if($checkValue ==null)
		{
		$memberResult = $memberObject->insert_member_meta($member_id,"last_name",$value);
		}
		else
		{
		$memberResult = $memberObject->update_member_meta($member_id,"last_name",$value); 
		}
	}
	
	
	
	//Check whether the query was successful or not
$url = '';
if(strpos($_SERVER['HTTP_REFERER'], "?") == null)
	$url = $_SERVER['HTTP_REFERER'];
else
	$url = substr($_SERVER['HTTP_REFERER'], 0, strpos($_SERVER['HTTP_REFERER'], "?"));
	
//echo $url;
header("location: ".$url."?err=".mysqli_error($con));
exit();
?>