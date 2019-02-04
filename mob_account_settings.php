<?php 

	session_start();

	

	//error_reporting(0);

	if(!isset($_SESSION['SESS_MEMBER_ID']))

	{

		header("location:index.php?back=". urlencode($_SERVER['REQUEST_URI']));

	}

	if(isset($_SESSION['lang']))

	{	

		include('common.php');

	}

	else

	{

		include('en.php');

		

	}

	require_once('config.php');

	$member_id = $_SESSION['SESS_MEMBER_ID'];

	if(!isset($_SESSION['SESS_MEMBER_ID']))

	{

		header("location:index.php");

	}

	$member_sql = mysql_query("select * from members where member_id='".$member_id."'");

	$member_res = mysql_fetch_array($member_sql);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title><?php echo $lang['Account'];?></title>

<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0">


<link rel="icon" href="images/favicon.ico" type="image" />

<link rel="shortcut icon" href="images/favicon.ico" type="image" />

<link rel="stylesheet" type="text/css" href="css/style.css"/>

<link rel="stylesheet" type="text/css" href="css/group.css"/>

<link rel="stylesheet" type="text/css" href="css/account.css"/>

<link rel="stylesheet" type="text/css" href="css/notifications.css"/>

<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>

<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>font-awesome/css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/responsive.css" />


<script src="js/jquery-1.9.1.js"></script>

<script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>

	<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>

<script src="js/account.js" type="text/javascript"></script>

<script type="text/javascript">

jQuery(function(){

        $("#btnsubmit").click(function(){

        $(".error").hide();

        var hasError = false;

        var passwordVal = $("#password").val();

        var checkVal = $("#cpassword").val();

		 var email_avail = $("#email_avail").val();

		var username_avail = $("#username_avail").val();

        

		if(passwordVal.length != 0)

		{

		

		if(passwordVal.length < 6)

		{

			$("#password").after('<span class="error"><?php echo $lang['Your password is too short! Please enter a minimum of 6 characters'];?>.</span>');

            hasError = true;

		}

        else if (passwordVal != checkVal ) {

            $("#cpassword").after('<span class="error"><?php echo $lang['Passwords do not match'];?>.</span>');

            hasError = true;

        }

		

		}

        if(hasError == true) {return false;}

    });

	

	$("#emailsubmit").click(function(){

        $(".error").hide();

        var hasError = false;

        

		var email_avail = $("#email_avail").val();		

        

		if (email_avail == 0) {

            $("#email_id").after('<span class="error"><?php echo $lang['Email already exist'];?>.</span>');

            hasError = true;

        }

        if(hasError == true) {return false;}

    });



$("#usernamesubmit").click(function(){

        $(".error").hide();

        var hasError = false;

        

		var email_avail = $("#username_avail").val();		

        

		if (email_avail == 0) {

            $("#username").after('<span class="error"><?php echo $lang['Username already exist'];?>.</span>');

            hasError = true;

        }

        if(hasError == true) {return false;}

    });





$('#boxclose').click(function(){	

	$('.box').hide();

});

});

//username exists

function check_email(){



	var email = $("#email_id").val();

	

	if(email.length > 2){

	$('#Loading1').show();

	$.post("load_data/email_ajax.php", {

     username: $('#email_id').val(),

	}, function(response){

		

			$('#Info1').fadeOut();

			 $('#Loading1').hide();

			

			 document.getElementById("email_avail").value = response;

			

		});

		

	}

	}

	

	//username exists

function check_username(){



	var username = $("#username").val();	

	if(username.length > 2){

	$('#Loading').show();

	$.post("load_data/username_ajax.php", {

     username: $('#username').val(),

	}, function(response){

		

			$('#Info').fadeOut();

			 $('#Loading').hide();

			

			 document.getElementById("username_avail").value = response;

			

		});

		

	}

	}

		

</script>

<style type="text/css">

.error {

    margin-left: 10px;

	 color: rgb(204, 0, 0);

    font-size: 12px;

}

</style>

</head>

<body id="acc_setting">

<div id="wrapper">

<?php include('includes/header.php');?>

<div id="mainbody">

<div class="column_left">

	<?php 

	if(isset($_GET['err'])){

if($_GET['err'] == null){ 

?>

<div class="box" id="box">

<a class="boxclose" id="boxclose"></a>

<div class="alert-box"><span><?php echo $lang['Your settings have been saved'];?>.</span></div>

</div>

<?php

}

}

