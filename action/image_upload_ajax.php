<?php 
ob_start();
require($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php');
include($_SERVER['DOCUMENT_ROOT'].'/config.php');
require($_SERVER['DOCUMENT_ROOT'].'/common/qb_email.php');
//error_reporting(0);
if(!isset($_SESSION['SESS_MEMBER_ID']))
	{
echo "1";	
	}
	else
	{
	


if(isset($_SESSION['lang']))
	{	
		include($_SERVER['DOCUMENT_ROOT'].'/common.php');
	}
	else
	{		
		include($_SERVER['DOCUMENT_ROOT'].'/Languages/en.php');		
	}

include_once ($_SERVER['DOCUMENT_ROOT'].'/includes/time_stamp.php');
include_once ($_SERVER['DOCUMENT_ROOT'].'/includes/tolink.php');

$member_id = mysqli_real_escape_string($con, f($_POST['member_id'],'escapeAll'));
$upload_value = mysqli_real_escape_string($con, f($_POST['uploads'],'escapeAll'));
$country = mysqli_real_escape_string($con, f($_POST['country'],'escapeAll'));
$description=nl2br($_POST['description'],'escapeAll');
$description = mysqli_real_escape_string($con, f($description,'escapeAll'));
$privacy = mysqli_real_escape_string($con, f($_POST['privacy'],'escapeAll'));

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
}
else{

	$content_id = $member_id;
	}
}

