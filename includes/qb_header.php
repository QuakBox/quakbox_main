<?php
	$base_url = 'https://qbtest.quakbox.com/'; 
    include_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_misc.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/friends_request_notification.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/view_notification.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_security.php');

	if (!isset($_SESSION['SESS_MEMBER_ID']) || $_SESSION['SESS_MEMBER_ID'] == 0) {
		$loggedIn = false;
	}else{
		$loggedIn = true;
	}
    $logged_in_member_id_header1 = $_SESSION['SESS_MEMBER_ID'];
    $objMemberHeader1 = new member1(); 

    $currentMemberResultHeader1=$objMemberHeader1->select_member_byID($logged_in_member_id_header1);
    $currentMemberResultHeader1ProfileLogo=$objMemberHeader1->select_member_meta_value($logged_in_member_id_header1,'current_profile_image');

    $currentUserProfilePic='';
    if($currentMemberResultHeader1ProfileLogo){			
       $currentUserProfilePic=SITE_URL.'/'.$currentMemberResultHeader1ProfileLogo.'?'.time();	
    }
    else
    {
            $currentUserProfilePic=SITE_URL.'/images/default.png';
    }


    $objMisc = new misc();  

    $member = new Member();
    $member_user_name = $member->get_username_by_id($_SESSION['SESS_MEMBER_ID']);


    $randomCountriesResult=$objMisc->getRandom3countries();
    $randomCountries='';
    foreach($randomCountriesResult as $valueRandomCountries){
           
            $randomCountries .='<a class="thumbnail headerflagthumbs pop hidden-xs" style="margin-right:3px;padding:0px;display:inline-block;margin-bottom:0px;" href="'.SITE_URL.'/country/'.$valueRandomCountries['code'].'"';
            $randomCountries .= ' data-toggle="popover" data-trigger="hover" data-container="body" title="All Countries"';
            $randomCountries .='>';
            $randomCountries .='<i class="sprite sprite-'.strtolower($valueRandomCountries['code']).'" style="min-height:10px;"></i>';
            $randomCountries .='<span style="font-size:9px;">'.substr($valueRandomCountries['country_title'],0,6).'</span>';
            $randomCountries .='</a>';

    }
    $allCountriesResult=$objMisc->getallcountries();
    $iMaxCols=6;
    $rowscount = count($allCountriesResult);
    $allCountries='';
    //$allCountries .='<table style="width: 100%;">';
    $allCountries .='<ul class="dropdown-menu scrollable-menu" role="menu" aria-labelledby="dropdownMenu1" style="background: #FFF none repeat scroll 0% 0%;">';
    foreach($allCountriesResult as $valueAllCountries){
            $country_name1 = str_replace(' ', '-', $valueAllCountries['country_title']);
            $allCountries .='<li>';
            $allCountries .='<a href="'.SITE_URL.'/country/'.$valueAllCountries['code'].'" >';
            $allCountries .='<i class="sprite sprite-'.strtolower($valueAllCountries['code']).'"></i>';
            $allCountries .='<label style="font-size: 14px; margin-top:4px; color:#000000;">'.$valueAllCountries["country_title"].'</label>';
            $allCountries .='</a>';
            $allCountries .='</li>';
    }

    $allCountries .='</ul>';
    
    // Countries div to be viewed in the popover when hover on country
    $popover_countries = '';
    $popover_countries .='<div class="row"><div class="col-md-12"><form style="box-sizing: border-box; padding: 10px 10px 10px 20px;"><input class="form-control"  type="text" id="filter_country" name="search" value="" placeholder="Filter by Name" autocomplete="off"></form></div></div>';
    foreach($allCountriesResult as $valueCountries){
            $popover_countries .='<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">';
            $popover_countries .='<a href="'.SITE_URL.'/country/'.$valueCountries['code'].'" >';
            $popover_countries .='<img src="'.SITE_URL.'/images/Flags/flags_new/195x120flags/'.strtolower($valueCountries['code']).'.png"'." title=" .$valueCountries["country_title"].' height="36" style="border:0px none; background: none repeat scroll 0% 0% transparent;" />';
            $popover_countries .='<br/>';
            $popover_countries .='<span class="filter-country-name" style="white-space: nowrap; font-size:10px;">'.substr($valueCountries['country_title'],0,6).'</span>';
            $popover_countries .='</a>';
            $popover_countries .='</div>';
    }

    
    
$objFriendsRequest = new friendsRequestNotificationWidget(); 
$objViewNotification = new viewNotificationWidget(); 
$currentUsername='';
while($clMember = mysqli_fetch_array($currentMemberResultHeader1))
{
    $currentUsername=$clMember['username'];	
}


// Get User Favourite Countries
$favarioteCountriesResult=$objMisc->getFavCountry($logged_in_member_id_header1);
$favCountries='';
foreach($favarioteCountriesResult as $valueFavCountries)
{
    $favCountries .='<a class="thumbnail headerflagthumbs" style="margin-right:3px;padding:0px;display:inline-block;margin-bottom:0px;" href="'.SITE_URL.'/country/'.$valueFavCountries['code'].'" >';
    $favCountries .='<i class="sprite sprite-'.strtolower($valueFavCountries['code']).'" style="min-height:18px;"></i>';
    $favCountries .='<span style="font-size:9px;">'.substr($valueFavCountries['country_title'],0,6).'</span>';
    $favCountries .='</a>';	
}


?>







<!doctype html>
    <!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
    <!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
    <!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
    <!--[if gt IE 8]><!--> 
