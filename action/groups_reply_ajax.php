<?php ob_start();
session_start();
include_once '../config.php';
include_once '../includes/time_stamp.php';

$member_id = $_SESSION['SESS_MEMBER_ID'];
$reply = $_POST['reply'];
$reply	 = 	f($reply, 'escapeAll');
$reply   = mysqli_real_escape_string($con, $reply);

$comment_id = $_POST['comment_id'];
$comment_id	 = 	f($comment_id, 'strip');
$comment_id	 = 	f($comment_id, 'escapeAll');
$comment_id   = mysqli_real_escape_string($con, $comment_id);


$uname = $_POST['uname'];
$uname	 = 	f($uname, 'strip');
$uname	 = 	f($uname, 'escapeAll');
$uname   = mysqli_real_escape_string($con, $uname);


$mem_id = $_POST['mem_id'];
$mem_id	 = 	f($mem_id, 'strip');
$mem_id	 = 	f($mem_id, 'escapeAll');
$mem_id   = mysqli_real_escape_string($con, $mem_id);


mysqli_query($con, "INSERT INTO groups_wall_reply (member_id,comment_id,content, date_created)
VALUES('$member_id','$comment_id','$reply','".strtotime(date("Y-m-d H:i:s"))."')");

$sql = mysqli_query($con, "select * from groups_wall_reply a JOIN members m ON m.member_id = a.member_id where comment_id = '$comment_id' order by reply_id desc");
$res = mysqli_fetch_array($sql);
if ($res)
{
	$com_id = $res['reply_id'];	
	$comment = $res['content'];
	$time = $res['date_created'];
	$username = $res['username'];
	$cface = $res['profImage'];
?>
<div class="streplybody" id="streplybody<?php echo $res['reply_id']; ?>">
<div class="stcommentimg">
<a href="<?php echo $base_url.$row['username'];?>"><img src="<?php echo $res['profImage']; ?>" class='small_face'/></a>
</div>
<div class="streplytext">
 <?php 
if($_SESSION['SESS_MEMBER_ID'] == $res['member_id'])
{
?>
<a class="streplydelete" href="#" id='<?php echo $res['reply_id']; ?>' title='Delete Reply'></a>
<?php } ?>
<a href="<?php echo $base_url.$res['username'];?>"><b><?php echo $res['username']; ?> 
 
 </b></a>
<?php 
 
 if($mem_id != $member_id)
 {
	 echo '@'; 
	?> <a href="<?php echo $base_url.$uname;?>"><b><?php echo $uname; ?> 
 
 </b></a>
	 
<?php
 }
   ?> 
 

<?php 
echo $res['content'];
?>
<div class="streplytime"><?php time_stamp($res['date_created']); ?></div>
<span style="padding-left:5px;">
<!--like block-->
<div>
<?php
$reply_like_query = mysqli_query($con, "SELECT * FROM groups_wall_reply_like WHERE reply_id='". $res['reply_id'] ."'");
$reply_like_count = mysqli_num_rows($reply_like_query);

$reply_like_query1 = mysqli_query($con, "SELECT m.username,m.member_id 
								  FROM groups_wall_reply_like c, members m 
								  WHERE m.member_id = c.member_id 
								  AND c.reply_id = '".$res['reply_id']."' 
								  AND c.member_id = '".$_SESSION['SESS_MEMBER_ID']."' ");
$reply_like_count = mysqli_num_rows($reply_like_query1);
if($reply_like_count == 1)
{
$reply_like_query2 = mysqli_query($con, "SELECT m.username,m.member_id 
								  FROM groups_wall_reply_like c, members m 
								  WHERE m.member_id=c.member_id 
								  AND c.reply_id='".$res['reply_id']."' 
								  AND c.member_id!='".$_SESSION['SESS_MEMBER_ID']."' LIMIT 2");
$rlike_count = mysqli_num_rows($reply_like_query2);
$new_rlike_count = $reply_like_count - 2; 
}
else
{
$reply_like_query2 = mysqli_query($con, "SELECT m.username,m.member_id 
                                 FROM groups_wall_reply_like c, members m 
								 WHERE m.member_id=c.member_id 
								 AND c.reply_id='".$res['reply_id']."' LIMIT 3");
$rlike_count = mysqli_num_rows($reply_like_query2);
$new_rlike_count=$reply_like_count - 3; 
}

?>
<div class="rlike" id="rlike<?php echo $row1['comment_id'];?>" style="display:<?php if($reply_like_count <= 0) { echo 'none'; } else { echo 'block'; }?>">
<?php 

if($reply_like_count == 1)
{?><span id="you<?php echo $row1['comment_id'];?>"><a href="#">You</a><?php if($reply_like_count>1)
echo ','; ?> </span><?php
}

?>

<input type="hidden"  value="<?php echo $reply_like_count; ?>" id="rcommacount<?php echo $res['reply_id'];?>" >
<?php

$i = 0;
while($reply_like_res = mysqli_fetch_array($reply_like_query2)) {
$i++; 	  
?>

<a href="#" id="likeuser<?php echo $res['reply_id'];?>"><?php echo $reply_like_res['username']; ?></a>
<?php
	//}
if($i <> $rlike_count) { echo ',';}
//} 
} 
if($rlike_count > 3) {
?>
 and <span id="rlike_count<?php echo $res['reply_id'];?>" class="rnumcount"><?php echo $new_rlike_count;?></span> others<?php } ?> like this.</div> 

</div>
<!--end like block-->

<!--dislie block-->
<div>
<?php
$rdquery = "SELECT * FROM groups_wall_reply_dislike WHERE reply_id='". $res['reply_id'] ."'";
$rdsql  = mysqli_query($con, $rdquery) or die(mysqli_error($con));
$reply_dislike_count = mysqli_num_rows($rdsql);

$rdquery1 = mysqli_query($con, "SELECT m.username,m.member_id FROM groups_wall_comment_dislike c, members m WHERE m.member_id=c.member_id 
AND c.comment_id='".$res['reply_id']."'");
?>
<span id="rdislikecout_container<?php echo $res['reply_id'];?>" style="display:<?php if($reply_dislike_count <= 0) { echo 'none'; } else { echo 'block'; }?>">
<span id="rdislikecout<?php echo $res['reply_id'];?>">
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
$reply_like = mysqli_query($con, "select like_id from groups_wall_reply_like where reply_id = '".$res['reply_id']."' and member_id = '".$member_id."'");
if(mysqli_num_rows($reply_like) > 0)
{
	echo '<a href="javascript: void(0)" class="reply_like" id="reply_like'.$res['reply_id'].'"  title="Unlike" rel="Unlike">Unlike</a>';
} 
else 
{ 
	echo '<a href="javascript: void(0)" class="reply_like" id="reply_like'.$res['reply_id'].'"  title="Like" rel="Like">Like</a>';
}
?>
</span>
<!-- End of like button -->
<!-- Dislike button -->
<span style="top:2px; padding-left:5px;">
<?php
$reply_dislike_query = "SELECT dislike_id FROM groups_wall_reply_dislike WHERE reply_id='". $res['reply_id'] ."' and member_id = '".$member_id."'";
$reply_dislike_sql  = mysqli_query($con, $reply_dislike_query) or die(mysqli_error($con));
$reply_dislike_count = mysqli_num_rows($reply_dislike_sql);
if($reply_dislike_count > 0) {
echo '<a href="javascript: void(0)" class="reply_dislike" id="reply_dislike'.$res['reply_id'].'" title="disLike" rel="disLike">DisLike</a>';
} else {
echo '<a href="javascript: void(0)" class="reply_dislike" id="reply_dislike'.$res['reply_id'].'" title="disLike" rel="disLike">DisLike</a>';
}
?>
</span> 
<!-- End of dislike  button -->

<span style="top:2px; margin-left:3px;" > <a class="translateButton" href="javascript:void(0);" id="translateButton<?php echo $comment_id;?>"  >Translate</a></span>


</div><!--End streplytext div-->
<!--reply@reply-->
<div class="replycontainer" style="margin-left:40px;" id="reply-reply-load<?php echo $res['reply_id'];?>">
<?php
$reply_r_sql  = mysqli_query($con, "SELECT m.username,m.member_id,m.profImage,
						   a.content, a.date_created,a.id
						   FROM groups_wall_reply_reply a 
						   LEFT JOIN members m ON a.member_id = m.member_id 
						   WHERE reply_id=" . $res['reply_id'] . " 
						   ORDER BY id DESC limit 0,2") or die(mysqli_error($con));

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
 
 if($res['member_id'] <> $reply_r_res['member_id'])
 {
	 echo '@'; 
	?> <a href="<?php echo $base_url.$res['username'];?>"><b><?php echo $res['username']; ?> 
 
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
<div class="reply-reply-update" style='display:none' id='reply-reply-update<?php echo $res['reply_id'];?>'>
<div class="streplyimg">
<img src="<?php echo $res['profImage'];?>" class='small_face'/>
</div>

<div class="reply-reply-text" >
<form method="post" action="">
<textarea name="reply" class="reply-reply" maxlength="200"  id="reply-reply<?php echo $res['reply_id'];?>"></textarea>
<br /> 
<input type="submit" abcd="<?php echo $res['member_id']; ?>"  title="<?php echo $res['username']; ?>" value="    @    "  id="<?php echo $res['reply_id'];?>" class="reply-reply"/>
<input type="button"  value=" Cancel"  onclick="closereplyreply('reply-reply-update<?php echo $res['reply_id'];?>')" class="cancel"/>
</form>
</div>
</div>
<!--End replyupdate div	--> 
</div>
<?php
}
?>
