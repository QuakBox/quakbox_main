<?php 

	session_start();

	

	//error_reporting(0);

	if(isset($_SESSION['lang']))

	{	

		include('common.php');

	}

	else

	{

		include('en.php');

		

	}

	require_once('config.php');
	
	//$country_code=$_REQUEST['country'];

	$member_id = $_SESSION['SESS_MEMBER_ID'];

	if(!isset($_SESSION['SESS_MEMBER_ID']))

	{

		header("location:login.php?back=". urlencode($_SERVER['REQUEST_URI']));

	}

	$sql = mysql_query("select * from members where member_id='".$member_id."'") or die(mysql_error());

	$res = mysql_fetch_array($sql);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<title><?php echo  $lang['Create New Group'];?></title>

<head>

<link rel="stylesheet" type="text/css" href="css/style.css"/>

<link rel="icon" href="images/favicon.ico" type="image" />

<link rel="shortcut icon" href="images/favicon.ico" type="image" />



<link rel="stylesheet" type="text/css" href="css/format.css"/>

<link rel="stylesheet" type="text/css" href="css/search.css"/>

<link rel="stylesheet" type="text/css" href="css/dropdown.css"/>

<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />

<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css" />

<link rel="stylesheet" type="text/css" href="css/bootstrap-reset.css" />

<link rel="stylesheet" type="text/css" href="css/responsive.css" />

<link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.css" />

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


</head>

<body>

<div id="wrapper">

<?php include('includes/header.php');?>

<div id="mainbody">

<div class="column_left">

	

    <div class="componentheading">

    <div id="submenushead"><?php echo  $lang['Create New Event'];?></div>

    </div>

<?php 

if(isset($_REQUEST['event_input']) && isset($_REQUEST['event_date']) && isset($_REQUEST['where_event']) && 0 < strlen($_REQUEST['event_input']) && 0 < strlen($_REQUEST['event_date']) && 0 < strlen($_REQUEST['where_event']) ){

	$strEventInput = $_REQUEST['event_input'];

	$strEventDate  = $_REQUEST['event_date'];

	$strWhereEvent = $_REQUEST['where_event'];

	$strEventDescription = $_REQUEST['event_description'];

	

	$date = new DateTime(trim($strEventDate));

	

	

	mysql_query("insert into event values( '','" .$strEventInput."','".$strEventDescription."','','".$date->format('Y-m-d') ."','".$strWhereEvent."','".$_SESSION['SESS_MEMBER_ID']."','','','2','','')") or die(mysql_error());

	$event_id = mysql_insert_id();

	

	mysql_query("insert into event_members (event_id,member_id,status) values('$event_id','$member_id',1)");

	header('Location: mob_my_event.php');

}

?>
    

   <div id="border">

<form id="frm_create_event" action="" method="post" role="form" class="form-horizontal">

 <div class="form-group crt_grp_p">

<p><?php echo $lang['Create your own Event today.'];?>.</p></div>

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

		<input id="datepicker" class="form-control" type="text" value="" name="event_date" placeholder="<?php echo $lang['Enter Date'];?>"></input>

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



<?php include 'ads_right_column.php';?>



</div><!--end mainbody div-->

<?php include 'includes/footer.php';?>

</div><!--end wrapper div-->


</body>

</html>