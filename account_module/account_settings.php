<?php
error_reporting(-1);
require_once($_SERVER['DOCUMENT_ROOT'] . '/common/qb_session.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/common/common.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/qb_header.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/common/qb_security.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/qb_classes/qb_member1.php');
$objMember = new member1();
$lookupObject = new lookup();
$member_id = htmlspecialchars(trim($_SESSION['SESS_MEMBER_ID']));
$sql = mysqli_query($con, "select * from member where member_id='" . $member_id . "'") or die(mysqli_error($con));
$res = mysqli_fetch_array($sql);
$username = $res['username'];
$email = $res['email'];
$first_name = $objMember->select_member_meta_value($member_id, "first_name");
$last_name = $objMember->select_member_meta_value($member_id, "last_name");
$language = $objMember->select_member_meta_value_for_lookupID($member_id, "language_known");

?>
    <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jquery-editable/css/jquery-editable.css" rel="stylesheet"/>
    <link href="/js/poshytip/tip-yellowsimple/tip-yellowsimple.css" rel="stylesheet"/>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.2/moment.min.js"></script>
    <script src="/js/poshytip/jquery.poshytip.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jquery-editable/js/jquery-editable-poshytip.min.js"></script>
    <script type="text/javascript">

        jQuery(function () {
            $('#change_name').editable({
                type: 'text',
                pk: 1,
                name: 'member_name',
                url: window.location.origin + '/action/change_name.php',
                title: 'Enter First Name',
                validate: function (value) {
                    var regexname = /^[a-zA-Z ]*$/;
                    if ($.trim(value) == '') {
                        return 'This field is required';
                    } else if (!regexname.test(value)) {
                        return 'The First Name can only consist of alphabets';
                    }
                }
            });

            $('#change_lname').editable({
                type: 'text',
                pk: 1,
                name: 'l_member_name',
                url: window.location.origin + '/action/change_lname.php',
                title: 'Enter Last Name',
                validate: function (value) {
                    var regexname = /^[a-zA-Z ]*$/;
                    if ($.trim(value) == '') {
                        return 'This field is required';
                    } else if (!regexname.test(value)) {
                        return 'The Last Name can only consist of alphabets';
                    }
                }
            });

            $('#change_username').editable({
                type: 'text',
                pk: 1,
                name: 'username',
                url: window.location.origin + '/action/change_username-exec.php',
                title: 'Enter Username',
                validate: function (value) {
                    var regexname = /^[a-zA-Z 0-9_\.]+$/;
                    if ($.trim(value) == '') {
                        return 'This field is required';
                    } else if ($.trim(value).length < 6 || $.trim(value).length > 30) {
                        return 'The username must be more than 6 and less than 30 characters long';
                    } else if (!regexname.test(value)) {
                        return 'The username can only consist of alphabetical, number, dot and underscore';
                    }
                },
                success: function (data, config) {
                    obj = JSON && JSON.parse(data) || $.parseJSON(data);
                    var msg = '';
                    if (obj && obj.result) {  //record created, response like {"id": 2}
                        //proceed success...
                        msg = 'Successfully Updated';
                    } else if (obj && obj.errors) {              //validation error

                        $.each(obj.errors, function (k, v) {
                            msg += k + ": " + v + "<br>";
                        });

                    } else if (obj.responseText) {   //ajax error
                        msg = obj.responseText;
                    }

                    $('#msg').html(msg);
                    $('#msg').show();
                }
            });

            $('#change_email').editable({
                type: 'text',
                pk: 1,
                name: 'email',
                url: window.location.origin + '/action/change_email-exec.php',
                title: 'Enter Email',
                validate: function (value) {
                    var regexname = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                    if ($.trim(value) == '') {
                        return 'This field is required';
                    } else if (!regexname.test(value)) {
                        return 'The input is not a valid email address';
                    }
                },
                success: function (data, config) {
                    obj = JSON && JSON.parse(data) || $.parseJSON(data);
                    var msg = '';
                    if (obj && obj.result) {  //record created, response like {"id": 2}
                        //proceed success...
                        msg = 'Successfully Updated';
                    } else if (obj && obj.errors) {              //validation error

                        $.each(obj.errors, function (k, v) {
                            msg += k + ": " + v + "<br>";
                        });

                    } else if (obj.responseText) {   //ajax error
                        msg = obj.responseText;
                    }

                    $('#msg').html(msg);
                    $('#msg').show();
                }
            });

            $('#change_password').editable({
                display: false,
                pk: 1,
                name: 'password',
                url: window.location.origin + '/action/change_password-exec.php',
                title: 'Enter Password',
                validate: function (value) {
                    if ($.trim(value) == '') {
                        return 'This field is required';
                    } else if ($.trim(value).length < 8 || $.trim(value).length > 30) {
                        return 'The Password must be more than 8 and less than 30 characters long';
                    }
                },
                success: function (data, config) {
                    obj = JSON && JSON.parse(data) || $.parseJSON(data);
                    var msg = '';
                    if (obj && obj.result) {  //record created, response like {"id": 2}
                        //proceed success...
                        msg = 'Successfully Updated';
                    } else if (obj && obj.errors) {              //validation error

                        $.each(obj.errors, function (k, v) {
                            msg += k + ": " + v + "<br>";
                        });

                    } else if (obj.responseText) {   //ajax error
                        msg = obj.responseText;
                    }

                    $('#msg').html(msg);
                    $('#msg').show();
                }
            });

            $('#change_lang').editable({
                value: null,
                source: [
                    {value: 36, text: 'Arabic'},
                    {value: 37, text: 'Bosnian (Latin)'},
                    {value: 38, text: 'Bulgarian'},
                    {value: 39, text: 'Catalan'},
                    {value: 40, text: 'Chinese Simplified'},
                    {value: 41, text: 'Chinese Traditional'},
                    {value: 42, text: 'Croatian'},
                    {value: 43, text: 'Czech'},
                    {value: 44, text: 'Danish'},
                    {value: 45, text: 'Dutch'},
                    {value: 46, text: 'English'},
                    {value: 47, text: 'Estonian'},
                    {value: 48, text: 'Finnish'},
                    {value: 49, text: 'French'},
                    {value: 50, text: 'German'},
                    {value: 51, text: 'Greek'},
                    {value: 52, text: 'Haitian Creole'},
                    {value: 53, text: 'Hebrew'},
                    {value: 54, text: 'Hindi'},
                    {value: 55, text: 'Hmong Daw'},
                    {value: 56, text: 'Hungarian'},
                    {value: 57, text: 'Indonesian'},
                    {value: 58, text: 'Italian'},
                    {value: 59, text: 'Japanese'},
                    {value: 60, text: 'Klingon'},
                    {value: 61, text: 'Klingon (pIqaD)'},
                    {value: 62, text: 'Korean'},
                    {value: 63, text: 'Latvian'},
                    {value: 64, text: 'Lithuanian'},
                    {value: 65, text: 'Malay'},
                    {value: 66, text: 'Maltese'},
                    {value: 67, text: 'Norwegian'},
                    {value: 68, text: 'Persian'},
                    {value: 69, text: 'Polish'},
                    {value: 70, text: 'Portuguese'},
                    {value: 71, text: 'Queretaro Otomi'},
                    {value: 72, text: 'Romanian'},
                    {value: 73, text: 'Russian'},
                    {value: 74, text: 'Serbian (Cyrillic)'},
                    {value: 75, text: 'Serbian (Latin)'},
                    {value: 76, text: 'Slovak'},
                    {value: 77, text: 'Slovenian'},
                    {value: 78, text: 'Spanish'},
                    {value: 79, text: 'Swedish'},
                    {value: 80, text: 'Thai'},
                    {value: 81, text: 'Turkish'},
                    {value: 82, text: 'Ukrainian'},
                    {value: 83, text: 'Urdu'},
                    {value: 84, text: 'Vietnamese'},
                    {value: 85, text: 'Welsh'},
                    {value: 86, text: 'Yucatec Maya'}
                ],
                name: 'language_known',
                url: window.location.origin + '/action/change_language-exec.php',
                title: 'Enter Language',
                validate: function (value) {
                    if ($.trim(value) == '') {
                        return 'This field is required';
                    }
                }
            });

        });
    </script>

    <div class="insideWrapper container">
        <div class="col-lg-8" style="background:#fff;">


            <h2><?php echo $lang['Account Setting']; ?></h2>
            <ul class="nav nav-pills">
                <li role="presentation"><a href="<?php echo SITE_URL; ?>/privacy.php"><?php echo $lang['Privacy']; ?></a></li>
                <li role="presentation"><a href="<?php echo SITE_URL; ?>/blocking.php"><?php echo $lang['Blocking']; ?></a></li>
                <li role="presentation" class="active"><a href="<?php echo SITE_URL; ?>/account_settings.php"><?php echo $lang['Account Settings']; ?></a></li>
                <li role="presentation"><a href="<?php echo SITE_URL; ?>/delete_account.php"><?php echo $lang['deactivate account']; ?></a></li>
            </ul>

            <h2><?php echo $lang['Edit your account settings']; ?></h2>
            <div id="msg" class="alert alert-danger" role="alert" style="display:none;"></div>
            <table class="table table-hover">
                <tr>
                    <td><h5 class="SettingsListItemLabel pls"> <?php echo $lang['First Name']; ?></h5></td>
                    <td><a href="javascript:void(0);" id="change_name"><span class="SettingsListItemContent"><strong><?php if ($first_name == null) { echo 'Add First Name'; } else { echo $first_name; } ?></strong></span></a></td>
                </tr>
                <tr>
                    <td><h5 class="SettingsListItemLabel pls"><?php echo $lang['Last Name']; ?></h5></td>
                    <td><a href="javascript:void(0);" class="SettingsListLink pvm phs" id="change_lname"><span class="SettingsListItemContent"><strong><?php if ($last_name == null) { echo 'Add Last Name'; } else { echo $last_name; } ?></strong></span></a></td>
                </tr>

                <tr>
                    <td><h5 class="SettingsListItemLabel pls"><?php echo $lang['Username']; ?></h5></td>
                    <td><a href="javascript:void(0);" class="SettingsListLink pvm phs" id="change_username"><span class="SettingsListItemContent"><strong><?php if ($username == null) { echo 'Add Username'; } else { echo $username; } ?></strong></span></a></td>
                </tr>
                <tr>
                    <td><h5 class="SettingsListItemLabel pls"><?php echo $lang['Email']; ?></h5></td>
                    <td><a href="javascript:void(0);" class="SettingsListLink pvm phs" id="change_email"><span class="SettingsListItemContent"><strong><?php if ($email == null) { echo 'Add Email'; } else { echo $email; } ?></strong></span></a></td>
                </tr>
                <tr>
                    <td><h5 class="SettingsListItemLabel pls"><?php echo $lang['Password']; ?></h5></td>
                    <td><a href="javascript:void(0);" data-type="password" class="SettingsListLink pvm phs" id="change_password"><span class="SettingsListItemContent"><strong><?php echo $lang['Change password']; ?></strong></span></a></td>
                </tr>
                <tr>
                    <td><h5 class="SettingsListItemLabel pls"><?php echo $lang['Language']; ?></h5></td>
                    <td><a href="javascript:void(0);" class="SettingsListLink pvm phs" data-type="select" data-pk="1" id="change_lang"><span class="SettingsListItemContent"><strong><?php if ($language == null) { echo 'Add Language'; } else { echo $language; } ?></strong></span></a>
                    </td>
                </tr>
            </table>
        </div>
<?php
    include($_SERVER['DOCUMENT_ROOT'] . '/includes/qb_footer.php');
?>