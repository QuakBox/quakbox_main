<?php ob_start();

session_start();

//error_reporting(0);
include('../config.php');
if(isset($_SESSION['lang']))
	{	
		include($root_folder_path.'public_html/common.php');
	}
	else
	{		
		include($root_folder_path.'public_html/Languages/en.php');		
	}



include_once '../includes/time_stamp.php';

include_once '../includes/tolink.php';



$s_member_id = $_SESSION['SESS_MEMBER_ID'];

$member_id = $_POST['member_id'];
$member_id	 = 	f($member_id, 'strip');
$member_id	 = 	f($member_id, 'escapeAll');
$member_id   = mysqli_real_escape_string($con, $member_id);

$mystatusx = $_POST['update'];
$mystatusx	 = 	f($mystatusx, 'strip');
$mystatusx	 = 	f($mystatusx, 'escapeAll');
$mystatusx   = mysqli_real_escape_string($con, $mystatusx);



$group_id= $_POST['group_id'];
$group_id	 = 	f($group_id, 'strip');
$group_id	 = 	f($group_id, 'escapeAll');
$group_id   = mysqli_real_escape_string($con, $group_id);

$smembersql =  mysqli_query($con, "select * from members where member_id='".$s_member_id."'");

$smemberres = mysqli_fetch_array($smembersql);




$member = mysqli_query($con, "select * from members where member_id = '$member_id'");

$member_res = mysqli_fetch_array($member);



mysqli_query($con, "INSERT INTO groups_wall (member_id,messages,group_id,type,date_created)

VALUES('$member_id','".$mystatusx."','$group_id','0',".strtotime(date("Y-m-d H:i:s")).")");



$sql = mysqli_query($con, "select * from groups_wall msg,members m where msg.member_id=m.member_id order by messages_id desc");

$row = mysqli_fetch_array($sql);

if ($row)

{

	$time = $row['date_created'];

	$msg_id = $row['messages_id'];

	$messages = $row['messages'];

	$url = 'posts.php?id='.$msg_id.'';

	$type = $row['type'];

	

	

	$fquery = "select m.member_id,m.email_id from friendlist f,members m where f.member_id=m.member_id and f.added_member_id = '".$member_id."' AND status !=0";

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
/*$subject_text = 'Group';

if($type == 0){

	$subject_msg = 'status';

} else if($type == 1){

	$subject_msg = 'photo';

}else {

	$subject_msg = 'video';

}
*/


/*$to = $ids;

$subject = "".$member_res['username']." post ".$subject_msg." in ".$subject_text."";

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

$message .= "<img src='".$base_url."images/Flags/flags_new/flags/".strtolower($res['code']).".png' width='100' height='100'>";

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

	$message .= "<a href='".$base_url."posts.php?id=".$msg_id."' target='_blank'><img src='".$base_url.$messages."' height='200' width='200'><a>";

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



$mail = mail($to, $subject, $message, $headers); */

}

}



/************************************* end mail function ***********************************/

	

?>

<script type="text/javascript"> 

$(document).ready(function(){$("#stexpand<?php echo $row['messages_id'];?>").oembed("<?php echo  $row['messages']; ?>",{maxWidth: 400, maxHeight: 300});});

</script>

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

<img src="<?php echo $base_url."images/emblems/".$res['code'].".jpg";?>" width="20" height="20" style="margin-left:3px; vertical-align:middle;" />

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

<h3 class="video_title"  ><?php echo $row['title'];?></h3></a>

<script>

   videojs.Quakbox = videojs.Button.extend({

      // @constructor 

        init: function(player, options){

          videojs.Button.call(this, player, options);

          this.on('click', this.onClick);

        }

      });



      videojs.Quakbox.prototype.onClick = function() {

        

      };



      // Note that we're not doing this in prototype.createEl() because

      // it won't be called by Component.init (due to name obfuscation).

      var createQuakboxButton = function() {

        var props = {

            className: 'vjs-quakbox-button vjs-control',

            innerHTML: '<div class="vjs-control-content"><span class="vjs-control-text">' + ('Quakbox') + '</span></div>',

            role: 'button',

            'aria-live': 'polite', // let the screen reader user know that the text of the button may change

            tabIndex: 0

          };

        return videojs.Component.prototype.createEl(null, props);

      };



      var quakbox;

      videojs.plugin('quakbox', function() {

        var options = { 'el' : createQuakboxButton() };

        quakbox = new videojs.Quakbox(this, options);

        this.controlBar.el().appendChild(quakbox.el());

      });



      var vid = videojs("videojs-<?php echo $row['messages_id'];?>", {

        plugins : { quakbox : {} }

      });

    </script>

