<?php
	ob_start();
	session_start();
	
	if(isset($_SESSION['lang']))
	{	
		include('common.php');
	}
	else
	{
		include('Languages/en.php');
		
	}
	require_once('config.php');
	require_once('includes/time_stamp.php');
	require_once('qb_classes/qb_news.php');

	$news = new QB_News();

	$member_id = $_SESSION['SESS_MEMBER_ID'];
	$url = mysqli_real_escape_string($con, $_REQUEST['url']);
	
	$member = mysqli_query($con, "select * from members where member_id = '$member_id'");
	$member_res = mysqli_fetch_array($member);
	$sql = mysqli_query($con, "select * from news where url='".$url."'") or die(mysqli_error($con));
	$ures = mysqli_fetch_array($sql);
	$news_id = $ures['news_id'];
	$country_id = $ures['country_id'];

	$csql = mysqli_query($con, "select * from geo_country where country_id='".$country_id."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($csql);
	$country_code = $res['country_title'];
        
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $ures['title'];?></title>
<head>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css" />
<link rel="stylesheet" type="text/css" href="css/jquery-ui.css"/>
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css"/>
<link rel="stylesheet" type="text/css" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"/>

<script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
<script src="sjs/jquery.min.js"></script>

</head>
<body>
<div id="wrapper">
<?php include('includes/qb_header.php');?>

    
<div class="row" style="padding:0.1px; margin:0.1px ; margin-top:25px;">   
   
    <div class="col-md-2" >
        <?php include 'includes/news_left_panel.php'; ?>
    </div>
    <div class="col-md-8" >
        
        <div class="well" style='position:fixed;width: 65%'>
        <?php include 'includes/qb_header_news.php'; ?>
        </div>
        <br/><br/><br/><br/>

        <div class="panel panel-primary"  style="border: 0;">
        <div class="panel-heading" style="height: 20px;padding: 1px;"><?php echo $ures['title']; ?></div>
          <div class="panel-body">
              <center><img src="<?php echo str_replace(' ', '%20', $ures['image_url']); ?>" style="max-width: 300px" /></center>
           <?php echo str_replace('\r\n', '<br/>', $ures['description']) ; ?>
          </div>
        </div> 
    </div>

    

 
  
    <div class="col-md-2 nopadding"  style="float: right !important;">
        <?php include 'includes/news_right_panel.php'; ?>
    </div>
    

 </div>

    
<?php include_once 'share.php';?>
<?php include 'includes/qb_footer.php';?>    
</div>
</body>
</html>





