<?php
	ob_start();
	session_start();
	require_once('config.php');
	if(!isset($_SESSION['SESS_MEMBER_ID']))
	{
		header("location: ".$base_url."index.php");
		exit();
	}
	$session_member_id = $_SESSION['SESS_MEMBER_ID'];
	include 'includes/time_stamp.php';
	
	$msql = mysqli_query($con, "select username,profImage from members where member_id = '$session_member_id'");
	$mres = mysqli_fetch_array($msql);
	
	$video_id = $_REQUEST['video_id']; 
	$group_id = $_REQUEST['group_id'];

	$pvsql = mysqli_query($con, "select msg.video,url,msg.messages,msg.url_title,msg.date_created,msg.messages_id,msg.view_count,m.member_id,msg.type 
						from groups_wall msg left join members m on m.member_id = msg.member_id 
						where msg.messages_id = '$video_id' ");
$mrow = mysqli_fetch_array($pvsql);
$msg_id = $mrow['messages_id'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<title>Videos</title>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="css/wall.css"/>
<link rel="stylesheet" type="text/css" href="css/group.css"/>
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="stylesheet" type="text/css" href="css/youtube.css"/>
<link rel="stylesheet" type="text/css" href="css/jquery-ui.css"/>
<link rel="icon" href="images/favicon.ico" type="image" />
<link rel="shortcut icon" href="images/favicon.ico" type="image" />
<link rel="stylesheet" href="<?php echo $base_url;?>assets/chosen-jquery/chosen.css">
<link rel="stylesheet"  type="text/css" href="<?php echo $base_url;?>css/token-input.css"/>
<link rel="stylesheet"  type="text/css" href="<?php echo $base_url;?>css/token-input-facebook.css"/>
<link rel="stylesheet"  type="text/css" href="<?php echo $base_url;?>css/token-input-mac.css"/>
<script src="js/jquery.min.js"></script>
<script src="js/groups.js"></script>

<script src="js/jquery.livequery.js" type="text/javascript"></script>
<script src="js/jquery.oembed.js"></script>
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui.js"></script>

<script type="text/javascript" src="js/ibox.js"></script>
<script type="text/javascript" src="js/autocomplete.js"></script>

<script type="text/javascript" src="<?php echo $base_url;?>js/jquery.tokeninput.js"></script>
<!-- player skin -->
   <link rel="stylesheet" type="text/css" href="flowplayer/skin/minimalist.css">
   <!-- include flowplayer -->
   <script type="text/javascript" src="flowplayer/flowplayer.min.js"></script>


<script type="text/javascript">
$(function() {
    $(".cancel_custom").click(function() {
	$("#popup").hide();
	});
	
	 $(".cancel_share").click(function() {
	$("#share_popup").hide();
	$(".share_body").children('div').remove();
	});
});

</script>
 <script type="text/javascript">
function showHide() 
{
				
   if(document.getElementById("privacy").selectedIndex == 1) 
   {
	    document.getElementById("mvm").style.display = "block"; // This line makes the DIV visible
		document.getElementById("mvm1").style.display = "none";
	   	document.getElementById("mvm2").style.display = "none";
   }
   else
   {
	   document.getElementById("mvm").style.display = "none";	   
   } 
   if(document.getElementById("privacy").selectedIndex == 2)
   {            
        document.getElementById("mvm1").style.display = "block";
		document.getElementById("mvm").style.display = "none"; 
		document.getElementById("mvm2").style.display = "none"; 
   }
   else
   {
	   document.getElementById("mvm1").style.display = "none";	   
   }
   if(document.getElementById("privacy").selectedIndex == 3)
   {            
        document.getElementById("mvm2").style.display = "block";
		document.getElementById("mvm1").style.display = "none"; 
		document.getElementById("mvm").style.display = "none"; 
   }
   else
   {
	   document.getElementById("mvm2").style.display = "none";
	   	   
   }
   
}
</script>
<style type="text/css">
#share_popup{
	width: 100%;
	height: 100%;
	position: fixed;
	top: 0;	
	background-color: rgba(0,0,0,0.7);
	color:#fff;
	z-index:2;
}
</style>
</head>
 
<body>
<div id="wrapper">
<?php 
include('includes/header.php');

?>
<div id="mainbody">

   
<div class="column_left_video">

 <div id="submenushead">
   <ul class="submenu">
    <li><input type="button" name="add_video" class="" value="Group videos" 
    onclick="window.open('group_videos.php?group_id=<?php echo $group_id;?>','_self');return false;" style="font-size:14px;" /></li>
   
	</ul>
   </div>
    <?php	
$view_count = $mrow['view_count'];
$view_count = $view_count + 1;
$musql = "update groups_wall set view_count = '$view_count' where messages_id = '$msg_id'";
$mures = mysqli_query($con, $musql) or die(mysqli_error($con));
$time = $mrow['date_created'];

if($mrow['type'] == 2)
{
?>
        
 <div class="flowplayer" data-swf="flowplayer/flowplayer.swf" data-ratio="0.4167">
 <video autoplay="autoplay" height="390">         
 <source type="video/mp4" src="<?php echo $mrow['messages'];?>">
 
      </video>
   </div>
 <?php } 
 if($mrow['type'] == 3)
 {
 
  if (preg_match('![?&]{1}v=([^&]+)!', $mrow['messages'] . '&', $m))
	$video_id = $m[1]; 
	$url = "http://gdata.youtube.com/feeds/api/videos/".$video_id;
	$doc = new DOMDocument;
	$doc->load($url);
	$title = $doc->getElementsByTagName("title")->item(0)->nodeValue;
	?>
       
    <embed src="http://www.youtube.com/v/<?php echo $video_id ?>&hl=en&fs=1&hd=1&showinfo=0&rel=0" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="80%" height="390" wmode="transparent"></embed>

  <?php } ?> 
<div class="video_Content">
<h3 class="video_title"><?php echo $mrow['url_title'];?></h3>
<div class="video_data">
<span class="view_count"><?php echo $mrow['view_count'];?> views</span>
<span class="content_item_time"><?php echo time_stamp($time);?></span>
<br />
<?php 

$sql = mysqli_query($con, "SELECT * FROM groups_wall_like WHERE remarks='". $mrow['messages_id'] ."'");
$like_count = mysqli_num_rows($sql);

if($like_count > 0) 
{ 
$query=mysqli_query($con, "SELECT m.username,m.member_id FROM bleh b, members m WHERE m.member_id=b.member_id AND b.remarks='".$mrow['messages_id']."' LIMIT 3");
$like = mysqli_num_rows($query);
?>
<div class="commentPanel">
<div class='likeUsers' id="likes<?php echo $mrow['messages_id']; ?>">
<?php
while($row1=mysqli_fetch_array($query))
{
$like_uid=$row1['member_id']; 
$likeusername=$row1['username']; 
if($like_uid==$mrow['member_id'])
{
echo '<span id="you'.$mrow['messages_id'].'"><a href="'.$likeusername.'">You </a></span>';
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
echo '<div class="likeUsers" id="elikes'.$mrow['messages_id'].'"></div>';
} 

?>

</div>
<div class="comment-menu">
   
	<span id="show-cmt1">
 <?php
 $q = mysqli_query($con, "SELECT * FROM groups_wall_like WHERE member_id='". $_SESSION['SESS_MEMBER_ID'] ."' and remarks='".$mrow['messages_id']."' ");
	if(mysqli_num_rows($q) > 0)
	{
		echo '<a href="javascript: void(0)" class="like" id="like'.$mrow['messages_id'].'" title="Unlike" rel="Unlike">Unlike</a>';
	} 

	else 
	{ 
		echo '<a href="javascript: void(0)" class="like" id="like'.$mrow['messages_id'].'" title="Like" rel="Like">Like</a>';
	}
	
?>
</span>

	<span  id="show-cmt1" class="show-cmt">
    <!--<a href='#' class='commentopen' id='<?php echo $mrow['messages_id'];?>' title='Comment'>Comment </a>-->
<a href="javascript:void(0)" id="<?php echo $mrow['messages_id'];?>" class="commentopen">Comment</a>
</span>
<span>
<div id="social-bookmarks">
<!--<a href="javascript:;" onclick="ai2display_bkmk(this, 'bkmk', '', '');">-->
<a href="javascript:void(0)" rowtype="<?php echo $mrow['type'];?>" class="share_open" id="<?php echo $mrow['messages_id'];?>" title="Share" onClick="show_share(<?php echo $mrow['messages_id'];?>)">
<span style="font-size: 1.0em;float: left;width: 53px;cursor: pointer;" class="share" >Share</span></a>
</div>
</span>

<span id="show-cmt1" class="show-cmt" style="width:auto;float: left;width: 93px;">
<a href="javascript:void(0)" id="<?php echo $mrow['messages_id'];?>" class="flagopen">Flag this Status</a>

</span>
</div>
<div class="commentupdate" style="width:100%; height:120px;" id='commentbox<?php echo $mrow['messages_id'];?>'>
<div class="stcommentimg">
<img src="<?php echo $mres['profImage'];?>" class='small_face'/>
</div>

<div class="video-commenttext">
<form method="post" action="">
<textarea name="comment" class="comment-text" maxlength="200"  id="ctextarea<?php echo $mrow['messages_id'];?>"></textarea>
<br />
<input type="submit"  value=" Comment "  id="<?php echo $mrow['messages_id'];?>" class="button" style="float:right; margin-top:10px;"/>
</form>
</div>
</div><!--End commentupdate div	--> 

<div class="commentcontainer" style="width:100%;" id="commentload<?php echo $mrow['messages_id'];?>">
<?php
$comment  = mysqli_query($con, "SELECT * FROM groups_wall_comment p,members m  
						WHERE p.post_member_id=m.member_id and p.msg_id = ". $mrow['messages_id'] ." 
						ORDER BY p.comment_id DESC limit 0,4") or die(mysqli_error($con));
while($row1 = mysqli_fetch_assoc($comment))
{
?>
<div class="stcommentbody" style="width:99%;" id="stcommentbody<?php echo $row1['comment_id']; ?>">
<div class="stcommentimg">
<a href="member_profile.php?member_id=<?php echo $mrow['member_id'];?>"><img src="<?php echo $row1['profImage']; ?>" class='small_face'/></a>
</div> 
<div class="video-commenttext">
<?php 
if($_SESSION['SESS_MEMBER_ID'] == $row1['member_id'])
{
?>
<a class="stcommentdelete" href="#" id='<?php echo $row1['comment_id']; ?>' title='Delete Comment'>X</a>
<?php } ?>
<a href="member_profile.php?member_id=<?php echo $mrow['member_id'];?>"><b><?php echo $row1['username']; ?></b> </a>
<?php 
if($row1['type']==1) echo $row1['content'];
if($row1['type']==2) echo '<img src="'.$row1["content"].'" >';
?>
<div class="stcommenttime"><?php time_stamp($row1['date_created']); ?>
<span style="padding-left:5px;">
<?php
$sql = mysqli_query($con, "SELECT * FROM groups_wall_comment_like WHERE comment_id='". $row1['comment_id'] ."'");
$comment_like_count = mysqli_num_rows($sql);

if($comment_like_count > 0) 
{ 
$query1=mysqli_query($con, "SELECT m.username,m.member_id FROM groups_wall_comment_like c, members m WHERE m.member_id=c.member_id 
AND c.comment_id='".$row1['comment_id']."' LIMIT 3");
$like = mysqli_num_rows($query1);
?>
<div class='likeUsers' id="likes<?php echo $row1['comment_id']; ?>">
<?php
while($comment_like_res=mysqli_fetch_array($query1))
{
$like_uid=$comment_like_res['member_id']; 
$likeusername=$comment_like_res['username']; 
if($like_uid==$mrow['member_id'])
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
$comment_like = mysqli_query($con, "select * from groups_wall_comment_like where comment_id = '".$row1['comment_id']."' and member_id = '".$session_member_id."'");
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
$query12  = mysqli_query($con, "SELECT * FROM groups_wall_comment_reply WHERE comment_id=" . $row1['comment_id'] . " ORDER BY reply_id DESC");
$records1 = mysqli_num_rows($query12);
$p = mysqli_query($con, "SELECT * FROM groups_wall_comment_reply WHERE comment_id=" . $row1['comment_id'] . " ORDER BY reply_id DESC limit 2,$records1");
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
$reply_sql  = mysqli_query($con, "SELECT * FROM groups_wall_comment_reply c,members m WHERE c.member_id = m.member_id and comment_id=" . $row1['comment_id'] . " ORDER BY reply_id DESC limit 0,2");

while($reply_res = mysqli_fetch_assoc($reply_sql))
{
?>
<div class="streplybody" style="width:100%;" id="streplybody<?php echo $reply_res['reply_id']; ?>">
<div class="stcommentimg">
<a href="member_profile.php?member_id=<?php echo $mrow['member_id'];?>"><img src="<?php echo $reply_res['profImage']; ?>" class='small_face'/></a>
</div>
<div class="video-commenttext">
 <?php 
if($_SESSION['SESS_MEMBER_ID'] == $reply_res['member_id'])
{
?>
<a class="streplydelete" href="#" id='<?php echo $reply_res['reply_id']; ?>' title='Delete Comment'>X</a>
<?php } ?>
<a href="member_profile.php?member_id=<?php echo $mrow['member_id'];?>"><b><?php echo $reply_res['username']; ?></b></a>
<?php 
echo $reply_res['content'];
?>
<div class="streplytime"><?php time_stamp($reply_res['date_created']); ?></div>
</div><!--End streplytext div-->
</div><!--End streplybody div-->
<?php } ?>
<!--Start replyupdate -->
<div class="replyupdate" style='display:none; width:100%;' id='replybox<?php echo $row1['comment_id'];?>'>
<div class="streplyimg">
<img src="<?php echo $mres['profImage'];?>" class='small_face'/>
</div>

<div class="video-commenttext" >
<form method="post" action="">
<textarea name="reply" class="comment-text" maxlength="200"  id="rtextarea<?php echo $row1['comment_id'];?>"></textarea>
<br />
<input type="submit"  value=" reply "  id="<?php echo $row1['comment_id'];?>" class="reply_button"/>
<input type="button"  value=" Cancel "  id="<?php echo $mrow['messages_id'];?>" onclick="closereply('replybox<?php echo $row1['comment_id'];?>')" class="cancel"/>
</form>
</div>
</div><!--End replyupdate div	--> 
</div><!--End replycontainer div-->
</div>
<?php } 

?>

</div><!--End commentcontainer div	--> 
<div class="commentupdate" style='display:none; width:99%;' id='reportbox<?php echo $mrow['messages_id'];?>'>
<div class="stcommentimg">
<img src="<?php echo $res['profImage'];?>" class='small_face'/>
</div>

<div class="video-commenttext" >
<form method="post" action="">
<textarea name="comment" class="comment-text" maxlength="200"  id="rptextarea<?php echo $mrow['messages_id'];?>" placeholder="Flag this status.."></textarea>
<br />
<input type="submit"  value=" Report "  id="<?php echo $mrow['messages_id'];?>" class="report"/>
<input type="button"  value=" Cancel "  id="<?php echo $mrow['messages_id'];?>" onclick="canclose('reportbox<?php echo $mrow['messages_id'];?>')" class="cancel"/>
</form>
</div>
</div><!--End commentupdate div	--> 
</div>
</div><!--End column_left_video div-->

<div class="column_right_video">
<ul class="video_list">
<?php 
$vsql = mysqli_query($con, "select msg.video,msg.url,msg.messages,msg.url_title,msg.date_created,msg.messages_id,msg.view_count,m.username,msg.video_id
						from groups_wall msg join members m on msg.member_id = m.member_id
						 where msg.member_id = '$session_member_id' and msg.type = 2 or msg.type = 3 and msg.video_id != '$video_id'
						 limit 10") or die(mysqli_error($con));
while($vres = mysqli_fetch_array($vsql))
{
	$time = $vres['date_created'];
?>

<li class="video_list_item">
<a href="view_video.php?video_id=<?php echo $vres['video_id'];?>">
<span class="video_thumb">
<img src="images/videos_pl.png" width="120" height="75" />
</span>
<span class="title">
<?php echo $vres['url_title']?>
</span>
<span class="stat attribution">by <?php echo $vres['username']?></span>
<span class="stat view_count"><?php echo $vres['view_count']?> views</span>
</a>
</li>
<?php } ?>
</ul>
</div><!--End column_left_video div-->
</div><!--End mainbody div-->

<?php include 'includes/footer.php';?>
</div><!--End wrapper div-->

<?php include_once 'share.php';?>


</div>
</body>
</html>