<?php

define("DB_SERVER", "localhost");
define("DB_USER", "qbdevqb_main");
/*define("DB_PASS", "1@QBdevMaiN#;NC");*/
define("DB_PASS", "uB#{(J;6rQ-o");
define("DB_NAME", "qbdevqb_maindb");


class database
{
 var $con;
 var $db;
 var $query;
 
function database() {	

$this->con=mysqli_connect(DB_SERVER,DB_USER,DB_PASS) or die(mysqli_error($this->con));
$this->db=mysqli_select_db($this->con,DB_NAME);

if(!$this->con || !$this->db){return 0;}

return $this->con;
}

function execQueryWithFetchAll($query){
   $this->query=$query;
   $result = mysqli_query($this->con, $this->query);
   $data = mysqli_fetch_all($result,MYSQLI_ASSOC); 
   mysqli_free_result($result); 
   
   return $data; 
}
function insertQueryReturnLastID($query){
   $this->query=$query;
   $result = mysqli_query($this->con, $this->query) or die(mysqli_error($this->con));
   $id = mysqli_insert_id($this->con);    
   return $id; 
}

function execQuery($query){
   $this->query=$query;
   $result = mysqli_query($this->con, $this->query); 
   
   return $result; 
}

function execQueryWithFetchObject($query){
   $this->query=$query;
   $result = mysqli_query($this->con, $this->query); 
   $data = mysqli_fetch_object($result);
    mysqli_free_result($result); 
   return $data; 
}

function cleanString($string){
   	$str = @trim($string);
	if(get_magic_quotes_gpc()) {		
		$string= stripslashes($string);
	}
	return mysqli_real_escape_string($this->con,$string); 
}


}

?>


<?php

//This file is coded by Mushira Ahmad and yasser hossam 08-02-2016

//Get all members that have a birthday today
$sql="SELECT member_id, username, displayname, email, dob FROM member m WHERE MONTH(m.dob) = MONTH(NOW()) AND DAY(m.dob ) = DAY(NOW());";
$db_Obj = new database();	
$results = $db_Obj->execQueryWithFetchAll($sql); 
//echo $results;
//$msg = "Successfully test of cron job \nhello every minuet";

// send email
//mail("ymservices1@gmail.com","My subject",$msg);

//Get member's Friends list
//$misc=new misc();


foreach( $results as $bd_members)
	{
	
	   
		
		$sql = "select m.member_id, m.username, m.displayname, m.email from friendlist f,member m,qb_lookup l where f.added_member_id=m.member_id and f.member_id=".$bd_members['member_id']." AND f.status != 0 and m.status=l.lookup_key  AND l.lookup_value ='ACTIVE' ;";
			
		$Friends= $db_Obj->execQueryWithFetchAll($sql); 
	
/////////////////// Send Notification Message 

// 2- Generate subject		
$subject = "QuakBox| Today is ".$bd_members['displayname']."'s birthday" ;

$base_url = "https://quakbox.com/";
$site_email = "noreply@quakbox.com";

$media = "images/default.png";
$media=$base_url.$media;

$message = "
		<html>
	<body style='font-family:Verdana, Geneva, sans-serif; font-size:14px;'>
	
	<table width='100%' cellpadding='0' cellspacing='0' style='border-collapse:collapse;width:100%;'>
	<tbody>
	<tr>
	<td style='font-family:lucida grande,tahoma,verdana,arial,sans-serif;font-size:12px;'>
	
	<table width='100%' cellpadding='0' cellspacing='0' style='border-collapse:collapse;width:100%;'>
	<tbody>
	<tr>
	<td style='font-size:16px;font-family:lucida grande,tahoma,verdana,arial,sans-serif;background:#4F70D1;color:#ffffff;font-weight:bold;vertical-align:baseline;letter-spacing:-0.03em;text-align:left;padding:5px 20px;'>
	<a href='".$base_url."' style='text-decoration:none'>
	<span style='background:#4F70D1;color:#ffffff;font-weight:bold;font-family:lucida grande,tahoma,verdana,arial,sans-serif;vertical-align:middle;font-size:16px;letter-spacing:-0.03em;text-align:left;vertical-align:baseline;'>
	<img src='".$base_url."images/qb-email.png' height='30' style='margin-right:3px;'><img src='".$base_url."images/qb-quack.png' width='75' height='30'>
	<span>
	</a>
	</td>
	</tr>
	</tbody>
	</table>
	
	<table width='100%' cellpadding='0' cellspacing='0' style='border-collapse:collapse;width:100%;' border='0'>
	<tbody>
	<tr>
	<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding:0px;background-color:#f2f2f2;border-left:none;border-right:none;border-top:none;border-bottom:none'>
	
	<table cellpadding='0' cellspacing='0' style='border-collapse:collapse;width:100%;'>
	<tbody>
	<tr>
	<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding:0px;width:100%;'>
	
	<table width='100%' cellpadding='0' cellspacing='0' style='border-collapse:collapse;width:100%;'>
	<tbody>
	<tr>
	
	<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding:20px;background-color:#fff;border-left:none;border-right:none;border-top:none;border-bottom:none'>
	
	<table cellpadding='0' cellspacing='0' style='border-collapse:collapse;'>
	<tbody>
	<tr>
	
	
	
	<td valign='top' style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;width:100%;text-align:left'>
	<table cellpadding='0' cellspacing='0' style='border-collapse:collapse;width:100%;'>
	<tbody>
	<tr>
	<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding-bottom:2px'>
	<span style='color:#111111;font-size:14px;font-weight:bold'>
	Wish
	<a href='".$base_url."".$bd_members['username']."' target='_blank' style='color:#3b5998;text-decoration:none'>
	".$bd_members['displayname']." 
	</a>
	 a happy Birthday
	</span>
	</td>
	</tr>
	
	<tr>
	<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding-top:1px'>
	<hr/>
	<span style='color:#333333'>
	<span>
	".$bd_members['dob']."
	
	<br><br>
	"."     "."
	</span>
	</span>
	</td>
	</tr>
	</tbody>
	</table>
	
	</td>
	</tr>
	</tbody>
	</table>
	
	</td>
	</tr>
	</tbody>
	</table>
	
	</td>
	</tr>
	
	<tr>
	<td style='font-size:18px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding:5px;width:100%;'>
	<center>
	$message_content
	</center>
	</td>
	</tr>
	<tbody>
	<table>
	
	</td>
	</tr>
	
	</tbody>
	</table>
	
	</body>
	</html>
	";

	//echo $message;
	
		// Always set content-type when sending HTML email
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
		$headers .= "From: QuackBox <".$site_email.">";
	    foreach( $Friends as $Friend)
	    {
	      $friend_id=$Friend['member_id'];
	      $friend_name=$Friend['displayname'];
	      $friend_email=$Friend['email'];
	      
	      // Send mail of Birthday
	      $mail = mail($friend_email, $subject, $message, $headers); 
	//////////////////////////// Send a portal notification ////////////////////////


        $portal_sql = "INSERT INTO notifications (sender_id, received_id, title, type_of_notifications, href, is_unread, date_created) 
	VALUES('".$bd_members['member_id']."','".$friend_id."','has a Birth Day today',37,'".$bd_members['username']."',0,".strtotime(date("Y-m-d H:i:s")).")";	
	
	error_log($portal_sql, 0);


        $insert_result=$db_Obj->execQuery($portal_sql);
        
	

	   
	    }
			 
	}		







?>