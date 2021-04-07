<?php 
	session_start();
	require_once('config.php');
	$member_id = $_SESSION['SESS_MEMBER_ID'];
	$bulletine_id = $_REQUEST['bulletine_id'];
	if(!isset($_SESSION['SESS_MEMBER_ID']))
	{
		header("location: ".$base_url."index.php");
		exit();
	}
	$sql = mysqli_query($con, "select * from groups_bulletins g,members m where m.member_id=g.created_by and g.id='".$bulletine_id."'") or die(mysqli_error($con));
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
    <div id="submenushead" style="width:500px;">
    <ul class="dropDown">
    <li style="border-left:1px solid #C2CDDE; padding:0 8px;"><a href="view_groups.php?group_id=<?php echo $res['groupid'];?>">Back to Group</a></li>
   <!-- <li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="groups.php">My Groups</a></li>
    <li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="">Pending Invitations</a></li>
  	<li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="create_groups.php">Create</a></li>
    <li style="padding:0 8px;"><a href="groups_search.php">Search</a></li> -->   
	</ul>
   </div>

<div class="page-actions">
<div class="page-action"><a class="icon-report"><span>Report Bulletine</span></a></div>
<div class="page-action"><a class="icon-bookmark"><span>Share This</span></a></div>
</div>

<div id="group-buletin-topic">
<div class="author-avatar">
<a href="#">
<img class="avatar" src="<?php echo $res['profImage'];?>" height="50" width="50"/>
</a>
</div>
<div class="buletin-detail">
<div class="buletin-created">
Discussion started by <a href="#"><?php echo $res['username'];?></a>, on <?php echo date('l, j F Y',$res['date']);?>
</div>
<div class="buletin-entry"><?php echo $res['message'];?></div>

</div>
</div>
<div class="app-box">
<div class="wall-tittle">Replies</div>
<div id="wallForm"></div>
<div id="wallContent">
                <div><a href="">Older Posts</a>
                 <a href="" style="float:right; bottom:16px;">Recent activities</a>
                </div>
               
                </div>
</div></div>


</div><!--end mainbody div-->
<?php include 'includes/footer.php';?>
</div><!--end wrapper div-->
</body>
</html>