else
{
	$content_id = 0;
}
if($_POST['content_id'])
{
$content_id = mysqli_real_escape_string($con, f($_POST['content_id']));
}
if($_POST['country'] != 'mywall'){
$country = mysqli_real_escape_string($con, f($_POST['country']));
}
$member = mysqli_query($con, "select * from members where member_id = '$member_id'");
$member_res = mysqli_fetch_array($member);
$time=strtotime(date("Y-m-d H:i:s"));
mysqli_query($con,  "INSERT INTO message (member_id,content_id,messages,country_flag,type,wall_privacy,share_member_id,unshare_member_id,date_created,description)
VALUES('$member_id','$content_id','".$upload_image."','".$country."',1,'".$privacy."','".$share_member_id."','".$unshare_member_id."','$time','".$description."')") or die(mysqli_error($con));
$message_id=mysqli_insert_id($con);			

$url = 'posts.php?id='.$message_id.'';
$fquery = "select m.member_id,m.email_id from friendlist f,members m where f.member_id=m.member_id and f.added_member_id = '".$member_id."' AND status !=0";

//echo $fquery;

$fsql = mysqli_query($con, $fquery);			
while($fres = mysqli_fetch_array($fsql))

{

	$to = $fres['email_id'];
$msg_member_id = $fres['member_id'];

$nquery = "INSERT INTO notifications (sender_id, received_id, type_of_notifications, href, is_unread, date_created)

				VALUES('$member_id','$msg_member_id',11,'$url',0,'$time')";

mysqli_query($con, $nquery);
$subject = "".ucfirst($member_res['username'])." added an image on quakbox wall";

$mailTitle="";
$htmlbody = " 
        	<div style='width:100px;float:left;border:1px solid #ddd;'>
        		<a href='".$base_url.$member_res['username']."' title='".$member_res['username']."' target='_blank' style='text-decoration:none;'><img style='width:100%;' alt='".$member_res['username']."' title='".$member_res['username']."' src='".$base_url.$member_res['profImage']."' /></a>
        	</div> 
        	<div style='float:left;padding:15px;'>
        		<div>
        			<a href='".$base_url.$member_res['username']."' title='".$member_res['username']."' target='_blank' style='text-decoration:none;color:#085D93;'>".$member_res['username']." Added an image on quakbox wall</a>
        		</div>
        		";
if($description != ''){	
$htmlbody .="<div>Message: ".$description."</div>";
}
$htmlbody .="<div><img src=".$base_url.$upload_image." height='250' width='250'/></div>";

$obj = new QBEMAIL(); 
$mail=$obj->send_email($to,$subject,'',$mailTitle,$htmlbody,'');

}

		
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

<div class="stbody" id="stbody<?php echo $row['messages_id'];?>" data-id="<?php echo $row['messages_id'];?>" wall-type="1">



<div class="stimg">

<?php if($_SESSION['SESS_MEMBER_ID'] == $row['member_id'])

{

   

?>







<a href="<?php echo $base_url.'i/'.$row['username']; ?>"><img src="<?php echo $base_url.$row['profImage'];?>" class='big_face' original-title="<?php echo $row['username'];?>"/></a> 



<?php } 

else

{

?>

<a href="<?php echo $base_url.$row['username'];?>"><img src="<?php echo $base_url.$row['profImage'];?>" class='big_face' original-title="<?php echo $row['username'];?>"/></a> 

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

<img style="margin:0px 3px;" src="<?php echo $base_url; ?>images/arrow_png.jpg" /> 

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

 

 <?php }  if($row['type']==0)
 
 {
 
  

	if(isset($_SESSION['lang']))
	{	
		
		?>
        <div id="target_tr"></div>
        <?php
		
	}
	
	else
	{
		echo tolink(htmlentities($row['messages']));
		
	}

	?>

<div tabindex="1" id="posttranslatemenu<?php echo $row['messages_id'];?>" class="posttranslatemenu" style="display:none; position:absolute;margin-left: 34%; "> <select id="postlangs<?php echo $row['messages_id'];?>" class="postlangs" onchange="selectOption(this.value, <?php echo $row['messages_id'];?>,2)">

            <option value=""><?php echo $lang['select language'];?></option> 

            </select>

            </div> 

            

<textarea class="postsource" id="postsource<?php echo $row['messages_id']; ?>"  style="display:none;"><?php echo $row['messages']; ?></textarea>

<div class="posttarget" style="font:bold;" id="posttarget<?php echo $row['messages_id']; ?>"></div>

<?php

} 

if($row['type']==1){

$desc=mysqli_query($con, "select description from message where messages_id='".$row['messages_id']."'" );
$desc_res=mysqli_fetch_assoc($desc);
?><div><?php
echo $desc_res['description'];

?></div>

<a href="albums.php?back_page=<?php echo $homepage;?>&member_id=<?php echo $row['member_id']; ?>&album_id=<?php echo $row['msg_album_id']; ?>&image_id=<?php echo $row['upload_data_id'];?>" >

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
    <img src="<?php echo $base_url.$row['messages'];?>" width="<?php if($width<400)echo $width; else echo '400'?>px" />
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



$post_like_sql = mysqli_query($con, "SELECT * FROM bleh WHERE remarks='". $row['messages_id'] ."'");

$post_like_count = mysqli_num_rows($post_like_sql);



$post_like_sql1 = mysqli_query($con, "SELECT m.username,m.member_id FROM bleh b, members m WHERE m.member_id=b.member_id AND b.remarks='".$row['messages_id']."' AND b.member_id='".$_SESSION['SESS_MEMBER_ID']."'");

$post_like_count1 = mysqli_num_rows($post_like_sql1);



if($post_like_count1==1)

{

$post_like_sql2 = mysqli_query($con, "SELECT m.username,m.member_id FROM bleh b, members m WHERE m.member_id=b.member_id AND b.remarks='".$row['messages_id']."' AND b.member_id!='".$_SESSION['SESS_MEMBER_ID']."' LIMIT 2");

$plike_count = mysqli_num_rows($post_like_sql2);

$new_plike_count=$post_like_count-2; 

}

else

{

$post_like_sql2 = mysqli_query($con, "SELECT m.username,m.member_id FROM bleh b, members m WHERE m.member_id=b.member_id AND b.remarks='".$row['messages_id']."' LIMIT 3");

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



$sql1 = mysqli_query($con ,"SELECT * FROM post_dislike WHERE msg_id='". $row['messages_id'] ."'") or die(mysqli_error($con));

$dislike_count = mysqli_num_rows($sql1);

 

$query1=mysqli_query($con, "SELECT m.username,m.member_id FROM post_dislike b, members m WHERE m.member_id=b.member_id AND b.msg_id='".$row['messages_id']."' LIMIT 3");

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

	<img src="<?php echo $base_url; ?>images/cicon.png" style="float:left;" alt="" />

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

$comment  = mysqli_query($con, "SELECT * FROM postcomment p,members m  WHERE p.post_member_id=m.member_id and p.msg_id=" . $row['messages_id'] . " ORDER BY comment_id DESC limit 0,4");

while($row1 = mysqli_fetch_assoc($comment))

{

?>

<div class="stcommentbody" id="stcommentbody<?php echo $row1['comment_id']; ?>">

<div class="stcommentimg">
<?php if($_SESSION['SESS_MEMBER_ID'] == $row1['member_id'])

{

?>

<a href="<?php echo $base_url.'i/'.$row['username'];?>"><img src="<?php echo $base_url.$row1['profImage']; ?>" class='small_face'/></a>
<?php } else {?>
<a href="<?php echo $base_url.$row['username'];?>"><img src="<?php echo $base_url.$row1['profImage']; ?>" class='small_face'/></a>	
<?php } ?>

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



$comment_like_query1 = mysqli_query($con, "SELECT m.username,m.member_id FROM comment_like c, members m WHERE m.member_id=c.member_id 

AND c.comment_id='".$row1['comment_id']."' AND c.member_id='".$_SESSION['SESS_MEMBER_ID']."' ");

$comment_like_res1 = mysqli_num_rows($comment_like_query1);

if($comment_like_res1==1)

{

$comment_like_query = mysqli_query($con, "SELECT m.username,m.member_id FROM comment_like c, members m WHERE m.member_id=c.member_id 

AND c.comment_id='".$row1['comment_id']."' AND c.member_id!='".$_SESSION['SESS_MEMBER_ID']."' LIMIT 2");

$clike_count = mysqli_num_rows($comment_like_query);

$new_clike_count=$comment_like_count-2; 

}

else

{

$comment_like_query = mysqli_query($con, "SELECT m.username,m.member_id FROM comment_like c, members m WHERE m.member_id=c.member_id 

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



$cdquery1 = mysqli_query($con, "SELECT m.username,m.member_id FROM comment_dislike c, members m WHERE m.member_id=c.member_id 

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

	<img src="<?php echo $base_url;?>images/cicon.png" style="float:left;" alt="" />

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

$reply_sql  = mysqli_query($con, "SELECT * FROM comment_reply c,members m WHERE c.member_id = m.member_id and comment_id=" . $row1['comment_id'] . " ORDER BY reply_id DESC limit 0,2");



while($reply_res = mysqli_fetch_assoc($reply_sql))

{

?>

<div class="streplybody" id="streplybody<?php echo $reply_res['reply_id']; ?>">

<div class="stcommentimg">
<?php if($_SESSION['SESS_MEMBER_ID'] == $reply_res['member_id'])

{

?>
<a href="<?php echo $base_url.'i/'.$reply_res['username'];?>"><img src="<?php echo $base_url.$reply_res['profImage']; ?>" class='small_face'/></a>
<?php } else { ?>
<a href="<?php echo $base_url.$reply_res['username'];?>"><img src="<?php echo $base_url.$reply_res['profImage']; ?>" class='small_face'/></a>
<?php } ?>
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

								  FROM reply_like c, members m 

								  WHERE m.member_id = c.member_id 

								  AND c.reply_id = '".$reply_res['reply_id']."' 

								  AND c.member_id = '".$_SESSION['SESS_MEMBER_ID']."' ");

$reply_like_count = mysqli_num_rows($reply_like_query1);

if($reply_like_count == 1)

{

$reply_like_query2 = mysqli_query($con, "SELECT m.username,m.member_id 

								  FROM reply_like c, members m 

								  WHERE m.member_id=c.member_id 

								  AND c.reply_id='".$reply_res['reply_id']."' 

								  AND c.member_id!='".$_SESSION['SESS_MEMBER_ID']."' LIMIT 2");

$rlike_count = mysqli_num_rows($reply_like_query2);

$new_rlike_count = $reply_like_count - 2; 

}

else

{

$reply_like_query2 = mysqli_query($con, "SELECT m.username,m.member_id 

                                 FROM reply_like c, members m 

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

	

if($i <> $rlike_count) { echo ',';}

 

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



$rdquery1 = mysqli_query($con, "SELECT m.username,m.member_id FROM comment_dislike c, members m WHERE m.member_id=c.member_id 

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
<span class="mySpan_dot_class"> · </span>

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

						   LEFT JOIN members m ON a.member_id = m.member_id 

						   WHERE reply_id=" . $reply_res['reply_id'] . " 

						   ORDER BY id DESC limit 0,2");



while($reply_r_res = mysqli_fetch_assoc($reply_r_sql))

{

?>

<div class="reply-reply-body" id="reply-reply-body<?php echo $reply_r_res['id']; ?>">

<div class="stcommentimg">
<?php if($_SESSION['SESS_MEMBER_ID'] == $reply_r_res['member_id'])

{

?>
<a href="<?php echo $base_url.'i/'.$reply_r_res['username'];?>"><img src="<?php echo $base_url.$reply_r_res['profImage']; ?>" class='small_face'/></a>
<?php } else { ?>
<a href="<?php echo $base_url.$reply_r_res['username'];?>"><img src="<?php echo $base_url.$reply_r_res['profImage']; ?>" class='small_face'/></a>
<?php } ?>
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

<img src="<?php echo $base_url.$res['profImage'];?>" class='small_face'/>

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

<img src="<?php echo $base_url.$res['profImage'];?>" class='small_face'/>

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

$q = mysqli_query($con, "SELECT * FROM bleh WHERE member_id='". $_SESSION['SESS_MEMBER_ID'] ."' and remarks='".$row['messages_id']."' ");

?>



</div><!--End commentcontainer div--> 



<div class="commentupdate" style='display:none' id='commentbox<?php echo $row['messages_id'];?>'>

<div class="stcommentimg">

<img src="<?php echo $base_url.$row['profImage'];?>" class='small_face'/>

</div>



<div class="stcommenttext" >

<form method="post" action="">
<textarea name="comment" class="comment" id="ctextarea<?php echo $row['messages_id'];?>"></textarea>

<input type="hidden" id="currentid" value="<?php echo $row['messages_id'];?>" />

<a herf="javascript:void(0)" style="cursor:pointer;" onclick="showsmiley(this.id)" id="<?php echo $row['messages_id'];?>"><img src="<?php echo $base_url; ?>images/Glad.png"></a>

<br />



<input type="submit"  value="<?php echo $lang['Comment '];?>"  id="<?php echo $row['messages_id'];?>" class="button22 cancel"/>



<!--<input type="submit"  value=" Comment "  id="<?php echo $row['messages_id'];?>" class="button"/>!-->
<input type="button"  value=" <?php echo $lang["Cancel"];?> "  id="<?php echo $row['messages_id'];?>" onclick="cancelclose('commentbox<?php echo $row['messages_id'];?>')" class="cancel"/>


</form>

</div>

</div><!--End commentupdate div	--> 

<div class="commentupdate" style='display:none' id='reportbox<?php echo $row['messages_id'];?>'>

<div class="stcommentimg">

<img src="<?php echo $base_url.$row['profImage'];?>" class='small_face'/>

</div>



<div class="stcommenttext" >

<form method="post" action="">

<textarea name="comment" class="comment" maxlength="200"  id="rptextarea<?php echo $row['messages_id'];?>" placeholder="<?php echo $lang['Flag this status'];?>.."></textarea>

<br />

<input type="submit"  value=" <?php echo $lang['Report'];?> "  id="<?php echo $row['messages_id'];?>" class="report"/>

<input type="button"  value="  <?php echo $lang["Cancel"];?>"  id="<?php echo $row['messages_id'];?>" onclick="canclose('reportbox<?php echo $row['messages_id'];?>')" class="cancel"/>

</form>

</div>

</div><!--End commentupdate div	-->

 

<div class="emot_comm">



    <!--<div id="normal-button" class="settings-button" title="0" value="<?php //echo $row['messages_id']; ?>" >

    <span style="bottom: 2px;float: left;position: relative;width: 33px;cursor: pointer;" class="">

	<img src="images/smiley.png"/>

	</span>

    </div>-->

    

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
<a href="javascript:void(0)" class="share_open show_cmt_linkClr" rowtype="<?php echo $row['type'];?>" id="<?php echo $row['messages_id'];?>" title="<?php echo $lang['Share'];?>"><?php echo $lang['Share'];?></a>

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
<a class="posttranslateButton show_cmt_linkClr" href="javascript:void(0);" id="posttranslateButton<?php echo $row['messages_id'];?>"  ><?php echo $lang['Translate'];?></a>

</span>

<?php } } ?>

</div>



</div><!--End sttext div	--> 

</div><!--End stbody div	-->
  
<?php
}
}
}
?> 