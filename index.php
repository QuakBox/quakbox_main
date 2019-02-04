<?php 

ob_start();
session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');


 header("location:".$site_landing."");
