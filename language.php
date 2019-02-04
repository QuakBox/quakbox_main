<?php ob_start();
	//Start session
	session_start();	
	require_once('config.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
<title>Change Language</title>
<meta name="google-translate-customization" content="94711e700d8013d0-e27bcd5ea04a4df8-g55731a7187edbdea-10"></meta>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="imagetoolbar" content="no" />
<meta http-equiv="Cache-control" content="public">
<meta name="robots" content="noindex,nofollow">
<meta content="<?php  echo $base_url;?>is a social utility that connects people with frienï¿½links and videos, and learn more about the people they meet." name="og:description"></meta>
<meta property="og:type" content="article"/>
<meta property="og:image" content="images/quak.jpg"/>
<link rel="icon" href="images/favicon.ico" type="image" />
<link href="css/format1.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/index.css" type="text/css" />
<link rel="shortcut icon" href="images/favicon.ico" type="image" />
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
<link rel="stylesheet" href="css/notifications.css" type="text/css" />
<script src="js/jquery-1.7.2.min.js" type="text/javascript"></script>
<script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="http://microsofttranslator.com/ajax/v3/widgetv3.ashx" type="text/javascript"></script>

<script type="text/javascript">
/*function set_cookie_lacale(lang, url)
{
	document.cookie = 'lang=' + lang ;
	window.location = url;
}*/
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

</head>
<body id="lang_form">

<div class="wrapper">

<div class="mainbody">
<div class="header">
<div class="topleft"><a href="index.php"><img src="images/quack.png" width="190" height="70" /></a></div>
</div>
<div class="masterdiv">  	
  <ul class="localeSelectorList-mob">
<li><a title="Arabic" dir="ltr" href="#" onclick="set_cookie_lacale('ar','<?php  echo $base_url;?>')">العربية</a></li>
<li><a title="Bulgarian" dir="ltr" href="#" onclick="set_cookie_lacale('bg','<?php  echo $base_url;?>')">Български</a></li>
<li><a title="Catalan" dir="ltr" href="#" onclick="set_cookie_lacale('ca','<?php  echo $base_url;?>')">Català</a></li>
<li><a title="Chinese Simplified" dir="ltr" href="#" onclick="set_cookie_lacale('zh-CHS','<?php  echo $base_url;?>')">简体中文</a></li>
<li><a title="Chinese Traditional" dir="ltr" href="#" onclick="set_cookie_lacale('zh-CHT','<?php  echo $base_url;?>')">繁體中文</a></li>
<li><a title="Czech" dir="ltr" href="#" onclick="set_cookie_lacale('cs','<?php  echo $base_url;?>')">Čeština</a></li>
<li><a title="Danish" dir="ltr" href="#" onclick="set_cookie_lacale('da','<?php  echo $base_url;?>')">Dansk</a></li>
<li><a title="Dutch" dir="ltr" href="#" onclick="set_cookie_lacale('nl','<?php  echo $base_url;?>')">Nederlands</a></li>
<li><a title="English" dir="ltr" href="#" onclick="set_cookie_lacale('en','<?php  echo $base_url;?>')">English</a></li>
<li><a title="Estonian" dir="ltr" href="#" onclick="set_cookie_lacale('et','<?php  echo $base_url;?>')">Eesti</a></li>
<li><a title="Finnish" dir="ltr" href="#" onclick="set_cookie_lacale('fi','<?php  echo $base_url;?>')">Suomi</a></li>
<li><a title="French" dir="ltr" href="#" onclick="set_cookie_lacale('fr','<?php  echo $base_url;?>')">Français</a></li>
<li><a title="German" dir="ltr" href="#" onclick="set_cookie_lacale('de','<?php  echo $base_url;?>')">Deutsch</a></li>
<li><a title="Greek" dir="ltr" href="#" onclick="set_cookie_lacale('el','<?php  echo $base_url;?>')">Ελληνικά</a></li>
<li><a title="Haitian Creole" dir="ltr" href="#" onclick="set_cookie_lacale('ht','<?php  echo $base_url;?>')">Haitian Creole</a></li>
<li><a title="Hebrew" dir="ltr" href="#" onclick="set_cookie_lacale('he','<?php  echo $base_url;?>')">עברית</a></li>
<li><a title="Hindi" dir="ltr" href="#" onclick="set_cookie_lacale('hi','<?php  echo $base_url;?>')">हिंदी</a></li>
<li><a title="Hmong Daw" dir="ltr" href="#" onclick="set_cookie_lacale('mww','<?php  echo $base_url;?>')">Hmong Daw</a></li>
<li><a title="Hungarian" dir="ltr" href="#" onclick="set_cookie_lacale('hu','<?php  echo $base_url;?>')">Magyar</a></li>
<li><a title="Indonesian" dir="ltr" href="#" onclick="set_cookie_lacale('id','<?php  echo $base_url;?>')">Indonesia</a></li>
<li><a title="Italian" dir="ltr" href="#" onclick="set_cookie_lacale('it','<?php  echo $base_url;?>')">Italiano</a></li>
<li><a title="Japanese" dir="ltr" href="#" onclick="set_cookie_lacale('ja','<?php  echo $base_url;?>')">日本語</a></li>

<li><a title="Klingon" dir="ltr" href="#" onclick="set_cookie_lacale('tlh','<?php  echo $base_url;?>')">Klingon</a></li>
<li><a title="Korean" dir="ltr" href="#" onclick="set_cookie_lacale('ko','<?php  echo $base_url;?>')">한국어</a></li>
<li><a title="Latvian" dir="ltr" href="#" onclick="set_cookie_lacale('lv','<?php  echo $base_url;?>')">Latviešu</a></li>
<li><a title="Lithuanian" dir="ltr" href="#" onclick="set_cookie_lacale('lt','<?php  echo $base_url;?>')">Lietuvių</a></li>
<li><a title="Malay" dir="ltr" href="#" onclick="set_cookie_lacale('ms','<?php  echo $base_url;?>')">Melayu</a></li>
<li><a title="Maltese" dir="ltr" href="#" onclick="set_cookie_lacale('mt','<?php  echo $base_url;?>')">Il-Malti</a></li>
<li><a title="Norwegian" dir="ltr" href="#" onclick="set_cookie_lacale('no','<?php  echo $base_url;?>')">Norsk</a></li>
<li><a title="Persian" dir="ltr" href="#" onclick="set_cookie_lacale('fa','<?php  echo $base_url;?>')">Persian</a></li>
<li><a title="Polish" dir="ltr" href="#" onclick="set_cookie_lacale('pl','<?php  echo $base_url;?>')">Polski</a></li>

<li><a title="Portuguese" dir="ltr" href="#" onclick="set_cookie_lacale('pt','<?php  echo $base_url;?>')">Português</a></li>
<li><a title="Romanian" dir="ltr" href="#" onclick="set_cookie_lacale('ro','<?php  echo $base_url;?>')">Română</a></li>
<li><a title="Russian" dir="ltr" href="#" onclick="set_cookie_lacale('ru','<?php  echo $base_url;?>')">Русский</a></li>
<li><a title="Slovak" dir="ltr" href="#" onclick="set_cookie_lacale('sk','<?php  echo $base_url;?>')">Slovenčina</a></li>
<li><a title="Slovenian" dir="ltr" href="#" onclick="set_cookie_lacale('sl','<?php  echo $base_url;?>')">Slovenščina</a></li>
<li><a title="Spanish" dir="ltr" href="#" onclick="set_cookie_lacale('es','<?php  echo $base_url;?>')">Español</a></li>
<li><a title="Swedish" dir="ltr" href="#" onclick="set_cookie_lacale('sv','<?php  echo $base_url;?>')">Svenska</a></li>
<li><a title="Thai" dir="ltr" href="#" onclick="set_cookie_lacale('th','<?php  echo $base_url;?>')">ไทย</a></li>
<li><a title="Turkish" dir="ltr" href="#" onclick="set_cookie_lacale('tr','<?php  echo $base_url;?>')">Türkçe</a></li>

<li><a title="Ukrainian" dir="ltr" href="#" onclick="set_cookie_lacale('uk','<?php  echo $base_url;?>')">Українська</a></li>
<li><a title="Urdu" dir="ltr" href="#" onclick="set_cookie_lacale('ur','<?php  echo $base_url;?>')">اردو</a></li>
<li><a title="Vietnamese" dir="ltr" href="#" onclick="set_cookie_lacale('vi','<?php  echo $base_url;?>')">Tiếng Việt</a></li>
<li><a title="Welsh" dir="ltr" href="#" onclick="set_cookie_lacale('cy','<?php  echo $base_url;?>')">Welsh</a></li>
</ul>  
</div>
</div>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
<script src="js/translate_page.js" type="text/javascript"></script>
</body>
</html>
