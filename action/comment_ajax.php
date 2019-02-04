<?php 
/**
   * @package    action
   * @subpackage 
   * @author     Vishnu
   * Created date  02/05/2015 
   * Updated date  03/13/2015 
   * Updated by    Vishnu S
 **/
ob_start();
require($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php');	
include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
require($_SERVER['DOCUMENT_ROOT'].'/common/qb_email.php');
if(!isset($_SESSION['SESS_MEMBER_ID']))
	{
echo "1";	
	}
	else
	{

	if(!isset($_SESSION['SESS_MEMBER_ID']))
	{	
		header("location: ".$base_url."login.php?back=". urlencode($_SERVER['REQUEST_URI']));
		exit();
	}
	if(isset($_SESSION['lang']))
	{	
		include('../common.php');
	}
	else
	{
		include('../Languages/en.php');
		
	}
	function reduce_string($str)
    {
        $str = preg_replace_callback(array(

                // eliminate single line comments in '// ...' form
                '#^\s*//(.+)$#m',

                // eliminate multi-line comments in '/* ... */' form, at start of string
                '#^\s*/\*(.+)\*/#Us',

                // eliminate multi-line comments in '/* ... */' form, at end of string
                '#/\*(.+)\*/\s*$#Us'

            ), function ($matches) {return '';}, $str);

        // eliminate extraneous space
        return trim($str);
    }
include_once '../includes/time_stamp.php';
include_once '../assets/smiley/includes/config_smiley.php';

$member_id = $_SESSION['SESS_MEMBER_ID'];

$comment = reduce_string($_POST['comment']);
$comment = mysqli_real_escape_string($con, f($_POST['comment'],'escapeAll'));

foreach ($smileys as $pattern => $result) {	
		$pattern_class = str_replace("'","\\'",$pattern);
		$title = str_replace("-"," ",ucwords(preg_replace_callback("/\.(.*)/",function ($matches) {return '';},$result)));
		$class = str_replace("-"," ",preg_replace_callback("/\.(.*)/",function ($matches) {return '';},$result));
		if (in_array($result, $people)) {			
			$comment= str_replace($pattern, '<img style="vertical-align:middle;" src="'.$base_url.'assets/smiley/images/smileys/'.$result.'" height="20" width="20" />', $comment);
		} elseif (in_array($result, $nature)) {
			$comment= str_replace($pattern, '<img style="vertical-align:middle;" src="'.$base_url.'assets/smiley/images/smileys/'.$result.'" height="20" width="20" />', $comment);
		} elseif (in_array($result, $objects)) {
			$comment = str_replace($pattern, '<img style="vertical-align:middle;" src="'.$base_url.'assets/smiley/images/smileys/'.$result.'" height="20" width="20" />', $comment);
		} elseif (in_array($result, $places)) {
			$comment = str_replace($pattern, '<img style="vertical-align:middle;" src="'.$base_url.'assets/smiley/images/smileys/'.$result.'" height="20" width="20" />', $comment);
		} elseif (in_array($result, $symbols)) {
			$comment = str_replace($pattern, '<img style="vertical-align:middle;" src="'.$base_url.'assets/smiley/images/smileys/'.$result.'" height="20" width="20" />', $comment);
		} else {
			$comment = str_replace($pattern, '<img style="vertical-align:middle;" src="'.$base_url.'assets/smiley/images/smileys/'.$result.'" height="20" width="20" />', $comment);
		}	
}

$msg_id = mysqli_real_escape_string($con, f($_POST['msg_id'],'escapeAll'));
$time = time();

$member_sql = mysqli_query($con, "select * from members where member_id='$member_id'");
$member_res = mysqli_fetch_array($member_sql);

mysqli_query($con, "INSERT INTO postcomment (post_member_id,msg_id,content, type, date_created)
VALUES('$member_id','$msg_id','$comment','1','$time')");


$last_id2 = mysqli_insert_id($con);
if(isset($_SESSION['lang']))
{
?>
<script>
var lan1="<?php echo $_SESSION['lang'];?>";
//alert(lan1);
var text1="<?php echo $comment;?>";
//call(lan1,text1);
//function call(lan1,text1)

var g_token = '';
var lan =lan1;
//alert(lan);
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
     
			translate1232<?php echo $last_id2;?>(g_token,src,lan);
			//alert(lan);
			},    
    });

	
		
		
function translate1232<?php echo $last_id2;?>(g_token,src1,lan)

	{
		 var language1="<?php echo $_SESSION['lang'];?>";
	
		var src = src1;
		
		var p = new Object;
		
    p.text = src;
    p.from = null;
    p.to = "" + language1 + "";
    //alert(language1);
    p.oncomplete = 'ajaxTranslate3<?php echo $last_id2;?>';
    p.appId = "Bearer " + g_token;
   
    var requestStr = "http://api.microsofttranslator.com/V2/Ajax.svc/Translate";
       $.ajax({
        url: requestStr,
        type: "GET",
        data: p,
        dataType: 'jsonp',
        cache: 'true',
       
		});
	}	
		
	function ajaxTranslate3<?php echo $last_id2;?>(response) { 
		//alert(response);
		 document.getElementById("target_tr_cm<?php echo $last_id2;?>").innerHTML = response;

	}
    
    </script>
    <?php
    }
