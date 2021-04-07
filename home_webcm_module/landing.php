<?php

header('X-UA-Compatible: IE=edge,chrome=1');
error_reporting(-1);

if (!isset($_SESSION)) {
    session_start();
}

//Show message
if (isset($_GET['Message'])) {
    $message = '';

    switch ($_GET['Message']) {
        case 'AgeLimit':
            $message = 'You can register only if your age is 13+';
            break;

        case 'UsernameWrong':
            $message = 'Username can contain only letters and numbers.';
            break;

        case 'EmailInvalid':
            $message = 'Please enter a valid email address.';
            break;

        case 'DateInvalid':
            $message = 'Date is invalid.';
            break;
    }

    print '<script type="text/javascript">alert("' . $message . '");</script>';
}

if (isset($_SESSION['lang'])) {
    include($_SERVER['DOCUMENT_ROOT'] . '/common.php');
} else {
    include($_SERVER['DOCUMENT_ROOT'] . '/Languages/en.php');
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/qb_classes/qb_member1.php');

$memberObject = new member1();
$ip = $_SERVER['REMOTE_ADDR'];

if ((isset($_SESSION['SESS_MEMBER_ID']) && $_SESSION['SESS_MEMBER_ID'] > 0 || isset($_COOKIE['remember_me']) && $_COOKIE['remember_me'] > 0)) {
    if (isset($_SESSION['SESS_MEMBER_ID']) && isset($_COOKIE['remember_me'])) {
        if ($_SESSION['SESS_MEMBER_ID'] == $_COOKIE['remember_me']) {
            $login = $_SESSION['SESS_MEMBER_ID'];
        }
    } else {
        if (isset($_SESSION['SESS_MEMBER_ID'])) {
            $login = $_SESSION['SESS_MEMBER_ID'];
        } else {
            $login = $_COOKIE['remember_me'];
        }
    }

    $_SESSION['SESS_MEMBER_ID'] = $login;
    $_SESSION['userid'] = $login;

    $rs = $memberObject->update_member_meta($login, "ip", $ip);
    $checkFirstTimeLastVisit = $memberObject->select_member_meta_value($login, "last_visited_on");

    if ($checkFirstTimeLastVisit != null) {
        $rs = $memberObject->update_member_meta($login, "last_visited_on", date('Y-m-d H:i:s'));
    } else {
        $rs = $memberObject->insert_member_meta($login, "last_visited_on", date('Y-m-d H:i:s'));
    }

    $page = $memberObject->select_checkPoints_FilePath($login);
    if ($page == null) {
        $page = $homepage;
    } else {
        $page = $base_url . $page;
    }

    header("location: " . $page . "");
    exit();

}
?>
<!doctype html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <title>QuakBox</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--
        <link rel="apple-touch-icon" href="<?php echo $base_url; ?>images/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="57x57" href="<?php echo $base_url; ?>images/favicon/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="<?php echo $base_url; ?>images/favicon/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo $base_url; ?>images/favicon/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo $base_url; ?>images/favicon/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo $base_url; ?>images/favicon/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="<?php echo $base_url; ?>images/favicon/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="<?php echo $base_url; ?>images/favicon/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="<?php echo $base_url; ?>images/favicon/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo $base_url; ?>images/favicon/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="<?php echo $base_url; ?>images/favicon/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo $base_url; ?>images/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo $base_url; ?>images/favicon/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo $base_url; ?>images/favicon/favicon-16x16.png">
	-->

    <link rel="icon" href="<?php echo $base_url; ?>/images/favicon.ico" type="image"/>
    <link rel="apple-touch-icon" href="<?php echo $base_url; ?>images/apple-touch-icon.png">


    <link rel="manifest" href="<?php echo $base_url; ?>images/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php echo $base_url; ?>images/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="<?php echo $base_url; ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/formvalidation/dist/css/formValidation.min.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>css/main.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>font-awesome/css/font-awesome.css">
    <script src="<?php echo $base_url; ?>js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/login.css">
</head>
<body class="login">
<?php if (isset($_COOKIE['lang'])) {
    echo '<input type="hidden" name="locales" id="locales" value="' . $_COOKIE['lang'] . '"/>';
} ?>

<div class="intro">
    <div class="logo">Quakbox &mdash; A New Source for Interactive Social News</div>
    <div class="icons">
        <div class="icon news">QB News</div>
        <div class="icon chat">Chat</div>
        <div class="icon share">Share</div>
        <div class="icon cast">Cast</div>
        <div class="more">&amp; much more!</div>
    </div>
</div>
<div class="form-area">
    <div class="login-form">
        <h3>Sign In</h3>
        <form class="navbar-form navbar-right" role="form" action="<?php echo $base_url; ?>login.php" method="post" id="form-login1">
            <div class="form-group">
                <input name="login" type="text" id="login" placeholder="<?php echo $lang['Email or Username']; ?>"
                       class="form-control" autofocus="autofocus" required="required" autocomplete="off">
            </div>
            <div class="form-group forgot-password">
                <input name="password" type="password" placeholder="<?php echo $lang['Password']; ?>"
                       class="form-control" required="required" autocomplete="off">
                <a class="forgot-password" href="/reset_password.php">Forgot It?</a>
            </div>
            <div class="pull-right login-webmail">
                <a href="/qbmail/"><i class="fa fa-envelope"></i>&nbsp; Login To Webmail</a>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-warning"
                        name="login_submit"><?php echo isset($lang['Quak In']) ? $lang['Quak In'] : 'Quak In'; ?></button>
                <div class="checkbox">
                    <label class="checkbox inline"><input type="checkbox"
                                                          value="remember-me"> <?php echo $lang['Remember me']; ?>
                    </label>
                </div>
            </div>
        </form>
        <p>&nbsp;</p>
        <div class="social-login clearfix">
            <a href="/qb_classes/hybridauth/google.php"><img src="/assets/buttons/google.png" alt=""></a> <a href="/qb_classes/hybridauth/facebook.php"><img src="/assets/buttons/facebook.png" alt=""></a>
        </div>
    </div>
    <div class="register-form">
        <h2>Sign Up</h2>
        <p class="description">Create a QuakBox account in 5 minutes and start quaking instantly (no additional
            verification is required).</p>
        <form action="<?php echo $base_url; ?>action/register-exec.php" method="post" name="regform" id="regform"
              class="form-horizontal" role="form">
            <div class="form-group has-feedback">
                <div class="col-sm-11">
                    <input value="" name="username" type="text" class="form-control" id="username" size="40"
                           placeholder="<?php echo $lang['Username']; ?>" required="required" autocomplete="off">
                    <small class="help-block" data-fv-validator="notEmpty" data-fv-for="username"
                           data-fv-result="NOT_VALIDATED" style="display: none;">The username is required
                    </small>
                    <small class="help-block" data-fv-validator="stringLength" data-fv-for="username"
                           data-fv-result="NOT_VALIDATED" style="display: none;">The username must be more than 6 and
                        less than 30 characters long
                    </small>
                    <small class="help-block" data-fv-validator="regexp" data-fv-for="username"
                           data-fv-result="NOT_VALIDATED" style="display: none;">The username can only consist of
                        alphabetical, number, dot and underscore
                    </small>
                    <small class="help-block" data-fv-validator="blank" data-fv-for="username"
                           data-fv-result="NOT_VALIDATED" style="display: none;">This value is not valid
                    </small>
                </div>
            </div>
            <div class="form-group has-feedback">
                <div class="col-sm-11">
                    <div class="input-group">
                        <input name="qbemail" type="text" id="userEmail" class="form-control" name="email" id="qbemail"
                               placeholder="example" size="40" required>
                        <span class="input-group-addon">@quakbox.com</span>
                    </div>
                    <i class="form-control-feedback fv-bootstrap-icon-input-group" data-fv-icon-for="qbemail"
                       style="display: none;"></i>
                    <small>Enter a desired account name for your QuakBox email address. I.e. your email address will be
                        yourname@quakbox.com.
                    </small>
                    <small class="help-block" data-fv-validator="notEmpty" data-fv-for="qbemail"
                           data-fv-result="NOT_VALIDATED" style="display: none;">The QuakBox email address is required
                    </small>
                    <small class="help-block" data-fv-validator="blank" data-fv-for="qbemail"
                           data-fv-result="NOT_VALIDATED" style="display: none;">This value is not valid
                    </small>
                </div>
            </div>
            <div class="form-group has-feedback">
                <div class="col-sm-11">
                    <input name="email" type="email" class="form-control" id="email"
                           placeholder="Your current email (i.e. someone@example.com)" size="40" required="required"
                           autocomplete="off" data-fv-field="email"><i class="form-control-feedback"
                                                                       data-fv-icon-for="email"
                                                                       style="display: none;"></i>
                    <small class="help-block" data-fv-validator="notEmpty" data-fv-for="email"
                           data-fv-result="NOT_VALIDATED" style="display: none;">The email address is required
                    </small>
                    <small class="help-block" data-fv-validator="emailAddress" data-fv-for="email"
                           data-fv-result="NOT_VALIDATED" style="display: none;">The input is not a valid email address
                    </small>
                    <small class="help-block" data-fv-validator="blank" data-fv-for="email"
                           data-fv-result="NOT_VALIDATED" style="display: none;">This value is not valid
                    </small>
                </div>
            </div>
            <div class="form-group has-feedback">
                <div class="col-sm-11">
                    <span class="spanaslabel"><?php echo $lang['Date of birth'] . "*"; ?></span>
                    <div id="birthdayPicker"></div>
                    <small class="help-block" data-fv-validator="notEmpty" data-fv-for="birth[month]"
                           data-fv-result="NOT_VALIDATED" style="display: none;">Please select a Month.
                    </small>
                    <small class="help-block" data-fv-validator="notEmpty" data-fv-for="birth[day]"
                           data-fv-result="NOT_VALIDATED" style="display: none;">Please select a Day.
                    </small>
                    <small class="help-block" data-fv-validator="notEmpty" data-fv-for="birth[year]"
                           data-fv-result="NOT_VALIDATED" style="display: none;">Please select a Year.
                    </small>
					<small>
					You can register only if your age is 13 or more
                    </small>
                </div>
            </div>
            <div class="form-group has-feedback has-success">
                <div class="col-sm-11">
                    <input name="password" type="password" class="form-control" id="password"
                           placeholder="<?php echo $lang['Password']; ?>" size="40" required="required"
                           autocomplete="off">
                    <small class="help-block" data-fv-validator="notEmpty" data-fv-for="password" data-fv-result="VALID"
                           style="display: none;">The password is required
                    </small>
                    <small class="help-block" data-fv-validator="different" data-fv-for="password"
                           data-fv-result="VALID" style="display: none;">The password cannot be the same as username
                    </small>
                    <small class="help-block" data-fv-validator="stringLength" data-fv-for="password"
                           data-fv-result="VALID" style="display: none;">The Password must be more than 8 and less than
                        30 characters long
                    </small>
					 
                </div>
            </div>
            <div class="form-group has-feedback">
                <div class="col-sm-11">
                    <input name="cpassword" type="password" class="form-control"
                           placeholder="<?php echo isset($lang['Confirm Password']) ? $lang['Confirm Password'] : 'Confirm Password'; ?>"
                           id="cpassword" size="40" required="required" autocomplete="off">
                    <small class="help-block" data-fv-validator="identical" data-fv-for="cpassword"
                           data-fv-result="NOT_VALIDATED" style="display: none;">The password and its confirm are not
                        the same
                    </small>
                    <small class="help-block" data-fv-validator="notEmpty" data-fv-for="cpassword"
                           data-fv-result="NOT_VALIDATED" style="display: none;">
                    </small>
                </div>
            </div>
            <div class="form-group has-feedback">
                <div class=" col-sm-11">
                    <div class="checkbox">
                        <button id="Termsandconditions" name="Termsandconditions" type="button"
                                class="btn btn-default btn-sm" data-toggle="modal" data-target="#termsModal">Agree with
                            the Terms &amp; Conditions
                        </button>
                        <input type="hidden" name="agree" value="no" data-fv-field="agree"><i
                            class="form-control-feedback" data-fv-icon-for="agree" style="display: none;"></i>
                    </div>
                    <small class="help-block" data-fv-validator="callback" data-fv-for="agree"
                           data-fv-result="NOT_VALIDATED" style="display: none;">You must agree with the Terms &amp;
                        Conditions
                    </small>
                </div>
            </div>
            <div class="form-group">
                <div class=" col-sm-11">
                    <button id="btnSubmit" name="btnSubmit" type="submit" class="btn btn-warning">Quak It</button>
                </div>
            </div>
            <!-- Terms and conditions modal -->
            <div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="Termsandconditions"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">Terms and Conditions</h3>
                        </div>

                        <div class="modal-body text-center">
                            <h4> PLEASE READ THE FOLLOWING TERMS AND POLICIES CAREFULLY. WHEN YOU USE QuakBox YOU
                                ACKNOWLEDGE THAT YOU HAVE READ, UNDERSTOOD, AND AGREE TO BE BOUND BY THESE TERMS AND
                                POLICIES.</h4>
                            <h4>QuakBox.com TERMS OF SERVICE</h4>
                            <p>These Terms of Service are hereby effective on January 01, 2010 and will apply to the
                                website that you are visiting, <a href="/">QuakBox.com</a>, which is owned by QuakBox
                                Inc. </p>
                            <p>Illegal or Abusive Usage is strictly Prohibited: </p>
                            <p>You must not abuse, harass, threaten, impersonate or intimidate other users of <a
                                    href="/">QuakBox.com</a>. You may not use the QuakBox.com for any illegal or
                                unauthorized purpose. International users agree to comply with all local laws regarding
                                online conduct and acceptable content. Should you be found to have engaged in illegal or
                                abusive usage of this Website (<a href="/">QuakBox.com</a>), Company will suspend/closed
                                your account or usage as applicable. </p>
                            <h5>Electronic Communication:</h5>
                            <p>When you visit <a href="/">QuakBox.com</a> or send us emails, you are communicating with
                                us electronically. You consent to receive communications from us electronically. We will
                                communicate with you by email or by posting notices on the Website. You agree that all
                                agreements, notices, disclosures and other communications that we provide to you
                                electronically satisfy any legal requirement that such communications be in writing.
                            </p>
                            <h5>Trademarks:</h5>
                            <p>QuakBox Inc. or <a href="/">QuakBox.com</a> and other Company graphics, logos, page
                                headers, button icons, scripts, and service names are trademarks, registered trademarks
                                or trade dress of Company in the U.S. and/or other countries. Company’s trademarks and
                                trade dress may not be used in connection with any product or service that is not
                                Company’s, in any manner that is likely to cause confusion among customers or in any
                                manner that disparages or discredits Company. All other trademarks not owned by QuakBox
                                Inc. or https://www.quakbox.com that appear on this site are the property of their
                                respective owners, who may or may not be affiliated with, connected to, or sponsored by
                                QuakBox Inc. or <a href="https://www.quakbox.com">QuakBox.com</a></p>
                            <h5>Your Account:</h5>
                            <p>When you use this site, you are responsible for maintaining the confidentiality of your
                                account and password and for restricting access to your computer, and you agree to
                                accept responsibility for all activities that occur under your account or password. <a
                                    href="https://www.quakbox.com">QuakBox.com</a> reserves the right to refuse service,
                                suspend/terminate accounts, remove or edit content, in their sole discretion.</p>
                            <h5>Disclaimer of Warranties and Limitation of Liability:</h5>
                            <p>this site and all information, content, materials, products (including software) and
                                services included on or otherwise made available to you through this site are provided
                                by quakbox.com on an “as is” and “as available” basis, unless otherwise specified in
                                writing. quakbox inc. or <a href="https://www.quakbox.com">QuakBox.com</a> makes no
                                representations or warranties of any kind, express or implied, as to the operation of
                                this site or the information, content, materials, products (including software) or
                                services included on or otherwise made available to you through this site, unless
                                otherwise specified in writing. you expressly agree that your use of this site is at
                                your sole risk. </p>
                            <p>To the full extent permissible by applicable law, company disclaims all warranties,
                                express or implied, including, but not limited to, implied warranties of merchantability
                                and fitness for a particular purpose. quakbox does not warrant that this site;
                                information, content, materials, products (including software) or services included on
                                or otherwise made available to you through this site; their servers; or e-mail sent from
                                quakbox are free of viruses or other harmful components. company will not be liable for
                                any damages of any kind arising from the use of this site or from any information,
                                content, materials, products (including software) or services included on or otherwise
                                made available to you through this site, including, but not limited to direct, indirect,
                                incidental, punitive, and consequential damages, unless otherwise specified in
                                writing. </p>
                            <p>Certain state laws do not allow limitations on implied warranties or the exclusion or
                                limitation of certain damages. if these laws apply to you, some or all of the above
                                disclaimers, exclusions, or limitations may not apply to you, and you might have
                                additional rights. </p>
                            <h5>Applicable Law:</h5>
                            <p>By visiting our website, you agree that the laws of the State of FL, without regard to
                                principles of conflict of laws, will govern these Terms of Service and any dispute of
                                any sort that might arise between you and Company. </p>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="agreeButton" data-dismiss="modal">Agree
                            </button>
                            <button type="button" class="btn btn-default" id="disagreeButton" data-dismiss="modal">
                                Disagree
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

</div>
<div class="footer">
    <ul class="uilist localesSelectorList _4ki list-inline">
        <li><a title="Arabic" dir="ltr" href="#"
               onclick="set_cookie_lacale('ar','<?php echo $base_url; ?>')">العربية</a></li>
        <li><a title="Bulgarian" dir="ltr" href="#" onclick="set_cookie_lacale('bg','<?php echo $base_url; ?>')">Български</a>
        </li>
        <li><a title="Catalan" dir="ltr" href="#"
               onclick="set_cookie_lacale('ca','<?php echo $base_url; ?>')">Català</a></li>
        <li><a title="Chinese Simplified" dir="ltr" href="#"
               onclick="set_cookie_lacale('zh-CHS','<?php echo $base_url; ?>')">简体中文</a></li>
        <li><a title="Chinese Traditional" dir="ltr" href="#"
               onclick="set_cookie_lacale('zh-CHT','<?php echo $base_url; ?>')">繁體中文</a></li>
        <li><a title="Czech" dir="ltr" href="#" onclick="set_cookie_lacale('cs','<?php echo $base_url; ?>')">Čeština</a>
        </li>
        <li><a title="Danish" dir="ltr" href="#" onclick="set_cookie_lacale('da','<?php echo $base_url; ?>')">Dansk</a>
        </li>
        <li><a title="Dutch" dir="ltr" href="#"
               onclick="set_cookie_lacale('nl','<?php echo $base_url; ?>')">Nederlands</a></li>
        <li><a title="English" dir="ltr" href="#"
               onclick="set_cookie_lacale('en','<?php echo $base_url; ?>')">English</a></li>
        <li><a title="Estonian" dir="ltr" href="#"
               onclick="set_cookie_lacale('et','<?php echo $base_url; ?>')">Eesti</a></li>
        <li><a title="Finnish" dir="ltr" href="#" onclick="set_cookie_lacale('fi','<?php echo $base_url; ?>')">Suomi</a>
        </li>
        <li><a title="French" dir="ltr" href="#"
               onclick="set_cookie_lacale('fr','<?php echo $base_url; ?>')">Français</a></li>
        <li><a data-toggle="modal" style="cursor:pointer;" title="More languages" data-target="#showMoreLocale">...</a>
        </li>
    </ul>
    <span class="copyright">&copy; <?php echo date('Y') ?> QuakBox &mdash; A NewSource For Interactive Social News</span>
</div>


<footer>
    <div id="pagefooter_maindiv" class="inline ">

        <div id="showMoreLocale" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><?php echo $lang['Select a Language']; ?></h4>
                    </div>
                    <ul class="localeSelectorList uiList _4kg list-inline">
                        <li><a title="Arabic" dir="ltr" href="#"
                               onclick="set_cookie_lacale('ar','<?php echo $base_url; ?>')">العربية</a></li>
                        <li><a title="Bulgarian" dir="ltr" href="#"
                               onclick="set_cookie_lacale('bg','<?php echo $base_url; ?>')">Bulgarian</a></li>
                        <li><a title="Catalan" dir="ltr" href="#"
                               onclick="set_cookie_lacale('ca','<?php echo $base_url; ?>')">Català</a></li>
                        <li><a title="Chinese Simplified" dir="ltr" href="#"
                               onclick="set_cookie_lacale('zh-CHS','<?php echo $base_url; ?>')">Chinese Simplified</a>
                        </li>
                        <li><a title="Chinese Traditional" dir="ltr" href="#"
                               onclick="set_cookie_lacale('zh-CHT','<?php echo $base_url; ?>')">Chinese Traditional</a>
                        </li>
                        <li><a title="Czech" dir="ltr" href="#"
                               onclick="set_cookie_lacale('cs','<?php echo $base_url; ?>')">Čeština</a></li>
                        <li><a title="Danish" dir="ltr" href="#"
                               onclick="set_cookie_lacale('da','<?php echo $base_url; ?>')">Dansk</a></li>
                        <li><a title="Dutch" dir="ltr" href="#"
                               onclick="set_cookie_lacale('nl','<?php echo $base_url; ?>')">Nederlands</a></li>
                        <li><a title="English" dir="ltr" href="#"
                               onclick="set_cookie_lacale('en','<?php echo $base_url; ?>')">English</a></li>
                        <li><a title="Estonian" dir="ltr" href="#"
                               onclick="set_cookie_lacale('et','<?php echo $base_url; ?>')">Eesti</a></li>
                        <li><a title="Finnish" dir="ltr" href="#"
                               onclick="set_cookie_lacale('fi','<?php echo $base_url; ?>')">Suomi</a></li>
                        <li><a title="French" dir="ltr" href="#"
                               onclick="set_cookie_lacale('fr','<?php echo $base_url; ?>')">Français</a></li>
                        <li><a title="German" dir="ltr" href="#"
                               onclick="set_cookie_lacale('de','<?php echo $base_url; ?>')">Deutsch</a></li>
                        <li><a title="Greek" dir="ltr" href="#"
                               onclick="set_cookie_lacale('el','<?php echo $base_url; ?>')">Greek</a></li>
                        <li><a title="Haitian Creole" dir="ltr" href="#"
                               onclick="set_cookie_lacale('ht','<?php echo $base_url; ?>')">Haitian Creole</a></li>
                        <li><a title="Hebrew" dir="ltr" href="#"
                               onclick="set_cookie_lacale('he','<?php echo $base_url; ?>')">עברית</a></li>
                        <li><a title="Hindi" dir="ltr" href="#"
                               onclick="set_cookie_lacale('hi','<?php echo $base_url; ?>')">िंदी</a></li>
                        <li><a title="Hmong Daw" dir="ltr" href="#"
                               onclick="set_cookie_lacale('mww','<?php echo $base_url; ?>')">Hmong Daw</a></li>
                        <li><a title="Hungarian" dir="ltr" href="#"
                               onclick="set_cookie_lacale('hu','<?php echo $base_url; ?>')">Magyar</a></li>
                        <li><a title="Indonesian" dir="ltr" href="#"
                               onclick="set_cookie_lacale('id','<?php echo $base_url; ?>')">Indonesia</a></li>
                        <li><a title="Italian" dir="ltr" href="#"
                               onclick="set_cookie_lacale('it','<?php echo $base_url; ?>')">Italiano</a></li>
                        <li><a title="Japanese" dir="ltr" href="#"
                               onclick="set_cookie_lacale('ja','<?php echo $base_url; ?>')">日本語</a></li>

                        <li><a title="Klingon" dir="ltr" href="#"
                               onclick="set_cookie_lacale('tlh','<?php echo $base_url; ?>')">Klingon</a></li>
                        <li><a title="Korean" dir="ltr" href="#"
                               onclick="set_cookie_lacale('ko','<?php echo $base_url; ?>')">한국어</a></li>
                        <li><a title="Latvian" dir="ltr" href="#"
                               onclick="set_cookie_lacale('lv','<?php echo $base_url; ?>')">Latviešu</a></li>
                        <li><a title="Lithuanian" dir="ltr" href="#"
                               onclick="set_cookie_lacale('lt','<?php echo $base_url; ?>')">Lietuvių</a></li>
                        <li><a title="Malay" dir="ltr" href="#"
                               onclick="set_cookie_lacale('ms','<?php echo $base_url; ?>')">Melayu</a></li>
                        <li><a title="Maltese" dir="ltr" href="#"
                               onclick="set_cookie_lacale('mt','<?php echo $base_url; ?>')">Il-Malti</a></li>
                        <li><a title="Norwegian" dir="ltr" href="#"
                               onclick="set_cookie_lacale('no','<?php echo $base_url; ?>')">Norsk</a></li>
                        <li><a title="Persian" dir="ltr" href="#"
                               onclick="set_cookie_lacale('fa','<?php echo $base_url; ?>')">Persian</a></li>
                        <li><a title="Polish" dir="ltr" href="#"
                               onclick="set_cookie_lacale('pl','<?php echo $base_url; ?>')">Polski</a></li>

                        <li><a title="Portuguese" dir="ltr" href="#"
                               onclick="set_cookie_lacale('pt','<?php echo $base_url; ?>')">Português</a></li>
                        <li><a title="Romanian" dir="ltr" href="#"
                               onclick="set_cookie_lacale('ro','<?php echo $base_url; ?>')">Românian</a></li>
                        <li><a title="Russian" dir="ltr" href="#"
                               onclick="set_cookie_lacale('ru','<?php echo $base_url; ?>')">Русский</a></li>
                        <li><a title="Slovak" dir="ltr" href="#"
                               onclick="set_cookie_lacale('sk','<?php echo $base_url; ?>')">Slovak</a></li>
                        <li><a title="Slovenian" dir="ltr" href="#"
                               onclick="set_cookie_lacale('sl','<?php echo $base_url; ?>')">Slovenian</a></li>
                        <li><a title="Spanish" dir="ltr" href="#"
                               onclick="set_cookie_lacale('es','<?php echo $base_url; ?>')">Spanish</a></li>
                        <li><a title="Swedish" dir="ltr" href="#"
                               onclick="set_cookie_lacale('sv','<?php echo $base_url; ?>')">Svenska</a></li>
                        <li><a title="Thai" dir="ltr" href="#"
                               onclick="set_cookie_lacale('th','<?php echo $base_url; ?>')">Thai</a></li>
                        <li><a title="Turkish" dir="ltr" href="#"
                               onclick="set_cookie_lacale('tr','<?php echo $base_url; ?>')">Türkçe</a></li>

                        <li><a title="Ukrainian" dir="ltr" href="#"
                               onclick="set_cookie_lacale('uk','<?php echo $base_url; ?>')">Ukrainian</a></li>
                        <li><a title="Urdu" dir="ltr" href="#"
                               onclick="set_cookie_lacale('ur','<?php echo $base_url; ?>')">اردو</a></li>
                        <li><a title="Vietnamese" dir="ltr" href="#"
                               onclick="set_cookie_lacale('vi','<?php echo $base_url; ?>')">Tiếng Việt</a></li>
                        <li><a title="Welsh" dir="ltr" href="#"
                               onclick="set_cookie_lacale('cy','<?php echo $base_url; ?>')">Welsh</a></li>
                    </ul>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div><!-- Modal content-->
            </div><!-- Modal dialog-->

        </div><!--showMoreLocale-->
    </div><!--locales-->


    </div><!--locales1-->
    </div><!--pagefooter_maindiv--> <!-- Developed by Naresh Shaw -->
</footer>
</div> <!-- /container -->
<script src="<?php echo $base_url; ?>js/vendor/jquery-1.11.2.min.js"></script>
<script src="<?php echo $base_url; ?>js/vendor/bootstrap.min.js"></script>
<script src="<?php echo $base_url; ?>js/plugins.js"></script>
<script src="<?php echo $base_url; ?>js/main.js"></script>
<script src="<?php echo $base_url; ?>assets/formvalidation/dist/js/formValidation.min.js"></script>
<script src="<?php echo $base_url; ?>assets/formvalidation/dist/js/framework/bootstrap.min.js"></script>
<!--<script src="https://microsofttranslator.com/ajax/v3/widgetv3.ashx" type="text/javascript"></script>-->
<script src="<?php echo $base_url; ?>js/translate_page.js" type="text/javascript"></script>
<script src="<?php echo $base_url . 'assets/birthday_picker/js/jquery-birthday-picker.min.js'; ?>"></script>
<script type="text/javascript">
    $("#birthdayPicker").birthdayPicker();
</script>
<script type="text/javascript">
    $(document).ready(function () {

        $('#regform').formValidation({
            framework: 'bootstrap',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                username: {
                    validators: {
                        notEmpty: {
                            message: 'The username is required'
                        },
                        stringLength: {
                            min: 6,
                            max: 30,
                            message: 'The username must be more than 6 and less than 30 characters long'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z 0-9_]+$/,
                            message: 'The username can only consist of alphabetical, number, dot and underscore'
                        },
                        blank: {}
                    }
                },
                qbemail: {
                    validators: {
                        notEmpty: {
                            message: 'The QuakBox email address is required'
                        },
                        blank: {}

                    }
                },
                email: {
                    validators: {
                        notEmpty: {
                            message: 'The email address is required'
                        },
                        emailAddress: {
                            message: 'The input is not a valid email address'
                        },
                        blank: {}

                    }
                },
                'birth[month]': {
                    validators: {
                        notEmpty: {
                            message: 'Please select a Month.'
                        }
                    }
                },
                'birth[day]': {
                    validators: {
                        notEmpty: {
                            message: 'Please select a Day.'
                        }
                    }
                },
                'birth[year]': {
                    validators: {
                        notEmpty: {
                            message: 'Please select a Year.'
                        }
                    }
                },
                password: {
                    validators: {
                        notEmpty: {
                            message: 'The password is required'
                        },
                        different: {
                            field: 'username',
                            message: 'The password cannot be the same as username'
                        },
                        stringLength: {
                            min: 8,
                            max: 30,
                            message: 'The Password must be more than 8 and less than 30 characters long'
                        }
                    }
                },
                cpassword: {
                    validators: {
                        identical: {
                            field: 'password',
                            message: 'Your password and confirmation password do not match'
                        }
                    }
                },
                agree: {
                    // The plugin will ignore the hidden field
                    // By setting excluded: false, the field will be validated as usual
                    excluded: false,
                    validators: {
                        callback: {
                            message: 'You must agree with the Terms & Conditions',
                            callback: function (value, validator, $field) {
                                return value === 'yes';
                            }
                        }
                    }
                }
            }
        })
            .on('success.form.fv', function (e) {
                e.preventDefault();

                var $form = $(e.target),
                    fv = $form.data('formValidation');
                var url = "load_data/email_ajax.php";

                $.ajax({
                    url: url,
                    data: $form.serialize(),
                    dataType: 'json'
                }).success(function (response) {
                    // If there is error returned from server
                    if (response.result === 'error') {
                        for (var field in response.fields) {
                            fv
                            // Show the custom message
                                .updateMessage(field, 'blank', response.fields[field])
                                // Set the field as invalid
                                .updateStatus(field, 'INVALID', 'blank');
                        }
                    } else {
                        fv.defaultSubmit();
                    }
                });
            });

        // Update the value of "agree" input when clicking the Agree/Disagree button
        $('#agreeButton, #disagreeButton').on('click', function () {
            var whichButton = $(this).attr('id');

            $('#regform')
                .find('[name="agree"]')
                .val(whichButton === 'agreeButton' ? 'yes' : 'no')
                .end()
                // Revalidate the field manually
                .formValidation('revalidateField', 'agree');
        });


        $('#form-login').formValidation({
            framework: 'bootstrap',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                login: {
                    validators: {
                        notEmpty: {
                            message: 'This feild is required'
                        }
                    }
                },
                password: {
                    validators: {
                        notEmpty: {
                            message: 'The password is required'
                        }
                    }
                }
            }
        });


    });
</script>
<script type="text/javascript">
    function set_cookie_lacale(lang, url) {

        $.ajax({
            type: "POST",
            url: "lang.php",
            data: {lang: lang},
            cache: false,
            success: function (html) {
                $("#lang").html(html);
                document.cookie = 'lang=' + lang;
                window.location = url;
            }
        });

    }
</script>


</body>
</html>