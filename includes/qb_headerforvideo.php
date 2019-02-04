<?php
    include_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
  
    require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_misc.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/friends_request_notification.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/view_notification.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_security.php');
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
