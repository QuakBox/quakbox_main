<?php 
class friend {
	//to check friends or not
	public function is_friend($from, $to, $con) {
		$query = mysqli_query($con, "SELECT * FROM friendlist WHERE (added_member_id = '$member_id' AND                               member_id='$member') OR
		                      (member_id = '$member_id' AND added_member_id='$member') 
							  ") or die(mysqli_error($con));	    		
		$data = mysqli_num_rows($query);		
		
		return $data;
	}
	
	//count friends
	public function friend_count($member, $con) {
		$query = mysqli_query($con, "SELECT m.member_id FROM 
		                     friendlist f INNER JOIN members m ON f.added_member_id = m.member_id
							 where f.member_id = '".$member."' 
							  ") or die(mysqli_error($con));	    		
		$data = mysqli_num_rows($query);		
		
		return $data;
	}
	
	//fetch friend list
	public function friend_list($to, $con) {
		$query = mysqli_query($con, "SELECT * FROM friendlist f INNER JOIN members m 
		                      ON f.added_member_id = m.member_id 
							  WHERE f.member_id = '$to'") or die(mysqli_error($con));
	    while($row = mysqli_fetch_array($query))
		$data[] = $row;		
		
		return $data;
	}
	
	//fetch latest members
	public function latest_members($con) {
		$query = mysqli_query($con, "SELECT * FROM members WHEER member_id!='$member_id' 
		                      ORDER BY member_id DESC") or die(mysqli_error($con));
	    while($row = mysqli_fetch_array($query))
		$data[] = $row;		
		
		return $data;
	}
	
	//fetch request sent members
	public function request_sent_list($id, $con) {
		$query = mysqli_query($con, "SELECT * FROM friendlist a INNER JOIN members b
		                      ON a.member_id = b.member_id  
		                      WHERE a.added_member_id = '$id' 
							  AND a.status = 0") or die(mysqli_error($con));
	    while($row = mysqli_fetch_array($query))
		$data[] = $row;		
		
		return $data;
	}
	
	//fetch pending request members
	public function pending_request_list($id, $con) {
		$query = mysqli_query($con, "SELECT * FROM friendlist a INNER JOIN members b
		                      ON a.added_member_id = b.member_id  
		                      WHERE a.member_id = '$id' 
							  AND a.status = 0") or die(mysqli_error($con));
	    while($row = mysqli_fetch_array($query))
		$data[] = $row;		
		
		return $data;
	}
}

class wall {
	//fetch all posts on World wall
	public function get_world_wall_post($con) {
		$query = mysqli_query($con, "SELECT msg.messages_id, msg.messages, msg.date_created, msg.type, msg.wall_privacy, m.member_id,
		  msg.msg_album_id, m.username, m.profImage, msg.country_flag, u.upload_data_id,msg.share,msg.video_id
		  , msg.share_by,m.username, v.thumburl
		  FROM message msg LEFT JOIN members m ON msg.member_id = m.member_id 
		  LEFT JOIN upload_data u on msg.messages_id = u.msg_id		  
		  LEFT JOIN videos v ON v.msg_id = msg.messages_id
		  WHERE msg.country_flag='world'		  
		  GROUP BY msg.messages_id 
		  ORDER BY date_created DESC
		  LIMIT 10") or die(mysqli_error($con));
	    while($row = mysqli_fetch_array($query))
		$data[] = $row;		
		
		return $data;
	}
	
	//fetch all posts on country wall
	public function get_country_wall_post($country, $con) {
		$query = mysqli_query($con, "SELECT msg.messages_id, msg.msg_album_id, msg.messages,msg.date_created, 
			msg.country_flag, msg.type, m.member_id, m.profImage,msg.video_id,msg.share,
			msg.share_by,
			m.username, u.upload_data_id FROM message msg 
			LEFT JOIN members m ON msg.member_id = m.member_id 
			LEFT JOIN upload_data u ON msg.messages_id = u.msg_id 
			WHERE msg.country_flag = '$country_code' 
			ORDER BY msg.date_created DESC") or die(mysqli_error($con));
	    while($row = mysqli_fetch_array($query))
		$data[] = $row;		
		
		return $data;
	}
	
	//fetch all comments
	public function get_comments($msg_id, $con) {
		$query = mysqli_query($con, "SELECT * FROM postcomment a INNER JOIN members b ON  
		                      WHERE p.post_member_id = m.member_id 
							  AND p.msg_id=" . $row['messages_id'] . " 
							  ORDER BY a.comment_id DESC limit 0,4") or die(mysqli_error($con));
	    while($row = mysqli_fetch_array($query))
		$data[] = $row;		
		
		return $data;
	}
	
	//fetch all replys
	public function get_replys($comment_id, $con) {
		$query = mysqli_query($con, "SELECT * FROM comment_reply c INNER JOIN members m 
		                      WHERE c.member_id = m.member_id 
							  AND comment_id='$comment_id' 
							  ORDER BY reply_id DESC limit 0,2") or die(mysqli_error($con));
	    while($row = mysqli_fetch_array($query))
		$data[] = $row;		
		
		return $data;
	}
	
	//insert and fetch posts data
	public function insert_update($update,$member_id,$country,$privacy,$content_id,$share_member_id,$unshare_member_id, $con,) {
		$time = time();
	    $ip = $_SERVER['REMOTE_ADDR'];
		$query = mysqli_query($con, "INSERT INTO message member_id,content_id,messages,
		                      country_flag,type,wall_privacy,
		                      share_member_id,unshare_member_id,date_created)
                              VALUES('$member_id','$content_id','".$update."',
							  '$country',0,'".$privacy."','".$share_member_id."',
							  '".$unshare_member_id."',
							  '$time')") or die(mysqli_error($con));
							  
		$msgquery = mysqli_query($con, "SELECT * FROM message msg INNER JOIN members m 
		                        ON msg.member_id = m.member_id 
								WHERE country_flag = '$country' 
								ORDER BY msg.messages_id DESC
								LIMIT 1") or die(mysqli_error($con));
	    $row = mysqli_fetch_array($msgquery);				
		
		return $row;
	}
	
	//insert and fetch comment data
	public function insert_comment($comment,$member_id,$msg_id, $con,) {
		$time = time();	    
		$query = mysqli_query($con, "INSERT INTO postcomment (post_member_id,msg_id,content, type, date_created)
                              VALUES ('$member_id','$msg_id','$comment','1','$time')") or die(mysqli_error($con,));
							  
		$msgquery = mysqli_query($con, "SELECT * FROM postcomment p INNER JOIN members m 
		                        ON p.post_member_id = m.member_id 
								WHERE p.msg_id = '$msg_id' 
								ORDER BY p.comment_id DESC LIMIT 1") or die(mysqli_error($con,));
	    $row = mysqli_fetch_array($msgquery);				
		
		return $row;
	}
	
	//insert and fetch reply data
	public function insert_reply($comment,$member_id,$comment_id, $con) {
		$time = time();	    
		$query = mysqli_query($con, "INSERT INTO comment_reply (member_id,comment_id,content, date_created)
VALUES('$member_id','$comment_id','$comment','$time')") or die(mysqli_error($con,));
							  
		$msgquery = mysqli_query($con, "SELECT * FROM comment_reply a INNER JOIN members m 
		                         ON m.member_id = a.member_id WHERE comment_id = '$comment_id' 
								 ORDER BY reply_id desc LIMIT 1") or die(mysqli_error($con,));
	    $row = mysqli_fetch_array($msgquery);				
		
		return $row;
	}
	
	//delete post
	public function delete_post($member_id,$msg_id) {		
        return true;
	}	
}

class members {
	//fetch all member details
	public function member_details($id) {
		$query = mysqli_query($con, "SELECT * FROM members WHERE member_id = '$id'") or die(mysqli_error($con,));
	    $row=mysqli_fetch_array($query);				
		
		return $row;
	}
}
?>