<?php
//Start session
ob_start();
session_start();

//Include database connection details
require_once($_SERVER['DOCUMENT_ROOT'] . '/common/common.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/qb_classes/qb_lookup.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/qb_classes/qb_member1.php');
$memberObject = new member1();
$lookupObject = new lookup();

//Array to store validation errors
$errmsg_arr = array();

//Validation error flag
$errflag = false;


$member_id = htmlspecialchars(trim($_SESSION['SESS_MEMBER_ID']));


if (isset($_POST['name']) && (trim($_POST['name']) == 'birthDay')) {
    $dob = $_POST['value'];
    $rsdob = $memberObject->update_member_dob($member_id, $dob);
    echo $rsdob;
} else if (isset($_POST['name']) && (trim($_POST['name']) == 'email')) {
    $email = clean($_POST['email'], $con);
    $email = f($email, 'strip');
    $email = f($email, 'escapeAll');
    $email = mysqli_real_escape_string($con, $email);

    /*$checkemail = $memberObject->select_member_meta_value_for_lookupID($member_id,"political_view");
   if($checkemail ==null)
   { $rsemail = $memberObject->insert_member_meta($member_id,"political_view",$email);
   }else{*/

    $rsemail = $memberObject->update_member_columns($memberID, "email", $value);
//}
} else if (isset($_POST['name']) && (trim($_POST['name']) != '')) {
    $key = clean($_POST['name'], $con);
    $value = clean($_POST['value'], $con);
    $value = f($value, 'strip');
    $value = f($value, 'escapeAll');
    $value = mysqli_real_escape_string($con, $value);
    $rs = '';

    $checkKey = $memberObject->select_member_meta_value_for_lookupID($member_id, $key);
    if ($checkKey == null) {
        $rs = $memberObject->insert_member_meta($member_id, $key, $value);
    } else {
        $rs = $memberObject->update_member_meta($member_id, $key, $value);
    }
    echo $rs;
}


/*if(isset($_POST['relationship']))
{
$relationship = clean($_POST['relationship'],$con);
	$relationship	 = 	f($relationship, 'strip');
$relationship	 = f($relationship, 'escapeAll'); 
$relationship   = mysqli_real_escape_string($con, $relationship);

 $checkRelationship = $memberObject->select_member_meta_value_for_lookupID($member_id,"relationship_status");
if($checkRelationship ==null)
{ $rsRelationship = $memberObject->insert_member_meta($member_id,"relationship_status",$relationship);
}else{
$rsRelationship= $memberObject->update_member_meta($member_id,"relationship_status",$relationship); 
}
}

if(isset($_POST['language']))
{
$language = clean($_POST['language'],$con);
	$language	 = 	f($language, 'strip');
$language	 = f($language, 'escapeAll'); 
$language   = mysqli_real_escape_string($con, $language);

 $checklanguage = $memberObject->select_member_meta_value_for_lookupID($member_id,"language_known");
if($checklanguage ==null)
{ $rslanguage = $memberObject->insert_member_meta($member_id,"language_known",$language);
}else{
$rslanguage = $memberObject->update_member_meta($member_id,"language_known",$language); 
}
}


if(isset($_POST['politics']))
{
$politics = clean($_POST['politics'],$con);
	$politics	 = 	f($politics, 'strip');
$politics	 = f($politics, 'escapeAll'); 
$politics   = mysqli_real_escape_string($con, $politics);

 $checkpolitics = $memberObject->select_member_meta_value_for_lookupID($member_id,"political_view");
if($checkpolitics ==null)
{ $rspolitics = $memberObject->insert_member_meta($member_id,"political_view",$politics);
}else{
$rspolitics = $memberObject->update_member_meta($member_id,"political_view",$politics); 
}
}*/


/*		$month = clean($_POST['month'],$con);
	$month	 = 	f($month, 'strip');
$month	 = 	f($month, 'escapeAll');
$month   = mysqli_real_escape_string($con, $month);

		$day = clean($_POST['day'], $con);
	$day	 = 	f($day, 'strip');
$day	 = 	f($day, 'escapeAll');
$day   = mysqli_real_escape_string($con, $day);

		$year = clean($_POST['year'], $con);
	$year	 = 	f($year, 'strip');
$year	 = 	f($year, 'escapeAll');
$year   = mysqli_real_escape_string($con, $year);
$year=$year. "-" .date('m',strtotime($month)) . "-" . $day;

	$interested = clean($_POST['interested'], $con);
	$interested	 = 	f($interested, 'strip');
$interested	 = 	f($interested, 'escapeAll');
$interested   = mysqli_real_escape_string($con, $interested);

	$relationship = clean($_POST['relationship'], $con);
	$relationship	 = 	f($relationship, 'strip');
$relationship	 = 	f($relationship, 'escapeAll');
$relationship   = mysqli_real_escape_string($con, $relationship);

	$language = clean($_POST['language'], $con);
	$language	 = 	f($language, 'strip');
$language	 = 	f($language, 'escapeAll');
$language   = mysqli_real_escape_string($con, $language);

	$religion = clean($_POST['religion'], $con);
	$religion	 = 	f($religion, 'strip');
$religion	 = 	f($religion, 'escapeAll');
$religion   = mysqli_real_escape_string($con, $religion);
	
	$political_views = clean($_POST['political_views'], $con);
	$political_views	 = 	f($political_views, 'strip');
$political_views	 = 	f($political_views, 'escapeAll');
$political_views   = mysqli_real_escape_string($con, $membpolitical_viewser_id);

	
	//Create Update query
	$sql = "update members set gender='$gender',month='$month', day='$day', year='$year',birthdate='$bday', interested='$interested', relationship='$relationship',language='$language',religion='$religion',political_views='$political_views' where member_id = '$member_id'";
	$result = mysqli_query($con, $sql) or die($con, mysqli_error());
	
	//Check whether the query was successful or not
	if($result) 
	{
	 $_SESSION['SESS_MEMBER_ID'] = $member_id;		
		header("location: ".$base_url."profile.php");
		exit();
	}*/
?>