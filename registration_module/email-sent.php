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

    <!-- Main jumbotron for a primary marketing message or call to action  -->
    <div class="jumbotron">
    </div>

    <div class="container">
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-5 col-md-offset-3">
        <div class="panel panel-default">
	  <div class="panel-heading" role="alert">
	    <h3 class="panel-title  alert alert-success"><?php echo $lang['Email successfully sent'];?></h3>
	  </div>
	  <div class="panel-body">
	    <div class="row">
		  <div class="col-lg-12">
		  	<h5><?php echo $lang["email sent message"];?></h5>
		  </div>
	    </div>
	  </div>
	  <div class="panel-footer">
	  <a href="<?php echo $base_url;?>reset_password.php" class="btn btn-danger" ><?php echo $lang["I didn't receive any reset email"];?></a>	
	  </div>
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
	<script src="https://microsofttranslator.com/ajax/v3/widgetv3.ashx" type="text/javascript"></script>
	<script src="<?php echo $base_url; ?>js/translate_page.js" type="text/javascript"></script>      
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