?>

    <div class="componentheading">

    <div id="submenushead"><?php echo $lang['Account Setting'];?></div>

    </div>

    <div id="submenushead">

    <ul class="dropDown">

    <li><a href="mob_privacy.php"><?php echo $lang['Privacy'];?></a></li>

    <li><a href="mob_blocking.php"><?php echo $lang['Blocking'];?></a></li>

    <li><a href="mob_account_settings.php"><?php echo $lang['Account Settings'];?></a></li>

  	<li><a href="mob_delete_account.php"><?php echo $lang['delete account'];?></a></li>

    <!--<li style="padding:0 8px;"><a href="groups_search.php">Search</a></li>    -->

	</ul>

   </div>



<div id="border"> 



<div class="ctitle">

<h2 style="font-size:110%;"><?php echo $lang['Edit your account settings'];?></h2>

</div>



<div id="contentArea" role="main">

<div id="SettingsPage_Content">

<ul class="SettingsList _4kg _4ks uiList">

<li class="SettingsListItem SettingsListItemLabeled _5b2_" id="li_change_name">

<a href="javascript:void(0);" class="SettingsListLink pvm phs" id="change_name">

<h3 class="SettingsListItemLabel pls"> <?php echo $lang['First Name'];?></h3>

<span class="SettingsListItemEdit uiIconText"><?php echo $lang['Edit'];?></span>

<span class="hidden_elem SettingsListItemSaved"><?php echo $lang['Changes saved'];?></span>

<span class="SettingsListItemContent"><strong><?php echo $member_res['FirstName'];?></strong></span>

</a>

<div class="content">

<form name="account_form" id="account_form" action="action/change_name.php" method="post">

<input type="hidden" name="member_id" value="<?php echo $member_id;?>" />

<div class="formtable" style="width: 100% ! important;">

<div style="font-weight: bold; text-align: left; padding: 5px; vertical-align: top; float: left; width: 30%;">

<label style="font-weight: 700;text-align: right;"> <?php echo $lang['Name'];?></label>

</div>

<div style="padding:5px; vertical-align:top;">

<input type="text" class="special" name="member_name" id="member_name" value="<?php echo $member_res['FirstName'];?>" style="width:50%; padding:3px;"/>

</div>

<div style="padding:5px; vertical-align:top;">

<input type="submit" value="<?php echo $lang['Save'];?>" name="action" class="button" id="submit" />

<input type="button" value="<?php echo $lang['Cancel'];?>" name="action" class="button" id="change_name_cancel" />

</div>
</div>

</form>

</div>

</li>







<li class="SettingsListItem SettingsListItemLabeled _5b2_" id="li_change_mname">

<a href="javascript:void(0);" class="SettingsListLink pvm phs" id="change_mname">

<h3 class="SettingsListItemLabel pls"><?php echo $lang['Middle Name'];?></h3>

<span class="SettingsListItemEdit uiIconText"><?php echo $lang['Edit'];?></span>

<span class="hidden_elem SettingsListItemSaved"><?php echo $lang['Changes saved'];?></span>

<span class="SettingsListItemContent"><strong><?php echo $member_res['Mname'];?></strong></span>

</a>

<div class="content">

<form name="account_form" id="account_form" action="action/change_mname.php" method="post">

<input type="hidden" name="member_id" value="<?php echo $member_id;?>" />

<div class="formtable" style="width: 100% ! important;">

<div style="font-weight: bold; text-align: left; padding: 5px; vertical-align: top; float: left; width: 30%;">

<label style="font-weight: 700;text-align: right;"> <?php echo $lang['Middle Name'];?></label>

</div>

<div style="padding:5px; vertical-align:top;">

<input type="text" name="m_member_name" id="member_name" value="<?php echo $member_res['Mname'];?>" style="width:50%; padding:3px;"/>

</div>

<div style="padding:5px; vertical-align:top;">

<input type="submit" value="<?php echo $lang['Save'];?>" name="action" class="button" id="submit" />

<input type="button" value="<?php echo $lang['Cancel'];?>" name="action" class="button" id="change_mname_cancel" />
</div>
</div>
</form>

</div>

</li>











<li class="SettingsListItem SettingsListItemLabeled _5b2_" id="li_change_lname">

<a href="javascript:void(0);" class="SettingsListLink pvm phs" id="change_lname">

<h3 class="SettingsListItemLabel pls"><?php echo $lang['Last Name'];?></h3>

<span class="SettingsListItemEdit uiIconText"><?php echo $lang['Edit'];?></span>