$langs=array("","hi","ar","bg","ca","cs","da","nl","et","fi","fr","zh-CHS","zh-CHT","de","el","ht","he","mww","hu","id","it","ja","tlh","ko","lv","lt","ms","mt","no","fa","pl","pt","ro","ru","sk","sl","es","sv","th","tr","uk","ur","vi","cy");

//$language="hi";
?>
<?php
$z=0;
for($z==0;$z<=43;$z++)
{


$language = $langs[$z];

?>


<?php //include "../test_comment.php"; 
}
?>


<?php 

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
$subject = "".ucfirst($member_res['username']). " " .$lang['commented on your status'];

$mailTitle="";
$htmlbody = " 
        	<div style='width:100px;float:left;border:1px solid #ddd;'>
        		<a href='".$base_url.$member_res['username']."' title='".$member_res['username']."' target='_blank' style='text-decoration:none;'><img style='width:100%;' alt='".$member_res['username']."' title='".$member_res['username']."' src='".$base_url.$member_res['profImage']."' /></a>
        	</div> 
        	<div style='float:left;padding:15px;'>
        		<div>
        			<a href='".$base_url.$member_res['username']."' title='".$member_res['username']."' target='_blank' style='text-decoration:none;color:#085D93;'>".$member_res['username']." commented on your status</a>
        		</div>
        		";
if($comment != ''){	
$htmlbody .="<div>wrote: ".$comment."</div>";
}


$obj = new QBEMAIL(); 
$mail=$obj->send_email($to,$subject,'',$mailTitle,$htmlbody,'');

