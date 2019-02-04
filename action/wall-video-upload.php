<?php
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php'); 	 
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');	 
 	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/time_stamp.php');	 
 	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/tolink.php');
$content_id = 0;
$s_member_id   = $_SESSION['SESS_MEMBER_ID'];

$member_id     = f($s_member_id, 'strip');
$member_id		 = 	f($member_id, 'escapeAll');
$member_id 	     = mysqli_real_escape_string($con, $member_id);

$title		 = 	f($_POST['title'], 'escapeAll');
$title 	     = mysqli_real_escape_string($con, $title);

if($title == ''){
	$title 	     = 'Video upload';
} else {
	$title 	     = $_POST['title'];
	
	
	
}
// translate
if(isset($_SESSION['lang']))
{
?>	
<script>
var lan1="<?php echo $_SESSION['lang'];?>";
var text1="<?php echo $title;?>";
call(lan1,text1);
function call(lan1,text1)
{
var g_token = '';
var lan =lan1;
var src = text1;

    var requestStr = "../token.php";
       $.ajax({
        url: requestStr,
        type: "GET",
        cache: true,
        dataType: 'json',
        success: function (data) {        
            g_token = data.access_token;
           	
        },
        complete: function(request, status) {
     
			translate1231(g_token,src,lan);
			
			},    
    });

	
		}
		
function translate1231(g_token,src1,lan)
	{
		 var language=lan;
	
		var src = src1;
		
		var p = new Object;
		
    p.text = src;
    p.from = null;
    p.to = "" + language + "";
    p.oncomplete = 'ajaxTranslate';
    p.appId = "Bearer " + g_token;
   
    var requestStr = "https://api.microsofttranslator.com/V2/Ajax.svc/Translate";
       $.ajax({
        url: requestStr,
        type: "GET",
        data: p,
        dataType: 'jsonp',
        cache: 'true',
       
		});
	}	
		
	function ajaxTranslate(response) { 
		
		 document.getElementById("target_tr").innerHTML = response;

	}
    
    </script>
     
	<?php 
}
//translate

$time = time();
$privacy   = f($_POST['privacy'], 'strip');
$privacy	 = 	f($privacy, 'escapeAll');
$privacy   = mysqli_real_escape_string($con, $privacy);

$country   = f($_POST['country'], 'strip');
$country	 = 	f($country, 'escapeAll');
$country   = mysqli_real_escape_string($con, $country);


$dThumb   = f($_POST['defaultthumbnail'], 'strip');
$dThumb	 = 	f($privacy, 'escapeAll');
$dThumb   = mysqli_real_escape_string($con, $privacy);

$NameWithoutExtension   = f($_POST['nwe'], 'strip');
$NameWithoutExtension	 = 	f($NameWithoutExtension, 'escapeAll');
$NameWithoutExtension   = mysqli_real_escape_string($con, $NameWithoutExtension);

$ip	     = $_SERVER['REMOTE_ADDR'];
if($country = '')
{
if($country = 'mywall')
{
$content_id = 0;
} else{
	$content_id = $member_id;
	}
}

else
{
	$content_id = 0;
}

if($_POST['country'] != 'mywall'){

$country   = f($_POST['country'], 'strip');
$country	 = 	f($country, 'escapeAll');
$country   = mysqli_real_escape_string($con, $country);

}
if(isset($_POST['content_id']))
{
$content_id   = f($_POST['content_id'], 'strip');
$content_id	 = 	f($content_id, 'escapeAll');
$content_id   = mysqli_real_escape_string($con, $content_id);
}
$locationForMp4 = "uploadedvideo/new".$NameWithoutExtension.".mp4";
$locationForOgg = "uploadedvideo/new".$NameWithoutExtension.".ogg";
$locationForWebm = "uploadedvideo/new".$NameWithoutExtension.".webm";
$defaultThumb = "uploadedvideo/videothumb/".$dThumb;

$base_url2='/home/qbdevqb/public_html/';
//$locationForThumb1 = "uploadedvideo/videothumb/new".$NameWithoutExtension."01.png";
$locationForThumb1= $NameWithoutExtension."01.png";
//$p300x150_path= $base_url2."uploadedvideo/videothumb/new".$NameWithoutExtension."01.png";
//$p300x150 = $base_url2."uploadedvideo/videothumb/p400x225".$NameWithoutExtension."01.png";
//$p200x150_1 = $base_url2."uploadedvideo/videothumb/p200x150".$NameWithoutExtension."01.png";	
$p300x150_path= "../uploadedvideo/videothumb/new".$NameWithoutExtension."01.png";
$p300x150 = "../uploadedvideo/videothumb/p400x225".$NameWithoutExtension."01.png";
$p200x150_1 = "../uploadedvideo/videothumb/p200x150".$NameWithoutExtension."01.png";	

	//image resize into 300x150
	$image300x150 = new Imagick($p300x150_path);	
    $image300x150->adaptiveResizeImage(400,225);     
    $image300x150->writeImage($p300x150);
    
    $image200x150_1 = new Imagick($p300x150_path);
    $image200x150_1->adaptiveResizeImage(200,150);
    $image200x150_1->writeImage($p200x150_1);

//$locationForThumb2 = "uploadedvideo/videothumb/new".$NameWithoutExtension."02.png";

$locationForThumb2= $NameWithoutExtension."02.png";
 /*$p300x150_path_2= $base_url2."uploadedvideo/videothumb/new".$NameWithoutExtension."02.png";
$p300x150_2 = $base_url2."uploadedvideo/videothumb/p400x225".$NameWithoutExtension."02.png";
$p200x150_2 = $base_url2."uploadedvideo/videothumb/p200x150".$NameWithoutExtension."02.png";
*/
$p300x150_path_2= "../uploadedvideo/videothumb/new".$NameWithoutExtension."02.png";
$p300x150_2 = "../uploadedvideo/videothumb/p400x225".$NameWithoutExtension."02.png";
$p200x150_2 = "../uploadedvideo/videothumb/p200x150".$NameWithoutExtension."02.png";

	//image resize into 300x150
	$image300x150_2 = new Imagick($p300x150_path_2);
    $image300x150_2->adaptiveResizeImage(400,225);
    $image300x150_2->writeImage($p300x150_2);
    $image200x150_2 = new Imagick($p300x150_path_2);
    $image200x150_2->adaptiveResizeImage(200,150);
    $image200x150_2->writeImage($p200x150_2);
    
//$locationForThumb3 = "uploadedvideo/videothumb/new".$NameWithoutExtension."03.png";
$locationForThumb3= $NameWithoutExtension."03.png";
/* $p300x150_path_3= $base_url2."uploadedvideo/videothumb/new".$NameWithoutExtension."03.png";
$p300x150_3 = $base_url2."uploadedvideo/videothumb/p400x225".$NameWithoutExtension."03.png";
$p200x150_3 = $base_url2."uploadedvideo/videothumb/p200x150".$NameWithoutExtension."03.png";
*/
$p300x150_path_3= "../uploadedvideo/videothumb/new".$NameWithoutExtension."03.png";
$p300x150_3 = "../uploadedvideo/videothumb/p400x225".$NameWithoutExtension."03.png";
$p200x150_3 = "../uploadedvideo/videothumb/p200x150".$NameWithoutExtension."03.png";

	//image resize into 300x150
	$image300x150_3 = new Imagick($p300x150_path_3);
    $image300x150_3->adaptiveResizeImage(400,225);
    $image300x150_3->writeImage($p300x150_3);
    $image200x150_3 = new Imagick($p300x150_path_3);
    $image200x150_3->adaptiveResizeImage(200,150);
    $image200x150_3->writeImage($p200x150_3);

