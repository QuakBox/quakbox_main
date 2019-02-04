<?php 

ob_start();

	//Include database connection details
	require_once('../config.php');
	
	function makeLink($string){

/*** make sure there is an http:// on all URLs ***/
//$string = preg_replace_callback("/([^\w\/])(www\.[a-z0-9\-]+\.[a-z0-9\-]+)/i", "$1http://$2",$string);
/*** make all URLs links ***/
$string = preg_replace_callback("/([\w]+:\/\/[\w-?&;#~=\.\/\@]+[\w\/])/i",function ($matches) {return "<a target=\"_blank\" href=\"$matches[1]\">$matches[1]</a>";},$string);
/*** make all emails hot links ***/
//$string = preg_replace_callback("/([\w-?&;#~=\.\/]+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?))/i","<A HREF=\"mailto:$1\">$1</A>",$string);

return $string;
}

function _make_url_clickable_cb($matches) {
	$ret = '';
	$url = $matches[2];
 
	if ( empty($url) )
		return $matches[0];
	// removed trailing [.,;:] from URL
	if ( in_array(substr($url, -1), array('.', ',', ';', ':')) === true ) {
		$ret = substr($url, -1);
		$url = substr($url, 0, strlen($url)-1);
	}
	return $matches[1] . "<a href=\"$url\" rel=\"nofollow\">$url</a>" . $ret;
}

function _make_web_ftp_clickable_cb($matches) {
	$ret = '';
	$dest = $matches[2];
	$dest = 'http://' . $dest;
 
	if ( empty($dest) )
		return $matches[0];
	// removed trailing [,;:] from URL
	if ( in_array(substr($dest, -1), array('.', ',', ';', ':')) === true ) {
		$ret = substr($dest, -1);
		$dest = substr($dest, 0, strlen($dest)-1);
	}
	return $matches[1] . "<a href=\"$dest\" rel=\"nofollow\" target=\"_blank\">$dest</a>" . $ret;
}
 
function _make_email_clickable_cb($matches) {
	$email = $matches[2] . '@' . $matches[3];
	return $matches[1] . "<a href=\"mailto:$email\">$email</a>";
}
 
function make_clickable($ret) {
	$ret = ' ' . $ret;
	// in testing, using arrays here was found to be faster
	$ret = preg_replace_callback('#([\s>])([\w]+?://[\w\\x80-\\xff\#$%&~/.\-;:=,?@\[\]+]*)#is', '_make_url_clickable_cb', $ret);
	$ret = preg_replace_callback('#([\s>])((www|ftp)\.[\w\\x80-\\xff\#$%&~/.\-;:=,?@\[\]+]*)#is', '_make_web_ftp_clickable_cb', $ret);
	$ret = preg_replace_callback('#([\s>])([.0-9a-z_+-]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,})#i', '_make_email_clickable_cb', $ret);
 
	// this one is not in an array because we need it to run last, for cleanup of accidental links within links
	$ret = preg_replace_callback("#(<a( [^>]+?>|>))<a [^>]+?>([^>]+?)</a></a>#i", 
	function($matches){
	return $matches[1].$matches[3]."</a>";
	}, $ret);
	$ret = trim($ret);
	return $ret;
}
	
	//Sanitize the POST values
	$member_id   = f($_POST['member_id'], 'strip');
$member_id	 = 	f($member_id, 'escapeAll');
$member_id   = mysqli_real_escape_string($con, $member_id);

$msg_to   = f($_POST['msg_to'], 'strip');
$msg_to	 = 	f($msg_to, 'escapeAll');
$msg_to   = mysqli_real_escape_string($con, $msg_to);

$message_body   = f($_POST['message_body'], 'escapeAll');
$message_body   = mysqli_real_escape_string($con, $message_body);
$message_body = make_clickable($message_body);

$time = time();
	$sql = mysqli_query($con, "select * from member where username ='".$msg_to."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);
	$user = $res['member_id'];
        $url = $base_url."messages.php?username=".$user;	
	//Insert query
	$sql = "insert into cometchat(cometchat.from,cometchat.to,cometchat.message,cometchat.sent,cometchat.read) values('$member_id','$user','".$message_body."','$time',1)";
	$result = mysqli_query($con, $sql) or die(mysqli_error($con));	
	
	//Check whether the query was successful or not
	if($result) 
	{	
		header("location: ".$url);
		exit();		
	}
?>