<?php
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php'); 	 
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');
	//require_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_header.php');
	
	if(!isset($_SESSION['SESS_MEMBER_ID']))
	{
		header("location: ".$base_url."login.php?back=". urlencode($_SERVER['REQUEST_URI']));
		exit();
	}
	
	$member_id = $_SESSION['SESS_MEMBER_ID'];
	
	$usql = mysqli_query($con, "select * from member where member_id='".$member_id."'") or die(mysqli_error($con));
	$ures = mysqli_fetch_array($usql);
		
	$sql = mysqli_query($con, "select categoryid from groups where categoryid=1") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);
	$count = mysqli_num_rows($sql);
	
	$sql1 = mysqli_query($con, "select categoryid from groups where categoryid=2") or die(mysqli_error($con));
	$res1 = mysqli_fetch_array($sql1);
	$count1 = mysqli_num_rows($sql1);
	
	$sql2 = mysqli_query($con, "select categoryid from groups where categoryid=3") or die(mysqli_error($con));
	$res2 = mysqli_fetch_array($sql2);
	$count2 = mysqli_num_rows($sql2);
	
	$sql3 = mysqli_query($con, "select categoryid from groups where categoryid=4") or die(mysqli_error($con));
	$res3 = mysqli_fetch_array($sql3);
	$count3 = mysqli_num_rows($sql3);
	
	$sql4 = mysqli_query($con, "select categoryid from groups where categoryid=5") or die(mysqli_error($con));
	$res4 = mysqli_fetch_array($sql4);
	$count4 = mysqli_num_rows($sql4);
?>
<?php /*?><link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="icon" href="images/favicon.ico" type="image" />
<link rel="shortcut icon" href="images/favicon.ico" type="image" />
<link rel="stylesheet" type="text/css" href="css/format.css"/>
<link rel="stylesheet" type="text/css" href="css/search.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>font-awesome/css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>css/responsive.css" />
<link rel="stylesheet" type="text/css" href="css/dropdown.css"/><?php */?>
<link rel="stylesheet" type="text/css" href="css/group.css"/>
<script src="js/jquery.livequery.js" type="text/javascript"></script>
<script src="js/jquery.oembed.js"></script>
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/jquery-1.7.2.min.js"></script>
<script src="<?php echo $base_url;?>js/check.js"></script>
<div id="mobile_group_all">
<div class="insideWrapper container">
    <div class="col-lg-9 col-md-9 col-sm-9"> 
	
    <div class="componentheading">
    <div id="submenushead"><?php echo $lang['All Groups'];?></div>
    </div>
    <div id="submenushead">
    <ul class="dropDown">
    <li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="groups_all.php"><?php echo $lang['All Groups'];?></a></li>
    <li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="<?php echo $base_url.'groups/'.$ures['username'];?>"><?php echo $lang['My Groups'];?></a></li>
    <li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href=""><?php echo $lang['Pending Invitations'];?></a></li>
  	<li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="create_groups.php"><?php echo $lang['Create'];?></a></li>
<!--    <li style="padding:0 8px;"><a href="groups_search.php">--><?php //echo $lang['Search'];?><!--</a></li>  -->
	</ul>
   </div>

<div id="cFilterBar">
<div class="cFilterBar_inner">
<div class="filterGroup" id="cFilterType_Sort">
<span class="filterName"><?php echo $lang['Sort By'];?>:</span>
<ul class="filterOptions">
<li class="filterOption"><a href="groups_all.php?sort=<?php echo 'latest';?>"><?php echo $lang['Latest Group'];?></a></li>
<li class="filterOption"><a href="groups_all.php?sort=<?php echo 'alphabetical';?>"><?php echo $lang['Alphabetical'];?></a></li>
<!--<li class="filterOption"><a href="groups_all.php?sort=<?php echo 'mostdiscussed';?>">Most Discussed</a></li>!-->
<!--<li class="filterOption"><a href="groups_all.php?sort=<?php echo 'mostwall';?>">Most wall posts</a></li>!-->
<li class="filterOption"><a href="groups_all.php?sort=<?php echo 'mostmember';?>"><?php echo $lang['Most Members'];?></a></li>
<!--<li class="filterOption"><a href="groups_all.php?sort=<?php echo 'mostactive';?>">Most Active</a></li>!-->
</ul>
</div>
</div>
</div>

<div class="cLayout clrfix" id="groupintex">
<div class="cRow">
<div class="ctitle"><?php echo $lang['Featured Groups'];?></div>
<div class="featured-items">
</div><!--end featured-items div-->
</div><!--end crow div-->