//$locationForThumb4 = "uploadedvideo/videothumb/new".$NameWithoutExtension."04.png";
$locationForThumb4= $NameWithoutExtension."04.png";
/* $p300x150_path_4= $base_url2."uploadedvideo/videothumb/new".$NameWithoutExtension."04.png";
$p300x150_4 = $base_url2."uploadedvideo/videothumb/p400x225".$NameWithoutExtension."04.png";
$p200x150_4 = $base_url2."uploadedvideo/videothumb/p200x150".$NameWithoutExtension."04.png";
*/
$p300x150_path_4= "../uploadedvideo/videothumb/new".$NameWithoutExtension."04.png";
$p300x150_4 = "../uploadedvideo/videothumb/p400x225".$NameWithoutExtension."04.png";
$p200x150_4 = "../uploadedvideo/videothumb/p200x150".$NameWithoutExtension."04.png";


	//image resize into 300x150
	$image300x150_4= new Imagick($p300x150_path_4);
    $image300x150_4->adaptiveResizeImage(400,225);
    $image300x150_4->writeImage($p300x150_4);
    $image200x150_4 = new Imagick($p300x150_path_4);
    $image200x150_4->adaptiveResizeImage(200,150);
    $image200x150_4->writeImage($p200x150_4);

//$locationForThumb5 = "uploadedvideo/videothumb/new".$NameWithoutExtension."05.png";

$locationForThumb5= $NameWithoutExtension."05.png";
/* $p300x150_path_5= $base_url2."uploadedvideo/videothumb/new".$NameWithoutExtension."05.png";
$p300x150_5 = $base_url2."uploadedvideo/videothumb/p400x225".$NameWithoutExtension."05.png";
$p200x150_5 = $base_url2."uploadedvideo/videothumb/p200x150".$NameWithoutExtension."05.png";
*/
$p300x150_path_5= "../uploadedvideo/videothumb/new".$NameWithoutExtension."05.png";
$p300x150_5 = "../uploadedvideo/videothumb/p400x225".$NameWithoutExtension."05.png";
$p200x150_5 = "../uploadedvideo/videothumb/p200x150".$NameWithoutExtension."05.png";

	//image resize into 300x150
	$image300x150_5= new Imagick($p300x150_path_5);
    $image300x150_5->adaptiveResizeImage(400,225);
    $image300x150_5->writeImage($p300x150_5);
    $image200x150_5 = new Imagick($p300x150_path_5);
    $image200x150_5->adaptiveResizeImage(200,150);
    $image200x150_5->writeImage($p200x150_5);

// extension_loaded('ffmpeg') or die('Error in loading ffmpeg');
require_once('../qb_classes/ffmpeg-php/FFmpegAutoloader.php');

$ffmpegInstance = new ffmpeg_movie("../".$locationForMp4);

$duration = intval($ffmpegInstance->getDuration());

//query for fetch members data

$smembersql =  mysqli_query($con, "select * from member where member_id='".$s_member_id."'");
$smemberres = mysqli_fetch_array($smembersql);

 $share_member_id = $_POST['video_custom_share'];
 $unshare_member_id = $_POST['video_custom_unshare'];

 $member_sql = mysqli_query($con, "select * from member where username='".$share_member_id."'");
 $mem_res = mysqli_fetch_array($member_sql);
	
 $member_sql1 = mysqli_query($con, "select * from member where username='".$unshare_member_id."'");
 $mem_res1 = mysqli_fetch_array($member_sql1);

$csql = mysqli_query($con, "select * from geo_country where country_title='".$country."'") or die(mysqli_error($con));
$cres = mysqli_fetch_array($csql);

$member = mysqli_query($con, "select * from member where member_id = '$member_id'");
$member_res = mysqli_fetch_array($member);

$pvsql = mysqli_query($con, "SELECT video_id FROM videos ORDER BY video_id DESC LIMIT 1");

$pvres = mysqli_fetch_array($pvsql);

$pvideo_id = $pvres['video_id'];

	$sql="INSERT INTO message(content_id,member_id,country_flag,type,date_created,ip,wall_privacy,share_member_id,unshare_member_id) VALUES ('$content_id','$member_id','$country',2,'$time','$ip','$privacy','".$share_member_id."','".$unshare_member_id."')";

mysqli_query($con, $sql) or die(mysqli_error($con));

//tranlate code start

$langs=array("","hi","ar","bg","ca","cs","da","nl","et","fi","fr","zh-CHS","zh-CHT","de","el","ht","he","mww","hu","id","it","ja","tlh","ko","lv","lt","ms","mt","no","fa","pl","pt","ro","ru","sk","sl","es","sv","th","tr","uk","ur","vi","cy");
$last_id1= mysqli_insert_id($con);

