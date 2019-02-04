<?php ob_start();
session_start();
include_once '../config.php';
include_once '../includes/time_stamp.php';

$member_id = $_SESSION['SESS_MEMBER_ID'];

$comment = mysqli_real_escape_string($con, $_POST['comment']);
$comment	 = 	f($comment, 'escapeAll');
$comment   = mysqli_real_escape_string($con, $comment);

$msg_id = $_POST['msg_id'];
$msg_id	 = 	f($msg_id, 'strip');
$msg_id	 = 	f($msg_id, 'escapeAll');
$msg_id   = mysqli_real_escape_string($con, $msg_id);

$time = time();

$member_sql = mysqli_query($con, "select * from members where member_id='$member_id'");
$member_res = mysqli_fetch_array($member_sql);

mysqli_query($con, "INSERT INTO groups_wall_comment(post_member_id,msg_id,content, type, date_created)
VALUES('$member_id','$msg_id','$comment','1','$time')");

$msgsql = mysqli_query($con, "SELECT m.member_id,m.email_id FROM message msg LEFT JOIN members m ON m.member_id = msg.member_id 
WHERE msg.messages_id = '$msg_id'");
$msgres = mysqli_fetch_array($msgsql);
$msg_member_id = $msgres['member_id'];

$url = 'posts.php?id='.$msg_id.'';

if($member_id != $msg_member_id)
{

$nquery = "INSERT INTO notifications (sender_id, received_id, type_of_notifications, href, is_unread, date_created)
				VALUES('$member_id','$msg_member_id',2,'$url',0,'$time')";
mysqli_query($con, $nquery);

/************************************* mail function ***********************************/

$to = $msgres['email_id'];
$subject = "".$member_res['username']." commented on your status";
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
commented on your status
</span>
</td>
</tr>

<tr>
<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding-top:1px;padding-bottom:2px'>
<span style='color:#808080'>
".$member_res['username']." wrote: ".$comment."
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
See comment
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
$headers .= "From:".$site_email."";

$mail = mail($to, $subject, $message, $headers); 


/************************************* end mail function ***********************************/

}
$sql = mysqli_query($con, "select * FROM groups_wall_comment p,members m  WHERE p.post_member_id=m.member_id and p.msg_id = '$msg_id' order by comment_id desc");
$res = mysqli_fetch_array($sql);
if ($res)
{
	$com_id = $res['comment_id'];	
	$comment = $res['content'];
	$time = $res['date_created'];
	$cface = $res['profImage'];
	$username = $res['username'];
	
?>
<div class="stcommentbody" id="stcommentbody<?php echo $res['comment_id']; ?>">
<div class="stcommentimg">
<a href="<?php echo $base_url.$row['username'];?>"><img src="<?php echo $res['profImage']; ?>" class='small_face'/></a>
</div> 
<div class="stcommenttext">
<?php 
if($_SESSION['SESS_MEMBER_ID'] == $res['member_id'])
{
?>
<a class="stcommentdelete" href="#" id='<?php echo $res['comment_id']; ?>' title='Delete Comment'></a>
<?php } ?>
<a href="<?php echo $base_url.$res['username'];?>"><b><?php echo $res['username']; ?></b> </a>
<?php 
if($res['type']==1){ echo $res['content']; 
	?>
	
	<div id="translatemenu<?php echo $res['comment_id'];?>" class="translatemenu" style="display:none; position:absolute;margin-left: 34%; "> <select id="langs<?php echo $res['comment_id'];?>" class="langs" onchange="selectOption(this.value, <?php echo $res['comment_id'];?>,1)">
            <option value="">Select Language</option> 
            </select></div> 
            
	<textarea class="source" id="source<?php echo $res['comment_id']; ?>"  style="display:none;"><?php echo $res['content']; ?></textarea>
	<?php
}
if($res['type']==2) echo '<img src="'.$res["content"].'" >';
?>
<div class="target" style="font:bold;" id="target<?php echo $res['comment_id']; ?>"></div>
<div class="stcommenttime"><?php time_stamp($res['date_created']); ?>
<!--  like button  -->
<span style="padding-left:5px;">
<!--like block-->
<div>
<?php
$sql = mysqli_query($con, "SELECT * FROM groups_wall_comment_like WHERE comment_id='". $res['comment_id'] ."'");
$comment_like_count = mysqli_num_rows($sql);

$comment_like_query1 = mysqli_query($con, "SELECT m.username,m.member_id FROM groups_wall_comment_like c, members m WHERE m.member_id=c.member_id 
AND c.comment_id='".$res['comment_id']."' AND c.member_id='".$_SESSION['SESS_MEMBER_ID']."' ");
$comment_like_res1 = mysqli_num_rows($comment_like_query1);
if($comment_like_res1==1)
{
$comment_like_query = mysqli_query($con, "SELECT m.username,m.member_id FROM groups_wall_comment_like c, members m WHERE m.member_id=c.member_id 
AND c.comment_id='".$res['comment_id']."' AND c.member_id!='".$_SESSION['SESS_MEMBER_ID']."' LIMIT 2");
$clike_count = mysqli_num_rows($comment_like_query);
$new_clike_count=$comment_like_count-2; 
}
else
{
$comment_like_query = mysqli_query($con, "SELECT m.username,m.member_id FROM groups_wall_comment_like c, members m WHERE m.member_id=c.member_id 
AND c.comment_id='".$res['comment_id']."' LIMIT 3");
$clike_count = mysqli_num_rows($comment_like_query);
$new_clike_count=$comment_like_count-3; 
}

?>
<div class="clike" id="clike<?php echo $res['comment_id'];?>" style="display:<?php if($comment_like_count <= 0) { echo 'none'; } else { echo 'block'; }?>">
<?php 

if($comment_like_res1==1)
{?><span id="you<?php echo $res['comment_id'];?>"><a href="#">You</a><?php if($comment_like_count>1)
echo ','; ?> </span><?php
}

?>
<!-- <input type="hidden" value="<?php if($comment_like_res1==1)echo 1;else echo 0; ?>" id="youcount<?php echo $res['comment_id'];?>" > -->
<input type="hidden"  value="<?php echo $comment_like_count; ?>" id="commacount<?php echo $res['comment_id'];?>" >
<?php

$i = 0;
while($comment_like_res = mysqli_fetch_array($comment_like_query)) {
$i++; 	  
?>

<a href="#" id="likeuser<?php echo $res['comment_id'];?>"><?php echo $comment_like_res['username']; ?></a>
<?php
	//}
if($i <> $clike_count) { echo ',';}
//} 
} 
if($clike_count > 3) {
?>
 and <span id="like_count<?php echo $res['comment_id'];?>" class="numcount"><?php echo $new_clike_count;?></span> others<?php } ?> like this.</div> 
<!--<span id="commentlikecout_container<?php echo $res['comment_id'];?>" style="display:<?php if($comment_like_count <= 0) { echo 'none'; } else { echo 'block'; }?>">

<span id="commentlikecount<?php echo $res['comment_id'];?>">
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
$cdquery = "SELECT * FROM groups_wall_comment_dislike WHERE comment_id='". $res['comment_id'] ."'";
$cdsql  = mysqli_query($con, $cdquery) or die(mysqli_error($con));
$comment_dislike_count = mysqli_num_rows($cdsql);

$cdquery1 = mysqli_query($con, "SELECT m.username,m.member_id FROM groups_wall_comment_dislike c, members m WHERE m.member_id=c.member_id 
AND c.comment_id='".$res['comment_id']."' LIMIT 3");
?>
<span id="dislikecout_container<?php echo $res['comment_id'];?>" style="display:<?php if($comment_dislike_count <= 0) { echo 'none'; } else { echo 'block'; }?>">
<span id="dislikecout<?php echo $res['comment_id'];?>">
<?php
echo $comment_dislike_count;
?>
</span>
Person Dislike this
</span>
</div>
<!--end dislike block-->
</span>
<span style="top:2px;">
<?php
$comment_like = mysqli_query($con, "select * from groups_wall_comment_like where comment_id = '".$res['comment_id']."' and member_id = '".$member_id."'");
if(mysqli_num_rows($comment_like) > 0)
{
	echo '<a href="javascript: void(0)" class="comment_like" id="comment_like'.$res['comment_id'].'" msg_id = '.$msg_id.' title="Unlike" rel="Unlike">Unlike</a>';
} 
else 
{ 
	echo '<a href="javascript: void(0)" class="comment_like" id="comment_like'.$res['comment_id'].'" msg_id = '.$msg_id.' title="Like" rel="Like">Like</a>';
}
?>
</span>
<!-- End of like button -->
<!-- Dislike button -->
<span style="top:2px; padding-left:5px;">
<?php
$cdquery1 = "SELECT * FROM groups_wall_comment_dislike WHERE comment_id='". $res['comment_id'] ."' and member_id = '".$member_id."'";
$cdsql1  = mysqli_query($con, $cdquery1) or die(mysqli_error($con));
$comment_dislike_count1 = mysqli_num_rows($cdsql1);
if($comment_dislike_count1 > 0) {
echo '<a href="javascript: void(0)" class="comment_dislike" id="comment_dislike'.$res['comment_id'].'" title="'.$lang['dislike'].'" rel="disLike">'.$lang['dislike'].'</a>';
} else {
echo '<a href="javascript: void(0)" class="comment_dislike" id="comment_dislike'.$res['comment_id'].'" title="'.$lang['Undislike'].'" rel="disLike">'.$lang['Undislike'].'</a>';
}
?>
</span> 
<!-- End of dislike  button -->
<!-- Reply Button -->
<span style="top:2px; margin-left:5px;">
<a href="" id="<?php echo $res['comment_id'];?>" class="replyopen">Reply</a>
</span>
<!-- <?php if($res['type']==1){?><span style="top:2px; left:3px;"><a class="translatebutton" onclick="translateSourceTarget(<?php echo $res['comment_id'];?>);" href="javascript:void(0)" >Translate </a> </span><?php } ?> -->

<?php if($res['type']==1)
{ ?>
<span style="top:2px; margin-left:3px;" > <a class="translateButton" href="javascript:void(0);" id="translateButton<?php echo $res['comment_id'];?>"  >Translate</a></span>

       
<?php 
} ?>


<!--View more reply-->
<?php
$query12  = mysqli_query($con, "SELECT * FROM groups_wall_reply WHERE comment_id=" . $res['comment_id'] . " ORDER BY reply_id DESC");
$records1 = mysqli_num_rows($query12);
$p = mysqli_query($con, "SELECT * FROM groups_wall_reply WHERE comment_id=" . $res['comment_id'] . " ORDER BY reply_id DESC limit 2,$records1");
$q = mysqli_num_rows($p);
if ($records1 > 2)
{
	$collapsed1 = true;?>
    <input type="hidden" value="<?php echo $records1?>" id="replytotals-<?php  echo $res['comment_id'];?>" />
	<div class="replyPanel" id="replycollapsed-<?php  echo $res['comment_id'];?>" align="left">
	<img src="images/cicon.png" style="float:left;" alt="" />
	<a href="javascript: void(0)" class="ViewReply">
	View <?php echo $q;?> more replys 
	</a>
	<span id="loader-<?php  echo $res['comment_id']?>">&nbsp;</span>
	</div>
<?php
}
?>
</div>

</div>
<div class="replycontainer" style="margin-left:40px;" id="replyload<?php echo $res['comment_id'];?>">

<?php
$reply_sql  = mysqli_query($con, "SELECT * FROM groups_wall_reply c,members m WHERE c.member_id = m.member_id and comment_id=" . $res['comment_id'] . " ORDER BY reply_id DESC limit 0,2");

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
<a class="streplydelete" href="#" id='<?php echo $reply_res['reply_id']; ?>' title='Delete Reply'></a>
<?php } ?>
<a href="<?php echo $base_url.$reply_res['username'];?>"><b><?php echo $reply_res['username']; ?> 
 
 </b></a>
<?php 
 
 if($res['member_id'] <> $reply_res['member_id'])
 {
	 echo '@'; 
	?> <a href="<?php echo $base_url.$res['username'];?>"><b><?php echo $res['username']; ?> 
 
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
$reply_like_query = mysqli_query($con, "SELECT * FROM groups_wall_reply_like WHERE reply_id='". $reply_res['reply_id'] ."'");
$reply_like_count = mysqli_num_rows($reply_like_query);

$reply_like_query1 = mysqli_query($con, "SELECT m.username,m.member_id 
								  FROM groups_wall_reply_like c, members m 
								  WHERE m.member_id = c.member_id 
								  AND c.reply_id = '".$reply_res['reply_id']."' 
								  AND c.member_id = '".$_SESSION['SESS_MEMBER_ID']."' ");
$reply_like_count = mysqli_num_rows($reply_like_query1);
if($reply_like_count == 1)
{
$reply_like_query2 = mysqli_query($con, "SELECT m.username,m.member_id 
								  FROM groups_wall_reply_like c, members m 
								  WHERE m.member_id=c.member_id 
								  AND c.reply_id='".$reply_res['reply_id']."' 
								  AND c.member_id!='".$_SESSION['SESS_MEMBER_ID']."' LIMIT 2");
$rlike_count = mysqli_num_rows($reply_like_query2);
$new_rlike_count = $reply_like_count - 2; 
}
else
{
$reply_like_query2 = mysqli_query($con, "SELECT m.username,m.member_id 
                                 FROM groups_wall_reply_like c, members m 
								 WHERE m.member_id=c.member_id 
								 AND c.reply_id='".$reply_res['reply_id']."' LIMIT 3");
$rlike_count = mysqli_num_rows($reply_like_query2);
$new_rlike_count=$reply_like_count - 3; 
}

?>
<div class="rlike" id="rlike<?php echo $res['comment_id'];?>" style="display:<?php if($reply_like_count <= 0) { echo 'none'; } else { echo 'block'; }?>">
<?php 

if($reply_like_count == 1)
{?><span id="you<?php echo $res['comment_id'];?>"><a href="#">You</a><?php if($reply_like_count>1)
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
 and <span id="rlike_count<?php echo $reply_res['reply_id'];?>" class="rnumcount"><?php echo $new_rlike_count;?></span> others<?php } ?> like this.</div> 

</div>
<!--end like block-->

<!--dislie block-->
<div>
<?php
$rdquery = "SELECT * FROM groups_wall_reply_dislike WHERE reply_id='". $reply_res['reply_id'] ."'";
$rdsql  = mysqli_query($con, $rdquery) or die(mysqli_error($con));
$reply_dislike_count = mysqli_num_rows($rdsql);

$rdquery1 = mysqli_query($con, "SELECT m.username,m.member_id FROM groups_wall_comment_dislike c, members m WHERE m.member_id=c.member_id 
AND c.comment_id='".$reply_res['reply_id']."'");
?>
<span id="rdislikecout_container<?php echo $reply_res['reply_id'];?>" style="display:<?php if($reply_dislike_count <= 0) { echo 'none'; } else { echo 'block'; }?>">
<span id="rdislikecout<?php echo $reply_res['reply_id'];?>">
<?php
echo $reply_dislike_count;
?>
</span>
Person Dislike this
</span>
</div>
<!--end dislike block-->
</span>
<span style="top:2px;">
<?php
$reply_like = mysqli_query($con, "select like_id from groups_wall_reply_like where reply_id = '".$reply_res['reply_id']."' and member_id = '".$member_id."'");
if(mysqli_num_rows($reply_like) > 0)
{
	echo '<a href="javascript: void(0)" class="reply_like" id="reply_like'.$reply_res['reply_id'].'"  title="Unlike" rel="Unlike">Unlike</a>';
} 
else 
{ 
	echo '<a href="javascript: void(0)" class="reply_like" id="reply_like'.$reply_res['reply_id'].'"  title="Like" rel="Like">Like</a>';
}
?>
</span>
<!-- End of like button -->
<!-- Dislike button -->
<span style="top:2px; padding-left:5px;">
<?php
$reply_dislike_query = "SELECT dislike_id FROM groups_wall_reply_dislike WHERE reply_id='". $reply_res['reply_id'] ."' and member_id = '".$member_id."'";
$reply_dislike_sql  = mysqli_query($con, $reply_dislike_query) or die(mysqli_error($con));
$reply_dislike_count = mysqli_num_rows($reply_dislike_sql);
if($reply_dislike_count > 0) {
echo '<a href="javascript: void(0)" class="reply_dislike" id="reply_dislike'.$reply_res['reply_id'].'" title="'.$lang['dislike'].'" rel="disLike">'.$lang['dislike'].'</a>';
} else {
echo '<a href="javascript: void(0)" class="reply_dislike" id="reply_dislike'.$reply_res['reply_id'].'" title="'.$lang['Undislike'].'" rel="disLike">'.$lang['Undislike'].'</a>';
}
?>
</span> 
<!-- End of dislike  button -->
<!-- Reply Button -->
<span style="top:2px; margin-left:5px;">
<a href="" id="<?php echo $reply_res['reply_id'];?>" class="reply-replyopen">Reply</a>
</span>
<?php if($res['type']==1)
{ ?>
<span style="top:2px; margin-left:3px;" > <a class="translateButton" href="javascript:void(0);" id="translateButton<?php echo $res['comment_id'];?>"  >Translate</a></span>
       
<?php 
} ?>

</div><!--End streplytext div-->
<!--reply@reply-->
<div class="replycontainer" style="margin-left:40px;" id="reply-reply-load<?php echo $reply_res['reply_id'];?>">
<?php
$reply_r_sql  = mysqli_query($con, "SELECT m.username,m.member_id,m.profImage,
						   a.content, a.date_created,a.id
						   FROM reply_reply a 
						   LEFT JOIN members m ON a.member_id = m.member_id 
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
<a class="reply-reply-delete" href="#" id='<?php echo $reply_r_res['reply_id']; ?>' title='Delete Reply'></a>
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
<input type="button"  value=" Cancel"  onclick="closereply-reply('reply-reply-update<?php echo $reply_res['reply_id'];?>')" class="cancel"/>
</form>
</div>
</div>
<!--End replyupdate div	--> 
</div><!--End streplybody div-->
<?php } ?>

<!--Start replyupdate -->
<div class="replyupdate" style='display:none' id='replybox<?php echo $res['comment_id'];?>'>
<div class="streplyimg">
<img src="<?php echo $res['profImage'];?>" class='small_face'/>
</div>

<div class="streplytext" >
<form method="post" action="">
<textarea name="reply" class="reply" maxlength="200"  id="rtextarea<?php echo $res['comment_id'];?>"></textarea>
<br /> 
<input type="submit" abcd="<?php echo $res['member_id']; ?>"  title="<?php echo $res['username']; ?>" value="    @    "  id="<?php echo $res['comment_id'];?>" class="reply_button"/>
<input type="button"  value=" Cancel "  id="<?php echo $row['messages_id'];?>" onclick="closereply('replybox<?php echo $res['comment_id'];?>')" class="cancel"/>
</form>
</div>
</div>
<!--End replyupdate div	--> 
</div><!--End replycontainer div-->
</div>
<?php
}
?>
