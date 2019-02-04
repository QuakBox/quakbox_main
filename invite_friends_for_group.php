<?php
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php'); 	 
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');
	//require_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_header.php');
	
	$member_id = $QbSecurity->qbClean($_SESSION['SESS_MEMBER_ID'],$con);
	$objMember = new member1();
	$lookupObject = new lookup();
	
	if(!isset($_SESSION['SESS_MEMBER_ID']))
	{
		header("location: ".$base_url."login.php?back=". urlencode($_SERVER['REQUEST_URI']));
		exit();
	}
	
	$member_id = $_SESSION['SESS_MEMBER_ID'];
	$sql = mysqli_query($con, "select * from member where member_id='".$member_id."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);
?>

<?php /*?><link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="icon" href="images/favicon.ico" type="image" />
<link rel="shortcut icon" href="images/favicon.ico" type="image" /><?php */?>

<script src="js/ibox.js"></script>
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/jquery.autocomplete.js"></script>
<script type="text/javascript">
$(function() {
$('#boxclose').click(function(){	
	$('.box').hide();
});
});
</script>
<script>
$(document).ready(function(){
   
  $("#test").submit(function(event){
  var email=$("#email").val();
  email = email.toUpperCase();
  var email1=$(".form-control").val();
  email1 = email1.toUpperCase();
  if(email==email1 || email1=='')
  {
  if(email1=='')
  alert("please insert email id");
  else
  alert(" You are trying to invite yourself , Please insert different email id");
  
 return false;
}
<?php 
 
 $sql1 = mysqli_query($con, "select m.email_id,m.member_id,m.username,m.profImage,f.added_member_id from friendlist f,members m where f.member_id=m.member_id and f.added_member_id = '".$member_id."' AND status!= 0") or die(mysqli_error($con));
	//$res = mysqli_fetch_array($sql);
	while($res1 = mysqli_fetch_array($sql1))
	{
	 ?>
	
	var email2= "<?php echo $res1['email_id'];?>"
	if(email1==email2)
	{
		alert(email2 +" alredy exist in your friends list");
		return false;
	}
	<?php
		
		
	}
  
  $sql_mail=mysqli_query($con, "select * from invite_friends where member_id=".$member_id) or die(mysqli_error($con));
while($res2=mysqli_fetch_array($sql_mail))
{
  ?>
	var email3="<?php echo $res2['email_id'];?>";
	if(email1==email3)
	{
	var result=confirm("You have already sent freind request to this mail id .\n Do you want send again?");
	if(result)
	{
	return true;
	}
	else
	{
	return false;
	}
}
<?php 
}
?>



//return false;
});
});
</script>
<?php /*?><link rel="stylesheet" type="text/css" href="js/jquery.autocomplete.css" /><?php */?>
<style type="text/css">

</style>
<div class="insideWrapper container">
    <div class="col-lg-9 col-md-9 col-sm-8">
	<?php 
	if(isset($_GET['err'])){
if($_GET['err'] == null){ 
?>
<div class="box" id="box">
<a class="boxclose" id="boxclose"></a>
<div class="alert-box"><span><?php echo $lang['Message Sent Successfully'];?></span></div>
</div>
<?php
}
}
?>
    <div class="componentheading">
    <div id="submenushead"><?php echo $lang['Invite friends to QuakBox'];?></div>
    </div>
   <div id="submenushead">
   <ul class="submenu">
    <li><a onclick="history.back(); return false;" href="javascript:void(0);"><?php echo $lang['Back'];?></a></li>
    <!--<li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="find_friend.php">Search</a></li>
    <li><a href="find_friend_advanced.php">Advanced Search</a></li>
  	<li><a href="invite_friends.php">Invite Friends</a></li>
    <li><a href="request_sent.php">Request Sent</a></li>
    <li><a href="pending_request.php" style="border-right:none;">Pending my approval</a></li>-->
	</ul>
   </div>
<br clear="all" />
<div class="col-lg-8 col-md-7">
    <div class="column_internal_left" style="border:#CCCCCC 1px solid; padding:10px;">
    <div style="margin:0 0 10px;">
    <?php echo $lang['You can invite your friends to this community. Just add their emails here and we will send the invite for you'];?>.
    </div>
    <form action="action/invite_friends_for_group-exec.php" method="post" name="invite_friends" id="test">
    <div style="padding:5px 0 5px;">
    <label style="font-weight:bold; vertical-align:baseline;"><?php echo $lang['From'];?>:</label><br />
    
    <?php echo $res['username'];?>
    </div>
    <input type="hidden" value="<?php echo $res['email_id'];?>"  id="email" />
    <div style="padding:5px 0 5px;">
    <label style="font-weight:bold; vertical-align:baseline;">*<?php echo $lang['To'];?>:</label><br />
    <input name="emails" style="height:110px; width:100%;" required="required" class="form-control" multiple pattern="^([\w+-.%]+@[\w-.]+\.[A-Za-z]{2,4},*[\W]*)+$"/>
    <!--<div style="font-size:80% !important; margin-bottom:12px;"><?php echo $lang['Separate emails with a comma'];?></div>-->
    </div>
    
    <div style="padding:5px 0 5px;">
    <label style="font-weight:bold; vertical-align:baseline;"><?php echo $lang['Message'];?>:</label><br />
    <textarea name="message" style="height:110px; width:100%;"></textarea>
    <div style="font-size:80% !important; margin-bottom:12px;">(<?php echo $lang['Optional'];?>)</div>
    </div>
    <div style="padding:5px 0 5px;">
    <span style="font-style:italic; line-height:140%;"><?php echo $lang['Fields marked with an asterisk (*) are required'];?>.</span>
    </div>
    
    <div style="padding:5px 0 5px;">
    <input type="submit" name="submit" value="<?php echo $lang['send invite'];?>" class="button" />
    </div>
    
    </form>
    </div>
</div>
<div class="col-lg-4 col-md-5">
	<?php include_once 'contact_import.php';?>
</div>

</div><!--end column_left div-->

<!--Start column right-->
    <div class="col-lg-2 col-md-3 col-sm-3 hidden-xs"> 
        <div style="" class="adsQBxzqw"><?php include($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/ads.php');?></div>
    </div>
<!--end column_right div-->

</div><!--end mainbody div-->
<?php
	include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_footer.php');
?>