<?php ob_start();
	session_start();
	//error_reporting(0);
	//if(!isset($_SESSION['SESS_MEMBER_ID']))
	//{
	///	header("location:index.php?back=". urlencode($_SERVER['REQUEST_URI']));
	//}
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
	require_once('includes/tolink.php');
	//$member_id = $_SESSION['SESS_MEMBER_ID'];
	//$sql = mysqli_query("select * from members where member_id='".$member_id."'") or die(mysqli_error());
	//$res = mysqli_fetch_array($sql);

$req['code']=$_REQUEST['code'];
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<?php //include('includes/files.php');?>
</head>

<body>
 <?php include 'includes/qb_header.php';?>

<?php 
$query = mysqli_query($con, "select * from app where id=".$req['code']."");
$res = mysqli_fetch_assoc($query);
//echo $res['id'];
$url = $res['url'];
$url = explode("://", $url);

if(!empty($_SERVER["HTTPS"])){
	if($_SERVER["HTTPS"]!=="off") {
		$res_url = 'https://'. $url[1];
	} else {
		$res_url = 'http://'. $url[1];
	}
} else {
	$res_url = 'http://'. $url[1];
}
?>
<div style="margin: 100px 0px 50px 100px; width:810px; display: inline-block">
	<iframe src="<?php echo $res_url; ?>" width="800" height="800" frameborder="no" scrolling="no"></iframe>
</div>

 <div style="margin: 100px 0px 0px 50px; overflow-x: auto; padding: 9px; width: 576px; display: inline-block;  vertical-align: top">
	 <p style="font-size: 24px; color: rgb(51, 51, 51); padding-bottom: 22px;">Apps</p>
	 <?php
	 $query=mysqli_query($con, "select * from app where status='1'");
	 while($res=mysqli_fetch_array($query)) { ?>
		 <div style="padding: 5px; border-bottom: 1px solid  #999;">
			 <a href="app1.php?code=<?php echo $res['id'];?>" ><img src="<?php echo $res['image'];?>" style="width: 100px; padding-right: 4px; margin: 1px 0px 0px 1px;" /><P  style="font-size: 17px; color: rgb(125, 94, 77); float: left; margin: 8px -558px 0px 118px; width:438px;"><?php echo $res['name'];?> </P></a>
		 </div>
	 <?php } ?>
 </div>

 <?php //include 'includes/footer.php';?>

</body>
</html>