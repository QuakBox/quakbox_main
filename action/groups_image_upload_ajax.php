	<?php ob_start();
session_start();
//error_reporting(0);
if(isset($_SESSION['lang']))
	{	
		include('../common.php');
	}
	else
	{
		include('../en.php');
		
	}
include('../config.php');
include_once '../includes/time_stamp.php';
include_once '../includes/tolink.php';

$member_id = $_POST['member_id'];
$member_id	 = 	f($member_id, 'strip');
$member_id	 = 	f($member_id, 'escapeAll');
$member_id   = mysqli_real_escape_string($con, $member_id);

$upload_value = $_POST['uploads'];
$upload_value	 = 	f($upload_value, 'strip');
$upload_value	 = 	f($upload_value, 'escapeAll');
$upload_value   = mysqli_real_escape_string($con, $upload_value);

$country = $_POST['country'];
$country	 = 	f($country, 'strip');
$country	 = 	f($country, 'escapeAll');
$country   = mysqli_real_escape_string($con, $country);

$privacy = $_POST['privacy'];
$privacy	 = 	f($privacy, 'strip');
$privacy	 = 	f($privacy, 'escapeAll');
$privacy   = mysqli_real_escape_string($con, $privacy);

$time = time();
if($upload_value != NULL){	
//$uploads = substr($upload_value, 0, -1);
//$uploads_n = explode(",",$uploads);

$upsql = mysqli_query($con, "SELECT image_name FROM user_uploads WHERE upload_id = '$upload_value'");
$upres = mysqli_fetch_array($upsql);
$upload_image = 'uploads/'.$upres['image_name'];
$file_type='image/jpeg';

$share_member_id = $_POST['share_member_id'];
$unshare_member_id = $_POST['unshare_member_id'];

$member_sql = mysqli_query($con, "select * from members where username='".$share_member_id."'");
$mem_res = mysqli_fetch_array($member_sql);
	
$member_sql1 = mysqli_query($con, "select * from members where username='".$unshare_member_id."'");
$mem_res1 = mysqli_fetch_array($member_sql1);

$sql = mysqli_query($con, "select * from geo_country where country_title='".$country."'") or die(mysqli_error($con));
$res = mysqli_fetch_array($sql);
$cntid=$res['country_id'];

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

/*
if($country == '')
{
	$content_id = $member_id;
}
else
{
	$content_id = 0;
}*/
$member = mysqli_query($con, "select * from members where member_id = '$member_id'");
$member_res = mysqli_fetch_array($member);

mysqli_query($con, "INSERT INTO message (member_id,content_id,messages,country_flag,type,wall_privacy,share_member_id,unshare_member_id,date_created)
VALUES('$member_id','$content_id','".$upload_image."','$country',1,'".$privacy."','".$share_member_id."','".$unshare_member_id."',".strtotime(date("Y-m-d H:i:s")).")") or die(mysqli_error($con));
$message_id=mysqli_insert_id($con);			
			
			
			 $checkalbum="Select * from user_album where album_user_id = '".$member_id."' and album_name = '".$country."'";
			$querry=mysqli_query($con, $checkalbum) or die(mysqli_error($con));
			
			//$rowscheck=mysqli_num_rows($checkalbum);
			$album_id=0;
			
			if(mysqli_num_rows($querry) >0)
			{	
				while($row1=mysqli_fetch_array($querry))
				{
					$album_id=$row1['album_id']; 
				}
				
				/*$insertIntoAlbum="Insert into upload_data (USER_CODE,FILE_NAME,date_created,album_id,msg_id) VALUES  			 				('$member_id','$upload_image',$time,'$album_id','$message_id') ";*/
				
				$insertIntoAlbum="Insert into upload_data (USER_CODE,FILE_NAME,date_created,album_id,msg_id,country_id) VALUES  			 				('$member_id','$upload_image',$time,'$album_id','$message_id','$cntid') ";
				mysqli_query($con, $insertIntoAlbum) or die(mysqli_error($con));
				$photo_id = mysqli_insert_id($con);
			}
			else
			{
				
				$insertAlbumDetails="INSERT into user_album (album_user_id,album_name,type,country_id) VALUES('".$member_id."','".$country."',1,'$cntid');";
				//$insertAlbumDetails="INSERT into user_album (album_user_id,album_name) VALUES('".$member_id."','".$country."');";
				mysqli_query($con, $insertAlbumDetails) or die(mysqli_error($con)) ;
				$album_id=mysqli_insert_id($con);
				/*$insertIntoAlbum="Insert into upload_data (USER_CODE,FILE_NAME,date_created,album_id,msg_id) VALUES 		 				('$member_id','$upload_image','$time','$album_id','$message_id') ";*/
				
				$insertIntoAlbum="Insert into upload_data (USER_CODE,FILE_NAME,date_created,album_id,msg_id,country_id) VALUES 		 				('$member_id','$upload_image','$time','$album_id','$message_id','$cntid') ";
				mysqli_query($con, $insertIntoAlbum) or die(mysqli_error($con));
				$photo_id = mysqli_insert_id($con);
			}		

	$musql = "Update message set msg_album_id=".$album_id.", photo_id = '$photo_id' where messages_id=".$message_id."";
	mysqli_query($con, $musql) or die(mysqli_error($con));

$sql = mysqli_query($con, "select * from message msg,members m where msg.member_id=m.member_id and country_flag='$country' order by messages_id desc");
$row = mysqli_fetch_array($sql);
if ($row)
{
	$time = $row['date_created'];
	
?>

<div class="stbody" id="stbody<?php echo $row['messages_id'];?>">

<div class="stimg">
<?php if($_SESSION['SESS_MEMBER_ID'] == $row['member_id'])
{
   
?>



<a href="<?php echo $base_url.'i/'.$row['username'];?>"><img src="<?php echo $row['profImage'];?>" class='big_face' original-title="<?php echo $row['username'];?>"/></a> 

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
<a class="stdelete" href="#" id="<?php echo $row['messages_id'];?>" original-title="Delete update" title="<?php echo $lang['Delete update'];?>">"></a>
<?php }
if($row['share'] != 1)
	{
if($_SESSION['SESS_MEMBER_ID'] == $row['member_id'])
{

?>


<a href="<?php echo $base_url.'i/'.$row['username'];?>"><b><?php echo $row['username'];?></b></a> 

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
echo "<a href='".$base_url.$smres['username']."'><b>".$row['username']."</b></a>" ;	

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
<?php } 
}
?>

<div style="margin:5px 0px;">
 <?php if($row['type']==0)
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
	list($width, $height) = getimagesize('../'.$row['messages']);
	if($width > 600)
	{
	?>
    <img src="<?php echo $row['messages'];?>" height="250" width="400" style="height:auto;" />
    <?php } 
	else if($width <= 600)
	{
	?>
	<img src="<?php echo $row['messages'];?>" style="height:auto;" width="400"/>
	<?php } 
	else
	{
	?>
    <img src="<?php echo $row['messages'];?>" style="height:auto;"/>
    <?php } ?>
</a>

<?php } if($row['type']==2){?>
 <div class="flowplayer" data-swf="flowplayer/flowplayer.swf" style="height:225px !important; width:350px;" data-ratio="0.4167">
 <video height="225" width="350">         
 <source type="video/mp4" src="<?php echo $row['messages'];?>">
 
      </video>
   </div>
<?php }if($row['type']==3){
if (preg_match('![?&]{1}v=([^&]+)!', $row['messages'] . '&', $m))
	$video_id = $m[1]; 
	$url = "http://gdata.youtube.com/feeds/api/videos/".$video_id;
	$doc = new DOMDocument;
	$doc->load($url);
	$title = $doc->getElementsByTagName("title")->item(0)->nodeValue;
	?>
    <div>
    <span style="margin-bottom:5px;"> <?php $lang['title']; ?> : <strong> <?php echo $title; ?> </strong> </span>
    </div>
    <embed src="http://www.youtube.com/v/<?php echo $video_id ?>&hl=en&fs=1&hd=1&showinfo=0&rel=0" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="350" height="225" wmode="transparent"></embed>
<?php } ?>
</div>

<div><span class="sttime" title="<?php echo date($time);?>"><?php echo time_stamp($time);?></span>
<br />
<!-- LIke users display panel -->
<?php 

$sql = mysqli_query($con, "SELECT * FROM groups_wall_like WHERE remarks='". $row['messages_id'] ."'");
$like_count = mysqli_num_rows($sql);

if($like_count > 0) 
{ 
$query=mysqli_query($con, "SELECT m.username,m.member_id FROM bleh b, members m WHERE m.member_id=b.member_id AND b.remarks='".$row['messages_id']."' LIMIT 3");
$like = mysqli_num_rows($query);
?>
<div class="commentPanel">
<!-- LIke users display panel -->
<div class='likeUsers' id="likes<?php echo $row['messages_id']; ?>">
<?php
while($row1 = mysqli_fetch_array($query))
{
$like_uid = $row1['member_id'];
$likeusername = $row1['username'];
$newlike_count = $like_count - 3; 
if($like_uid == $member_id)
{
	if($like_count > 1)
	{
		echo '<span id="you'.$row['messages_id'].'">'.$lang['You and'].' </span>';
	}
	else
	{
		echo '<span id="you'.$row['messages_id'].'">'.$lang['You'].'</span>';
	}
}
else
{ 
echo '<a id="likeuser'.$row['messages_id'].'" href="'.$likeusername.'">'.$likeusername.' </a>';
}  
}
if($like_count > 3)
{
echo '<span id="likeuser'.$row['messages_id'].'">'.$likeusername.' </span>'.$lang['others like this'];
}
else
{
	echo $lang['like this'] ;
}
?> 
</div>
</div>
<?php 
}
else 
{ 
	echo '<div class="likeUsers" id="elikes'.$row['messages_id'].'"></div>';
} 

?>
<br />
<!--Dislike users display panel-->

<!--
<?php 

$sql1 = mysqli_query("SELECT * FROM groups_wall_dislike WHERE remarks='". $row['messages_id'] ."'");
$dislike_count = mysqli_num_rows($sql1);

if($dislike_count > 0) 
{ 
$query1=mysqli_query("SELECT m.username,m.member_id FROM blehdis b, members m WHERE m.member_id=b.member_id AND b.remarks='".$row['messages_id']."' LIMIT 3");
$dislike = mysqli_num_rows($query1);
?>
<div class="commentPanel">
<!--Like users display panel 
<div class='dislikeUsers' id="dislikes<?php echo $row['messages_id']; ?>">
<?php
while($row12 = mysqli_fetch_array($query1))
{
$dislike_uid = $row12['member_id'];
$dislikeusername = $row12['username'];
$disnewlike_count = $dislike_count - 3; 
if($dislike_uid == $member_id)
{
	if($dislike_count > 1)
	{
echo '<span id="you'.$row['messages_id'].'">'.$lang['You and'].' </span>';
	}
	else
	{
		echo '<span id="you'.$row['messages_id'].'">'.$lang['You'].'</span>';
	}
}
else
{ 
echo '<a href="'.$dislikeusername.'">'.$dislikeusername.' </a>';
}  
}
if($dislike_count > 3)
{
echo $lang['and'].''.$disnewlike_count.''.$lang['other friends dislike this'];
}
else
{
	echo $lang[' Dislike this'];
}
?> 
</div></div>
<?php 
}
else 
{ 
	echo '<div class="dislikeUsers" id="diselikes'.$row['messages_id'].'"></div>';
} 

?>-->

</div> <!-- End of timestamp div -->
<?php
$query1  = mysqli_query($con, "SELECT * FROM groups_wall_comment WHERE msg_id=" . $row['messages_id'] . " ORDER BY comment_id DESC");
$records = mysqli_num_rows($query1);
$s = mysqli_query($con, "SELECT * FROM groups_wall_comment WHERE msg_id=" . $row['messages_id'] . " ORDER BY comment_id DESC limit 4,$records");
$y = mysqli_num_rows($s);
if ($records > 4)
{
	$collapsed = true;?>
    <input type="hidden" value="<?php echo $records?>" id="totals-<?php  echo $row['messages_id'];?>" />
	<div class="commentPanel" id="collapsed-<?php  echo $row['messages_id'];?>" align="left">
	<img src="images/cicon.png" style="float:left;" alt="" />
	<a href="javascript: void(0)" class="ViewComments" id="<?php echo $row['messages_id'];?>">
	<?php echo $lang['View'];?><?php echo $y;?> <?php echo $lang['more comments'];?> 
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
$comment  = mysqli_query($con, "SELECT * FROM groups_wall_comment p,members m  WHERE p.post_member_id=m.member_id and p.msg_id=" . $row['messages_id'] . " ORDER BY comment_id DESC limit 0,4");
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
$sql = mysqli_query($con, "SELECT * FROM groups_wall_comment_like WHERE comment_id='". $row1['comment_id'] ."'");
$comment_like_count = mysqli_num_rows($sql);

$comment_like_query1 = mysqli_query($con, "SELECT m.username,m.member_id FROM groups_wall_comment_like c, members m WHERE m.member_id=c.member_id 
AND c.comment_id='".$row1['comment_id']."' AND c.member_id='".$_SESSION['SESS_MEMBER_ID']."' ");
$comment_like_res1 = mysqli_num_rows($comment_like_query1);
if($comment_like_res1==1)
{
$comment_like_query = mysqli_query($con, "SELECT m.username,m.member_id FROM groups_wall_comment_like c, members m WHERE m.member_id=c.member_id 
AND c.comment_id='".$row1['comment_id']."' AND c.member_id!='".$_SESSION['SESS_MEMBER_ID']."' LIMIT 2");
$clike_count = mysqli_num_rows($comment_like_query);
$new_clike_count=$comment_like_count-2; 
}
else
{
$comment_like_query = mysqli_query($con, "SELECT m.username,m.member_id FROM groups_wall_comment_like c, members m WHERE m.member_id=c.member_id 
AND c.comment_id='".$row1['comment_id']."' LIMIT 3");
$clike_count = mysqli_num_rows($comment_like_query);
$new_clike_count=$comment_like_count-3; 
}

?>
<div class="clike" id="clike<?php echo $row1['comment_id'];?>" style="display:<?php if($comment_like_count <= 0) { echo 'none'; } else { echo 'block'; }?>">
<?php 

if($comment_like_res1==1)
{?><span id="you<?php echo $row1['comment_id'];?>"><a href="#"><?php echo $lang['You'];?> </a><?php if($comment_like_count>1)
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
 <?php echo $lang['and'];?><span id="like_count<?php echo $row1['comment_id'];?>" class="numcount"><?php echo $new_clike_count;?></span> <?php echo $lang['others'];?><?php } ?> <?php echo $lang['like this'];?>.</div>  
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
$cdquery = "SELECT * FROM groups_wall_comment_dislike WHERE comment_id='". $row1['comment_id'] ."'";
$cdsql  = mysqli_query($con, $cdquery) or die(mysqli_error($con));
$comment_dislike_count = mysqli_num_rows($cdsql);

$cdquery1 = mysqli_query($con, "SELECT m.username,m.member_id FROM groups_wall_comment_dislike c, members m WHERE m.member_id=c.member_id 
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
$comment_like = mysqli_query($con, "select * from groups_wall_comment_like where comment_id = '".$row1['comment_id']."' and member_id = '".$member_id."'");
if(mysqli_num_rows($comment_like) > 0)
{
	echo '<a href="javascript: void(0)" class="comment_like" id="comment_like'.$row1['comment_id'].'" msg_id = '.$row['messages_id'].' title="'.$lang['Unlike'].'" rel="Unlike">'.$lang['Unlike'].'</a>';
} 
else 
{ 
	echo '<a href="javascript: void(0)" class="comment_like" id="comment_like'.$row1['comment_id'].'" msg_id = '.$row['messages_id'].' title="'.$lang['Like'].'" rel="Like">'.$lang['Like'].'</a>';
}
?>
</span>
<!-- End of like button -->
<!-- Dislike button -->
<span style="top:2px; padding-left:5px;">
<?php
$cdquery1 = "SELECT * FROM groups_wall_comment_dislike WHERE comment_id='". $row1['comment_id'] ."' and member_id = '".$member_id."'";
$cdsql1  = mysqli_query($con, $cdquery1) or die(mysqli_error($con));
$comment_dislike_count1 = mysqli_num_rows($cdsql1);
if($comment_dislike_count1 > 0) {
echo '<a href="javascript: void(0)" class="comment_dislike" id="comment_dislike'.$row1['comment_id'].'" title="'.$lang['DisLike'].'" rel="disLike">'.$lang['DisLike'].'</a>';
} else {
echo '<a href="javascript: void(0)" class="comment_dislike" id="comment_dislike'.$row1['comment_id'].'" title="'.$lang['UnDisLike'].'" rel="disLike">'.$lang['UnDisLike'].'</a>';
}
?>
</span> 
<!-- End of dislike  button -->
<!-- Reply Button -->
<span style="top:2px; margin-left:5px;">
<a href="" id="<?php echo $row1['comment_id'];?>" class="replyopen">Reply</a>
</span>
<!-- <?php if($row1['type']==1){?><span style="top:2px; left:3px;"><a class="translatebutton" onclick="translateSourceTarget(<?php echo $row1['comment_id'];?>);" href="javascript:void(0)" >Translate </a> </span><?php } ?> -->

<?php if($row1['type']==1)
{ ?>
<span style="top:2px; margin-left:3px;" > <a class="translateButton" href="javascript:void(0);" id="translateButton<?php echo $row1['comment_id'];?>"  ><?php echo  $lang['Translate'];?></a></span>

       
<?php 
} ?>


<!--View more reply-->
<?php
$query12  = mysqli_query($con, "SELECT * FROM groups_wall_reply WHERE comment_id=" . $row1['comment_id'] . " ORDER BY reply_id DESC");
$records1 = mysqli_num_rows($query12);
$p = mysqli_query($con, "SELECT * FROM groups_wall_reply WHERE comment_id=" . $row1['comment_id'] . " ORDER BY reply_id DESC limit 2,$records1");
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
$reply_sql  = mysqli_query($con, "SELECT * FROM groups_wall_reply c,members m WHERE c.member_id = m.member_id and comment_id=" . $row1['comment_id'] . " ORDER BY reply_id DESC limit 0,2");

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
<input type="submit" abcd="<?php echo $row1['member_id']; ?>"  title="<?php echo $row1['username']; ?>" value="    @    "  id="<?php echo $row1['comment_id'];?>" class="reply_button"/>
<input type="button"  value=" <?php echo $lang["Cancel"];?> "  id="<?php echo $row['messages_id'];?>" onclick="closereply('replybox<?php echo $row1['comment_id'];?>')" class="cancel"/>
</form>
</div>
</div><!--End replyupdate div	--> 
</div><!--End replycontainer div-->
</div>
<?php } 
$q = mysqli_query($con, "SELECT * FROM groups_wall_like WHERE member_id='". $_SESSION['SESS_MEMBER_ID'] ."' and remarks='".$row['messages_id']."' ");
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
<input type="submit"  value=" <?php echo $lang['Comment '];?> "  id="<?php echo $row['messages_id'];?>" class="button"/>
<input type="button"  value="<?php echo $lang["Cancel"];?>"  id="<?php echo $row['messages_id'];?>" onclick="cancelclose('commentbox<?php echo $row['messages_id'];?>')" class="cancel"/>

</form>
</div>
</div><!--End commentupdate div	--> 
<div class="commentupdate" style='display:none' id='reportbox<?php echo $row['messages_id'];?>'>
<div class="stcommentimg">
<img src="<?php echo $res['profImage'];?>" class='small_face'/>
</div>

<div class="stcommenttext" >
<form method="post" action="">
<textarea name="comment" class="comment" maxlength="200"  id="rptextarea<?php echo $row['messages_id'];?>" placeholder="<?php echo $lang['Flag this status'];?>.."></textarea>
<br />
<input type="submit"  value=" <?php echo $lang['Report'];?> "  id="<?php echo $row['messages_id'];?>" class="report"/>
<input type="button"  value="<?php echo $lang["Cancel"];?> "  id="<?php echo $row['messages_id'];?>" onclick="canclose('reportbox<?php echo $row['messages_id'];?>')" class="cancel"/>
</form>
</div>
</div><!--End commentupdate div	-->
 
<div class="emot_comm">
    <div id="normal-button" class="settings-button" title="0" value="<?php echo $row['messages_id']; ?>" >
    <span style="bottom: 2px;float: left;position: relative;width: 33px;cursor: pointer;" class="">
	<img src="images/smiley.png"/>
	</span>
    </div>
	<div class="submenu12" id="<?php echo $row['messages_id']; ?>-submenu12" style="display: none; position: absolute; background:#ffffff; margin-top:15px;">
	  
	      <a href="action/groups_comment_post.php?postid=<?php echo $row['messages_id']; ?>&member_id=<?php echo $member_id; ?>&postcomment=images/1.jpg&type=2" ><img src="images/1.jpg"></a>
	    
	      <a href="action/groups_comment_post.php?postid=<?php echo $row['messages_id']; ?>&member_id=<?php echo $member_id; ?>&postcomment=images/2.jpg&type=2" ><img src="images/2.jpg"></a>
	    
	      <a href="action/groups_comment_post.php?postid=<?php echo $row['messages_id']; ?>&member_id=<?php echo $member_id; ?>&postcomment=images/3.jpg&type=2" ><img src="images/3.jpg"></a>
	    
	      <a href="action/groups_comment_post.php?postid=<?php echo $row['messages_id']; ?>&member_id=<?php echo $member_id; ?>&postcomment=images/4.jpg&type=2" ><img src="images/4.jpg"></a>
	      
	      <a href="action/groups_comment_post.php?postid=<?php echo $row['messages_id']; ?>&member_id=<?php echo $member_id; ?>&postcomment=images/5.jpg&type=2" ><img src="images/5.jpg"></a>
	    
	     <a href="action/groups_comment_post.php?postid=<?php echo $row['messages_id']; ?>&member_id=<?php echo $member_id; ?>&postcomment=images/6.jpg&type=2" ><img src="images/6.jpg"></a>
	    
	      <a href="action/groups_comment_post.php?postid=<?php echo $row['messages_id']; ?>&member_id=<?php echo $member_id; ?>&postcomment=images/1.gif&type=2" ><img src="images/1.gif"></a>
	   
	</div>
    
	<span id="show-cmt1">
 <?php
	if(mysqli_num_rows($q) > 0)
	{
		echo '<a href="javascript: void(0)" class="like" id="like'.$row['messages_id'].'" title="'.$lang['Unlike'].'" rel="Unlike">'.$lang['Unlike'].' </a>';
	} 

	else 
	{ 
		echo '<a href="javascript: void(0)" class="like" id="like'.$row['messages_id'].'" title="'.$lang['Like'].'" rel="Like">'.$lang['Like'].'</a>';
	}
	
?>
</span>



<span class="show-cmt">
<a href="javascript:void(0)" id="<?php echo $row['messages_id'];?>" class="commentopen"><?php echo $lang['Comment'];?></a>
</span>

<span class="show-cmt">
<a href="javascript:void(0)" rowtype="<?php echo $row['type'];?>" class="share_open" id="<?php echo $row['messages_id'];?>" title="<?php echo $lang['Share'];?>"><?php echo $lang['Share'];?></a>
</span>

<span class="show-cmt hidden">
<a href="javascript:void(0)" id="<?php echo $row['messages_id'];?>" class="flagopen"><?php echo $lang['Flag this Status'];?></a>
</span>
<?php if($row['type']==0)
 {
	 if(substr($row['messages'],0,4) != 'http' )
{ ?>
<span style="top:2px; left:3px;" >
<a class="posttranslateButton" href="javascript:void(0);" id="posttranslateButton<?php echo $row['messages_id'];?>"  >Translate</a>
</span>
<?php } } ?>
</div>

</div><!--End sttext div	--> 
</div><!--End stbody div	-->
  
<?php
}
}
?> 