<video id="videojs-<?php echo $row['messages_id'];?>" class="video-js vjs-default-skin" controls preload="none" width="400" height="225"

      poster="<?php echo $row['thumburl'];?>"

      data-setup="{}">

    <source src="<?php echo $row['messages'];?>" type='video/mp4' />

    <track kind="captions" src="uploadedvideo/captions/demo.captions.vtt" srclang="en" label="English"></track><!-- Tracks need an ending tag thanks to IE9 -->

    <track kind="subtitles" src="uploadedvideo/captions/demo.captions.vtt" srclang="en" label="English"></track><!-- Tracks need an ending tag thanks to IE9 -->

  </video> 

 

  <br/>

  <span class="sttime"  > <h3><?php echo $row['description']; ?></h3></span>

  

 <!--<div class="flowplayer" data-swf="flowplayer/flowplayer.swf" style="height:225px !important;" data-ratio="0.4167">

 <video height="225">         

 <source type="video/mp4" src="<?php echo $row['messages'];?>"> 

      </video>

   </div>-->

<?php }?>

</div>



<div><span class="sttime" title="<?php echo date($time);?>"><?php echo time_stamp($time);?></span>

<br />

<!-- LIke users display panel -->

<?php 



$post_like_sql = mysqli_query($con, "SELECT * FROM groups_wall_like WHERE remarks='". $row['messages_id'] ."'");

$post_like_count = mysqli_num_rows($post_like_sql);



$post_like_sql1 = mysqli_query($con, "SELECT m.username,m.member_id FROM groups_wall_like b, members m WHERE m.member_id=b.member_id AND b.remarks='".$row['messages_id']."' AND b.member_id='".$_SESSION['SESS_MEMBER_ID']."'");

$post_like_count1 = mysqli_num_rows($post_like_sql1);



if($post_like_count1==1)

{

$post_like_sql2 = mysqli_query($con, "SELECT m.username,m.member_id FROM groups_wall_like b, members m WHERE m.member_id=b.member_id AND b.remarks='".$row['messages_id']."' AND b.member_id!='".$_SESSION['SESS_MEMBER_ID']."' LIMIT 2");

$plike_count = mysqli_num_rows($post_like_sql2);

$new_plike_count=$post_like_count-2; 

}

else

{

$post_like_sql2 = mysqli_query($con, "SELECT m.username,m.member_id FROM groups_wall_like b, members m WHERE m.member_id=b.member_id AND b.remarks='".$row['messages_id']."' LIMIT 3");

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

<?php echo $lang[' and'];?> <span id="plike_count<?php echo $row['messages_id'];?>" class="pnumcount"><?php echo $new_plike_count;?></span> <?php echo $lang[' others'] ;} ?> <?php echo $lang['like this'] ; ?> .</div> 



<!-- LIke users display panel -->





<!--Dislike users display panel-->

<?php 



$sql1 = mysqli_query($con, "SELECT * FROM groups_wall_dislike WHERE msg_id='". $row['messages_id'] ."'") or die(mysqli_error($con));

$dislike_count = mysqli_num_rows($sql1);

 

$query1=mysqli_query($con, "SELECT m.username,m.member_id FROM groups_wall_dislike b, members m WHERE m.member_id=b.member_id AND b.msg_id='".$row['messages_id']."' LIMIT 3");

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

$query1  = mysqli_query($con, "SELECT * FROM groups_wall_comment WHERE msg_id=" . $row['messages_id'] . " ORDER BY comment_id DESC") or die(mysqli_error($con));

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

	<?php echo $lang['View'];?> <?php echo $y;?> <?php echo $lang['more comments'];?> 

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

<a href="" id="<?php echo $row1['comment_id'];?>" class="replyopen"><?php echo $lang['Reply'];?></a>

</span>

<!-- <?php if($row1['type']==1){?><span style="top:2px; left:3px;"><a class="translatebutton" onclick="translateSourceTarget(<?php echo $row1['comment_id'];?>);" href="javascript:void(0)" >Translate </a> </span><?php } ?> -->



<?php if($row1['type']==1)

{ ?>

<span style="top:2px; margin-left:3px;" > <a class="translateButton" href="javascript:void(0);" id="translateButton<?php echo $row1['comment_id'];?>"  ><?php echo  $lang['Translate'];?></a></span>



       

<?php 

} ?>





<!--View more reply-->

<?php

$query12  = mysqli_query($con,"SELECT * FROM groups_wall_reply WHERE comment_id=" . $row1['comment_id'] . " ORDER BY reply_id DESC");

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

	View <?php echo $q;?> <?php  echo $lang['more replys'];?>

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

$reply_dislike_query = "SELECT dislike_id FROM groups_wall_reply_dislike WHERE reply_id='". $reply_res['reply_id'] ."' and member_id = '".$member_id."'";

