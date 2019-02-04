<?php
include_once("connection/qb_database.php");

class groups
{

	function getGroupByID($groupID){		
		$sql = "SELECT * FROM groups WHERE id='$groupID'";
		$db_Obj = new database();
		$results = $db_Obj->execQueryWithFetchAll($sql); 
		return $results;
	}
	function getGroupMembersByID($groupID,$limit){		
		$sql = "select m.username,m.member_id 
			from groups_members gm inner join member m ON m.member_id = gm.member_id
		    	WHERE gm.groupid = '$groupID'
			and gm.approved != 0
			order by rand()
			LIMIT $limit";
		$db_Obj = new database();
		$results = $db_Obj->execQueryWithFetchAll($sql); 
		return $results;
	}
	function view_latest_post($encryptedGroupID)
	{
		$QbSecurityPost=new QB_SqlInjection();
		$groupID=$QbSecurityPost->QB_AlphaID($encryptedGroupID,true);		
		$sql = "SELECT msg.messages_id, msg.messages, msg.date_created, msg.type, m.member_id,msg.country_flag,msg.msg_album_id,
		             m.username, u.photo_id,msg.share,msg.video_id,
		             msg.share_by, v.location,v.location1,v.location2, v.thumburl, v.title,v.video_id, v.description,
 			         v.msg_id, v.category, v.title_color,v.title_size,v.ads,msg.share_msg
		             FROM groups_wall msg LEFT JOIN member m ON msg.member_id = m.member_id 
		             LEFT JOIN groups_photo u on msg.messages_id = u.msg_id		  
		             LEFT JOIN videos v ON v.msg_id = msg.messages_id 		             
		             WHERE msg.group_id= '".$groupID."'		  
		             GROUP BY msg.messages_id 
		             ORDER BY date_created DESC
			     LIMIT 10 ;";
		$db_Obj = new database();	
		$results = $db_Obj->execQueryWithFetchAll($sql); 
		return $results;
	}
	function view_latest_post_by_last_id($encryptedGroupID,$last_id)
	{
		$QbSecurityPost=new QB_SqlInjection();
		$groupID=$QbSecurityPost->QB_AlphaID($encryptedGroupID,true);
		$sql = "SELECT msg.messages_id, msg.messages, msg.date_created, msg.type, m.member_id,msg.country_flag,msg.msg_album_id,
		             m.username, u.photo_id,msg.share,msg.video_id,
		             msg.share_by, v.location,v.location1,v.location2, v.thumburl, v.title,v.video_id, v.description,
 			         v.msg_id, v.category, v.title_color,v.title_size,v.ads,msg.share_msg
		             FROM groups_wall msg LEFT JOIN member m ON msg.member_id = m.member_id 
		             LEFT JOIN groups_photo u on msg.messages_id = u.msg_id		  
		             LEFT JOIN videos v ON v.msg_id = msg.messages_id 		             
		             WHERE msg.group_id= '".$groupID."'	
		             AND msg.messages_id < '$last_id'	  
		             GROUP BY msg.messages_id 
		             ORDER BY date_created DESC
			     LIMIT 5 ;";
		$db_Obj = new database();
		$results = $db_Obj->execQueryWithFetchAll($sql); 
		return $results;	
	}
	function view_latest_post_by_top_id($encryptedGroupID,$top_id)
	{
		$QbSecurityPost=new QB_SqlInjection();
		$groupID=$QbSecurityPost->QB_AlphaID($encryptedGroupID,true);		
		$sql = "SELECT msg.messages_id, msg.messages, msg.date_created, msg.type, m.member_id,msg.country_flag,msg.msg_album_id,
		             m.username, u.photo_id,msg.share,msg.video_id,
		             msg.share_by, v.location,v.location1,v.location2, v.thumburl, v.title,v.video_id, v.description,
 			         v.msg_id, v.category, v.title_color,v.title_size,v.ads,msg.share_msg
		             FROM groups_wall msg LEFT JOIN member m ON msg.member_id = m.member_id 
		             LEFT JOIN groups_photo u on msg.messages_id = u.msg_id		  
		             LEFT JOIN videos v ON v.msg_id = msg.messages_id 		             
		             WHERE msg.group_id= '".$groupID."'	
		             AND msg.messages_id > '$top_id'	  
		             GROUP BY msg.messages_id 
		             ORDER BY date_created DESC
			     LIMIT 5 ;";
		$db_Obj = new database();
		$results = $db_Obj->execQueryWithFetchAll($sql); 
		return $results;	
	}	
	function insert_post_status($memberID,$status,$encryptedGroupID,$type){	
		$db_Obj = new database();
		$QbSecurityPost=new QB_SqlInjection();
		$datecreated=strtotime(date('Y-m-d H:i:s'));
		$status=$db_Obj->cleanString($status);
		$groupID=$QbSecurityPost->QB_AlphaID($encryptedGroupID,true);
		$sql = "INSERT INTO groups_wall (member_id,messages,group_id,type,date_created) ";
		$sql .="VALUES('$memberID','$status','$groupID','$type','$datecreated');";		
		$rs = $db_Obj->insertQueryReturnLastID($sql); 
		return $rs; 
	}	
	


	

		
		
}



?>