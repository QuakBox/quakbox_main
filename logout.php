<?php
	//Start session
	session_start();
	require_once('config.php');
	//Unset the variables stored in session
	unset($_SESSION['SESS_MEMBER_ID']);
	unset($_SESSION['SESS_FIRST_NAME']);
	unset($_SESSION['SESS_LAST_NAME']);
	unset($_SESSION['userid']);
	session_unset() ;
	session_destroy();
	$year = time() - 2592000;
	unset($_COOKIE['remember_me']);
	setcookie ("remember_me", "", $year);
	header("location: ".$base_url."landing.php");
	exit();
?>