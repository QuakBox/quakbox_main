<?php
	
	//Include database connection details
	require_once('../config.php');
	
	
	
	
	//Function to sanitize values received from the form. Prevents SQL injection
	function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysqli_real_escape_string($str);
	}
	
	
	$tempPass = "matrix";
	$tempPass	 = 	f($tempPass, 'strip');
$tempPass	 = 	f($tempPass, 'escapeAll');
$tempPass   = mysqli_real_escape_string($con, $tempPass);

	$password = "matrix";
	$password	 = 	f($password, 'strip');
$password	 = 	f($password, 'escapeAll');
$password   = mysqli_real_escape_string($con, $password);
	
	$email = "abhinavpanda1990@gmail.com";
	$email	 = 	f($email, 'strip');
$email	 = 	f($email, 'escapeAll');
 echo $email   = mysqli_real_escape_string($con, $email);


	$hash = hash('sha256', $password); 
	$salt = genUid();
	$password = hash('sha256', $salt . $hash);


	//Create INSERT query
	 $qry = "UPDATE  members SET Password = '$password',tempPass = '$tempPass', salt = '$salt' where email_id = '$email'";
	 $result = mysqli_query($con, $qry) or die(mysqli_error($con));
	 
	/* $stmt = $dbh->prepare("UPDATE  members SET Password = ?,tempPass = ?, salt = ? where email_id = ?");

	$stmt->bindParam(1, $password);
	$stmt->bindParam(2, $tempPass);
	$stmt->bindParam(3, $salt);
	$stmt->bindParam(4, $email);*/
	
	 
	exit;
?>