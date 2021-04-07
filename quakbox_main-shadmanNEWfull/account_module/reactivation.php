<?php 
ob_start();
//Start session
	session_start();	
	
	if(isset($_SESSION['lang']))
	{	
		include('common.php');
	}
	else
	{
		include('Languages/en.php');
		
	}
	require_once('config.php');
		
	
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="images/favicon.ico" type="image" />
<link rel="shortcut icon" href="images/favicon.ico" type="image" />

<title>QuakBox</title>
<link href="css/format1.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/reset.css" type="text/css" />
<link rel="stylesheet" href="css/master.css" type="text/css" />
<link rel="stylesheet" href="css/index.css" type="text/css" />
<link rel="stylesheet" href="css/loginPage.css" type="text/css" />
</head>
<body class="login">

<div class="wrapper">

<div class="mainbody">
<div class="header">
<div class="topleft"><a href="index.php"><img src="images/quack.png" width="190" height="70" /></a></div>
 </div>
  <div class="masterdiv">  	
    <div class="form-signin">             
		<div id="loginform">
        <form action="<?php echo $base_url; ?>action/activate-exec.php" method="post" id="form-login">
 <input type="hidden" name="location" value="<?php if(isset($_GET['back'])) { echo htmlspecialchars($_GET['back']);} echo '';?>">
		  <div id="loginemail"> To Activate your account please enter your password
          <br /><br />
			
           </div>
           <br />
           <div id="loginpswrd"> Password
           <br /><br />
           <input name="password" type="password" placeholder="Password" required class="inputtext"  />
           </div>
           <br />
           <br /><br />
			<input   type="submit" value="Login" id="logbutton" />
           </form>
        </div>
        
  </div>
  <?php
if(isset($_GET['err']))
{
if($_GET['err'] != null)
{ 
?>
<h4 align="left" style="color:#FF0000">Invalid Password</h4>
<?php }
}
?>
</div>
</div>
</div>


<?php include('includes/footer_front.php');?>
<script src="js/jquery-1.7.2.min.js" type="text/javascript"></script>
<script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">jQuery(document).ready(function(){jQuery("#form1").validationEngine();});</script>
</body>
</html>