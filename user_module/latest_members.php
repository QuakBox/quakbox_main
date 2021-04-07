<?php 
	session_start();
	//error_reporting(0);
	if(isset($_SESSION['lang']))
	{	
		include('common.php');
	}
	else
	{
		include('Languages/en.php');
		
	}
	if(!isset($_SESSION['SESS_MEMBER_ID']))
	{
		header("location: ".$base_url."login.php?back=". urlencode($_SERVER['REQUEST_URI']));
		exit();
	}
	
	require_once('config.php');
	
	$member_id = $_SESSION['SESS_MEMBER_ID'];
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $lang['Browse People'];?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="icon" href="images/favicon.ico" type="image" />
<link rel="shortcut icon" href="images/favicon.ico" type="image" />

<link rel="stylesheet" type="text/css" href="css/format.css"/>
<link rel="stylesheet" type="text/css" href="css/search.css"/>
<link rel="stylesheet" type="text/css" href="css/dropdown.css"/>
<link rel="stylesheet" type="text/css" href="css/responsive.css"/>
<link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.css"/>
<!--<script src="js/jquery.livequery.js" type="text/javascript"></script>
<script src="js/jquery.oembed.js"></script>-->

<script src="js/ibox.js"></script>
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/jquery.fastLiveFilter.js"></script>
<script src="js/move-top.js"></script>
<script type="text/javascript">


function delfriend(id)
{
//alert(id);
var r=confirm("<?php echo $lang['Are you sure you want to delete this friend'];?>?");
	if(r==true)
	{
	//alert('yes');
	
	           $.ajax({
			type: "POST",
			url: "action/del_friend.php",
			data: {member_id:id},
			cache: false,
			success: function(html){
			 $("#vinod").html(html);
			alert('<?php echo $lang['Friend Deleted'];?>');
			 $("#mini-profile_"+id).hide();
			  
			 }
			 });
	//ocation.href="action/delete_friend.php?member_id="+id;
	}
}


$(document).ready (function () {
	/*$('.remove').click (function () {
		return confirm ("Are you sure you want to delete this friend?") ;
	}) ; */
}) ;
    $(function() {
        $('#friend_search_input').fastLiveFilter('#border',{
			callback: function(total) { $('#num_results').html(total); }
		});
    });
    
    $(function() {

	$('.remove1').click (function () {

		return confirm('<?php echo $lang["Are you sure you want to delete this friend"];?>?', 'Confirmation Dialog');

						

	}) ; 
});
    
</script>

</head> 
<body id="latest_member">
<div id="wrapper">
<?php include('includes/header.php');

?>
<div id="mainbody">
<div class="column_left">

<div class="componentheading">
    <div id="submenushead"><?php echo $lang['Browse Friends'];?></div>
    <div id="vinod" ></div>
    </div>
      
<div class="cFilterBar_inner">

<div class="innerwrap">

<span class="uiSearchInput textinput">
<span>
<input type="text" id="friend_search_input" placeholder="<?php echo $lang['search your friends'];?>" />
<button><span></span></button>
</span>
</span>
</div>
<div id="" style="border-bottom:1px solid rgb(204, 204, 204); padding:10px 5px; padding-bottom:10px;"><?php echo $lang['search found'];?>: <span id="num_results" style="font-weight:bold;"></span></div>

</div>

