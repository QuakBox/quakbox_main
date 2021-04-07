<?php 

	require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');
	$member_id = $QbSecurity->qbClean($_SESSION['SESS_MEMBER_ID'], $con);
	if(isset($_REQUEST['id'])){$id = $QbSecurity->qbClean($_REQUEST['id'], $con);}else{$id=null;}
	$id =htmlspecialchars(trim($id));
	if(!(empty($id)||($QbSecurity->qbCheckSpecialChars($id))))
	{
	$qb_err_msg="Oops Something Went Wrong...!";
        $QbSecurity->qbErrorMessage($qb_err_msg,$homepage);
	}
	else
	{
	
	$msql = mysqli_query($con, "select member_id,username from member where username='".$id."'") or die(mysqli_error($con));
	$mres = mysqli_fetch_array($msql);
	
	$sql = mysqli_query($con, "select * from member where member_id='".$member_id."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<title><?php echo $lang['Compose'];?></title>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="icon" href="images/favicon.ico" type="image" />
<link rel="shortcut icon" href="images/favicon.ico" type="image" />
<link rel="stylesheet" type="text/css" href="css/group.css"/>
<link rel="stylesheet" type="text/css" href="css/messages.css"/>
<link rel="stylesheet" type="text/css" href="css/responsive.css"/>
<link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.css"/>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css" />
<link rel="stylesheet" type="text/css" href="css/bootstrap-reset.css" />
<link rel="stylesheet"  type="text/css" href="<?php echo $base_url;?>css/token-input.css"/>
<link rel="stylesheet"  type="text/css" href="<?php echo $base_url;?>css/token-input-facebook.css"/>
<link rel="stylesheet"  type="text/css" href="<?php echo $base_url;?>css/token-input-mac.css"/>


<script src="<?php echo $base_url;?>js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="<?php echo $base_url;?>js/jquery-ui.min.js"></script>
<script src="<?php echo $base_url;?>js/move-top.js"></script>
<script src="<?php echo $base_url;?>js/jquery.tokeninput.js"></script>
<script src="<?php echo $base_url;?>js/check.js"></script>
<script type="text/javascript">
function check(){	
	var msg_body = document.getElementById("message_body").value;
	var msg_to = document.getElementById("msg_to").value;
	
	if(msg_to == ''){
		alert('You must provide a recipient for your message.');
		return false;
	}
	else if(msg_body == ''){
		alert('Please write something.');
		return false;
	}
}
</script>
</head>
<body>
<div id="wrapper">
<?php include('includes/qb_header.php');?>
<div id="mainbody">
<div class="column_left">
	
    <div class="componentheading">
    <div id="submenushead"><?php echo $lang['Compose'];?></div>
    </div>
    <div id="submenushead">
    <ul class="dropDown">
    <li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="messages.php"><?php echo $lang['Inbox'];?></a></li>   	
    <li style="padding:0 8px;"><a href="write_message.php"><?php echo $lang['Write'];?></a></li>
	</ul>
   </div>
	<div id="border">

			<form action="action/write_msg-exec.php" method="post" class="form-horizontal" onsubmit="return check()">
				<input type="hidden" name="msgto_member_id" id="msgto_member_id" value="<?php if(isset($id)) { echo $mres['member_id']; }?>" />
                <input type="hidden" name="msgto_username" id="msgto_username" value="<?php if(isset($id)) { echo $mres['username']; }?>" /> 
		
         <div class="form-group">
			 
			    <label for="name" class="control-label col-md-4"><?php echo $lang['To'];?>(<?php echo $lang['Username'];?>)</label>
					<div class="col-md-4">                   
       
                     <input name="msg_to" type="text" id="msg_to" class="form-control" placeholder="<?php echo $lang['Username'];?>" autofocus="autofocus" required="required" value="<?php if(isset($id)) { echo $id; }?>"/>
                     <script type="text/javascript">
        $(document).ready(function() {
       var msgto = $("#msgto_member_id").val();
	   var msgto_username = $("#msgto_username").val();
	   if(msgto != ''){
            $("#msg_to").tokenInput("<?php echo $base_url;?>load_data/friends_names_ajax.php", {
				prePopulate: [
                    {id: msgto, value: msgto_username}                   
                ],
				theme: "facebook",
                  tokenLimit: 1
                 
            });
		} else {
			$("#msg_to").tokenInput("<?php echo $base_url;?>load_data/friends_names_ajax.php", {				
				theme: "facebook",
                  tokenLimit: 1
                 
            });
		}
        });
        </script>
 			</div>
          </div>
          
          
 		<div class="form-group">
 			<label for="name" class="control-label col-md-4"><?php echo $lang['Message'];?></label>
            <div class="col-md-4">	
				 <textarea id="message_body" class="form-control" name="message_body" style="height:150px;" required="required"></textarea>
 			</div>
        </div>
        
 		
		<input type="hidden" id="member_id" name="member_id" value="<?php echo $member_id;?>">
		
        <div class="form-group">
        	<div class="col-md-4">
				<input id="button validateSubmit"  type="submit" value="<?php echo $lang['Submit'];?>" class="button"/>
			</div>
         </div>
  </form>

</div>

</div><!--end column_left div-->
<!--Start column right-->
<div class="column_right">
<div class="column_internal_right-inner">
 <div id="ads">
   <h3><?php echo $lang['Partners'];?>
   <a href="add_ads.php"><?php echo $lang['Create Ads'];?></a>   
   </h3>
   </div>
   <div class="ads-wrapper">
   <?php
   $ad=0;
   $random_id = rand(1,3); 
   /*$ads_sql = mysqli_query($con, "select * from ads order by rand() LIMIT 3");*/
   $ads_sql = mysqli_query($con, "select * from ads where ads_pic!='' order by rand() LIMIT 3");

   while($ads_res = mysqli_fetch_array($ads_sql))
   {
   ?>
      
	<div class="ads-main" id="ads_<?php echo ++$ad;?>">
        <div class="ads-title">
        <a href="<?php echo $ads_res['url'];?>"><?php echo $ads_res['ads_title'];?></a>
        </div>
        <div class="ads-content">        
        <a href="<?php echo $ads_res['url'];?>" target="_blank">
        <img src="<?php echo $base_url.$ads_res['ads_pic'];?>"/>
        </a>
         <div class="ads-description">
        <?php echo $ads_res['ads_content'];?>
        </div>
               
        <?php 

$ads_like_sql = mysqli_query($con, "SELECT * FROM ads_like WHERE ads_id='". $ads_res['ads_id'] ."'");
$ads_like_count = mysqli_num_rows($ads_like_sql);
?>
 <div class="commentPanel" id="likes<?php echo $ads_res['ads_id'];?>" style="display:<?php if($ads_like_count <= 0) { echo 'none'; } else { echo 'block'; }?>">
<div class="likeUsers" id="ads_elikes<?php echo $ads_res['ads_id'];?>">
<a href="ads_likes.php?id=<?php echo $ads_res['ads_id'];?>" class="" data-toggle="modal" data-target="#myModal"><?php echo $ads_like_count;?> <?php echo $lang['people'];?></a> <?php echo $lang['like this'];?>.</div></div>
<!-- Modal -->
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 
</div><!-- /.modal -->
<?php
$q1 = mysqli_query($con, "SELECT * FROM ads_like WHERE member_id='". $_SESSION['SESS_MEMBER_ID'] ."' and ads_id='".$ads_res['ads_id']."' ");

if(mysqli_num_rows($q1) <= 0)
{
?>     
          <a href="javascript: void(0)" class="ads_like" id="like_ads<?Php echo $ads_res['ads_id'];?>" title="<?Php echo $lang['Like'];?>" rel="Like"><?Php echo $lang['Like'];?></a>
          
          <?php } else
		  {?>         
                
          <a href="javascript: void(0)" class="ads_like" id="like_ads<?Php echo $ads_res['ads_id'];?>" title="<?Php echo $lang['Unlike'];?>" rel="Unlike"><?Php echo $lang['Unlike'];?></a>
          
<?php } ?>
        </div>
        </div>
       
       
     <?php 
   }
	 ?>
	 </div>
       </div>
</div>
<!--end column_right div-->
</div><!--end mainbody div-->
<?php include 'includes/footer.php';?>
</div>
<?php }?><!--end wrapper div-->
</body>
</html>