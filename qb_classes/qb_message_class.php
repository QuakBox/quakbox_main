<?php
require_once("connection/qb_database.php");

class messages
{
	function viewUnreadMessages($member_id)
	{
	 	$sql="SELECT * FROM cometchat WHERE cometchat.to = $member_id AND cometchat.read != 1 ORDER BY id DESC LIMIT 5";
		$obj=new database();
		$rs=$obj->execQuery($sql);
		return $rs;
	}
	
	function count_unread_messages($member_id)
	{
		$sql="SELECT COUNT(cometchat.id) FROM cometchat WHERE cometchat.to=$member_id  AND cometchat.read !=1";
		$db_obj=new database();
		$rs=$db_obj->execQueryWithFetchAll($sql);
		return $rs;
	}
	
	
	
}
?>