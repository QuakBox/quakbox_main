<?php ob_start();
	//Start session
	session_start();
	
	//Include database connection details
	require_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_registration_class.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_lookup.php');
	$objLookupClass=new lookup();
	$male =  $objLookupClass->getLookupKey("GENDER", "MALE");
	$female =  $objLookupClass->getLookupKey("GENDER", "FEMALE");
	//Array to store validation errors
	$errmsg_arr = array();
	
	//Validation error flag
	$errflag = false;
	$object = new registration();	
	//Sanitize the POST values
	$member_id = $_SESSION['SESS_MEMBER_ID'];
	$fname = clean($_POST['fname'], $con);	
	$lname =  clean($_POST['lname'], $con);
	$gender = clean($_POST['gender'], $con);	
	$about_me = clean($_POST['about_me'], $con);
	$location = "images/ImageGenderOther.png";
	
	if($gender==$male)
	{
		$location = "images/ImageGenderMale.png";
	}else if($gender==$female)
	{
		$location = "images/ImageGenderFemale.png";
	}
	
	$displayName = $fname.' '.$lname;
    $file = $_FILES['image']['tmp_name'];
	if (!isset($file)){
	    echo "";
	} else {
	    $image= addslashes(file_get_contents($_FILES['image']['tmp_name']));
	    $image_name= addslashes($_FILES['image']['name']);
	    $image_size= getimagesize($_FILES['image']['tmp_name']);
		if ($image_size==FALSE) {		
			echo "That's not an image!";			
		} else {			
		
                $ext = pathinfo($image_name, PATHINFO_EXTENSION);                
                move_uploaded_file($_FILES["image"]["tmp_name"],"../profile_photo/" . $member_id .'.'. $ext);
		        $location=mysqli_real_escape_string($con, "profile_photo/" . $member_id .'.'. $ext);
		        $object-> skipChekPoints($member_id, 'Profile Image');
    	    
	    }
	}


$rs = $object->insert_member_meta($member_id,"first_name",$fname);
$rs1 = $object->insert_member_meta($member_id,"last_name",$lname);
$rs2 = $object->insert_member_meta($member_id,"gender",$gender);
$rs3 = $object->insert_member_meta($member_id,"about_me",$about_me);
$rs4 = $object->insert_member_meta($member_id,"current_profile_image",$location);
$rs5 = $object->update_DisplayName($member_id,$displayName);
//Check whether the query was successful or not
if($rs5)
{
$object-> skipChekPoints($member_id, 'Additional Information');
header("location: ".$base_url."registerContact.php");
exit();
}

	//$month=clean($_POST['month'], $con);
	//$day=clean($_POST['day'], $con);
	//$year=clean($_POST['year'], $con);
	//$bday=clean($_POST['year']. "-" .date('m',strtotime($month)) . "-" . $_POST['day'], $con);
	
	//Create Update query
	/*$sql = "update members set gender='$gender',month='$month', day='$day', year='$year',birthdate='$bday', aboutme='$about_me' where member_id = '$member_id'";
	$result = mysqli_query($con, $sql) or die(mysqli_error($con));
	
	//Check whether the query was successful or not
	if($result) 
	{
	 $_SESSION['SESS_MEMBER_ID'] = $member_id;		
		header("location: ".$base_url."registerContact.php");
		exit();
	}*/
?>