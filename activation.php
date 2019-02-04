<?php
	//Start session
	session_start();
	if(isset($_SESSION['lang']))
	{	
		include($_SERVER['DOCUMENT_ROOT'].'/common.php');
	}
	else
	{
		include($_SERVER['DOCUMENT_ROOT'].'/Languages/en.php');
		
	}
	require_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
	require_once($_SERVER['DOCUMENT_ROOT']."/common/qb_security.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/common/qb_validation.php");
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_lookup.php');
		
        $member_id = $_GET['member_id'];
	$sql = mysqli_query($con, "select * from members where member_id='".$member_id."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);
?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <title>QuakBox</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="<?php echo $base_url; ?>images/apple-touch-icon.png">

        <link rel="stylesheet" href="<?php echo $base_url; ?>css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo $base_url; ?>css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="<?php echo $base_url; ?>assets/formvalidation/dist/css/formValidation.min.css">
        <link rel="stylesheet" href="<?php echo $base_url; ?>css/main.css">
        <script src="<?php echo $base_url; ?>js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <?php if(isset($_COOKIE['lang'])){echo '<input type="hidden" name="locales" id="locales" value="'.$_COOKIE['lang'].'"/>'; }?>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
         <img class="logo_img" style="display: inline-block;" src="<?php echo $base_url; ?>images/quakboxSmall.png" alt="Image of QuakBox Logo" />
         <span class="logoText" style="display: inline-block;">QuakBox</span>
        </div>
            
      </div>
    </nav>

    <div class="jumbotron">
       
    </div>

    <div class="container">
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-5 col-md-offset-3">
        
	    <div class="row">
		  <form enctype="multipart/form-data" action="<?php echo $base_url;?>action/registerContact-exec.php" method="post" name="regform" id="regform" class="form-horizontal" role="form">
		  <div class="panel panel-default">
		  
<?php 
	require_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
	require_once($_SERVER['DOCUMENT_ROOT']."/common/qb_security.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/common/qb_validation.php");
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_lookup.php');	
	$LookupObject = new lookup(); 		
	//error_reporting(0);
	if(empty($_REQUEST['member_id'])||empty($_REQUEST['verification_code']))
	{
	echo'<script>window.location="'.$base_url.'";</script>';
	}
	else{
	$activation_code=htmlspecialchars(trim($_REQUEST['verification_code']));
	$member_id=htmlspecialchars(trim($_REQUEST['member_id']));
if(!(empty($member_id)||($qbValidation->qbIntegerCheck($member_id))))
	{
		$qb_err_msg="Oops Something Went Wrong...!";
$QbSecurity->qbErrorMessage($qb_err_msg,$homepage);
	}
	elseif(!(empty($activation_code)||($QbSecurity->qbCheckSpecialChars($activation_code))))
	{
		$qb_err_msg="Oops Something Went Wrong...!";
$QbSecurity->qbErrorMessage($qb_err_msg,$homepage);
	}
	else
	{
	$check_query=mysqli_query($con, "SELECT * FROM `member` WHERE `member_id`='$member_id' and `activation_key`='$activation_code'");
	//echo "SELECT * FROM `members` WHERE `member_id`='$member_id' and `status_code`='$activation_code'";
	$check_row=mysqli_fetch_array($check_query);
	$table_activation_code=$check_row['activation_key'];
	$table_member_id=$check_row['member_id'];
	$email_id=$check_row['email'];
	if(($member_id==$table_member_id)&&($activation_code==$table_activation_code))
	{
	$boolflag=true;
	$lookup_id =  $LookupObject->getLookupKey("MEMBER STATUS", "ACTIVE");
	$sql = "update member set status ='$lookup_id' where member_id = '".$member_id."' and activation_key ='".$activation_code."'";
	mysqli_query($con, $sql);
include('cpanelemailreg.php');
	}
	else if(($member_id!=$table_member_id)&&($activation_code!=$table_activation_code))
	{
	$boolflag="failed";
	}
	else{
	$boolflag=false;
	}
?>
<?php
 if($boolflag=="true"){?>
 <div class="panel-heading">
		    <h3 class="panel-title">Activation Complete</h3>
		  </div>
		  <div class="panel-body">

	  	<div>
        <label>
        Your account has been successfully Activated. <br />
You can now log in username and password <br />
you choose during the registration.  
         </label>
         </div>
		<br /><br />
	<div >
	<label>
		Welcome To QUAKBOX!!<br>
		<a href="<?php echo $site_landing; ?>">Click Here For Login Page</a>
	</label></div>
	<?php }
	else if($boolflag==false){ ?>
	 <div class="panel-heading">
		    <h3 class="panel-title">VERIFY YOUR EMAIL ADDRESS</h3>
		  </div>
		  <div class="panel-body">
	  	<div>
        <label>
       We now need to verify your email address. <br />
We have sent an email to "<?php echo $email_id; ?>" verify your account. <br />
Please click the link in that email to continue.  
               </label>
              </div>
		<br /><br />
	<div >
	<label>
			<a href="<?php echo $base_url;?>action/resendmail.php?verification_code=<?php echo $activation_code;?>&member_id=<?php echo $member_id;?>">Need to resend the email? or get some help!!</a>	
	</label> </div>
	<?php }
	else if($boolflag=="failed"){ ?>
		 <div class="panel-heading">
		    <h3 class="panel-title">VERIFY YOUR ACCOUNT</h3>
		  </div>
		  <div class="panel-body">
<div>
        <label>
       We are unable to find any registration for this account.
               </label>
			   <br><br>
			   <a href="<?php echo $site_landing; ?>">Click Here For REGISTER</a>
              </div>
			<div >
	 </div>
<?php
}
else
{
header('location: '.$base_url.'login.php');
exit();
}
}	
}
if(isset($_GET['err']))
{ 
?>
<div class="panel-heading">
		    <h3 class="panel-title">ACTIVATE YOUR ACCOUNT</h3>
		  </div>
		  <div class="panel-body">
	  	<div>
        <label><br><br>
       We are sent an activation link for this account to your mail id.<br>
	   please activate your account with activation Link.
               </label>
			   <br>
			             </div>
			<div >
	 </div>
	 <?php
}
if(isset($_GET['sakdj']))
{ 
?>
<div class="panel-heading">
		    <h3 class="panel-title">MAIL SUCCESSFULLY SENT</h3>
		  </div>
		  <div class="panel-body">
	  	<div>
        <label><br><br>
       We are sent an activation link for this account to your mail id.<br>
	   please activate your account with activation Link.
               </label>
			   <br>
			             </div>
			<div >
	 </div>
	 <?php
}?>

		  
		  
		  </div>
		  <div class="panel-footer">
		  
		  </div>
		  </div> 
		</form>
	    </div>
	    
	    
	  
        </div>
      </div>
      <hr>

      <footer>
        <div id="pagefooter_maindiv" class="inline ">
           
       <div class="locales1 ">
<div class="locales text-center">
<ul class="uilist localesSelectorList _4ki list-inline">
<li><a title="Arabic" dir="ltr" href="#" onclick="set_cookie_lacale('ar','<?php echo $base_url;?>getting_started_import.php')">العربية</a></li>
<li><a title="Bulgarian" dir="ltr" href="#" onclick="set_cookie_lacale('bg','<?php echo $base_url;?>getting_started_import.php')">Български</a></li>
<li><a title="Catalan" dir="ltr" href="#" onclick="set_cookie_lacale('ca','<?php echo $base_url;?>getting_started_import.php')">Català</a></li>
<li><a title="Chinese Simplified" dir="ltr" href="#" onclick="set_cookie_lacale('zh-CHS','<?php echo $base_url;?>getting_started_import.php')">简体中文</a></li>
<li><a title="Chinese Traditional" dir="ltr" href="#" onclick="set_cookie_lacale('zh-CHT','<?php echo $base_url;?>getting_started_import.php')">繁體中文</a></li>
<li><a title="Czech" dir="ltr" href="#" onclick="set_cookie_lacale('cs','<?php echo $base_url;?>getting_started_import.php')">Čeština</a></li>
<li><a title="Danish" dir="ltr" href="#" onclick="set_cookie_lacale('da','<?php echo $base_url;?>getting_started_import.php')">Dansk</a></li>
<li><a title="Dutch" dir="ltr" href="#" onclick="set_cookie_lacale('nl','<?php echo $base_url;?>getting_started_import.php')">Nederlands</a></li>
<li><a title="English" dir="ltr" href="#" onclick="set_cookie_lacale('en','<?php echo $base_url;?>getting_started_import.php')">English</a></li>
<li><a title="Estonian" dir="ltr" href="#" onclick="set_cookie_lacale('et','<?php echo $base_url;?>getting_started_import.php')">Eesti</a></li>
<li><a title="Finnish" dir="ltr" href="#" onclick="set_cookie_lacale('fi','<?php echo $base_url;?>getting_started_import.php')">Suomi</a></li>
<li><a title="French" dir="ltr" href="#" onclick="set_cookie_lacale('fr','<?php echo $base_url;?>getting_started_import.php')">Français</a></li>
<li><a data-toggle="modal" style="cursor:pointer;" title="More languages" data-target="#showMoreLocale">...</a>
</li>
</ul>

<div id="showMoreLocale" class="modal fade" role="dialog" >
<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $lang['Select a Language'];?></h4>
      </div>
<ul class="localeSelectorList uiList _4kg list-inline">
<li><a title="Arabic" dir="ltr" href="#" onclick="set_cookie_lacale('ar','<?php echo $base_url;?>getting_started_import.php')">العربية</a></li>
<li><a title="Bulgarian" dir="ltr" href="#" onclick="set_cookie_lacale('bg','<?php echo $base_url;?>getting_started_import.php')">Български</a></li>
<li><a title="Catalan" dir="ltr" href="#" onclick="set_cookie_lacale('ca','<?php echo $base_url;?>getting_started_import.php')">Català</a></li>
<li><a title="Chinese Simplified" dir="ltr" href="#" onclick="set_cookie_lacale('zh-CHS','<?php echo $base_url;?>getting_started_import.php')">简体中文</a></li>
<li><a title="Chinese Traditional" dir="ltr" href="#" onclick="set_cookie_lacale('zh-CHT','<?php echo $base_url;?>getting_started_import.php')">繁體中文</a></li>
<li><a title="Czech" dir="ltr" href="#" onclick="set_cookie_lacale('cs','<?php echo $base_url;?>getting_started_import.php')">Čeština</a></li>
<li><a title="Danish" dir="ltr" href="#" onclick="set_cookie_lacale('da','<?php echo $base_url;?>getting_started_import.php')">Dansk</a></li>
<li><a title="Dutch" dir="ltr" href="#" onclick="set_cookie_lacale('nl','<?php echo $base_url;?>getting_started_import.php')">Nederlands</a></li>
<li><a title="English" dir="ltr" href="#" onclick="set_cookie_lacale('en','<?php echo $base_url;?>getting_started_import.php')">English</a></li>
<li><a title="Estonian" dir="ltr" href="#" onclick="set_cookie_lacale('et','<?php echo $base_url;?>getting_started_import.php')">Eesti</a></li>
<li><a title="Finnish" dir="ltr" href="#" onclick="set_cookie_lacale('fi','<?php echo $base_url;?>getting_started_import.php')">Suomi</a></li>
<li><a title="French" dir="ltr" href="#" onclick="set_cookie_lacale('fr','<?php echo $base_url;?>getting_started_import.php')">Français</a></li>
<li><a title="German" dir="ltr" href="#" onclick="set_cookie_lacale('de','<?php echo $base_url;?>getting_started_import.php')">Deutsch</a></li>
<li><a title="Greek" dir="ltr" href="#" onclick="set_cookie_lacale('el','<?php echo $base_url;?>getting_started_import.php')">Ελληνικά</a></li>
<li><a title="Haitian Creole" dir="ltr" href="#" onclick="set_cookie_lacale('ht','<?php echo $base_url;?>getting_started_import.php')">Haitian Creole</a></li>
<li><a title="Hebrew" dir="ltr" href="#" onclick="set_cookie_lacale('he','<?php echo $base_url;?>getting_started_import.php')">עברית</a></li>
<li><a title="Hindi" dir="ltr" href="#" onclick="set_cookie_lacale('hi','<?php echo $base_url;?>getting_started_import.php')">हिंदी</a></li>
<li><a title="Hmong Daw" dir="ltr" href="#" onclick="set_cookie_lacale('mww','<?php echo $base_url;?>getting_started_import.php')">Hmong Daw</a></li>
<li><a title="Hungarian" dir="ltr" href="#" onclick="set_cookie_lacale('hu','<?php echo $base_url;?>getting_started_import.php')">Magyar</a></li>
<li><a title="Indonesian" dir="ltr" href="#" onclick="set_cookie_lacale('id','<?php echo $base_url;?>getting_started_import.php')">Indonesia</a></li>
<li><a title="Italian" dir="ltr" href="#" onclick="set_cookie_lacale('it','<?php echo $base_url;?>getting_started_import.php')">Italiano</a></li>
<li><a title="Japanese" dir="ltr" href="#" onclick="set_cookie_lacale('ja','<?php echo $base_url;?>getting_started_import.php')">日本語</a></li>

<li><a title="Klingon" dir="ltr" href="#" onclick="set_cookie_lacale('tlh','<?php echo $base_url;?>getting_started_import.php')">Klingon</a></li>
<li><a title="Korean" dir="ltr" href="#" onclick="set_cookie_lacale('ko','<?php echo $base_url;?>getting_started_import.php')">한국어</a></li>
<li><a title="Latvian" dir="ltr" href="#" onclick="set_cookie_lacale('lv','<?php echo $base_url;?>getting_started_import.php')">Latviešu</a></li>
<li><a title="Lithuanian" dir="ltr" href="#" onclick="set_cookie_lacale('lt','<?php echo $base_url;?>getting_started_import.php')">Lietuvių</a></li>
<li><a title="Malay" dir="ltr" href="#" onclick="set_cookie_lacale('ms','<?php echo $base_url;?>getting_started_import.php')">Melayu</a></li>
<li><a title="Maltese" dir="ltr" href="#" onclick="set_cookie_lacale('mt','<?php echo $base_url;?>getting_started_import.php')">Il-Malti</a></li>
<li><a title="Norwegian" dir="ltr" href="#" onclick="set_cookie_lacale('no','<?php echo $base_url;?>getting_started_import.php')">Norsk</a></li>
<li><a title="Persian" dir="ltr" href="#" onclick="set_cookie_lacale('fa','<?php echo $base_url;?>getting_started_import.php')">Persian</a></li>
<li><a title="Polish" dir="ltr" href="#" onclick="set_cookie_lacale('pl','<?php echo $base_url;?>getting_started_import.php')">Polski</a></li>

<li><a title="Portuguese" dir="ltr" href="#" onclick="set_cookie_lacale('pt','<?php echo $base_url;?>getting_started_import.php')">Português</a></li>
<li><a title="Romanian" dir="ltr" href="#" onclick="set_cookie_lacale('ro','<?php echo $base_url;?>getting_started_import.php')">Română</a></li>
<li><a title="Russian" dir="ltr" href="#" onclick="set_cookie_lacale('ru','<?php echo $base_url;?>getting_started_import.php')">Русский</a></li>
<li><a title="Slovak" dir="ltr" href="#" onclick="set_cookie_lacale('sk','<?php echo $base_url;?>getting_started_import.php')">Slovenčina</a></li>
<li><a title="Slovenian" dir="ltr" href="#" onclick="set_cookie_lacale('sl','<?php echo $base_url;?>getting_started_import.php')">Slovenščina</a></li>
<li><a title="Spanish" dir="ltr" href="#" onclick="set_cookie_lacale('es','<?php echo $base_url;?>getting_started_import.php')">Español</a></li>
<li><a title="Swedish" dir="ltr" href="#" onclick="set_cookie_lacale('sv','<?php echo $base_url;?>getting_started_import.php')">Svenska</a></li>
<li><a title="Thai" dir="ltr" href="#" onclick="set_cookie_lacale('th','<?php echo $base_url;?>getting_started_import.php')">ไทย</a></li>
<li><a title="Turkish" dir="ltr" href="#" onclick="set_cookie_lacale('tr','<?php echo $base_url;?>getting_started_import.php')">Türkçe</a></li>

<li><a title="Ukrainian" dir="ltr" href="#" onclick="set_cookie_lacale('uk','<?php echo $base_url;?>getting_started_import.php')">Українська</a></li>
<li><a title="Urdu" dir="ltr" href="#" onclick="set_cookie_lacale('ur','<?php echo $base_url;?>getting_started_import.php')">اردو</a></li>
<li><a title="Vietnamese" dir="ltr" href="#" onclick="set_cookie_lacale('vi','<?php echo $base_url;?>getting_started_import.php')">Tiếng Việt</a></li>
<li><a title="Welsh" dir="ltr" href="#" onclick="set_cookie_lacale('cy','<?php echo $base_url;?>getting_started_import.php')">Welsh</a></li>
</ul>
<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      </div><!-- Modal content-->
</div><!-- Modal dialog-->

</div><!--showMoreLocale-->
</div><!--locales-->


</div><!--locales1-->
</div><!--pagefooter_maindiv-->
      </footer>
    </div> <!-- /container -->       
        <script src="<?php echo $base_url; ?>js/vendor/jquery-1.11.2.min.js"></script>
	<script src="<?php echo $base_url; ?>js/vendor/bootstrap.min.js"></script>
	<script src="<?php echo $base_url; ?>js/plugins.js"></script>
        <script src="<?php echo $base_url; ?>js/main.js"></script>
        <script src="<?php echo $base_url; ?>assets/formvalidation/dist/js/formValidation.min.js"></script>
	<script src="<?php echo $base_url; ?>assets/formvalidation/dist/js/framework/bootstrap.min.js"></script>
	<script src="https://microsofttranslator.com/ajax/v3/widgetv3.ashx" type="text/javascript"></script>
	<script src="<?php echo $base_url; ?>js/translate_page.js" type="text/javascript"></script>
	<script src="<?php echo $base_url; ?>js/selectBox/jquery.selectBox.js" type="text/javascript"></script>
            
<script type="text/javascript">
function set_cookie_lacale(lang, url)
{

     $.ajax({
            type: "POST",
            url: "lang.php",
            data: {lang:lang},
            cache: false,
            success: function (html) {
               $("#lang").html(html);
               document.cookie = 'lang=' + lang ;
	window.location = url;
            }
        });
	
}
</script>
    </body>
</html>
<?php
/**
   * activation.php helps to activate user account
   * 
   * @author     Quakbox
   * Updated by    Abhinav
 **/
 ?>
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>QuakBox</title>
<link rel="icon" href="images/favicon.ico" type="image" />
<link rel="shortcut icon" href="images/favicon.ico" type="image" />
<link href="css/format1.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/reset.css" type="text/css" />
<link rel="stylesheet" href="css/master.css" type="text/css" />
<link rel="stylesheet" href="css/index.css" type="text/css" />
</head>
<body>
<div class="wrapper">
<div class="mainbody">
  <div class="header" class="msheght">
  <div class="topleft"><img src="images/quack.png" width="190" height="70" /></div>
 </div>
  
     </div><!--end mainbody div-->
 <?php include('includes/footer.php');?>
 </div><!--end wrapper div--> 
 
</body>
</html>