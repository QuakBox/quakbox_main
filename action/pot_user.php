<?php ob_start();
//echo "hi";
include('config.php');
$country=$_POST['country'];
$country   = f($country, 'strip');
$country	 = 	f($country, 'escapeAll');
$country   = mysqli_real_escape_string($con, $country);

$sql="select * from members where country='$country'";
$count=mysqli_num_rows(mysqli_query($con, $sql));
//echo $count;
if($count!=0)
{
?>
<font color="green">You Can Reach Upto <?php echo $count;?> Users</font>
<?php
}
?>