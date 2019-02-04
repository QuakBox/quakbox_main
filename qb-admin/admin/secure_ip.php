<?php ob_start();
//Start session
	
	session_start();	
	//Include database connection details
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
	require_once($_SERVER['DOCUMENT_ROOT'] . "/qb_classes/connection/qb_database.php");
	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_log.php');
	$base_url = SITE_URL . "/";
	$database = new database();
	error_reporting(-1);
	if(isset($_POST['landing_submit'])){		
	
	//Sanitize the POST values
	$flagForServer = false;	//Server Side Validation for User Inputs
        $username = clean($_POST['name'], $database->con);
	$username = preg_replace_callback('/\s+/',function ($matches) {return '';}, $username);
	$password = "testquakb123!@#";// old pass "testquakb123!@#";	
	$email = $_POST['email'];
	
	$ip = $_SERVER['REMOTE_ADDR'];
	$hash = hash('sha256', $password); 
	$salt = genUid();
	$password = hash('sha256', $salt . $hash);
	
	//echo " username >> " . !preg_match('/^([0-9]|[a-z])+([0-9a-z]+)$/i', $username);
	//echo " <br/> email >> " . !preg_match('/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/', $email);
	//exit;
	if (!preg_match('/^([0-9]|[a-z])+([0-9a-z]+)$/i', $username))
	{$flagForServer = true;}
	else if(!preg_match('/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/', $email))
	{$flagForServer = true;}
	
	
	if($flagForServer)
	{
	header("location: ".$base_url."qb-admin/admin/register_ip.php");
 	exit();
	}
	
	
try
{
	
$vquery = "INSERT INTO registered_ip (ip_address ,ip_holder_name ,password ,salt , email) VALUES('$ip','$username','$password','$salt','$email')";


$database->insertQueryReturnLastID( $vquery );
header("location: ".$base_url."");
 	exit();	
}
catch(Exception $ex)
		{
		
		 /* General exception error message */
	 write_log($ex->getMessage(),1,"secure_ip.php","Anonymous");
		}
	
	}