<?php
session_start();
include('config.php');
$m_id=$_POST['msgid'];
$member_id=$_SESSION['SESS_MEMBER_ID'];
//echo $m_id;


$check="select * from bleh where remarks='$m_id' && member_id='$member_id'";
$stcheck=mysqli_query($con, $check);
$count=mysqli_num_rows($stcheck);
//echo $count;
if($count>0)
{
while($row=mysqli_fetch_array($stcheck))
{
  $like_id=$row['bleh_id'];
  mysqli_query($con, "delete from bleh where bleh_id='$like_id'");
  echo "delete from bleh where bleh_id='$like_id'";
}
}

$sql="insert into post_dislike(msg_id,member_id,date_created,isread)values('$m_id','$member_id',now(),'1')";
//echo $sql;

mysqli_query($con, $sql);

?>