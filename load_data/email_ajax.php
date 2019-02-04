<?php
	require_once($_SERVER['DOCUMENT_ROOT']."/config.php");
	$err = false;
	$err1 = array();//for email
	$err2 = array();//for username
        $err3 = array();//for qbemail
	$json = array();
	
if($_REQUEST)
{
	if($_REQUEST['email'])
	{
		$email 	= mysqli_real_escape_string($con, f($_REQUEST['email'],'escapeAll'));
		$query = "select email from member where LOWER(email) = '".strtolower($email)."'";
	    	$results = mysqli_query($con, $query) or die('ok');
		if(mysqli_num_rows($results) > 0) // not available
		{
			$err = true;
			$err1 = array("email" => "The Email is not available");
		}
	
	}

        
	if($_REQUEST['username'])
	{	
		$username 	= mysqli_real_escape_string($con, f($_REQUEST['username'],'escapeAll'));
		$query = "select username from member where LOWER(username) = '".strtolower($username)."'";
		$results = mysqli_query($con, $query) or die('ok');
	  	if(mysqli_num_rows(@$results) > 0) // not available
		{
			$err = true;
			$err2 = array("username" => "The Username is not available");
		}
	}
        
        
        
        if($_REQUEST['qbemail'])
	{
		$qbemail 	= mysqli_real_escape_string($con, f($_REQUEST['qbemail'],'escapeAll'));
		$query = "select qbemail from member where LOWER(qbemail) = '".strtolower($qbemail)."'";
	    	$results = mysqli_query($con, $query) or die('ok');
		if(mysqli_num_rows($results) > 0) // not available
		{
			$err = true;
			$err3 = array("qbemail" => "The Email is not available");
		}
	}
        

$json = array_merge(array_merge($err1, $err2),$err3);

if($err)
{
echo json_encode(array(
     "result" => "error",
     "fields" => $json
));
}
else
{
echo json_encode(array(
     "result" => "ok"
     ));
}	
}

?>