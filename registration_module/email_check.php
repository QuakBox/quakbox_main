<?php
include('config.php');
$memberid=$_POST['memberid'];
$email=$_POST['email'];
//echo "hi";
//echo $memberid;
if($email!="")
{
$sql="select * from members where email_id='$email' && member_id!=$memberid";
//echo $sql;
$st=mysqli_query($con, $sql);
$count=mysqli_num_rows($st);
if($count>0)
{
echo "<font color='red'>Email Already Exist</font>";
?>
<script>
$("#emailstat2").val('1');
</script>

<?php
}
else
{
echo "<font color='green'>Email Available</font>";
?>
<script>
$("#emailstat2").val('0');

</script>
<?php
}

?>

<?php
}
?>

