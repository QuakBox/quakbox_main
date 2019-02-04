<?php
session_start();
require_once('common/common.php');
?>
<head>
<title>

QuakBox

</title>

<?php include('includes/files.php');?>


</head>
<body onload="onLoad();">
<?php

$member_id=$_SESSION['SESS_MEMBER_ID'];
$mem_New_Query = "SELECT * FROM members WHERE member_id = $member_id";
$mem_New_SQL = mysqli_query($con, $mem_New_Query);
$mem_New_Result = mysqli_fetch_array($mem_New_SQL);
 $query  = "SELECT msg.messages_id,msg.share,msg.description, msg.messages, msg.date_created, msg.type, msg.wall_privacy, m.member_id,
		  msg.msg_album_id, m.active, m.username, m.profImage, msg.country_flag, u.upload_data_id,msg.share,msg.video_id
		  , msg.share_by,m.username, v.location,v.location1,v.location2, v.thumburl, v.title, v.video_id, v.description,
 			v.msg_id, v.category, v.title_color,v.title_size,v.ads,a.ads_name,
				a.location as adslocation,a.location1 as adslocation1,a.location2 as adslocation2, a.click_url,msg.share_msg
		  FROM message msg LEFT JOIN members m ON msg.member_id = m.member_id 
		  LEFT JOIN upload_data u on msg.messages_id = u.msg_id		  
		  LEFT JOIN videos v ON v.msg_id = msg.messages_id 
		  LEFT JOIN videos_ads a ON v.ads_id = a.id
		  WHERE msg.country_flag='world'		  
		  GROUP BY msg.messages_id 
		  ORDER BY date_created DESC
		  LIMIT 10";

$result = mysqli_query($con, $query) or die(mysqli_error($con));

while($row = mysqli_fetch_assoc($result))

