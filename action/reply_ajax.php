<?php ob_start();
if(!isset($_SESSION)){
session_start();
}

error_reporting(-1);
include_once '../config.php';

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
		include($root_folder_path.'public_html/common.php');
	}
	else
	{		
		include($root_folder_path.'public_html/Languages/en.php');		
	}

include_once($root_folder_path.'public_html/includes/time_stamp.php');


$member_id = $_SESSION['SESS_MEMBER_ID'];
$reply = f($_POST['reply'],'escapeAll');
$reply = mysqli_real_escape_string($con, $reply);
$comment_id = f($_POST['comment_id'],'escapeAll');
$comment_id = mysqli_real_escape_string($con, $comment_id);
$uname = f($_POST['uname'],'escapeAll');
$uname = mysqli_real_escape_string($con, $uname);
$mem_id = f($_POST['mem_id'],'escapeAll');
$mem_id = mysqli_real_escape_string($con, $mem_id);

mysqli_query($con, "INSERT INTO comment_reply (member_id,comment_id,content, date_created)
VALUES('$member_id','$comment_id','$reply','".strtotime(date("Y-m-d H:i:s"))."')");

$last_id3=mysqli_insert_id($con);
if(isset($_SESSION['lang']))
{
?>
<script>
var lan1="<?php echo $_SESSION['lang'];?>";
var text1="<?php echo $reply ;?>";
call(lan1,text1);
function call(lan1,text1)
{
var g_token = '';
var lan =lan1;
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
    
    
			translate1233(g_token,src,lan);
			
			},    
    });

	
		}
		
function translate1233(g_token,src1,lan)
	{
		 var language=lan;
	
		var src = src1;
		
		var p = new Object;
		
    p.text = src;
    p.from = null;
    p.to = "" + language + "";
    p.oncomplete = 'ajaxTranslate1<?php echo $last_id3;?>';
    p.appId = "Bearer " + g_token;
   
    var requestStr = "https://api.microsofttranslator.com/V2/Ajax.svc/Translate";
       $.ajax({
        url: requestStr,
        type: "GET",
        data: p,
        dataType: 'jsonp',
        cache: 'true',
       
		});
	}	
		
	function ajaxTranslate1<?php echo $last_id3;?>(response) { 
		
		
		 document.getElementById("target_tr_reply<?php echo $last_id3;?>").innerHTML = response;

	}
    
    </script>
    <?php
}


$langs=array("","hi","ar","bg","ca","cs","da","nl","et","fi","fr","zh-CHS","zh-CHT","de","el","ht","he","mww","hu","id","it","ja","tlh","ko","lv","lt","ms","mt","no","fa","pl","pt","ro","ru","sk","sl","es","sv","th","tr","uk","ur","vi","cy");

//$language="hi";
for($y=0;$y<=43;$y++)
{
$language=$langs[$y];

?>
<?php include "../test_reply.php"; }?>


<?php 




