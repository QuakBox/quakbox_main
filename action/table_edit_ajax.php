<?php session_start();
require_once('../config.php');
$id = $_SESSION['SESS_MEMBER_ID'];
	if(isset($_POST['gender']))
	{
$gender=f($_POST['gender'],'escapeAll');
echo $gender=mysqli_real_escape_String($con, $gender);
$birthdate=f($_POST['birthdate'],'escapeAll');
echo $birthdate=mysqli_real_escape_String($con, $birthdate);
$interested=f($_POST['interested'],'escapeAll');
echo $interested=mysqli_real_escape_String($con, $interested);
$relationship=f($_POST['relationship'],'escapeAll');
echo $relationship=mysqli_real_escape_String($con, $relationship);
$language=f($_POST['language'],'escapeAll');
echo $language=mysqli_real_escape_String($con, $language);
$religion=f($_POST['religion'],'escapeAll');
echo $religion=mysqli_real_escape_String($con, $religion);
$political_views=f($_POST['political_views'],'escapeAll');
echo $political_views=mysqli_real_escape_String($con, $political_views);


$sql = "update members set gender='$gender',birthdate='$birthdate',interested='$interested',relationship='$relationship',language='$language',religion='$religion',political_views='$political_views' where member_id='$id'";
mysqli_query($con, $sql) or die(mysqli_error($con));
}
else if(isset($_POST['email_id']))
	{

$email_id=f($_POST['email_id'],'escapeAll');
echo $email_id=mysqli_real_escape_String($con, $email_id);
$mobile_no=f($_POST['mobile_no'],'escapeAll');
echo $mobile_no=mysqli_real_escape_String($con, $mobile_no);
$landline_no=f($_POST['landline_no'],'escapeAll');
echo $landline_no=mysqli_real_escape_String($con, $landline_no);
$address=f($_POST['address'],'escapeAll');
echo $address=mysqli_real_escape_String($con, $address);
$country_title=f($_POST['country_title'],'escapeAll');
echo $country_title=mysqli_real_escape_String($con, $country_title);
$state_title=f($_POST['state_title'],'escapeAll');
echo $state_title=mysqli_real_escape_String($con, $state_title);
$city_title=f($_POST['city_title'],'escapeAll');
echo $city_title=mysqli_real_escape_String($con, $city_title);
$zip=f($_POST['zip'],'escapeAll');
echo $zip=mysqli_real_escape_String($con, $zip);


$sql = "update members set email_id='$email_id',mobile_no='$mobile_no',landline_no='$landline_no',address='$address',country='$country_title',state='$state_title',city='$city_title',zip='$zip' where member_id='$id'";
mysqli_query($con,$sql) or die(mysqli_error($con));
}


else if(isset($_POST['company']))
	{

$company=f($_POST['company'],'escapeAll');
echo $company=mysqli_real_escape_String($con, $company);
$designation=f($_POST['designation'],'escapeAll');
echo $designation=mysqli_real_escape_String($con, $designation);
$college=f($_POST['college'],'escapeAll');
echo $college=mysqli_real_escape_String($con, $college);
$college_year=f($_POST['college_year'],'escapeAll');
echo $college_year=mysqli_real_escape_String($con, $college_year);
$highschool=f($_POST['highschool'],'escapeAll');
echo $highschool=mysqli_real_escape_String($con, $highschool);
$school_year=f($_POST['school_year'],'escapeAll');
echo $school_year=mysqli_real_escape_String($con, $school_year);

$sql = "update members set company='$company',designation='$designation',college='$college',college_year='$college_year',highschool='$highschool',school_year='$school_year' where member_id='$id'";
mysqli_query($con, $sql) or die(mysqli_error($con));
}

 

else if(isset($_POST['country']))
	{

$country=f($_POST['country'],'escapeAll');
echo $country=mysqli_real_escape_String($con, $country);
$origion_country=f($_POST['origion_country'],'escapeAll');
echo $origion_country=mysqli_real_escape_String($con, $origion_country);


$sql = "update members set country='$country',origion_country='$origion_country' where member_id='$id'";
mysqli_query($con, $sql) or die(mysqli_error($con));
}

?>
