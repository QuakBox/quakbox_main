<?php 
include('config.php');
 $msg12 = mysqli_real_escape_string($con, $_POST['vara']);
 $id11 =$_POST['vara1'];
 $lan=$_POST['vara2'];
mysqli_query($con, "INSERT INTO reply_reply1 (msg_id,message,tr_id) VALUES('$id11','$msg12','".$lan."')");
//echo $last_id= mysqli_insert_id();
?>