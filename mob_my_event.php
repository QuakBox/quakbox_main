<?php 

	session_start();

	if(isset($_SESSION['lang']))

	{	

		include('common.php');

	}

	else

	{

		include('en.php');

		

	}

	if(!isset($_SESSION['SESS_MEMBER_ID']))

	{

		header("location:login.php?back=". urlencode($_SERVER['REQUEST_URI']));

	}

	require_once('config.php');

	$member_id = $_SESSION['SESS_MEMBER_ID'];

	//$country_code = $_REQUEST['country'];

	

	$sql = mysql_query("select * from members where member_id='".$member_id."'") or die(mysql_error());

	$res = mysql_fetch_array($sql);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<title><?php echo $lang['Events'];?></title>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">


<link rel="stylesheet" type="text/css" href="css/style.css"/>

<link rel="icon" href="images/favicon.ico" type="image" />

<link rel="shortcut icon" href="images/favicon.ico" type="image" />



<link rel="stylesheet" type="text/css" href="css/format.css"/>

<link rel="stylesheet" type="text/css" href="css/search.css"/>



<link rel="stylesheet" type="text/css" href="css/dropdown.css"/>

<link rel="stylesheet" type="text/css" href="css/responsive.css"/>

<link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.css">

<link rel="stylesheet" type="text/css" href="css/group.css"/>
<link rel="stylesheet" type="text/css" href="css/jquery-ui.css"/>

<script src="js/jquery.livequery.js" type="text/javascript"></script>

<script src="js/jquery.oembed.js"></script>

<script src="js/jquery-1.9.1.js"></script>

<script src="js/jquery-ui.js"></script>



<script src="js/ibox.js"></script>





<style>



table {

	width:100%;

	border:0px solid #888;

	border-collapse:collapse;

}



.viewDate {

	width:14%;

	border-collpase:collpase;

	border:1px solid #888;

	text-align:right;

	padding-right:5px;

}

.days{

	

}

th {

	width:14%;

	border-collpase:collpase;

	border:0px solid #888;

}

.actday{

	background-color: #c22;

	font-weight:bold;

}

.mainBox{

	width:100px;

	height:100px;

}

.subdiv1{

	width:95px;

	height:60px;

	text-align:left;

}

.subdiv2{

	width:95px;

	height:100px;

	overflow:auto;

	text-align:left;

}

    

	



.eventdiv{

	width:20px;

	height:20px;

	display:inline;

	border:1px solid;

	margin-left:2px;

	background-color:#F00;

}

.eventdivimage{

	width:20px;

	height:20px;

	display:inline;

	margin-left:2px;

	

}



.div_popup{

	height:120px;

	width:300px;

	border-left:2px solid;

	border-left-color:#999999;

	border-right:2px solid;

	border-right-color:#999999;

	position:fixed;

	top:70px;

	left:200px;

	visibility:hidden;

}

.div_calendar{

	width:100%;

	height:auto;

	position:absolute;

	

	

}

.div_view{

	height:250px;

	width:300px;

	

	border-left:4px solid;

	border-left-color:#999999;

	border-right:4px solid;

	border-right-color:#999999;

	

	position:fixed;

	top:200px;

	left:400px;

	visibility:hidden;

}

.div_head{

	width:100%;

	height:15%;

	background-color:#999999;

	text-align:left;

	

	

}

.div_body{

	width:100%;

	height:70%;

	background-color:#CCC;

}

.div_bottom{

	width:100%;

	height:15%;

	background-color:#999999;

	text-align:right;



	

}

.create_event_div{



	height:auto;

	width:300px;

	position:absolute;

	top:15%;

	left:30%;	

	visibility:hidden;

	border:3px solid #CCC;

	background-color:#FFF;

	z-index:15;

}

</style>



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







</head>



<body id="mob_my_event">

<div id="wrapper">

<?php include('includes/header.php');?>

<div id="mainbody">

<div class="column_left" >

	<div class="componentheading" style="width:50%;">
    <div id="submenushead" style="text-align:left; width:50%"><?php echo  $lang['Events'];?></div>

    </div>
    
<?php    echo "<div id='create_div'><a href='mob_create_event.php'><input type='button' value='".$lang['Create Event']."'/></a></div>";?>


<div class="componentheading">

    <div id="submenushead" style="text-align:left; width:93%"><?php echo  $lang['Todays Birthday'];?></div>

    </div>




<?php 

