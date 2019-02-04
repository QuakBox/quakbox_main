<?php ob_start();
session_start();
include_once('../config.php');

   
 $typeofadd = $_POST['typeofadd']; 
 $typeofadd	 = 	f($typeofadd, 'strip');
$typeofadd	 = 	f($typeofadd, 'escapeAll');
$typeofadd   = mysqli_real_escape_string($con, $typeofadd);
 	
 $http =  $_POST['http'].$_POST['url']; 
 $http	 = 	f($http, 'strip');
$http	 = 	f($http, 'escapeAll');
$http	 = 	f($http, 'url');
$http   = mysqli_real_escape_string($con, $http);


 $title =  mysqli_real_escape_string($con, $_POST['title']);
$title	 = 	f($title, 'escapeAll');
$title   = mysqli_real_escape_string($con, $title);

 $description =  mysqli_real_escape_string($con, $_POST['description']);
$description	 = 	f($description, 'escapeAll');
$description   = mysqli_real_escape_string($con, $description);

 $choice = implode(",",$_POST['gender']);
 $choice	 = 	f($choice, 'strip');
$choice	 = 	f($choice, 'escapeAll');
$choice   = mysqli_real_escape_string($con, $choice);

 
 $mobile_from =  trim($_POST['mobile_from']); 
 $mobile_from	 = 	f($mobile_from, 'strip');
$mobile_from	 = 	f($mobile_from, 'escapeAll');
$mobile_from   = mysqli_real_escape_string($con, $mobile_from);

 $mobile_to =  trim($_POST['mobile_to']);  
 $mobile_to	 = 	f($mobile_to, 'strip');
$mobile_to	 = 	f($mobile_to, 'escapeAll');
$mobile_to   = mysqli_real_escape_string($con, $mobile_to);

 
 $countries =  trim($_POST['countries']);
 $countries	 = 	f($countries, 'strip');
$countries	 = 	f($countries, 'escapeAll');
$countries   = mysqli_real_escape_string($con, $countries);

 $state =  trim($_POST['state']);
 $state	 = 	f($state, 'strip');
$state	 = 	f($state, 'escapeAll');
$state   = mysqli_real_escape_string($con, $state);

 $city =  trim($_POST['city']);
 $city	 = 	f($city, 'strip');
$city	 = 	f($city, 'escapeAll');
$city   = mysqli_real_escape_string($con, $city);

 
 $dob =  trim($_POST['dob']);
 $dob	 = 	f($dob, 'strip');
$dob	 = 	f($dob, 'escapeAll');
$dob   = mysqli_real_escape_string($con, $dob);

 $address =  trim($_POST['address']);
 $address	 = 	f($address, 'strip');
$address	 = 	f($address, 'escapeAll');
$address   = mysqli_real_escape_string($con, $address);

 $graduation_year =  trim($_POST['graduation_year']);
 $graduation_year	 = 	f($graduation_year, 'strip');
$graduation_year	 = 	f($graduation_year, 'escapeAll');
$graduation_year   = mysqli_real_escape_string($con, $graduation_year);

 
 $per =  trim($_POST['per']);
 $per	 = 	f($per, 'strip');
$per	 = 	f($per, 'escapeAll');
$per   = mysqli_real_escape_string($con, $per);

 $click_payment =  trim($_POST['click_payment']);
 $click_payment	 = 	f($click_payment, 'strip');
$click_payment	 = 	f($click_payment, 'escapeAll');
$click_payment   = mysqli_real_escape_string($con, $click_payment);

 $paypal =  trim($_POST['paypal']);
 $paypal	 = 	f($paypal, 'strip');
$paypal	 = 	f($paypal, 'escapeAll');
$paypal   = mysqli_real_escape_string($con, $paypal);
 
 $image_url = $_SESSION['actual_image_name'];

 $member_id = $_POST['member_id'];
  $member_id	 = 	f($member_id, 'strip');
$member_id	 = 	f($member_id, 'escapeAll');
$member_id   = mysqli_real_escape_string($con, $member_id);

	$sql = "INSERT INTO ads (ad_creator,`typeofadd`,`url`,`ads_title`,ads_pic,`ads_content`,`targetmob`,
			`targetgender`,`targetstate`,`targetcity`,`targetdob`,`targetadd`,`targetgrad`,
			`pricingperclick`,`pricingbuy`,`pricinggateway`,`targetcountry`) 
			values('$member_id','".$typeofadd."','".$http."','". $title ."','".$image_url."','".$description."',
			'".$mobile_from."','".$choice."','".$state."','".$city."','".$dob."','".$address."','".$graduation_year."','".$per."',
			'".$click_payment."','".$paypal."','".$countries."')";
    
	$result = mysqli_query($con, $sql) or die(mysqli_error($con));
	
	header("location: ".$base_url."add_ads.php");
	exit();

	
?>