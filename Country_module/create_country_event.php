<?php
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php'); 	 
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');
	//require_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/time_stamp.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_header.php');
	
	$country_code=$_REQUEST['country'];
	$member_id = $_SESSION['SESS_MEMBER_ID'];

	if(!isset($_SESSION['SESS_MEMBER_ID']))
	{
		header("location: ".$base_url."login.php?back=". urlencode($_SERVER['REQUEST_URI']));
		exit();
	}

	$sql = mysqli_query($con, "select * from member where member_id='".$member_id."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);
?>
<?php /*?><link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="icon" href="images/favicon.ico" type="image" />
<link rel="shortcut icon" href="images/favicon.ico" type="image" />

<link rel="stylesheet" type="text/css" href="css/format.css"/>
<link rel="stylesheet" type="text/css" href="css/search.css"/>
<link rel="stylesheet" type="text/css" href="css/dropdown.css"/>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css" />
<link rel="stylesheet" type="text/css" href="css/bootstrap-reset.css" />
<link rel="stylesheet" type="text/css" href="css/responsive.css" />
<link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.css" /><?php */?>
<link rel="stylesheet" type="text/css" href="css/group.css"/>
<link rel="stylesheet" type="text/css" href="css/jquery-ui.css"/>

<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui.js"></script>
<script type="text/javascript">
	$(function() {

		$( "#datepicker" ).datepicker({

			showOtherMonths: true,

			selectOtherMonths: true

		});
		});
</script>
<div class="insideWrapper container">
    <div class="col-lg-9 col-md-9 col-sm-9"> 

	

    <div class="componentheading">

    <div id="submenushead"><?php echo  $lang['Create Event']; //$lang['Create New Event'];?></div>

    </div>

<?php 

if(isset($_REQUEST['event_input']) && isset($_REQUEST['event_date']) && isset($_REQUEST['where_event']) && 0 < strlen($_REQUEST['event_input']) && 0 < strlen($_REQUEST['event_date']) && 0 < strlen($_REQUEST['where_event']) ){

	$strEventInput = $_REQUEST['event_input'];

	$strEventDate  = $_REQUEST['event_date'];

	$strWhereEvent = $_REQUEST['where_event'];

	$strEventDescription = $_REQUEST['event_description'];

	

	$date = new DateTime(trim($strEventDate));

	

	
	// echo "insert into event values( '','" .$strEventInput."','".$strEventDescription."','','".$date->format('Y-m-d') ."','".$strWhereEvent."','".$_SESSION['SESS_MEMBER_ID']."','','','2','".$country_code."','')<br />";
	mysqli_query($con, "insert into event values( '','" .$strEventInput."','".$strEventDescription."','','".$date->format('Y-m-d') ."','".$strWhereEvent."','".$_SESSION['SESS_MEMBER_ID']."','','','2','".$country_code."','')") or die(mysqli_error($con));

	//echo $event_id = mysqli_insert_id($con);
	
	//echo "<br />insert into event_members (event_id,member_id,status) values('$event_id','$member_id',1)";
	mysqli_query($con, "insert into event_members (event_id,member_id,status) values('$event_id','$member_id',1)");

	echo '<script>window.location.href="/country_event.php?country='.$country_code.'";</script>';
	exit();
}

?>
    

   <div id="border">

<form id="frm_create_event" action="" method="post" role="form" class="form-horizontal">

 <div class="form-group crt_grp_p">

<?php /*?><p><?php echo $lang['Create your own Event today.'];?>.</p><?php */?></div>

   <div class="form-group">

     

      <label for="name" class="control-label col-md-4">* <?php echo $lang['Name'];?></label>   

      	 <div class="col-md-4">

		<input id="name" class="form-control" type="text" value="" name="event_input" placeholder="<?php echo $lang['Enter Name'];?>"></input>

        </div>

	</div>





  <div class="form-group">

	

    <label for="name" class="control-label col-md-4">* <?php echo $lang['Description'];?></label>

      <div class="col-md-4">  

		<textarea style="rgb(255, 0, 0) !important; width:100%; height:110px;" id="name" type="text" value="" name="event_description" class="form-control"></textarea>

        </div>

  </div>

 <div class="form-group">

     

      <label for="event_date" class="control-label col-md-4">* <?php echo $lang['Date'];?></label>   

      	 <div class="col-md-4">

		<input id="datepicker" class="form-control" type="text" value="" name="event_date" placeholder="<?php //echo $lang['Enter Date'];?>"></input>

        </div>

	</div>
 <div class="form-group">

     

      <label for="Where" class="control-label col-md-4">* <?php echo $lang['Where'];?></label>   

      	 <div class="col-md-4">

		<input id="name" class="form-control" type="text" value="" name="where_event" placeholder="<?php echo $lang['Where'];?>"></input>

        </div>

	</div>




	

	

    

        

  

  

        

        

  

        

       

    

         

 

  

    



<div class="form-group">

<div class="col-md-4 crt_grp">

<input type="hidden" value="save" name="action"></input>

<input type="hidden" value="" name="groupid"></input>

<input class="button validateSubmit" type="submit" value="<?php echo $lang['Create Event'];?>"></input>

<input class="button" type="button" value="<?php echo $lang['Cancel'];?>" onclick="history.go(-1);return false;"></input>

<input type="hidden" value="1" name="326e4f73c340f29d8ce547ad40dc0e1b"></input>

</div>

</div>

</form>





</div>





</div><!--end column_left div-->

<!--Start column right-->
    <div class="col-lg-2 col-md-3 col-sm-3 hidden-xs"> 
        <div style="" class="adsQBxzqw"> <?php include($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/ads.php');?></div>
    </div>
<!--end column_right div-->
</div><!--end mainbody div-->
<?php
	include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_footer.php');
?>