<?php ob_start();
	session_start();

	//Include database connection details
	require_once('../config.php');
	
	//Sanitize the POST values
	 $from_member_id =  $_SESSION['SESS_MEMBER_ID'];
	 
	 	$to_member_id = clean($_POST['member_id'], $con);
	$to_member_id	 = 	f($to_member_id, 'strip');
$to_member_id	 = 	f($to_member_id, 'escapeAll');
$to_member_id   = mysqli_real_escape_string($con, $to_member_id);

		
		$bmessage = clean($_POST['bmessage'], $con);
	$bmessage	 = 	f($bmessage, 'strip');
$bmessage	 = 	f($bmessage, 'escapeAll');
$bmessage   = mysqli_real_escape_string($con, $bmessage);

	$time = time();
			
	//Insert query
	$sql = "insert into cometchat(cometchat.from,cometchat.to,cometchat.message,cometchat.sent,cometchat.read) values('$from_member_id','$to_member_id','".  		$bmessage."','$time',1)";
	$result = mysqli_query($con, $sql) or die(mysqli_error($con));
	
	//$sql = "insert into bday_msg(from_member_id,to_member_id,msg,date_created,status) values('$from_member_id','$to_member_id','".$bmessage."','$time',1)";
	//$result1 = mysqli_query($con, $sql) or die(mysqli_error($con));
	
	//Insert query
	$query = "insert into message(member_id,content_id,messages,date_created) values('$from_member_id','$to_member_id','".$bmessage."','$time')";
	$responce = mysqli_query($con, $query) or die(mysqli_error($con));
	
$url = '';
if(strpos($_SERVER['HTTP_REFERER'], "?") == null)
	$url = $_SERVER['HTTP_REFERER'];
else
	$url = substr($_SERVER['HTTP_REFERER'], 0, strpos($_SERVER['HTTP_REFERER'], "?"));
	


header("location: ".$url."");
exit();

?>