if(isset($_REQUEST['event_input']) && isset($_REQUEST['event_date']) && isset($_REQUEST['where_event']) && 0 < strlen($_REQUEST['event_input']) && 0 < strlen($_REQUEST['event_date']) && 0 < strlen($_REQUEST['where_event']) ){

	$strEventInput = $_REQUEST['event_input'];

	$strEventDate  = $_REQUEST['event_date'];

	$strWhereEvent = $_REQUEST['where_event'];

	$strEventDescription = $_REQUEST['event_description'];

	

	$date = new DateTime(trim($strEventDate));

	

	

	mysql_query("insert into event values( '','" .$strEventInput."','".$strEventDescription."','','".$date->format('y-m-d') ."','".$strWhereEvent."','".$_SESSION['SESS_MEMBER_ID']."','','','2','".$country_code."','')") or die(mysql_error());

	$event_id = mysql_insert_id();

	

	mysql_query("insert into event_members (event_id,member_id,status) values('$event_id','$member_id',1)");

	

}



//select data from event table

$sqlBDate='SELECT m.username,m.FirstName,m.LastName,m.birthdate,m.profimage,f.member_id FROM friendlist f join members m on (f.member_id=m.member_id )where f.added_member_id='.$_SESSION['SESS_MEMBER_ID'].'';

$esql=mysql_query($sqlBDate);
$numrow= mysql_num_rows($esql);
if($numrow > 0)
{

	while( $eres=mysql_fetch_array($esql)){

		$mydate=$eres['birthdate'];

		$date = new DateTime(trim($mydate));
		//print_r($date);
		//$date->format('d'); echo "<br>";
		$actday=date('d');
		$actmon=date('m');
		if( $actday == $date->format('d') && $actmon == $date->format('m') ){
				//echo $eres['username'];



/*

$equery = "SELECT e.event_host, m.profImage,e.event_name,e.id, e.datepicker,e.event_location FROM event e

			INNER JOIN members m ON m.member_id = e.event_host

			WHERE e.source = 2 and e.country_id = '$country_code'";


$esql = mysql_query($equery) or die(mysql_error());

if(mysql_num_rows($esql) > 0)

{

while($eres = mysql_fetch_array($esql))

{*/

?>



<div class="mini-profile">

<div class="mini-profile-avatar">

<a href="<?php echo $base_url.$clicks_res['username'];?>" title="<?php echo $eres['FirstName'];?>"><img src="<?php echo $eres['profImage'];?>" width="68" height="68" /></a>

</div>

<div class="mini-profile-details">

<div>

<h3 style="font-size:120%;">

<a href="<?php echo $base_url.$eres['username'];?>" title="<?php echo $eres['FirstName'];?>">

<strong><?php echo ucfirst($eres['FirstName']);?></strong></a></h3>

</div>

<br />

<div style="text-align:left;">

<h2 style="font-size:11px; outline:medium none;text-align:left;"><?php echo "Today";?></h2>

</div>



<!--<div style="text-align:left;"><strong><?php //echo ucfirst($eres['event_location']);?></strong></div>-->


<!--
<div class="mini-profile-details-action">

<a class="remove" href="action/delete_event.php?id=<?php echo $eres['id'];?>" title="Remove event" ></a>



</div>
-->
</div>


</div><!--end mini profile-->
<?php }}
}
else

{

	echo "<div class='community-empty-list' style='width: 83%;'>".$lang['No events']."</div>";

}
?>

<div class="componentheading">
<hr />
    <div id="submenushead" style="text-align:left; width:93%;"><?php echo  $lang['Events'];?></div>

    </div>




<?php
$equery = "SELECT e.event_host, m.profImage,e.event_name,e.id, e.datepicker,e.event_location FROM event e

			INNER JOIN members m ON m.member_id = e.event_host

			WHERE e.datepicker <= (now() + interval 6 day) AND e.datepicker >= now() ORDER BY e.datepicker";

$esql = mysql_query($equery) or die(mysql_error());

if(mysql_num_rows($esql) > 0)

{

while($eres = mysql_fetch_array($esql))

{
	
?>



<div class="mini-profile">

<div class="mini-profile-avatar">

<a href="event_view.php?id=<?php echo $eres['id'];?>" title="<?php echo $eres['event_name'];?>"><img src="<?php echo $eres['profImage'];?>" width="68" height="68" /></a>

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


<!--
<div class="mini-profile-details-action">

<a class="remove" href="action/delete_event.php?id=<?php echo $eres['id'];?>" title="Remove event" ></a>



</div>
-->
</div>



</div><!--end mini profile-->






<?php 



}


		}

		


?>

   

</div><!--end column_left div-->

<!--Start column right-->



<!--end column_right div-->

</div><!--end mainbody div-->

<?php include 'includes/footer.php';?>

</div><!--end wrapper div-->



</body>

</html>