<html> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <title>QuakBox</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link rel="icon" href="<?php echo SITE_URL ?>/images/favicon.ico" type="image" />
        <link rel="apple-touch-icon" href="<?php echo $base_url; ?>images/apple-touch-icon.png">
        <?php include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_style.php'); ?>
        <link href="<?php echo $base_url;?>css/qb_custom_style.css" type="text/css"rel="stylesheet" media="screen"/>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.3.2/css/bootstrap-responsive.css" rel="stylesheet" media="screen" />
        
        <script src="<?php echo $base_url; ?>js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <?php include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_script.php'); ?>

        

<!-- Script for making the notifications read using Ajax -->
<script>
    $(document).ready(function(){
        $("#notifications_icon").click(function(){
            $.ajax( {
            type : "POST",
            url : "action/see_all_notifications.php"
            });
            
            $("#noti_bubble").hide();
            
        });
    });
</script>


<!-- Script for the countries panel when hover on random country  -->
<script>
$(document).ready(function(){
$(".pop").popover({ 
        html:true,
        trigger: 'manual',
        animate: false,
        placement: 'bottom',
        content: function () 
        {
            return '<?php echo $popover_countries; ?>';
        }
        })
    .on("mouseenter", function () {
        var _this = this;
        $(this).popover("show");
        $(".popover").on("mouseleave", function () {
            $(_this).popover('hide');
        });
    }).on("mouseleave", function () {
        var _this = this;
        setTimeout(function () {
            if (!$(".popover:hover").length) {
                $(_this).popover("hide");
            }
        }, 300);
});
});
</script>


<!-- Script for images tool tip -->
<script>
$(document).ready(function(){
$('[data-toggle="tooltip"]').tooltip(); 
});
</script>




    <style>
    /* CSS for the user drop down list */
    .navbar-login
    {
        width: 305px;
        padding: 10px;
        padding-bottom: 0px;
    }

    .navbar-login-session
    {
        padding: 10px;
        padding-bottom: 0px;
        padding-top: 0px;
    }

    .icon-size
    {
        font-size: 87px;
    }
    </style>

    <style>
        .hidden-desktop { display: inherit !important; }
    </style>

    
    <!-- Style for the popover of the random countries -->
    <style>
        .popover {
            position: absolute;
            top: 0;
            left: 0;
            z-index: 1010;
            display: none;
            max-width: 1000px;
            /*min-width: 1000px;*/
            max-height:600px;
            height:auto;
            padding: 1px;
            text-align: left;
            white-space: normal;
            background-color: #ffffff;
            border: 1px solid #ccc;
            border: 1px solid rgba(0, 0, 0, 0.2);
            -webkit-border-radius: 6px;
               -moz-border-radius: 6px;
                    border-radius: 6px;
            -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
               -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
                    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            -webkit-background-clip: padding-box;
               -moz-background-clip: padding;
                    background-clip: padding-box;
          }
          
          .popover-content 
          {
            overflow-y: scroll;
            height:95%
          }
    </style>
    
    
    
<style >
#noti_Container {
    position:relative;     /* This is crucial for the absolutely positioned element */
    /*border:1px solid blue;*/ /* This is just to show you where the container ends */
    width:16px;
    height:16px;
}
.noti_bubble {
    position:absolute;    /* This breaks the div from the normal HTML document. */
    top: 2px;
    right:12px;
    padding:1px 2px 1px 2px;
    background-color:red; /* you could use a background image if you'd like as well */
    color:white;
    font-weight:bold;
    font-size:0.55em;

    /* The following is CSS3, but isn't crucial for this technique to work. */
    /* Keep in mind that if a browser doesn't support CSS3, it's fine! They just won't have rounded borders and won't have a box shadow effect. */
    /* You can always use a background image to produce the same effect if you want to, and you can use both together so browsers without CSS3 still have the rounded/shadow look. */
    border-radius:30px;
    box-shadow:1px 1px 1px gray;
}
</style>

<!-- Style for the header Icons  -->


