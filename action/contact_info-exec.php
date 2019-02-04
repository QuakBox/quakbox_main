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
	
	$result = $memberObject->select_multiple_member_meta_value($member_id, $key);

	if($result->num_rows == 0)
	{ 
		$rs = $memberObject->insert_member_meta($member_id,$key,$value);
	}else{
		$rs= $memberObject->update_member_meta($member_id,$key,$value);
	}
	echo $rs;
}

/*if(isset($_POST['landline_no']))
{
	$landline_no = clean($_POST['landline_no'],$con);
	$landline_no	 = 	f($landline_no, 'strip');
	$landline_no	 = 	f($landline_no, 'escapeAll'); 
	$landline_no   = mysqli_real_escape_string($con, $landline_no);
	
	$checkLandlineNo = $memberObject->select_member_meta_value_for_lookupID($member_id,"phone_landline");
	if($checkLandlineNo==null)
	{ $rslandline_no = $memberObject->insert_member_meta($member_id,"phone_landline",$landline_no);
	}else{
	$rslandline_no= $memberObject->update_member_meta($member_id,"phone_landline",$landline_no); 
	}
}
if(isset($_POST['current_city']))
{
	$current_city = clean($_POST['current_city'],$con);
	$current_city	 = 	f($current_city, 'strip');
	$current_city	 = 	f($current_city, 'escapeAll'); 
	$current_city   = mysqli_real_escape_string($con, $current_city);
	
	$checkCurrent_city = $memberObject->select_member_meta_value_for_lookupID($member_id,"current_city");
	if($checkCurrent_city==null)
	{ $rscurrent_city = $memberObject->insert_member_meta($member_id,"current_city",$current_city);
	}else{
	$rscurrent_city= $memberObject->update_member_meta($member_id,"current_city",$current_city); 
	}
}
if(isset($_POST['hometown']))
{
	$hometown = clean($_POST['hometown'],$con);
	$hometown	 = 	f($hometown, 'strip');
	$hometown	 = 	f($hometown, 'escapeAll'); 
	$hometown   = mysqli_real_escape_string($con, $hometown);
	
	$checkHometown = $memberObject->select_member_meta_value_for_lookupID($member_id,"home_town");
	if($checkHometown==null)
	{ $rshometown = $memberObject->insert_member_meta($member_id,"home_town",$hometown);
	}else{
	$rshometown = $memberObject->update_member_meta($member_id,"home_town",$hometown); 
	}
}
if(isset($_POST['website']))
{
	$website = clean($_POST['website'],$con);
	$website	 = 	f($website, 'strip');
	$website	 = 	f($website, 'escapeAll'); 
	$website   = mysqli_real_escape_string($con, $website);
	
	$checkWebsite = $memberObject->select_member_meta_value_for_lookupID($member_id,"website");
	if($checkWebsite==null)
	{ $rswebsite = $memberObject->insert_member_meta($member_id,"website",$website);
	}else{
	$rswebsite = $memberObject->update_member_meta($member_id,"website",$website); 
	}
}
if(isset($_POST['address']))
{
	$address = clean($_POST['address'],$con);
	$address	 = 	f($address, 'strip');
	$address	 = 	f($address, 'escapeAll'); 
	$address   = mysqli_real_escape_string($con, $address);
	
	$checkAddress = $memberObject->select_member_meta_value_for_lookupID($member_id,"address");
	if($checkAddress==null)
	{ $rsaddress = $memberObject->insert_member_meta($member_id,"address",$address);
	}else{
	$rsaddress = $memberObject->update_member_meta($member_id,"address",$address); 
	}
}*/
		
	//Sanitize the POST values
/*	$member_id = clean($_POST['member_id'], $con);
	$email_id = clean($_POST['email_id'], $con);
	$mobile_no = clean($_POST['mobile_no'], $con);
	$landline_no = clean($_POST['landline_no'], $con);
	$address = clean($_POST['address'], $con);
	$country = clean($_POST['country'], $con);	
	$state = clean($_POST['state'], $con);
	$city = clean($_POST['city'], $con);
	$zip = clean($_POST['zip'], $con);
	

	//Create Update query
	 $sql = "update members set email_id='$email_id', mobile_no='$mobile_no', landline_no='$landline_no',address='$address',country='$country',state='$state',city='$city',zip='$zip' where member_id = '$member_id'";
	$result = mysqli_query($con, $sql) or die(mysqli_error($con));
	
	//Check whether the query was successful or not
	if($result) 
	{
	 $_SESSION['SESS_MEMBER_ID'] = $member_id;		
		header("location: ".$base_url."profile.php");
		exit();
	}*/
?>