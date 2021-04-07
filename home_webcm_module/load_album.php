<?php ob_start();
	session_start();
	//error_reporting(0);
	if(!isset($_SESSION['SESS_MEMBER_ID']))
	{
		header("location: ".$base_url."login.php?back=". urlencode($_SERVER['REQUEST_URI']));
		exit();
	}
	if(isset($_SESSION['lang']))
	{	
		include('common.php');
	}
	else
	{
		include('Languages/en.php');
		
	}
	require_once('config.php');
	$member_id = $_REQUEST['member_id'];
	$album_id = $_REQUEST['album_id'];
	$session_member_id = $_SESSION['SESS_MEMBER_ID'];
	$sql = mysqli_query($con, "select * from members, user_album where members.member_id='".$member_id."'
	and members.member_id=user_album.album_user_id and user_album.album_id='".$_REQUEST['album_id']."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<title><?php echo $lang['My Photos'];?></title>
<head>
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="stylesheet" type="text/css" href="css/share_box.css"/>
<link href="css/style5forimageGallery.css" rel="stylesheet" type="text/css" media="all" />
<link rel="icon" href="images/favicon.ico" type="image" />
<link rel="shortcut icon" href="images/favicon.ico" type="image" />

<link rel="stylesheet" type="text/css" href="css/format.css"/>
<link rel="stylesheet" type="text/css" href="css/search.css"/>
<link rel="stylesheet" type="text/css" href="css/dropdown.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>font-awesome/css/font-awesome.css">
<link rel="stylesheet" href="<?php echo $base_url;?>assets/chosen-jquery/chosen.css">
<link rel="stylesheet"  type="text/css" href="<?php echo $base_url;?>css/token-input.css"/>
<link rel="stylesheet"  type="text/css" href="<?php echo $base_url;?>css/token-input-facebook.css"/>
<link rel="stylesheet"  type="text/css" href="<?php echo $base_url;?>css/token-input-mac.css"/>
<script src="js/ibox.js"></script>
<script src="js/jquery.livequery.js" type="text/javascript"></script>
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/script.js"></script>
<script src="js/photos.js"></script>
<script type="text/javascript" src="js/jquery.livequery.js"></script>

<script type="text/javascript" src="<?php echo $base_url;?>js/jquery.tokeninput.js"></script>
<!-- drag -->
<link rel="stylesheet" href="css/jquery-ui.css" />
<link rel="stylesheet" href="/resources/demos/style.css" />

<style>
.ui-widget-content { width:50px; height: 50px; padding: 0.5em;z-index:11000; border:#0000FF ridge 2px;;}

.ui-widget-content1 { width:50px; height: 50px;z-index:11000; display:none; position:absolute;}

.tagged { width:50px; height: 50px;z-index:12000; position:absolute;}
.commentMark{width:200px;}
 </style>

</head>
<body>
<div id="wrapper">
<?php include('includes/header.php');?>
<div id="mainbody">

<div class="column_left">
<?php 
	if($member_id != $session_member_id)
	{
	?>
<input type="button" class="button" value="<?php echo $lang['Profile'];?>" 
    onclick="window.open('<?php echo $base_url;?>photos/<?php echo $res['username'];?>','_self');" />
   
     <?php } 
	else
	{
	?>  
    <!--<input type="button" class="button" value="Mywall" 
    onclick="window.open('<?php echo $base_url.'i/'.$res['username'];?>','_self');" /> -->
    <?php } ?>
     <input type="button" class="button" value="<?php echo $lang['Back to album'];?>" 
    onclick="window.open('<?php echo $base_url;?>photos/<?php echo $res['username'];?>','_self');" />
    
    <?php 
	
	if($res['album_user_id'] == $session_member_id)
	{
	?>
    
     <a href="#" class="topopup"><input type="button" class="button" value="<?php echo $lang['Delete album'];?>" />
    </a> 
    <a href="action/delete_album.php?album_id=<?php echo $album_id;?>" class="delete_album"><input type="button" class="button" value="<?php echo $lang['Delete album'];?>" />
    </a>  
    <?php } ?>
	<div class="" style="width:">
    <div class="componentheading">
    <div id="submenushead"><?php echo $res['album_name']; ?></div>
    </div>
    <!--<div id="submenushead">
    <ul class="dropDown">
    <li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="friends.php">All Groups</a></li>
    <li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="groups.php">My Groups</a></li>
    <li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="find_friend_advanced.php">Pending Invitations</a></li>
  	<li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="create_groups.php">Create</a></li>
    <li style="padding:0 8px;"><a href="request_sent.php">Search</a></li>    
	</ul>
   </div>-->
   <?php 
      function _make_url_clickable_cb($matches) {
	$ret = '';
	$url = $matches[2];
 
	if ( empty($url) )
		return $matches[0];
	// removed trailing [.,;:] from URL
	if ( in_array(substr($url, -1), array('.', ',', ';', ':')) === true ) {
		$ret = substr($url, -1);
		$url = substr($url, 0, strlen($url)-1);
	}
	return $matches[1] . "<a href=\"$url\" rel=\"nofollow\">$url</a>" . $ret;
}

function _make_web_ftp_clickable_cb($matches) {
	$ret = '';
	$dest = $matches[2];
	$dest = 'http://' . $dest;
 
	if ( empty($dest) )
		return $matches[0];
	// removed trailing [,;:] from URL
	if ( in_array(substr($dest, -1), array('.', ',', ';', ':')) === true ) {
		$ret = substr($dest, -1);
		$dest = substr($dest, 0, strlen($dest)-1);
	}
	return $matches[1] . "<a href=\"$dest\" rel=\"nofollow\" target=\"_blank\">$dest</a>" . $ret;
}
 
function _make_email_clickable_cb($matches) {
	$email = $matches[2] . '@' . $matches[3];
	return $matches[1] . "<a href=\"mailto:$email\">$email</a>";
}

    function clickable_link($text = '')
	{
		$text = preg_replace_callback('#(script|about|applet|activex|chrome):#is',function($matches) {
        return $matches[1];
			}, $text);
		$ret = ' ' . $text;
		$ret = preg_replace_callback("#(^|[\n ])([\w]+?://[\w\#$%&~/.\-;:=,?@\[\]+]*)#is",'_make_url_clickable_cb', $ret);
		
		$ret = preg_replace_callback("#(^|[\n ])((www|ftp)\.[\w\#$%&~/.\-;:=,?@\[\]+]*)#is",'_make_web_ftp_clickable_cb', $ret);
		$ret = preg_replace_callback("#(^|[\n ])([a-z0-9&\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)#i",'_make_email_clickable_cb', $ret);
		$ret = substr($ret, 1);
		return $ret;
	}
	
	
	$da= "SELECT *, UNIX_TIMESTAMP() - date_created AS TimeSpent FROM upload_data u, members m where u.USER_CODE=m.member_id and u.album_id=".$_REQUEST['album_id']." AND share !=1 ORDER by u.upload_data_id ASC";
	
	
	$result = mysqli_query($con, $da) or die(mysqli_error($con));
	$totalnumofrec=mysqli_num_rows($result);
	$countrecord=1;
	while ($row = mysqli_fetch_array($result) )
	{ 
	$row['upload_data_id'];
	  $total_comments = mysqli_query($con, "SELECT count(*) FROM photo_comments where c_item_id = ".$row['upload_data_id']." order by c_when asc");
	  $records = mysqli_fetch_array($total_comments);
	  $records = $records[0];
	  
	    $comments = mysqli_query($con, "SELECT *,
		UNIX_TIMESTAMP() - c_when AS CommentTimeSpent FROM photo_comments, members where members.member_id=photo_comments.c_user_id and c_item_id = ".$row['upload_data_id']." order by c_when asc limit 0,4") or die(mysqli_error($con));		
		$comment_num_row = mysqli_num_rows(@$comments);
		
	  
	  
	  echo '<div class="photo" style="z-index:100009;margin-top: 20px;" >';
	  if($_SESSION['SESS_MEMBER_ID'] == $_REQUEST['member_id'])
{
?>

<a class="stdelete" href="#" id="<?php echo $row['upload_data_id'];?>" title="<?php echo $lang['Delete Photo'];?>">X</a>
<?php }



	 echo '<div id='.$row['upload_data_id'].' class="topup">';
	  
	  ?><a href="albums.php?back_page=<?php echo $base_url;?>photos/<?php echo $res['username'];?>&member_id=<?php echo $row['member_id']; ?>&album_id=<?php echo $_REQUEST['album_id']; ?>&image_id=<?php echo $row['upload_data_id'];?>" >
<img width="265" height="205" src="<?php echo $row['FILE_NAME'];?>" id="<?php echo $row['upload_data_id'];?>" value="<?php echo $_REQUEST['album_id'];?>" />
	  
	  
	  </a>
	  <?php
	 //echo "caption=".$row['caption'];
	  if($session_member_id==$member_id && ($row['caption']!="" || $row['description']!=""))
	  {
	 
	  ?>
	 
	  <a href="#!" onclick="editcapt(<?php echo $row['upload_data_id'];?>)"><?php echo $lang['Edit'];?></a>
	  <?php
	  }
	  ?>
	  </div>
	   <script>
	   
	   function closeedit(id)
	   {
	   $('#capt_desc_'+id).hide();
	   }
	  function editcapt(id)
	  {
		
		//alert('hi');
		
		//var id=$("#edit_descid").val();
		//alert(id);
		$("#edit_description"+id).show();
		$('#capt').hide();
		$('#desc').hide();
		$('#capt_desc_'+id).show();
	  }
	  </script>
	
<?php	  
	  if(!$row['caption'])
	  {
	  	if($_SESSION['SESS_MEMBER_ID'] == $_REQUEST['member_id'])
	  	{
	  	?>
	  	<div class="text_wrapper_caption" id="text_wrapper_caption<?php echo $row['upload_data_id']; ?>" style="">
	  	<a href="javascript: void(0)" class="captions" id="<?php echo $row['upload_data_id']; ?>"><p><?php echo $lang['Add Caption']; ?> </p></a>	  	</div>
	  	<div class="edit_caption" id="edit_caption<?php echo $row['upload_data_id']; ?>" style="display:none">
	  	<textarea class="editbox_caption" id="editbox_caption<?php echo $row['upload_data_id']; ?>" size="80px" rows="2"name="profile_box"></textarea></div>
	  <?php
	  	  
	  	}
	  
	  }
	  else
	  {
		  echo '<i>Caption</i><p id="capt">'.$row['caption'].'</p>';
	  }
	  if(!$row['description'])
	  {
	  	if($_SESSION['SESS_MEMBER_ID'] == $_REQUEST['member_id'])
	  	{
	  	  ?>
	  	<div class="text_wrapper_description" id="text_wrapper_description<?php echo $row['upload_data_id']; ?>" style="">
	  	<a href="javascript: void(0)" class="descriptions" id="<?php echo $row['upload_data_id']; ?>"><p><?php echo $lang['Add Description']; ?></p></a>	  	</div>
	  	<div class="edit_description" id="edit_description<?php echo $row['upload_data_id']; ?>" style="display:none">
	  	<textarea class="editbox_description" id="editbox_description<?php echo $row['upload_data_id']; ?>" cols="23" rows="2"
	  	name="profile_box">
	  	</textarea></div>
	    
	    <span class="app-box">
	    <?php
	  	  
	  	  //echo '<i>'.$row['description'].'</i>';
	  	  
	  	}
	  }
	  else
	  {
		echo '<i>'.$lang['Description'].'</i><i id="desc">'.$row['description'].'</i>';  
	  }
	  ?>
	  
	  
	  
	   <form id="capt_desc_<?php echo $row['upload_data_id'];?>" action="<?php echo $base_url;?>savecapt.php" method="post" style="display:none;">
      <input type="hidden" id="edit_descid" name='id' value="<?php echo $row['upload_data_id']; ?>">
      <input type="hidden" id="edit_albumid" name='albumid' value="<?php echo $album_id; ?>">
      <input type="hidden" id="edit_memberid" name='memberid' value="<?php echo $member_id; ?>">
      <p><?php echo $lang['Caption']; ?></p>
      <textarea name='caption' required="required" cols="23" rows="1"><?php echo $row['caption']; ?></textarea>
      <br /><br/>
      <i><?php echo $lang['Description']; ?></i>
     <textarea class="editbox_description" required="required" name="editbox_description" cols="23" rows="2"
	  	><?php echo $row['description']; ?></textarea><br>
	  	<input type='submit' value="<?php echo $lang['update']; ?>">
	  	<input type="button" value="<?php echo $lang['Cancel']; ?>" onclick="closeedit(<?php echo $row['upload_data_id'];?>)">
      
      </form>
	  
	  <?php
	  echo '</div>';
	  echo '<div id="toPopup'.$row['upload_data_id'].'" class="toPopup">';
	  ?>
	   </span>
			      	
        <div class="close"></div>
       	<span class="ecs_tooltip"><?php echo $lang['Press Esc to close']; ?> <span class="arrow"></span></span>
		<div id="popup_content"> <!--your content start-->
          
				<div id="div_left_panel" class="leftpanel" align="center">
				
				
			<?php 
				$tag_sql = "SELECT tag_id, member_in_tag_id, div_top, div_left FROM tags Where photo_id='".$row['upload_data_id']."'"; 
	
				$tag_data = mysqli_query($tag_sql);
			while( $info=mysqli_fetch_array($tag_data)){
			echo "<div class='tagged'  id='tagged".$info['tag_id']."' style='top:".$info['div_top']."px;left:".$info['div_left']."px;' title='".$info['member_in_tag_id']."' >
		 	</div>";
			
			}
			
				
			echo "<div class='ui-widget-content1'>
		 	<div id='draggable".$row['upload_data_id']."' class='ui-widget-content'>
		 
		 	<input type='button' value='".$lang['Ok']."' class='btn_tag_submit' id='".$row['upload_data_id']."'>
		 	<input type='button' value='X' name='btn_tag_box_close' 		   	onclick='hide_photo_tag()'>
			<br>		 
			<center>
			<input type='text' id='tag_text".$row['upload_data_id'] ."' class='tag_text' name='tag_text' size='3px' />
			</center>
</div> </div>";
				
				
				
				list($width, $height) = getimagesize("uploadedimage/".$row['FILE_NAME'].""); 
				
				if($width>600 || $height>550)
				{
				echo '<img height="100%" width="100%" align="middle" src="uploadedimage/'.$row['FILE_NAME'].'" id="'.$row['upload_data_id'].'" value="'.$_REQUEST['album_id'].'" />'; 	
				
				}
				else
				{
				
				$height1=(550-$height)/2;
				echo '<div style="margin-top:'.$height1.'px">';
				echo '<img align="middle" src="uploadedimage/'.$row['FILE_NAME'].'" id="'.$row['upload_data_id'].'" value="'.$_REQUEST['album_id'].'" />';
				echo '</div>';
				} 
				
				$previousvalu= mysqli_query("SELECT `upload_data_id` FROM `upload_data` WHERE album_id=".$_REQUEST['album_id']." and `upload_data_id` < 				'".$row['upload_data_id']."' ORDER BY `upload_data_id` DESC LIMIT 1");
				while ($getpreval = mysqli_fetch_array($previousvalu) )
				{
					$prevval=$getpreval['upload_data_id'];
				}
				
				$nextvalu= mysqli_query("SELECT `upload_data_id` FROM `upload_data` WHERE album_id=".$_REQUEST['album_id']." and `upload_data_id` > 				'".$row['upload_data_id']."' ORDER BY `upload_data_id` ASC LIMIT 1");
				while ($getnextval = mysqli_fetch_array($nextvalu) )
				{
					$nextval=$getnextval['upload_data_id'];
					
					
				}
				
				if($countrecord!=1)
				{?>
				
				<div class="leftnav" id="<?php echo $prevval; ?>">		</div>
				<?php } 
					if($countrecord!=$totalnumofrec)
				{
				?>
				<div class="rightnav" id="<?php echo $nextval; ?>">				</div>
				<?php } ?>
				</div>
				<div class="rightpanel">
				<div class="rightTop">
				<div class="image" style="height:60px">
				
				<img src="<?php echo $row['profImage']; ?>" width="60" height="60" class="CommentImg" style="float:left;" alt="" />
				<p><span style="margin-left:10px;">
				<b><?php echo $row['username']; ?></b></p></span>
				<p>
				<span style="margin-left:10px;">
				  <?php  
		   
		         // echo strtotime($row['date_created'],"Y-m-d H:i:s");
   		    
		         $days = floor($row['TimeSpent'] / (60 * 60 * 24));
			     $remainder = $row['TimeSpent'] % (60 * 60 * 24);
			     $hours = floor($remainder / (60 * 60));
			     $remainder = $remainder % (60 * 60);
			     $minutes = floor($remainder / 60);
			     $seconds = $remainder % 60;
			
			     if($days > 0)
			     echo date('F d Y', $row['date_created']);
			     elseif($days == 0 && $hours == 0 && $minutes == 0)
		  	     echo $lang['few seconds ago'];		
		    	 elseif($days == 0 && $hours == 0)
			     echo $minutes.' minutes ago';
			     else
			     echo $lang['few seconds ago'];	
			
		          ?>
				</span>				</p>
				</div>
				<div class="caption" >
				<?php
				if(!$row['caption'])
				{
					if($_SESSION['SESS_MEMBER_ID'] == $_REQUEST['member_id'])
	  				{
		  				echo '<p class="captions" id="'.$row['upload_data_id'].'">'.$lang['Add Caption'].'</p>';
		  				//echo $row['caption'];
	  	  
		  			}
		  		}
		  		else
		  		{
		  			echo $row['caption'];
		  		}
				 ?>
				</div>
				<div class="description" >
				<?php
				if(!$row['description'])
				{
					if($_SESSION['SESS_MEMBER_ID'] == $_REQUEST['member_id'])
					{
						echo '<p class="descriptions" id="'.$row['upload_data_id'].'">'.$lang['Add Description'].'</p>';
						//echo $row['description'];
	  	  
					}
				}
				else
				{
					echo $row['description'];
				}
				 ?>
				</div>
				
		<a href="#" rowtype="<?php echo $row['type'];?>" class="share_open" id="<?php echo $row['messages_id'];?>" title="<?php echo $lang['Share'];?>" onClick="">
<span style="font-size: 1.0em;float: left;width: 53px;cursor: pointer;color: #005689;" id="share"><?php echo $lang['Comments'];?></span></a> &nbsp;

<?php echo "<a href='javascript:show_photo_tag()' id='photo_tag'>".$lang['photo tag']."</a>"; 

?> &nbsp;



				<a href="javascript: void(0)" id="post_id<?php  echo $row['upload_data_id']?>" class="showCommentBox"><?php echo $lang['Comments'];?></a>
								<?php
		   
		   $q = mysqli_query($con, "SELECT upload_data_like_id FROM upload_data_like WHERE upload_data_user_id='".$member_id."' and upload_data_item_id='".$row['upload_data_id']."' ") or die(mysqli_error($con));

if(mysqli_num_rows($q) > 0)
{
	echo '<a href="#" class="like" id="like'.$row['upload_data_id'].'" title="'.$lang['Unlike'].'" rel="Unlike">'.$lang['Unlike'].'</a>';
} 
else 
{ 
	echo '<a href="#" class="like" id="like'.$row['upload_data_id'].'" title="'.$lang['Like'].'" rel="Like">'.$lang['Like'].'</a>';
} 
		?><?php	
			
$like_count = $row['like_count'];

if($like_count > 0) 
{ 
$query=mysqli_query($con, "SELECT U.username,U.member_id FROM upload_data_like M, members U WHERE U.member_id=M.upload_data_user_id AND M.upload_data_item_id='".$row['upload_data_id']."' LIMIT 3");
$like = mysqli_num_rows($query);
?>
<div class='likeUsers' id="likes<?php echo $row['upload_data_id'] ?>">
<?php
$new_like_count = $like_count-3; 
while($row12=mysqli_fetch_array($query))
{
$like_uid=$row12['member_id']; 
$likeusername=$row12['username']; 
if($like_uid==$member_id)
{
echo '<span id="you'.$row['upload_data_id'].'"><a href="'.$likeusername.'">'.$lang['You'].', </a></span>';
}
else
{ 
echo '<a href="'.$likeusername.'">'.$likeusername.',</a>';
}  
}
if($new_like_count>0)
echo ''.$lang['and'].''.$like.' '.$lang['other friends'].'';
echo $lang['like this'];
?> 
</div>
<?php }
else { 
echo '<div class="likeUsers" id="elikes'.$row['upload_data_id'].'"></div>';
} 
 
			?>
				</div>
				<div class="rightbottom">
				
				<div class="friends_area" id="record-<?php  echo $row['upload_data_id']?>">
				
				<br clear="all" />
				<div id="CommentPosted<?php  echo $row['upload_data_id']?>">
				<?php
				$comment_num_row = mysqli_num_rows(@$comments);
				if($comment_num_row > 0)
				{
					while ($rows = mysqli_fetch_array($comments))
					{
						$days2 = floor($rows['CommentTimeSpent'] / (60 * 60 * 24));
						$remainder = $rows['CommentTimeSpent'] % (60 * 60 * 24);
						$hours = floor($remainder / (60 * 60));
						$remainder = $remainder % (60 * 60);
						$minutes = floor($remainder / 60);
						$seconds = $remainder % 60;	
				?>
				<div class="commentPanel" id="record-<?php  echo $rows['c_id'];?>" align="left">
						<img src="<?php echo $rows['profImage'];?>" height="30" width="30" class="CommentImg" style="float:left;" alt="" />
						<label style="float:left" class="name">

		   <b><?php echo $rows['username'];?></b> </label>
						<label class="postedComments">
							<?php  echo clickable_link($rows['c_text']);?>
						</label>
						<br clear="all" />
						<span style="margin-left:43px; color: #e1e1e1; font-size:11px">
						<?php
						
						if($days2 > 0)
						echo date('F d Y', $rows['c_when']);
						elseif($days2 == 0 && $hours == 0 && $minutes == 0)
						echo $lang['few seconds ago'];		
						elseif($days2 == 0 && $hours == 0)
						echo $minutes.$lang['minutes ago'];
						else
			echo $lang['few seconds ago'];	
						?>
						</span>
						 <?php
		   
		   $q1 = mysqli_query($con, "SELECT pcl_id FROM photo_comments_like WHERE photo_comment_user_id='".$member_id."' and photo_comment_id='".$rows['c_id']."' ");

if(mysqli_num_rows($q1) > 0)
{
	echo '<a class="like1" id="like1'.$rows['c_id'].'" title="'.$lang['Unlike'].'" rel="Unlike">'.$lang['Unlike'].'</a>';
} 
else 
{ 
	echo '<a class="like1" id="like1'.$rows['c_id'].'" title="'.$lang['Like'].'" rel="Like">'.$lang['Like'].'</a>';
} 
		?><?php	
			
$like_count1 = $rows['like_count'];

if($like_count1 > 0) 
{ 
$query1=mysqli_query($con, "SELECT U.username,U.member_id FROM photo_comments_like M, members U WHERE U.member_id=M.photo_comment_user_id AND M.photo_comment_id='".$rows['c_id']."' LIMIT 3");
$like1 = mysqli_num_rows($query1);
?>
<div class='likeUsers' id="likes<?php echo $rows['c_id'] ?>">
<?php
$new_like_count1 = $like_count1-3; 
while($row121=mysqli_fetch_array($query1))
{
$like_uid1=$row121['member_id']; 
$likeusername1=$row121['username']; 
if($like_uid1=$member_id)
{ 
echo '<span id="you1'.$rows['c_id'].'"><a style="color:#FFFFFF; font-size: 11px; margin: 3px 3px 3px 6px; text-decoration: none;" href="'.$likeusername1.'">'.$lang['You'].' '; 
if($like_count1>1)
echo ' ,'; 
echo '</a></span>';
}
else
{ 
echo '<a style="color:#FFFFFF; font-size: 11px; margin: 3px 3px 3px 6px; text-decoration: none;" href="'.$likeusername1.'">'.$likeusername1.',</a>';
}  
}
if($new_like_count1>0)
echo ''.$lang['and'].''.$like1.' other friends';
echo $lang['like this'];
?> 
</div>
<?php }
else { 
echo '<div class="likeUsers" id="elikes1'.$rows['c_id'].'"></div>';
} 

		
			?>
						
						<?php
						$userip = $_SERVER['REMOTE_ADDR'];
						if($rows['c_user_id'] == $member_id){?>
						<div>
						<div id="normal-button" class="settings-button" title="0" value="<?php echo $rows['c_id']; ?>" >
						<span title="<?php echo $lang['Edit'];?> & Delete" style="bottom: 2px;float: right;position: relative;width: 33px;cursor: pointer;" class="">
						<img src="images/edit_icon.png"/>						</span></div>
						<div class="submenu12" id="<?php echo $rows['c_id']; ?>-submenu12" style="display: none;float: right;
						 position: relative; background:#000000">
						<a href="#" class="edit_link" id="<?php  echo $rows['c_id'];?>" title="<?php echo $lang['Edit'];?>"><?php echo $lang['Edit'];?></a><br>
						<a href="#" id="CID-<?php  echo $rows['c_id'];?>" class="c_delete"><?php echo $lang['Delete'];?></a>						</div>
						</div>
						
						<?php
						}?>
				  </div>
					<?php 
					}
				}?>
				</div><!--  CommentPosted -->
				<div class="commentBox" align="right" id="commentBox-<?php  echo $row['upload_data_id'];?>" <?php echo (($comment_num_row) ? '' :'style="display:none"')?>>
				<img src="<?php echo $res['profImage']; ?>" width="40" class="CommentImg" style="float:left;" alt="" />
				<label id="record-<?php  echo $row['upload_data_id'];?>">
					<textarea class="commentMark" id="commentMark-<?php  echo $row['upload_data_id'];?>" name="commentMark" cols="60"></textarea>
				</label>
				<br clear="all" />
				<a id="SubmitComment" class="small button comment"> <?php  echo $lang['Comment'];?></a>			</div>
				</div> <!--  friends_area --> 
				</div>
				</div> 
        </div> <!--your content end-->
    </div> 
	<!--toPopup end-->
    
	<div class="loader" id="loader"></div>
   	<div class="backgroundPopup" id="backgroundPopup"></div>
	<?php
	$countrecord++;}
?>

</div>    
</div> 
<!--Start column right-->
<?php include 'ads_right_column.php';?>
<!--end column_right div-->
</div><!--end mainbody div-->
<?php include 'includes/footer.php';?>
</div><!--end wrapper div-->

<div id="toPopup">     	
        <div class="close"></div>
       	<span class="ecs_tooltip"><?php  echo $lang['Press Esc to Cancel'];?> <span class="arrow"></span></span>
		<div id="popup_content"> <!--your content start-->
            <p>
            
		<form action='action/add_photos.php' method='POST' enctype='multipart/form-data'>
        <input type="hidden" name="member_id" id="member_id" value="<?php echo $member_id;?>" />
            <input type="hidden" name="album_id" id="album_id" value="<?php echo $album_id?>" />
            
			
			<?php echo $lang['Choose photos'];?> <input class="sumbitform" type="file" name="files[]" multiple required="required"/>
			<input type="submit" value="<?php echo $lang['Upload'];?> " class=""/>
            </form></p>            
        </div> <!--your content end-->    
    </div> <!--toPopup end-->
	

<?php include_once 'share.php';?>


</div>

</body>
</html>