<?php 
//header( 'Content-Type: text/html; charset=utf-8' ); 
include('config.php');
 $msg12 = mysqli_real_escape_string($con, $_POST['vara']);
 $id11 =$_POST['vara1'];
 $lan=$_POST['vara2'];
mysqli_query($con, "INSERT INTO message1 (msg_id,message,tr_id) VALUES('$id11','$msg12','".$lan."')");
echo $last_id= mysqli_insert_id($con);


/*$sql = mysqli_query("select * from message1");

while($row = mysqli_fetch_array($sql))
{
	echo $row['hi'];
}

?>
<?php include "translate_file.php"; ?>
<?php 

for($i==0;$i<=2;$i++)
{
	
	if($i==1)
	{
		$lan="ar";
	?>

<script>
alert(<?php echo $last_id ;?>);

var lan="<?php echo $lan;?>";
var id="<?php echo $last_id;?>";
var text="<?php echo $msg12;?>";

call(lan,id,text);

</script>

<?php }} ?>*/