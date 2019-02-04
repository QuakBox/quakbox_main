<?php ob_start();

	//Start session
	session_start();
	
	//Include database connection details
	require_once('../config.php');
	
	//Array to store validation errors
	$errmsg_arr = array();
	
	//Validation error flag
	$errflag = false;
		
	//Sanitize the POST values
	 $member_id = $_SESSION['SESS_MEMBER_ID'];	
	 $password = md5($_POST['password']);
	

	//Create query
	 $qry = "SELECT * FROM members WHERE Password='$password' and member_id='$member_id'";
	 $result = mysqli_query($con, $qry);	 
	 $query1=mysqli_fetch_array($result);
	 
	//Check whether the query was successful or not	
		if(mysqli_num_rows($result) > 0) 
		{	
		    	mysqli_query($con, "UPDATE members set active = 0 where member_id = '$member_id'");
							       
			header("location: ".$base_url."home.php");
			exit();					
		}
		else 
		{					
			header("location: ".$base_url."reactivation.php?err=".md5(003)."&back=".$redirect."&#login_ringt");	
			exit();		
		}	
?>