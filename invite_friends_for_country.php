<?php 
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php'); 	 
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');
	//require_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_header.php');

	if(!isset($_SESSION['SESS_MEMBER_ID']))
	{
		header("location: ".$base_url."login.php?back=". urlencode($_SERVER['REQUEST_URI']));
		exit();
	}

	$member_id = $_SESSION['SESS_MEMBER_ID'];
	$country_code = @$_REQUEST['country'];

	$sql = mysqli_query($con, "select * from member where member_id='".$member_id."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);
?>

<?php /*?><link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="icon" href="images/favicon.ico" type="image" />
<link rel="shortcut icon" href="images/favicon.ico" type="image" />
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css" />
<link rel="stylesheet" type="text/css" href="css/responsive.css" />
<link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.css" />
<link rel="stylesheet" type="text/css" href="css/bootstrap-reset.css" /><?php */?>

<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.min.js"></script>
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
  var email1=$(".form-field").val();
  email1 = email1.toUpperCase();
  <?php
  $block=mysqli_query($con, "select * from blocklist where blocked_userid='".$member_id."'");
  
  if(mysqli_num_rows($block)>0)
  {
  while($block_res=mysqli_fetch_array($block))
  {
  $block_mem=mysqli_query($con, "select * from members where member_id='".$block_res['userid']."'");
  $block_mem_res=mysqli_fetch_assoc($block_mem);
  
  
  
  ?>
  //alert("<?php echo $block_mem_res['email_id']?>");
  email4="<?php echo $block_mem_res['email_id']?>";
  if(email1==email4)
  {
  alert("You has been blocked by this Mail ID user")
  return false;
  }
  <?php }}
    
  ?>
  
  
  
  
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
		alert(email2 +" alredy exist in your invite list");
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
	var result=confirm("You have already sent invitation for some other country to this mail id .\n Do you want to invite it again?");
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
<link rel="stylesheet" type="text/css" href="js/jquery.autocomplete.css" />
<div class="insideWrapper container">
    <div class="col-lg-9 col-md-9 col-sm-8">

	<?php 

	if(isset($_GET['err'])){

if(($_GET['err'] == null) && ($_SESSION['err_count_country']==0)){ 
$_SESSION['err_count_country']++;

?>

<div class="box" id="box">

<a class="boxclose" id="boxclose"></a>

<div class="alert-box"><span><?php echo $lang['Invitation Sent Successfully'];?></span></div>

</div>

<?php

}

}

?>

    <div class="componentheading">

    <div id="submenushead"><?php echo $lang['Invite your friends to your Country'];?></div>

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

   

	
    	<div >

			<label for="name" class="control-label"><?php echo $lang['You can invite your friends to your Country. Just add their emails here and we will send the invitation for you'];?>. </label>

		    </div>    





	<div id="border">

    <div class="col-lg-8 col-md-7">
         <div class="column_internal_left">
    
            <form action="action/invite_country-exec.php" method="post" name="invite_friends" class="form-horizontal" id="test">
    
                <input type="hidden" name="country" id="country" value="<?php echo $country_code;?>" />
    
                    
    
                <div class="form-group">
    
                    <div class="col-md-6">
    <input type="hidden" value="<?php echo $res['email_id'];?>"  id="email" />
                        <label for="name" class="control-label"><?php echo $lang['From'];?>:</label>
    
                        <?php echo $res['username'];?>
    
                    </div>
    
                </div>
    
                
    
                
    
                <div class="form-group">				
    
                    <label for="name" class="control-label col-md-2">*<?php echo $lang['To'];?>:</label><br />
    
                        <div class="col-md-6">	
    
                            <textarea name="emails" class="form-control form-field"  required="required" multiple pattern="^([\w+-.%]+@[\w-.]+\.[A-Za-z]{2,4},*[\W]*)+$" ><?php if(isset($_REQUEST['email'])) echo $_REQUEST[	'email'];?></textarea>
    
                                <!--<label for="name" class="control-label"><?php echo $lang['Separate emails with a comma'];?></label>-->
    
                        </div>
    
                </div>
    
                <div class="form-group">				
    
                    <label for="name" class="control-label col-md-2"><?php echo $lang['Message'];?>:</label><br />
    
                        <div class="col-md-6">	
    
                            <textarea name="message" class="form-control form-field" style="height:110px; width:100%;"></textarea>
    
                                <label for="name" class="control-label">(<?php echo $lang['Optional'];?>)</label>
    
                        </div>
    
                 </div>
    
                 
    
                        
    
        <div class="form-group">	
    
            <div class="col-md-7">	
    
                <span><?php echo $lang['Fields marked with an asterisk (*) are required'];?>.</span>
    
            </div>
    
        </div>
    
    
    
        <div class="form-group">
    
            <div class="col-md-4">
    
                <input type="submit" name="submit" value="<?php echo $lang['send invite'];?>" class="button" />
    
            </div>
    
        </div>
    
    </form>
    
    </div>
    </div>
    <div class="col-lg-4 col-md-5">
    	<?php include_once 'contact_import-country.php';?>
    </div>
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

