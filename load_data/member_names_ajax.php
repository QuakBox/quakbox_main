<?php 
ob_start();
session_start();
include($_SERVER['DOCUMENT_ROOT'].'/common/common.php');

$member_id = $_SESSION['SESS_MEMBER_ID'];
$q = mysqli_real_escape_string($con, f($_REQUEST['term'],'escapeAll'));
$results = array();
$req = "SELECT username,member_id FROM member WHERE username LIKE '%$q%' and member_id!='$member_id' "; 

$query = mysqli_query($con, $req);

while($row = mysqli_fetch_array($query))
{
$member=$row['member_id'];
$block=mysqli_query($con, "select * from blocklist where userid='$member' and blocked_userid='$member_id' ");
	$block_count = mysqli_num_rows($block);
if($block_count==0)
	{
	$results[] = $row['username'];
	}
}

echo json_encode($results);
?>