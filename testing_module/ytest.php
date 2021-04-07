<?php
ob_start();
session_start();

//Include database connection details
require_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_log.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_registration_class.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_lookup.php');


$salt = genUid();
echo $salt;