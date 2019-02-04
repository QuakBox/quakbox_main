<?php ob_start();
	//Start session
	session_start();
	$flag = false;
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
	require_once($_SERVER['DOCUMENT_ROOT'] . "/qb_classes/connection/qb_database.php");
	$ip = $_SERVER['REMOTE_ADDR'];
	$base_url = SITE_URL . "/";
		
	
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>QuakBox</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script src="js/jquery-1.7.2.min.js"></script>
<style>
/*dark background to support form theme*/
body{
  background:url("img/abs6.jpg");
}



@mixin disable{
  outline:none;
  border:none;
}

@mixin easeme{
  -webkit-transition:1s ease;
  -moz-transition:1s ease;
  -o-transition:1s ease;
  -ms-transition:1s ease;
  transition:1s ease;
}

/*site container*/
.wrapper{
  width:420px;
  margin:0 auto;
}

h1{
  text-align:center;
  padding:30px 0px 0px 0px;
  font:25px Oswald;
  color:#FFF;
  text-transform:uppercase;
  text-shadow:#000 0px 1px 5px;
  margin:0px;
}

p{
  font:13px Open Sans;
  color:#6E6E6E;
  text-shadow:#000 0px 1px 5px;
  margin-bottom:30px;
}

.form{
  width:100%;
}

input[type="text"],input[type="email"]{
  width:98%;
  padding:15px 0px 15px 8px;
  border-radius:5px;
  box-shadow:inset 4px 6px 10px -4px rgba(0,0,0,0.3), 0 1px 1px -1px rgba(255,255,255,0.3);
	background:rgba(0,0,0,0.2);
  @include disable;
  border:1px solid rgba(0,0,0,1);
  margin-bottom:10px;
  color:#6E6E6E;
  text-shadow:#000 0px 1px 5px;
}

input[type="submit"]{
  width:100%;
  padding:15px;
  border-radius:5px;
  @include disable;
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#28D2DE), to(#1A878F));
  background-image: -webkit-linear-gradient(#28D2DE 0%, #1A878F 100%);
  background-image: -moz-linear-gradient(#28D2DE 0%, #1A878F 100%);
  background-image: -o-linear-gradient(#28D2DE 0%, #1A878F 100%);
  background-image: linear-gradient(#28D2DE 0%, #1A878F 100%);
  font:14px Oswald;
  color:#FFF;
  text-transform:uppercase;
  text-shadow:#000 0px 1px 5px;
  border:1px solid #000;
  opacity:0.7;
	-webkit-box-shadow: 0 8px 6px -6px rgba(0,0,0,0.7);
  -moz-box-shadow: 0 8px 6px -6px rgba(0,0,0,0.7);
	box-shadow: 0 8px 6px -6px rgba(0,0,0,0.7);
  border-top:1px solid rgba(255,255,255,0.8)!important;
  -webkit-box-reflect: below 0px -webkit-gradient(linear, left top, left bottom, from(transparent), color-stop(50%, transparent),  to(rgba(255,255,255,0.2)));
}

input:focus{
  box-shadow:inset 4px 6px 10px -4px rgba(0,0,0,0.7), 0 1px 1px -1px rgba(255,255,255,0.3);
  background:rgba(0,0,0,0.3);
  @include easeme;
}

input[type="submit"]:hover{
  opacity:1;
  cursor:pointer;
}

.name-help,.email-help{
  display:none;
  padding:0px;
  margin:0px 0px 15px 0px;
}

.optimize{
  position:fixed;
  right:3%;
  top:0px;
}
</style>
<script type="text/javascript">
$(".name").focus(function(){
  $(".name-help").slideDown(500);
}).blur(function(){
  $(".name-help").slideUp(500);
});

$(".email").focus(function(){
  $(".email-help").slideDown(500);
}).blur(function(){
  $(".email-help").slideUp(500);
});

</script>	
</head>
<?php
	 $query = "SELECT registered_ip_id FROM registered_ip WHERE ip_address='$ip' ";
	 $database  = new database();
	 $ipArray = $database->execQueryWithFetchAll( $query );

	 if(count( $ipArray) > 0) 
	 { 
	 ?><body>
<div class="wrapper">
  <h1>Your Ip Address is Already Registered</h1>
  <p>You will be Automatically Redirected to the Testing Portal Quakbox in few Seconds.</p>
</div>
 
			
</body>
</html><?php
	 header("refresh:5;url= ".$base_url."");
	 exit;
	 }
	 else
	 {
	 ?>
<body>
<div class="wrapper">
  <h1>Register Your Ip Address</h1>
  <p>Your IP address will be Registered for Testing Portal access Of Quakbox. Please Register your Name and Email ID, so that Site Administrator can contact you for Further Process.</p>
  <form class="form" action="<?php echo $base_url; ?>qb-admin/admin/secure_ip.php" method="post" id="form-login">
  <p> Your IP address is <?php echo $_SERVER['REMOTE_ADDR']; ?> </p>
    <input type="text" name="name" class="name" placeholder="Name" required >
    <div>
      <p class="name-help">Please enter your first and last name.</p>
    </div>
    <input type="email" name="email" class="email" placeholder="Email" required >
     <div>
      <p class="email-help">Please enter your current email address.</p>
    </div>
    <input type="submit" name="landing_submit" class="submit" value="Register">
  </form>
</div>
 
			
</body>
</html><?php } ?>