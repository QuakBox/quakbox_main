<?php ob_start();
	//Start session
	session_start();
	
	//Include database connection details
	require_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_registration_class.php');
	//Array to store validation errors
	$errmsg_arr = array();
	
	//Validation error flag
	$errflag = false;
	$object = new registration();	
	//Sanitize the POST values
	$member_id = $_SESSION['SESS_MEMBER_ID'];
	$mobile_no = clean($_POST['mobile_no'], $con);
	$landline_no = clean($_POST['landline_no'], $con);	
	$address = clean($_POST['address'], $con);	
	$country = clean($_POST['country'], $con);	
	$state = clean($_POST['state'], $con);
	$city = clean($_POST['city'], $con);
	$current_city = clean($_POST['current_city'], $con);
	$hometown = clean($_POST['hometown'], $con);
	$website = clean($_POST['website'], $con);	
	
		
$rs = $object->insert_member_meta($member_id,"phone_mobile",$mobile_no);
$rs1 = $object->insert_member_meta($member_id,"phone_landline",$landline_no);
$rs2 = $object->insert_member_meta($member_id,"address",$address);
$rs3 = $object->insert_member_meta($member_id,"country",$country);
$rs4 = $object->insert_member_meta($member_id,"state",$state);
$rs5 = $object->insert_member_meta($member_id,"city",$city);
$rs6 = $object->insert_member_meta($member_id,"current_city",$current_city);
$rs7 = $object->insert_member_meta($member_id,"home_town",$hometown);
$rs8 = $object->insert_member_meta($member_id,"website",$website);
//Check whether the query was successful or not
if($rs8)
{
$object-> skipChekPoints($member_id, 'Contact Information');
header("location: ".$base_url."registerEdu.php");
exit();
}

	/*
	$sql_country="select * from geo_country where country_id=$country";
	$st_country=mysqli_query($sql_country);
	while($row=mysqli_fetch_array($st_country))
	{
		$countrynm=$row['country_title'];
	}
	
	$sql_state="select * from geo_state where state_id=$state";
	$st_state=mysqli_query($sql_state);
	while($row=mysqli_fetch_array($st_state))
	{
		$statenm=$row['state_title'];
	}
	
	$sql_city="select * from geo_city where city_id=$city ";
	$st_city=mysqli_query($sql_city);
	while($row=mysqli_fetch_array($st_city))
	{
		$citynm=$row['city_title'];
	}*/

	//Create Update query
	/*$sql = "update members set 
	mobile_no='$mobile_no',  
	landline_no='$landline_no',	
	country='$country', 
	state='$state', 
	city='$city',
	website='$website',
	curcity = '$current_city',
	hometown = '$hometown' 
	 where member_id = '$member_id'";
	$result = mysqli_query($con, $sql) or die(mysqli_error($con));
	
	//Check whether the query was successful or not
	if($result) 
	{
	 $_SESSION['SESS_MEMBER_ID'] = $member_id;		
		header("location: ".$base_url."registerEdu.php");
		exit();
	}*/
?>