<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">

<?php 


 $msg12 = $_POST['vara'];
 $id11 =$_POST['vara1'];
include('../config.php');
mysqli_query($con, 'SET character_set_results=utf8');
mysqli_query($con, 'SET names=utf8');
mysqli_query($con, 'SET character_set_client=utf8');
mysqli_query($con, 'SET character_set_connection=utf8');
mysqli_query($con, 'SET collation_connection=utf8_general_ci'); 

mysqli_query($con, "INSERT INTO message1 (msg_id,message)
VALUES('$id11','$msg12')");

$sql = mysqli_query($con, "select * from message1");

while($row = mysqli_fetch_array($sql))
{
	echo $row['message'];
}

?>