for($e=0;$e<=43;$e++)
{
$language=$langs[$e];

?>
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/video_tran.php'); }?>


<?php



// tranlate code end



$newwallid = mysqli_insert_id($con);

$description='';
$category=0;

//insert into videos table
	$vquery = "INSERT INTO videos (description,category, location,location1,location2,thumburl,thumburl1,thumburl2,thumburl3,thumburl4,thumburl5,title,user_id,type,url_type,date_created,msg_id,duration,title_size,title_color) VALUES('$description','$category','$locationForMp4','$locationForOgg','$locationForWebm','$locationForThumb2','$locationForThumb1','$locationForThumb2','$locationForThumb3','$locationForThumb4','$locationForThumb5','$title',
	'$member_id','$privacy','1','$time','$newwallid','$duration','14','FFFFFF')";
	
	$vsql = mysqli_query($con, $vquery)  or die(mysqli_error($con));
	
	$video_id = mysqli_insert_id($con);
	
	mysqli_query($con, "UPDATE videos set parent_id = '$pvideo_id' where video_id = '$video_id'");
	
	$umsql="UPDATE message set video_id = '$video_id' where messages_id = '$newwallid'";
	mysqli_query($con, $umsql);
	
	$sql = mysqli_query($con, "SELECT msg.messages_id, msg.messages, msg.date_created, msg.type, msg.wall_privacy, m.member_id,
		  msg.msg_album_id, m.username, m.profImage, msg.country_flag, u.upload_data_id,msg.share,msg.video_id,
		  msg.share_by,m.username, v.location,v.location1,v.location2, v.thumburl, v.title, v.video_id, v.description,
 		  v.msg_id, v.category, v.title_color,v.title_size,v.ads,a.ads_name,a.location as adslocation,a.location1 as adslocation1,
		  a.location2 as adslocation2, a.click_url, msg.share_msg
		  FROM message msg LEFT JOIN member m ON msg.member_id = m.member_id 
		  LEFT JOIN upload_data u on msg.messages_id = u.msg_id		  
		  LEFT JOIN videos v ON v.msg_id = msg.messages_id 
		  LEFT JOIN videos_ads a ON v.ads_id = a.id 		  		  		  
		  ORDER BY messages_id DESC");
$row = mysqli_fetch_array($sql);
if ($row)
{
	$time = $row['date_created'];
	$msg_id = $row['messages_id'];
	$messages = $row['messages'];
	$url = 'posts.php?id='.$msg_id.'';
	$type = $row['type'];
	
	$title = $row['title'];
$description = $row['description'];
$mp4videopath = $row['location'];
$oggvideopath = $row['location1'];
$webmvideopath = $row['location2'];
$thumb = $row['thumburl'];
$ads = $row['ads'];
$adsmp4videopath = $row['adslocation'];
$adsoggvideopath = $row['adslocation1'];
$adswebmvideopath = $row['adslocation2'];
$click_url = $row['click_url'];
	$email_video_thunb = 'uploadedvideo/videothumb/p200x150'.$thumb;
	
	$fquery = "select m.member_id,m.email_id from friendlist f,member m where f.member_id=m.member_id and f.added_member_id = '".$member_id."' AND status !=0";
//echo $fquery;
$fsql = mysqli_query($con, $fquery);

if(mysqli_num_rows($fsql) > 0)
{
while($fres = mysqli_fetch_array($fsql))
{
	$ids = $fres['email_id'];

$msg_member_id = $fres['member_id'];
$nquery = "INSERT INTO notifications (sender_id, received_id, type_of_notifications, href, is_unread, date_created)
				VALUES('$member_id','$msg_member_id',8,'$url',0,'$time')";
mysqli_query($con, $nquery);

	
/************************************* mail function ***********************************/
if($country != 'world'){
if($country != NULL){
	$subject_text = $country;
} else {
	$subject_text = 'wall';
}

if($type == 0){
	$subject_msg = 'status';
} else if($type == 1){
	$subject_msg = 'photo';
}else {
	$subject_msg = 'video';
}

$to = $ids;
$subject = "".$member_res['username']." post ".$subject_msg." in ".$country."";
$message = "
<html>
<head>

<body style='font-family:Verdana, Geneva, sans-serif; font-size:14px;'>

<table cellpadding='0' cellspacing='0' style='border-collapse:collapse; width=98%;'>
<tbody>
<tr>
<td style='font-family:lucida grande,tahoma,verdana,arial,sans-serif;font-size:12px;'>

<table width='620px' cellpadding='0' cellspacing='0' style='border-collapse:collapse; width=620px;'>
<tbody>
<tr>
<td style='font-size:16px;font-family:lucida grande,tahoma,verdana,arial,sans-serif;background:#4F70D1;color:#ffffff;font-weight:bold;vertical-align:baseline;letter-spacing:-0.03em;text-align:left;padding:5px 20px;'>
<a href='".$base_url."posts.php?id=".$msg_id."' style='text-decoration:none'>
<span style='background:#4F70D1;color:#ffffff;font-weight:bold;font-family:lucida grande,tahoma,verdana,arial,sans-serif;vertical-align:middle;font-size:16px;letter-spacing:-0.03em;text-align:left;vertical-align:baseline;'>
<img src='".$base_url.$logo1."' height='30' style='margin-right:10px;'><img src='".$base_url.$logo."' width='75' height='30'>
<span>
</a>
</td>
</tr>
</tbody>
</table>

<table width='100%' cellpadding='0' cellspacing='0' style='border-collapse:collapse; width=620px;' border='0'>
<tbody>
<tr>
<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding:0px;border-left:none;border-right:none;border-top:none;border-bottom:none'>

<table cellpadding='0' cellspacing='0' style='border-collapse:collapse; width=620px;'>
<tbody>
<tr>
<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding:0px;width:620px'>

<table width='100%' cellpadding='0' cellspacing='0' style='border-collapse:collapse; width=100%;'>
<tbody>
<tr>

<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding:20px;background-color:#fff;border-left:none;border-right:none;border-top:none;border-bottom:none'>

<table cellpadding='0' cellspacing='0' style='border-collapse:collapse;'>
<tbody>
<tr>

<td valign='top' style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding-right:15px;text-align:left'>
<a href='".$base_url.$member_res['username']."' style='color:#3b5998;text-decoration:none' target='_blank'>
<img style='border:0' height='50' width='50' src='".$base_url.$member_res['profImage']."' />
</a>
</td>

<td valign='top' style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;width:100%;text-align:left'>
<table cellpadding='0' cellspacing='0' style='border-collapse:collapse; width='100%''>
<tbody>
<tr>
<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding-bottom:2px'>
<span style='color:#111111;font-size:14px;font-weight:bold'>
<a href='".$base_url.$member_res['username']."' target='_blank' style='color:#3b5998;text-decoration:none'>
".$member_res['username']."
</a>
post ".$subject_msg." in "; if($country != NULL && $country != 'world') { 
$message .= "".$country.""; } else {
$message .= " wall </span>";
}
$message .="</td>
</tr>

<tr>
<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding-bottom:2px'>
<span style='color:#111111;font-size:14px;font-weight:bold'>";
if($country != NULL && $country != 'world') {
$message .= "<span style='color:#808080;font-weight:bold;'>
".$res['country_title']."
</span>";
}
$message .= "</span>
</td>
</tr>

<tr>
<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding-top:1px;padding-bottom:2px'>
";
if($country != NULL && $country != 'world') {
$message .= "<img src='".$base_url."images/Flags/flags_new/flags/".strtolower($cres['code']).".png' width='100' height='100'>";
}
$message .= "
</td>
</tr>

<tr>
<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding-top:1px;padding-bottom:2px'>";
if($type == 0) {
$message .= "<span style='color:#808080'>
".$messages."
</span>";
} else if($type == 1) {
	$message .= "<a href='".$base_url."posts.php?id=".$msg_id."' target='_blank'><img src='".$base_url.$messages."' height='200' width='200'></a>";
} else if($type == 2) {
	$message .= "<a href='".$base_url."posts.php?id=".$msg_id."' target='_blank'><img src='".$base_url.$email_video_thunb."' height='150' width='200'><a>";
}

$message .="
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
<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding:0px;width:620px'>

<table cellpadding='0' cellspacing='0' style='border-collapse:collapse;'>
<tbody>
<tr>
<td style='border-width:1px;border-style:solid;border-color:#29447e #29447e #1a356e;background-color:#5b74a8'>
<a href='".$base_url."posts.php?id=".$msg_id."' target='_blank' style='color:#3b5998;text-decoration:none'>
<table cellpadding='0' cellspacing='0' style='border-collapse:collapse;'>
<tbody>
<tr>
<td style='border-collapse: collapse;  border-radius: 2px;  text-align: center;  display: block;  border: solid 1px #4f70d1;  background: #4f70d1;  padding: 7px 16px 8px 16px;'>

<span style='font-weight:bold;white-space:nowrap;font-size:13px;color: #fff;'>
See Post
</span>

</td>
</tr>
</tbody>
</table>
</a>
</td>
</tr>
</tbody>
</table>
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

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
$headers .= "From: Quakbox";

$mail = mail($to, $subject, $message, $headers); 
}
}
}
/************************************* end mail function ***********************************/
	
?>

<div class="stbody" id="stbody<?php echo $row['messages_id'];?>" data-id="<?php echo $row['messages_id'];?>" wall-type="1">

<div class="stimg">
<?php if($_SESSION['SESS_MEMBER_ID'] == $row['member_id'])
{
   
?>



<a href="mywall.php"><img src="<?php echo $row['profImage'];?>" class='big_face' original-title="<?php echo $row['username'];?>"/></a> 

<?php } 
else
{
?>
<a href="<?php echo $base_url.$row['username'];?>"><img src="<?php echo $row['profImage'];?>" class='big_face' original-title="<?php echo $row['username'];?>"/></a> 
<?php } ?>

</div><!--End stimg div	-->

<div class="sttext">
<?php 
if($_SESSION['SESS_MEMBER_ID'] == $row['member_id'])
{
?>
<a class="stdelete" href="#" id="<?php echo $row['messages_id'];?>" original-title="Delete update" title="<?php echo $lang['Delete update'];?>"></a>
<?php }
if($row['share'] != 1)
	{
if($_SESSION['SESS_MEMBER_ID'] == $row['member_id'])
{

?>


<a href="mywall.php"><b><?php echo $row['username'];?></b></a> 

<?php } 
else
{
?>
<a href="<?php echo $base_url.$row['username'];?>"><b><?php echo $row['username'];?></b></a> 
<?php }

	}
if($row['country_flag'] != NULL)
{
	if($row['share'] == 1)
	{
	echo "<a href='".$base_url.$smres['username']."'><b>".$smres['username']."</b></a>" ;		
echo $lang['share a'];
//echo "<a href='".$base_url.$smres['username']."'><b>".$row['username']."</b></a>" ;	

if($row['type'] == 0)
{
	echo '<a href="posts.php?id='.$row['messages_id'].'">'.$lang['status'].'</a>';
}
else if($row['type'] == 1)
{
	echo '<a href="albums.php?back_page=country_wall.php?country='.$row['country_flag'].'&member_id='.$row['member_id'].'&album_id='.$row['msg_album_id'].'&image_id='.$row['upload_data_id'].'">'.$lang['photo'].'</a>';
}
else
{
	echo '<a href="watch.php?video_id='.$row['video_id'].'">'.$lang['video'].'</a>';
}
} 
else
{
?>
<img style="margin:0px 3px;" src="images/arrow_png.jpg" /> 
<a href="<?php echo $homepage;?>"><b><?php echo strtoupper($row['country_flag']);?></b></a>
<?php if(strtolower($row['country_flag'])!='world'){?>
<img src="<?php echo $base_url."images/emblems/".$cres['code'].".jpg";?>" width="20" height="20" style="margin-left:3px; vertical-align:middle;" />
<?php } }
}
?>

<div style="margin:5px 0px;">
<?php 
 if($row['share']==1) {?>
 <div class="aboveUnitContent">
 <div class="_wk mbn">
 <span><?php echo $row['share_msg'];?></span>
 </div>
 </div>
 
 <?php } if($row['type']==0)
 
 {
	echo tolink(htmlentities($row['messages']));
?> 
<div tabindex="1" id="posttranslatemenu<?php echo $row['messages_id'];?>" class="posttranslatemenu" style="display:none; position:absolute;margin-left: 34%; "> <select id="postlangs<?php echo $row['messages_id'];?>" class="postlangs" onchange="selectOption(this.value, <?php echo $row['messages_id'];?>,2)">
            <option value=""><?php echo $lang['select language'];?></option> 
            </select>
            </div> 
            
<textarea class="postsource" id="postsource<?php echo $row['messages_id']; ?>"  style="display:none;"><?php echo $row['messages']; ?></textarea>
<div class="posttarget" style="font:bold;" id="posttarget<?php echo $row['messages_id']; ?>"></div>
<?php
} 
if($row['type']==1){?>
<a href="albums.php?back_page=<?php echo $homepage;?>&member_id=<?php echo $row['member_id']; ?>&album_id=<?php echo $row['msg_album_id']; ?>&image_id=<?php echo $row['upload_data_id'];?>" >
<?php 
	list($width, $height) = getimagesize($row['messages']);
	if($width > 600)
	{
	?>
    <img src="<?php echo $row['messages'];?>" class="stimage"/>
    <?php } 
	else if($width <= 600)
	{
	?>
	<img src="<?php echo $row['messages'];?>" class="stimage"/>
	<?php } 
	else
	{
	?>
    <img src="<?php echo $row['messages'];?>" class="stimage"/>
    <?php } ?>
</a>

<?php } if($row['type']==2){?>
<a href="watch.php?video_id=<?php echo $row['video_id'];?>" style="color:#993300;">
<h3 class="video_title"  >
<?php
if(isset($_SESSION['lang']))
	{	
		
		?>
        <div id="target_tr"></div>
        <?php
		
	}
	
	else
	{
		echo $row['title'];
		
	}?>
</h3></a>
 
<div id="videoplayerid<?php echo $row['video_id'];?>"> </div>
 <?php 
 $videoid="videoplayerid".$row['video_id'];
 $mp4videopath1 = $base_url.$mp4videopath;
 $oggpath = $base_url.$oggvideopath;
 $webmpath = $base_url.$webmvideopath;
 $thumwala = $base_url."uploadedvideo/videothumb/p400x225".$thumb;
 $adsmp4 = $base_url.$adsmp4videopath;
 $adsogg = $base_url.$adsoggvideopath;
 $adswebm = $base_url.$adswebmvideopath;
$fetch = urlencode($base_url."watch.php?video_id=".$row['video_id']);
 $fetch_url_pinterest = urlencode($base_url.'uploadedvideo/videothumb/p200x150'.$thumb).'&url='.urlencode($base_url."watch.php?video_id=".$row['video_id']).'&is_video=true&description='.$description;   
 ?>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function($)
    {
    var videoidqw = "<?php Print($videoid); ?>";
    var title1 = "<?php Print($title); ?>";
		var desc1 = "<?php Print($description); ?>";
		var mp4videopath = "<?php Print($mp4videopath1); ?>";
		var oggvideopath = "<?php Print($oggpath); ?>";
		var webmvideopath = "<?php Print($webmpath); ?>";
		var thumb = "<?php Print($thumwala); ?>";
		var adsmp4videopath = "<?php Print($adsmp4); ?>";
		var adsoggvideopath = "<?php Print($adsogg); ?>";
		var adswebmvideopath = "<?php Print($adswebm); ?>";
		var ads = "<?php Print($ads); ?>";
		if(ads == 1){
			var adsFlag = true;
		}else {
			var adsFlag = false;
		}
		var click_url = "<?php Print($click_url); ?>";
		var fetch_url = "<?php Print($fetch); ?>";
		var pintereset = "<?php Print($fetch_url_pinterest); ?>";
		
        videoPlayer = $("#"+videoidqw).Video({
            autoplay:false,
            autohideControls:4,
            videoPlayerWidth:400,
            videoPlayerHeight:250,
            posterImg:thumb,
            fullscreen_native:false,
            fullscreen_browser:true,
            restartOnFinish:false,
            spaceKeyActive:true,
            rightClickMenu:true,
            
            share:[{
                show:true,
                facebookLink:"https://www.facebook.com/sharer/sharer.php?u="+fetch_url,
                twitterLink:"https://twitter.com/intent/tweet?source=webclient&text="+fetch_url,                
                $fetch_url_pinterest = pintereset,
                linkedinLink:"https://www.linkedin.com/cws/share?url="+fetch_url,
                googlePlusLink:"https://plus.google.com/share?url="+fetch_url,
                deliciousLink:"https://delicious.com/post?url="+fetch_url
            }],
            logo:[{
                show:false,
                clickable:true,
                path:"images/logo/logo.png",
                goToLink:"http://codecanyon.net/",
                position:"top-right"
            }],
             embed:[{
                show:false,
                embedCode:'<iframe src="www.yoursite.com/player/index.html" width="746" height="420" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>'
            }],
            videos:[{
                id:0,
                title:"Oceans",
                mp4:mp4videopath,
                webm:webmvideopath,
                ogv:oggvideopath,
                info:desc1,

                popupAdvertisementShow:false,
                popupAdvertisementClickable:false,
                popupAdvertisementPath:"images/advertisement_images/ad2.jpg",
                popupAdvertisementGotoLink:"http://codecanyon.net/",
                popupAdvertisementStartTime:"00:02",
                popupAdvertisementEndTime:"00:10",

                videoAdvertisementShow:adsFlag,
                videoAdvertisementClickable:true,
                videoAdvertisementGotoLink:click_url,
                videoAdvertisement_mp4:adsmp4videopath,
                videoAdvertisement_webm:adswebmvideopath,
                videoAdvertisement_ogv:adsoggvideopath
            }]
        });

    });

  </script>

  <br/>
  <span class="sttime"  > <h3><?php echo $row['description']; ?></h3></span>
  
<?php }?>
</div>

