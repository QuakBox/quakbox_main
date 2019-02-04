<?php 
ob_start();
session_start();
$member_id = $_SESSION['SESS_MEMBER_ID'];
include('../config.php');
$results = array();
$code = mysqli_real_escape_string($con, f($_REQUEST['c'],'escapeAll'));
$csql = mysqli_query($con, "SELECT country_title FROM geo_country WHERE code = '$code'");
$cres = mysqli_fetch_array($csql);
$country = $cres['country_title'];

$ocquery = mysqli_query($con, "SELECT username,email_id FROM members WHERE origion_country = '$country'");
while($ocres = mysqli_fetch_array($ocquery)) {
	$ids[] = $ocres['email_id'];
$result_row1 = "'";
$result_row1.= implode("','",$ids);
$result_row1.= "'";
}
$req = "SELECT m.username,m.LastName,m.member_id 
		FROM members m inner join friendlist f on f.member_id = m.member_id 
		WHERE username LIKE '%".$_REQUEST['term']."%' and email_id IN ($result_row1) group by m.member_id "; 

$query = mysqli_query($con, $req) or die(mysqli_error($con));

$results = array();
while($row = mysqli_fetch_array($query))
{	
$sql_block=mysqli_query($con, "select * from blocklist where userid='".$row['member_id']."' and blocked_userid='".$_SESSION['SESS_MEMBER_ID']."'");
$count_block=mysqli_num_rows($sql_block);
if($count_block==0)
{
array_push($results ,array("id"=>$row['member_id'],"value"=>$row['username']));
}



	
}

echo json_encode($results);
?>