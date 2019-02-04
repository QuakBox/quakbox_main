<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php');
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
        <link rel="icon" href="<?php echo SITE_URL ?>/images/favicon.ico" type="image" />
        <link rel="apple-touch-icon" href="<?php echo $base_url; ?>images/apple-touch-icon.png">
    <title>Quakbox</title>    
    <?php include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_style.php'); ?>
    <script src="<?php echo $base_url; ?>js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    <?php include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_script.php'); ?>
</head>

<body>
<!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <?php if(isset($_COOKIE['lang'])){echo '<input type="hidden" name="locales" id="locales" value="'.$_COOKIE['lang'].'"/>'; }?>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
        	<a class="navbar-brand" href="#">
        	<img class="logo_img" style="display: inline-block;" src="<?php echo $base_url; ?>images/quakboxSmall.png" alt="Image of QuakBox Logo" />
        	<span class="logoText hidden-xs" style="display: inline-block;">QuakBox</span>
        	</a>
          <button type="button" data-toggle="collapse" data-target=".navbarForCollapse" aria-expanded="false" aria-controls="navbar" class="navbar-toggle collapsed  btn-warning">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div class="row">
	  <div class="col-md-2">
		  <div class="navbarForCollapse nav1 navbar-collapse collapse">
	          <?php include_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_subheader1.php'); 
	          ?>
		  </div>
	  </div>
	  <div class="col-md-3 gapp1 notification-bar">
		  <div class="" >
		     <?php include_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_subheader2.php'); 
		     ?>
		  </div>
	  </div>
	  <div class="col-md-2">
		  <div class="navbarForCollapse nav2 navbar-collapse collapse" style="width: 380px;">
		   <?php include_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_subheader3.php'); 
		     ?>
		  </div>
	  </div>
	</div>
        
	
	       
      </div>
    </nav>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <?php //if(isset($_COOKIE['lang'])){echo '<input type="hidden" name="locales" id="locales" value="'.$_COOKIE['lang'].'"/>'; }
        ?>

		