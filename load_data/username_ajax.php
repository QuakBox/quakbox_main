<?php

	require_once("../config.php");
	
if($_REQUEST)
{
	$username 	= mysqli_real_escape_string($con, f($_REQUEST['username'],'escapeAll'));
	//$mvnno 	= $_REQUEST['mvnno'];
	
    $query = "select username from member where LOWER(username) = '".strtolower($username)."'";
	//$query1 = "select * from activation where MVNNo = '".strtolower($MVNNo)."'"  ;
	//and  MVNNo = '".strtolower($MVNNo)."'" ;
	$results = mysqli_query($con, $query) or die('ok');
  //  $results1 = mysqli_query( $query1) or die('ok');
	
	if(mysqli_num_rows(@$results) > 0) // not available
	{
		echo '0';
	}
	else
	{
	echo '1';
	
	}
}

?>