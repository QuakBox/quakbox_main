<?php 
include('config.php');

if(isset($_POST['type1']))
{
$lan1=$_POST['vara12'];
$msg121= mysqli_real_escape_string($con, $_POST['vara1']);
$type1=$_POST['type1'];
$id11 =$_POST['vara11'];
mysqli_query($con, "INSERT INTO message1 (msg_id,message,tr_id) VALUES('$id11','$msg121','".$lan1."')");
}
else if(isset($_POST['type2']))
{
$lan2=$_POST['vara22'];
$msg122 = mysqli_real_escape_string($con, $_POST['vara2']);
$type2=$_POST['type2'];
$id12 =$_POST['vara12'];
mysqli_query($con, "INSERT INTO postcomment1 (msg_id,message,tr_id) VALUES('$id12','$msg122','".$lan2."')");
}
else if(isset($_POST['type3']))
{
 $lan3=$_POST['vara32'];
$msg123= mysqli_real_escape_string($con, $_POST['vara3']);
$type3=$_POST['type3'];
$id13 =$_POST['vara13'];
mysqli_query($con, "INSERT INTO comment_reply1 (msg_id,message,tr_id) VALUES('$id13','$msg123','".$lan3."')");
}
else if(isset($_POST['type4']))
{
$lan4=$_POST['vara42'];
$msg124 = mysqli_real_escape_string($con, $_POST['vara4']);
$type4=$_POST['type4'];
$id14 =$_POST['vara14'];
mysqli_query($con, "INSERT INTO reply_reply1 (msg_id,message,tr_id) VALUES('$id14','$msg124','".$lan4."')");
}
else if(isset($_POST['type5']))
{
$lan1=$_POST['vara12'];
$msg121= mysqli_real_escape_string($con, $_POST['vara1']);
$type1=$_POST['type5'];
$id11 =$_POST['vara11'];
mysqli_query($con, "INSERT INTO videos1 (video_id,title,lang) VALUES('$id11','$msg121','".$lan1."')");
}
 else
 {
 
 mysqli_query($con, "INSERT INTO message1 (msg_id,message,tr_id) VALUES('0','0','0')");
 
 }




?>