<div><span class="sttime" title="<?php echo date($time);?>"><?php echo time_stamp($time);?></span>
<br />
<!-- LIke users display panel -->
<?php 

$post_like_sql = mysqli_query($con, "SELECT * FROM bleh WHERE remarks='". $row['messages_id'] ."'");
$post_like_count = mysqli_num_rows($post_like_sql);

$post_like_sql1 = mysqli_query($con, "SELECT m.username,m.member_id FROM bleh b, member m WHERE m.member_id=b.member_id AND b.remarks='".$row['messages_id']."' AND b.member_id='".$_SESSION['SESS_MEMBER_ID']."'");
$post_like_count1 = mysqli_num_rows($post_like_sql1);

if($post_like_count1==1)
{
$post_like_sql2 = mysqli_query($con, "SELECT m.username,m.member_id FROM bleh b, member m WHERE m.member_id=b.member_id AND b.remarks='".$row['messages_id']."' AND b.member_id!='".$_SESSION['SESS_MEMBER_ID']."' LIMIT 2");
$plike_count = mysqli_num_rows($post_like_sql2);
$new_plike_count=$post_like_count-2; 
}
else
{
$post_like_sql2 = mysqli_query($con, "SELECT m.username,m.member_id FROM bleh b, member m WHERE m.member_id=b.member_id AND b.remarks='".$row['messages_id']."' LIMIT 3");
$plike_count = mysqli_num_rows($post_like_sql2);
$new_plike_count=$post_like_count-3; 
}
?>
<div class="commentPanel" id="likes<?php echo $row['messages_id'];?>" style="display:<?php if($post_like_count <= 0) { echo 'none'; } else { echo 'block'; }?>">
<?php 

if($post_like_count1==1)
{?><span id="you<?php echo $row['messages_id'];?>"><a href="#"><?php echo $lang['You'];?></a><?php if($post_like_count>1)
echo ','; ?> </span><?php
}
?>

