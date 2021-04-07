<?php
session_start();
include('config.php');
$m_id=$_POST['msgid'];
$member_id=$_SESSION['SESS_MEMBER_ID'];

$check="select * from post_dislike where msg_id='$m_id' && member_id='$member_id'";
$stcheck=mysqli_query($con, $check);
$count=mysqli_num_rows('$stcheck');
if($count>0)
{
while($row=mysqli_fetch_array($stcheck))
{
  $dislike_id=$row['dislike_id'];
  mysqli_query($con, "delete from post_dislike where dislike_id='$dislike_id'");
} 
}

$sql="insert into bleh(remarks,member_id,updated,isread)values('$m_id','$member_id',now(),'1')";
//echo $sql;
mysqli_query($con, $sql);
?>