<style>  
.HeaderIcon
{
    text-align: center;
}
.HeaderIconAnchor
{
    background-image:non!important;
}
.navbar-inverse .navbar-nav>.open>a, .navbar-inverse .navbar-nav>.active>a 
{
    background-image: -webkit-linear-gradient(top,#080808 0,#ccc 20%);
    background-image: -o-linear-gradient(top,#080808 0,#ccc 20%);
    background-image: -webkit-gradient(linear,left top,left bottom,from(#ccc),to(#ccf));
    background-image: linear-gradient(to bottom,#ccc 0,#ccc 20%);
}

/* Icons Font Size*/
/*Size#1 Tablet and Phone (xs) */
@media only screen and (max-width: 767px)
{
    .search-bar
    {
        width:300px!important;
    }
    
}

/*Size#2 from 768px to 900px */
@media (min-width: 768px) and (max-width: 900px) 
{
    .HeaderIconAnchor
    {
        padding-left: 2px!important;
        padding-right: 2px!important;
    }
    .HeaderIconImage
    {
       height: 15px;
       width: 15px;
       font-size: 15px;
    }
    .search-bar
    {
        width: 200px!important;
    }
    .qb-logo
    {
        width:15%!important;
    }
    .qb-logo-img
    {
       width: 20px !important;
       height:20px !important; 
    }
    .qb-logo-txt
    {
        font-size: 15px!important;
    }
    .header-profile-image
    {
        
        height: 30px;
    }
        .noti_bubble 
    {
    top: 2px;
    right:0px;
    }
    
}

/*Size#3 from 901px to 1100px */
@media (min-width: 901px) and (max-width: 1100px) 
{
    .HeaderIconAnchor
    {
        padding-left: 3px!important;
        padding-right: 3px!important;
    }
    .HeaderIconImage
    {
       height: 18px;
       width: 18px;
       font-size: 18px;
    }
    .search-bar
    {
        width: 250px!important;
    }
    .qb-logo
    {
        width: 17%!important;
    }
    .qb-logo-img
    {
       width: 25px !important;
       height:25px !important; 
    }
    .qb-logo-txt
    {
        font-size: 21px;
    }
    .header-profile-image
    {
        
        height: 35px;
    }
    .noti_bubble 
    {
    top: 2px;
    right:0px;
    }
}

/*Size#4  1101px to 1300px*/
@media (min-width: 1101px) and (max-width: 1300px)
{
    .HeaderIconAnchor
    {
        padding-left: 8px!important;
        padding-right: 8px!important;
    }
    .HeaderIconImage
    {
       height: 20px;
       width: 20px;
       font-size: 20px;
       
    }
    .search-bar
    {
        width: 300px!important;
    }
    .qb-logo
    {
        width: 18%!important;
    }
    .qb-logo-img
    {
       width: 30px !important;
       height:30px !important; 
    }
    .qb-logo-txt
    {
        font-size: 27px;
    }
    .header-profile-image
    {
        max-height: 43px;
        
    }
    .noti_bubble 
    {
    top: 2px;
    right:12px;
    }
}

/*Size#4 > 1300px*/
@media (min-width: 1301px)
{
    .HeaderIconAnchor
    {
        padding-left: 18px!important;
        padding-right: 18px!important;
    }
    .HeaderIconImage
    {
       height: 20px;
       width: 20px;
       font-size: 20px;
       
    }
    .search-bar
    {
        width: 300px!important;
    }
    .qb-logo
    {
        width: 14%!important;
    }
    .qb-logo-img
    {
       width: 30px !important;
       height:30px !important; 
    }
    .qb-logo-txt
    {
        font-size: 27px;
    }
    .header-profile-image
    {
        max-height: 43px;
        
    }
}

.navbar .container > .navbar-header {
    background-color: #cccccc;
    border-bottom: 5px solid rgb(79, 112, 209);
    border-color: rgb(79, 112, 209);
    padding-right: 5px;
    margin-right: 5px;
}

@media screen and (max-width: 740px) {
    .navbar.navbar-inverse .navbar-toggle:hover {
        background: rgb(55, 86, 178);
    }

    .navbar.navbar-inverse .navbar-toggle {
        border: none;
        border-radius: 0;
    }

    .navbar .container > .navbar-header {
        /*background: rgb(79, 112, 209) !important;*/
        /*border-bottom: 0;*/
    }

    li.qb-logo {
        display: none;
    }

    li.random-flag-list {
        display: none;
    }

    #main-menubar li.HeaderIcon.open .dropdown-menu {
        position: fixed;
        width: 100%;
        left: 0;
        top: 54px;
        z-index: 100000;
        background: #fff;
        overflow: hidden;
        box-shadow: 0 2px 3px rgba(0, 0, 0, 0.4);
    }
    #main-menubar li.HeaderIcon > a {
        height: 55px;
    }
    #main-menubar li.HeaderIcon.open > a {
        display: inline-block;
    }
    #main-menubar li.HeaderIcon .tooltip {
        display: none !important;
        visibility: hidden;
    }
    #main-menubar {
        position: fixed;
        left: 10px;
        top: -7px;
        width: 80%;
    }
    ul.dropdown-menu.dropMenu1 {
        min-width: 100% !important;
    }
    #main-menubar ul.nav.navbar-nav.right-navbar-nav.ulHeader {
        width: 95% !important;
    }

    #main-menubar ul.nav.navbar-nav.right-navbar-nav.ulHeader li {
        float: left;
    }
    #main-menubar ul.nav.navbar-nav.right-navbar-nav.ulHeader img {
        height: auto;
        width: 20px;
    }
    #main-menubar {
        width: 83%;
    }
    #main-menubar li.HeaderIcon > a {
        padding-top: 13px;
        height: 59px;
    }
    .nav > li.mainmenu-settings {
        display: none !important;
    }
    #main-menubar li.HeaderIcon.favorite-countries-item a {
        padding-top: 14px !important;
    }
}
@media screen and (max-width: 650px) {
    #main-menubar ul.nav.navbar-nav.right-navbar-nav.ulHeader > li {
        margin-left: 4%;
        margin-right: 4%;
    }
}
@media screen and (max-width: 510px) {
    #main-menubar ul.nav.navbar-nav.right-navbar-nav.ulHeader > li {
        margin-left: 3%;
        margin-right: 3%;
    }
}
@media screen and (max-width: 414px) {
    #main-menubar ul.nav.navbar-nav.right-navbar-nav.ulHeader > li {
        margin-left: 3%;
        margin-right: 2%;
    }
}
@media screen and (max-width: 375px) {
    #main-menubar ul.nav.navbar-nav.right-navbar-nav.ulHeader > li {
        margin-left: 2%;
        margin-right: 1%;
    }
}
@media screen and (max-width: 374px) {
    #main-menubar ul.nav.navbar-nav.right-navbar-nav.ulHeader > li {
        margin-left: 0;
        margin-right: 0;
    }
}
</style>
    
</head>

    <body style="padding-left:0px!important; padding-right:0px!important; margin-left:0px !important; margin-right:0px !important;">
    <!--[if lt IE 8]>
                <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    <?php if(isset($_COOKIE['lang'])){echo '<input type="hidden" name="locales" id="locales" value="'.$_COOKIE['lang'].'"/>'; }?>
    <div class="navbar navbar-inverse navbar-fixed-top" style="background-image:non!important; background-color: #cccccc;position: fixed;z-index: 9999;left: 0;right: 0;">
        <div class="container" style="width:100%!important">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