<input type="hidden"  value="<?php echo $post_like_count; ?>" id="commacount<?php echo $row['messages_id'];?>" >
<?php

$i = 0;
while($post_like_res = mysqli_fetch_array($post_like_sql2)) {
$i++; 	  
?>

<a href="#" id="likeuser<?php echo $row['messages_id'];?>"><?php echo $post_like_res['username']; ?></a>
<?php if($i <> $plike_count) { echo ',';}

} 
if($plike_count > 3) {
?>
 <?php echo $lang['and'];?><span id="plike_count<?php echo $row['messages_id'];?>" class="pnumcount"><?php echo $new_plike_count;?></span><?php echo $lang[' others'] ; ?><?php } ?> <?php echo $lang['like this'] ; ?>.</div> 

<!-- LIke users display panel -->


<!--Dislike users display panel-->
<?php 

$sql1 = mysqli_query($con, "SELECT * FROM post_dislike WHERE msg_id='". $row['messages_id'] ."'") or die(mysqli_error($con));
$dislike_count = mysqli_num_rows($sql1);
 
$query1=mysqli_query($con, "SELECT m.username,m.member_id FROM post_dislike b, member m WHERE m.member_id=b.member_id AND b.msg_id='".$row['messages_id']."' LIMIT 3");
$dislike = mysqli_num_rows($query1);
?>

<span class="commentPanel" id="postdislike_container<?php echo $row['messages_id'];?>" style="display:<?php if($dislike_count <= 0) { echo 'none'; } else { echo 'block'; }?>">
<span id="postdislikecount<?php echo $row['messages_id'];?>">
<?php
echo $dislike_count;
?>
</span>
<?php echo $lang['Person Dislike this'];?>
</span>

</div> <!-- End of timestamp div -->
<?php
$query1  = mysqli_query($con, "SELECT * FROM postcomment WHERE msg_id=" . $row['messages_id'] . " ORDER BY comment_id DESC") or die(mysqli_error($con));
$records = mysqli_num_rows($query1);
$s = mysqli_query($con, "SELECT * FROM postcomment WHERE msg_id=" . $row['messages_id'] . " ORDER BY comment_id DESC limit 4,$records");
$y = mysqli_num_rows($s);
if ($records > 4)
{
	$collapsed = true;?>
    <input type="hidden" value="<?php echo $records?>" id="totals-<?php  echo $row['messages_id'];?>" />
	<div class="commentPanel" id="collapsed-<?php  echo $row['messages_id'];?>" align="left">
	<img src="images/cicon.png" style="float:left;" alt="" />
	<a href="javascript: void(0)" class="ViewComments" id="<?php echo $row['messages_id'];?>">
	View <?php echo $y;?> <?php echo $lang['more comments'];?> 
	</a>
	<span id="loader-<?php  echo $row['messages_id']?>">&nbsp;</span>
	</div>
<?php
}
?>
<div id="stexpandbox">
<div id="stexpand<?php echo $msg_id;?>"></div>
</div><!--End stexpandbox div	--> 

