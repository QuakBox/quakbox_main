<?php 
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php'); 	 
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');
	//require_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_header.php');
	$member_id = $_SESSION['SESS_MEMBER_ID'];

	if(!isset($_SESSION['SESS_MEMBER_ID']))
	{
		header("location: ".$base_url."login.php?back=". urlencode($_SERVER['REQUEST_URI']));
		exit();
	}
	
	$country = @$_REQUEST['country'];
?>
<link rel="stylesheet" type="text/css" href="css/group.css"/>
<link rel="stylesheet" type="text/css" href="css/jquery-ui.css"/>
<link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.css" />

<?php /*?><link rel="stylesheet" type="text/css" href="js/jquery.autocomplete.css" />
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui.js"></script>
<script type="text/javascript">
$(document).ready(function(){
$("#invite_frinds").autocomplete({
	 source: "load_data/friends_names_ajax.php",			
			select: function(event,ui)
			{				
				$( "#event_member_id" ).val( ui.item.id);				
			}
 });

	// add multiple select / deselect functionality
	$("#selectall").click(function () {
		  $(".checkbox").prop("checked",$("#selectall").prop("checked"))
	});

	// if all checkbox are selected, check the selectall checkbox
	// and viceversa
	$(".checkbox").click(function(){
		if($(".checkbox").length == $(".checkbox:checked").length) {			
			$("#selectall").attr('checked',true);
		} else {
			$("#selectall").removeAttr("checked");
		}

	});
});
</script><?php */?>
<div class="insideWrapper container">
    <div class="col-lg-9 col-md-9 col-sm-8">

<div class="componentheading">
    <div id="submenushead">Imported Contact</div>
    </div>
    <div id="submenushead">
    <ul class="dropDown">
    <li style="border-right:padding:0 8px;"><a href="invite_friends_for_country.php?country=<?php echo $country; ?>">Back to Invite Friends</a></li>
   
	</ul>
   </div>
	    
<!--start border div-->    
<div id="border">
<form name="email_list" id="email_list" method="post" action="action/delete_contact.php">
<?php 
$cquery = "SELECT email,id FROM import_contact WHERE member_id = '$member_id'";
$csql = mysqli_query($con, $cquery);
if(mysqli_num_rows($csql) > 0){
?>
<!--start inbox-toolbar div-->
<div class="inbox-toolbar">
<table width="100%" cellspacing="0" cellpadding="2" border="0" style="border-collapse:collapse; border-spacing:0px;">
<tbody>
<tr>
<td align="center" width="30">
<input id="selectall" type="checkbox" />
</td>
<td align="center" width="300">
<input type="submit" name="submit" value="Delete">
<input type="button" onclick="inviteMultipleContacts()" value="Invite selected Contacts" id="invite_contacts" />
</td>
<td>

</td>
</tr>
</tbody>
</table>
</div><!--end inbox-toolbar div-->
<?php }else {?>
Not found
<?php 
}
while($cres = mysqli_fetch_array($csql))
{
?>

<div id="message-" class="inbox-read">
<table width="100%" cellspacing="0" cellpadding="2" border="0" style="border-collapse:collapse; border-spacing:0px;">
<tbody>
<tr>
<td align="center" width="30">
<input class="checkbox emailCheckbox" data-email="<?php echo $cres['email'];?>" type="checkbox" name="email[]" value="<?php echo $cres['id'];?>" />
</td>
<td width="300"><a class="subject" href="invite_friends_for_country.php?email=<?php echo $cres['email'];?>&country=<?php echo $country; ?>"><?php echo $cres['email'];?></a></td>

</tr>
</tbody>
</table>
</div>

<?php } ?>

</form>
<script>
	function inviteMultipleContacts(){
		if($(".emailCheckbox:checked").length == 0 ){
			alert("Please select atleast one email to invite");
			return false;
		} 	
	    var emailsStr = $('.emailCheckbox:checked').map(function () {  
		            return $(this).data("email");
		            }).get().join(",");

				
		window.location.href="<?php echo $base_url?>/invite_friends_for_country.php?email=" + emailsStr+"&country=<?php echo $country; ?>";
	}
</script>
</div>
<!--end border div-->
</div>
<!--end column_left div-->

<!--Start column right-->
    <div class="col-lg-2 col-md-3 col-sm-3 hidden-xs" style="padding-left:0px;padding-right:0px;"> 
        <div style="" class="adsQBxzqw"> <?php include($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/ads.php');?></div>
    </div>
<!--end column_right div-->
</div><!--end mainbody div-->
<?php include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_footer.php'); ?>