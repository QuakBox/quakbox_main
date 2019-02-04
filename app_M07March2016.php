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

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<?php include('includes/files.php');?>
</head>

<body>
 <?php include 'includes/header.php';?>
 <div style="width: 754px; margin: 78px 0px -18px 295px;">
<?php include_once 'ads_column.php';?>
</div>
<div style="margin: 100px 0px 0px 253px; overflow-x: auto; padding: 9px; width: 576px;">
<p style="font-size: 24px; color: rgb(51, 51, 51); padding-bottom: 22px;">Apps</p>
<?php 

$query=mysqli_query($con, "select *from app where status='1'");
while($res=mysqli_fetch_array($query))
{
?>
<div style="padding: 5px; border-bottom: 1px solid  #999;">


<a href="app1.php?code=<?php echo $res['id'];?>" ><img src="<?php echo $res['image'];?>" style="width: 100px; padding-right: 4px; margin: 1px 0px 0px 1px;" /><P  style="font-size: 17px; color: rgb(125, 94, 77); float: left; margin: 8px -558px 0px 118px; width:438px;"><?php echo $res['name'];?> </P></a>
</div>

<?php }?>

</div>



 <?php include 'includes/footer.php';?>
</body>
</html>