<span class="hidden_elem SettingsListItemSaved"><?php echo $lang['Changes saved'];?></span>

<span class="SettingsListItemContent"><strong><?php echo $member_res['LastName'];?></strong></span>

</a>

<div class="content">

<form name="account_form" id="account_form" action="action/change_lname.php" method="post">

<input type="hidden" name="member_id" value="<?php echo $member_id;?>" />


<div class="formtable" style="width: 100% ! important;">
<div style="font-weight: bold; text-align: left; padding: 5px; vertical-align: top; float: left; width: 30%;">

<label style="font-weight: 700;text-align: right;"><?php echo $lang['Last Name'];?></label>

</div>

<div style="padding:5px; vertical-align:top;">

<input type="text" name="l_member_name" class="special" id="member_name" value="<?php echo $member_res['LastName'];?>" style="width:50%; padding:3px;"/>

</div>

<div style="padding:5px; vertical-align:top;">

<input type="submit" value="<?php echo $lang['Save'];?>" name="action" class="button" id="submit" />

<input type="button" value="<?php echo $lang['Cancel'];?>" name="action" class="button" id="change_lname_cancel" />

</div>
</div>
</form>

</div>

</li>









<li class="SettingsListItem SettingsListItemLabeled _5b2_" id="li_change_username">

<a href="javascript:void(0);" class="SettingsListLink pvm phs" id="change_username">

<h3 class="SettingsListItemLabel pls"><?php echo $lang['Username'];?></h3>

<span class="SettingsListItemEdit uiIconText"><?php echo $lang['Edit'];?></span>

<span class="hidden_elem SettingsListItemSaved"><?php echo $lang['Changes saved'];?></span>

<span class="SettingsListItemContent"><strong><?php echo $member_res['username'];?></strong></span>

</a>

<div class="content">

<form name="account_form" id="account_form" action="action/change_username-exec.php" method="post">

<input type="hidden" name="member_id" value="<?php echo $member_id;?>" />

<div class="formtable" style="width: 100% ! important;">

<div style="font-weight: bold; text-align: left; padding: 5px; vertical-align: top; float: left; width: 30%;">

<label style="font-weight: 700;text-align: right;"><?php echo $lang['Username'];?></label>

</div>

<div style="padding:5px; vertical-align:top;">

<input type="text" name="username" id="username" value="<?php echo $member_res['username'];?>" onblur="return check_username();" style="width:50%; padding:3px;"/>

<input type="hidden" name="username_avail" id="username_avail" />

</div>

 <div style="padding:5px; vertical-align:top;"><div id="Info" ><span id="Loading"></span></div>

<span class="check"  ></span>
</div>

<div style="padding:5px; vertical-align:top;">

<input type="submit" value="<?php echo $lang['Save'];?>" name="action" class="button" id="submit" />

<input type="button" value="<?php echo $lang['Cancel'];?>" name="action" class="button" id="change_username_cancel" />

</div>
</div>
</form>

</div>

</li>



<li class="SettingsListItem SettingsListItemLabeled _5b2_" id="li_change_email">

<a href="javascript:void(0);" class="SettingsListLink pvm phs" id="change_email">

<h3 class="SettingsListItemLabel pls"><?php echo $lang['Email'];?></h3>

<span class="SettingsListItemEdit uiIconText"><?php echo $lang['Edit'];?></span>

<span class="hidden_elem SettingsListItemSaved"><?php echo $lang['Changes saved'];?></span>

<span class="SettingsListItemContent"><strong><?php echo $member_res['email_id'];?></strong></span>

</a>

<div class="content">

<form name="account_form" id="account_form" action="action/change_email-exec.php" method="post">

<input type="hidden" name="member_id" value="<?php echo $member_id;?>" />

<div class="formtable" style="width: 100% ! important;">

<div style="font-weight: bold; text-align: left; padding: 5px; vertical-align: top; float: left; width: 30%;">

<label style="font-weight: 700;text-align: right;"><?php echo $lang['Email'];?></label>

</div>

<div style="padding:5px; vertical-align:top;">

<input type="email" name="email_id" id="email_id" value="<?php echo $member_res['email_id'];?>" onblur="return check_email();" style="width:50%; padding:3px;" />

<input type="hidden" name="email_avail" id="email_avail" />

</div>

 <div style="padding:5px; vertical-align:top;"><div id="Info1" ><span id="Loading1"></span></div>

		<span class="check1"  ></span></td>

</div>




<div style="padding:5px; vertical-align:top;">

