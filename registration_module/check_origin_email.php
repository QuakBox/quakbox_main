<?php
session_start();
include('config.php');
$emails=$_POST['val'];
$cntid=$_POST['cntid'];
$member_id = $_SESSION['SESS_MEMBER_ID'];
	$sql = mysqli_query($con, "select * from members where member_id='".$member_id."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);
	$ocountry_id=$res['origion_country'];
	
$sepemails=explode(',',$emails);
foreach($sepemails as $email)
{
//echo $email."<br>";
	if($cntid=="")
	{
		    $check="select member_id from members where member_id!=$member_id && email_id='$email'";
		    $st=mysqli_query($con, $check);
		    $count=mysqli_num_rows($st);
		    if($count==0)
		    {
		     $stat="false";
		     break;
		    }
		    else
		    {
		     $stat="true";
		    }
     }
     else
     {
       $check="select member_id from members where member_id!=$member_id && email_id='$email' && country='$cntid'";
		    $st=mysqli_query($con, $check);
		    $count=mysqli_num_rows($st);
		    if($count==0)
		    {
		     $stat="false";
		     break;
		    }
		    else
		    {
		     $stat="true";
		    }
     
     }
}
echo $stat;
?>