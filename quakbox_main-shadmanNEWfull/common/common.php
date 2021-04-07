<?php
/**
 * Common Includes
 * Common files willbe included inside this file for reference
 *
 */

ob_start();
if (!isset($_SESSION)) {
    session_start();
}

error_reporting(-1); //enables only on test
include_once($_SERVER['DOCUMENT_ROOT'] . '/common/qb_config.php'); //CONFIGURATION FILE
include_once($_SERVER['DOCUMENT_ROOT'] . '/common/qb_security.php');//SECURITY FILE
// include session              // SESSION FILE
//require_once("qb_log.php");//LOG FILE
//include_once("qb_global_variables.php"); //GLOBAL VARIABLES FILE
include_once($_SERVER['DOCUMENT_ROOT'] . '/common/qb_validation.php'); //COMMON VALIDATION CLASS
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/time_stamp.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/tolink.php');

if (!isset($_SESSION['SESS_MEMBER_ID'])) {

    header("location:" . $base_url . "login.php?back=" . urlencode($_SERVER['REQUEST_URI']));
}

if (isset($_SESSION['lang'])) {
    include_once($root_folder_path . 'public_html/common.php');
} else {
    include_once($root_folder_path . 'public_html/Languages/en.php');
}
