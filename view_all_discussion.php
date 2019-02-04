<?php 
	session_start();
	require_once('config.php');
	$member_id = $_SESSION['SESS_MEMBER_ID'];
	$group_id = $_REQUEST['group_id'];
	if(!isset($_SESSION['SESS_MEMBER_ID']))
	{
		header("location: ".$base_url."index.php");
		exit();
	}
	$sql = mysqli_query($con, "select * from groups_discuss where groupid='".$group_id."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<title><?php echo $res['title'];?></title>
<head>
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="icon" href="images/favicon.ico" type="image" />
<link rel="shortcut icon" href="images/favicon.ico" type="image" />

<link rel="stylesheet" type="text/css" href="css/group.css"/>
<link rel="stylesheet" type="text/css" href="css/search.css"/>
<link rel="stylesheet" type="text/css" href="css/dropdown.css"/>


</head>
<body>
<div id="wrapper">
<?php include('includes/header.php');?>
<div id="mainbody">
	<div class="column_left">
    <div class="componentheading">
    <div id="submenushead"><?php echo $res['title'];?></div>
    </div>
    <div id="submenushead">
    <ul class="dropDown">
    <li style="border-left:1px solid #C2CDDE; padding:0 8px;"><a href="view_groups.php?group_id=<?php echo $group_id;?>">Back to Group</a></li>
   <!-- <li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="groups.php">My Groups</a></li>
    <li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="">Pending Invitations</a></li>
  	<li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="create_groups.php">Create</a></li>
    <li style="padding:0 8px;"><a href="groups_search.php">Search</a></li> -->   
	</ul>
   </div>


<?php 
			$dsql = mysqli_query($con, "select * from groups_discuss g,members m where m.member_id=g.creator and g.groupid='$group_id'");
			$drow = mysqli_num_rows($dsql);
			if($drow > 0)
			{
			while($dres = mysqli_fetch_array($dsql))
			{
			?>  
            
            <div class="group-discussion">
            <div class="group-discussion-title"><a href="view_discussion.php?discuss_id=<?php echo $dres['id'];?>"><?php echo $dres['title'];?></a>
            <div class="group-discussion-replies"><a href="">0 Replies</a></div>
            </div>
            <div class="groups-news-meta">
            <span><?php echo date("l, j F Y",$dres['created']);?></span>
            <span>by <a href="member_profile.php?member_id=<?php echo $dres['member_id'];?>"><?php echo $dres['username'];?></a></span>
            </div>
            <div class="groups-news-text"><?php echo $dres['message'];?></div>
            </div>
            <?php }
			}
			else
			{
			?>
            <div class="empty">No discussion added yet</div>
            <?php } ?>
            
</div><!--end mainbody div-->
<?php include 'includes/footer.php';?>
</div><!--end wrapper div-->
</body>
</html>