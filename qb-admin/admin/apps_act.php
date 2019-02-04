<?php
 session_start();

if(!isset($_SESSION['id']))
{
	header("location:login.php");
}
include("config.php");

 $id=$_GET['id'];

if(isset($_GET['call']))
{
	mysqli_query($conn,"UPDATE app SET status=0
WHERE id=$id") or die(mysqli_error($conn));
header("location:apps_table.php");
}
else
{
	mysqli_query($conn,"UPDATE app SET status=1
WHERE id=$id") or die(mysqli_error($conn));
header("location:apps_table.php");
}
?>
