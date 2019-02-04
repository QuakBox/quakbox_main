<?php
//Start session
ob_start();
session_start();

//Include database connection details
require_once($_SERVER['DOCUMENT_ROOT'] . '/common/common.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/qb_classes/qb_member1.php');
$memberObject = new member1();

//Array to store validation errors
$errmsg_arr = array();

//Validation error flag
$errflag = false;

$member_id = htmlspecialchars(trim($_SESSION['SESS_MEMBER_ID']));

$name = clean($_POST['name'], $con);

$tempPass = $_POST['value'];
$password = $_POST['value'];
$hash = hash('sha256', $password);
$salt = genUid();
$password = hash('sha256', $salt . $hash);

$err = false;
$err1 = array();//for username
$err2 = array();//for error
$json = array();

if ($name == 'password' && $tempPass != '') {
    $memberResult = $memberObject->update_member_meta($member_id, "temp_pwd", $tempPass);
    if ($memberResult) {
        $memberResult = $memberObject->update_member_columns($member_id, "password", $password);
        $memberResult = $memberObject->update_member_columns($member_id, "salt", $salt);
    }
    if (!$memberResult) {
        $err = true;
        $err1 = array("password" => "Query Failed");
    }


    $json = array_merge($err1, $err2);

    if ($err) {
        echo json_encode(array(
            "errors" => $json
        ));
    } else {
        $member = $memberObject->getMemberById($member_id);
        if(!empty($member)){
            require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/qb_vmin.php');
            $vmin = new qb_vmin();
            $vmin->modifyUser($member['qbemail'], $tempPass);
        }

        echo json_encode(array(
            "result" => "ok"
        ));
    }
} else {
    header('HTTP 400 Bad Request', true, 400);
    echo "This field is required!";
}
