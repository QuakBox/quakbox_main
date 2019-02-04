<?php
/**
   * Rgister Exe action file of index while submission
   * 
   * @author     quakbox
   * Updated date  04/13/2015 05:00:05
   * Updated by    Abhinav
 **/
	//Start session
	ob_start();
	session_start();
	
	//Include database connection details
	require_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_log.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_registration_class.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_lookup.php');			
	//Sanitize the POST values
	//$fname = clean($_POST['fname'], $con);	
	//$lname=  clean($_POST['lname'], $con);
	$flagForServer = false;	//Server Side Validation for User Inputs
        $AgeAccepted  = true;
        $username = clean($_POST['username'], $con);
	$username = preg_replace_callback('/\s+/',function ($matches) {return '';}, $username);
	$tempPass = $_POST['cpassword'];
	$password = $_POST['cpassword'];	
	$email = $_POST['email'];
        $qbemail = $_POST['qbemail'];
	$dob = $_POST['birthDay'];
	//$country = clean($_POST['country'], $con);
	//$uploadimage = 'images/default.png';
	$time = time();
	$activation_code=md5(randomCode(6));
	$ip = $_SERVER['REMOTE_ADDR'];
	$hash = hash('sha256', $password); 
	$salt = genUid();
	$password = hash('sha256', $salt . $hash);
	$age = date_diff(date_create($dob), date_create('today'))->y;
	list( $y, $m, $d ) = preg_split( '/[-\.\/ ]/', $dob);
	if (!preg_match('/^([0-9]|[a-z])+([0-9a-z]+)$/i', $username))
	{
		$flagForServerusername = true;
	}
	else if(!preg_match('/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{1,4})+$/', $email))
	{$flagForServer = true;}
	else if(!checkdate( $m, $d, $y ))
	{$flagForServer = true;}
	else if($age<13)
	{$flagForServer = true;
        $AgeAccepted = false;
        }

	if(!$AgeAccepted)
	{
	header("location: ".$base_url."landing.php?Message=AgeLimit");
 	exit();
	}
	if($flagForServerusername)
	{
	header("location: ".$base_url."landing.php?Message=UsernameWrong");
 	exit();
	}
        
	if($flagForServer)
	{
	header("location: ".$base_url."index.php");
 	exit();
	}
	

	
