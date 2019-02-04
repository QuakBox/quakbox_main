<?php
include("../config.php");
//echo $_POST['c_id'];
if($_POST['data']&&$_POST['c_id'])
{
$data=$_POST['data'];
$cid=$_POST['c_id'];
$data = mysqli_escape_String($con, $data);
$cid = mysqli_escape_String($con, $cid);
$sql = "update facebook_posts_comments set comments='$data' where c_id='$cid'";
mysqli_query($con, $sql);
}
?>