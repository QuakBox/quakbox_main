<?php session_start();

include("config.php");
if(isset($_POST['submit']))
 {
	$name = $_POST['username'];
	$password = $_POST['password'];
	$password1 = md5($password);
	//$decrept_password = md5($password);
	
	$query = "SELECT id FROM admins 
			WHERE username = '$name'
			AND password = '$password1'";
			

	$sql = mysqli_query($con, $query) or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);
	$res1= $res['id'];
	if(mysqli_num_rows($sql) > 0) 
	{
		$_SESSION['id'] = $res1;
		
		header("location:index.php");
		exit();
		
	} else 
	{		

		
		header("location:login.php?err=1");

	}
}
?>