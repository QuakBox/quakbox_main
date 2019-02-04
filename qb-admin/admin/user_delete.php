<?php session_start();



if(isset($_SESSION['id']))

{

	include("config.php");

	$memberId = $_GET['id'];

	$deleteQuery = "DELETE FROM member WHERE member_id=$memberId";
mysqli_query($conn,$deleteQuery);

	header("location:user_table.php");

}

else

header("Location: login.php");

?>

