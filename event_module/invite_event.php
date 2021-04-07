<?php
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php'); 	 
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');
	//require_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_header.php');
	
	$member_id = $_SESSION['SESS_MEMBER_ID'];
	$event_id = $_REQUEST['id'];
	if(!isset($_SESSION['SESS_MEMBER_ID']))
	{
		header("location: ".$base_url."index.php");
		exit();
	}	
?>
<?php /*?><link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="icon" href="images/favicon.ico" type="image" />
<link rel="shortcut icon" href="images/favicon.ico" type="image" />
<link rel="stylesheet" type="text/css" href="css/jquery-ui.css"/>
<link rel="stylesheet" type="text/css" href="js/jquery.autocomplete.css" /><?php */?>
<link rel="stylesheet" type="text/css" href="css/group.css"/>
<script src="js/jquery-1.9.1.js"></script>
<script src="<?php echo $base_url;?>check.js"></script>
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
    <div id="submenushead">Invite Friends to Event</div>
    </div>
    <div id="submenushead">
    <ul class="dropDown">
    <li style="border-left:1px solid #C2CDDE; padding:0 8px;"><a href="event_view.php?id=<?php echo $event_id;?>">Back to Event</a></li>
   <!-- <li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="groups.php">My Groups</a></li>
    <li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="">Pending Invitations</a></li>
  	<li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="create_groups.php">Create</a></li>
    <li style="padding:0 8px;"><a href="groups_search.php">Search</a></li> -->   
	</ul>
   </div>
<div id="border">
<form name="find_friend" id="find_friend" action="action/invite_event-exec.php" method="post">
<input type="hidden" name="member_id" id="member_id" value="<?php echo $member_id;?>" />
<input type="hidden" name="event_id" id="event_id" value="<?php echo $event_id;?>" />
<input type="hidden" name="event_member_id" id="event_member_id" value="" />
<table class="formtablenew">
<tbody>
<tr>
<td colspan="2"></td>
</tr>
<tr>
<td style="font-weight: bold;text-align: right;width: 130px; padding:5px;vertical-align:top;">
<label style="font-weight: 700;text-align: right;">Invite Friends</label>
</td>
<td style="padding:5px; vertical-align:top;"><input id="invite_frinds" class="required inputbox" type="text" value="" size="40" name="invite_frinds" placeholder="Invite Friends" /></td>
</tr>
<tr>
<td colspan="2"></td>
</tr>
    <tr>
<td style="font-weight: bold;text-align: right;width: 130px; padding:5px;vertical-align:top;">
</td>
<td style="padding:5px; vertical-align:top;">

<input class="button validateSubmit" type="submit" value="Invite"></input>
<input class="button" type="button" value="CANCEL" onclick="history.go(-1);return false;"></input>

</td>
</tr>
<tr>
</tbody>
</table>
</div>

</div><!--end column_left div-->

<!--Start column right-->
    <div class="col-lg-2 col-md-2 col-sm-3 hidden-xs"> 
        <div style="" class="adsQBxzqw"> <?php include($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/ads.php');?></div>
    </div>
<!--end column_right div-->

</div><!--end mainbody div-->
<?php
	include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_footer.php');
?>