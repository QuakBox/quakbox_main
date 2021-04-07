<?php 
include('config.php');

if(isset($_POST['type']))
{
$lan=$_POST['vara2'];
$msg = mysqli_real_escape_string($con, $_POST['vara']);
//$type=$_POST['type'];
$id =$_POST['vara1'];
mysqli_query($con, "INSERT INTO message1 (msg_id,message,tr_id) VALUES('$id','$msg','".$lan."')");
}
else if(isset($_POST['type2']))
{
$lan=$_POST['vara2'];
$msg = mysqli_real_escape_string($con, $_POST['vara']);
//$type=$_POST['type'];
$id =$_POST['vara1'];
mysqli_query($con, "INSERT INTO postcomment1 (msg_id,message,tr_id) VALUES('$id','$msg','".$lan."')");
	
}
else if(isset($_POST['type3']))
{
$lan=$_POST['vara2'];
$msg = mysqli_real_escape_string($con, $_POST['vara']);
//$type=$_POST['type'];
$id =$_POST['vara1'];
mysqli_query($con, "INSERT INTO comment_reply1 (msg_id,message,tr_id) VALUES('$id','$msg','".$lan."')");
	
}
else if(isset($_POST['type4']))
{
$lan=$_POST['vara2'];
$msg = mysqli_real_escape_string($con, $_POST['vara']);
//$type=$_POST['type'];
$id =$_POST['vara1'];
mysqli_query($con, "INSERT INTO reply_reply1 (msg_id,message,tr_id) VALUES('$id','$msg','".$lan."')");
	
}
?>