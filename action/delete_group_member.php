<?php 
/**
   * This page helps to delete a member from group
   * 
   * @package    Group
   * @author     Vishnu NCN
   * Created date  02/03/2015 08:02:16
   * Updated date  02/26/2015 05:53:05
   * Updated by    Vishnu NCN
   */
ob_start();
require_once('../config.php');
$member_id = mysqli_real_escape_string($con, f($_REQUEST['member_id'],'escapeAll'));
if(empty($member_id)){
	exit();
}
$sql = "delete from groups_members where member_id='$member_id'";

//echo $sql;
//echo "<br>";
//echo $member_id;
//if(mysqli_num_rows($sql) == 0){
//	exit();
//}
$responce = mysqli_query($con, $sql);

?>
<script type="text/javascript">
	window.history.back();
</script>