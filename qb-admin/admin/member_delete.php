<?php session_start();

if(isset($_SESSION['id']))
{
	include("config.php");
	$memberId = $_GET['id'];
	$deleteQuery = "DELETE from admins WHERE id='$memberId'";
	mysql_query( $deleteQuery );
	header("location:member_table.php");
}
else
header("Location: login.php");
?>
