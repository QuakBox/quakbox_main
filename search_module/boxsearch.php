<?php
session_start();

	//error_reporting(0);
require_once('config.php');
	if(!isset($_SESSION['SESS_MEMBER_ID']))

	{

		header("location: ".$base_url."login.php?back=". urlencode($_SERVER['REQUEST_URI']));
		exit();

	}

	if(isset($_SESSION['lang']))

	{	

		include('common.php');

	}

	else

	{

		include('Languages/en.php');

		

	}

	

	$member_id = $_SESSION['SESS_MEMBER_ID'];

	

	$sql = mysqli_query($con, "select * from members where member_id='".$member_id."'") or die(mysqli_error($con));

	$res = mysqli_fetch_array($sql);
	
	if(mysqli_num_rows($sql) == 0){ exit;}

	$friends_member_id = $res['member_id'];




if($_POST)
{
$q=$_POST['searchword'];
$q=str_replace("@","",$q);
$q=str_replace(" ","%",$q);

$clicks = mysqli_query($con, "select * from friendlist f,members m where f.added_member_id = m.member_id and f.member_id = '".$friends_member_id."' AND f.status != 0 AND m.active != 1 AND FirstName like '%$q%' or LastName like '%$q%' order by uid LIMIT 5 ");

	if(mysqli_num_rows($clicks) > 0)

	{

	while($clicks_res = mysqli_fetch_array($clicks))

	{
$member=$clicks_res['member_id'];
		$b = mysqli_query($con, "select * from friendlist where member_id = '".$_SESSION['SESS_MEMBER_ID']."'");
		
		$fcount = mysqli_query($con, "select * from friendlist where (added_member_id = '".$_SESSION['SESS_MEMBER_ID']."' AND member_id='$member') OR
		(member_id = '".$_SESSION['SESS_MEMBER_ID']."' AND added_member_id='$member')")  or die(mysqli_error($con));				
		$fcount_row = mysqli_num_rows($fcount);

		$c = mysqli_num_rows($b);



$fname=$clicks_res['FastName'];
$lname=$clicks_res['LastName'];
$img=$clicks_res['profImage'];
$country=$clicks_res['country'];

?>
<div class="display_box" align="left">
<img src="<?php echo $base_url.$clicks_res['profImage'];?>" class="image"/>
<a href="#" class='addname' title='<?php echo $fname; ?>&nbsp;<?php echo $lname; ?>'>
<?php echo $fname; ?>&nbsp;<?php echo $lname; ?> </a><br/>
<?php

}
	}}
?>