<!-- Developed by Naresh Shaw -->
            <!-- Header on Mobile -->
            <div class="visible-xs hidden-sm hidden-md hidden-lg hidden-xl-down" >
                <ul class=" nav navbar-collapse collapse" style="background: #cccccc;border-color:#cccccc; ">
                    <li><a href="/home"><i style="font-size: 15px;color: white;" class="glyphicon glyphicon-globe"></i> World</a></li>
                    <li><a href="/i/<?php echo $member_user_name; ?>"><img src="<?php echo $currentUserProfilePic;?>" style="height: 20px;width: 20px; padding-right: 3px;"/><?php echo $member_user_name; ?></a></li>
                    <li><a href="/my_countries.php"><img src="<?php echo SITE_URL;?>/images/header_icons/add-heart.png" style="width:20px;height: 20px; padding-right: 3px;" />Favorite Countries</a></li>
                    <li><a href="/countries.php"><img src="<?php echo SITE_URL;?>/images/ImageAllCountries3.png" style="width:20px;height: 20px; padding-right: 3px;" />All Countries</a></li>
                    <li><a href="/messages.php"><img style="height: 20px;width: 20px; padding-right: 3px;" class="media-object" alt="Messages" src="<?php echo SITE_URL.'/';?>images/header_icons/messages.png" />Messages</a></li>
                    <li><a href="/notifications.php"><img style="height: 20px; width: 20px; padding-right: 3px;" class="media-object" alt="Notification" src="<?php echo SITE_URL.'/';?>images/header_icons/notification.png" />Notifications</a></li>
                    <li><a href="/friends/<?php echo $member_user_name; ?>"><img style="height: 20px;width: 20px; padding-right: 3px;" alt="Friend Request" src="<?php echo SITE_URL.'/';?>images/header_icons/add-friend.png" />Friend Requests</a></li>
                    <li><a href="/report_issue.php"><img style="height: 20px;width: 20px; padding-right: 3px;" class="media-object" alt="Report Issue" src="<?php echo SITE_URL.'/';?>images/header_icons/bug.png" />Report an Issue</a></li>
                    <li><a href="/profile.php"><img style="height: 20px;width: 20px; padding-right: 3px;" class="media-object" alt="profile" src="<?php echo SITE_URL.'/';?>images/header_icons/add-friend.png" />Profile</a></li>
					<li><a href="/account_settings.php"><img style="height: 20px;width: 20px; padding-right: 3px;" class="media-object" alt="Account Settings" src="<?php echo SITE_URL.'/';?>images/ImageAccountSettings3.png" />Account Settings</a></li>
                    <li><a href="/privacy.php"><img style="height: 20px;width: 20px; padding-right: 3px;" class="media-object" alt="Privacy Settings" src="<?php echo SITE_URL.'/';?>images/ImagePrivecySeetings3.png" />Privacy Settings</a></li>
                    <li><a href="/logout.php"><img style="height: 20px;width: 20px; padding-right: 3px;" class="media-object" alt="Logout" src="<?php echo SITE_URL.'/';?>images/ImageLogout3.png" />Logout</a></li>
                </ul>
            </div>
            <?php /*
            <div class="navbar-header" style="background-color: #cccccc; border-bottom: 5px solid rgb(79,112,209); border-color:rgb(79,112,209);padding-right:5px;margin-right:5px;">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Search Bar in mobile -->
                <form>
                    <input class="hidden-xl hidden-lg hidden-md hidden-sm visible-xs form-control search" data-placement="bottom" style= "height: 25px;width: 250px; padding-bottom: 10px;margin-left: 40px;margin-top: 15px;z-index: 15001;" type="text" name="search" value="" placeholder="<?php echo $lang['search'];?>" autocomplete="off">
                </form>
                <div id="divResult" class="dropdown" style="background-color: white;margin-left: 40px;position:absolute; z-index:10001; "> </div>
            </div>

            <!-- Header on Mobile -->
            <div class="visible-xs hidden-sm hidden-md hidden-lg hidden-xl-down" >
                <ul class=" nav navbar-collapse collapse" style="background: #cccccc;border-color:#cccccc; ">
                    <li><a href="/home"><i style="font-size: 15px;color: white;" class="glyphicon glyphicon-globe"></i> World</a></li>
                    <li><a href="/i/<?php echo $member_user_name; ?>"><img src="<?php echo $currentUserProfilePic;?>" style="height: 20px;width: 20px; padding-right: 3px;"/><?php echo $member_user_name; ?></a></li>
                    <li><a href="/my_countries.php"><img src="<?php echo SITE_URL;?>/images/header_icons/add-heart.png" style="width:20px;height: 20px; padding-right: 3px;" />Favorite Countries</a></li>
                    <li><a href="/countries.php"><img src="<?php echo SITE_URL;?>/images/ImageAllCountries3.png" style="width:20px;height: 20px; padding-right: 3px;" />All Countries</a></li>
                    <li><a href="/messages.php"><img style="height: 20px;width: 20px; padding-right: 3px;" class="media-object" alt="Messages" src="<?php echo SITE_URL.'/';?>images/header_icons/messages.png" />Messages</a></li>
                    <li><a href="/notifications.php"><img style="height: 20px; width: 20px; padding-right: 3px;" class="media-object" alt="Notification" src="<?php echo SITE_URL.'/';?>images/header_icons/notification.png" />Notifications</a></li>
                    <li><a href="/friends/<?php echo $member_user_name; ?>"><img style="height: 20px;width: 20px; padding-right: 3px;" alt="Friend Request" src="<?php echo SITE_URL.'/';?>images/header_icons/add-friend.png" />Friend Requests</a></li>
                    <li><a href="/report_issue.php"><img style="height: 20px;width: 20px; padding-right: 3px;" class="media-object" alt="Report Issue" src="<?php echo SITE_URL.'/';?>images/header_icons/bug.png" />Report an Issue</a></li>
                    <li><a href="/account_settings.php"><img style="height: 20px;width: 20px; padding-right: 3px;" class="media-object" alt="Account Settings" src="<?php echo SITE_URL.'/';?>images/ImageAccountSettings3.png" />Account Settings</a></li>
                    <li><a href="/privacy.php"><img style="height: 20px;width: 20px; padding-right: 3px;" class="media-object" alt="Privacy Settings" src="<?php echo SITE_URL.'/';?>images/ImagePrivecySeetings3.png" />Privacy Settings</a></li>
                    <li><a href="/logout.php"><img style="height: 20px;width: 20px; padding-right: 3px;" class="media-object" alt="Logout" src="<?php echo SITE_URL.'/';?>images/ImageLogout3.png" />Logout</a></li>
                </ul>
            </div>
            */ ?>

