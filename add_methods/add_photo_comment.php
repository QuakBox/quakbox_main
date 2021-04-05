<?php 
/**
   * @package    add_photo_comment
   * @subpackage 
   * @author     Vishnu
   * Created date  02/05/2015 
   * Updated date  03/13/2015 
   * Updated by    Vishnu S
 **/
 
session_start();
	include('config.php');
	$member_id = $_SESSION['SESS_MEMBER_ID'];
	
	
	
		$userip = $_SERVER['REMOTE_ADDR'];
		
		$m = mysqli_query($con, "INSERT INTO photo_comments (c_item_id,c_text,c_ip,c_user_id,c_when) VALUES('".$_REQUEST['post_id']."',
		'".$_REQUEST['comment_text']."','".$userip."','".$member_id."','".strtotime(date("Y-m-d H:i:s"))."')") ;
		
		$result = mysqli_query($con, "SELECT *,
		UNIX_TIMESTAMP() - c_when AS CommentTimeSpent FROM photo_comments, members where members.member_id=photo_comments.c_user_id order by c_id desc limit 1") or die(mysqli_error($con));
	
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
		$text = preg_replace_callback('#(script|about|applet|activex|chrome):#is', function ($matches) {return "$matches[1]";}, $text);
		$ret = ' ' . $text;
	$ret = preg_replace_callback("#(^|[\n ])([\w]+?://[\w\#$%&~/.\-;:=,?@\[\]+]*)#is",'_make_url_clickable_cb', $ret);
		
		$ret = preg_replace_callback("#(^|[\n ])((www|ftp)\.[\w\#$%&~/.\-;:=,?@\[\]+]*)#is",'_make_web_ftp_clickable_cb', $ret);
		$ret = preg_replace_callback("#(^|[\n ])([a-z0-9&\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)#i",'_make_email_clickable_cb', $ret);
		$ret = substr($ret, 1);
		return $ret;
	}
	while ($rows = mysqli_fetch_array($result))
	{
		$days2 = floor($rows['CommentTimeSpent'] / (60 * 60 * 24));
		$remainder = $rows['CommentTimeSpent'] % (60 * 60 * 24);
		$hours = floor($remainder / (60 * 60));
		$remainder = $remainder % (60 * 60);
		$minutes = floor($remainder / 60);
		$seconds = $remainder % 60;	?>
		<div class="commentPanel"  id="record-<?php  echo $rows['c_id'];?>" align="left">
			<img src="<?php echo $rows['profImage'] ?>" class="CommentImg" style="float:left;" alt="" height="30" width="30" />
			
			<label class="postedComments">
			<label class="name">

		   <b><?php echo $rows['username'];?></b> </label>
			
		<div class="text_wrapper" id="text_wrapper<?php echo $rows['c_id']; ?>" style=""><?php  echo clickable_link($rows['c_text']);?></div>
							<div class="edit" id="edit<?php echo $rows['c_id']; ?>" style="display:none"><textarea class="editbox" id="editbox<?php echo $rows['c_id']; ?>" cols="23" rows="3"   name="profile_box">
							</textarea></div>
			</label>
			<br clear="all" />
			
			<span style="margin-left:43px; color:#e1e1e1; font-size:11px">
			<?php
			
			if($days2 > 0)
			echo date('F d Y', $rows['c_when']);
			elseif($days2 == 0 && $hours == 0 && $minutes == 0)
			echo "few seconds ago";		
			elseif($days2 == 0 && $hours == 0)
			echo $minutes.' minutes ago';
			else
			echo "few seconds ago";	
			
			?>
			</span>
			
			
 <?php
		   
$q1 = mysqli_query($con, "SELECT pcl_id FROM photo_comments_like WHERE photo_comment_user_id='".$member_id."' and photo_comment_id='".$rows['c_id']."' ");

if(mysqli_num_rows($q1) > 0)
{
	echo '<a class="like1" id="like1'.$rows['c_id'].'" title="Unlike" rel="Unlike">Unlike</a>';
} 
else 
{ 
	echo '<a class="like1" id="like1'.$rows['c_id'].'" title="Like" rel="Like">Like</a>';
} 
		?><?php	
			
$like_count1 = $rows['like_count'];

if($like_count1 > 0) 
{ 
$query1=mysqli_query($con, "SELECT m.username,m.member_id FROM photo_comments_like p, members m WHERE m.member_id=p.photo_comment_user_id AND p.photo_comment_id='".$rows['c_id']."' LIMIT 3");
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
echo '<span id="you1'.$rows['c_id'].'"><a style="color:#FFFFFF; font-size: 11px; margin: 3px 3px 3px 6px; text-decoration: none;" href="'.$likeusername1.'">You  '; 
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
echo 'and '.$like1.' other friends';
echo 'Like this';
?> 
</div>
<?php }
else { 
echo '<div class="likeUsers" id="elikes1'.$rows['c_id'].'"></div>';
} 

			
			$userip = $_SERVER['REMOTE_ADDR'];
			if($rows['c_user_id'] == $member_id){?>
			<div>
						<div id="normal-button" class="settings-button" title="0" value="<?php echo $rows['c_id']; ?>" >
						<span title="Edit & Delete" style="bottom: 2px;float: right;position: relative;width: 33px;cursor: pointer;" class="">
						<img src="images/edit_icon.png"/>
						</span></div>
						<div class="submenu12" id="<?php echo $rows['c_id']; ?>-submenu12" style="display: none;float: right;
						 position: relative; background:#000000">
						<a href="#" class="edit_link" id="<?php  echo $rows['c_id'];?>" title="Edit">Edit</a><br>
						<a href="#" id="CID-<?php  echo $rows['c_id'];?>" class="c_delete">Delete</a>
						</div>
						</div>
						
			<?php
			}?>
		</div>
	<?php
	}?>	

		
		
		
		