<div id="border">
<?php 
	$clicks = mysqli_query($con, "select * from member where member_id!='$member_id' order by member_id desc");
	if(mysqli_num_rows($clicks) > 0)
	{
	while($clicks_res = mysqli_fetch_array($clicks))
	{
		$member  = $clicks_res['member_id'];
		$count = mysqli_query($con, "select m.member_id,m.username,m.profImage,f.added_member_id from friendlist f,member m where f.added_member_id=m.member_id and f.member_id = '".$member."'");
		$count_res = mysqli_fetch_array($count);		
		$count_row = mysqli_num_rows($count);
		
		$fcount = mysqli_query($con, "select * from friendlist where (added_member_id = '$member_id' AND member_id='$member') OR
		(member_id = '$member_id' AND added_member_id='$member')") or die(mysqli_error($con));				
		$fcount_row = mysqli_num_rows($fcount);	
		
		
?>
        
<div class="mini-profile" id="mini-profile_<?php echo $clicks_res['member_id'];?>">
<div class="mini-profile-avatar">
<a href="<?php echo $base_url.$clicks_res['username'];?>" title="<?php echo ucfirst($clicks_res['username']);?>"><img src="<?php echo $clicks_res['profImage'];?>" width="68" height="68" /></a>
</div>
<div class="mini-profile-details">
<h3 style="font-size:120%;"><a href="<?php echo $base_url.$clicks_res['username'];?>" 
title="<?php echo ucfirst($clicks_res['username']);?>"><div<strong><?php echo ucfirst($clicks_res['username']);?></strong></a></h3>
<div class="mini-profile-details-status"></div>
<div class="mini-profile-details-action">


<?php
$sql_block=mysqli_query($con, "select * from blocklist where userid='".$member."' and blocked_userid='".$_SESSION['SESS_MEMBER_ID']."'");
$count_block=mysqli_num_rows($sql_block);
if($count_block>0)
{
echo "block";
}
else
{?>
<span class="icon-group"><?php echo $count_row.' ';?><?php echo $lang['friends'];?></span>
<?php
if($fcount_row == 1)
	{
	$fcount2 = mysqli_query($con, "select * from friendlist where (member_id = '$member_id' AND added_member_id='$member')") or die(mysqli_error($con));				
		$fcount_row2 = mysqli_num_rows($fcount2);
		if($fcount_row2==1)
		{
		
		
		}
	else
	{?>
	
	<a href="write_message.php?id=<?php echo $clicks_res['username'];?>"><span class="icon-write"><?php echo $lang['write message'];?></span></a>
<?php	}
	} 
	else
	{?>
	
	<a href="write_message.php?id=<?php echo $clicks_res['username'];?>"><span class="icon-write"><?php echo $lang['write message'];?></span></a>
<?php	}
	
	?>

<!--<a class="remove" href="action/delete_friend.php?member_id=<?php echo $clicks_res['member_id'];?>" title="Remove Friend" ></a>-->
<?php 
if($fcount_row <= 0)
{

?>

<a href="#myform1<?php echo $member;?>" rel="ibox" id="" class="add_friend" title="<?php echo $lang['Add as friend'];?>"><span class="icon-add-friend"><?php echo $lang['Add as friend'];?></span></a>
<?php }
else if($fcount_row == 1)

{
	$fcount1 = mysqli_query($con, "select * from friendlist where (member_id = '$member_id' AND added_member_id='$member')") or die(mysqli_error($con));				
		$fcount_row1 = mysqli_num_rows($fcount1);
		if($fcount_row1==1)
		{
		?>
		<div style="float:right" id="fri<?Php echo $member;?>" data-id="<?Php echo $member;?>">

<div style="display:inline;"><input type="button" name="accept_request" value="<?Php echo $lang['confirm'];?>" id="<?Php echo $member;?>" 
        class="accept_request"></div>
        <div style="display:inline;"><input type="button" name="cancel_request" value="<?Php echo $lang['not now'];?>" id="<?Php echo $member;?>" class="cancel_request"></div>

</div>
<div style="display:none; float:right" id="friend<?Php echo $member;?>">

        <a href="write_message.php?id=<?php echo $row['username'];?>" ><span class="icon-write" style="margin-right: 69px;"><?php echo $lang['write message'];?></span></a>
        <a class="remove1" href="action/delete_friend.php?member_id=<?php echo $clicks_res['member_id'];?>"><?php echo $lang['Remove Friend'];?></a>
        </div>
		<?php }
	else
	{
	
	 echo "<span class='icon-add-friend'>".$lang['Request Sent']."</span>";
	}
	} 

	
else
{

?>

<a class="remove1" href="action/delete_friend.php?member_id=<?php echo $clicks_res['member_id'];?>"><?php echo $lang['Remove Friend'];?></a>

<?php }}?>
<form id="myform1<?php echo $member;?>" style="display:none;" action="action/add_friend.php" method="post">
<p><?php echo $lang['Are you sure you want to add this friend'];?>?</p>
<textarea name="message" style="width:90%; margin:5px;" placeholder="<?php echo $lang['write message'];?>" ></textarea>

<input type="hidden" value="<?php echo $member;?>"  name="member_id"/>
<input type="submit" name="add_friend" value="<?php echo $lang['Add friend'];?>" class="button" style="margin:3px; margin-top:10px; margin-left:250px;"  />
<input type="button" class="button" name="cancel" id="cancel_request" onclick="javascript:{window.location.reload();}" value="<?php echo $lang['Cancel'];?>" style="margin:3px; margin-top:10px; float:right;"/>
</form>
</div>
</div>

</div><!--end mini profile-->
<?php }}
else
{
?>
<div class="community-empty-list" style="width: 300px;float: left;margin: 20px 20px 20px 0px;">
<?php echo $lang['No friends'];?>
</div>
<?php } ?>
</div><!--end border-->

</div><!--end column_left div-->

<!--Start column right-->
<?php include 'ads_right_column.php';?>
<!--end column_right div-->
</div><!--end mainbody div-->
<?php include 'includes/footer.php';?>
</div><!--end wrapper div-->
</body>
</html>