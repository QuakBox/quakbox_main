<?php

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* ADVANCED */

define('SET_SESSION_NAME','');			// Session name
define('SWITCH_ENABLED','0');
define('INCLUDE_JQUERY','1');
define('FORCE_MAGIC_QUOTES','0');

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* DATABASE */

// DO NOT EDIT DATABASE VALUES BELOW
// DO NOT EDIT DATABASE VALUES BELOW
// DO NOT EDIT DATABASE VALUES BELOW

define('DB_SERVER',			"localhost"				);
define('DB_PORT',			"3306"					);
define('DB_USERNAME',			"wwwquakb_main"					);
define('DB_PASSWORD',			"uB#{(J;6rQ-o"				);
define('DB_NAME',			"wwwquakb_maindb"				);
if(defined('USE_CCAUTH') && USE_CCAUTH == '0'){
define('TABLE_PREFIX',			""					);
define('DB_USERTABLE',			"member"					);
define('DB_USERTABLE_USERID',		"member_id"				);
define('DB_USERTABLE_NAME',		"username"				);
define('DB_AVATARTABLE',		"member_meta"					);
define('DB_AVATARFIELD',	        "meta_value"                                     );


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* FUNCTIONS */

	function getUserID() {
	$userid = 0;	
	if (!empty($_SESSION['basedata']) && $_SESSION['basedata'] != 'null') {
		$_REQUEST['basedata'] = $_SESSION['basedata'];
	}
	
	if (!empty($_REQUEST['basedata'])) {
	
		if (function_exists('mcrypt_encrypt')) {
			$key = KEY_A.KEY_B.KEY_C;
			$uid = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($_REQUEST['basedata']), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
			if (intval($uid) > 0) {
				$userid = $uid;
			}
		} else {
			$userid = $_REQUEST['basedata'];
		}
	}
	if (!empty($_SESSION['SESS_MEMBER_ID'])) {
		$userid = $_SESSION['SESS_MEMBER_ID'];
	}
	if (!empty($_SESSION['userid'])) {
		$userid = $_SESSION['userid'];
	}
	

	$userid = intval($userid);
//echo getFriendsList($userid,time());
	//echo getFriendsIds($userid);
	return $userid;
	
}	

function chatLogin($userName,$userPass) {

	$userid = 0;
	if (filter_var($userName, FILTER_VALIDATE_EMAIL)) {
		$sql = ("SELECT * FROM `".TABLE_PREFIX.DB_USERTABLE."` WHERE email ='".$userName."'");
	} else {
		$sql = ("SELECT * FROM `".TABLE_PREFIX.DB_USERTABLE."` WHERE username ='".$userName."'"); 
	}
	$result = mysqli_query($GLOBALS['dbh'],$sql);
	$row = mysqli_fetch_array($result);
	$salted_password = md5($row['value'].$userPass.$row['salt']);
	if($row['password'] == $salted_password) {
		$userid = $row['user_id'];
                if (isset($_REQUEST['callbackfn']) && $_REQUEST['callbackfn'] == 'mobileapp') {
                    $sql = ("insert into cometchat_status (userid,isdevice) values ('".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."','1') on duplicate key update isdevice = '1'");
                    mysqli_query($GLOBALS['dbh'], $sql);
                }
	}
	if($userid && function_exists('mcrypt_encrypt')) {
		$key = KEY_A.KEY_B.KEY_C;
		$userid = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $userid, MCRYPT_MODE_CBC, md5(md5($key))));
	}

	return $userid;
}



