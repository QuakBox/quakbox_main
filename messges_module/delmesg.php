<?php
include('config.php');
$mesgid=$_POST['checkedid'];
$msg_member_id=$_POST['msg_member_id'];
//echo "msg member id=".$msg_member_id;
//echo "checked mesg id=".$mesgid;
$sepratedid=explode(',',$mesgid);
foreach($sepratedid as $mid)
{
	//echo "mesg id=".$mid;
	
	$sql="Delete from cometchat where id=$mid";
	mysqli_query($con, $sql);
}

?>
