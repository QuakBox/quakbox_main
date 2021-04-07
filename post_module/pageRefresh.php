<?php ob_start();
	  session_start();
	
		include_once 'config.php';
		include_once 'includes/time_stamp.php';
		include_once("function.php");
		
		$output = array();

//  newly added comnt fetching code -----start		
$sqlCount = "select p.comment_id,p.content,p.date_created,p.msg_id,m.profImage,m.username FROM postcomment p,members m  WHERE p.post_member_id=m.member_id and p.isread='0' and p.post_member_id!=".$_SESSION['SESS_MEMBER_ID']."  and updated > date_sub(now(), interval 1 minute) order by comment_id desc";
$resCount = mysqli_query($con, $sqlCount) or die(mysqli_error($con));

		if(mysqli_num_rows($resCount)>0) {
			while($rowCount = mysqli_fetch_assoc($resCount)) { 
			if ($rowCount['content'] != "") {
				$com_id[] = $rowCount['comment_id'];	
				$comment[] = $rowCount['content'];
				$time[] = time_stamp_vj($rowCount['date_created']);
				$cface[] = $rowCount['profImage'];
				$cusername[] = $rowCount['username'];
				$id[] = $rowCount['msg_id'];
				
			 	// update message read flag to=1 
				mysqli_query($con, "update postcomment set isread='1' where comment_id=".$rowCount['comment_id']);
				}
			}
			$output['post_id']=$id;
			$output['comments']=$comment;
			$output['cmntid']=$com_id;
			$output['time']=$time;
			$output['cface']=$cface;
			$output['cusername']=$cusername;
		}
		// cmnt code -----ends
		
		// newly add status,video,photos code
		$sqlCount ="";  $resCount =""; $rowCount ="";
		$sqlCount = "SELECT msg.messages_id, msg.messages, msg.date_created, msg.type,msg.url_title,  
		             m.member_id, m.profImage,m.username, msg.country_flag FROM message msg 
					 LEFT JOIN members	m ON msg.member_id = m.member_id 
					 WHERE msg.country_flag='world' 
					 and m.member_id !=".$_SESSION['SESS_MEMBER_ID']." 
					 and updated > date_sub(now(), interval 1 minute) 
					 and isread='0'	GROUP BY msg.messages_id 
					 ORDER BY date_created DESC";
		$resCount = mysqli_query($con, $sqlCount) or die(mysqli_error($con));

		if(mysqli_num_rows($resCount)>0) {
			while($rowCount = mysqli_fetch_assoc($resCount)) { 
				
				if($rowCount['type']==0) {
				// check type ==0 is url if yes then parse it as url --
				$regex = "((https?|ftp)\:\/\/)?"; // SCHEME 
				$regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass 
				$regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP 
				$regex .= "(\:[0-9]{2,5})?"; // Port 
				$regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path 
				$regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
				$regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
			
				   if(preg_match("/^$regex$/", $rowCount['messages'])) 
				   { 
						    $send_url = get_url($rowCount['messages']);
							$img = $send_url['images'];
							$videos = $send_url['videos'];
							$video_count = count($videos);	
							if($video_count > 1 )
							{
								$title[] = $rowCount['url_title'];
								$video = $videos[2];
								$type[]= 3;
							}
							else
							{
								$type[]= 1;
								$messages[] = $img[1];
							}
				   } 
				}  
				if($rowCount['type']==3){
				    
					if (preg_match('![?&]{1}v=([^&]+)!', $rowCount['messages'] . '&', $m)) {
						$video_id = $m[1]; 
						$url = "http://gdata.youtube.com/feeds/api/videos/".$video_id;
						$doc = new DOMDocument;
						$doc->load($url);
						$title[] = $doc->getElementsByTagName("title")->item(0)->nodeValue;
						$video[] =$video_id;
					}else {
		
							$send_url = get_url($rowCount['messages']);
							$img = $send_url['images'];
							$videos = $send_url['videos'];
							$video_count = count($videos);	
							if($video_count > 1 )
							{
								$title[] = $rowCount['url_title'];
								$video = $videos[2];
								$type[]= 3;
							}
							else
							{
								$type[]= 1;
								$messages[] = $img[1];
							}
					}
					
				} 
				else {
					$type[] = $rowCount['type'];	
					$messages[] = $rowCount['messages'];
				}

				$messages_id[] = $rowCount['messages_id'];
				$member_id[]=$rowCount['member_id'];
				$profile_pic[]=$rowCount['profImage'];
				$stime[] = time_stamp_vj($rowCount['date_created']);
				$username[] = $rowCount['username'];
				$country_flag[]=$rowCount['country_flag'];
				mysqli_query($con, "update message set isread='1' where messages_id=".$rowCount['messages_id']);
			
			}// while rowcount end
			
			$output['type']=$type;
			$output['messages']=$messages;
			$output['messages_id']=$messages_id;
			$output['member_id']=$member_id;
			$output['profile_pic']=$profile_pic;
			$output['stime']=$stime;
			$output['video']=$video;
			$output['username']=$username;
			$output['title']=$title;
			$output['country_flag']=$country_flag;
		}// if comnt row count
		// status,video,photos code -----ends
		
		// Comment like
		 		 
		$sqlCount ="";  $resCount =""; $rowCount =""; $likecmntid=array();
		$sqlCount = "SELECT * FROM comment_like WHERE updated > date_sub(now(), interval 1 minute) and isread='0'";
		$resCount = mysqli_query($con, $sqlCount) or die(mysqli_error($con));

		if(mysqli_num_rows($resCount)>0) {
		$cmntlikes[] = mysqli_num_rows($resCount);			
			while($rowCount = mysqli_fetch_assoc($resCount)) { 											
				$likecmntid[] = $rowCount['comment_id'];			
			}// while rowcount end
			
			$output['cmntlikes']=$cmntlikes;
			$output['likecmntid']=$likecmntid;
			mysqli_query($con, "update comment_like set isread='1' where like_id=".$rowCount['like_id']);
		}// if comnt row count

		
		// status post like 
		 
		$sqlCount ="";  $resCount =""; $rowCount =""; $stslikedusername=array();
		$sqlCount = "SELECT * FROM bleh WHERE updated > date_sub(now(), interval 1 minute) and isread='0'";
		$resCount = mysqli_query($con, $sqlCount) or die(mysqli_error($con));

		if(mysqli_num_rows($resCount)>0) {
			while($rowCount = mysqli_fetch_assoc($resCount)) { 
				$likedusername="";
				if($_SESSION['SESS_MEMBER_ID'] <> $rowCount['member_id'])
					$likedusername=get_username_by_id($rowCount['member_id']);
				else 
					$likedusername="You";
					
				$stslikedusername[] = $likedusername;
				$stslikeduserid[] = $rowCount['member_id'];			
				$stsliked[] =  $rowCount['remarks'];
				mysqli_query($con, "update bleh set isread='1' where bleh_id=".$rowCount['bleh_id']);
			
			}// while rowcount end
			$output['stslikedusername']=$stslikedusername;
			$output['stslikeduserid']=$stslikeduserid;
			$output['stsliked']=$stsliked;
		}// if comnt row count

		if(count($output)>0) {		//prepare for JSON 
			echo json_encode($output);
		}else
		echo null;
?>
