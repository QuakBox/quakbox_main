<?php ob_start();
	if(!isset($_SESSION)){
		session_start();
	}
	include_once '../config.php';
	if(isset($_SESSION['lang']))
	{	
		include($root_folder_path.'public_html/common.php');
	}
	else
	{
		include($root_folder_path.'public_html/Languages/en.php');
		
	}
	include_once($root_folder_path.'public_html/includes/time_stamp.php');		
		$member_id = $_SESSION['SESS_MEMBER_ID'];
		$output = array();		 
	  	$msg_sql = mysqli_query($con, "select distinct msg.from ,m.username, msg.read,msg.id,m.profImage,m.member_id,
		     msg.message,msg.sent,count(*)
		     from cometchat msg, members m	 	     
			 WHERE 
			 CASE
			 WHEN msg.to = '$member_id'
			 THEN msg.from = m.member_id
			 WHEN msg.from = '$member_id'
			 THEN msg.to = m.member_id
			 END
			 AND
			 (msg.from ='$member_id' OR msg.to ='$member_id')
			 AND msg.read = 0
			 GROUP BY m.member_id ORDER BY msg.sent desc LIMIT 1") or die(mysqli_error($con));

		$msg_count = mysqli_num_rows($msg_sql);
		if($msg_count>0)
		{			
			while($msg_res = mysqli_fetch_array($msg_sql))
			{
				$id = $msg_res['id'];
			mysqli_query($con, "UPDATE cometchat SET read = 1 WHERE id='$id'");
				?>
				<li style="display:block; margin-bottom:5px;">
        <a href="<?php echo $base_url.'messages.php?username='.$msg_res['member_id'];?>">
        <div style="float:left; width:50px; height:50px; margin-right:8px;">
        <img src="<?php echo $base_url.$msg_res['profImage'];?>" width="50" height="50"/> 
        </div>
        <div style="overflow:hidden;">
        <div class="author"><strong><?php echo $msg_res['username'];?></strong>
        </div> 
        <div><span style="color:gray;"><?php echo $msg_res['message'];?></span></div>
        
        </div>
        </a>
        </li>
        <?php 
			}
			
			
		}	  
		
?>