try
{
	
$object = new registration(); 
 $lookup_id =  $object->insert_registration($password,$username,$qbemail,$email,$activation_code,$salt,$dob);
 if($lookup_id!=NULL)
 {
			$_SESSION['SESS_MEMBER_ID'] = $lookup_id;
			$res = $object->insert_member_meta($lookup_id,"ip",$ip);
			$res1 = $object->insert_member_meta($lookup_id,"member_registered_on","");
			$res2 = $object->insert_member_meta($lookup_id,"temp_pwd",$tempPass);
			if($res1)
			{
			/*header("location: ".$base_url."getting_started_import.php");*/
			header("location: ".$base_url."registerProfile.php");
			exit();
			
			
			}
			else
			{echo "query failed";}
 }
else
{
echo "query failed";
}	
	/*Create INSERT query 
	insertion in main table members*/
	/* $qry = "INSERT INTO members(Password,FirstName,username,email_id,origion_country,profImage,registerDate,LastName,status_code,tempPass,salt) VALUES('$password','$fname','$login','$email','$country','$uploadimage',now(),'$lname','$activation_code','$tempPass','$salt')";
	 $result = mysqli_query($con, $qry) or die(mysqli_error($con));
	 
	*/
	 	/*Create INSERT query 
	insertion in table members_profile_images
	stores member id ,status=1,prof pic*/
	/* $member_id = mysqli_insert_id($con);
	 $pquery = "INSERT INTO members_profile_images (url,status,created_on,member_id)
	 			VALUES('$uploadimage','1',now(),'$member_id')";
	 $pres = mysqli_query($con, $pquery);
	
	
		/*Create INSERT query 
	FUTURE USE .. PRIVACY SETTINGS*/
	/*mysqli_query($con, "insert into privacy(profile,friends,photo,privacy_member_id,receive_email,receive_notification,comment_notification) values(0,0,0,0,0,0,0)");
	
	$sql="INSERT INTO message(messages,member_id,date_created,ip,type,wall_privacy,share_member_id,unshare_member_id) VALUES ('$uploadimage','$member_id',$time,'$ip',1,'$privacy','".$share_member."','".$unshare_member."')"; 
			mysqli_query($con, $sql) or die(mysqli_error($con));
			$message_id=mysqli_insert_id($con);
	
	$aquery="INSERT into user_album (album_user_id,album_name) VALUES('".$member_id."','".$login."');";
	mysqli_query($con, $aquery) or die(mysqli_error($con)) ;
	$album_id = mysqli_insert_id($con);
	
	 $uquery="INSERT into upload_data (`USER_CODE`,`FILE_NAME`,`FILE_SIZE`,`FILE_TYPE`,`album_id`,`date_created`,msg_id) VALUES('$member_id','$uploadimage','$file_size','$file_type','$album_id','".strtotime(date("Y-m-d H:i:s"))."','$message_id'); ";
	 mysqli_query($con, $uquery) or die(mysqli_error($con)) ;
	 
	 mysqli_query($con, "Update message set msg_album_id=".$album_id." where messages_id=".$message_id."");
	 
	 $cover_channel = 'images/channel_cover.png';
	 //query for insert data into videos_channel table
	 mysqli_query($con, "INSERT INTO videos_channel (member_id,cover_photo) VALUES('$member_id','$cover_channel')");
	 
	
	
		
		//session_regenerate_id();
		$sql = "select * from members where member_id='$member_id' order by member_id desc LIMIT 1";
		if($sql = mysqli_query($con, $sql) or die(mysqli_error($con)))
		{
			$member = mysqli_fetch_array($sql);
			
			$_SESSION['session_member_id'] = $member['member_id'];
			$_SESSION['SESS_MEMBER_ID'] = $member['member_id'];
		 	$_SESSION['SESS_FIRST_NAME'] = $member['username'];

			
//mail function
$to = $email;
$subject = "Account Details For '".$fname."' at ".$site_name."";
$message = "
<html>
<head>
<title>'".$subject."'</title>
</head>
<body style='font-family:Verdana, Geneva, sans-serif; font-size:14px;'>

<p>Hello '".$fname."',</p><br />
<p>	Thank You for registering at <a href='".$base_url."'>".$site_name."</a>. Your account is created and must be activated before you can log in. To activate the account, click on the following link or copy-&-paste it in your browser.</p>
<br>

<a href='".$base_url."activation.php?verification_code=".$activation_code."&member_id=".$member['member_id']."'>Click here to Activate your account.
</a><br />
<p>Or Copy Below link and paste in Your Browser.
</p><br />
<a href='".$base_url."activation.php?verification_code=".$activation_code."&member_id=".$member['member_id']."'>".$base_url."activation.php?verification_code=".$activation_code."&member_id=".$member['member_id']."
</a>
<br />
<p>After activation you may log in to <a href='".$base_url."'>".$site_name."</a> using the following username and password:</p>
<br>
Email_id  :".$login."@".$site_email." or<br>
User Name :".$login."<br>
Password  :".$_POST['password2']."<br>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";


$headers .= "From: ".$site_email."";

$mail = mail($email, $subject, $message, $headers); 


		if($mail)
		{
		header("location: ".$base_url."getting_started_import.php");
		exit();
		}
		else
		{
		echo "mail not sent";
		}
		
		
	}else {
		die("Query failed");
	}*/
}
catch(Exception $ex)
		{
		
		 /* General exception error message */
	 write_log($ex->getMessage(),1,"register-exec.php","Anonymous");
		}
?>