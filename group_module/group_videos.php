<?php
require_once('common/common.php');
	$session_member_id = $QbSecurity->qbClean($_SESSION['SESS_MEMBER_ID'], $con);
	$group_id = $QbSecurity->qbClean($_REQUEST['group_id'], $con);
if(!(empty($group_id)||($qbValidation->qbIntegerCheck($group_id))))	
{
$qb_err_msg="Oops Something Went Wrong...!";
$QbSecurity->qbErrorMessage($qb_err_msg,$homepage);
	}
	
	else
	{
		$group_id=htmlspecialchars(trim($group_id ));			
		$sql = mysqli_query($con, "select * from groups where id='".$group_id."'") or die(mysqli_error($con));
		$res = mysqli_fetch_array($sql);
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<title><?php echo $res['name'];?><?php echo $lang['Videos'];?></title>
<head>

<link rel="stylesheet" type="text/css" href="css/wall.css"/>
<link rel="stylesheet" type="text/css" href="css/search.css"/>
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="stylesheet" type="text/css" href="css/group.css"/>
<link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.css" />
<link rel="icon" href="images/favicon.ico" type="image" />
<link rel="shortcut icon" href="images/favicon.ico" type="image" />

<script src="js/jquery.min.js"></script>
<script src="js/jquery-1.9.1.js"></script>
<script src="js/youtube.js"></script>
    <script type="text/javascript" src="flowplayer/flowplayer.min.js"></script>
 <link rel="stylesheet" type="text/css" href="flowplayer/skin/minimalist.css">
 <link rel="stylesheet" type="text/css" href="css/youtube.css"/>


<body>
<div id="wrapper">
<?php 
include('includes/header.php');

?>
<div id="mainbody">

<div class="column_left">
<input type="button" name="add_video" class="button" value="<?php echo $lang['Back to Group'];?>" 
    onclick="window.open('groups_wall.php?group_id=<?php echo $group_id;?>','_self');return false;" style="font-size:14px;" />
<div class="componentheading">
    <div id="submenushead"><?php echo $res['name'];?> <?php echo $lang['Videos'];?></div>
    </div>
    
    <ul class="submenu">    
   <li></li>
   <li><form id="searchbox" action="video_gallery_search.php" method="post">        
    <input id="search" type="text" name="search" placeholder="<?php echo $lang['Type here'];?>">
    <input class="submit" type="submit" value="<?php echo $lang['Search'];?>">
</form></li>
	</ul>

<div class="popular_video">

<?php 
$pvquery = "select msg.video,url,msg.messages,msg.url_title,msg.date_created,msg.messages_id,msg.view_count,m.member_id,msg.type 
		,msg.messages_id from groups_wall msg left join members m on m.member_id = msg.member_id 
		where msg.group_id = '$group_id' and msg.type =2 or msg.type = 3";
		
		$pvsql = mysqli_query($con, $pvquery);

if(mysqli_num_rows($pvsql) > 0)
{
?>
    <ul class="popular">
    <?php 

while($pvres = mysqli_fetch_array($pvsql))
{
	$time = $pvres['date_created'];
?>

        <li class="popular_list" id="popular_list-<?php echo $pvres['messages_id'];?>">
        <a href="view_group_video.php?group_id=<?php echo $group_id?>&video_id=<?php echo $pvres['messages_id'];?>" class="view_video" id="<?php echo $pvres['messages_id'];?>">
          
   <img src="images/videos_pl.png" />
   </a>
<div class="video_Content">
<h3 class="video_title"><?php echo $pvres['url_title'];?></h3>
<div class="video_data">

<span class="view_count"><?php echo $pvres['view_count'];?> <?php echo $lang['views'];?></span>
<span class="content_item_time"><?php echo time_stamp($time);?></span>

</div>
</div>
        
        </li>
        
        
<?php } ?>        
    </ul>
    <?php } 
	else
	{
		?>
        <div class="community-empty-list"><?php echo $lang['No videos'];?></div>
        <?php
	}
	?>
</div>

</div><!--End column left div-->
</div><!--End mainbody div-->

<?php include 'includes/footer.php';?>
</div><!--End wrapper div-->

</body>
<?php } ?>
</html>