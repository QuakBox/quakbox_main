<?php ob_start();
session_start();
include_once '../config.php';

$session_member_id = $_SESSION['SESS_MEMBER_ID'];
$member_id = (int)$_POST['member_id'];
$share_query  = "SELECT username,profImage from members where member_id  = '$member_id'";
$share_result = mysqli_query($con, $share_query) or die(mysqli_error($con));
$row = mysqli_fetch_array($share_result);

?>

<input type="hidden" name="session_member_id" value="<?php echo $session_member_id;?>" >
<input type="hidden" name="member_id" value="<?php echo $member_id;?>" >
<div class="bdayimg">
<img src="<?php echo $row['profImage']; ?>" class='big_face'/>
</div>
<div class="bdaytext">
<div style="padding:3px;"><b><?php echo $row['username'];?></b>'s birthday is today</div>
<textarea name="bmessage" id="bmessage" style="padding:3px; width:100%; height:20px;" placeholder="Message" required></textarea>
</div>