{
?>

<?php
	
	$memb_id=$row['member_id'];
	$block=mysqli_query($con, "select * from blocklist where userid='$memb_id' and blocked_userid='$member_id' ");
	$block_count = mysqli_num_rows($block);
if($block_count==0 && $row['active']==0)
	{
	
	$wall_privacy=$row['wall_privacy'];
	$share_by1=$row['share_by'];
	$msg_id           = $row['messages_id'];
	$orimessage       = $row['messages'];
	$time             = $row['date_created']; 
	$country_flag ="world"; 
	$category = $row['category'];
	$time = $row['date_created'];
	$uploadedby = $row['member_id'];
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
	$profpic = $base_url.$row['profImage'];
	$shusername = $base_url.$row['username'];
	
?>
<script type="text/javascript"> 
$(document).ready(function(){
	var text = $('#textoembed<?php echo $msg_id;?>').val();
	
	$("#stexpand<?php echo $msg_id;?>").oembed(text,{maxWidth: 400, maxHeight: 300});
});
</script>
<textarea id="textoembed<?php echo $msg_id;?>" style="display:none"><?php 

$string = $orimessage;
$regex = '/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i';
preg_match_all($regex, $string, $matches);
$urls = $matches[0];
// go over all links
foreach($urls as $url) {
    echo $url;
}
?></textarea>	
<div class="stbody" id="stbody<?php echo $row['messages_id'];?>" data-id="<?php echo $row['messages_id'];?>" wall-type="1">
<!--start stimg div	-->
<div class="stimg">
<a href="<?php echo $base_url."i/".$row['username'];?>"><img src="<?php echo $profpic;?>" class='big_face' original-title="<?php echo $shusername ;?>"/></a> 
<a href="<?php echo $base_url."i/".$row['username'];?>"><b><?php echo $row['username'];?></b></a> 
</div>

<!--End stimg div	-->

<div class="sttext">
<?php 

if($_SESSION['SESS_MEMBER_ID'] == $row['member_id'])
{?>
 <a class="stdelete" href="#" id="<?php echo $row['messages_id'];?>" original-title="Delete update" title="<?php echo $lang['Delete update'];?>"></a>  
<?php } 
	if($row['share'] == 1)
	{
	if($_SESSION['SESS_MEMBER_ID'] == $row['member_id']){
	
	echo "<a href='".$base_url."i/".$row['username']."'><b>".$row['username']."</b></a>" ;
	} 
echo $lang['share a'];
//echo "<a href='".$base_url.$smres['username']."'><b>".$row['username']."</b></a>" ;	

if($row['type'] == 0)
{
	echo '<a href="'.$base_url.'"posts.php?id='.$row['messages_id'].'">'.$lang['status'].'</a>';
}
else if($row['type'] == 1)
{
	echo '<a href="'.$base_url.'albums.php?back_page=country_wall.php?country='.$row['country_flag'].'&member_id='.$row['member_id'].'&album_id='.$row['msg_album_id'].'&image_id='.$row['upload_data_id'].'">--> '.$lang['photo'].'</a>';
}
else
{
	echo '<a href="'.$base_url.'watch.php?video_id='.$row['video_id'].'">'.$lang['video'].'</a>';
}
?>
<div class="aboveUnitContent">
 <div class="_wk mbn">
 <span><?php echo $row['share_msg']; ?></span>
 
 </div>
 </div>
 <?php
} 
else
{
?>
<img style="margin:0px 3px;" src="images/arrow_png.jpg" /> 
<a href="<?php echo $homepage;?>"><b><?php echo strtoupper($country_flag);?></b></a>
<?php  }
?>

<div style="margin:5px 0px;" class="text_exposed_root" id="id<?php echo $row['messages_id'];?>">
 
<br />	
 <?php  if($row['type']==0)
 
 {
 $message = $row['messages'];
	  $message_count = strlen($message);
	  $message500 = substr($message,0,500);
	  $message1000 = substr($message,500);
	  if($message_count <= 500){
		?>
		<p style="display: inline;"><?php echo tolink(htmlentities($row['messages'])); ?></p>
        <?php } else {?>
        <p style="display: inline;"><?php echo tolink(htmlentities($message500)); ?></p>
        <span class="text_exposed_hide">...</span>
        <div class="text_exposed_show"><?php echo tolink(htmlentities($message1000)); ?></div>
        <span class="text_exposed_hide"> 
        <span class="text_exposed_link">
        <!--<a class="see_more_link" onclick="var parent = Parent.byClass(this, text_exposed_root); if (parent parent.getAttribute(id) == <?php //echo $row['messages_id'];?>) { CSS.addClass(parent, text_exposed); }; " href="#" role="button">See More</a>-->
        <a class="see_more_link" id="<?php echo $row['messages_id'];?>" href="#" role="button">See More</a>
        </span>
        </span>
<?php		
	}
?> 
<div tabindex="1" id="posttranslatemenu<?php echo $row['messages_id'];?>" class="posttranslatemenu" style="display:none; position:absolute;margin-left: 34%; "> <select id="postlangs<?php echo $row['messages_id'];?>" class="postlangs" onchange="selectOption(this.value, <?php echo $row['messages_id'];?>,2,'<?php 
if(isset($_SESSION['lang']))
{
echo $_SESSION['lang'];
}
else
{
 echo 'en';
 }?>')">
            <option value=""><?php echo $lang['select language'];?></option> 
            </select>
            </div> 
            
<textarea class="postsource" id="postsource<?php echo $row['messages_id']; ?>"  style="display:none;"><?php echo $row['messages']; ?></textarea>
<div class="posttarget" style="font:bold;" id="posttarget<?php echo $row['messages_id']; ?>"></div>
<?php
} 
if($row['type']==1){
?><div><?php
echo $row['description'];

?></div>
<a href="<?php echo $base_url;?>albums.php?back_page=<?php echo $homepage;?>&member_id=<?php echo $row['member_id']; ?>&album_id=<?php echo $row['msg_album_id']; ?>&image_id=<?php echo $row['upload_data_id'];?>" >
<?php
list($width, $height) = getimagesize($base_url.$row['messages']);
	
	if($width > $height)
	{
	?>
    <img src="<?php echo $base_url.$row['messages'];?>"  style="width: 400px" />
    <?php } 
	else if($width < $height)
	{
	?>
	<img src="<?php echo $base_url.$row['messages'];?>" style="height: 250px" />
	<?php } 
	else
	{
	?>
    <img src="<?php echo $base_url.$row['messages'];?>" width="<?php if($width<400)echo $width; else echo '400'?>px"  />
    <?php } ?>
</a>

<?php } if($row['type']==2){?>
<a href="<?php echo $base_url;?>watch.php?video_id=<?php echo $row['video_id'];?>" style="color:#993300;">

<h3 class="video_title"  >
<?php 
echo $row['title'];
?></h3></a>


 <div id="videoplayerid<?php echo $row['video_id'];?>"> </div>
 <?php 
 $videoid = "videoplayerid".$row['video_id'];
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
            rightClickMenu:true,
            
            share:[{
                show:true,
                facebookLink:"https://www.facebook.com/sharer/sharer.php?u="+fetch_url,
                twitterLink:"https://twitter.com/intent/tweet?source=webclient&text="+fetch_url,                
                pinterestLink:"http://pinterest.com/pin/create/bookmarklet/?media=" + pintereset,
                linkedinLink:"http://www.linkedin.com/cws/share?url="+fetch_url,
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
                id:"0",
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

    

  </script>

  <br/>
  <span class="sttime"  > <h3><?php echo $row['description']; ?></h3></span>
  
 
<?php }?>
</div>

<div id="stexpandbox">
<div id="stexpand<?php echo $msg_id;?>"></div>
</div><!--End stexpandbox div	--> 
<div><span class="sttime" title="<?php echo date($time);?>"><?php echo time_stamp($time);?></span>

<!-- LIke users display panel -->
<?php 

$post_like_sql = mysqli_query($con, "SELECT * FROM bleh WHERE remarks='". $row['messages_id'] ."'");
//echo "SELECT * FROM bleh WHERE remarks='". $row['messages_id'] ."'";
$post_like_count = mysqli_num_rows($post_like_sql);

$post_like_sql1 = mysqli_query($con, "SELECT m.active,m.username,m.member_id FROM bleh b, members m WHERE m.active != 1 AND m.member_id=b.member_id AND b.remarks='".$row['messages_id']."' AND b.member_id='".$_SESSION['SESS_MEMBER_ID']."'");
$post_like_count1 = mysqli_num_rows($post_like_sql1);

if($post_like_count1==1)
{
$post_like_sql2 = mysqli_query($con, "SELECT m.username,m.active,m.member_id FROM bleh b, members m WHERE m.active != 1 AND m.member_id=b.member_id AND b.remarks='".$row['messages_id']."' AND b.member_id!='".$_SESSION['SESS_MEMBER_ID']."' LIMIT 2");
$plike_count = mysqli_num_rows($post_like_sql2);
$new_plike_count=$post_like_count-2; 

}
else
{
$post_like_sql2 = mysqli_query($con, "SELECT m.username,m.active,m.member_id FROM bleh b, members m WHERE m.active != 1 AND m.member_id=b.member_id AND b.remarks='".$row['messages_id']."' LIMIT 3");
$plike_count = mysqli_num_rows($post_like_sql2);
$new_plike_count=$post_like_count-3; 

}
?>
<div class="commentPanel" id="likes<?php echo $row['messages_id'];?>" style="display:<?php if($post_like_count <= 0) { echo 'none'; } else { echo 'block'; }?>">
<?php 

if($post_like_count1==1)
{?><span id="you<?php echo $row['messages_id'];?>"><?php echo $lang['You'];?><?php if($post_like_count>1)
echo ','; ?> </span><?php
}
?>

<input type="hidden"  value="<?php echo $post_like_count; ?>" id="commacount<?php echo $row['messages_id'];?>" >
<?php

$i = 0;
while($post_like_res = mysqli_fetch_array($post_like_sql2)){
$i++; 	  
?>

<a href="<?php echo $base_url.$post_like_res['username'];?>" id="likeuser<?php echo $row['messages_id'];?>"><?php echo $post_like_res['username']; ?></a>
<?php if($i <> $plike_count) { echo ',';}

} 
if($post_like_count > 3){
?>
 <?php echo $lang['and'];?><a href="likes.php?id=<?php echo $row['messages_id'];?>" class="show_cmt_linkClr" data-toggle="modal" data-target="#likemodal"> <span id="plike_count<?php echo $row['messages_id'];?>" class="pnumcount"><?php echo $new_plike_count;?></span> <?php echo $lang['others'];?></a>
 <?php } ?> <?php echo $lang['like this'];?>.</div> 


<!--Dislike users display panel-->
<?php 

$sql1 = mysqli_query($con, "SELECT * FROM post_dislike WHERE msg_id='". $row['messages_id'] ."'") or die(mysqli_error($con));
$dislike_count = mysqli_num_rows($sql1);
 
$query1=mysqli_query($con, "SELECT m.username,m.active,m.member_id FROM post_dislike b, members m WHERE m.active != 1 AND m.member_id=b.member_id AND b.msg_id='".$row['messages_id']."' LIMIT 3");
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

</div>







<div class="commentcontainer" id="commentload<?php echo $row['messages_id'];?>">

<?php
$comment1234  = mysqli_query($con, "SELECT * FROM postcomment p,members m  WHERE p.post_member_id=m.member_id and p.msg_id=" . $row['messages_id'] . " ORDER BY comment_id desc limit 0,4");
echo "SELECT * FROM postcomment p,members m  WHERE p.post_member_id=m.member_id and p.msg_id=" . $row['messages_id'] . " ORDER BY comment_id desc limit 0,4";
$result_arr = array();
$loop=0;
while($row1234 = mysqli_fetch_array($comment1234))
{

    $result_arr[] = $row1234['comment_id'];
}
 $loop_count=count($result_arr);
for($loop=$loop_count-1;$loop>=0;$loop--)
{
 $result_arr[$loop];
//}

//$comment  = mysqli_query("SELECT * FROM postcomment p,members m  WHERE p.post_member_id=m.member_id and p.msg_id=" . $row['messages_id'] . " ORDER BY //comment_id  desc limit 0,4");
$comment  = mysqli_query($con, "SELECT * FROM postcomment p,members m  WHERE p.post_member_id=m.member_id and p.msg_id=" . $row['messages_id'] . " and p.comment_id='".$result_arr[$loop]."'");
echo "SELECT * FROM postcomment p,members m  WHERE p.post_member_id=m.member_id and p.msg_id=" . $row['messages_id'] . " and p.comment_id='".$result_arr[$loop]."'";
$row1 = mysqli_fetch_assoc($comment);
//while($row1 = mysqli_fetch_assoc($comment))
//{
$re_memb_id=$row1['member_id'];
	
	$block=mysqli_query($con, "select * from blocklist where userid='$re_memb_id' and blocked_userid='$member_id' ");
	$block_count = mysqli_num_rows($block);
if($block_count==0 && $row1['active']==0)
{
	
?>
<div class="stcommentbody" id="stcommentbody<?php echo $row1['comment_id']; ?>">
<div class="stcommentimg">
<a href="<?php echo $base_url.$row['username'];?>"><img src="<?php echo $base_url.$row1['profImage']; ?>" class='small_face'/></a>
</div> 
<div class="stcommenttext">
<?php 
if($_SESSION['SESS_MEMBER_ID'] == $row1['member_id'])
{
?>
<a class="stcommentdelete" href="#" id='<?php echo $row1['comment_id']; ?>' title='<?php echo $lang['Delete Comment'];?> '></a>
<?php } ?>
<a href="<?php echo $base_url.$row1['username'];?>"><b><?php echo $row1['username']; ?></b> </a>
<br />
<?php 
if($row1['type']==1){ 
	
		echo $row1['content']; ;
		

	?>
	
	<div id="translatemenu<?php echo $row1['comment_id'];?>" class="translatemenu" style="display:none; position:absolute;margin-left: 34%; "> <select id="langs<?php echo $row1['comment_id'];?>" class="langs" onchange="selectOption(this.value, <?php echo $row1['comment_id'];?>,1,'<?php 
if(isset($_SESSION['lang']))
{
echo $_SESSION['lang'];
}
else
{
 echo 'en';
 }?>')">
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

$comment_like_query1 = mysqli_query($con, "SELECT m.username,m.active,m.member_id FROM comment_like c, members m WHERE m.active != 1 AND m.member_id=c.member_id 
AND c.comment_id='".$row1['comment_id']."' AND c.member_id='".$_SESSION['SESS_MEMBER_ID']."' ");
$comment_like_res1 = mysqli_num_rows($comment_like_query1);
if($comment_like_res1==1)
{
$comment_like_query = mysqli_query($con, "SELECT m.username,m.active,m.member_id FROM comment_like c, members m WHERE m.active != 1 AND m.member_id=c.member_id 
AND c.comment_id='".$row1['comment_id']."' AND c.member_id!='".$_SESSION['SESS_MEMBER_ID']."' LIMIT 2");
$clike_count = mysqli_num_rows($comment_like_query);
$new_clike_count=$comment_like_count-2; 
}
else
{
$comment_like_query = mysqli_query($con, "SELECT m.username,m.active,m.member_id FROM comment_like c, members m WHERE m.active != 1 AND m.member_id=c.member_id 
AND c.comment_id='".$row1['comment_id']."' LIMIT 3");
$clike_count = mysqli_num_rows($comment_like_query);
$new_clike_count=$comment_like_count-3; 
}

?>
<div class="clike" id="clike<?php echo $row1['comment_id'];?>" style="display:<?php if($comment_like_count <= 0) { echo 'none'; } else { echo 'block'; }?>">
<?php 

if($comment_like_res1==1)
{?><span id="you<?php echo $row1['comment_id'];?>"><?php echo $lang['You'];?> <?php if($comment_like_count>1)
echo ','; ?> </span><?php
}

?>

<input type="hidden"  value="<?php echo $comment_like_count; ?>" id="commacount<?php echo $row1['comment_id'];?>" >
<?php

$i = 0;
while($comment_like_res = mysqli_fetch_array($comment_like_query)) {
$i++; 	  
?>

<a href="<?php echo $base_url.$comment_like_res['username']; ?>" id="likeuser<?php echo $row1['comment_id'];?>"><?php echo $comment_like_res['username']; ?></a>
<?php
	
if($i <> $clike_count) { echo ',';}
 
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

$cdquery1 = mysqli_query($con, "SELECT m.username,m.active,m.member_id FROM comment_dislike c, members m WHERE m.active != 1 AND m.member_id=c.member_id 
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
}
?>

</span>
<!-- End of like button -->
<!-- Dislike button -->
<span style="top:2px; padding-left:2px;">
<span class="mySpan_dot_class"> · </span>
<?php
$cdquery1 = "SELECT * FROM comment_dislike WHERE comment_id='". $row1['comment_id'] ."' and member_id = '".$member_id."'";
$cdsql1  = mysqli_query($con, $cdquery1) or die(mysqli_error($con));
$comment_dislike_count1 = mysqli_num_rows($cdsql1);
if($comment_dislike_count1 > 0) {
echo '<a href="javascript: void(0)" class="comment_dislike show_cmt_linkClr" id="comment_dislike'.$row1['comment_id'].'" title="'.$lang['dislike'].'" rel="disLike">'.$lang['dislike'].'</a>';
} else {
echo '<a href="javascript: void(0)" class="comment_dislike show_cmt_linkClr" id="comment_dislike'.$row1['comment_id'].'" title="'.$lang['Undislike'].'" rel="disLike">'.$lang['Undislike'].'</a>';
}
?>

</span> 
<!-- End of dislike  button -->
<!-- Reply Button -->
<span style="top:2px; margin-left:2px;">
<span class="mySpan_dot_class"> · </span>
<a href="" id="<?php echo $row1['comment_id'];?>" class="replyopen show_cmt_linkClr"><?php echo $lang['Reply'];?></a>

</span>


<?php if($row1['type']==1)
{ ?>



<span style="top:2px; margin-left:2px;" >
<span class="mySpan_dot_class"> · </span>
 <a class="translateButton show_cmt_linkClr" href="javascript:void(0);" id="translateButton<?php echo $row1['comment_id'];?>"  ><?php echo  $lang['Translate'];?></a>

</span>

       
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
	<?php  echo $lang['View'];?> <?php echo $q;?> <?php  echo $lang['more replys'];?>
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

$repl_memb_id=$reply_res['member_id'];
	
	$block=mysqli_query($con, "select * from blocklist where userid='$repl_memb_id' and blocked_userid='$member_id' ");
	$block_count = mysqli_num_rows($block);
if($block_count==0 && $reply_res['active']==0)
{	
?>
<div class="streplybody" id="streplybody<?php echo $reply_res['reply_id']; ?>">
<div class="stcommentimg">
<a href="<?php echo $base_url.$row['username'];?>"><img src="<?php echo $base_url.$reply_res['profImage']; ?>" class='small_face'/></a>
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
 <br />	 
<?php
 }
   ?> 
 
<br />	 
<?php 
if(isset($_SESSION['lang'])&&($_SESSION['lang']<>"en"))
	{	
		
		$sql = mysqli_query($con, "select * from comment_reply1 where msg_id='".$reply_res['reply_id']."' and tr_id='".$_SESSION['lang']."'")or die(mysqli_error($con));
$r_count = mysqli_num_rows($sql);
if($r_count>0)
{
$row_comment = mysqli_fetch_assoc($sql);


	echo $row_comment['message'];

}
	
	else
	{
		
	include "test7.php";
		
	}
	$sql1 = mysqli_query($con, "select * from comment_reply1 where msg_id='".$reply_res['reply_id']."' and tr_id='".$_SESSION['lang']."'")or die(mysqli_error($con));
$r_count1 = mysqli_num_rows($sql1);
	if($r_count1==0)
{



	echo $reply_res['content'];

}		
	}
	
	else
	{
		echo $reply_res['content'];
		
	}
	


?>
<div class="replytarget" style="font:bold;" id="replytarget<?php echo $reply_res['reply_id'];?>"></div>


<div class="streplytime"><?php time_stamp($reply_res['date_created']); ?></div><div tabindex="1" id="replytranslatemenu<?php echo $reply_res['reply_id'];?>" class="replytranslatemenu" style="display:none; position:absolute;margin-left: 34%; "> <select id="replylangs<?php echo $reply_res['reply_id'];?>" class="postlangs" onchange="selectOption(this.value, <?php echo $reply_res['reply_id'];?>,3,'<?php 
if(isset($_SESSION['lang']))
{
echo $_SESSION['lang'];
}
else
{
 echo 'en';
 }?>')">
            <option value=""><?php echo $lang['select language'];?></option> 
            </select>
            </div> 
<span style="padding-left:5px;">
<!--like block-->
<div><br>
<?php
$reply_like_query = mysqli_query($con, "SELECT * FROM reply_like WHERE reply_id='". $reply_res['reply_id'] ."'");
$reply_like_count = mysqli_num_rows($reply_like_query);

$reply_like_query1 = mysqli_query($con, "SELECT m.username,m.active,m.member_id 
								  FROM reply_like c, members m 
								  WHERE m.active != 1 
								  AND m.member_id = c.member_id 
								  AND c.reply_id = '".$reply_res['reply_id']."' 
								  AND c.member_id = '".$_SESSION['SESS_MEMBER_ID']."' ");
$reply_like_count = mysqli_num_rows($reply_like_query1);
if($reply_like_count == 1)
{
$reply_like_query2 = mysqli_query($con, "SELECT m.username,m.active,m.member_id 
								  FROM reply_like c, members m 
								  WHERE m.active != 1
								  AND m.member_id=c.member_id 
								  AND c.reply_id='".$reply_res['reply_id']."' 
								  AND c.member_id!='".$_SESSION['SESS_MEMBER_ID']."' LIMIT 2");
$rlike_count = mysqli_num_rows($reply_like_query2);
$new_rlike_count = $reply_like_count - 2; 
}
else
{
$reply_like_query2 = mysqli_query($con, "SELECT m.username,m.active,m.member_id 
                                 FROM reply_like c, members m 
								 WHERE m.active != 1 AND m.member_id=c.member_id 
								 AND c.reply_id='".$reply_res['reply_id']."' LIMIT 3");
$rlike_count = mysqli_num_rows($reply_like_query2);
$new_rlike_count=$reply_like_count - 3; 
}

?>
<div class="rlike" id="rlike<?php echo $reply_res['reply_id'];?>" style="display:<?php if($reply_like_count <= 0) { echo 'none'; } else { echo 'block'; }?>">
<?php 

if($reply_like_count == 1)
{?><span id="you<?php echo $reply_res['reply_id'];?>"><?php echo $lang['You'];?><?php if($reply_like_count>1)
echo ','; ?> </span><?php
}

?>

<input type="hidden"  value="<?php echo $reply_like_count; ?>" id="rcommacount<?php echo $reply_res['reply_id'];?>" >
<?php

$i = 0;
while($reply_like_res = mysqli_fetch_array($reply_like_query2)) {
$i++; 	  
?>

<a href="<?php echo $base_url.$reply_like_res['username']; ?>" id="likeuser<?php echo $reply_res['reply_id'];?>"><?php echo $reply_like_res['username']; ?></a>
<?php
	
if($i <> $rlike_count) { echo ',';}
 
} 
if($rlike_count > 3) {
?>
<?php echo $lang['and'];?> <span id="rlike_count<?php echo $reply_res['reply_id'];?>" class="rnumcount"><?php echo $new_rlike_count;?></span><?php echo $lang['others'];?><?php } ?> <?php echo $lang['like this'];?>.</div> 

</div>
<!--end like block-->

<!--dislie block-->
<div>
<?php
$rdquery = "SELECT * FROM reply_dislike WHERE reply_id='". $reply_res['reply_id'] ."'";
$rdsql  = mysqli_query($con, $rdquery) or die(mysqli_error($con));
$reply_dislike_count = mysqli_num_rows($rdsql);

$rdquery1 = mysqli_query($con, "SELECT m.username,m.active,m.member_id FROM comment_dislike c, members m WHERE m.active != 1 AND m.member_id=c.member_id 
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
echo '<a href="javascript: void(0)" class="reply_dislike show_cmt_linkClr" id="reply_dislike'.$reply_res['reply_id'].'" title="'.$lang['dislike'].'" rel="disLike">'.$lang['dislike'].'</a>';
} else {
echo '<a href="javascript: void(0)" class="reply_dislike show_cmt_linkClr" id="reply_dislike'.$reply_res['reply_id'].'" title="'.$lang['Undislike'].'" rel="disLike">'.$lang['Undislike'].'</a>';
}
?>
</span> 
<!-- End of dislike  button -->
<!-- Reply Button -->
<span style="top:2px; margin-left:5px;">
<span class="mySpan_dot_class"> · </span>
<a href="" id="<?php echo $reply_res['reply_id'];?>" class="reply-replyopen show_cmt_linkClr"><?php echo $lang['Reply']; ?></a>

</span>
<span style="top:2px; margin-left:3px;" >
<span class="mySpan_dot_class"> · </span>
 <a class="replytranslateButton show_cmt_linkClr" href="javascript:void(0);" id="replytranslateButton<?php echo $reply_res['reply_id'];?>"  ><?php echo $lang['Translate']; ?></a>

</span>





            
<textarea class="replysource" id="replysource<?php echo $reply_res['reply_id'];?>"  style="display:none;"><?php echo $reply_res['content'];?></textarea>
<div class="replytarget" style="font:bold;" id="replytarget<?php echo $reply_res['reply_id'];?>"></div>


<?php if($row1['type']==1)
{ ?>

       
<?php 
} ?>

</div><!--End streplytext div-->
<!--reply@reply-->
<div class="replycontainer" style="margin-left:40px;" id="reply-reply-load<?php echo $reply_res['reply_id'];?>">
<?php
$reply_r_sql  = mysqli_query($con, "SELECT m.username,m.active,m.member_id,m.profImage,
						   a.content, a.date_created,a.id
						   FROM reply_reply a 
						   LEFT JOIN members m ON a.member_id = m.member_id 
						   WHERE reply_id=" . $reply_res['reply_id'] . " 
						   ORDER BY id DESC limit 0,2");

while($reply_r_res = mysqli_fetch_assoc($reply_r_sql))
{
$repl_r_memb_id=$reply_r_res['member_id'];
	
	$block=mysqli_query($con, "select * from blocklist where userid='$repl_r_memb_id' and blocked_userid='$member_id' ");
	$block_count = mysqli_num_rows($block);
if($block_count==0 && $reply_r_res['active']==0)
{
?>
<div class="reply-reply-body" id="reply-reply-body<?php echo $reply_r_res['id']; ?>">
<div class="stcommentimg">
<a href="<?php echo $base_url.$reply_r_res['username'];?>"><img src="<?php echo $base_url.$reply_r_res['profImage']; ?>" class='small_face'/></a>
</div>

<div class="reply-reply-text">
 <?php 
if($_SESSION['SESS_MEMBER_ID'] == $reply_r_res['member_id'])
{
?>
<a class="reply-reply-delete" href="#" id='<?php echo $reply_r_res['id']; ?>' title='<?php echo $lang['Delete Reply']; ?>'></a>
<?php } ?>
<a href="<?php echo $base_url.$reply_r_res['username'];?>"><b><?php echo $reply_r_res['username']; ?> 
 
 </b></a>
<?php 
 
 if($reply_res['member_id'] <> $reply_r_res['member_id'])
 {
	 echo '@'; 
	?> <a href="<?php echo $base_url.$reply_res['username'];?>"><b><?php echo $reply_res['username']; ?> 
 
 </b></a>
 <br />	 
<?php
 }
?> 
 <br />	

<?php 
if(isset($_SESSION['lang'])&&($_SESSION['lang']<>"en"))
	{	
		
		$sql = mysqli_query($con, "select * from reply_reply1 where msg_id='".$reply_r_res['id']."' and tr_id='".$_SESSION['lang']."'")or die(mysqli_error($con));
$r_count = mysqli_num_rows($sql);
if($r_count>0)
{
$row_reply_reply = mysqli_fetch_assoc($sql);


	echo $row_reply_reply['message'];

}
	
	else
	{
		
include "test6.php";
		
	
		
	}
	$sql1 = mysqli_query($con, "select * from reply_reply1 where msg_id='".$reply_r_res['id']."' and tr_id='".$_SESSION['lang']."'")or die(mysqli_error($con));
$r_count1 = mysqli_num_rows($sql1);
	if($r_count1==0)
{



	echo $reply_r_res['content'];

}	
	}
	
	else
	{
		echo $reply_r_res['content'];
		
	}
?>
<div class="streplytime"><?php time_stamp($reply_r_res['date_created']); ?></div>

</div><!--End reply-reply div-->
<!--reply@reply-->

</div><!--End streplybody div-->
<?php } }?>
</div>
<!--Start replyupdate -->
<div class="reply-reply-update" style='display:none' id='reply-reply-update<?php echo $reply_res['reply_id'];?>'>
<div class="streplyimg">
<img src="<?php echo $base_url.$mem_New_Result['profImage'];?>" class='small_face'/>
</div>

<div class="reply-reply-text" >
<form method="post" action="">
<textarea name="reply" class="reply-reply" id="reply-reply<?php echo $reply_res['reply_id'];?>"></textarea>
<br /> 
<input type="submit" abcd="<?php echo $reply_res['member_id']; ?>"  title="<?php echo $reply_res['username']; ?>" value="<?php echo $lang['Reply'];?>"  id="<?php echo $reply_res['reply_id'];?>" class="reply-reply reply_reply_button"/>
<input type="button"  value=" <?php echo $lang['Cancel'];?>"  onclick="closereplyreply('reply-reply-update<?php echo $reply_res['reply_id'];?>')" class="cancel"/>
</form>
</div>
</div>
<!--End replyupdate div	--> 
</div><!--End streplybody div-->
<?php }}
?>

<!--Start replyupdate -->
<div class="replyupdate" style='display:none' id='replybox<?php echo $row1['comment_id'];?>'>
<div class="streplyimg">
<img src="<?php echo $base_url.$mem_New_Result['profImage'];?>" class='small_face'/>
</div>

<div class="streplytext" >
<form method="post" action="">
<textarea name="reply" class="reply"  id="rtextarea<?php echo $row1['comment_id'];?>"></textarea>
<br /> 
<input type="submit" abcd="<?php echo $row1['member_id']; ?>"  title="<?php echo $row1['username']; ?>" value="OK"  id="<?php echo $row1['comment_id'];?>" class="reply_button"/>
<input type="button"  value=" <?php echo $lang["Cancel"];?> "  id="<?php echo $row['messages_id'];?>" onclick="closereply('replybox<?php echo $row1['comment_id'];?>')" class="cancel"/>
</form>
</div>
</div>
<!--End replyupdate div	--> 
</div><!--End replycontainer div-->
</div>
<?php } }
$q = mysqli_query($con, "SELECT * FROM bleh WHERE member_id='". $_SESSION['SESS_MEMBER_ID'] ."' and remarks='".$row['messages_id']."' ");

?>

</div>



<div class="commentupdate" style='display:none' id='commentbox<?php echo $row['messages_id'];?>'>
<div class="stcommentimg">
<img src="<?php echo $base_url.$mem_New_Result['profImage'];?>" class='small_face'/>
</div>

<div class="stcommenttext" >
<form method="post" action="">
<textarea name="comment" class="comment" id="ctextarea<?php echo $row['messages_id'];?>"></textarea>
<!--code for smiley-->
<input type="hidden" id="currentid" value="<?php echo $row['messages_id'];?>" />

<a herf="javascript:void(0)" style="cursor:pointer;" onclick="showsmiley(this.id)" id="<?php echo $row['messages_id'];?>"><img src="images/Glad.png" style="height: 17px; width: 17px;"></a>
<!--code for smiley-->


<input type="submit"  value="<?php echo $lang['Comment'];?>"  id="<?php echo $row['messages_id'];?>" class="button22 cancel"/>



<!--<input type="submit"  value=" Comment "  id="<?php echo $row['messages_id'];?>" class="button"/>!-->
<input type="button"  value=" <?php echo $lang["Cancel"];?> "  id="<?php echo $row['messages_id'];?>" onclick="cancelclose('commentbox<?php echo $row['messages_id'];?>')" class="cancel"/>

</form>
</div>
</div>



<div class="commentupdate" style='display:none' id='reportbox<?php echo $row['messages_id'];?>'>
<div class="stcommentimg">
<img src="<?php echo $base_url.$mem_New_Result['profImage'];?>" class='small_face'/>
</div>

<div class="stcommenttext" >
<form method="post" action="">
<textarea name="comment" class="comment" maxlength="200"  id="rptextarea<?php echo $row['messages_id'];?>" placeholder="<?php echo $lang['Flag this status'];?>.."></textarea>
<br />
<input type="submit"  value=" <?php echo $lang['Report'];?>"  id="<?php echo $row['messages_id'];?>" class="report"/>
<input type="button"  value=" <?php echo $lang['Cancel'];?>"  id="<?php echo $row['messages_id'];?>" onclick="canclose('reportbox<?php echo $row['messages_id'];?>')" class="cancel"/>
</form>
</div>
</div>


<div class="emot_comm">

    
    
	
    
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
		echo '<a href="javascript: void(0)" class="post_dislike show_cmt_linkClr" id="post_dislike'.$row['messages_id'].'" title="'.$lang['dislike'].'" rel="disLike">'.$lang['dislike'].'</a>';
	} 

	else 
	{ 
		echo '<a href="javascript: void(0)" class="post_dislike show_cmt_linkClr" id="post_dislike'.$row['messages_id'].'" title="'.$lang['Undislike'].'" rel="disLike">'.$lang['Undislike'].'</a>';
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

<span class="show-cmt">
<span class="mySpan_dot_class"> · </span>
<a href="javascript:void(0)" id="<?php echo $row['messages_id'];?>" class="flagopen show_cmt_linkClr"><?php echo $lang['Flag this Status'];?></a>

</span>

<?php if($row['type']==0)
 {
	 if(substr($row['messages'],0,4) != 'http' )
{ ?>
<span style="top:2px; left:3px;" >
<span class="mySpan_dot_class"> · </span>
<a class="posttranslateButton show_cmt_linkClr" href="javascript:void(0);" id="posttranslateButton<?php echo $row['messages_id'];?>"  ><?php echo $lang['Translate'];?></a>
</span>
<?php } } ?>
</div>

</div>
</div>
<?php } } ?>
