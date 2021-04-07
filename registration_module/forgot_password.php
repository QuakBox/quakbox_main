<?php
	//Start session
	session_start();
	require_once('config.php');	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="icon" href="images/favicon.ico" type="image" />
<link rel="shortcut icon" href="images/favicon.ico" type="image" />

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Quakbox</title>
<link href="css/format1.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/reset.css" type="text/css" />
<link rel="stylesheet" href="css/master.css" type="text/css" />


<style type="text/css">
<!--
body {
	background-image: url(images/bg.jpg);
	background-repeat:repeat-x;
	background-color:#FFFFFF;

}
-->
</style>

		<script>
		jQuery(document).ready(function(){
			// binds form submission and fields to the validation engine
			jQuery("#form").validationEngine();
		});

		/**
		*
		* @param {jqObject} the field where the validation applies
		* @param {Array[String]} validation rules for this field
		* @param {int} rule index
		* @param {Map} form options
		* @return an error string if validation failed
		*/
		function checkHELLO(field, rules, i, options){
			if (field.val() != "HELLO") {
				// this allows to use i18 for the error msgs
				return options.allrules.validate2fields.alertText;
			}
		}
	</script>

</head>

<body>
<div class="mainr" style="height:150px;">
  <div class="topleft"><img src="images/quack.png" width="190" height="70" /></div>
 
</div>
<?php 
if(isset($_REQUEST['Submit']))
{
$email = $_POST['uname'];
$sql = mysqli_query($con, "select * from member where email = '".$email."'");
$result = mysqli_fetch_array($sql);
$fname = $result['username'];

$to = $email;
$subject = "Account Details For ".$fname." at ".$site_name."";
$message = "
<html>
<head>
<title>'".$subject."'</title>
</head>
<body style='font-family:Verdana, Geneva, sans-serif; font-size:14px;'>

<p>Hello '".$fname."',</p><br />
<p>	Welcome to <a href='".$base_url."'>".$site_name."</a>. Your New Password is created and must be activated before you can log in. To Reset Password , click on the following link or copy-&-paste it in your browser.</p>
<br>
<a href='".$base_url."new_password.php?member_id=".$result['member_id']."'>
'".$base_url."new_password.php?member_id=".$result['member_id']."
</a>
<br />

</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";


$headers .= "From:  ".$site_email."";

$mail = mail($email, $subject, $message, $headers); 
}
?>

  <br /><br />
  <div align="center" id="masterdiv" style="margin-left: 450px;padding: 10px; height: 150px;">

  
   <!-- <div class="signup">Sign Up</div>-->
	
	<div class="text" >
	<form  method="post" name="form" id="form">
   <!-- <input name="member_id" type="hidden" class="textfield" id="member_id" value=<?php // echo $member_id;?> size="40">-->
	  
        <div class="free">Forgot Password</div><br />
        
        <div class="textleft">Enter Email :</div>
		<div class="textright"><input name="uname" type="text" class="textfield"  size="40">
        </div>
		
      
		
        
<div class="textleft">
</div>

		<div class="textright">

		<div class="textleft"></div>
		<div class="textright">
		  <label>
          
		  <input type="submit" name="Submit" value="Reset" class="greenButton1"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Back" class="greenButton1" onClick="javascript:{window.history.back();}"/>
          <!--<a href="registerEdu.php" ><input align="right" type="button" name="skip" value="Skip" class="greenButton1" /></a>-->
		  </label>
		</div>
	</form>	
	</div>
  </div>
 
</body>
</html>