<input type="submit" value="<?php echo $lang['Save'];?>" name="action" class="button" id="emailsubmit" />

<input type="button" value="<?php echo $lang['Cancel'];?>" name="action" class="button" id="change_email_cancel" />

</div>
</div>
</form>

</div>

</li>



<li class="SettingsListItem SettingsListItemLabeled _5b2_" id="li_change_password">

<a href="javascript:void(0);" class="SettingsListLink pvm phs" id="change_password">

<h3 class="SettingsListItemLabel pls"><?php echo $lang['Password'];?></h3>

<span class="SettingsListItemEdit uiIconText"><?php echo $lang['Edit'];?></span>

<span class="hidden_elem SettingsListItemSaved"><?php echo $lang['Changes saved'];?></span>

<span class="SettingsListItemContent"><strong><?php echo $lang['Change password'];?></strong></span>

</a>

<div class="content">

<form name="account_form" id="account_form" action="action/change_password-exec.php" method="post">

<input type="hidden" name="member_id" value="<?php echo $member_id;?>" />

<div class="formtable" style="width: 100% ! important;">

<div style="font-weight: bold; text-align: left; padding: 5px; vertical-align: top; float: left; width: 30%;">

<label style="font-weight: 700;text-align: right;"><?php echo $lang['Password'];?></label>

</div>

<div style="padding:5px; vertical-align:top;">

<input type="password" name="password" id="password" required="required"  value="" style="width:50%; padding:3px;" />

</div>

<div style="font-weight: bold; text-align: left; padding: 5px; vertical-align: top; float: left; width: 30%;">

<label style="font-weight: 700;text-align: right;"><?php echo $lang['Verify Password'];?></label>

</div>

<div style="padding:5px; vertical-align:top;">

<input type="password" name="cpassword" id="cpassword" required="required" value=""  style="width:50%; padding:3px;" />

</div>

<div style="padding:5px; vertical-align:top;">

<input type="submit" value="<?php echo $lang['Save'];?>" name="action" class="button" id="btnsubmit" />

<input type="button" value="<?php echo $lang['Cancel'];?>" name="action" class="button" id="change_password_cancel" />

</div>
</div>
</form>

</div>

</li>



<li class="SettingsListItem SettingsListItemLabeled _5b2_" id="li_change_lang">

<a href="javascript:void(0);" class="SettingsListLink pvm phs" id="change_lang">

<h3 class="SettingsListItemLabel pls"><?php echo $lang['Language'];?></h3>

<span class="SettingsListItemEdit uiIconText"><?php echo $lang['Edit'];?></span>

<span class="hidden_elem SettingsListItemSaved"><?php echo $lang['Changes saved'];?></span>

<span class="SettingsListItemContent"><strong><?php echo $lang['Engilsh (US)'];?></strong></span>

</a>

<div class="content">

<form name="account_form" id="account_form" action="action/change_language-exec.php" method="post">

<input type="hidden" name="member_id" value="<?php echo $member_id;?>" />

<div class="formtable" style="width: 100% ! important;">

<div style="font-weight: bold; text-align: left; padding: 5px; vertical-align: top; float: left; width: 30%;">

<label style="font-weight: 700;text-align: right;"><?php echo $lang['Language'];?></label>

</div>

<div style="padding:5px; vertical-align:top;">

<select name="language" id="language" style="width:50%; padding:3px;">

<option value="en-GB" selected="selected"><?php echo $lang['Engilsh (US)'];?></option>

</select>

</div>

<div style="padding:5px; vertical-align:top;">

<input type="submit" value="<?php echo $lang['Save'];?>" name="action" class="button" id="submit" />

<input type="button" value="<?php echo $lang['Cancel'];?>" name="action" class="button" id="change_lang_cancel" />

</div>
</div>


</form>

</div>

</li>

</ul>

</div><!--end SettingsPage_Content div-->

</div><!--end contentArea div-->



</div><!--end border div-->

</div><!--end column_left div-->

<script>

$('.special').bind('keypress', function(e) {



    

        var k = e.which;

        var ok = k >= 65 && k <= 90 || // A-Z

            k >= 97 && k <= 122 || // a-z

            k >= 48 && k <= 57; // 0-9



        if (!ok && k!=8){

            e.preventDefault();

        }

    

}); 

</script>

<?php /*include 'ads_right_column1.php';*/?>

</div><!--end mainbody div-->

<?php include 'includes/footer.php';?>

</div><!--end wrapper div-->





</body>

</html>