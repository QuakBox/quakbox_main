<?php
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php'); 	 
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');
	//require_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_header.php');
	
	$objMember = new member1();
	$member_id = $QbSecurity->qbClean($_SESSION['SESS_MEMBER_ID'], $con);
	$member_id =htmlspecialchars(trim($member_id ));
	
	if(isset($_REQUEST['username'])) {$username = $QbSecurity->qbClean($_REQUEST['username'], $con);
	$username =htmlspecialchars(trim($username ));}else{$username = 0;}
	
	//if($QbSecurity->qbIntegerCheck($username)==0)
	if(!(empty($username)||($qbValidation->qbIntegerCheck($username))))
	{
		$qb_err_msg="Oops Something Went Wrong...!";
$QbSecurity->qbErrorMessage($qb_err_msg,$homepage);
	}
	else
	{
	$sql = mysqli_query($con, "select * from member where member_id='".$username."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql); 
	$msg_member_id = $res['member_id'];
	
	/*if(mysqli_num_rows($sql) == 0) {
		header('location: '.$base_url.'error.html');exit();
	}	*/
	
	$pagename = curPageName();
?>
<?php /*?><link rel="icon" href="<?php echo $base_url;?>images/favicon.ico" type="image" />
<link rel="shortcut icon" href="<?php echo $base_url;?>images/favicon.ico" type="image" />
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/style.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/responsive.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>font-awesome/css/font-awesome.css"/><?php */?>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/messages.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/group.css"/>
<script src="<?php echo $base_url;?>js/jquery.min.js"></script>
<script src="<?php echo $base_url;?>js/jquery-ui.min.js"></script>
<script  src="<?php echo $base_url;?>js/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>js/move-top.js"></script>
<script src="<?php echo $base_url;?>js/check.js"></script>
<script type="text/javascript">
//var base_url = "http://localhost/quakbox/";	
var base_url = "<?php  echo $base_url;?>";
$(document).ready(function()
{

	$("#reply_content").animate({"scrollTop": $('#reply_content')[0].scrollHeight}, "slow");
	var playlist_content_height = 570;

	$('.conversation_grid').scroll(function(eve){	
	var a=0;
	var s=$(document).height() - playlist_content_height;
    if(s>128)
    {
	s=128;
    }
	if ($('.conversation_grid').scrollTop() >= s){
		
		var ID=$(".conList:last").attr("rel");
		var dataString = 'last_time='+ ID ;
	    if(a == 0){
		list_more(dataString);
		a = 1;	
    	}
		
	}
	});
	
	
	var playlist_contentReply_height = 470;

	$('.conversationReply_grid').scroll(function(eve){	
	var a=0;
	var s=$(document).height() - playlist_contentReply_height;
    
	if ($('.conversationReply_grid').scrollTop() == 0){
		var b=0;
	    var C_ID=$('#cid').val();
		var ID=$(".reply_stbody:first").attr("id");
		var sid=ID.split("stbody"); 
		var New_ID=sid[1];
		var dataString = 'last_time='+ New_ID +'&c_id='+C_ID;
		console.log(dataString);
		
	    if(b == 0){
		list_more_reply(dataString,C_ID);
		b = 1;	
    	}

		
	}

	});
	
	$('#replylist_content').slimScroll({
	        height: playlist_content_height+'px'
	});

	$('#reply_content').slimScroll({
	        height: '440px'
	});
	
	//message reply ajax call
	
	$(".reply_button").live("click",function(){
		var A = $('#update').val();
		var member_id = $('#member_id').val();
		var msg_to = $('#msgto_member_id').val();
	     A = escape(A);
		var dataString = 'reply='+ A +'&member_id='+member_id + '&msgto_member_id=' + msg_to;
		    if($.trim(A).length>0)
		    {
			$.ajax({
			type: "POST",
			url: base_url + "load_data/conversation_ajax.php",
			data: dataString,
			cache: false,
			beforeSend: function(){$("#flash").html('<img src="wall_icons/ajaxloader.gif"  />'); },
			success: function(html)
			{	
			if(html)
			{
			//var B=$('#cid').val();
			 
			if(A.length > 20) 
			{
			A = A.substring(0,17);
			A+='...';
		    }
			
			//$('#reply'+B).html("<img src='https://labs.9lessons.info/wall_icons/send.png'  class='con_send'/>"+htmlEscape(A));
			$('#reply_content').append(html);
			$("#reply_content").animate({"scrollTop": $('#reply_content')[0].scrollHeight}, "slow");
			$('#flash').hide();	
			$('#update').val('');
			$('#update').focus();
          
			}
			else
			{

			}
			}
			});
		}
			return false;
	
	});
	
	
	//delete message
	$('.reply_stdelete').click(function() 
	{
	var ID = $(this).attr("id");
	var X = $(this).attr("my");
	var dataString = 'c_id='+ ID + '&member_id=' + X;

	confirm('<?php echo $lang['Sure you want to delete this conversation? There is NO undo'];?>!');
	
	$.ajax({
	type: "POST",
	url: "action/delete_conversion_ajax.php",
	data: dataString,
	cache: false,	
	success: function(html){	 
    window.location='messages.php';
	 }
	 });
	
	return false;
	});
		
	
});

function delmesg()
{
//alert('hi');
var numbofcheckboxes=$("#numbofcheckboxes").val();
var msg_member_id=$("#msg_member_id").val();
//alert(numbofcheckboxes);
var comp=new Array();
var checkedid=new Array();
var total=$(":checkbox:checked").length;

if(total <= 0){
	alert('You must select some messages to delete. Click on a message to select it.');
       return false;
   }

		if (confirm("<?php echo $lang['Sure you want to delete this conversation? There is NO undo'];?>!") == true) {	    
    
				for(var i=1;i<=numbofcheckboxes;i++)
				{
				  if($('#check_'+i).is(':checked'))
				  {
				    var val=$('#check_'+i).val();
				    comp.push(val);
				    checkedid.push(i);
				  }
				}
				//alert(comp);
				//alert("checkedid="+checkedid);
				$("#checkedvalues").val(comp);
				var val=$("#checkedvalues").val()
				//alert(val);
				$.ajax({
				type: "POST",
				url: "delmesg.php",
				data: {checkedid:val,msg_member_id:msg_member_id},
				cache: false,	
				success: function(html){
				 $('#vin').html(html);
			    //window.location='messages.php';
						    for(var i=0;i<checkedid.length;i++)
						    {
						    //alert(checkedid[i]);
						    $("#div_"+checkedid[i]).hide();
						    }
					    
				 }
				 });
				 
				 }
}


</script>
<div class="insideWrapper container">
    <div class="col-lg-9 col-md-9 col-sm-9"> 
    
<div id="border">

<!--start inbox-toolbar div-->
<!--<div class="inbox-toolbar">
<table width="100%" cellspacing="0" cellpadding="2" border="0" style="border-collapse:collapse; border-spacing:0px;">
<tbody>
<tr>
<td align="center" width="30">
<input id="checkall" class="checkbox" type="checkbox" onclick="checkAll();" name="select"></input>
</td>
<td>
<a href="javascript:void(0);" onclick="">Mark as Read</a>
<a href="javascript:void(0);" onclick="">Mark as Unread</a>
<a href="javascript:void(0);" onclick="">Delete Message</a>
</td>
</tr>
</tbody>
</table>
</div>--><!--end inbox-toolbar div-->
<!--start message body-->
<div id="main_left">
<div id="submenushead" style="float:none;">
    <ul class="dropDown">
    <li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="<?php echo $base_url;?>messages.php"><?php echo $lang['Inbox'];?></a></li>   	
    <li style="padding:0 8px;"><a href="<?php echo $base_url;?>write_message.php"><?php echo $lang['Write'];?></a></li>   
	</ul>
   </div>
<div class="some-content-related-div">
<div id="replylist_content" class="conversation_grid">
<?php
$msgfquery = "SELECT SQL_CALC_FOUND_ROWS
       u.member_id ,
       i.from,
       i.to,
       u.username ,
       i.sent,
       i.message,
       i.id
    FROM cometchat AS i,
         member  AS u,
         (SELECT MAX(id) AS id_max,
                 id_with
              FROM (
                    SELECT id,
                           c.from AS id_with
                        FROM cometchat c
                        WHERE c.to = '".$member_id."'
                    UNION ALL
                    SELECT id,
                           o.to
                        FROM cometchat o
                        WHERE o.from = '".$member_id."'
                   ) AS t
              GROUP BY id_with) AS m
    WHERE i.id  = m.id_max
      AND u.member_id = m.id_with
    ORDER BY i.id DESC";
			 
$msgfsql = mysqli_query($con, $msgfquery) or die(mysqli_error($con)); 
while($msgfres = mysqli_fetch_array($msgfsql)) {
if($msgfres['member_id']<>$member_id){ 
$media = $objMember->select_member_meta_value($msgfres['member_id'],'current_profile_image');
if(!$media)
$media = "images/default.png";
$media=$base_url.$media;
?>
<a class="con_name" href="<?php echo $base_url.'messages.php?username='.$msgfres['member_id'];?>">
<div class="conList" id="<?php echo $msgfres['id']; ?>" style="background-color:<?php if($pagename.'?username='.$msgfres['member_id'] == $pagename.'?username='.$msg_member_id){ echo '#A7D8EC';} ?>">
<span class="reply_stdelete" href="#" id="<?php echo $msgfres['member_id'];?>" original-title="Delete Update" my="<?php echo $member_id;?>"></span>
<img src='<?php echo $media;?>' class='cimg'>
<span class='cname'><?php echo $msgfres['username'];?></span>
<br />
<span id='reply1822' class='reply'>	
<?php if($msgfres['from'] == $member_id && $msgfres['to'] == $msgfres['member_id']){?>
<img src='<?php echo $base_url;?>images/send.png'  class='con_send'/>	
<?php }?>
<span><?php 
$string=$msgfres['message'];
$replacedAnchorTag=preg_replace_callback('/<\/?a[^>]*>/',function($space)
	{
	$space='';
	return $space;},$string);
 $msglen = strlen($replacedAnchorTag); if($msglen > 20) { echo substr($replacedAnchorTag,0,17).'...';}else {echo $replacedAnchorTag;}
?></span>
</span>
<br />
<span  class="sttime timeago con_time" title=""><?php echo time_stamp($msgfres['sent']);?></span>
</div>
</a>
<?php }} ?>
</div>
</div>
</div><!--end main right-->

<div id="main_right">
<h2 style="font-size:16px;"><a href="<?php echo $base_url.$res['username']; ?>"><?php echo $res['username']; ?></a></h2>
<div class="some-content-related-div">
<?php if(isset($_REQUEST['username'])){?>
<div align='center' style="background: url("../images/delete.png") no-repeat scroll 0 0 rgba(0, 0, 0, 0); cursor: pointer;float: right;font-weight: bold; height: 14px;width:14px;" original-title="Delete Update" href="#"><?php echo $lang['delete selected messages'];?>&nbsp <img src="images/delete.png" onclick="delmesg()"/></div>
<?php } ?>
<div id='vin' style="display:none"></div>
<div id="reply_content" class='conversationReply_grid'>
<?php
$msgquery = "select msg.read,msg.id,m.username,msg.from,msg.to, msg.message,msg.sent,m.member_id from cometchat msg,member m WHERE msg.from = m.member_id AND (msg.from ='$msg_member_id' OR msg.to ='$msg_member_id') ORDER BY msg.id";
$msgsql = mysqli_query($con, $msgquery) or die(mysqli_error($con));
$checkboxlength=0;
$divid=0;

$msg_count = mysqli_num_rows($msg_sql);
if(isset($_REQUEST['username']))
{ 
while($mres = mysqli_fetch_array($msgsql)) {
	if(($mres['from'] == $member_id and $mres['to'] == $msg_member_id) or ($mres['to'] == $member_id and $mres['from'] == $msg_member_id)) {
$media2 = $objMember->select_member_meta_value($mres['member_id'],'current_profile_image');
if(!$media2)
$media2 = "images/default.png";
$media2=$base_url.$media2;
?>
<div class="reply_stbody" id="div_<?php echo ++$divid;?>">
<div class="reply_stimg">
<a href="<?php echo $base_url.$mres['username'];?>"><img src="<?php echo $media2;?>" class="big_face" alt="<?php echo $mres['username'];?>"></a>

</div> 

<div class="reply_sttext">
<?php //echo $mres['id'];?> 
<b><a href="<?php echo $base_url.$mres['username'];?>" class="pname"><?php echo $mres['username'];?></a></b>

<?php echo $mres['message'];?><div class="reply_sttime"> <span class="timeago" title=""><?php echo time_stamp($mres['sent']);?></span>
<input type="checkbox" id="check_<?php echo ++$checkboxlength;?>" name="del_msg[]" value="<?php echo $mres['id'];?>" />
</div> 
</div>
</div>
<?php } } 
}else {
?>
<b><?php echo $lang['No conversation selected'];?>.</b>

<?php } ?>

<input type="hidden" id="numbofcheckboxes" value="<?php echo $checkboxlength;?>">
<input type="hidden" id="checkedvalues" >
<input type="hidden" id="msg_member_id" value="<?php echo $msg_member_id;?>">
</div>
<?php if(isset($_REQUEST['username'])){?>
<div id="updateboxarea">
<h5><?php echo $lang['write a reply'];?>...</h5>
<input type="hidden" id="msgto_member_id" name="msgto_member_id" value="<?php echo $msg_member_id;?>">
<input type="hidden" id="member_id" name="member_id" value="<?php echo $member_id;?>">
<textarea name="message_body" id="update"></textarea>
<input type="submit" value="<?php echo $lang['Reply'];?> " id="update_button" class="reply_button wallbutton update_box" style="margin-top: 10px;"/> 

</div>
<?php } ?>
</div>
</div><!--end main left-->
<!--end message body-->

</div><!--end border div-->

</div><!--end column_left div-->

<!--Start column right-->
    <div class="col-lg-2 col-md-2 col-sm-3 hidden-xs"> 
        <div style="" class="adsQBxzqw"> <?php include($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/ads.php');?></div>
    </div>
<!--end column_right div-->

</div><!--end mainbody div-->
<?php
	include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_footer.php');
	}
?>