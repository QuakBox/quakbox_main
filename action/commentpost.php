<?php

/**
   * @package      action
   * @subpackage   commentpost.php
   * @author        Vishnu 
   * Created date  02/11/2015 
   * Updated date  03/27/2015 
   * Updated by    Vishnu S
 **/

 require_once('../common/common.php');

$member_id = $QbSecurity->qbClean($_REQUEST['member_id'], $con);
$member_id =htmlspecialchars(trim($member_id));

$messages = $QbSecurity->qbClean($_REQUEST['postcomment'], $con);

$messages =htmlspecialchars(trim($messages ));

$postid =$QbSecurity->qbClean($_REQUEST['postid'], $con);
$postid =htmlspecialchars(trim($postid));

$type = $QbSecurity->qbClean($_REQUEST['type'], $con);

$type=htmlspecialchars(trim($type));

echo $sql="INSERT INTO postcomment (post_member_id,msg_id,content, type, date_created)
VALUES
('$member_id','$postid','$messages','$type','".strtotime(date("Y-m-d H:i:s"))."')";

mysqli_query($con, $sql);
		$url = $_SERVER['HTTP_REFERER'];
header("location: ".$url."");	
exit();

?>