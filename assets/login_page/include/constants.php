<?
if(!defined("DB_SERVER") || DB_SERVER=="" )
{define("DB_SERVER", "localhost");
	const DB_SERVER = "localhost";
}
if(!defined("DB_USER") || DB_USER==""){
	define("DB_USER", "qbdevqb_main");
	const DB_USER = "qbdevqb_main";
}

/*if(!defined("DB_PASS"))
define("DB_PASS", "1@QBdevMaiN#;NC");*/
if(!defined("DB_PASS") || DB_PASS==""){
	define("DB_PASS", "uB#{(J;6rQ-o");
	const DB_PASS = "uB#{(J;6rQ-o";
}

if(!defined("DB_NAME") || DB_NAME=="" ){
	define("DB_NAME", "qbdevqb_maindb");
	const DB_NAME = "qbdevqb_maindb";
}

define("TBL_USERS", "users");
const TBL_USERS = "users";
define("TBL_ATTEMPTS", "login_attempts");
const TBL_ATTEMPTS = "login_attempts";
define("ATTEMPTS_NUMBER", "3");
const ATTEMPTS_NUMBER = "3";
define("TIME_PERIOD", "30");
const TIME_PERIOD = "30";
define("COOKIE_EXPIRE", 60*60*24*100);      //100 days by default
const COOKIE_EXPIRE = "60*60*24*100";
define("COOKIE_PATH", "/");                 //Avaible in whole domain
const COOKIE_PATH = "/";
