<?php

/**
   * @package      load_data
   * @subpackage   share_info
   * @author        Vishnu 
   * Created date  02/11/2015 
   * Updated date  03/26/2015 
   * Updated by    Vishnu NCN
 **/

ob_start();

if(!isset($_SESSION)){
session_start();
}

include_once '../config.php';
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');

if(!isset($_SESSION['SESS_MEMBER_ID']))
{}
else
{
$member_id = $_SESSION['SESS_MEMBER_ID'];
$msg_id = (int)$_POST['msg_id'];
$share_query  = "SELECT msg.type,msg.messages,m.username,m.member_id,
                v.thumburl 
				FROM message msg 
				INNER JOIN member m ON msg.member_id=m.member_id 
				LEFT JOIN videos v ON msg.messages_id = v.msg_id
				WHERE msg.messages_id='$msg_id'";
$share_result = mysqli_query($con, $share_query) or die(mysqli_error($con));
$row = mysqli_fetch_array($share_result);

$objMem = new member1(); 
$memProImage='';
$memProImage=$objMem->select_member_meta_value($member_id,'current_profile_image');
if($memProImage){			
		$memProImage=$base_url.'/'.$memProImage;	
}
else{
	$memProImage=$base_url.'/images/default.png';
}

?>
<div class="stsharebody" id="<?php echo $msg_id;?>">
<input type="hidden" name="member_id" value="<?php echo $member_id;?>" >
<input type="hidden" name="msg_id" value="<?php echo $msg_id;?>" >
<div class="stshareimg">
<img src="<?php echo $memProImage; ?>" class='big_face'/>
</div>
<script type="text/javascript"> 
$(document).ready(function(){
	var text = $('#textoembed<?php echo $msg_id;?>').val();
	$("#stexpand1<?php echo $msg_id;?>").oembed(text,{maxWidth: 100, maxHeight: 100});
	//$("#shareVideoPreviewoPreview").html($("#stexpand<?php echo $msg_id;?>").html());
});
</script>
<div class="stsharetext">
<b><?php echo $row['username']; ?></b><br />
<?php if($row['type']==0){

echo substr($row['messages'],0,100).'';} if($row['type']==1){?><img src="<?php echo $base_url.$row['messages'];?>" height="100" width="100" /><?php } if($row['type']==2){ ?>  <img src="<?php echo $base_url.'uploadedvideo/videothumb/p200x150'.$row['thumburl'];?>" height="150" width="200" /> <?php }?>
</div>
<div id="stexpand1<?php echo $msg_id;?>" style="max-width:100px;max-height:100px;overflow:hidden;"></div>
<input type="hidden" id="hid_div_id" value="<?php echo $msg_id;?>">

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
      //  alert('image available');    //do something
      link=$("#stexpand"+mid).find("img").attr("src"); 
    
          
 } 
 
 if ($("#stexpand"+mid).find("iframe").length > 0)
 {
        // alert('video available');    //do something
      vlink=$("#stexpand"+mid).find("iframe").attr("src"); 
 
          
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
	//alert();
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

<?php }?>