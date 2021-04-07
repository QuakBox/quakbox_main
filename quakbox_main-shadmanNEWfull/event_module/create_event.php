<?php
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php'); 	 
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');
	//require_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_header.php');
	
	$member_id = $QbSecurity->qbClean($_SESSION['SESS_MEMBER_ID'],$con);
	$objMember = new member1();
	$lookupObject = new lookup();
	
	$member_id = $_SESSION['SESS_MEMBER_ID'];
	if(!isset($_SESSION['SESS_MEMBER_ID']))
	{
		header("location: ".$base_url."index.php");
		exit();
	}
	
	$sql = mysqli_query($con, "select * from member where member_id='".$member_id."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);
?>
<?php /*?><link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="icon" href="images/favicon.ico" type="image" />
<link rel="shortcut icon" href="images/favicon.ico" type="image" />
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>font-awesome/css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="css/format.css"/>
<link rel="stylesheet" type="text/css" href="css/search.css"/>
<link rel="stylesheet" type="text/css" href="css/group.css"/>
<link rel="stylesheet" type="text/css" href="css/dropdown.css"/><?php */?>
<link rel="stylesheet" type="text/css" href="css/jquery-ui.css"/>
<script src="js/jquery.livequery.js" type="text/javascript"></script>
<script src="js/jquery.oembed.js"></script>
<script src="js/jquery-1.9.1.js"></script>
<script src="<?php echo $base_url;?>js/check.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/ibox.js"></script>


<script type="text/javascript">

	$(function() {
		$( "#datepicker" ).datepicker({
			showOtherMonths: true,
			selectOtherMonths: true
		});
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
<div class="col-lg-9 col-md-9 col-sm-8 paddingNone" style="text-align:center">
	<div class="componentheading">
    <div id="submenushead" style="text-align:left"><?php echo $lang['Event Calendar'];?></div>
    </div>


<?php 
$today 	  = getdate();
$firstDay   = getdate(mktime(0,0,0,$today['mon'],1,$today['year']));
$lastDay	= getdate(mktime(0,0,0,$today['mon']+1,0,$today['year']));

if( true == isset( $_REQUEST['intNextMonth'])){	
$firstDay = getdate(mktime(0,0,0,$_REQUEST['intNextMonth'],1,$_REQUEST['intYear']));
$lastDay  = getdate(mktime(0,0,0,$_REQUEST['intNextMonth']+1,0,$_REQUEST['intYear']));	
}

if( true == isset( $_REQUEST['intPreviousMonth'])){
$firstDay = getdate(mktime(0,0,0,$_REQUEST['intPreviousMonth'],1,$_REQUEST['intYear']));
$lastDay  = getdate(mktime(0,0,0,$_REQUEST['intPreviousMonth']+1,0,$_REQUEST['intYear']));	
}


//$con=mysqli_connect('localhost','root','');
//mysqli_select_db('db_laxman',$con);
//require_once('config.php');
//mysqli_query("insert into event values('','kkkkk','7/23/2013','kkkkk','','','')");


if(isset($_REQUEST['event_input']) && isset($_REQUEST['event_date']) && isset($_REQUEST['where_event']) && 0 < strlen($_REQUEST['event_input']) && 0 < strlen($_REQUEST['event_date']) && 0 < strlen($_REQUEST['where_event']) ){
	$strEventInput = $_REQUEST['event_input'];
	$strEventDate  = $_REQUEST['event_date'];
	$strWhereEvent = $_REQUEST['where_event'];
	$strEventDescription = $_REQUEST['event_description'];
	$event_date = date('Y-m-d',strtotime($strEventDate));
	$ip = $_SERVER['REMOTE_ADDR'];
	
	mysqli_query($con, "insert into event(event_name,event_description,datepicker,event_location,event_host,users_ip,source) 
			values('$strEventInput','$strEventDescription','$event_date','$strWhereEvent','".$_SESSION['SESS_MEMBER_ID']."','$ip','1')") or die(mysqli_error($con));
	$event_id = mysqli_insert_id($con);
	
	mysqli_query($con, "insert into event_members (event_id,member_id,status) values('$event_id','$member_id',1)");
	
}


// create event on calendar

echo "<div id='div_calendar' class='div_calendar'><br><br>
<div style='text-align:right'><input type='button' value='".$lang['Create Event']."' onclick='create_event_show()'/></div>";

// Create a table with the necessary header informations
echo '<table class="table table-bordered">';
echo '<tr><th colspan="7">';if(isset($_SESSION['lang']) && ($_SESSION['lang'])<>'en'){
			if ($firstDay['month']== 'January') echo $lang['January']; 
			else if ($firstDay['month']== 'February') echo $lang['February'];
			else if ($firstDay['month']== 'March') echo $lang['March'];
			else if ($firstDay['month']== 'April') echo $lang['April'];
			else if ($firstDay['month']== 'May') echo $lang['May']; 
			else if ($firstDay['month']== 'June') echo $lang['June'];
			else if ($firstDay['month']== 'July') echo $lang['July'];
			else if ($firstDay['month']== 'August') echo $lang['August'];
			else if ($firstDay['month']== 'September') echo $lang['September'];
			else if ($firstDay['month']== 'October') echo $lang['October'];
			else if ($firstDay['month']== 'November') echo $lang['November'];
			else if ($firstDay['month']== 'December') echo $lang['December'];
			 }else {echo  $firstDay['month'];}
			echo " - ".$firstDay['year']."</th></tr>";

if( 1 > ($firstDay['mon']-1)){
	$intPreviousMonth=12;
	$intPreviousYear=$firstDay['year']-1;
} else {
	$intPreviousMonth=($firstDay['mon']-1);
	$intPreviousYear=$firstDay['year'];
}

echo "<tr><th><a class='visibleSmall' href='create_event.php?intPreviousMonth=".$intPreviousMonth."&intYear=".$intPreviousYear."'>".substr($lang['previous'], 0, 4)."</a><a class='hiddenSmall' href='create_event.php?intPreviousMonth=".$intPreviousMonth."&intYear=".$intPreviousYear."'>".$lang['previous']."</a></th><th colspan='5'></th>";


if( 12 < ($firstDay['mon']+1)){
	$intNextMonth=1;
	$intNextYear=$firstDay['year']+1;
} else {
	$intNextMonth=($firstDay['mon']+1);
	$intNextYear=$firstDay['year'];
}
echo "<th><a href='create_event.php?intNextMonth=".$intNextMonth."&intYear=".$intNextYear."'>".$lang['next']."</a></th> </tr>";


echo '<tr class="days hiddenSmall">';
echo ' <td>'.$lang['sun'].'</td><td >'.$lang['mon'].'</td> <td>'.$lang['tue'].'</td> <td>'.$lang['wed'].'</td> <td>'.$lang['thu'].'</td>';
echo ' <td>'.$lang['fri'].'</td><td>'.$lang['sat'].'</td></tr>';
echo '<tr>';
echo '<tr class="days visibleSmall">';
echo ' <td>'.substr($lang['sun'], 0, 3).'</td><td >'.substr($lang['mon'], 0, 3).'</td> <td>'.substr($lang['tue'], 0, 3).'</td> <td>'.substr($lang['wed'], 0, 3).'</td> <td>'.substr($lang['thu'], 0, 3).'</td>';
echo ' <td>'.substr($lang['fri'], 0, 3).'</td><td>'.substr($lang['sat'], 0, 3).'</td></tr>';
echo '<tr>';
for($i=0;$i<$firstDay['wday'];$i++){
	echo "<td class='viewDate'><div class='mainBox'><div class='subdiv1'></div><br><div class='subdiv2'></div></div></td>";
}
$actday = 0;
for($i=$firstDay['wday'];$i<7;$i++){
	$actday++;
	echo "<td class='viewDate'><div class='mainBox'><div class='subdiv1'>$actday </div><br><div class='subdiv2'>";

	$sql="select * from event WHERE str_to_date( datepicker, '%Y-%m' ) = str_to_date( '".$firstDay['year']."-".$firstDay['mon']."-30', '%Y-%m' )";

	$result=mysqli_query($con, $sql);
	$cnt = 1;
	while( $data=mysqli_fetch_array($result)){
		$mydate=$data['datepicker'];
		$date = new DateTime(trim($mydate));
		if( $actday == $date->format('d') ){
			echo '<a href="event_view.php?id='.$data['id'].'">';
			echo "<div class='eventdivimage'><img src='images/event-icon.png' width='20px' height='20px'/></div></a>&nbsp;";
			//echo '<a href="event_view.php?id='.$data['id'].'" class="btn btn-primary btn-sm hidden-xs">My Event '.$cnt.'</a>&nbsp;';
		$cnt++;
		}
	}
	
	
	$sqlBDate='SELECT m.username,m.LastName,m.birthdate,m.profimage,f.member_id FROM friendlist f join members m on (f.member_id=m.member_id )where f.added_member_id='.$_SESSION['SESS_MEMBER_ID'].'';
		$result=mysqli_query($con, $sqlBDate);
	
	while( $data=mysqli_fetch_array($result)){
		$mydate=$data['birthdate'];
		$date = new DateTime(trim($mydate));
		if( $actday == $date->format('d') && $firstDay['mon'] == $date->format('m') ){
		
		echo "<a href='member_profile.php?member_id=".$data['member_id']."' title='".$data['username']. "'><div class='eventdivimage'><img src='".$data['profimage']."' width='20px' height='20px'/></div></a>&nbsp;";
		}
	}
	
	echo "</div></div></td>";
}
echo '</tr>';
$fullWeeks = floor(($lastDay['mday']-$actday)/7);

for ($i=0;$i<$fullWeeks;$i++){
	echo '<tr>';

	for ($j=0;$j<7;$j++){
		$actday++;
		echo "<td class='viewDate'><div class='mainBox'><div class='subdiv1'>$actday</div><br><div class='subdiv2'>";
		
		$sql="select * from event WHERE str_to_date( datepicker, '%Y-%m' ) = str_to_date( '".$firstDay['year']."-".$firstDay['mon']."-30', '%Y-%m' )";
	
		$result=mysqli_query($con, $sql);
		while( $data=mysqli_fetch_array($result)){
			$mydate=$data['datepicker'];
			$date = new DateTime(trim($mydate));
			if( $actday == $date->format('d') ){
				echo '<a href="event_view.php?id='.$data['id'].'">'; 
				echo "<div class='eventdivimage'><img src='images/event-icon.png' title='".$data['event_name']."' width='20px' height='20px'/></div></a>&nbsp;";
				//echo '<a href="event_view.php?id='.$data['id'].'" class="btn btn-primary  btn-sm hidden-xs">'.$data['event_name'].'</a>&nbsp;';
			}
		}

	$sqlBDate='SELECT m.username,m.LastName,m.birthdate,m.profimage,f.member_id FROM friendlist f join members m on (f.member_id=m.member_id )where f.added_member_id='.$_SESSION['SESS_MEMBER_ID'].'';
		$result=mysqli_query($con, $sqlBDate) or die(mysqli_error($con));
	
	while( $data=mysqli_fetch_array($result)){
		$mydate = $data['birthdate'];
		$date = new DateTime(trim($mydate));
		if( $actday == $date->format('d') && $firstDay['mon'] == $date->format('m') ){
		
		echo "<a href='member_profile.php?member_id=".$data['member_id']."' title='".$data['username']."'><div class='eventdivimage'><img src='".$data['profimage']."' width='20px' height='20px'/></div></a>&nbsp;";
		}
	}
		echo "</div></div></td>";
	}

	echo '</tr>';
}

if ($actday < $lastDay['mday']){
	echo '<tr>';

	for ($i=0; $i<7;$i++){
		$actday++;

		if ($actday <= $lastDay['mday']){
			echo "<td class='viewDate'><div class='mainBox'><div class='subdiv1'>$actday</div><br><div class='subdiv2'>";
			
		$sql="select * from event WHERE str_to_date( datepicker, '%Y-%m' ) = str_to_date( '".$firstDay['year']."-".$firstDay['mon']."-30', '%Y-%m' )";
	
		$result=mysqli_query($con, $sql);

			while( $data=mysqli_fetch_array($result)){
				$mydate=$data['datepicker'];
				$date = new DateTime(trim($mydate));
				if( $actday == $date->format('d') ){
					echo '<a href="event_view.php?id='.$data['id'].'">';		
					echo "<div class='eventdivimage'><img src='images/event-icon.png' title='".$data['event_name']."' width='20px' height='20px'/></div></a>&nbsp;";			
					//echo '<a href="event_view.php?id='.$data['id'].' " class="btn btn-primary btn-sm hidden-xs">'.$data['event_name'].'</a>&nbsp;';
				}
			}

	$sqlBDate='SELECT m.username,m.LastName,m.birthdate,m.profimage,f.member_id FROM friendlist f join members m on (f.member_id=m.member_id )where f.added_member_id='.$_SESSION['SESS_MEMBER_ID'].'';
		$result=mysqli_query($con, $sqlBDate);
	
	while( $data=mysqli_fetch_array($result)){
		$mydate = $data['birthdate'];
		$date = new DateTime(trim($mydate));
		if( $actday == $date->format('d') && $firstDay['mon'] == $date->format('m') ){
		
		echo "<a href='member_profile.php?member_id=".$data['member_id']."' title='".$data['username']. "'><div class='eventdivimage'><img src='".$data['profimage']."' width='20px' height='20px'/></div></a>&nbsp;";
		}
	}
	echo "</div></div></td>";
		} else {
			echo "<td class='viewDate'><div class='mainBox'><div class='subdiv1'></div><br><div class='subdiv2'></div></div></td>";
		}
	}
}
echo '</tr></table></div>';
echo "<div id='div_view' class='div_view'>
		<div class='div_head' id='div_head'>
		</div>
		<div class='div_body' id='div_body'>
		<br><br>
		<table>
			<tr>
				<td> ".$lang['Event Details']."</td>
				<td><input type='text' id='lblDetails'/></td>
			</tr>
			<tr>
				<td>".$lang['Event Date']."</td>
				<td><input type='text' id='lblDate'/></td>
			</tr>
			<tr>
				<td>".$lang['Location']."</td>
				<td><input type='text' id='lblLocation'/></td>
			</tr>
		</table> 
		</div>
		<div class='div_bottom' id='div_bottom'>
			<input id='btn_div_view_close' onclick='close_div_view()' type='button' value='".$lang['Close']."'/>
		</div>
	</div>";

echo"
<div class='create_event_div' id='create_event_div'>
<form id='frm_create_event' action='create_event.php' method='post' > 
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
	<td align='right'>".$lang['Event Input']."</td>
    <td><input name='event_input' id='event_input' type='text'></td>
</tr>

<tr>
	<td align='right'>".$lang['Details']."</td>
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
    <input type='button' name='create_event' onclick='fun_submit()' value='". $lang['Create']."'>
    <input type='button' name='btn_cancel' onclick='create_event_close()' value='". $lang['Cancel']."'>
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
?>