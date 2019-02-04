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
	
	$err = false;
	$err1 = array();//for username
	$err2 = array();//for error
	$json = array();
	
if($name=='email' && $value != '')
{	
		
	$email 	= mysqli_real_escape_string($con, f($value,'escapeAll'));
	$query = "select email from member where email = '".$email."'";
	$results = mysqli_query($con, $query) or die('ok');
	 if(mysqli_num_rows(@$results) > 0) // not available
	 {
		$err = true;
		$err1 = array("email" => "The Email is not available");
	 }
	 else
	 {
	 	$memberResult = $memberObject->update_member_columns($member_id,"email",$value); 
	 	if(!$memberResult)
		{
			$err = true;
			$err2 = array("email" => "Query Failed");
		}
	 }
	
	

$json = array_merge($err1, $err2);

if($err)
{
echo json_encode(array(
     "errors" => $json
));
}
else
{
echo json_encode(array(
     "result" => "ok"
     ));
}	
}
else{
header('HTTP 400 Bad Request', true, 400);
        echo "This field is required!";
}

	
	
?>