<div class="commentcontainer" id="commentload<?php echo $row['messages_id'];?>">
<?php
$comment  = mysqli_query($con, "SELECT * FROM postcomment p,member m  WHERE p.post_member_id=m.member_id and p.msg_id=" . $row['messages_id'] . " ORDER BY comment_id DESC limit 0,4");
while($row1 = mysqli_fetch_assoc($comment))
{
?>
<div class="stcommentbody" id="stcommentbody<?php echo $row1['comment_id']; ?>">
<div class="stcommentimg">
<a href="<?php echo $base_url.$row['username'];?>"><img src="<?php echo $row1['profImage']; ?>" class='small_face'/></a>
</div> 
<div class="stcommenttext">
<?php 
if($_SESSION['SESS_MEMBER_ID'] == $row1['member_id'])
{
?>
<a class="stcommentdelete" href="#" id='<?php echo $row1['comment_id']; ?>' title='<?php echo $lang['Delete Comment'];?>'></a>
<?php } ?>
<a href="<?php echo $base_url.$row1['username'];?>"><b><?php echo $row1['username']; ?></b> </a>
<?php 
if($row1['type']==1){ echo $row1['content']; 
	?>
	
	<div id="translatemenu<?php echo $row1['comment_id'];?>" class="translatemenu" style="display:none; position:absolute;margin-left: 34%; "> <select id="langs<?php echo $row1['comment_id'];?>" class="langs" onchange="selectOption(this.value, <?php echo $row1['comment_id'];?>,1)">
            <option value=""><?php echo $lang['select language'];?></option> 
            </select></div> 
            
	<textarea class="source" id="source<?php echo $row1['comment_id']; ?>"  style="display:none;"><?php echo $row1['content']; ?></textarea>
	<?php
}
if($row1['type']==2) echo '<img src="'.$row1["content"].'" >';
?>
<div class="target" style="font:bold;" id="target<?php echo $row1['comment_id']; ?>"></div>
<div class="stcommenttime"><?php time_stamp($row1['date_created']); ?>
<!--  like button  -->
<span style="padding-left:5px;">
<!--like block-->
<div>
<?php
$sql = mysqli_query($con, "SELECT * FROM comment_like WHERE comment_id='". $row1['comment_id'] ."'");
$comment_like_count = mysqli_num_rows($sql);

$comment_like_query1 = mysqli_query($con, "SELECT m.username,m.member_id FROM comment_like c, member m WHERE m.member_id=c.member_id 
AND c.comment_id='".$row1['comment_id']."' AND c.member_id='".$_SESSION['SESS_MEMBER_ID']."' ");
$comment_like_res1 = mysqli_num_rows($comment_like_query1);
if($comment_like_res1==1)
{
$comment_like_query = mysqli_query($con, "SELECT m.username,m.member_id FROM comment_like c, member m WHERE m.member_id=c.member_id 
AND c.comment_id='".$row1['comment_id']."' AND c.member_id!='".$_SESSION['SESS_MEMBER_ID']."' LIMIT 2");
$clike_count = mysqli_num_rows($comment_like_query);
$new_clike_count=$comment_like_count-2; 
}
else
{
$comment_like_query = mysqli_query($con, "SELECT m.username,m.member_id FROM comment_like c, member m WHERE m.member_id=c.member_id 
AND c.comment_id='".$row1['comment_id']."' LIMIT 3");
$clike_count = mysqli_num_rows($comment_like_query);
$new_clike_count=$comment_like_count-3; 
}

?>
<div class="clike" id="clike<?php echo $row1['comment_id'];?>" style="display:<?php if($comment_like_count <= 0) { echo 'none'; } else { echo 'block'; }?>">
<?php 

if($comment_like_res1==1)
{?><span id="you<?php echo $row1['comment_id'];?>"><a href="#"><?php echo $lang['You'];?></a><?php if($comment_like_count>1)
echo ','; ?> </span><?php
}

?>
<!-- <input type="hidden" value="<?php if($comment_like_res1==1)echo 1;else echo 0; ?>" id="youcount<?php echo $row1['comment_id'];?>" > -->
<input type="hidden"  value="<?php echo $comment_like_count; ?>" id="commacount<?php echo $row1['comment_id'];?>" >
<?php

$i = 0;
while($comment_like_res = mysqli_fetch_array($comment_like_query)) {
$i++; 	  
?>

<a href="#" id="likeuser<?php echo $row1['comment_id'];?>"><?php echo $comment_like_res['username']; ?></a>
<?php
	//}
if($i <> $clike_count) { echo ',';}
//} 
} 
if($clike_count > 3) {
?>
 <?php echo $lang['and'];?>  <span id="like_count<?php echo $row1['comment_id'];?>" class="numcount"><?php echo $new_clike_count;?></span> <?php echo $lang['others'];?><?php } ?> <?php echo $lang['like this'];?>.</div>
<!--<span id="commentlikecout_container<?php echo $row1['comment_id'];?>" style="display:<?php if($comment_like_count <= 0) { echo 'none'; } else { echo 'block'; }?>">

<span id="commentlikecount<?php echo $row1['comment_id'];?>">
<?php
echo $comment_like_count;
?>
</span>
Like this
</span>
-->
</div>
<!--end like block-->

<!--dislie block-->
<div>
<?php
$cdquery = "SELECT * FROM comment_dislike WHERE comment_id='". $row1['comment_id'] ."'";
$cdsql  = mysqli_query($con, $cdquery) or die(mysqli_error($con));
$comment_dislike_count = mysqli_num_rows($cdsql);

$cdquery1 = mysqli_query($con, "SELECT m.username,m.member_id FROM comment_dislike c, member m WHERE m.member_id=c.member_id 
AND c.comment_id='".$row1['comment_id']."' LIMIT 3");
?>
<span id="dislikecout_container<?php echo $row1['comment_id'];?>" style="display:<?php if($comment_dislike_count <= 0) { echo 'none'; } else { echo 'block'; }?>">
<span id="dislikecout<?php echo $row1['comment_id'];?>">
<?php
echo $comment_dislike_count;
?>
</span>
<?php echo $lang['Person Dislike this'];?>
</span>
</div>
<!--end dislike block-->
</span>
<span style="top:2px;">
<?php
$comment_like = mysqli_query($con, "select * from comment_like where comment_id = '".$row1['comment_id']."' and member_id = '".$member_id."'");
if(mysqli_num_rows($comment_like) > 0)
{
	echo '<a href="javascript: void(0)" class="comment_like show_cmt_linkClr" id="comment_like'.$row1['comment_id'].'" msg_id = '.$row['messages_id'].' title="'.$lang['Unlike'].'" rel="Unlike">'.$lang['Unlike'].'</a>';
} 
else 
{ 
	echo '<a href="javascript: void(0)" class="comment_like show_cmt_linkClr" id="comment_like'.$row1['comment_id'].'" msg_id = '.$row['messages_id'].' title="'.$lang['Like'].'" rel="Like">'.$lang['Like'].'</a>';
}?>
</span>
<!-- End of like button -->
<!-- Dislike button -->
<span style="top:2px; padding-left:5px;">
<span class="mySpan_dot_class"> · </span>
<?php
$cdquery1 = "SELECT * FROM comment_dislike WHERE comment_id='". $row1['comment_id'] ."' and member_id = '".$member_id."'";
$cdsql1  = mysqli_query($con, $cdquery1) or die(mysqli_error($con));
$comment_dislike_count1 = mysqli_num_rows($cdsql1);
if($comment_dislike_count1 > 0) {
echo '<a href="javascript: void(0)" class="comment_dislike show_cmt_linkClr" id="comment_dislike'.$row1['comment_id'].'" title="'.$lang['DisLike'].'" rel="disLike">'.$lang['DisLike'].'</a>';
} else {
echo '<a href="javascript: void(0)" class="comment_dislike show_cmt_linkClr" id="comment_dislike'.$row1['comment_id'].'" title="'.$lang['UnDisLike'].'" rel="disLike">'.$lang['UnDisLike'].'</a>';
}
?>
</span> 
<!-- End of dislike  button -->
<!-- Reply Button -->
<span style="top:2px; margin-left:5px;">
<span class="mySpan_dot_class"> · </span>
<a href="" id="<?php echo $row1['comment_id'];?>" class="replyopen show_cmt_linkClr"><?php echo $lang['Reply'];?></a>
</span>
<!-- <?php if($row1['type']==1){?><span style="top:2px; left:3px;"><a class="translatebutton" onclick="translateSourceTarget(<?php echo $row1['comment_id'];?>);" href="javascript:void(0)" >Translate </a> </span><?php } ?> -->

<?php if($row1['type']==1)
{ ?>
<span style="top:2px; margin-left:3px;" > 
<span class="mySpan_dot_class"> · </span>
<a class="translateButton show_cmt_linkClr" href="javascript:void(0);" id="translateButton<?php echo $row1['comment_id'];?>"  ><?php echo  $lang['Translate'];?></a></span>

       
<?php 
} ?>


<!--View more reply-->
<?php
$query12  = mysqli_query($con, "SELECT * FROM comment_reply WHERE comment_id=" . $row1['comment_id'] . " ORDER BY reply_id DESC");
$records1 = mysqli_num_rows($query12);
$p = mysqli_query($con, "SELECT * FROM comment_reply WHERE comment_id=" . $row1['comment_id'] . " ORDER BY reply_id DESC limit 2,$records1");
$q = mysqli_num_rows($p);
if ($records1 > 2)
{
	$collapsed1 = true;?>
    <input type="hidden" value="<?php echo $records1?>" id="replytotals-<?php  echo $row1['comment_id'];?>" />
	<div class="replyPanel" id="replycollapsed-<?php  echo $row1['comment_id'];?>" align="left">
	<img src="images/cicon.png" style="float:left;" alt="" />
	<a href="javascript: void(0)" class="ViewReply">
	View <?php echo $q;?><?php  echo $lang['more replys'];?>
	</a>
	<span id="loader-<?php  echo $row1['comment_id']?>">&nbsp;</span>
	</div>
<?php
}
?>
</div>

</div>
<div class="replycontainer" style="margin-left:40px;" id="replyload<?php echo $row1['comment_id'];?>">

<?php
$reply_sql  = mysqli_query($con, "SELECT * FROM comment_reply c,member m WHERE c.member_id = m.member_id and comment_id=" . $row1['comment_id'] . " ORDER BY reply_id DESC limit 0,2");

while($reply_res = mysqli_fetch_assoc($reply_sql))
{
?>
<div class="streplybody" id="streplybody<?php echo $reply_res['reply_id']; ?>">
<div class="stcommentimg">
<a href="<?php echo $base_url.$row['username'];?>"><img src="<?php echo $reply_res['profImage']; ?>" class='small_face'/></a>
</div>
<div class="streplytext">
 <?php 
if($_SESSION['SESS_MEMBER_ID'] == $reply_res['member_id'])
{
?>
<a class="streplydelete" href="#" id='<?php echo $reply_res['reply_id']; ?>' title='<?php echo $lang['Delete Reply'];?>'></a>
<?php } ?>
<a href="<?php echo $base_url.$reply_res['username'];?>"><b><?php echo $reply_res['username']; ?> 
 
 </b></a>
<?php 
 
 if($row1['member_id'] <> $reply_res['member_id'])
 {
	 echo '@'; 
	?> <a href="<?php echo $base_url.$row1['username'];?>"><b><?php echo $row1['username']; ?> 
 
 </b></a>
	 
<?php
 }
   ?> 
 

<?php 
echo $reply_res['content'];
?>
<div class="streplytime"><?php time_stamp($reply_res['date_created']); ?></div>
<span style="padding-left:5px;">
<!--like block-->
<div>
<?php
$reply_like_query = mysqli_query($con, "SELECT * FROM reply_like WHERE reply_id='". $reply_res['reply_id'] ."'");
$reply_like_count = mysqli_num_rows($reply_like_query);

$reply_like_query1 = mysqli_query($con, "SELECT m.username,m.member_id 
								  FROM reply_like c, member m 
								  WHERE m.member_id = c.member_id 
								  AND c.reply_id = '".$reply_res['reply_id']."' 
								  AND c.member_id = '".$_SESSION['SESS_MEMBER_ID']."' ");
$reply_like_count = mysqli_num_rows($reply_like_query1);
if($reply_like_count == 1)
{
$reply_like_query2 = mysqli_query($con, "SELECT m.username,m.member_id 
								  FROM reply_like c, member m 
								  WHERE m.member_id=c.member_id 
								  AND c.reply_id='".$reply_res['reply_id']."' 
								  AND c.member_id!='".$_SESSION['SESS_MEMBER_ID']."' LIMIT 2");
$rlike_count = mysqli_num_rows($reply_like_query2);
$new_rlike_count = $reply_like_count - 2; 
}
else
{
$reply_like_query2 = mysqli_query($con, "SELECT m.username,m.member_id 
                                 FROM reply_like c, member m 
								 WHERE m.member_id=c.member_id 
								 AND c.reply_id='".$reply_res['reply_id']."' LIMIT 3");
$rlike_count = mysqli_num_rows($reply_like_query2);
$new_rlike_count=$reply_like_count - 3; 
}

?>
<div class="rlike" id="rlike<?php echo $row1['comment_id'];?>" style="display:<?php if($reply_like_count <= 0) { echo 'none'; } else { echo 'block'; }?>">
<?php 

if($reply_like_count == 1)
{?><span id="you<?php echo $row1['comment_id'];?>"><a href="#"><?php echo $lang['You'];?></a><?php if($reply_like_count>1)
echo ','; ?> </span><?php
}

?>

<input type="hidden"  value="<?php echo $reply_like_count; ?>" id="rcommacount<?php echo $reply_res['reply_id'];?>" >
<?php

$i = 0;
while($reply_like_res = mysqli_fetch_array($reply_like_query2)) {
$i++; 	  
?>

<a href="#" id="likeuser<?php echo $reply_res['reply_id'];?>"><?php echo $reply_like_res['username']; ?></a>
<?php
	//}
if($i <> $rlike_count) { echo ',';}
//} 
} 
if($rlike_count > 3) {
?>
 <?php echo $lang['and'];?> <span id="rlike_count<?php echo $reply_res['reply_id'];?>" class="rnumcount"><?php echo $new_rlike_count;?></span> <?php echo $lang['others'];?><?php } ?> <?php echo $lang['like this'];?>.</div>

</div>
<!--end like block-->

<!--dislie block-->
<div>
<?php
$rdquery = "SELECT * FROM reply_dislike WHERE reply_id='". $reply_res['reply_id'] ."'";
$rdsql  = mysqli_query($con, $rdquery) or die(mysqli_error($con));
$reply_dislike_count = mysqli_num_rows($rdsql);

$rdquery1 = mysqli_query($con, "SELECT m.username,m.member_id FROM comment_dislike c, member m WHERE m.member_id=c.member_id 
AND c.comment_id='".$reply_res['reply_id']."'");
?>
<span id="rdislikecout_container<?php echo $reply_res['reply_id'];?>" style="display:<?php if($reply_dislike_count <= 0) { echo 'none'; } else { echo 'block'; }?>">
<span id="rdislikecout<?php echo $reply_res['reply_id'];?>">
<?php
echo $reply_dislike_count;
?>
</span>
<?php echo $lang['Person Dislike this'];?>
</span>
</div>
<!--end dislike block-->
</span>
<span style="top:2px;">
<?php
$reply_like = mysqli_query($con, "select like_id from reply_like where reply_id = '".$reply_res['reply_id']."' and member_id = '".$member_id."'");
if(mysqli_num_rows($reply_like) > 0)
{
	echo '<a href="javascript: void(0)" class="reply_like show_cmt_linkClr" id="reply_like'.$reply_res['reply_id'].'"  title="'.$lang['Unlike'].'" rel="Unlike">'.$lang['Unlike'].'</a>';
} 
else 
{ 
	echo '<a href="javascript: void(0)" class="reply_like show_cmt_linkClr" id="reply_like'.$reply_res['reply_id'].'"  title="'.$lang['like'].'" rel="Like">'.$lang['like'].'</a>';
}
?>
</span>
<!-- End of like button -->
<!-- Dislike button -->
<span style="top:2px; padding-left:5px;">
<span class="mySpan_dot_class"> · </span>
<?php
$reply_dislike_query = "SELECT dislike_reply_id FROM reply_dislike WHERE reply_id='". $reply_res['reply_id'] ."' and member_id = '".$member_id."'";
$reply_dislike_sql  = mysqli_query($con, $reply_dislike_query) or die(mysqli_error($con));
$reply_dislike_count = mysqli_num_rows($reply_dislike_sql);
if($reply_dislike_count > 0) {
echo '<a href="javascript: void(0)" class="reply_dislike show_cmt_linkClr" id="reply_dislike'.$reply_res['reply_id'].'"title="'.$lang['disLike'].'" rel="disLike">'.$lang['disLike'].'</a>';
} else {
echo '<a href="javascript: void(0)" class="reply_dislike show_cmt_linkClr" id="reply_dislike'.$reply_res['reply_id'].'" title="'.$lang['UndisLike'].'" rel="disLike">'.$lang['UndisLike'].'</a>';
}
?>
</span> 
<!-- End of dislike  button -->
<!-- Reply Button -->
<span style="top:2px; margin-left:5px;">
<span class="mySpan_dot_class"> · </span>
<a href="" id="<?php echo $reply_res['reply_id'];?>" class="reply-replyopen show_cmt_linkClr"><?php echo $lang['Reply']; ?></a>
</span>
<?php if($row1['type']==1)
{ ?>
<span style="top:2px; margin-left:3px;" >
<span class="mySpan_dot_class"> · </span>
 <a class="translateButton show_cmt_linkClr" href="javascript:void(0);" id="translateButton<?php echo $row1['comment_id'];?>"  ><?php echo $lang['Translate']; ?></a></span>
       
<?php 
} ?>

</div><!--End streplytext div-->
<!--reply@reply-->
<div class="replycontainer" style="margin-left:40px;" id="reply-reply-load<?php echo $reply_res['reply_id'];?>">
<?php
$reply_r_sql  = mysqli_query($con, "SELECT m.username,m.member_id,m.profImage,
						   a.content, a.date_created,a.id
						   FROM reply_reply a 
						   LEFT JOIN member m ON a.member_id = m.member_id 
						   WHERE reply_id=" . $reply_res['reply_id'] . " 
						   ORDER BY id DESC limit 0,2");

while($reply_r_res = mysqli_fetch_assoc($reply_r_sql))
{
?>
<div class="reply-reply-body" id="reply-reply-body<?php echo $reply_r_res['id']; ?>">
<div class="stcommentimg">
<a href="<?php echo $base_url.$reply_r_res['username'];?>"><img src="<?php echo $reply_r_res['profImage']; ?>" class='small_face'/></a>
</div>

<div class="reply-reply-text">
 <?php 
if($_SESSION['SESS_MEMBER_ID'] == $reply_r_res['member_id'])
{
?>
<a class="reply-reply-delete" href="#" id='<?php echo $reply_r_res['reply_id']; ?>' title='<?php echo $lang['Delete Reply']; ?>'></a>
<?php } ?>
<a href="<?php echo $base_url.$reply_r_res['username'];?>"><b><?php echo $reply_r_res['username']; ?> 
 
 </b></a>
<?php 
 
 if($reply_res['member_id'] <> $reply_r_res['member_id'])
 {
	 echo '@'; 
	?> <a href="<?php echo $base_url.$reply_res['username'];?>"><b><?php echo $reply_res['username']; ?> 
 
 </b></a>
	 
<?php
 }
?> 
 

<?php 
echo $reply_r_res['content'];
?>
<div class="streplytime"><?php time_stamp($reply_r_res['date_created']); ?></div>

</div><!--End reply-reply div-->
<!--reply@reply-->

</div><!--End streplybody div-->
<?php } ?>
</div>
<!--Start replyupdate -->
<div class="reply-reply-update" style='display:none' id='reply-reply-update<?php echo $reply_res['reply_id'];?>'>
<div class="streplyimg">
<img src="<?php echo $res['profImage'];?>" class='small_face'/>
</div>

<div class="reply-reply-text" >
<form method="post" action="">
<textarea name="reply" class="reply-reply" maxlength="200"  id="reply-reply<?php echo $reply_res['reply_id'];?>"></textarea>
<br /> 
<input type="submit" abcd="<?php echo $reply_res['member_id']; ?>"  title="<?php echo $reply_res['username']; ?>" value="    @    "  id="<?php echo $reply_res['reply_id'];?>" class="reply-reply"/>
<input type="button"  value=" <?php echo $lang["Cancel"];?>"  onclick="closereply-reply('reply-reply-update<?php echo $reply_res['reply_id'];?>')" class="cancel"/>
</form>
</div>
</div>
<!--End replyupdate div	--> 
</div><!--End streplybody div-->
<?php } ?>

<!--Start replyupdate -->
<div class="replyupdate" style='display:none' id='replybox<?php echo $row1['comment_id'];?>'>
<div class="streplyimg">
<img src="<?php echo $smemberres['profImage'];?>" class='small_face'/>
</div>

<div class="streplytext" >
<form method="post" action="">
<textarea name="reply" class="reply" maxlength="200"  id="rtextarea<?php echo $row1['comment_id'];?>"></textarea>
<br /> 
<input type="submit" abcd="<?php echo $row1['member_id']; ?>"  title="<?php echo $row1['username']; ?>" value="    @    "  id="<?php echo $row1['comment_id'];?>" class="reply_button"/>
<input type="button"  value="<?php echo $lang["Cancel"];?>"  id="<?php echo $row['messages_id'];?>" onclick="closereply('replybox<?php echo $row1['comment_id'];?>')" class="cancel"/>
</form>
</div>
</div>
<!--End replyupdate div	--> 
</div><!--End replycontainer div-->
</div>
<?php } 
$q = mysqli_query($con, "SELECT * FROM bleh WHERE member_id='". $_SESSION['SESS_MEMBER_ID'] ."' and remarks='".$row['messages_id']."' ");
?>

</div><!--End commentcontainer div--> 

<div class="commentupdate" style='display:none' id='commentbox<?php echo $row['messages_id'];?>'>
<div class="stcommentimg">
<img src="<?php echo $smemberres['profImage'];?>" class='small_face'/>
</div>

<div class="stcommenttext" >
<form method="post" action="">

<div id="ctextarea<?php echo $row['messages_id'];?>" onkeyup="checkdata(this.id)" onclick="checkdata(this.id)" contenteditable="true" name="comment" class="comment" style="height:70px; width:329px; border:1px solid black; overflow-y:scroll;"></div>
<div id="showimg2_<?php echo $row['messages_id'];?>" name="actcomment" style="display:none;" ></div>

<input type="hidden" id="currentid" value="<?php echo $row['messages_id'];?>" />

<a herf="#!" style="cursor:pointer;" onclick="show(this.id)" id="<?php echo $row['messages_id'];?>"><img src="images/smiley.png"></a>
<!--code for smiley!-->

<br />



<input type="submit"  value="<?php echo $lang['Comment '];?>"  id="<?php echo $row['messages_id'];?>" class="button22 cancel"/>



<!--<input type="submit"  value=" Comment "  id="<?php echo $row['messages_id'];?>" class="button"/>!-->
<input type="button"  value=" <?php echo $lang["Cancel"];?> "  id="<?php echo $row['messages_id'];?>" onclick="cancelclose('commentbox<?php echo $row['messages_id'];?>')" class="cancel"/>

</form>
</div>
</div><!--End commentupdate div	--> 
<div class="commentupdate" style='display:none' id='reportbox<?php echo $row['messages_id'];?>'>
<div class="stcommentimg">
<img src="<?php echo $smemberres['profImage'];?>" class='small_face'/>
</div>

<div class="stcommenttext" >
<form method="post" action="">
<textarea name="comment" class="comment" maxlength="200"  id="rptextarea<?php echo $row['messages_id'];?>" placeholder="<?php echo $lang['Flag this status'];?>.."></textarea>
<br />
<input type="submit"  value=" <?php echo $lang['Report'];?>"  id="<?php echo $row['messages_id'];?>" class="report"/>
<input type="button"  value="  <?php echo $lang["Cancel"];?>"  id="<?php echo $row['messages_id'];?>" onclick="canclose('reportbox<?php echo $row['messages_id'];?>')" class="cancel"/>
</form>
</div>
</div>
<!--End commentupdate div	-->
 
<div class="emot_comm">
    
    
	<div class="submenu12" id="<?php echo $row['messages_id']; ?>-submenu12" style="display: none; position: absolute; background:#ffffff; margin-top:15px;">
	  
	      <a href="action/commentpost.php?postid=<?php echo $row['messages_id']; ?>&member_id=<?php echo $member_id; ?>&postcomment=images/1.jpg&type=2" ><img src="images/1.jpg"></a>
	    
	      <a href="action/commentpost.php?postid=<?php echo $row['messages_id']; ?>&member_id=<?php echo $member_id; ?>&postcomment=images/2.jpg&type=2" ><img src="images/2.jpg"></a>
	    
	      <a href="action/commentpost.php?postid=<?php echo $row['messages_id']; ?>&member_id=<?php echo $member_id; ?>&postcomment=images/3.jpg&type=2" ><img src="images/3.jpg"></a>
	    
	      <a href="action/commentpost.php?postid=<?php echo $row['messages_id']; ?>&member_id=<?php echo $member_id; ?>&postcomment=images/4.jpg&type=2" ><img src="images/4.jpg"></a>
	      
	      <a href="action/commentpost.php?postid=<?php echo $row['messages_id']; ?>&member_id=<?php echo $member_id; ?>&postcomment=images/5.jpg&type=2" ><img src="images/5.jpg"></a>
	    
	     <a href="action/commentpost.php?postid=<?php echo $row['messages_id']; ?>&member_id=<?php echo $member_id; ?>&postcomment=images/6.jpg&type=2" ><img src="images/6.jpg"></a>
	    
	      <a href="action/commentpost.php?postid=<?php echo $row['messages_id']; ?>&member_id=<?php echo $member_id; ?>&postcomment=images/1.gif&type=2" ><img src="images/1.gif"></a>
	   
	</div>
    
	<span class="show-cmt">
 <?php
	if(mysqli_num_rows($q) > 0)
	{
		echo '<a href="javascript: void(0)" class="like show_cmt_linkClr" id="like'.$row['messages_id'].'" title="'.$lang['Unlike'].'" rel="Unlike">'.$lang['Unlike'].' </a>';
	} 

	else 
	{ 
		echo '<a href="javascript: void(0)" class="like show_cmt_linkClr" id="like'.$row['messages_id'].'" title="'.$lang['Like'].'" rel="Like">'.$lang['Like'].'</a>';
	}
	
	
?>
</span>

<span class="show-cmt">
<span class="mySpan_dot_class"> · </span>
 <?php
 $pdislikequery = "SELECT dislike_id FROM post_dislike WHERE member_id='$member_id'";
 $pdislikesql = mysqli_query($con, $pdislikequery);
 
 
	if(mysqli_num_rows($pdislikesql) > 0)
	{
		echo '<a href="javascript: void(0)" class="post_dislike show_cmt_linkClr" id="post_dislike'.$row['messages_id'].'" title="'.$lang['UnDislike'].'" rel="disLike">'.$lang['UnDisLike'].'</a>';
	} 

	else 
	{ 
	echo '<a href="javascript: void(0)" class="post_dislike show_cmt_linkClr" id="post_dislike'.$row['messages_id'].'" title="'.$lang['dislike'].'" rel="disLike">'.$lang['dislike'].'</a>';
		
	}
	
?>
</span>


<span class="show-cmt">
<span class="mySpan_dot_class"> · </span>
<a href="javascript:void(0)" id="<?php echo $row['messages_id'];?>" class="commentopen show_cmt_linkClr"><?php echo $lang['Comment'];?></a>
</span>

<span class="show-cmt">
<span class="mySpan_dot_class"> · </span>
<a href="javascript:void(0)" rowtype="<?php echo $row['type'];?>" class="share_open show_cmt_linkClr" id="<?php echo $row['messages_id'];?>" title="<?php echo $lang['Share'];?>"><?php echo $lang['Share'];?></a>
</span>

<span class="show-cmt hidden">
<span class="mySpan_dot_class"> · </span>
<a href="javascript:void(0)" id="<?php echo $row['messages_id'];?>" class="flagopen show_cmt_linkClr"><?php echo $lang['Flag this Status'];?></a>
</span>
<?php if($row['type']==0)
 {
	 if(substr($row['messages'],0,4) != 'http' )
{ ?>
<span style="top:2px; left:3px;" >
<span class="mySpan_dot_class"> · </span>
<a class="posttranslateButton" href="javascript:void(0);" id="posttranslateButton<?php echo $row['messages_id'];?>"  ><?php echo $lang['Translate'];?></a>
</span>
<?php } } ?>
</div>

</div><!--End sttext div	--> 
</div>  
<?php
}
unlink($p300x150_path);

unlink($p300x150_path_2);
unlink($p300x150_path_3);
unlink($p300x150_path_4);
unlink($p300x150_path_5);

?>