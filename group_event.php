<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/common/qb_session.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/common/common.php');
//require_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/qb_header.php');

$group_id = intval($_GET['group_id']);
$group_id = htmlspecialchars(trim($group_id));

if (!(empty($group_id) || ($qbValidation->qbIntegerCheck($group_id)))) {
	$qb_err_msg = "Oops Something Went Wrong...!";
	$QbSecurity->qbErrorMessage($qb_err_msg, $homepage);
} else {
	$member_id = $QbSecurity->qbClean($_SESSION['SESS_MEMBER_ID'], $con);
?>
<script src="js/jquery.livequery.js" type="text/javascript"></script>
<script src="js/jquery.oembed.js"></script>
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/ibox.js"></script>
<script type="text/javascript">
	$(function() {
		$( "#datepicker" ).datepicker({
			showOtherMonths: true,
			selectOtherMonths: true
		});
			$('.remove').click (function () {
		return confirm ("<?php echo $lang['Are you sure you want to delete this event'];?>?") ;
	}) ; 		
	});
	
	$(function() {
		$( document ).tooltip();

	});

function div_view( strDetails, strDate,strLocation){

	document.getElementById('lblDetails').value=strDetails;
	document.getElementById('lblDate').value=strDate;
	document.getElementById('lblLocation').value=strLocation;
	
	//document.getElementById('div_popup').style.visibility='hidden';
	document.getElementById('div_view').style.visibility='visible';
	//document.getElementById('div_calendar').style.visibility='hidden';
}
function close_div_view(){
	document.getElementById('div_view').style.visibility='hidden';
}

function create_event_show(){
	document.getElementById('create_event_div').style.visibility='visible';
}
function create_event_close(){
	document.getElementById('create_event_div').style.visibility='hidden';
}


function fun_submit(){
	if( '' == document.getElementById('event_input').value ){
		alert('<?php echo $lang['Enter valid Event Details'];?>!');
		exit;
	}
	
	if( '' == document.getElementById('datepicker').value ){
		alert('<?php echo $lang['Enter valid date'];?>!');
		exit;
	}
	if( '' == document.getElementById('where_event').value ){
		alert('<?php echo $lang['Enter valid Location'];?>!');
		exit;
	}

	document.getElementById('frm_create_event').submit();

}

</script>

<div class="insideWrapper container">
    <div class="col-lg-9 col-md-9 col-sm-8">
	<div class="componentheading">
    <div id="submenushead" style="text-align:left; width:500px"><?php echo $lang['Events'];?></div>
    </div>


<?php 
if(isset($_REQUEST['event_input']) && isset($_REQUEST['event_date']) && isset($_REQUEST['where_event']) && 0 < strlen($_REQUEST['event_input']) && 0 < strlen($_REQUEST['event_date']) && 0 < strlen($_REQUEST['where_event']) ){
	$strEventInput = $_REQUEST['event_input'];
	$strEventDate  = $_REQUEST['event_date'];
	$strWhereEvent = $_REQUEST['where_event'];
	$strEventDescription = $_REQUEST['event_description'];
	
	$date = new DateTime(trim($strEventDate));
	
	
	mysqli_query($con, "insert into event values( '','" .$strEventInput."','".$strEventDescription."','','".$date->format('y-m-d') ."','".$strWhereEvent."','".$_SESSION['SESS_MEMBER_ID']."','','','3','','$group_id')") or die(mysqli_error($con));
	$event_id = mysqli_insert_id($con);
	
	mysqli_query($con, "insert into event_members (event_id,member_id,status) values('$event_id','$member_id',1)");
	
}

//select data from event table
$equery = "SELECT e.event_host, e.event_name,e.id, e.datepicker,e.event_location , m.username, m.member_id FROM event e
			INNER JOIN member m ON m.member_id = e.event_host
			WHERE e.source = 3 and e.group_id = '$group_id' ORDER BY e.id DESC";

$esql = mysqli_query($con, $equery) or die(mysqli_error($con));
if(mysqli_num_rows($esql) > 0)
{
	$objMemberHeader1 = new member1();
	while($eres = mysqli_fetch_array($esql))
	{
		$eres['profImage'] = $objMemberHeader1->select_member_meta_value($eres['member_id'],'current_profile_image');
?>

<div class="mini-profile">
<div class="mini-profile-avatar">
<a href="<?php echo $base_url."i/".$smres['username'];?>" title="<?php echo $eres['username'];?>"><img src="<?php echo $eres['profImage'];?>" width="68" height="68" /></a>
</div>
<div class="mini-profile-details">
<div>
<h3 style="font-size:120%;">
<a href="event_view.php?id=<?php echo $eres['id'];?>" title="<?php echo $eres['event_name'];?>">
<strong><?php echo ucfirst($eres['event_name']);?></strong></a></h3>
</div>
<br />
<div style="text-align:left;">
<h2 style="font-size:11px; outline:medium none;text-align:left;"><?php echo date('l, F d,Y',strtotime($eres['datepicker']));?></h2>
</div>

<div style="text-align:left;"><strong><?php echo ucfirst($eres['event_location']);?></strong></div>

<div class="mini-profile-details-action">
<a class="remove" href="action/delete_event.php?id=<?php echo $eres['id'];?>" title="<?php echo $lang['Remove event'];?>" ></a>

</div>
</div>

</div><!--end mini profile-->


<?php 
}
}
else
{
	echo "<div class='community-empty-list'>".$lang['No events']."</div>";
}
echo "<div style='text-align:right; padding-top: 15px;'><input type='button' value='".$lang['Create Event']."' onclick='create_event_show()'/></div>";

echo "<div class='create_event_div' id='create_event_div'>
<form id='frm_create_event' action='' method='post' > 
<div style='background-color:#CCC'>
<table height='10%'>
<tr>
	<td colspan='2' align='left'><b>
    ".$lang['Create Event']."</b>
    </td>    
</tr>
</table>

</div>
<br>
<div>
<table height='80%'>
<tr>
	<td align='right'>".$lang['Name']."</td>
    <td><input name='event_input' id='event_input' type='text'></td>
</tr>
<tr>
	<td align='right'>Details</td>
    <td><textarea name='event_description' id='event_description'></textarea></td>
</tr>
<tr>
	<td align='right'>".$lang['Date']."</td>
    <td><input name='event_date' type='text' id='datepicker' /></td>
</tr>
<tr>
	<td align='right'>".$lang['Where']."</td>
    <td><input name='where_event' id='where_event' type='text'></td>
</tr>
</table>
</div>
<br>
<div style='background-color:#CCC'>
<table height='10%'>
<tr>
	<td colspan='2' align='right'>
    <input type='button' name='create_event' onclick='fun_submit()' value='".$lang['Create']."'>
    <input type='button' name='btn_cancel' onclick='create_event_close()' value='".$lang['Cancel']."'>
    </td>    
</tr>
</table>
</div>
</form>

</div>";

?>
   
</div><!--end column_left div-->

<!--Start column right-->
    <div class="col-lg-2 col-md-2 col-sm-3 hidden-xs"> 
        <div style="" class="adsQBxzqw"> <?php include($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/ads.php');?></div>
    </div>
<!--end column_right div-->

</div><!--end mainbody div-->
<?php
	include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_footer.php');
}
?>