function getFriendsList($userid,$time) {
	global $hideOffline;
	$offlinecondition = '';
    $sql = ("select DISTINCT ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." userid, ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_NAME." username, ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_NAME." link, member_meta.meta_value avatar, cometchat_status.lastactivity lastactivity, cometchat_status.lastseen lastseen, cometchat_status.lastseensetting lastseensetting, cometchat_status.status, cometchat_status.message, cometchat_status.isdevice from member_meta , ".TABLE_PREFIX."friendlist join ".TABLE_PREFIX.DB_USERTABLE." on  ".TABLE_PREFIX."friendlist.member_id = ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." join cometchat_status on ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." = cometchat_status.userid where ".TABLE_PREFIX."friendlist.added_member_id = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."' AND ( member_meta.meta_key =  'current_profile_image' AND friendlist.member_id = member_meta.member_id) and (cometchat_status.status IS NULL OR cometchat_status.status <> 'invisible' OR cometchat_status.status <> 'offline') order by username asc");
/*
	if ((defined('MEMCACHE') && MEMCACHE <> 0) || DISPLAY_ALL_USERS == 1) {
			if ($hideOffline) {
				$offlinecondition = "where ((cometchat_status.lastactivity > (".mysqli_real_escape_string($GLOBALS['dbh'],$time)."-".((ONLINE_TIMEOUT)*2).")) OR cometchat_status.isdevice = 1) and (cometchat_status.status IS NULL OR cometchat_status.status <> 'invisible' OR cometchat_status.status <> 'offline')";
			}
			$sql = ("select ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." userid, ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_NAME." username, ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_NAME." link, member_meta.meta_value avatar, cometchat_status.lastactivity lastactivity, cometchat_status.status, cometchat_status.message, cometchat_status.isdevice from member_meta ,   ".TABLE_PREFIX.DB_USERTABLE."   left join cometchat_status on ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." = cometchat_status.userid ".$offlinecondition ." order by username asc");
		}
*/
		return $sql;
		
}
	
function getFriendsIds($userid) {
//$sql = ("select group_concat(" . TABLE_PREFIX . "friendlist.member_id) myfrndids from " . TABLE_PREFIX . "friendlist where " . TABLE_PREFIX . "friendlist.added_member_id = '" . mysqli_real_escape_string($GLOBALS['dbh'], $userid) . "' and " . TABLE_PREFIX . "friendlist.status = 1");
//echo $sql;

 $sql = ("select group_concat(friendlist.myfrndids) myfrndids from (SELECT member_id as myfrndids FROM 'friendlist' WHERE status = '1' and added_member_id = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."' union SELECT added_member_id as myfrndids FROM 'friendlist' WHERE status = '1' 
		 and member_id = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."') 'friendlist' ");
		

	return $sql;
}


function getUserDetails($userid) {
/*
	$sql = ("select ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." userid, ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_NAME." username, ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_NAME." link, x.".DB_AVATARFIELD." avatar, cometchat_status.lastactivity lastactivity, cometchat_status.status, cometchat_status.message, cometchat_status.isdevice from (select ".DB_AVATARTABLE.".".DB_AVATARFIELD." from ".DB_AVATARTABLE." where ".DB_AVATARTABLE.".meta_key='current_profile_image' and ".DB_AVATARTABLE.".".DB_USERTABLE_USERID."= '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."' ) x, ".TABLE_PREFIX.DB_USERTABLE." left join cometchat_status on ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." = cometchat_status.userid where ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."'"); */
	
	$sql = ("select member.member_id userid, member.username username, member.username link, x.meta_value avatar, cometchat_status.lastactivity lastactivity, cometchat_status.lastseen lastseen, cometchat_status.lastseensetting lastseensetting, cometchat_status.status, cometchat_status.message, cometchat_status.isdevice from (select member_meta.meta_value from member_meta where member_meta.meta_key='current_profile_image' and member_meta.member_id='".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."' ) x, member left join cometchat_status on member.member_id = cometchat_status.userid where member.member_id = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."' ");

	return $sql;
}


function getUserStatus($userid) {
	 $sql = ("select cometchat_status.message, cometchat_status.status from cometchat_status where userid = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."'");

	 return $sql;
}

function fetchLink($link) {
	
        return 'https://quakbox.com/'.$link;
}

function getAvatar($image) {
        if ($image) {
        return 'https://quakbox.com/'.$image;
    } else {
        return 'https://quakbox.com/images/default.png';
    }
}

	function getTimeStamp() {
		return time();
	}

	function processTime($time) {
		return $time;
	}

	if (!function_exists('getLink')) {
	  	function getLink($userid) { return fetchLink($userid); }
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	/* HOOKS */

	function hooks_statusupdate($userid,$statusmessage) {

	}

	function hooks_forcefriends() {

	}

	function hooks_activityupdate($userid,$status) {

	}

	function hooks_message($userid,$to,$unsanitizedmessage) {

	}

	function hooks_updateLastActivity($userid) {

	}
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* LICENSE */

include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'license.php');
$x="\x62a\x73\x656\x34\x5fd\x65c\157\144\x65";
eval($x('JHI9ZXhwbG9kZSgnLScsJGxpY2Vuc2VrZXkpOyRwXz0wO2lmKCFlbXB0eSgkclsyXSkpJHBfPWludHZhbChwcmVnX3JlcGxhY2UoIi9bXjAtOV0vIiwnJywkclsyXSkpOw'));

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////