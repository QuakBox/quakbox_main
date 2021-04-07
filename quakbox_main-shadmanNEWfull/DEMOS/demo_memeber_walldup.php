<?php
session_start();
include('config.php');
$lastid = $_POST["lastid"]; // save the posted value in a variable
	//$wall_type=$_POST["wall_type"];
	//$country_code=$_POST['country_flag'];
	$member_id = $_SESSION['SESS_MEMBER_ID'];
	
	
	
$fquery = "select m.member_id from friendlist f,members m where f.member_id=m.member_id and f.added_member_id = '".$_SESSION['SESS_MEMBER_ID']."' AND status != 0";
$fsql = mysqli_query($con, $fquery);



if(mysqli_num_rows($fsql) > 0)
{
while($fres = mysqli_fetch_array($fsql))
{
	$ids[] = $fres['member_id'];
$result_row1 = "'";
$result_row1.= implode("','",$ids);
$result_row1.= "'";
}

}
else
{
	$result_row1 = $member_id;
}

	
	//echo $lastid;
	
	
	
	
	
	
$query = "SELECT msg.content_id, msg.country_flag, msg.date_created, msg.messages_id, msg.member_id, 
m.profImage, m.username, msg.type, msg.messages, msg.msg_album_id, u.upload_data_id, msg.share,
msg.video_id, msg.share_by, msg.wall_privacy
FROM message msg
LEFT JOIN status_share s ON ( msg.messages_id = s.msg_id )
LEFT JOIN members m ON msg.member_id = m.member_id
LEFT JOIN upload_data u on msg.messages_id = u.msg_id
WHERE msg.content_id ='$member_id'
OR (msg.member_id in ($result_row1)
OR msg.member_id = '$member_id'
OR s.share_on_member = '$member_id')
AND msg.photo_status != 1
GROUP BY messages_id having msg.messages_id <'$lastid'
ORDER BY messages_id DESC LIMIT 1";
			//echo $query;
$result = mysqli_query($con, $query) or die(mysqli_error($con));

$nid="";
while($row=mysqli_fetch_array($result))	
{
	$nid22=$row['messages_id'];
	echo $nid22;
	
}


?>