<div class="cRow">
<div class="ctitle"><?php echo $lang['Categories'];?></div>
<ul class="c3colList">
<li><a href="groups_all.php"><?php echo $lang['All Groups'];?></a></li>
<?php 
$gcsql = mysqli_query($con, "SELECT * FROM groups_category ORDER BY name");
while($gcres = mysqli_fetch_array($gcsql)) {
	$category_id = $gcres['id'];
	$sql = mysqli_query($con, "select categoryid from groups where categoryid='$category_id'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);
	$count = mysqli_num_rows($sql);
?>
<li><a href="groups_all.php?cat=<?php echo $gcres['id'];?>">
<?php if(isset($_SESSION['lang']) && ($_SESSION['lang'])<>'en'){
	if ($gcres['name']== 'Automotive') echo $lang['Automotive']; 
	else if ($gcres['name']== 'General') echo $lang['General'];
	else if ($gcres['name']== 'Internet') echo $lang['Internet'];
	else if ($gcres['name']== 'Business') echo $lang['Business'];
	else if ($gcres['name']== 'Music') echo $lang['Music']; 
	 }
	 else echo $gcres['name'];?></a> ( <?php echo $count;?> )</li>
<?php } ?>
</ul>
</div><!--end crow div-->
<div class="cSidebar">
<div class="app-box">
<div class="app-box-header">
<h2 class="app-box-title"><?php echo $lang['Latest Discussion'];?></h2>
</div>
</div>
<div class="totlgrp">
<div class="lbl"> Total Groups : </div>
<div class="grpno"> 13</div>
</div>

<div id="border">
<?php 
if(isset($_REQUEST['sort']))
{
if($_REQUEST['sort']=="alphabetical")
 {
	 $group_sql = mysqli_query($con, "select * from groups order by name asc") or die(mysqli_error($con));
 }
 else if($_REQUEST['sort']=="latest")
 {
 	$group_sql = mysqli_query($con, "select * from groups order by created desc");
 }
 else if($_REQUEST['sort']=="mostdiscussed")
 {
 	$group_sql = mysqli_query("select * from groups g  order by discusscount desc");
 }
 else if($_REQUEST['sort']=="mostwall")
 {
 	$group_sql = mysqli_query($con, "select * from groups order by wallcount desc");
 }
 else if($_REQUEST['sort']=="mostmember")
 {
 	$group_sql = mysqli_query($con, "select * from groups  order by membercount desc");
 }
 else if($_REQUEST['sort']=="mostactive")
 {
 	$group_sql = mysqli_query($con, "select * from groups order by created desc");
 } 
}
else if(isset($_REQUEST['cat']) && ($_REQUEST['cat'] != ''))
 {
	 $cat = $_REQUEST['cat'];
 	$group_sql = mysqli_query($con, "select * from groups WHERE categoryid = '$cat'");
 }
 else
 {
 	$group_sql = mysqli_query($con, "select * from groups order by created desc");
 }
 
 if(mysqli_num_rows($group_sql) > 0) {
 $r_g = 0; 
 while($group_res = mysqli_fetch_array($group_sql))
 {
	 $group_id = $group_res['id'];
	 $group_member_sql = mysqli_query($con, "select * from groups_members where groupid='$group_id'");
	 $group_member_count = mysqli_num_rows($group_member_sql);	 
?>



<div class="community-groups-results-item" style="line-height:1.5em;">
<div class="community-events-results-left">
<a href="groups_wall.php?group_id=<?php echo $group_res['id']?>">
<img src="<?php echo $group_res['avatar']?>" height="68" width="68" />
</a>
</div>
<div class="community-events-results-right">
<h3><a href="groups_wall.php?group_id=<?php echo $group_res['id']?>">
<?php  
    
    
     if(isset($_SESSION['lang'])&&($_SESSION['lang']!='en'))
		 {
		$res=mysqli_query ($con, "select * from groups1  where group_id = '".$group_res['id']."' and  lang = '".$_SESSION['lang']."' and type ='0' ");		
             $result_group=mysqli_fetch_array($res);
              $count=mysqli_num_rows($res);
		//echo $count;
             if($count > 0)
             {
               echo $result_group['data'];
              }
              else
              {
             // echo $s;
				  $last_id = $group_res['id'];
				  $title = $group_res['name'];
				  $type_gp='2';
			     include "translate_group.php";
			    // $r_g++;
			  }
		 }
		 else
		 {
		echo $group_res['name'];
		 }
            
    ?>

</a></h3>
</div>
<div class="groupDescription">

<?php  if(isset($_SESSION['lang'])&&($_SESSION['lang']!='en'))
		 {
		$res=mysqli_query ($con, "select * from groups1  where group_id = '".$group_res['id']."' and  lang = '".$_SESSION['lang']."' and type ='0' ");		
             $result_group=mysqli_fetch_array($res);
              $count=mysqli_num_rows($res);
		//echo $count;
             if($count > 0)
             {
               echo $result_group['data'];
              }
              else
              {
             // echo $s;
				  $last_id = $group_res['id'];
				  $title = $group_res['description'];
				  $type_gp='3';
			     include "translate_group.php";
			    // $r_gd++;
			  }
		 }
		 else
		 {
		echo $group_res['description'];
		 }
		 ?>

</div>
<div class="small"><?php echo $lang['Created on']?>: <?php echo date("l, j F Y",$group_res['created']);?></div>
<div class="groupActions">
<span class="icon-group" style="margin-right:5px;">
<a href="group_members.php?group_id=<?php echo $group_id?>"><?php echo $group_member_count.' ';?> <?php echo $lang['Member']?></a></span>
<!--<span class="icon-discuss" style="margin-right:5px;"><a href="">0 Discusions</a></span>!-->
<!--<span class="icon-wall" style="margin-right:5px;"><a href="">0 Wall Posts</a></span>!-->
</div>
</div>
<?php } 
 } else {
?>
<div class="group-not-found">
<?php echo $lang['Group Not Found']?>
</div>
<?php  }?>
</div>
</div><!--End border div-->
</div><!--End cLayout div-->

</div><!--end column_left div-->

<!--Start column right-->
    <div class="col-lg-2 col-md-3 col-sm-3 hidden-xs"> 
        <div style="" class="adsQBxzqw"> <?php include($_SERVER['DOCUMENT_ROOT'].'/qb_widgets/ads.php');?></div>
    </div>
<!--end column_right div-->
</div><!--end mainbody div-->
</div>
<?php
	include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_footer.php');
?>