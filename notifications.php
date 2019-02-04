<?php
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php'); 	 
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');
	//require_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/time_stamp.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_header.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');

	if(!isset($_SESSION['SESS_MEMBER_ID']))
	{
		header("location: ".$base_url."login.php?back=". urlencode($_SERVER['REQUEST_URI']));
		exit();
	}

	$member_id = $_SESSION['SESS_MEMBER_ID'];
	$sql = mysqli_query($con, "select * from member where member_id='".$member_id."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);
?>
<link rel="stylesheet" href="css/notifications.css" type="text/css" />
<script type="text/javascript">
$(document).ready(function(){
	$("div.image").mouseover(function(){
   $id=$(this).attr('title');
   document.getElementById($id).style.display = "";
}); // end each

	$("div.image").mouseleave(function(){
	$id=$(this).attr('title');
   document.getElementById($id).style.display = "none";
	});	

$(".settings-button").click(function()
{
var X=$(this).attr('title');
var H=$(this).attr('value');

if(X==1)
{
$("#"+H+"-submenu12").hide();
$(this).attr('title', '0');	
}
else
{
$("#"+H+"-submenu12").show();
$(this).attr('title', '1');
}
});

//Mouseup textarea false
$(".submenu12").mouseup(function()
{
return false
});
$(".settings-button").mouseup(function()
{
return false
});
});
</script>
<script type="text/javascript">
$(function() {
    $(".cancel_custom").click(function() {
	$("#popup").hide();
	});

	 $(".cancel_share").click(function() {
	$("#share_popup").hide();
	$(".share_body").children('div').remove();
	});
});
</script>
<div class="insideWrapper container">

 

     

    <div class="col-lg-9 col-md-9 col-sm-9"> 

 
		
    <div class="componentheading">
    	<div id="submenushead"><?php echo $lang['Notifications'];?></div>
    </div>

    

<?php 



	  $nquery = "SELECT * FROM notifications n LEFT JOIN member m ON m.member_id = n.sender_id
	  			WHERE  received_id  = '$member_id'
				ORDER BY id DESC";

	  $nsql = mysqli_query($con, $nquery);

	  

	  if(mysqli_num_rows($nsql) > 0)

	  {

		  ?>

        
<table>

      <?php
	  while($nres = mysqli_fetch_array($nsql))

	  {

		 
		  $receiver_id = $nres['received_id'];

		  $rmquery = mysqli_query($con, "SELECT username, member_id FROM members WHERE member_id = '$receiver_id'");

		  $rmres = mysqli_fetch_array($rmquery);

		  

	  ?>

		


        
<tr><td>
        <div class="phm">

        

        <!--<img class="lfloat _8o _8r img" src="" />-->

        

        <div >

        <?php 
		$objMember= new member1(); 
		$notificationSenderProfileLogo=$objMember->select_member_meta_value(($nres['sender_id']),'current_profile_image');
		if($notificationSenderProfileLogo){			
					$notificationSenderProfileLogo='/'.$notificationSenderProfileLogo;	
		}
		else
		{
			$notificationSenderProfileLogo='/images/default.png';
		}
		?>
		
		
		<div class="pull-left"><img src="<?php echo $notificationSenderProfileLogo; ?>" style="width:50px; height:50px; float:left; margin-right:2px;border:1px solid #ccc;padding:2px;margin-bottom:2px;" /></div>
		

        <div><b><a href="<?php echo $base_url.$nres['username'];?>"><?php echo ucfirst($nres['username']);?></a> <b>

        


		<a href="<?php echo $nres['href'].$append_notid;?>" class="uiLinkSubtle"><?php echo $nres['title']; ?></a>
        <?php
		
		//Edited by Mushira Ahmad--Check for different types of notifications
	if ($nres['type_of_notifications']==30)
    		$append_notid="?notid=".$nres['id'];
    	else
	if ($nres['type_of_notifications']==37)
    		$append_notid="?notid=".$nres['id'];
    	else if($nres['type_of_notifications']==31)
		{
			 $append_notid=""; 
		}else
    	        $append_notid="&notid=".$nres['id'];
    	//End of handling different types of notifications
    	
		?>

		<span class="fss"><?php echo time_stamp($nres['date_created']);?></span>    

        

       

        </div>

        

        </div>    

        

        

        </div>
		
</td></tr>
		

        

      <?php } 	 

	  

	  ?>

</table>

      <?php } 

	  else

	  {

	  ?>

      <div class="community-empty-list"><?php echo $lang['No notifications'];?></div><?php } ?>



</div><!--end div column_internal_left-->

<!--Start column right-->
    <div class="col-lg-2 col-md-3 col-sm-3 hidden-xs"> 
        <div style="" class="adsQBxzqw"> <?php include($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/ads.php');?></div>
    </div>
<!--end column_right div-->

</div><!--end mainbody div-->



<div id="popup" style="display:none;">



    <div id="custom_privacy" style="width:445px; height:200px; margin:10% 40%; background:#FFF; border-radius:2px;">

    <div style="background:#999; border:solid 1px #000000; width:445; text-align:center; padding:5px; font-weight:bold;"><?php echo $lang['Custom Privacy'];?></div>

    <div style="padding:10px">

    <div style="padding:0px 20px;">

    <div>    

    <h3 class="app-box-title"><?php echo $lang['Share this with'];?></h3>

    

    <table cellpadding="0" cellspacing="1">

    <tbody>

<tr>

<td colspan="2"></td>

</tr>

<tr>

<td style="font-weight: bold;text-align: right;width: 140px; padding:5px;vertical-align:top;">

<label style="font-weight: 700;text-align: right; color:#000;"><?php echo $lang['Friends Name'];?></label>

</td>

<td style="padding:5px; vertical-align:top;">

<div class="ui-widget">

<input name="member_name" id="post_friend" style="padding:5px;" />



</div>



</td>

</tr>

</tbody>

</table>

    </div>

    <div>

    <h3 class="app-box-title"><?php echo $lang["Don't Share this with"];?></h3>

        <table cellpadding="0" cellspacing="1">

    <tbody>

<tr>

<td colspan="2"></td>

</tr>

<tr>

<td style="font-weight: bold;text-align: right;width: 140px; padding:5px;vertical-align:top;">

<label style="font-weight: 700;text-align: right; color:#000;"><?php echo $lang['Friends Name'];?></label>

</td>

<td style="padding:5px; vertical-align:top;">

<div class="ui-widget">

<input name="member_name" id="unpost_friend" style="padding:5px;" />

</div>

</td>

</tr>

</tbody>

</table>

    </div>

    </div>

    </div>

    <div style="background:#999; border:solid 1px #000000; width:auto; height:30px; padding:3px;">

    <div style="float:right">

    <input type="button" class="submit" name="submit" value="<?php echo $lang['Save Changes'];?>" style="height:26px;"/>

    <input type="button" class="cancel_custom" name="submit" value="<?php echo $lang['Cancel'];?>" style="height:26px;" />

    </div>

    </div>

    

    </div>

</div>



<?php include_once 'share.php';?>
<?php
	include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_footer.php');
?>