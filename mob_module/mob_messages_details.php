<?php 

	require_once('common/common.php');
	$member_id = $_SESSION['SESS_MEMBER_ID'];
	//$group_id = $_REQUEST['message_id'];
	
	if(isset($_REQUEST['username'])) {
	$username = $_REQUEST['username'];
	$username =htmlspecialchars(trim($username ));
	
	$sql = mysql_query("select * from members where member_id='".$username."'") or die(mysql_error());
	$res = mysql_fetch_array($sql); 
	$msg_member_id = $res['member_id'];
	
	}
	/*if(mysql_num_rows($sql) == 0) {
		header('location:error.html');
	}	*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $lang['My Messages'];?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="<?php echo $base_url;?>images/favicon.ico" type="image" />
<link rel="shortcut icon" href="<?php echo $base_url;?>images/favicon.ico" type="image" />
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/style.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/group.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/messages.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/responsive.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>font-awesome/css/font-awesome.css"/>
<link type="text/css" href="/cometchat/cometchatcss.php" rel="stylesheet" charset="utf-8">
<script type="text/javascript" src="/cometchat/cometchatjs.php" charset="utf-8"></script>
<script src="<?php echo $base_url;?>js/jquery.min.js"></script>
<script src="<?php echo $base_url;?>js/jquery-ui.min.js"></script>
<script  src="<?php echo $base_url;?>js/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>js/move-top.js"></script>
<script>

</script>
<script type="text/javascript">
$(window).scroll(function(){

if($(window).scrollTop()>300)
{

$("#ads_1").hide();
$("#ads_2").hide(); 


$(".column_internal_right").stop().css({"marginTop": ($(window).scrollTop()) + "px", "marginLeft":($(window).scrollLeft()) + "px"}, "slow" );
}
if($(window).scrollTop()<300)
{

$("#ads_1").show();

$("#ads_2").show();

$(".column_internal_right").stop().css({"marginTop": ($(window).scrollTop()) + "px", "marginLeft":($(window).scrollLeft()) + "px"}, "slow" );
}
}); 


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
</head>
<body>
<div id="wrapper">
<?php include('includes/header.php');?>
<div id="mainbody">
<div class="column_left">
	
    <div class="componentheading">
    <div id="submenushead"><?php echo $lang['My Messages'];?></div>
    </div>
    <div id="submenushead">
    <ul class="dropDown">
    <li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="<?php echo $base_url;?>mob_messages.php"><?php echo $lang['Inbox'];?></a></li>   	
    <li style="padding:0 8px;"><a href="<?php echo $base_url;?>write_message.php"><?php echo $lang['Write'];?></a></li>   
	</ul>
   </div>
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
<!--end main right-->

<div id="main_right">
<div class="some-content-related-div">
<div align='center' style="background: url("../images/delete.png") no-repeat scroll 0 0 rgba(0, 0, 0, 0); cursor: pointer;float: right;font-weight: bold; height: 14px;width:14px;" original-title="Delete Update" href="#"><?php echo $lang['delete selected messages'];?>&nbsp<img src="../images/delete.png" onclick="delmesg()"/></div>
<div id='vin' style="display:none">vinod</div>
<div id="reply_content" class='conversationReply_grid'>
<?php
$msgquery = "select msg.read,msg.id,m.profImage,m.username,msg.from,msg.to, msg.message,msg.sent,m.member_id from cometchat msg,members m WHERE msg.from = m.member_id AND (msg.from ='$msg_member_id' OR msg.to ='$msg_member_id') ORDER BY msg.id";
$msgsql = mysql_query($msgquery) or die(mysql_error());
$checkboxlength=0;
$divid=0;

$msg_count = mysql_num_rows($msg_sql);
if(isset($_REQUEST['username']))
{ 
while($mres = mysql_fetch_array($msgsql)) {
	if(($mres['from'] == $member_id and $mres['to'] == $msg_member_id) or ($mres['to'] == $member_id and $mres['from'] == $msg_member_id)) {
?>
<div class="reply_stbody" id="div_<?php echo ++$divid;?>">
<div class="reply_stimg">
<a href="<?php echo $base_url.$mres['username'];?>"><img src="<?php echo $base_url.$mres['profImage'];?>" class="big_face" alt="<?php echo $mres['username'];?>"></a>

</div> 

<div class="reply_sttext">
<?php //echo $mres['id'];?> 
<b><a href="<?php echo $base_url.$mres['username'];?>" class="pname"><?php echo $mres['username'];?></a></b>

<?php echo $mres['message'];?><div class="reply_sttime"> <span class="timeago" title=""><?php echo time_stamp($mres['sent']);?></span>
<input type="checkbox" id="check_<?php echo ++$checkboxlength;?>" name="" value="<?php echo $mres['id'];?>" />
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
<div id="updateboxarea">
<h5><?php echo $lang['write a reply'];?>...</h5>
<form action="<?php echo $base_url;?>action/write_msg-exec.php" method="post">
<input type="hidden" id="msgto_member_id" name="msgto_member_id" value="<?php echo $msg_member_id;?>">
<input type="hidden" id="member_id" name="member_id" value="<?php echo $member_id;?>">
<textarea name="message_body" id="update" maxlength="200"></textarea>
<input type="submit" value="<?php echo $lang['Reply'];?> " id="update_button" class="reply_button wallbutton update_box"/> 
</form>
</div>
</div>
</div><!--end main left-->
<!--end message body-->

</div><!--end border div-->

</div><!--end column_left div-->
<br />
<!--Start column right-->
<?php //include 'ads_right_column.php';?>
<!--end column_right div-->
</div><!--end mainbody div-->
<?php include 'includes/footer.php';?>
</div><!--end wrapper div-->
</body>
</html>