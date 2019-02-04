<?php 
//header( 'Content-Type: text/html; charset=utf-8' ); 
include('config.php');
 echo $msg12 = mysqli_real_escape_string($con, $_POST['vara']);
 echo $id11 =$_POST['vara1'];
 echo $lan=$_POST['vara2'];
mysqli_query($con, "update message1 set ar='$msg12' where id='$id11'");
 //$last_id1= mysqli_insert_id($con);


$sql = mysqli_query($con, "select * from message1 where id='$id11'");

while($row = mysqli_fetch_array($sql))
{
	echo $row['hi'];
}

?>

