<?php ob_start();
session_start(); 
function makeLink($string){

/*** make sure there is an http:// on all URLs ***/
//$string = preg_replace_callback("/([^\w\/])(www\.[a-z0-9\-]+\.[a-z0-9\-]+)/i", "$1http://$2",$string);
/*** make all URLs links ***/
$string = preg_replace_callback("/([\w]+:\/\/[\w-?&;#~=\.\/\@]+[\w\/])/i",'_make_url_clickable_cb',$string);
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
 function callback_chars($matches)
{
return '$1$3</a>';	
}
function make_clickable($ret) {
	$ret = ' ' . $ret;
	// in testing, using arrays here was found to be faster
	$ret = preg_replace_callback('#([\s>])([\w]+?://[\w\\x80-\\xff\#$%&~/.\-;:=,?@\[\]+]*)#is', '_make_url_clickable_cb', $ret);
	$ret = preg_replace_callback('#([\s>])((www|ftp)\.[\w\\x80-\\xff\#$%&~/.\-;:=,?@\[\]+]*)#is', '_make_web_ftp_clickable_cb', $ret);
	$ret = preg_replace_callback('#([\s>])([.0-9a-z_+-]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,})#i', '_make_email_clickable_cb', $ret);
 
	// this one is not in an array because we need it to run last, for cleanup of accidental links within links
	$ret = preg_replace_callback("#(<a( [^>]+?>|>))<a [^>]+?>([^>]+?)</a></a>#i", 'callback_chars', $ret);
	$ret = trim($ret);
	return $ret;
}

	//Include database connection details
	require_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/time_stamp.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/tolink.php');	
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
	$objMember = new member1();
	//Sanitize the POST values
	$member_id = mysqli_real_escape_string($con, f( $_SESSION['SESS_MEMBER_ID'],'escapeAll'));	
	$msg_to = mysqli_real_escape_string($con, f($_POST['msgto_member_id'],'escapeAll'));	
	$message_body = mysqli_real_escape_string($con, f($_POST['reply'],'escapeAll'));
	$message_body = make_clickable($message_body);
	$time = time();
	$sql = mysqli_query($con, "select * from member where member_id ='".$msg_to."'") or die(mysqli_error());
	$res = mysqli_fetch_array($sql);
	$user = $res['username'];
    $url = $base_url."messages.php?username=".$msg_to;	
	//Insert query
	$sql = "insert into cometchat(cometchat.from,cometchat.to,cometchat.message,cometchat.sent,cometchat.read) values('$member_id','$msg_to','".$message_body."','$time',0)";
	$result = mysqli_query($con, $sql) or die(mysqli_error($con));
	$msg_id = mysqli_insert_id($con);	

$msgquery = "select msg.read,msg.id,m.username,msg.from,msg.to, msg.message,msg.sent,m.member_id from cometchat msg,member m WHERE msg.from = m.member_id AND (msg.from ='$msg_to' OR msg.to ='$msg_to') AND id = '$msg_id' ORDER BY msg.id desc LIMIT 1";
$msgsql = mysqli_query($con, $msgquery) or die(mysqli_error($con));
$checkboxlength=0;
$divid=0;

//$msg_count = mysqli_num_rows($msg_sql);

while($mres = mysqli_fetch_array($msgsql)) {
	if(($mres['from'] == $member_id and $mres['to'] == $msg_to) or ($mres['to'] == $member_id and $mres['from'] == $msg_to)) { 
	$media = $objMember->select_member_meta_value($mres['member_id'],'current_profile_image');
if(!$media)
$media = "images/default.png";
$media=$base_url.$media;



////////////////////////////////////////////////////
/////////////////// Send Notification Message 
// 1- Get Sender Name
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member.php');
$member = new Member();
$sender_name = $member->get_member_name($member_id);

// 2- Generate subject		
$subject = "QuakBox| $sender_name Sent you a message on QuakBox" ;

// 3- Send the Email
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_send_email.php');
$email = new SendEmail();
////////send_notification_email($sender_id,$receiver_id,$subject,$message_body,$media)
$email->send_notification_email($member_id,$msg_to,$subject,$message_body,$media);
	
///// End Send Notification Message



?>
<div class="reply_stbody" id="div_<?php echo ++$divid;?>">
<div class="reply_stimg">
<a href="<?php echo $base_url.$mres['username'];?>"><img src="<?php echo $media;?>" class="big_face" alt="<?php echo $mres['username'];?>"></a>

</div> 

<div class="reply_sttext">
<?php //echo $mres['id'];?> 
<b><a href="<?php echo $base_url.$mres['username'];?>" class="pname"><?php echo $mres['username'];?></a></b>

<?php echo $mres['message'];?><div class="reply_sttime"> <span class="timeago" title=""><?php echo time_stamp($mres['sent']);?></span>
<input type="checkbox" id="check_<?php echo ++$checkboxlength;?>" name="" value="<?php echo $mres['id'];?>" />
</div> 
</div>
</div>
<?php } }
?>