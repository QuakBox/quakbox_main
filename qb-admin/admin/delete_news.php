<?php session_start();

if(isset($_SESSION['id']))
{
	include("config.php");
	$memberId = $_GET['id'];
	$deleteQuery = "DELETE from news WHERE news_id='$memberId'";
	mysqli_query($conn, $deleteQuery );
	header("location:newstable.php");
}
else
header("Location: login.php");
?>