/************************************* end mail function ***********************************/

} 
$sql = mysqli_query($con, "select * FROM postcomment p,members m  WHERE p.post_member_id=m.member_id and p.msg_id = '$msg_id' order by comment_id desc");
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
<a href="<?php echo $base_url.$res['username'];?>"><img src="<?php echo $base_url.$res['profImage']; ?>" class='small_face'/></a>
</div> 
<div class="stcommenttext">
<?php 
if($_SESSION['SESS_MEMBER_ID'] == $res['member_id'])
{
?>
<a class="stcommentdelete" href="#" id='<?php echo $res['comment_id']; ?>' title='<?php echo $lang['Delete Comment'];?>'></a>
<?php } ?>
<a href="<?php echo $base_url.$res['username'];?>"><b><?php echo $res['username']; ?></b> </a>
<br />
<?php 
if($res['type']==1)
{ 
if(isset($_SESSION['lang']))
	{	
		
		?>
        <div id="target_tr_cm<?php echo $last_id2;?>"></div>
        <?php
		
	}
	
	else
	{
		echo "<div>".$res['content']."</div>";
		
	}


	?>
	
	<div id="translatemenu<?php echo $res['comment_id'];?>" class="translatemenu" style="display:none; position:absolute;margin-left: 34%; "> <select id="langs<?php echo $res['comment_id'];?>" class="langs" onchange="selectOption(this.value, <?php echo $res['comment_id'];?>,1)">
            <option value=""><?php echo $lang['select language'];?></option> 
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
</div>
<!--like block-->
<div>
<?php
$sql = mysqli_query($con, "SELECT * FROM comment_like WHERE comment_id='". $res['comment_id'] ."'");
$comment_like_count = mysqli_num_rows($sql);

$comment_like_query1 = mysqli_query($con, "SELECT m.username,m.member_id FROM comment_like c, members m WHERE m.member_id=c.member_id 
AND c.comment_id='".$res['comment_id']."' AND c.member_id='".$_SESSION['SESS_MEMBER_ID']."' ");
$comment_like_res1 = mysqli_num_rows($comment_like_query1);
if($comment_like_res1==1)
{
$comment_like_query = mysqli_query($con, "SELECT m.username,m.member_id FROM comment_like c, members m WHERE m.member_id=c.member_id 
AND c.comment_id='".$res['comment_id']."' AND c.member_id!='".$_SESSION['SESS_MEMBER_ID']."' LIMIT 2");
$clike_count = mysqli_num_rows($comment_like_query);
$new_clike_count=$comment_like_count-2; 
}
else
{
$comment_like_query = mysqli_query($con, "SELECT m.username,m.member_id FROM comment_like c, members m WHERE m.member_id=c.member_id 
AND c.comment_id='".$res['comment_id']."' LIMIT 3");
$clike_count = mysqli_num_rows($comment_like_query);
$new_clike_count=$comment_like_count-3; 
}

?>
<div class="clike" id="clike<?php echo $res['comment_id'];?>" style="display:<?php if($comment_like_count <= 0) { echo 'none'; } else { echo 'block'; }?>">
<?php 

if($comment_like_res1==1)
{?><span id="you<?php echo $res['comment_id'];?>"><?php echo $lang['You'];?><?php if($comment_like_count>1)
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
	
if($i <> $clike_count) { echo ',';}
 
} 
if($clike_count > 3) {
?>
 <?php echo $lang['and'];?><span id="like_count<?php echo $res['comment_id'];?>" class="numcount"><?php echo $new_clike_count;?></span> <?php echo $lang['others'];?><?php } ?> <?php echo $lang['like this'];?>.</div> 
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
$cdquery = "SELECT * FROM comment_dislike WHERE comment_id='". $res['comment_id'] ."'";
$cdsql  = mysqli_query($con, $cdquery) or die(mysqli_error($con));
$comment_dislike_count = mysqli_num_rows($cdsql);

$cdquery1 = mysqli_query($con, "SELECT m.username,m.member_id FROM comment_dislike c, members m WHERE 
m.member_id=c.member_id 
AND c.comment_id='".$res['comment_id']."' LIMIT 3");
?>
<span id="dislikecout_container<?php echo $res['comment_id'];?>" style="display:<?php if($comment_dislike_count <= 0) { echo 'none'; } else { echo 'block'; }?>">
<span id="dislikecout<?php echo $res['comment_id'];?>">
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
$comment_like = mysqli_query($con, "select * from comment_like where comment_id = '".$res['comment_id']."' and member_id = '".$member_id."'");
if(mysqli_num_rows($comment_like) > 0)
{
	echo '<a href="javascript: void(0)" class="comment_like show_cmt_linkClr" id="comment_like'.$res['comment_id'].'" msg_id = '.$msg_id.' title="'.$lang['Unlike'].'" rel="Unlike">'.$lang['Unlike'].'</a>';
} 
else 
{ 
	echo '<a href="javascript: void(0)" class="comment_like show_cmt_linkClr" id="comment_like'.$res['comment_id'].'" msg_id = '.$msg_id.' title="'.$lang['Like'].'" rel="Like">'.$lang['Like'].'</a>';
}
?>
</span>
<!-- End of like button -->

<!-- Dislike button -->
<span style="top:2px; padding-left:5px;">
<span class="mySpan_dot_class"> · </span>
<?php
$cdquery1 = "SELECT * FROM comment_dislike WHERE comment_id='". $res['comment_id'] ."' and member_id = '".$member_id."'";
$cdsql1  = mysqli_query($con, $cdquery1) or die(mysqli_error($con));
$comment_dislike_count1 = mysqli_num_rows($cdsql1);
if($comment_dislike_count1 > 0) {
echo '<a href="javascript: void(0)" class="comment_dislike show_cmt_linkClr" id="comment_dislike'.$res['comment_id'].'" title="'.$lang['dislike'].'" rel="disLike">'.$lang['dislike'].'</a>';
} else {
echo '<a href="javascript: void(0)" class="comment_dislike show_cmt_linkClr" id="comment_dislike'.$res['comment_id'].'" title="'.$lang['dislike'].'" rel="disLike">'.$lang['dislike'].'</a>';
}
?>
</span> 
<!-- End of dislike  button -->
<!-- Reply Button -->
<span style="top:2px; margin-left:5px;">
<span class="mySpan_dot_class"> · </span>
<a href="" id="<?php echo $res['comment_id'];?>" class="replyopen show_cmt_linkClr"><?php echo $lang['Reply'];?></a>
</span>
<!-- <?php if($res['type']==1){?><span style="top:2px; left:3px;"><a class="translatebutton" onclick="translateSourceTarget(<?php echo $res['comment_id'];?>);" href="javascript:void(0)" >Translate </a> </span><?php } ?> -->

<?php if($res['type']==1)
{ ?>

<span style="top:2px; margin-left:3px;" > 
<span class="mySpan_dot_class"> · </span>
<a class="translateButton show_cmt_linkClr" href="javascript:void(0);" id="translateButton<?php echo $res['comment_id'];?>"  ><?php echo  $lang['Translate'];?></a></span>
<script>
$(document).ready(function () {

    $('#translateButton<?php echo $res['comment_id'];?>').click(function (event) {
        var ID = $(this).attr('id');
        var sid = ID.split("translateButton");
        var New_ID = sid[1];
        var optionss = 1;
        fillList(Microsoft.Translator.Widget.GetLanguagesForTranslateLocalized(), New_ID, optionss);        
        $('#translatemenu' + New_ID).toggle(300);
        event.stopPropagation();
    });
    });
</script> 
     
<?php 
} ?>


<!--View more reply-->
<?php
$query12  = mysqli_query($con, "SELECT * FROM comment_reply WHERE comment_id=" . $res['comment_id'] . " ORDER BY reply_id DESC");
$records1 = mysqli_num_rows($query12);
$p = mysqli_query($con, "SELECT * FROM comment_reply WHERE comment_id=" . $res['comment_id'] . " ORDER BY reply_id DESC limit 2,$records1");
$q = mysqli_num_rows($p);
if ($records1 > 2)
{
	$collapsed1 = true;?>
    <input type="hidden" value="<?php echo $records1?>" id="replytotals-<?php  echo $res['comment_id'];?>" />
	<div class="replyPanel" id="replycollapsed-<?php  echo $res['comment_id'];?>" align="left">
	<img src="images/cicon.png" style="float:left;" alt="" />
	<a href="javascript: void(0)" class="ViewReply">
	<?php  echo $lang['View'];?> <?php echo $q;?> <?php  echo $lang['more replys'];?>
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
$reply_sql  = mysqli_query($con, "SELECT * FROM comment_reply c,members m WHERE c.member_id = m.member_id and comment_id=" . $res['comment_id'] . " ORDER BY reply_id DESC limit 0,2");

while($reply_res = mysqli_fetch_assoc($reply_sql))
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
 
 if($res['member_id'] <> $reply_res['member_id'])
 {
	 echo '@'; 
	?> <a href="<?php echo $base_url.$res['username'];?>"><b><?php echo $res['username']; ?> 
	<br />
 
 </b></a>
	 
<?php
 }
   ?> 
 
<br />
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
<div class="rlike" id="rlike<?php echo $res['comment_id'];?>" style="display:<?php if($reply_like_count <= 0) { echo 'none'; } else { echo 'block'; }?>">
<?php 

if($reply_like_count == 1)
{?><span id="you<?php echo $res['comment_id'];?>"><?php echo $lang['You'];?><?php if($reply_like_count>1)
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
 <?php echo $lang['and'];?><span id="rlike_count<?php echo $reply_res['reply_id'];?>" class="rnumcount"><?php echo $new_rlike_count;?></span> <?php echo $lang['others'];?><?php } ?> <?php echo $lang['like this'];?>.</div> .</div> 

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
echo '<a href="javascript: void(0)" class="reply_dislike show_cmt_linkClr" id="reply_dislike'.$reply_res['reply_id'].'" title="'.$lang['dislike'].'" rel="disLike">'.$lang['dislike'].'</a>';
} else {
echo '<a href="javascript: void(0)" class="reply_dislike show_cmt_linkClr" id="reply_dislike'.$reply_res['reply_id'].'" title="'.$lang['dislike'].'" rel="disLike">'.$lang['dislike'].'</a>';
}
?>
</span> 
<!-- End of dislike  button -->
<!-- Reply Button -->
<span style="top:2px; margin-left:5px;">
<span class="mySpan_dot_class"> · </span>
<a href="" id="<?php echo $reply_res['reply_id'];?>" class="reply-replyopen show_cmt_linkClr"><?php echo $lang['Reply']; ?></a>
</span>
<?php if($res['type']==1)
{ ?>
<span style="top:2px; margin-left:3px;" > 
<span class="mySpan_dot_class"> · </span>
<a class="translateButton show_cmt_linkClr" href="javascript:void(0);" id="translateButton<?php echo $res['comment_id'];?>"  ><?php echo  $lang['Translate'];?></a></span>
       
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
<a href="<?php echo $base_url.$reply_r_res['username'];?>"><img src="<?php echo $base_url.$reply_r_res['profImage']; ?>" class='small_face'/></a>
</div>

<div class="reply-reply-text">
 <?php 
if($_SESSION['SESS_MEMBER_ID'] == $reply_r_res['member_id'])
{
?>
<a class="reply-reply-delete" href="#" id='<?php echo $reply_r_res['reply_id']; ?>' title='<?php echo $lang['Delete Reply'];?>'></a>
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
 
<br />
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
<input type="submit" abcd="<?php echo $reply_res['member_id']; ?>"  title="<?php echo $reply_res['username']; ?>" value="<?php echo $lang["Reply"];?>"  id="<?php echo $reply_res['reply_id'];?>" class="reply-reply"/>
<input type="button"  value=" <?php echo $lang["Cancel"];?>"  onclick="closereplyreply('reply-reply-update<?php echo $reply_res['reply_id'];?>')" class="cancel"/>
</form>
</div>
</div>
<!--End replyupdate div	--> 
</div><!--End streplybody div-->
<?php } ?>

<!--Start replyupdate -->
<div class="replyupdate" style='display:none' id='replybox<?php echo $res['comment_id'];?>'>
<div class="streplyimg">
<img src="<?php echo $base_url.$res['profImage'];?>" class='small_face'/>
</div>

<div class="streplytext" >
<form method="post" action="">
<textarea name="reply" class="reply" maxlength="200"  id="rtextarea<?php echo $res['comment_id'];?>"></textarea>
<br /> 


<input type="submit" abcd="<?php echo $res['member_id']; ?>"  title="<?php echo $res['username']; ?>" value="<?php echo $lang["Reply"];?>"  id="<?php echo $res['comment_id'];?>" class="reply_button"/>
<input type="button"  value=" <?php echo $lang["Cancel"];?> "  id="<?php echo $res['messages_id'];?>" onclick="closereply('replybox<?php echo $res['comment_id'];?>')" class="cancel"/>
</form>
</div>
</div>
<!--End replyupdate div	--> 
</div><!--End replycontainer div-->
</div>
<?php
}?>

<?php
}
?>