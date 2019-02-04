<?php
require_once("connection/qb_database.php");

class notification
{
function select_notification($member_id)		
{
		$sql="SELECT * FROM notifications WHERE received_id = '$member_id'";
		$db_Obj=new database();
		$rs=$db_Obj->execQueryWithFetchAll($sql);
		return $rs;
}
function view_notifications($sender_id,$member_id,$limit_value)		
{
		$sql="SELECT * FROM notifications WHERE sender_id='$sender_id' AND is_unread = 0 AND received_id = '$member_id' ORDER BY id DESC LIMIT $limit_value";
		$db_Obj=new database();
		$rs=$db_Obj->execQueryWithFetchAll($sql);
		return $rs;
}

function insert_notifications($sender_id,$receiver_id,$type_of_notifications,$url,$time)
{
	$sql="INSERT INTO notifications (sender_id, received_id, type_of_notifications, href, is_unread, date_created)
				VALUES('$sender_id','$receiver_id',$type_of_notifications,'$url',0,'$time')";
				$db_Obj=new database();
				$rs=$db_Obj->execQuery($sql);
				return $rs;
}


function getNotification($memberID,$limit_value)
{

	if($limit_value>0){
		$sql="SELECT * FROM notifications n LEFT JOIN member m ON m.member_id = n.sender_id
	  			WHERE n.is_unread = 0 AND received_id = '$memberID'  ORDER BY id DESC LIMIT $limit_value";	
	}
	else{
		$sql="SELECT * FROM notifications n LEFT JOIN member m ON m.member_id = n.sender_id
	  			WHERE n.is_unread = 0 AND received_id = '$memberID'  ORDER BY id DESC LIMIT 5";	
	}	
						
	$db_Obj=new database();
	$results=$db_Obj->execQueryWithFetchAll($sql);
	
	/*$sql2="update notifications set is_unread='1' where id='$id'";
	$db_Obj2=new database;
	$rs = $db_Obj2-> execQuery($sql2); */

	return $results;
}

function getCountOfUnreadNotification($memberID)
{
	$sql="select count(n.id) AS count from notifications n,member m where n.received_id= m.member_id AND  n.received_id='$memberID' AND is_unread = 0";
	$db_Obj=new database();
	$results=$db_Obj->execQueryWithFetchAll($sql);
	return $results;
	
}


}



?>