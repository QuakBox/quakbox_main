<?php ob_start();
session_start();
include_once '../config.php';

$member_id = $_SESSION['SESS_MEMBER_ID'];
$msg_id = (int)$_POST['msg_id'];
$share_query  = "SELECT msg.type,msg.messages,m.username,m.profImage,
                v.thumburl 
				FROM groups_wall msg 
				INNER JOIN members m ON msg.member_id=m.member_id 
				LEFT JOIN videos v ON msg.messages_id = v.msg_id
				WHERE msg.messages_id='$msg_id'";
$share_result = mysqli_query($con, $share_query) or die(mysqli_error($con));
$row = mysqli_fetch_array($share_result);

?>
<div class="stsharebody" id="<?php echo $msg_id;?>">
<input type="hidden" name="member_id" value="<?php echo $member_id;?>" >
<input type="hidden" name="msg_id" value="<?php echo $msg_id;?>" >
<div class="stshareimg">
<img src="<?php echo $row['profImage']; ?>" class='big_face'/>
</div>

<div class="stsharetext">
<b><?php echo $row['username']; ?></b><br />
<?php if($row['type']==0){echo substr($row['messages'],0,400).'....';} if($row['type']==1){?><img src="<?php echo $row['messages'];?>" height="100" width="100" /><?php } if($row['type']==3){ ?>  <img src="<?php echo $row['thumburl'];?>" height="100" width="100" /> <?php }?>
</div>
<input type="hidden" id="hid_div_id" value="<?php echo $msg_id;?>">
<!--<div id="sendemail"><input type="button" value="Send Email" onclick="showform()"></div>!-->
</div><!--End stbody-->
<script>
var mid=$('#hid_div_id').val();
//alert(mid);
var htm=$("#stexpand"+mid).html();
//alert(htm);
var test="#stexpand"+mid;
var link="";
var vlink="";
//alert($("#stexpand"+mid).find("img").attr("src"));
if ($("#stexpand"+mid).find("img").length > 0)
 {
        // alert('image available');    //do something
      link=$("#stexpand"+mid).find("img").attr("src"); 
         
          
 } 
 
 if ($("#stexpand"+mid).find("iframe").length > 0)
 {
        // alert('video available');    //do something
      vlink=$("#stexpand"+mid).find("iframe").attr("src"); 
   // alert(vlink);
         
          
 } 
function showform()
{
//alert('hi');
    
	$('#share_popup').hide();
	$(".share_body").children('div').remove();
	$('#mydiv3').empty();
	
	
	var viewportwidth = document.documentElement.clientWidth;
	var viewportheight = document.documentElement.clientHeight;
	window.resizeBy(-300,0);
	window.moveTo(0,0);
	var share_status=$("#share_status").val();
	//alert(share_status);
	//alert(link);
	//alert(vlink);
	 if(link!="")
	 {
	window.open("<?php echo $base_url;?>emailfrm.php?mesgid=<?php echo $msg_id;?>&link="+link+"&share_status="+share_status,
	            "mywindow",
	            "width=600,left="+(viewportwidth-300)+",top=0");
	            link="";exit;
	 }	 
	else if(vlink!="")
	 {
	 
	 //alert(vlink);
	 window.open("<?php echo $base_url;?>emailfrm.php?mesgid=<?php echo $msg_id;?>&vlink="+vlink+"&share_status="+share_status,
	            "mywindow",
	            "width=600,left="+(viewportwidth-300)+",top=0");
	            vlink="";exit;
	 }
	 else if(link=="" && vlink=="")
	 {
	// alert('both blank');
	 window.open("<?php echo $base_url;?>emailfrm.php?mesgid=<?php echo $msg_id;?>&share_status="+share_status,
	            "mywindow",
	            "width=600,left="+(viewportwidth-300)+",top=0");exit;
	 }        
	 
	    
	

}
</script>