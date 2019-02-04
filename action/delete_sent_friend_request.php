<?php ob_start();
require_once('../config.php');
$add_member_id = $_SESSION['SESS_MEMBER_ID'];
$member_id = mysqli_real_escape_string($con, f($_REQUEST['id'],'escapeAll'));
if(empty($member_id)){
	exit();
}
$sql = "delete from friendlist where member_id='$member_id' AND added_member_id = '$add_member_id'";
$responce = mysqli_query($con, $sql);

?>
<script type="text/javascript">
window.history.back();
</script>