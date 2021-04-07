<?php
//echo "hi";
include('config.php');
$country=$_POST['country'];

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