$reply_dislike_sql  = mysqli_query($con, $reply_dislike_query) or die(mysqli_error($con));

$reply_dislike_count = mysqli_num_rows($reply_dislike_sql);

if($reply_dislike_count > 0) {

echo '<a href="javascript: void(0)" class="reply_dislike" id="reply_dislike'.$reply_res['reply_id'].'"title="'.$lang['disLike'].'" rel="disLike">'.$lang['disLike'].'</a>';

} else {

echo '<a href="javascript: void(0)" class="reply_dislike" id="reply_dislike'.$reply_res['reply_id'].'" title="'.$lang['UndisLike'].'" rel="disLike">'.$lang['UndisLike'].'</a>';

}

?>

</span> 

<!-- End of dislike  button -->

<!-- Reply Button -->

<span style="top:2px; margin-left:5px;">

<a href="" id="<?php echo $reply_res['reply_id'];?>" class="reply-replyopen"><?php echo $lang['Reply']; ?></a>

</span>

<?php if($row1['type']==1)

{ ?>

<span style="top:2px; margin-left:3px;" > <a class="translateButton" href="javascript:void(0);" id="translateButton<?php echo $row1['comment_id'];?>"  ><?php echo $lang['Translate']; ?></a></span>

       

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

<img src="<?php echo $base_url.$smemberres['profImage'];?>" class='small_face'/>

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

<img src="<?php echo $base_url.$smemberres['profImage'];?>" class='small_face'/>

</div>



<div class="streplytext" >

<form method="post" action="">

<textarea name="reply" class="reply" maxlength="200"  id="rtextarea<?php echo $row1['comment_id'];?>"></textarea>

<br /> 

<input type="submit" abcd="<?php echo $row1['member_id']; ?>"  title="<?php echo $row1['username']; ?>" value="    @    "  id="<?php echo $row1['comment_id'];?>" class="reply_button"/>

<input type="button"  value=" <?php echo $lang["Cancel"];?> "  id="<?php echo $row['messages_id'];?>" onclick="closereply('replybox<?php echo $row1['comment_id'];?>')" class="cancel"/>

</form>

</div>

</div>

<!--End replyupdate div	--> 

</div><!--End replycontainer div-->

</div>

<?php } 

$q = mysqli_query($con,"SELECT * FROM groups_wall_like WHERE member_id='". $_SESSION['SESS_MEMBER_ID'] ."' and remarks='".$row['messages_id']."' ");

?>



</div><!--End commentcontainer div--> 



<div class="commentupdate" style='display:none' id='commentbox<?php echo $row['messages_id'];?>'>
<div class="stcommentimg">
<img src="<?php echo $base_url.$smemberres['profImage'];?>" class='small_face'/>
</div>

<div class="stcommenttext" >
<form method="post" action="">
<!--<textarea name="comment" class="comment" maxlength="200"  id="ctextarea<?php echo $row['messages_id'];?>"></textarea>!-->
<!-- code for smiley!-->
<div id="ctextarea<?php echo $row['messages_id'];?>" onkeyup="checkdata(this.id)" onclick="checkdata(this.id)" contenteditable="true" name="comment" class="comment" style="height:70px; width:329px; border:1px solid black; overflow-y:scroll;"></div>
<div id="showimg2_<?php echo $row['messages_id'];?>" name="actcomment" style="display:none;" /></div>
<input type="hidden" id="currentid" value="<?php echo $row['messages_id'];?>" />
<!--<input type="button" value="show smiley" id="<?php echo $row['messages_id'];?>" onclick="show(this.id)"  />!--><a herf="#!" style="cursor:pointer;" onclick="show(this.id)" id="<?php echo $row['messages_id'];?>"><img src="<?php echo $base_url.'images/smiley.png';?>"></a>
<!--code for smiley!-->

<br />
<input type="submit"  value="<?php echo $lang['Comment '];?>"  id="<?php echo $row['messages_id'];?>" class="button22 cancel"/>



<!--<input type="submit"  value=" Comment "  id="<?php echo $row['messages_id'];?>" class="button"/>!-->
<input type="button"  value=" <?php echo $lang["Cancel"];?> "  id="<?php echo $row['messages_id'];?>" onclick="cancelclose('commentbox<?php echo $row['messages_id'];?>')" class="cancel"/>

</form>

</div><!--End commentupdate div	--> 
<div class="commentupdate" style='display:none' id='reportbox<?php echo $row['messages_id'];?>'>
<div class="stcommentimg">
<img src="<?php echo $base_url.$smemberres['profImage'];?>" class='small_face'/>
</div>

