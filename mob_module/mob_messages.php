<?php ob_start();
	session_start();
	
	if(isset($_SESSION['lang']))
	{	
		include('common.php');
	}
	else
	{
		include('en.php');
		
	}
	require_once('config.php');
	require_once('includes/time_stamp.php');
	$member_id = $_SESSION['SESS_MEMBER_ID'];
	//$group_id = $_REQUEST['message_id'];
	if(!isset($_SESSION['SESS_MEMBER_ID']))
	{
		header("location:login.php?back=". urlencode($_SERVER['REQUEST_URI']));
	}
	if(isset($_REQUEST['username'])) {
	$username = $_REQUEST['username'];
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

<script src="<?php echo $base_url;?>js/jquery.min.js"></script>
<script type="text/javascript">

$(document).ready(function()
{	
	
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
<body id="mob_msg">
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
<div id="main_left">
<div class="some-content-related-div">
<div id="replylist_content" class="conversation_grid">
<?php
$msgfquery = "select distinct msg.from ,m.username, msg.read,m.profImage,m.member_id,
		     msg.message,msg.sent,count(*)
		     from cometchat msg, members m	 	     
			 WHERE 
			 CASE
			 WHEN msg.to = '$member_id'
			 THEN msg.from = m.member_id
			 WHEN msg.from = '$member_id'
			 THEN msg.to = m.member_id
			 END
			 AND
			 (msg.from ='$member_id' OR msg.to ='$member_id')
			 GROUP BY m.member_id ORDER BY msg.from desc";
			 
$msgfsql = mysql_query($msgfquery) or die(mysql_error()); 
while($msgfres = mysql_fetch_array($msgfsql)) {
if($msgfres['member_id']<>$member_id){ ?>
<a class="con_name" href="<?php echo $base_url.'mob_messages_details.php?username='.$msgfres['member_id'];?>">
<div class="conList" id="1">
<span class="reply_stdelete" href="#" id="<?php echo $msgfres['member_id'];?>" original-title="Delete Update" my="<?php echo $member_id;?>"></span>
<img src='<?php echo $base_url.$msgfres['profImage'];?>' class='cimg'>
<span class='cname'><?php echo $msgfres['username'];?></span>
<br />
<span id='reply1822' class='reply'>	
<!--<img src='https://labs.9lessons.info/wall_icons/send.png'  class='con_send'/>	-->
<?php $msglen = strlen($msgfres['message']); if($msglen > 20) { echo substr($msgfres['message'],0,17).'...';}else {echo $msgfres['message'];}?></span>
<br />
<span  class="sttime timeago con_time" title=""><?php echo time_stamp($msgfres['sent']);?></span>
</div>
</a>
<?php }} ?>
</div>
</div>
</div><!--end main right-->

<!--end main left-->
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