<?php
include('config.php');
include('includes/time_stamp.php');
$member_id = $_SESSION['SESS_MEMBER_ID'];
	$sql = mysqli_query($con, "select * from members where member_id='".$member_id."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);
$last_msg_id=$_GET['last_msg_id'];

$query  = "SELECT * FROM groups_wall msg,members m where msg.member_id=m.member_id and messages_id < '$last_msg_id' ORDER BY messages_id DESC LIMIT 5";

$result = mysqli_query($con, $query);

while($row = mysqli_fetch_assoc($result))
{
	$time = $row['date_created'];
	
		if($member_id == $row['member_id'] or $row['wall_privacy']==1)
	{
				
		
?>	
<div class="stbody" id="stbody<?php echo $row['messages_id'];?>">

<div class="stimg">
<a href="member_profile.php?member_id=<?php echo $row['member_id'];?>"><img src="<?php echo $row['profImage'];?>" class='big_face'/></a>
</div><!--End stimg div	-->

<div class="sttext">
<?php 
if($_SESSION['SESS_MEMBER_ID'] == $row['member_id'])
{
?>
<a class="stdelete" href="#" id="<?php echo $row['messages_id'];?>" title="Delete update">X</a>
<?php }?>


<a href="member_profile.php?member_id=<?php echo $row['member_id'];?>"><b><?php echo $row['username'];?></b></a> <img style="margin:0px 3px;" src="images/arrow_png.jpg" /> 
<a href="country_wall.php?country=<?php echo $row['country_flag'];?>"><b><?php echo strtoupper($row['country_flag']);?></b></a>
<div style="margin:5px 0px;">
 <?php if($row['type']==0){echo $row['messages'];} if($row['type']==1){?>
<a href="albums.php?back_page='logged_in.php'&member_id=<?php echo $row['member_id']; ?>&album_id=<?php echo $row['msg_album_id']; ?>" >
<img src="<?php echo $row['messages'];?>" height="250" width="400" />
</a>

<?php } if($row['type']==2){?>
<div id="myElement">Loading the player...</div>

<script type="text/javascript">
    jwplayer("myElement").setup({
        file: "<?php echo $row['messages'];?>",
        width:320,
		height:240
    });
</script>


<?php }if($row['type']==3){
if (preg_match('![?&]{1}v=([^&]+)!', $row['messages'] . '&', $m))
	$video_id = $m[1]; 
	$url = "http://gdata.youtube.com/feeds/api/videos/".$video_id;
	$doc = new DOMDocument;
	$doc->load($url);
	$title = $doc->getElementsByTagName("title")->item(0)->nodeValue;
	?>
    <span style="margin-bottom:5px;"> Title : <strong> <?php echo $title; ?> </strong> </span>
    <embed src="http://www.youtube.com/v/<?php echo $video_id ?>&hl=en&fs=1&hd=1&showinfo=0&rel=0" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="350" height="225" wmode="transparent"></embed>
<?php } ?>
</div>
<div class="sttime"><?php time_stamp($time);?>
<br />
<?php 

$sql = mysqli_query($con, "SELECT * FROM bleh WHERE remarks='". $row['messages_id'] ."'");
$like_count = mysqli_num_rows($sql);

if($like_count > 0) 
{ 
$query=mysqli_query($con, "SELECT m.username,m.member_id FROM bleh b, members m WHERE m.member_id=b.member_id AND b.remarks='".$row['messages_id']."' LIMIT 3");
$like = mysqli_num_rows($query);
?>
<div class="commentPanel">
<div class='likeUsers' id="likes<?php echo $row['messages_id']; ?>">
<?php
while($row1=mysqli_fetch_array($query))
{
$like_uid=$row1['member_id']; 
$likeusername=$row1['username']; 
if($like_uid==$row['member_id'])
{
echo '<span id="you'.$row['messages_id'].'"><a href="'.$likeusername.'">You </a></span>';
}
else
{ 
echo '<a href="'.$likeusername.'">'.$likeusername.'</a>';
}  
}
echo ' and '.$like_count.' other friends like this';
?> 
</div></div>
<?php }
else { 
echo '<div class="likeUsers" id="elikes'.$row['messages_id'].'"></div>';
} 

?>

</div> 
<?php
$query1  = mysqli_query($con, "SELECT * FROM postcomment WHERE msg_id=" . $row['messages_id'] . " ORDER BY comment_id DESC");
$records = mysqli_num_rows($query1);
$s = mysqli_query($con, "SELECT * FROM groups_wall_comment g,members m WHERE g.post_member_id=m.member_id and g.msg_id=" . $row['messages_id'] . " ORDER BY comment_id DESC limit 4,$records");
$y = mysqli_num_rows($s);
if ($records > 4)
{
	$collapsed = true;?>
    <input type="hidden" value="<?php echo $records?>" id="totals-<?php  echo $row['messages_id'];?>" />
	<div class="commentPanel" id="collapsed-<?php  echo $row['messages_id'];?>" align="left">
	<img src="images/cicon.png" style="float:left;" alt="" />
	<a href="javascript: void(0)" class="ViewComments">
	View <?php echo $y;?> more comments 
	</a>
	<span id="loader-<?php  echo $row['messages_id']?>">&nbsp;</span>
	</div>
<?php
}
?>
<div id="stexpandbox">
<div id="stexpand<?php echo $row['messages_id'];?>"></div>
</div><!--End stexpandbox div	--> 

<div class="commentcontainer" id="commentload<?php echo $row['messages_id'];?>">
<?php
$comment  = mysqli_query($con, "SELECT * FROM groups_wall_comment g,members m WHERE g.post_member_id=m.member_id and g.msg_id=" . $row['messages_id'] . " ORDER BY comment_id DESC limit 0,4");
while($row1 = mysqli_fetch_assoc($comment))
{
?>
<div class="stcommentbody" id="stcommentbody<?php echo $row1['comment_id']; ?>">
<div class="stcommentimg">
<a href="member_profile.php?member_id=<?php echo $row['member_id'];?>"><img src="<?php echo $row1['profImage']; ?>" class='small_face'/></a>
</div> 
<div class="stcommenttext">
<?php 
if($_SESSION['SESS_MEMBER_ID'] == $row1['member_id'])
{
?>
<a class="stcommentdelete" href="#" id='<?php echo $row1['comment_id']; ?>' title='Delete Comment'>X</a>
<?php } ?>
<a href="member_profile.php?member_id=<?php echo $row['member_id'];?>"><b><?php echo $row1['username']; ?></b> </a>
<?php 
if($row1['type']==1) echo $row1['content'];
if($row1['type']==2) echo '<img src="'.$row1["content"].'" >';
?>
<div class="stcommenttime"><?php time_stamp($row1['date_created']); ?>
<span style="padding-left:5px;">
<?php
$sql = mysqli_query($con, "SELECT * FROM comment_like WHERE comment_id='". $row1['comment_id'] ."'");
$comment_like_count = mysqli_num_rows($sql);

if($comment_like_count > 0) 
{ 
$query1=mysqli_query($con, "SELECT m.username,m.member_id FROM comment_like c, members m WHERE m.member_id=c.member_id 
AND c.comment_id='".$row1['comment_id']."' LIMIT 3");
$like = mysqli_num_rows($query1);
?>
<div class='likeUsers' id="likes<?php echo $row1['comment_id']; ?>">
<?php
while($comment_like_res=mysqli_fetch_array($query1))
{
$like_uid=$comment_like_res['member_id']; 
$likeusername=$comment_like_res['username']; 
if($like_uid==$row['member_id'])
{
echo '<span id="you'.$row1['comment_id'].'"><a href="'.$likeusername.'">You&nbsp;</a></span>';
}
else
{ 
echo '<a href="'.$likeusername.'">'.$likeusername.'&nbsp;</a>';
}  
}
echo 'and '.$comment_like_count.' other friends like this';
?> 
</div>
<?php }
else { 
echo '<div class="likeUsers" id="elikes'.$row1['comment_id'].'"></div>';
} 
?>
</span>
<span style="top:2px; left:3px;">
<?php
$comment_like = mysqli_query($con, "select * from comment_like where comment_id = '".$row1['comment_id']."' and member_id = '".$member_id."'");
if(mysqli_num_rows($comment_like) > 0)
{
	echo '<a href="javascript: void(0)" class="comment_like" id="comment_like'.$row1['comment_id'].'" title="Unlike" rel="Unlike">Unlike</a>';
} 
else 
{ 
	echo '<a href="javascript: void(0)" class="comment_like" id="comment_like'.$row1['comment_id'].'" title="Like" rel="Like">Like</a>';
}
?>
</span>
<span style="top:2px; left:3px;">
<a href="" id="<?php echo $row1['comment_id'];?>" class="replyopen">Reply</a>
</span>

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
	View <?php echo $q;?> more replys 
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
$reply_sql  = mysqli_query($con, "SELECT * FROM comment_reply c,members m WHERE c.member_id = m.member_id and comment_id=" . $row1['comment_id'] . " ORDER BY reply_id DESC limit 0,2");

while($reply_res = mysqli_fetch_assoc($reply_sql))
{
?>
<div class="streplybody" id="streplybody<?php echo $reply_res['reply_id']; ?>">
<div class="stcommentimg">
<a href="member_profile.php?member_id=<?php echo $row['member_id'];?>"><img src="<?php echo $reply_res['profImage']; ?>" class='small_face'/></a>
</div>
<div class="streplytext">
 <?php 
if($_SESSION['SESS_MEMBER_ID'] == $reply_res['member_id'])
{
?>
<a class="streplydelete" href="#" id='<?php echo $reply_res['reply_id']; ?>' title='Delete Comment'>X</a>
<?php } ?>
<a href="member_profile.php?member_id=<?php echo $row['member_id'];?>"><b><?php echo $reply_res['username']; ?></b></a>
<?php 
echo $reply_res['content'];
?>
<div class="streplytime"><?php time_stamp($reply_res['date_created']); ?></div>
</div><!--End streplytext div-->
</div><!--End streplybody div-->
<?php } ?>
<!--Start replyupdate -->
<div class="replyupdate" style='display:none' id='replybox<?php echo $row1['comment_id'];?>'>
<div class="streplyimg">
<img src="<?php echo $res['profImage'];?>" class='small_face'/>
</div>

<div class="streplytext" >
<form method="post" action="">
<textarea name="reply" class="reply" maxlength="200"  id="rtextarea<?php echo $row1['comment_id'];?>"></textarea>
<br />
<input type="submit"  value=" reply "  id="<?php echo $row1['comment_id'];?>" class="reply_button"/>
<input type="button"  value=" Cancel "  id="<?php echo $row['messages_id'];?>" onclick="closereply('replybox<?php echo $row1['comment_id'];?>')" class="cancel"/>
</form>
</div>
</div><!--End replyupdate div	--> 
</div><!--End replycontainer div-->
</div>
<?php } 
$q = mysqli_query($con, "SELECT * FROM bleh WHERE member_id='". $_SESSION['SESS_MEMBER_ID'] ."' and remarks='".$row['messages_id']."' ");
?>

</div><!--End commentcontainer div	--> 

<div class="commentupdate" style='display:none' id='commentbox<?php echo $row['messages_id'];?>'>
<div class="stcommentimg">
<img src="<?php echo $res['profImage'];?>" class='small_face'/>
</div>

<div class="stcommenttext" >
<form method="post" action="">
<textarea name="comment" class="comment" maxlength="200"  id="ctextarea<?php echo $row['messages_id'];?>"></textarea>
<br />
<input type="submit"  value=" Comment "  id="<?php echo $row['messages_id'];?>" class="button"/>
<input type="button"  value=" Cancel "  id="<?php echo $row['messages_id'];?>" onclick="cancelclose('commentbox<?php echo $row['messages_id'];?>')" class="cancel"/>

</form>
</div>
</div><!--End commentupdate div	--> 
<div class="commentupdate" style='display:none' id='reportbox<?php echo $row['messages_id'];?>'>
<div class="stcommentimg">
<img src="<?php echo $res['profImage'];?>" class='small_face'/>
</div>

<div class="stcommenttext" >
<form method="post" action="">
<textarea name="comment" class="comment" maxlength="200"  id="rptextarea<?php echo $row['messages_id'];?>" placeholder="Flag this status.."></textarea>
<br />
<input type="submit"  value=" Report "  id="<?php echo $row['messages_id'];?>" class="report"/>
<input type="button"  value=" Cancel "  id="<?php echo $row['messages_id'];?>" onclick="canclose('reportbox<?php echo $row['messages_id'];?>')" class="cancel"/>
</form>
</div>
</div><!--End commentupdate div	--> 
<div class="emot_comm">
    <div id="normal-button" class="settings-button" title="0" value="<?php echo $row['messages_id']; ?>" >
    <span style="bottom: 2px;float: left;position: relative;width: 33px;cursor: pointer;" class="">
	<img src="images/Glad.png"/>
	</span>
    </div>
	<div class="submenu12" id="<?php echo $row['messages_id']; ?>-submenu12" style="display: none; position: absolute; background:#ffffff">
	  
	      <a href="action/commentpost.php?postid=<?php echo $row['messages_id']; ?>&user=<?php echo $_SESSION['SESS_FIRST_NAME']; ?>&pic=<?php echo $_SESSION['SESS_LAST_NAME']; ?>&postcomment=images/1.jpg&type=2" ><img src="images/1.jpg"></a>
	    
	      <a href="action/commentpost.php?postid=<?php echo $row['messages_id']; ?>&user=<?php echo $_SESSION['SESS_FIRST_NAME']; ?>&pic=<?php echo $_SESSION['SESS_LAST_NAME']; ?>&postcomment=images/2.jpg&type=2" ><img src="images/2.jpg"></a>
	    
	      <a href="action/commentpost.php?postid=<?php echo $row['messages_id']; ?>&user=<?php echo $_SESSION['SESS_FIRST_NAME']; ?>&pic=<?php echo $_SESSION['SESS_LAST_NAME']; ?>&postcomment=images/3.jpg&type=2" ><img src="images/3.jpg"></a>
	    
	      <a href="action/commentpost.php?postid=<?php echo $row['messages_id']; ?>&user=<?php echo $_SESSION['SESS_FIRST_NAME']; ?>&pic=<?php echo $_SESSION['SESS_LAST_NAME']; ?>&postcomment=images/4.jpg&type=2" ><img src="images/4.jpg"></a>
	      
	      <a href="action/commentpost.php?postid=<?php echo $row['messages_id']; ?>&user=<?php echo $_SESSION['SESS_FIRST_NAME']; ?>&pic=<?php echo $_SESSION['SESS_LAST_NAME']; ?>&postcomment=images/5.jpg&type=2" ><img src="images/5.jpg"></a>
	    
	     <a href="action/commentpost.php?postid=<?php echo $row['messages_id']; ?>&user=<?php echo $_SESSION['SESS_FIRST_NAME']; ?>&pic=<?php echo $_SESSION['SESS_LAST_NAME']; ?>&postcomment=images/6.jpg&type=2" ><img src="images/6.jpg"></a>
	    
	      <a href="action/commentpost.php?postid=<?php echo $row['messages_id']; ?>&user=<?php echo $_SESSION['SESS_FIRST_NAME']; ?>&pic=<?php echo $_SESSION['SESS_LAST_NAME']; ?>&postcomment=images/1.gif&type=2" ><img src="images/1.gif"></a>
	   
	</div>
    
	<span id="show-cmt1">
 <?php
	if(mysqli_num_rows($q) > 0)
	{
		echo '<a href="javascript: void(0)" class="like" id="like'.$row['messages_id'].'" title="Unlike" rel="Unlike">Unlike</a>';
	} 

	else 
	{ 
		echo '<a href="javascript: void(0)" class="like" id="like'.$row['messages_id'].'" title="Like" rel="Like">Like</a>';
	}
	
?>
</span>

	<span  id="show-cmt1" class="show-cmt">
    <!--<a href='#' class='commentopen' id='<?php echo $row['messages_id'];?>' title='Comment'>Comment </a>-->
<a href="" id="<?php echo $row['messages_id'];?>" class="commentopen">Comment</a>
</span>

<span id="show-cmt1" class="show-cmt" style="width:auto;float: left;width: 93px;">
<a href="" id="<?php echo $row['messages_id'];?>" class="flagopen">Flag this Status</a>

</span>
</div>

</div><!--End sttext div	--> 
</div><!--End stbody div	-->

<?php
		}}
 
?>
