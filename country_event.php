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
	$country_code = $_REQUEST['country'];

	$sql = mysqli_query($con, "select * from member where member_id='".$member_id."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);

?>
<?php /*?><link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="icon" href="images/favicon.ico" type="image" />
<link rel="shortcut icon" href="images/favicon.ico" type="image" />
<link rel="stylesheet" type="text/css" href="css/format.css"/>
<link rel="stylesheet" type="text/css" href="css/search.css"/>
<link rel="stylesheet" type="text/css" href="css/dropdown.css"/>
<link rel="stylesheet" type="text/css" href="css/responsive.css"/>
<link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="css/group.css"/><?php */?>
<link rel="stylesheet" type="text/css" href="css/jquery-ui.css"/>

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
		return confirm ("Are you sure you want to delete this event?") ;
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
		alert('Enter valid Event Details!');
		exit;
	}

	if( '' == document.getElementById('datepicker').value ){
		alert('Enter valid date!');
		exit;
	}

	if( '' == document.getElementById('where_event').value ){
		alert('Enter valid Location!');
		exit;
	}

	document.getElementById('frm_create_event').submit();
}
</script>
<div class="insideWrapper container">
    <div class="col-lg-9 col-md-9 col-sm-8">

	<div class="componentheading">

    <div id="submenushead" style="text-align:left; width:100%"><?php echo  $lang['Events'];?></div>

    </div>
    
<?php    echo "<div id='create_div' style='text-align:right; padding-top: 15px; margin-bottom:20px;'><a href='create_country_event.php?country=$country_code'><input type='button' value='".$lang['Create Event']."'/></a></div>";?>






<?php 

if(isset($_REQUEST['event_input']) && isset($_REQUEST['event_date']) && isset($_REQUEST['where_event']) && 0 < strlen($_REQUEST['event_input']) && 0 < strlen($_REQUEST['event_date']) && 0 < strlen($_REQUEST['where_event']) ){

	$strEventInput = $_REQUEST['event_input'];

	$strEventDate  = $_REQUEST['event_date'];

	$strWhereEvent = $_REQUEST['where_event'];

	$strEventDescription = $_REQUEST['event_description'];

	

	$date = new DateTime(trim($strEventDate));

	

	

	mysqli_query($con, "insert into event values( '','" .$strEventInput."','".$strEventDescription."','','".$date->format('y-m-d') ."','".$strWhereEvent."','".$_SESSION['SESS_MEMBER_ID']."','','','2','".$country_code."','')") or die(mysqli_error($con));

	$event_id = mysqli_insert_id($con);

	

	mysqli_query($con, "insert into event_members (event_id,member_id,status) values('$event_id','$member_id',1)");

	

}



//select data from event table

$equery = "SELECT e.event_host, m.member_id,e.event_name,e.id, e.datepicker,e.event_location FROM event e

			INNER JOIN member m ON m.member_id = e.event_host

			WHERE e.source = 2 and e.country_id = '$country_code'";

$esql = mysqli_query($con, $equery) or die(mysqli_error($con));

if(mysqli_num_rows($esql) > 0)

{

while($eres = mysqli_fetch_array($esql))

{
	$memberProfilePic=$objMember->select_member_meta_value($eres['member_id'],'current_profile_image');
	
	if($memberProfilePic){			
		$memberProfilePic=SITE_URL.'/'.$memberProfilePic;	
	} else{
		$memberProfilePic=SITE_URL.'/images/default.png';
	}
?>



<div class="mini-profile">

<div class="mini-profile-avatar">

<a href="event_view.php?id=<?php echo $eres['id'];?>&country=<?php echo $country_code ?>" title="<?php echo $eres['event_name'];?>"><img src="<?php echo $memberProfilePic;?>" width="68" height="68" /></a>

</div>

<div class="mini-profile-details">

<div>

<h3 style="font-size:120%;">

<a href="event_view.php?id=<?php echo $eres['id'];?>&country=<?php echo $country_code ?>" title="<?php echo $eres['event_name'];?>">

<strong><?php echo ucfirst($eres['event_name']);?></strong></a></h3>

</div>

<br />

<div style="text-align:left;">

<h2 style="font-size:11px; outline:medium none;text-align:left;"><?php echo date('l, F d,Y',strtotime($eres['datepicker']));?></h2>

</div>



<div style="text-align:left;"><strong><?php echo ucfirst($eres['event_location']);?></strong></div>



<div class="mini-profile-details-action">

<a class="remove" href="action/delete_event.php?id=<?php echo $eres['id'];?>&country=<?php echo $country_code ?>" title="Remove event" ></a>



</div>

</div>



</div><!--end mini profile-->





<?php 

}

}

else

{

	echo "<div class='community-empty-list' style='width: 83%;'>".$lang['No events']."</div>";

}







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