<!-- Header on Desktop -->
<div class="visible-xs visible-sm visible-md visible-lg visible-xl" width="100%" id="main-menubar">
    <div style="position:absolute;left:3%;width:100%!important;">
        <ul class="nav navbar-nav right-navbar-nav ulHeader" style="width:100%!important" >  
            
            <!-- Brand Logo -->  
            <li class="qb-logo">
            <a class="navbar-brand" href="/home">
                <img class="qb-logo-img logo_img" style="display: inline-block; vertical-align:middle;" src="<?php echo $base_url; ?>images/quakboxSmall.png"  alt="Image of QuakBox Logo" />
                <span class="qb-logo-txt logoText" style="display: inline-block;">QuakBox</span>
            </a>
            </li>
            
            <!-- Random Flags-->
            <li style="padding-top: 2px;margin-top: 2px;" class="random-flag-list hidden-xs">
                <div class="hidden-xs">
                    <?php echo $randomCountries ;?>
                </div>
            </li>
            
            <!-- All countries Drop Down List -->
            <li class="hidden-xs">
                <div class="dropdown" style="text-align: center;">
                    <button class="btn btn-default dropdown-toggle connectbutton" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                      <span class="caret"></span>
                    </button>
                    <?php echo $allCountries;?>
                </div>
            </li>

            <!-- Report an Issue Icon-->
            <!--<li class="HeaderIcon hidden-xs"  style="padding-top: 0px!important">
                <a class="HeaderIconAnchor" href="<?php echo SITE_URL;?>/report_issue.php">
                    <img class="HeaderIconImage"  data-toggle="tooltip" title="Report an Issue" data-placement="bottom" alt="Report Issue" src="<?php echo SITE_URL.'/';?>images/header_icons/bug.png" />
                </a>
            </li>-->
			 <li class="HeaderIcon hidden-xs"  style="padding-top: 0px!important">
                <a class="HeaderIconAnchor" href="<?php echo SITE_URL;?>/qcast.php">
                   <!--<span class="glyphicon">&#xe009;</span>-->
				    <img class="HeaderIconImage"  data-toggle="tooltip" title="Video" data-placement="bottom" alt="Video" src="<?php echo SITE_URL.'/';?>images/header_icons/video.png" />
                </a>
            </li>

    <!-- Friends Icon -->
     <?php if(!isPageVisibleForEveryone() || $loggedIn){ ?>
     <li  class="HeaderIcon" style="padding-top: 0px!important">
        <?php
           $rcquery = "select * from friendlist f,member m 
           where f.member_id = m.member_id AND f.member_id = '".$_SESSION['SESS_MEMBER_ID']."' AND is_unread = 0";
           $rcsql = mysqli_query($con, $rcquery) or die(mysqli_error($con));
           $rcount = mysqli_num_rows($rcsql);
           $friend_request = mysqli_query($con, "select * from friendlist f,member m where m.member_id=f.added_member_id and f.status = 0 and f.member_id = '".$_SESSION['SESS_MEMBER_ID']."'");
           $request_count = mysqli_num_rows($friend_request);
           $ResultMemberProfileLogo = '';
           $ResultMemberProfilePic = '';
           ?>
                   <a id="notifications"  href="#" class="dropdown-toggle HeaderIconAnchor" data-toggle="dropdown" style="background-color:transparent">
                       <img class="HeaderIconImage"   data-toggle="tooltip" title="Friends Requests" data-placement="bottom" alt="Friend Request" src="<?php echo SITE_URL.'/';?>images/header_icons/add-friend.png" />
                            
                           <?php if($request_count > 0){ 
                           echo '<div class="noti_bubble"> <span style="margin-left:0px !important" >'.($request_count>100?"99+":$request_count).'</span> </div>';
                           }?>
                   </a>
           <ul class="dropdown-menu dropMenu1">
                   <li>
                   <div style="float:right; font-size:15px;"><?php if(isset($_SESSION['lang']))
           {echo nl2br($lang['friend request']);}else{?>Friend Requests<?php }?></div>
                   <div style="font-size:15px;">
                   <a href="<?php echo $base_url;?>find_friend.php" style=""><?php if(isset($_SESSION['lang']))
           {echo nl2br($lang['Search People']);}else{?>Find Friend<?php }?></a></div>
                   </li>
                   <li role="separator" class="divider"></li>
                                   <?php 

           if($request_count > 0){
           ?>      
           <?php 
           while($request_res = mysqli_fetch_array($friend_request))
           {

           $ResultMemberProfileLogo =$objMemberHeader1->select_member_meta_value($request_res['member_id'],'current_profile_image');
           if($ResultMemberProfileLogo){			
           $ResultMemberProfilePic =SITE_URL.'/'.$ResultMemberProfileLogo;	
           }
           else{
           $ResultMemberProfilePic =SITE_URL.'/images/default.png';
           }
           $encryptedMemberID=$QbSecurity->QB_AlphaID($request_res['member_id']);
           ?>
           <li id="mini_prof<?Php echo $encryptedMemberID;?>" style="display:block; margin-bottom:5px;">
           <div style="float:left; width:50px; height:50px; margin-right:8px;">
           <a href="<?php echo $base_url.$request_res['username'];?>" title="<?php echo $request_res['username'];?>"><img src="<?php echo $ResultMemberProfilePic;?>" width="50" height="50"/> </a>
           </div>
           <div style="overflow:hidden;">
           <div class="author"><strong><a href="<?php echo $base_url.$request_res['username'];?>" title="<?php echo $request_res['username'];?>"><?php echo $request_res['username'];?></a></strong>
           </div>
           <div style="float:right" id="friends1<?Php echo $encryptedMemberID;?>">
           <div style="display:inline;"><input type="button" name="accept_request" value="<?Php echo $lang['confirm'];?>" custoMid ="<?Php echo $encryptedMemberID;?>" 
           class="accept_request btn btn-info" 
           onclick="location.href='<?php  echo $base_url."action/accept_request.php?member_id=".$request_res['member_id']; ?>';"></div>
           <div style="display:inline;"><input type="button" name="cancel_request" value="<?Php echo $lang['not now'];?>" custoMid ="<?Php echo $encryptedMemberID;?>" class="cancel_request btn btn-danger"></div>
           </div>
           <div style="display:none; float:right" id="friends<?Php echo $encryptedMemberID;?>">
           <input type="button" name="accept_request" value="Friends" class="friends btn btn-success">
           </div>

           </div>

           </li>
           <li role="separator" class="divider"></li>
           <?php } ?> 

           <?php }
           else {?>
           <div class="community-empty-list"> <?php echo $lang['No new Request'];?></div>
           <li role="separator" class="divider"></li>
           <?php } ?>




                           <li><a href="<?php echo $base_url;?>friends/<?php echo $currentUsername;?>">
           <?php if(isset($_SESSION['lang']))
           {echo nl2br($lang['Show all']);}else{?>Show All Friends<?php }?>
           </a></li>
                   </ul> <!-- / .dropdown-menu -->   
     </li>
     
    
    <!-- Notification Icon -->
    <li class="HeaderIcon dropdown" style="padding-top: 0px!important">
        <?php 
            $ncquery = "SELECT * FROM notifications n LEFT JOIN member m ON m.member_id = n.sender_id
                            WHERE n.is_unread = 0 AND received_id = '".$_SESSION['SESS_MEMBER_ID']."'  ORDER BY id DESC";
            $ncsql = mysqli_query($con, $ncquery) or die(mysqli_error($con));
            $ncount = mysqli_num_rows($ncsql);
        ?>	
        
    <a href="#" id="notifications_icon" class="dropdown-toggle HeaderIconAnchor" data-toggle="dropdown" style="background-color:transparent;">
            <img class="HeaderIconImage media-object" alt="Notification" src="<?php echo SITE_URL.'/';?>images/header_icons/notification.png" data-toggle="tooltip" title="Notifications" data-placement="bottom" />
            <?php if($ncount > 0){ echo '<div id="noti_bubble" class="noti_bubble"> <span style="margin-left:0px !important" >'.($ncount>100?"99+":$ncount).'</span> </div>';}?>
    </a>
    <!-- Notifications Menu Drop down -->
    <ul class="dropdown-menu dropMenu1" style="width: 360px!important;">
    <li>
    <div style="font-size:15px;"><?php if(isset($_SESSION['lang']))
    {echo $lang['Notifications'];}else{?>Notifications<?php }?></div>
    </li>
    <li role="separator" class="divider"></li>

            <?php 
              $nquery = "SELECT * FROM notifications n 
              LEFT JOIN member m ON m.member_id = n.sender_id 
              WHERE received_id = '".$_SESSION['SESS_MEMBER_ID']."'
              ORDER BY id DESC LIMIT 5";
              $nsql = mysqli_query($con, $nquery);
              $NotificationMemberProfileLogo='';
              $NotificationMemberProfilePic='';

              if(mysqli_num_rows($nsql) > 0)
              {
                      ?>




          <?php 

              while($nres = mysqli_fetch_array($nsql))
              {



                      $NotificationMemberProfileLogo =$objMemberHeader1->select_member_meta_value($nres['member_id'],'current_profile_image');
    if($NotificationMemberProfileLogo){			
                    $NotificationMemberProfilePic =SITE_URL.'/'.$NotificationMemberProfileLogo;	
    }
    else{
            $NotificationMemberProfilePic =SITE_URL.'/images/default.png';
    }
                      $receiver_id = $nres['received_id'];
                      $rmquery = mysqli_query($con, "SELECT username, member_id FROM member WHERE member_id = '$receiver_id'");
                      $rmres = mysqli_fetch_array($rmquery);

            //Edited by Mushira Ahmad--Check for different types of notifications
                  /*
            if ($nres['type_of_notifications']==30)
                    $append_notid="?notid=".$nres['id'];
            else
            if ($nres['type_of_notifications']==37)
                    $append_notid="?notid=".$nres['id'];
            else
                    $append_notid="&notid=".$nres['id'];
             //End of handling different types of notifications
                  */

                  $append_notid = '';
                  if(strpos($nres['href'], '?') !== false) {
                      $append_notid = '&';
                  } else {
                      $append_notid = '?';
                  }

                  $append_notid .= 'notid='.$nres['id'];
				 // echo "<br>url is :".$nres['href'];
				  if(strpos($nres['href'],"quakbox.com") == false)
				  {
					  $notification_link  = $base_url.$nres['href'].$append_notid;
				  }else{
					 $notification_link  =$nres['href'];  
				  }
              ?>

            <li class="notili" id="<?php echo $nres['id'];?>">
            <a href="<?php echo $notification_link;?>" style="display:block; padding: 7px 27px 7px 8px;">
            <div style="float:left; width:50px; height:50px; margin-right:8px;">
            <img src="<?php echo $NotificationMemberProfilePic;?>" width="50" height="50"/> 
            </div>
            <div>
            <div><strong><?php echo $nres['username'];?></strong>

                    <?php echo (strlen($nres['title'])<30)?($nres['title']):(substr($nres['title'],0,30).'..'); ?>



            </div> 
            <div><span style="color:gray;"><?php echo time_stamp($nres['date_created']);?></span></div>

            </div>
            </a>
            </li>
            <li role="separator" class="divider"></li>
          <?php } 	 

              ?>


          <?php } 
              else
              {
              ?>
          <div class="community-empty-list"><?php echo $lang['No notifications'];?></div><li role="separator" class="divider"></li><?php } ?>



                                                                            <li><a href="<?php echo $base_url;?>notifications.php">
          <?php if(isset($_SESSION['lang']))
    {echo $lang['see all'];}else{?>See All<?php }?></a></li>
                                                                    </ul> 

    </li>
   
    
    <!-- Messages Icon -->
    <li class="HeaderIcon">
        <?php
            $mcquery = mysqli_query($con, "SELECT id FROM cometchat WHERE cometchat.to = '".$_SESSION['SESS_MEMBER_ID']."' AND cometchat.read != 1") or die(mysqli_error($con));
            $mcount = mysqli_num_rows($mcquery);
        ?>

        <!-- Messages Icon-->
        <a href="#" class="dropdown-toggle HeaderIconAnchor" data-toggle="dropdown" style="background-color:transparent">
           <img class="HeaderIconImage media-object" alt="Messages" src="<?php echo SITE_URL.'/';?>images/header_icons/messages.png" data-toggle="tooltip" title="Messages" data-placement="bottom" />
            <?php if($mcount > 0){ 
                echo '<div class="noti_bubble"> <span style="margin-left:0px !important" >'.($mcount>100?"99+":$mcount).'</span> </div>';
            }?>
        </a>

        <!-- MESSAGES -->
        <ul class="dropdown-menu dropMenu1" >
        <li padding-left: 10px;>
            <div style="float:right; font-size:15px;"><?php if(isset($_SESSION['lang']))
    {echo $lang['inbox'];}else{?>Inbox<?php }?></div>
		<div style="font-size:15px;"><a href="<?php echo $base_url;?>write_message.php">
        <?php if(isset($_SESSION['lang']))
    {echo $lang['send a new message'];}else{?>Send a New Message<?php }?>
        </a></div>
		</li>
		<li role="separator" class="divider"></li>
        			<?php 
	 $msg_query = "SELECT SQL_CALC_FOUND_ROWS
       u.member_id ,
       i.from,
       i.to,
       u.username ,
       i.sent,
       i.message
    FROM cometchat AS i,
         member  AS u,
         (SELECT MAX(id) AS id_max,
                 id_with
              FROM (
                    SELECT id,
                           c.from AS id_with
                        FROM cometchat c
                        WHERE c.to = '".$_SESSION['SESS_MEMBER_ID']."'
                    UNION ALL
                    SELECT id,
                           o.to
                        FROM cometchat o
                        WHERE o.from = '".$_SESSION['SESS_MEMBER_ID']."'
                   ) AS t
              GROUP BY id_with) AS m
    WHERE i.id  = m.id_max
      AND u.member_id = m.id_with
    ORDER BY i.id DESC LIMIT 5";
			 $msg_sql = mysqli_query($con, $msg_query) or die(mysqli_error($con));
		$msg_count = mysqli_num_rows($msg_sql);
		$MessageMemberProfileLogo='';
		$MessageMemberProfilePic='';
		if($msg_count > 0)
		{
		?>
        <?php
		while($msg_res = mysqli_fetch_array($msg_sql))
		{	
		
		$MessageMemberProfileLogo =$objMemberHeader1->select_member_meta_value($msg_res['member_id'],'current_profile_image');
if($MessageMemberProfileLogo){			
		$MessageMemberProfilePic =SITE_URL.'/'.$MessageMemberProfileLogo;	
}
else{
	$MessageMemberProfilePic =SITE_URL.'/images/default.png';
}  
	  ?>
		<li style="display:block; margin-bottom:5px;">
        <a href="<?php echo $base_url.'messages.php?username='.$msg_res['member_id'];?>">
        <div style="float:left; width:50px; height:50px; margin-right:8px;">
        <img src="<?php echo $MessageMemberProfilePic;?>" width="50" height="50"/> 
        </div>
        <div style="overflow:hidden;">
        <div class="author"><strong><?php echo $msg_res['username'];?></strong>
        </div> 
        <div style="overflow: hidden;text-overflow: ellipsis;white-space: nowrap;"><span style="color:gray;">
        <?php if($msg_res['from'] == $_SESSION['SESS_MEMBER_ID'] && $msg_res['to'] == $msg_res['member_id']){?>
<img src='<?php echo $base_url;?>images/send.png'  class='con_send'/>	
<?php }
         echo $msg_res['message'];?></span></div>
        
        </div>
        <div><span style="color:gray;"><?php echo time_stamp($msg_res['sent']);?></span></div>
        </a>
        </li>
        <li role="separator" class="divider"></li>
        <?php } 				
		 } else { ?>
	   <div class="community-empty-list"><?php echo $lang['No New Message']?></div><li role="separator" class="divider"></li><?php } ?>
										
									

									
									<li><a href="<?php echo $base_url;?>messages.php">
	     <?php if(isset($_SESSION['lang']))
{echo $lang['view all my messages'];}else{?> View All My Messages<?php }?>
	    </a></li>
								</ul> <!-- / .dropdown-menu -->


  
    </li>
     <?php } ?>

   <!-- Search bar-->
    <li style="padding-top:10px!important;" class="hidden-xs">
        <form>
           <input class="search-bar hidden-xs visible-sm visible-md visible-lg form-control search" style="height: 25px;" role="search" type="text" name="search" value="" placeholder="<?php echo $lang['search'];?>" autocomplete="off">
        </form>
        <div id="divResult" class="hidden-xs visible-sm visible-lg visible-xl dropdown" style="background-color: white;margin-left: 0px;"> </div>
    </li>

    <?php if(!isPageVisibleForEveryone() || $loggedIn){ ?>
    <!-- Setting Icon -->    
    <li class="HeaderIcon mainmenu-settings">
        <a href="#" class=" dropdown-toggle user-menu HeaderIconAnchor" data-toggle="dropdown" style="outline: none !important; background-color:transparent !important;">
            <i style="color: white;" class="HeaderIconImage glyphicon glyphicon-cog" data-toggle="tooltip" title="Settings" data-placement="bottom"></i>
        </a>                                                    
        <ul class="dropdown-menu">
            <li> <a href="<?php echo $base_url;?>profile.php" style="white-space: nowrap;text-overflow: ellipsis;font-size: 14px; display: block; "><?php echo $lang['Profile'];?><i id="firstIcon" class="fa fa-user" style="padding-left: 5px;"></i></a></li><li role="separator" class="divider"></li>
            <li><a href="<?php echo $base_url;?>account_settings.php"  style="white-space: nowrap;text-overflow: ellipsis;font-size: 14px; display: block;"><?php echo nl2br($lang['Account Settings']);?> <i id="secondIcon" class="fa fa-gears" style="padding-left: 5px;"></i></a></li>
            <li role="separator" class="divider"></li>
            <li><a href="<?php echo $base_url;?>privacy.php" style="white-space: nowrap;text-overflow: ellipsis;font-size: 14px; display: block;"><?php if(isset($_SESSION['lang']))
            {echo nl2br($lang['Privacy Settings']);}else{?>Privacy Settings<?php }?> <i id="thirdIcon" class="fa fa-unlock-alt" style="padding-left: 5px;"></i></a></li>
            <li role="separator" class="divider"></li>
            <li><a href="<?php echo $base_url;?>logout.php" style="white-space: nowrap;text-overflow: ellipsis;font-size: 14px; display: block;"><?php if(isset($_SESSION['lang']))
            {echo nl2br($lang['Logout']);}else{?>Logout<?php }?><i id="fourthIcon" class="fa fa-power-off" style="padding-left: 5px;"></i></a>
            </li>
        </ul>                                                         
    </li>


<!-- World Icon -->
<li class="HeaderIcon hidden-xs"  style="padding-top: 0px!important">
    <a class="HeaderIconAnchor" href="<?php echo SITE_URL.'/';?>home" style="color:#FFF;">
    <i class="HeaderIconImage glyphicon glyphicon-globe" data-toggle="tooltip" title="World" data-placement="bottom"></i>   
</a>
</li>


<!-- My Favorite Countries Icon -->
<li class="HeaderIcon favorite-countries-item" style="padding-top: 0px!important">
<a class="HeaderIconAnchor" href="<?php echo SITE_URL;?>/create_country.php">
    <img class="HeaderIconImage" src="<?php echo SITE_URL;?>/images/header_icons/add-heart.png" data-toggle="tooltip" title="Favorite Countries" data-placement="bottom" />
</a>
</li>

<!-- Favorite Countries -->							
<li style="text-align: center;" class="hidden-xs">
<?php echo $favCountries;?>
</li>

<li class="HeaderIcon hidden-sm hidden-md hidden-lg visible-xs search-icon">
    <a class="HeaderIconAnchor dropdown-toggle" href="#" id="header-show-form" data-toggle="dropdown">
        <img class="HeaderIconImage"  src="<?php echo SITE_URL.'/';?>images/header_icons/search.png?" />
    </a>
    <div class="search-form-dropdown dropdown-menu">
        <form>
            <input class="hidden-xl hidden-lg hidden-md hidden-sm visible-xs form-control search" data-placement="bottom" style= "width: 94%; margin: 10px; box-sizing: border-box; z-index: 15001;" type="text" name="search" value="" placeholder="<?php echo $lang['search'];?>" autocomplete="off" autofocus="autofocus">
        </form>
        <div class="divResult" class="dropdown" style="background-color: white;margin-left: 10px;margin-bottom: 10px;position:relative; z-index:10001; "> </div>
    </div>
</li>

<!-- User Name and profile image with link to user page-->
<li class="hidden-xs">
  <a href="<?php echo SITE_URL."/i/".$currentUsername;?>" style="padding-top: 0px;padding-left: 3px!important; padding:0px;font-size: 15px;color:#FFF; text-align:center;white-space: nowrap;text-overflow: ellipsis;cursor:pointer;" data-toggle="tooltip" title="Profile" data-placement="bottom">
  <img class="header-profile-image" src="<?php echo $currentUserProfilePic;?>"/>
  <!--<strong><?php echo ucfirst($currentUsername);?></strong>-->
  </a>
</li>
    <?php } else { ?>
        <li><a href="/landing.php"><strong style="text-shadow: none;color: #fff;">Click to Login or Register</strong></a></li>
    <?php } ?>


  
  


    </ul>

</div>

 

        </div>




      </div>




    </div>



    <!-- Solve Mobile padding issue-->
    <div class="hidden-lg hidden-md visible-xs visible-sm" >
        <br/><br/><br/>
    </div>




        <!--[if lt IE 8]>
                <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
            <![endif]-->
            <?php //if(isset($_COOKIE['lang'])){echo '<input type="hidden" name="locales" id="locales" value="'.$_COOKIE['lang'].'"/>'; }
            ?>