$sql = mysqli_query($con, "select * from comment_reply a JOIN members m ON m.member_id = a.member_id where comment_id = '$comment_id' order by reply_id desc");
$res = mysqli_fetch_array($sql);
if ($res)
{
$_SESSION['reply_id_id']=$res['reply_id'];

	$com_id = $res['reply_id'];	
	$comment = $res['content'];
	$time = $res['date_created'];
	$username = $res['username'];
	$cface = $res['profImage'];
?>
<div class="streplybody" id="streplybody<?php echo $res['reply_id']; ?>">
<div class="stcommentimg">
<a href="<?php echo $base_url.$row['username'];?>"><img src="<?php echo $base_url.$res['profImage']; ?>" class='small_face'/></a>
</div>
<div class="streplytext">
 <?php 
if($_SESSION['SESS_MEMBER_ID'] == $res['member_id'])
{
?>
<a class="streplydelete" href="#" id='<?php echo $res['reply_id']; ?>' title='<?php echo $lang['Delete Reply'];?>'></a>
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
   
   <br />
 <?php 
if(isset($_SESSION['lang']))
	{	
		
		?>
        <div id="target_tr_reply<?php echo $last_id3;?>"></div>
        <?php
		
	}
	
	else
	{
		echo $res['content'];
		
	}
?>
<br />

<div class="replytarget" style="font:bold;" id="replytarget<?php echo $res['reply_id'];?>" style="display: block; margin: 3px 0px 3px 1px;"></div>
<div class="sttargettime" style="margin-top: 10px; margin-bottom: -13px;"><?php time_stamp($res['date_created']); ?></div><div tabindex="1" id="replytranslatemenu<?php echo $res['reply_id'];?>" class="replytranslatemenu" style="display:none; position:absolute;margin-left: 34%; "> <select id="replylangs<?php echo $res['reply_id'];?>" class="postlangs" onchange="selectOption(this.value, <?php echo $res['reply_id'];?>,3)">
            <option value=""><?php echo $lang['select language'];?></option> 
            </select>
            </div> 
<span style="padding-left:5px;">
<!--like block-->
<div>
<?php
$reply_like_query = mysqli_query($con, "SELECT * FROM reply_like WHERE reply_id='". $res['reply_id'] ."'");
$reply_like_count = mysqli_num_rows($reply_like_query);

$reply_like_query1 = mysqli_query($con, "SELECT m.username,m.member_id 
								  FROM reply_like c, members m 
								  WHERE m.member_id = c.member_id 
								  AND c.reply_id = '".$res['reply_id']."' 
								  AND c.member_id = '".$_SESSION['SESS_MEMBER_ID']."' ");
$reply_like_count = mysqli_num_rows($reply_like_query1);
if($reply_like_count == 1)
{
$reply_like_query2 = mysqli_query($con, "SELECT m.username,m.member_id 
								  FROM reply_like c, members m 
								  WHERE m.member_id=c.member_id 
								  AND c.reply_id='".$res['reply_id']."' 
								  AND c.member_id!='".$_SESSION['SESS_MEMBER_ID']."' LIMIT 2");
$rlike_count = mysqli_num_rows($reply_like_query2);
$new_rlike_count = $reply_like_count - 2; 
}
else
{
$reply_like_query2 = mysqli_query($con, "SELECT m.username,m.member_id 
                                 FROM reply_like c, members m 
								 WHERE m.member_id=c.member_id 
								 AND c.reply_id='".$res['reply_id']."' LIMIT 3");
$rlike_count = mysqli_num_rows($reply_like_query2);
$new_rlike_count=$reply_like_count - 3; 
}

?>
<div class="rlike" id="rlike<?php echo $res['reply_id'];?>" style="display:<?php if($reply_like_count <= 0) { echo 'none'; } else { echo 'block'; }?>">
<?php 

if($reply_like_count == 1)
{?><span id="you<?php echo $res['reply_id'];?>"><?php echo $lang['You'];?><?php if($reply_like_count>1)
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
	
if($i <> $rlike_count) { echo ',';}
 
} 
if($rlike_count > 3) {
?>
 <?php echo $lang['and'];?> <span id="rlike_count<?php echo $res['reply_id'];?>" class="rnumcount"><?php echo $new_rlike_count;?></span> <?php echo $lang['others'];?> <?php } ?> <?php echo $lang['like this'];?>. </div>
 

</div>
<!--end like block-->

<!--dislie block-->
<div>
<?php
$rdquery = "SELECT * FROM reply_dislike WHERE reply_id='". $res['reply_id'] ."'";
$rdsql  = mysqli_query($con, $rdquery) or die(mysqli_error($con));
$reply_dislike_count = mysqli_num_rows($rdsql);

$rdquery1 = mysqli_query($con, "SELECT m.username,m.member_id FROM comment_dislike c, members m WHERE m.member_id=c.member_id 
AND c.comment_id='".$res['reply_id']."'");
?>
<span id="rdislikecout_container<?php echo $res['reply_id'];?>" style="display:<?php if($reply_dislike_count <= 0) { echo 'none'; } else { echo 'block'; }?>">
<span id="rdislikecout<?php echo $res['reply_id'];?>">
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
$reply_like = mysqli_query($con, "select like_id from reply_like where reply_id = '".$res['reply_id']."' and member_id = '".$member_id."'");
if(mysqli_num_rows($reply_like) > 0)
{
	echo '<a href="javascript: void(0)" class="reply_like show_cmt_linkClr" id="reply_like'.$res['reply_id'].'"  title="'.$lang['Unlike'].'" rel="Unlike">'.$lang['Unlike'].'</a>';
} 
else 
{ 
	echo '<a href="javascript: void(0)" class="reply_like show_cmt_linkClr" id="reply_like'.$res['reply_id'].'"  title="'.$lang['like'].'" rel="Like">'.$lang['like'].'</a>';
}
?>
</span>
<!-- End of like button -->
<!-- Dislike button -->
<span style="top:2px; padding-left:5px;">
<span class="mySpan_dot_class"> · </span>
<?php
$reply_dislike_query = "SELECT dislike_reply_id FROM reply_dislike WHERE reply_id='". $res['reply_id'] ."' and member_id = '".$member_id."'";
$reply_dislike_sql  = mysqli_query($con, $reply_dislike_query) or die(mysqli_error($con));
$reply_dislike_count = mysqli_num_rows($reply_dislike_sql);
if($reply_dislike_count > 0) {
echo '<a href="javascript: void(0)" class="reply_dislike show_cmt_linkClr" id="reply_dislike'.$res['reply_id'].'" title="'.$lang['dislike'].'" rel="disLike">'.$lang['dislike'].'</a>';
} else {
echo '<a href="javascript: void(0)" class="reply_dislike show_cmt_linkClr" id="reply_dislike'.$res['reply_id'].'" title="'.$lang['Undislike'].'" rel="disLike">'.$lang['Undislike'].'</a>';

}
?>
</span> 
<!-- End of dislike  button -->
<span style="top:2px; margin-left:5px;">
<span class="mySpan_dot_class"> · </span>
<a href="" id="<?php echo $res['reply_id'];?>" class="reply-replyopen show_cmt_linkClr"><?php echo $lang['Reply'];?></a>
</span>
<span style="top:2px; margin-left:3px;" >
<span class="mySpan_dot_class"> · </span>
 <a class="replytranslateButton show_cmt_linkClr" href="javascript:void(0);" id="replytranslateButton<?php echo $res['reply_id'];?>"  ><?php echo $lang['Translate']; ?></a></span>
<div class="reply-reply-update" style='display:none' id='reply-reply-update<?php echo $res['reply_id'];?>'>
<div class="streplyimg">
<img src="<?php echo $base_url.$res['profImage'];?>" class='small_face'/>
</div>

<div class="reply-reply-text" >
<form method="post" action="">
<textarea name="reply" class="reply-reply" maxlength="200"  id="reply-reply<?php echo $res['reply_id'];?>"></textarea>
<br /> 
<input type="submit" abcd="<?php echo $res['member_id']; ?>"  title="<?php echo $res['username']; ?>" value="<?php echo $lang['Reply'];?>"  id="<?php echo $res['reply_id'];?>" class="reply-reply reply_reply_button""/>
<input type="button"  value=" Cancel"  onclick="closereplyreply('reply-reply-update<?php echo $res['reply_id'];?>')" class="cancel"/>
</form>
</div>
</div>
<div tabindex="1" id="replytranslatemenu<?php echo $res['reply_id'];?>" class="replytranslatemenu" style="display:none; position:absolute;margin-left: 34%; "> <select id="replylangs<?php echo $res['reply_id'];?>" class="postlangs" onchange="selectOption(this.value, <?php echo $res['reply_id'];?>,3)">
            <option value=""><?php echo $lang['select language'];?></option> 
            </select>
            </div> 
            
<textarea class="replysource" id="replysource<?php echo $res['reply_id'];?>"  style="display:none;"><?php echo $res['content'];?></textarea>


<!--
<?php if($row1['type']==1)
{ ?><?php 
} ?>
-->
       



</div><!--End streplytext div-->
<!--reply@reply-->
<div class="replycontainer" style="margin-left:40px;" id="reply-reply-load<?php echo $res['reply_id'];?>">
<?php
$reply_r_sql  = mysqli_query($con, "SELECT m.username,m.member_id,m.profImage,
						   a.content, a.date_created,a.id
						   FROM reply_reply a 
						   LEFT JOIN members m ON a.member_id = m.member_id 
						   WHERE reply_id=" . $res['reply_id'] . " 
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
<a class="reply-reply-delete" href="#" id='<?php echo $reply_r_res['reply_id']; ?>' title='<?php echo $lang['Delete Reply']; ?>'></a>
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
<div class="reply-reply-update" style='display:none' id='reply-reply-update<?php echo $res['reply_id'];?>'>
<div class="streplyimg">
<img src="<?php echo $base_url.$res['profImage'];?>" class='small_face'/>
</div>

<div class="reply-reply-text" >
<form method="post" action="">
<textarea name="reply" class="reply-reply" maxlength="200"  id="reply-reply<?php echo $res['reply_id'];?>"></textarea>
<br /> 
<input type="submit" abcd="<?php echo $res['member_id']; ?>"  title="<?php echo $res['username']; ?>" value="<?php echo $lang["Reply"];?>"  id="<?php echo $res['reply_id'];?>" class="reply-reply"/>
<input type="button"  value="<?php echo $lang['Cancel']; ?>"  onclick="closereplyreply('reply-reply-update<?php echo $res['reply_id'];?>')" class="cancel"/>
</form>
</div>
</div>
<!--End replyupdate div	--> 
</div>
<?php
}

?>
<div id="<?php echo $res['reply_id'];?>">
<script>
$(document).ready(function () {

$('#replytranslateButton<?php echo $res['reply_id'];?>').click(function (event) {
	
        var ID = $(this).attr('id');
        var sid = ID.split("replytranslateButton");
        var New_ID = sid[1];
        
        var optionss = 3;
        fillList(Microsoft.Translator.Widget.GetLanguagesForTranslateLocalized(), New_ID, optionss);        
        $('#replytranslatemenu' + New_ID).toggle(300);
        event.stopPropagation();
    });
     });
     </script>
</div>
<?php }?>