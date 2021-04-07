<?php

require_once('common/common.php');

$lastid = $QbSecurity->qbClean($_POST["lastid"], $con);
$lastid=htmlspecialchars(trim($lastid)); // save the posted value in a variable
	$wall_type=$QbSecurity->qbClean($_POST["wall_type"], $con);
	$wall_type=htmlspecialchars(trim($wall_type));
	$country_code=$QbSecurity->qbClean($_POST['country_flag'], $con);
	$country_code=htmlspecialchars(trim($country_code));
$query = "SELECT msg.messages_id, msg.msg_album_id, msg.messages,msg.date_created, 
			msg.country_flag, msg.type, m.member_id, m.profImage,msg.video_id,msg.share,
			msg.share_by,msg.wall_privacy,
			m.username, u.upload_data_id FROM message msg 
			LEFT JOIN members m ON msg.member_id = m.member_id 
			LEFT JOIN upload_data u ON msg.messages_id = u.msg_id 
			WHERE msg.country_flag = '$country_code'
			AND messages_id < '$lastid' 
			ORDER BY msg.messages_id DESC
			LIMIT 1";
			//echo $query;
$result = mysqli_query($con, $query) or die(mysqli_error($con));

$nid="";
while($row=mysqli_fetch_array($result))	
{
	$nid22=$row['messages_id'];
	echo $nid22;
	
}


?>