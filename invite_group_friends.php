<?php
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php'); 	 
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');
	//require_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_header.php');
	
	$member_id = $QbSecurity->qbClean($_SESSION['SESS_MEMBER_ID'], $con);
	$group_id = $QbSecurity->qbClean($_REQUEST['group_id'], $con);
	if(!(empty($group_id)||($qbValidation->qbIntegerCheck($group_id))))
	{
		$qb_err_msg="Oops Something Went Wrong...!";
		$QbSecurity->qbErrorMessage($qb_err_msg,$homepage);
	}
	else
	{
	$group_id=htmlspecialchars(trim($group_id));
	$sql = mysqli_query($con, "select * from groups where id='".$group_id."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);
	
?>
<link rel="stylesheet" type="text/css" href="js/jquery.autocomplete.css" />
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
});
</script>
<div class="insideWrapper container">
    <div class="col-lg-9 col-md-9 col-sm-8">
	
    <div class="componentheading">
    <div id="submenushead"><?php echo $lang['Invite frineds to Group'];?></div>
    </div>
    <div id="submenushead">
    <ul class="dropDown">
    <li style="border-left:1px solid #C2CDDE; padding:0 8px;"><a href="groups_wall.php?group_id=<?php echo $group_id;?>"><?php echo $lang['Back to Group'];?></a></li>
   <!-- <li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="groups.php">My Groups</a></li>
    <li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="">Pending Invitations</a></li>
  	<li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="create_groups.php">Create</a></li>
    <li style="padding:0 8px;"><a href="groups_search.php">Search</a></li> -->   
	</ul>
   </div>
   <br clear="all" />
<div id="border">
<form name="find_friend" id="find_friend" action="action/invite_group_friends-exec.php" method="post">
<input type="hidden" name="member_id" id="member_id" value="<?php echo $member_id;?>" />
<input type="hidden" name="group_id" id="group_id" value="<?php echo $group_id;?>" />
<input type="hidden" name="event_member_id" id="event_member_id" value="" />
<table class="formtablenew">
<tbody>
<tr>
<td colspan="2"></td>
</tr>
<tr>
<td style="font-weight: bold;text-align: right;width: 130px; padding:5px;vertical-align:top;">
<label style="font-weight: 700;text-align: right;"><?php echo $lang['Invite Friends'];?></label>
</td>
<td style="padding:5px; vertical-align:top;"><input id="invite_frinds" class="required inputbox" type="text" value="" size="40" name="invite_frinds" placeholder="<?php echo $lang['Invite Friends'];?>" /></td>
</tr>


<tr>
<td colspan="2"></td>
</tr>
    <tr>
<td style="font-weight: bold;text-align: right;width: 130px; padding:5px;vertical-align:top;">
</td>
<td style="padding:5px; vertical-align:top;">
<input type="hidden" value="save" name="action"></input>
<input type="hidden" value="" name="groupid"></input>
<input class="button validateSubmit" type="submit" value="<?php echo $lang['Add friend'];?>"></input>
<input class="button" type="button" value="<?php echo $lang["Cancel"];?>" onclick="history.go(-1);return false;"></input>

</td>
</tr>
<tr>
</tbody>
</table>
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
	}
?>