<div class="stcommenttext" >
<form method="post" action="">
<textarea name="comment" class="comment" maxlength="200"  id="rptextarea<?php echo $row['messages_id'];?>" placeholder="<?php echo $lang['Flag this status'];?>.."></textarea>
<br />
<input type="submit"  value=" <?php echo $lang['Report'];?>"  id="<?php echo $row['messages_id'];?>" class="report"/>
<input type="button"  value=" <?php echo $lang['Cancel '];?>"  id="<?php echo $row['messages_id'];?>" onclick="canclose('reportbox<?php echo $row['messages_id'];?>')" class="cancel"/>
</form>
</div>
</div><!--End commentupdate div	-->

 

<div class="emot_comm">



    <div id="normal-button" class="settings-button" title="0" value="<?php echo $row['messages_id']; ?>" >

    <span style="bottom: 2px;float: left;position: relative;width: 33px;cursor: pointer;" class="">

	<!--<img src="images/smiley.png"/>-->

	</span>

    </div>

    

	<div class="submenu12" id="<?php echo $row['messages_id']; ?>-submenu12" style="display: none; position: absolute; background:#ffffff; margin-top:15px;">

	  

	      <a href="action/groups_comment_post.php?postid=<?php echo $row['messages_id']; ?>&member_id=<?php echo $member_id; ?>&postcomment=images/1.jpg&type=2" ><img src="images/1.jpg"></a>

	    

	      <a href="action/groups_wall_comment_post.php?postid=<?php echo $row['messages_id']; ?>&member_id=<?php echo $member_id; ?>&postcomment=images/2.jpg&type=2" ><img src="images/2.jpg"></a>

	    

	      <a href="action/groups_wall_comment_post.php?postid=<?php echo $row['messages_id']; ?>&member_id=<?php echo $member_id; ?>&postcomment=images/3.jpg&type=2" ><img src="images/3.jpg"></a>

	    

	      <a href="action/groups_wall_comment_post.php?postid=<?php echo $row['messages_id']; ?>&member_id=<?php echo $member_id; ?>&postcomment=images/4.jpg&type=2" ><img src="images/4.jpg"></a>

	      

	      <a href="action/groups_wall_comment_post.php?postid=<?php echo $row['messages_id']; ?>&member_id=<?php echo $member_id; ?>&postcomment=images/5.jpg&type=2" ><img src="images/5.jpg"></a>

	    

	     <a href="action/groups_wall_comment_post.php?postid=<?php echo $row['messages_id']; ?>&member_id=<?php echo $member_id; ?>&postcomment=images/6.jpg&type=2" ><img src="images/6.jpg"></a>

	    

	      <a href="action/groups_wall_comment_post.php?postid=<?php echo $row['messages_id']; ?>&member_id=<?php echo $member_id; ?>&postcomment=images/1.gif&type=2" ><img src="images/1.gif"></a>

	   

	</div>

    

	<span class="show-cmt">

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

 <?php

 /*$pdislikequery = "SELECT dislike_id FROM groups_wall__dislike WHERE member_id='$member_id'";

 $pdislikesql = mysqli_query($con, $pdislikequery);

 

 

	if(mysqli_num_rows($pdislikesql) > 0)

	{

		echo '<a href="javascript: void(0)" class="post_dislike" id="post_dislike'.$row['messages_id'].'" title="'.$lang['Dislike'].'" rel="disLike">'.$lang['DisLike'].'</a>';

	} 



	else 

	{ 

		echo '<a href="javascript: void(0)" class="post_dislike" id="post_dislike'.$row['messages_id'].'" title="'.$lang['UnDislike'].'" rel="disLike">'.$lang['UnDisLike'].'</a>';

	}

	*/

?>

</span>





<span class="show-cmt">

<a href="javascript:void(0)" id="<?php echo $row['messages_id'];?>" class="commentopen"><?php echo $lang['Comment'];?></a>

</span>

<!--

<span class="show-cmt">

<a href="javascript:void(0)" rowtype="<?php// echo $row['type'];?>" class="share_open" id="<?php// echo $row['messages_id'];?>" title="<?php// echo $lang['Share'];?>"><?php// echo $lang['Share'];?></a>

</span>
-->


<span class="show-cmt hidden">

<a href="javascript:void(0)" id="<?php echo $row['messages_id'];?>" class="flagopen"><?php echo $lang['Flag this Status'];?></a>

</span>

<?php if($row['type']==0)

 {

	 if(substr($row['messages'],0,4) != 'http' )

{ ?>

<span style="top:2px; left:3px;" >

<a class="posttranslateButton" href="javascript:void(0);" id="posttranslateButton<?php echo $row['messages_id'];?>"  ><?php echo $lang['Translate'];?></a>

</span>

<?php } } ?>

</div>



</div><!--End sttext div	--> 

 

<?php

}

?> 
