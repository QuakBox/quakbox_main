<?php 
include('config.php');

$type= $_POST['type'];
$lan=$_POST['vara2'];
$msg = mysqli_real_escape_string($con, $_POST['vara']);
//$type=$_POST['type'];
$id =$_POST['vara1'];
if($type=='1')
{
	
mysqli_query($con, "INSERT INTO ads_title (ads_id,data,lang) VALUES('$id','$msg','".$lan."')");
}
else if($type=='2')
{
	mysqli_query($con, "INSERT into groups1 (group_id,data,lang,type) VALUES('$id','$msg','".$lan."','0')");
}
else if($type=='3')
{
	mysqli_query($con, "INSERT into groups1 (group_id,data,lang,type) VALUES('$id','$msg','".$lan."','1')");
}
else 
{
	mysqli_query($con, "INSERT into ads_description (ads_id,data,lang) VALUES('$id','$msg','".$lan."')");
}
?>