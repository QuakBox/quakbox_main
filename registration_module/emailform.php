<?php 

/**
   * @package      emailform
   * @subpackage 
   * @author        Vishnu 
   * Created date  02/11/2015 
   * Updated date  03/26/2015 
   * Updated by    Vishnu S
 **/


ob_start();
session_start();
include($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php');	
include_once('config.php');


$message25="";
$member_id = $_SESSION['SESS_MEMBER_ID'];
$mid=$_POST['mesg_id'];
//echo $mid;exit;
$email=$_POST['email'];
$share_status=$_POST['share_status'];

if(isset($_POST['vlink']))
{
	$vlink=$_POST['vlink'];
	$message24=$vlink;
}

$firstname=explode('@',$email);

$shareby="select * from member where member_id='$member_id'";

$stshare=mysqli_query($con, $shareby) or die(mysqli_error($con));
$rowsh=mysqli_fetch_array($stshare);
$username=$rowsh['username'];
/* $countryid=$rowsh['country'];
// $senderemail=$rowsh['email_id'];
$getcountry="select * from geo_country where country_id='$countryid'";
//echo $getcountry;
$stget=mysqli_query($con, $getcountry) or die(mysqli_error($con));
$rowget=mysqli_fetch_array($stget);
$country=$rowget['country_title'];
*/
//echo "<br>".$country;


$sql="select * from message where messages_id='$mid'";

$st=mysqli_query($con, $sql);
$row=mysqli_fetch_array($st);

	$message22=$row['messages'];
	$type=$row['type'];
	$url_title=$row['url_title'];
	$video_id=$row['video_id'];


if($type==1)
{
$message24= $base_url.$message22;

$message23="<img src='".$base_url.$message22."' height='250' width='250'><br><a href='".$base_url."fetch_posts.php?id=$mid'>Show Post</a>";
	
}
if($type==3)
{
$message23="<a href=$message22>Show Post</a>";
}

if($type==2)
{

		$pvquery = "SELECT v.location, v.thumburl, v.title, v.video_id, v.date_created, v.view_count,v.description,
						v.url_type, v.msg_id, v.category, m.username
						FROM videos v LEFT JOIN members m ON m.member_id = v.user_id 
						WHERE v.video_id = '$video_id'";
			$pvsql = mysqli_query($con, $pvquery) or die(mysqli_error($con));
		
		$mrow = mysqli_fetch_array($pvsql);
		$category = $mrow['category'];
		$location=$mrow['location'];
		$thumburl='uploadedvideo/videothumb/p200x150'.$mrow['thumburl'];
$message24= $base_url.$location;

          $message23="<a href='".$base_url."posts.php?id=$mid'><img src='".$base_url.$thumburl."' height='150' width='200'></a><br><a href='".$base_url."fetch_posts.php?mid=$mid'>Show Video</a>";      
	
}
if($type==0)
{
        
        
        
        
	$message23=$message22;
}
if(isset($_POST['link'])&& $_POST['link']!="undefined")
{
	$link=$_POST['link'];
	$message24=$link;
	$message25="<a href='$message23' target='_blank'><img src='$link' height='250' width='250'></a>";
}



?>





<?php
$subMessage='';
$to = $email; //Recipient Email Address
if($type==1){
$subject = "$username has shared a photo with you on $site_name"; //Email Subject
$subMessage=ucfirst($username)." has shared a photo";
}
else if($type==2){
$subject = "$username has shared a video with you on $site_name";
$subMessage=ucfirst($username)." has shared a video  ";
}
else{
$subject = "$username has shared a status with you on ".$site_name;
$subMessage=ucfirst($username)." has shared a status  ";
}
$headers = "From:Quakbox<$site_notification_email>";

$random_hash = md5(date('r', time()));

$headers .= "\r\nContent-Type: multipart/mixed; boundary=\"PHP-mixed-".$random_hash."\"";

if($type==1 || $type==2 )
{
$attachment = chunk_split(base64_encode(file_get_contents($message24)));
$path_parts = pathinfo($message24);

//echo $path_parts['dirname'], "<br>";
//echo $path_parts['basename'], "<br>";
//echo $path_parts['extension'], "<br>";
//echo $path_parts['filename'], "<br>"; // since PHP 5.2.0
 // Set your file path here
}

$htmlbody = " <html>
<head>
</head>

<body>

<div id='wrapper' style='min-height:350px; width:98%;margin-top:10px;margin-bottom:10px;border:1px solid #ddd;position: relative;'>
	
	<div style='font-size:16px;font-family:lucida grande,tahoma,verdana,arial,sans-serif;background:#4F70D1;color:#ffffff;font-weight:bold;vertical-align:baseline;letter-spacing:-0.03em;text-align:left;padding:5px 20px;'>
<a href='".$base_url."' style='text-decoration:none'>
<span style='background:#4F70D1;color:#ffffff;font-weight:bold;font-family:lucida grande,tahoma,verdana,arial,sans-serif;vertical-align:middle;font-size:16px;letter-spacing:-0.03em;text-align:left;vertical-align:baseline;'>
<img src='".$base_url."images/qb-email.png' height='30' style='margin-right:3px;'><img src='".$base_url."images/qb-quack.png' width='75' height='30'><span style='display:inline-block;color:#fff;font-size: 16px; padding: 5px 15px;vertical-align:middle;'>".$subMessage."</span>	
<span>
</a>
</div>
    
    <div id='containt' style='padding: 10px; margin: 0px auto; width: 95%;clear:both;'>
    	<div style='font:Verdana, Geneva, sans-serif; font-size:18px; font-weight:bold; color:#999; margin-top:3px;float:left;'> <br/>
        	<div>$share_status</div>
        	<div>$message23</div>
        	<div>$message25</div>        	 
        </div>
        <div style='clear:both;'></div>
    </div>
    <div style='clear:both;'></div>
    <div id='link' style='clear:both;text-align:center;padding: 20px;border-top: 1px solid #ccc;' > 
    	<div style='text-align:center;font-size: 16px;'>If you want to stop the notification please contact <a href='mailto:support@quakbox.com?Subject=Stop%20notification%20from%20quakbox' target='_top' style='text-decoration:none;'>support@quakbox.com</a>...</div> 
    	<div style='text-align:center;font-size: 16px;color:#409D5B;'>We are always happy to help you.. </div>   
    	<div style='text-align:center;'><a href='".$base_url."' title='".$site_name."' target='_blank' style='text-decoration:none;color:#1155CC; font-family:Verdana, Geneva, sans-serif; font-size:15px;'> <b>View more updates on ".$site_name."</b> </a></div>
    	<div style='clear:both;'></div>
    </div>
    <div style='clear:both;'></div>    
</div>

</body>

</html>";




//define the body of the message.

$message = "--PHP-mixed-$random_hash\r\n"."Content-Type: multipart/alternative; boundary=\"PHP-alt-$random_hash\"\r\n\r\n";
$message .= "--PHP-alt-$random_hash\r\n"."Content-Type: text/html; charset=\"iso-8859-1\"\r\n"."Content-Transfer-Encoding: 7bit\r\n\r\n";

//Insert the html message.
$message .= $htmlbody;
$message .="\r\n\r\n--PHP-alt-$random_hash--\r\n\r\n";
if($type==1)
{
//include attachment
$message .= "--PHP-mixed-$random_hash\r\n"."Content-Type: image/jpeg; name=\"File Attached\"\r\n"."Content-Transfer-Encoding: base64\r\n"."Content-Disposition: attachment\r\n\r\n";
$message .= $attachment;
}
else if($type==2 )
{
//include attachment
//$message .= "--PHP-mixed-$random_hash\r\n"."Content-Type: video/x-msvideo; name=\"Video Attached\"\r\n"."Content-Transfer-Encoding: base64\r\n"."Content-Disposition: attachment\r\n\r\n";
//$message .= $attachment;
}

$message .= "/r/n--PHP-mixed-$random_hash--";

//send the email
$mail = mail( $to, $subject , $message, $headers );

if($mail)
{
$sqlincount="insert into count_share(message_id,post_member_id)values($mid,$member_id)";
	//echo $sqlincount;
	mysqli_query($con, $sqlincount);

//echo $message24;
//echo $video;
//echo $attachment;
//echo $_POST['link'];
unset($_POST['link']);
unset($_POST['vlink']);
?>
<script>
alert('Email Sent');
window.close();
</script>
<?php
echo "<script>
alert('Email Sent');
window.close();
</script>";
}
//echo $message;
?> 