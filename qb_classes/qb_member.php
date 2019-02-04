<?php
include_once($_SERVER['DOCUMENT_ROOT']."/qb_classes/connection/qb_database.php");
include_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_security.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_lookup.php');

class Member
{
	var $member_id;
	var $member_displayname;
	var $member_email;
	var $member_current_profile_image;

	function get_member_data($memberID)
	{
		$sql = "SELECT * FROM member WHERE member_id ='$memberID'";
		$db_Obj = new database();
		$results = $db_Obj->execQueryWithFetchObject($sql);
		return $results;
	}
	function get_member_age($memberID)
	{
		$sql = "SELECT dob FROM member WHERE member_id ='$memberID'";
		$db_Obj = new database();
		$results = $db_Obj->execQueryWithFetchObject($sql);
		$dob=$results->dob;
		$diff = (date('Y') - date('Y',strtotime($dob)));
    
		return $diff;
	}
	function get_member_username($memberID)
	{
		$sql = "SELECT username FROM member WHERE member_id ='$memberID'";
		$db_Obj = new database();
		$results = $db_Obj->execQueryWithFetchObject($sql);
		return $results->username;
	}

	

	function get_member_name($memberID)
	{
		$sql = "SELECT displayname FROM member WHERE member_id ='$memberID'";
		$db_Obj = new database();
		$results = $db_Obj->execQueryWithFetchObject($sql);
		return $results->displayname;
	}

	function get_member_email($memberID)
	{
		$sql = "SELECT email FROM member WHERE member_id ='$memberID'";
		$db_Obj = new database();
		$results = $db_Obj->execQueryWithFetchObject($sql);
		return $results->email;
	}

	function get_id_by_username($username)
	{
		$sql = "SELECT member_id FROM member WHERE username ='$username'";
		$db_Obj = new database();
		$results = $db_Obj->execQueryWithFetchObject($sql);
		return $results->member_id;
	}

	function get_username_by_id($id)
	{
		if(isPageVisibleForEveryone()){
			return '';
		}

		$sql = "SELECT username FROM member WHERE member_id ='$id'";
		$db_Obj = new database();
		$results = $db_Obj->execQueryWithFetchObject($sql);
		return $results->username;
	}



	function get_member_friends_count($memberID)
	{
		$db_Obj = new database();
		$friends_count = $db_Obj->execQueryWithFetchObject("select COUNT(*) AS fcount from friendlist where added_member_id = '$memberID'");
		return $friends_count->fcount;
	}



	function get_member_friends_emails($memberID)
	{
		$friends_emails = "" ;
		$db_Obj = new database();
		$fsql = "SELECT added_member_id, friendlist.member_id, `member`.email As added_email, memb.email member_email
		FROM friendlist
		INNER JOIN `member` ON `member`.`member_id` = `friendlist`.`added_member_id`
		INNER JOIN `member` AS memb ON memb.`member_id` = `friendlist`.`member_id`
		WHERE added_member_id = '$memberID'";
		$results = $db_Obj->execQueryWithFetchAll($fsql);
		foreach( $results as $row )
		{
			$member=  $row['member_id'];
			$added = $row['added_member_id'];

			if($memberID != $member)
			{
				$friends_emails = $friends_emails . "," . $row['member_email'];
			}
			else
			{
				$friends_emails = $friends_emails . "," . $row['added_email'];
			}
		}

		return $friends_emails;
	}

	function get_member_friends_ids($memberID, $limit = 0)
	{
		$friends_ids = [];
		$db_Obj = new database();
		$fsql = "SELECT added_member_id, friendlist.member_id, `member`.email As added_email, memb.email member_email
		FROM friendlist
		INNER JOIN `member` ON `member`.`member_id` = `friendlist`.`added_member_id`
		INNER JOIN `member` AS memb ON memb.`member_id` = `friendlist`.`member_id`
		WHERE added_member_id = '$memberID'";

		if($limit > 0) {
			$fsql .= ' LIMIT '.$limit;
		}

		$results = $db_Obj->execQueryWithFetchAll($fsql);

		foreach( $results as $row )
		{
			$member=  $row['member_id'];
			$added = $row['added_member_id'];

			if($memberID != $member)
			{
				$friends_ids[] = $member;
			}
			else
			{
				$friends_ids[] = $added;
			}
		}

		unset($db_Obj);
		return implode(',', $friends_ids);
	}

	function get_member_friends_friends_ids($list, $memberId, $limit = 13)
	{
		$listArr = $list;
		$list = implode(',', $list);

		$db_Obj = new database();
		$fsql = "SELECT added_member_id, friendlist.member_id, `member`.email As added_email, memb.email member_email
		FROM friendlist
		INNER JOIN `member` ON `member`.`member_id` = `friendlist`.`added_member_id`
		INNER JOIN `member` AS memb ON memb.`member_id` = `friendlist`.`member_id`
		WHERE added_member_id IN ($list)";
		if($limit > 0) {
			$fsql .= ' LIMIT '.$limit;
		}
		$results = $db_Obj->execQueryWithFetchAll($fsql);
		$friends_ids = [];

		foreach( $results as $row )
		{
			if(!in_array($row['member_id'], $listArr) && $memberId != $row['member_id']) {
				$friends_ids[] = $row['member_id'];
			}
		}

		unset($db_Obj);
		return implode(',', $friends_ids);
	}
}
