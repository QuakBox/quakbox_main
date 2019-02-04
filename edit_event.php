<?php
	ob_start();
	session_start();

	require_once('config.php');
	if(!isset($_SESSION['SESS_MEMBER_ID']))
	{
		header("location: ".$base_url."index.php");
		exit();
	}
	$session_member_id = $_SESSION['SESS_MEMBER_ID'];
	include 'includes/time_stamp.php';
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<title>Edit video</title>
<head>

<link rel="stylesheet" type="text/css" href="css/wall.css"/>
<link rel="stylesheet" type="text/css" href="css/search.css"/>
<link rel="stylesheet" type="text/css" href="css/style.css"/>


<link rel="icon" href="images/favicon.ico" type="image" />
<link rel="shortcut icon" href="images/favicon.ico" type="image" />

<script src="js/jquery.min.js"></script>
<script src="js/jquery-1.9.1.js"></script>
<script src="js/youtube.js"></script>
    <script type="text/javascript" src="flowplayer/flowplayer.min.js"></script>
 <link rel="stylesheet" type="text/css" href="flowplayer/skin/minimalist.css">
 <link rel="stylesheet" type="text/css" href="css/youtube.css"/>
<script type="text/javascript">

//change upload link page when i select option btn
                                                          function filetypeshow(obj)
                                                          {
                                                              if(obj.value==0 || obj==0)
                                                              {
                                                                 
                                                                   document.getElementById("typefile").style.display="none";
                                                                 
                                                                  document.getElementById("typeff").style.display="block";

                                                              }
                                                              if(obj.value==1 || obj==1)
                                                              {
																   document.getElementById("typefile").style.display="block";
                                                                  document.getElementById("typeff").style.display="none";
                                                                 

                                                                  

                                                              }
                                                             

                                                          }
                                                         

                                                          document.getElementById("typeff").style.display="none";
</script>
</head>
<body>
<div id="wrapper">
<?php 
$video_id = $_REQUEST['id'];
include('includes/header.php');
$id = $_REQUEST['id'];
$equery = "SELECT e.event_name, e.event_location, e.date_created, e.event_host,
			m.username, m.LastName, e.id, e.datepicker
			FROM event e LEFT JOIN members m ON e.event_host = m.member_id 
			WHERE e.id = '$id'";
$esql = mysqli_query($con, $equery) or die(mysqli_error($con));
$eres = mysqli_fetch_array($esql);
?>
<div id="mainbody">

<div class="column_left">
<div id="submenushead">
<div class="componentheading" style="width:780px !important;">
    <div id="submenushead" style="width:300px;">
    Edit event</div>
    <input type="button" name="add_video" class="button" value="BACK TO EVENTS" onclick="window.open('event_view.php?id=<?php echo $id;?>','_self');" style="border-right:none; float:right; padding:0px; margin-left:10px;" />
    </div>
   
   </div>
   <div id="border">
  <form name="video_upload" method="post" enctype="multipart/form-data" action="action/edit_video-exec.php"> 
  <input type="hidden" name="member_id" value="<?php echo $session_member_id;?>" />
  <input type="hidden" name="event_id" value="<?php echo $id;?>" />
   <table cellpadding="0" cellspacing="1">
<tbody>
<tr>
<td colspan="2"></td>
</tr>


<tr>
<td style="font-weight: bold;text-align: right;width: 130px; padding:5px;vertical-align:top;">
<label style="font-weight: 700;text-align: right;">*Event name</label>
</td>
<td style="padding:5px; vertical-align:top;"><input id="name" class="required inputbox" type="text" value="<?php echo $eres['event_name'];?>" size="45" name="title"></td>
</tr>
<tr>
<td style="font-weight: bold;text-align: right;width: 130px; padding:5px;vertical-align:top;">
<label style="font-weight: 700;text-align: right;">Description</label>
</td>
<td style="padding:5px; vertical-align:top;"><textarea style="rgb(255, 0, 0) !important; width:100%; height:110px;" id="name" class="inputbox" type="text" value="<?php echo $pvres['event_description'];?>" size="45" name="description"></textarea></td>
</tr>
<tr>
<td style="font-weight: bold;text-align: right;width: 130px; padding:5px;vertical-align:top;">
<label style="font-weight: 700;text-align: right;">*Date</label>
</td>
<td style="padding:5px; vertical-align:top;">
<input id="date" class="required inputbox" type="text" value="<?php echo $eres['datepicker'];?>" size="45" name="date"></td>
</tr>
   <tr>
<td style="font-weight: bold;text-align: right;width: 130px; padding:5px;vertical-align:top;">
<label style="font-weight: 700;text-align: right;">*Location</label>
</td>
<td style="padding:5px; vertical-align:top;">
<input id="location" class="required inputbox" type="text" value="<?php echo $eres['event_location'];?>" size="45" name="location"></td>
</tr>
   
<tr>
<td colspan="2"></td>
</tr>
    <tr>
<td style="font-weight: bold;text-align: right;width: 130px; padding:5px;vertical-align:top;">
</td>
<td style="padding:5px; vertical-align:top;">


<input class="button validateSubmit" type="submit" value="Update"></input>
<input class="button" type="button" value="Cancel" onclick="history.go(-1);return false;"></input>

</td>
</tr>

</tbody>
</table>
 </form> 
</div>

</div><!--End column left div-->
</div><!--End mainbody div-->

<?php include 'includes/footer.php';?>
</div><!--End wrapper div-->
</body>
</html>