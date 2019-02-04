<?php ob_start();

	session_start();

	include('../config.php');

	include('../includes/time_stamp.php');

	if(isset($_SESSION['lang']))
	{	
		include('../common.php');
	}
	else
	{
		include('../en.php');
		
	}

	

	$member_id = $_SESSION['SESS_MEMBER_ID'];

	$member = mysqli_query($con, "select * from members where member_id = '$member_id'");

	$member_res = mysqli_fetch_array($member);
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

	function clickable_link($text = '')

	{

	$text = preg_replace_callback('#(script|about|applet|activex|chrome):#is',function($matches) {
        return $matches[1];
			}, $text);
		$ret = ' ' . $text;
		$ret = preg_replace_callback("#(^|[\n ])([\w]+?://[\w\#$%&~/.\-;:=,?@\[\]+]*)#is",'_make_url_clickable_cb', $ret);
		$ret = preg_replace_callback("#(^|[\n ])((www|ftp)\.[\w\#$%&~/.\-;:=,?@\[\]+]*)#is",'_make_web_ftp_clickable_cb', $ret);
		$ret = preg_replace_callback("#(^|[\n ])([a-z0-9&\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)#i",'_make_email_clickable_cb', $ret);
		$ret = substr($ret, 1);

		return $ret;

	}

	$total = (int)$_REQUEST['totals'];

	$comments = mysqli_query($con, "SELECT * FROM groups_wall_comment c LEFT JOIN members m ON m.member_id = c.post_member_id where msg_id = ".$_REQUEST['postId']." order by date_created desc limit 4, ".$total);

		

	$comment_num_row = mysqli_num_rows(@$comments);

	

	if($comment_num_row > 0)

	{

		while ($rows = mysqli_fetch_array($comments))

		{

	?>			

			

<div class="stcommentbody" id="stcommentbody<?php echo $rows['comment_id']; ?>">

<div class="stcommentimg">

<a href="<?php echo $base_url.$row['username'];?>"><img src="<?php echo $rows['profImage']; ?>" class='small_face'/></a>

</div> 

<div class="stcommenttext">

<?php 

if($_SESSION['SESS_MEMBER_ID'] == $rows['member_id'])

{

?>

<a class="stcommentdelete" href="#" id='<?php echo $rows['comment_id']; ?>' title='<?php echo $lang['Delete Comment'];?> '></a>

<?php } ?>

<a href="<?php echo $base_url.$rows['username'];?>"><b><?php echo $rows['username']; ?></b> </a>

<?php 

if($rows['type']==1){ echo $rows['content']; 

	?>

	

	<div id="translatemenu<?php echo $rows['comment_id'];?>" class="translatemenu" style="display:none; position:absolute;margin-left: 34%; "> <select id="langs<?php echo $rows['comment_id'];?>" class="langs" onchange="selectOption(this.value, <?php echo $rows['comment_id'];?>,1)">

            <option value=""><?php echo $lang['select language'];?></option> 

            </select></div> 

            

	<textarea class="source" id="source<?php echo $rows['comment_id']; ?>"  style="display:none;"><?php echo $rows['content']; ?></textarea>

	<?php

}

if($rows['type']==2) echo '<img src="'.$rows["content"].'" >';

?>

<div class="target" style="font:bold;" id="target<?php echo $rows['comment_id']; ?>"></div>

<div class="stcommenttime"><?php time_stamp($rows['date_created']); ?>

<!--  like button  -->

<span style="padding-left:5px;">

<!--like block-->

<div>

<?php

$sql = mysqli_query($con, "SELECT * FROM groups_wall_comment_like WHERE comment_id='". $rows['comment_id'] ."'");

$comment_like_count = mysqli_num_rows($sql);



$comment_like_query1 = mysqli_query($con, "SELECT m.username,m.member_id FROM groups_wall_comment_like c, members m WHERE m.member_id=c.member_id 

AND c.comment_id='".$rows['comment_id']."' AND c.member_id='".$_SESSION['SESS_MEMBER_ID']."' ");

$comment_like_res1 = mysqli_num_rows($comment_like_query1);

if($comment_like_res1==1)

{

$comment_like_query = mysqli_query($con, "SELECT m.username,m.member_id FROM groups_wall_comment_like c, members m WHERE m.member_id=c.member_id 

AND c.comment_id='".$rows['comment_id']."' AND c.member_id!='".$_SESSION['SESS_MEMBER_ID']."' LIMIT 2");

$clike_count = mysqli_num_rows($comment_like_query);

$new_clike_count=$comment_like_count-2; 

}

else

{

$comment_like_query = mysqli_query($con, "SELECT m.username,m.member_id FROM groups_wall_comment_like c, members m WHERE m.member_id=c.member_id 

AND c.comment_id='".$rows['comment_id']."' LIMIT 3");

$clike_count = mysqli_num_rows($comment_like_query);

$new_clike_count=$comment_like_count-3; 

}



?>

<div class="clike" id="clike<?php echo $rows['comment_id'];?>" style="display:<?php if($comment_like_count <= 0) { echo 'none'; } else { echo 'block'; }?>">

<?php 



if($comment_like_res1==1)

{?><span id="you<?php echo $rows['comment_id'];?>"><a href="#"><?php echo $lang['You'];?> </a><?php if($comment_like_count>1)

echo ','; ?> </span><?php

}



?>

<!-- <input type="hidden" value="<?php if($comment_like_res1==1)echo 1;else echo 0; ?>" id="youcount<?php echo $rows['comment_id'];?>" > -->

<input type="hidden"  value="<?php echo $comment_like_count; ?>" id="commacount<?php echo $rows['comment_id'];?>" >

<?php



$i = 0;

while($comment_like_res = mysqli_fetch_array($comment_like_query)) {

$i++; 	  

?>



<a href="#" id="likeuser<?php echo $rows['comment_id'];?>"><?php echo $comment_like_res['username']; ?></a>

<?php

	//}

if($i <> $clike_count) { echo ',';}

//} 

} 

if($clike_count > 3) {

?>

 <?php echo $lang['and'];?>  <span id="like_count<?php echo $rows['comment_id'];?>" class="numcount"><?php echo $new_clike_count;?></span> <?php echo $lang['others'];?><?php } ?> <?php echo $lang['like this'];?>.</div> 

<!--<span id="commentlikecout_container<?php echo $rows['comment_id'];?>" style="display:<?php if($comment_like_count <= 0) { echo 'none'; } else { echo 'block'; }?>">



<span id="commentlikecount<?php echo $rows['comment_id'];?>">

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

$cdquery = "SELECT * FROM groups_wall_comment_dislike WHERE comment_id='". $rows['comment_id'] ."'";

$cdsql  = mysqli_query($con, $cdquery) or die(mysqli_error($con));

$comment_dislike_count = mysqli_num_rows($cdsql);



$cdquery1 = mysqli_query($con, "SELECT m.username,m.member_id FROM groups_wall_comment_dislike c, members m WHERE m.member_id=c.member_id 

AND c.comment_id='".$rows['comment_id']."' LIMIT 3");

?>

<span id="dislikecout_container<?php echo $rows['comment_id'];?>" style="display:<?php if($comment_dislike_count <= 0) { echo 'none'; } else { echo 'block'; }?>">

<span id="dislikecout<?php echo $rows['comment_id'];?>">

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

$comment_like = mysqli_query($con, "select * from groups_wall_comment_like where comment_id = '".$rows['comment_id']."' and member_id = '".$member_id."'");

if(mysqli_num_rows($comment_like) > 0)

{

	echo '<a href="javascript: void(0)" class="comment_like" id="comment_like'.$rows['comment_id'].'" msg_id = '.$row['messages_id'].' title="'.$lang['Unlike'].'" rel="Unlike">'.$lang['Unlike'].'</a>';

} 

else 

{ 

	echo '<a href="javascript: void(0)" class="comment_like" id="comment_like'.$rows['comment_id'].'" msg_id = '.$row['messages_id'].' title="'.$lang['Like'].'" rel="Like">'.$lang['Like'].'</a>';

}

?>

</span>

<!-- End of like button -->

<!-- Dislike button -->

<span style="top:2px; padding-left:5px;">

<?php

$cdquery1 = "SELECT * FROM groups_wall_comment_dislike WHERE comment_id='". $rows['comment_id'] ."' and member_id = '".$member_id."'";

$cdsql1  = mysqli_query($con, $cdquery1) or die(mysqli_error($con));

$comment_dislike_count1 = mysqli_num_rows($cdsql1);

if($comment_dislike_count1 > 0) {

echo '<a href="javascript: void(0)" class="comment_dislike" id="comment_dislike'.$rows['comment_id'].'" title="'.$lang['dislike'].'" rel="dislike">'.$lang['dislike'].'</a>';

} else {

echo '<a href="javascript: void(0)" class="comment_dislike" id="comment_dislike'.$rows['comment_id'].'" title="'.$lang['Undislike'].'" rel="dislike">'.$lang['Undislike'].'</a>';

}

?>

</span> 

<!-- End of dislike  button -->

<!-- Reply Button -->

<span style="top:2px; margin-left:5px;">

<a href="" id="<?php echo $rows['comment_id'];?>" class="replyopen"><?php echo $lang['Reply'];?></a>

</span>

<!-- <?php if($rows['type']==1){?><span style="top:2px; left:3px;"><a class="translatebutton" onclick="translateSourceTarget(<?php echo $rows['comment_id'];?>);" href="javascript:void(0)" >Translate </a> </span><?php } ?> -->



<?php if($rows['type']==1)

{ ?>







<span style="top:2px; margin-left:3px;" > <a class="translateButton" href="javascript:void(0);" id="translateButton<?php echo $rows['comment_id'];?>"  ><?php echo  $lang['Translate'];?></a></span>



       

<?php 

} ?>





<!--View more reply-->

<?php

$query12  = mysqli_query($con, "SELECT * FROM groups_wall_reply WHERE comment_id=" . $rows['comment_id'] . " ORDER BY reply_id DESC");

$records1 = mysqli_num_rows($query12);

$p = mysqli_query($con, "SELECT * FROM groups_wall_reply WHERE comment_id=" . $rows['comment_id'] . " ORDER BY reply_id DESC limit 2,$records1");

$q = mysqli_num_rows($p);

if ($records1 > 2)

{

	$collapsed1 = true;?>

    <input type="hidden" value="<?php echo $records1?>" id="replytotals-<?php  echo $rows['comment_id'];?>" />

	<div class="replyPanel" id="replycollapsed-<?php  echo $rows['comment_id'];?>" align="left">

	<img src="images/cicon.png" style="float:left;" alt="" />

	<a href="javascript: void(0)" class="ViewReply">

	<?php  echo $lang['View'];?> <?php echo $q;?> <?php  echo $lang['more replys'];?>

	</a>

	<span id="loader-<?php  echo $rows['comment_id']?>">&nbsp;</span>

	</div>

<?php

}

?>

</div>



</div>

<div class="replycontainer" style="margin-left:40px;" id="replyload<?php echo $rows['comment_id'];?>">



<?php

$reply_sql  = mysqli_query($con, "SELECT * FROM groups_wall_reply c,members m WHERE c.member_id = m.member_id and comment_id=" . $rows['comment_id'] . " ORDER BY reply_id DESC limit 0,2");



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

 

 if($rows['member_id'] <> $reply_res['member_id'])

 {

	 echo '@'; 

	?> <a href="<?php echo $base_url.$rows['username'];?>"><b><?php echo $rows['username']; ?> 

 

 </b></a>

	 

<?php

 }

   ?> 

 



<?php 

echo $reply_res['content'];





?>

<div class="replytarget" style="font:bold;" id="replytarget<?php echo $reply_res['reply_id'];?>"></div>





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

<div class="rlike" id="rlike<?php echo $rows['comment_id'];?>" style="display:<?php if($reply_like_count <= 0) { echo 'none'; } else { echo 'block'; }?>">

<?php 



if($reply_like_count == 1)

{?><span id="you<?php echo $rows['comment_id'];?>"><a href="#"><?php echo $lang['You'];?></a><?php if($reply_like_count>1)

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

<?php echo $lang['and'];?> <span id="rlike_count<?php echo $reply_res['reply_id'];?>" class="rnumcount"><?php echo $new_rlike_count;?></span><?php echo $lang['others'];?><?php } ?> <?php echo $lang['like this'];?>.</div> 



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

<?php echo $lang['Person Dislike this'];?>

</span>

</div>

<!--end dislike block-->

</span>

<span style="top:2px;">

<?php

$reply_like = mysqli_query($con, "select like_id from groups_wall_reply_like where reply_id = '".$reply_res['reply_id']."' and member_id = '".$member_id."'");

if(mysqli_num_rows($reply_like) > 0)

{

	echo '<a href="javascript: void(0)" class="reply_like" id="reply_like'.$reply_res['reply_id'].'"  title="'.$lang['Unlike'].'" rel="Unlike">'.$lang['Unlike'].'</a>';

} 

else 

{ 

	echo '<a href="javascript: void(0)" class="reply_like" id="reply_like'.$reply_res['reply_id'].'"  title="'.$lang['like'].'" rel="Like">'.$lang['like'].'</a>';

}

?>

</span>

<!-- End of like button -->

<!-- Dislike button -->

<span style="top:2px; padding-left:5px;">

<?php

$reply_dislike_query = "SELECT groups_wall_dislike_id FROM reply_dislike WHERE reply_id='". $reply_res['reply_id'] ."' and member_id = '".$member_id."'";

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

<a href="" id="<?php echo $reply_res['reply_id'];?>" class="reply-replyopen"><?php echo $lang['Reply']; ?></a>

</span>



<!---------------- Vinayak----------------------------->







<div tabindex="1" id="replytranslatemenu<?php echo $reply_res['reply_id'];?>" class="replytranslatemenu" style="display:none; position:absolute;margin-left: 34%; "> <select id="replylangs<?php echo $reply_res['reply_id'];?>" class="postlangs" onchange="selectOption(this.value, <?php echo $reply_res['reply_id'];?>,3)">

            <option value=""><?php echo $lang['select language'];?></option> 

            </select>

            </div> 

            

<textarea class="replysource" id="replysource<?php echo $reply_res['reply_id'];?>"  style="display:none;"><?php echo $reply_res['content'];?></textarea>

<div class="replytarget" style="font:bold;" id="replytarget<?php echo $reply_res['reply_id'];?>"></div>





<?php if($rows['type']==1)

{ ?>

<span style="top:2px; margin-left:3px;" > <a class="replytranslateButton" href="javascript:void(0);" id="replytranslateButton<?php echo $reply_res['reply_id'];?>"  ><?php echo $lang['Translate']; ?></a></span>

       

<?php 

} ?>



</div><!--End streplytext div-->

<!--reply@reply-->

<div class="replycontainer" style="margin-left:40px;" id="reply-reply-load<?php echo $reply_res['reply_id'];?>">

<?php

$reply_r_sql  = mysqli_query($con, "SELECT m.username,m.member_id,m.profImage,

						   a.content, a.date_created,a.id

						   FROM groups_wall_reply_reply a 

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

<div class="replyupdate" style='display:none' id='replybox<?php echo $rows['comment_id'];?>'>

<div class="streplyimg">

<img src="<?php echo $res['profImage'];?>" class='small_face'/>

</div>



<div class="streplytext" >

<form method="post" action="">

<textarea name="reply" class="reply" maxlength="200"  id="rtextarea<?php echo $rows['comment_id'];?>"></textarea>

<br /> 

<input type="submit" abcd="<?php echo $rows['member_id']; ?>"  title="<?php echo $rows['username']; ?>" value="    @    "  id="<?php echo $rows['comment_id'];?>" class="reply_button"/>

<input type="button"  value=" <?php echo $lang["Cancel"];?> "  id="<?php echo $row['messages_id'];?>" onclick="closereply('replybox<?php echo $rows['comment_id'];?>')" class="cancel"/>

</form>

</div>

</div>

<!--End replyupdate div	--> 

</div><!--End replycontainer div-->

</div>

		<?php

		}

		?>

        </div>

		<?php

	}?>