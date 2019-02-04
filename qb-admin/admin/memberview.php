<?php session_start();

if(isset($_SESSION['id']))
{
	include("config.php");
	$id = $_SESSION['id'];
	$id1= $_GET['id'];
	$query = "SELECT * FROM admins 
			WHERE id = '$id'";
			
			

	$sql = mysqli_query($conn,$query);
	$res = mysqli_fetch_array($sql);
	$res1= $res['email'];
	?>

<!DOCTYPE HTML>
<html>
<body>

<?php


$query1 = "SELECT * FROM members WHERE member_id= '$id1'";
$sql1 = mysqli_query($conn,$query); 
?>
<table border='1'>
<tr><th>Members Detail</th><th>Information</th></tr>"
<?php
while($row = mysqli_fetch_array( $sql1 )) {
	// Print out the contents of each row into a table
	?>
	<tr><td>Member ID</td> 
	<td><?php echo $row['member_id']; ?></td></tr>
	<tr><td>Profile Image</td> 
	<td><?php echo "<img src='".$row['profImage']."' height='100' width='100'/>";?></td></tr>
	
	<?php
} ?>

</table><br>



</body>
</html>



<?php
}

else
header("Location: login.php");
?>
