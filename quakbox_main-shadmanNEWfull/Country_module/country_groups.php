<?php
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php'); 	 
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');
	//require_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_lookup.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_header.php');
	
	$member_id = $_SESSION['SESS_MEMBER_ID'];
	$country = $_REQUEST['country'];
	if(!isset($_SESSION['SESS_MEMBER_ID']))
	{
		header("location:index.php");
	}
	$cquery = "SELECT country_id FROM geo_country WHERE country_title = '$country'";
	$csql = mysqli_query($con, $cquery);
	$cres = mysqli_fetch_array($csql);
	$country_id = $cres['country_id'];
	
	$sql = mysqli_query($con, "select * from member where member_id='".$member_id."'") or die(mysqli_error());
	$res = mysqli_fetch_array($sql);
?>
<?php /*?><link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="icon" href="images/favicon.ico" type="image" />
<link rel="shortcut icon" href="images/favicon.ico" type="image" />
<link rel="stylesheet" type="text/css" href="css/format.css"/>
<link rel="stylesheet" type="text/css" href="css/search.css"/>
<link rel="stylesheet" type="text/css" href="css/dropdown.css"/><?php */?>
<link rel="stylesheet" type="text/css" href="css/group.css"/>

<script src="js/jquery.livequery.js" type="text/javascript"></script>
<script src="js/jquery.oembed.js"></script>
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/jquery-1.7.2.min.js"></script>
<div class="insideWrapper container">
    <div class="col-lg-9 col-md-9 col-sm-8">
	
    <div class="componentheading">
    <div id="submenushead"><?php echo $country;?> Groups</div>
    </div>
    <div id="submenushead">
    <ul class="dropDown">
    <li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="groups_all.php">All Groups</a></li>
    <li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="country_groups.php?member_id=<?php echo $country;?>">Groups</a></li>    
  	<li style="border-right:1px solid #C2CDDE; padding:0 8px;"><a href="create_country_groups.php?country_id=<?php echo $country_id;?>">Create</a></li>
    <li style="padding:0 8px;"><a href="groups_search.php">Search</a></li>  
	</ul>
   </div>

<!--<div id="cFilterBar">
<div class="cFilterBar_inner">
<div class="filterGroup" id="cFilterType_Sort">
<span class="filterName">Sort By:</span>
<ul class="filterOptions">
<li class="filterOption"><a href="groups.php?member_id=<?php echo $member_id;?>&sort=<?php echo 'latest';?>">Latest Group</a></li>
<li class="filterOption"><a href="groups.php?member_id=<?php echo $member_id;?>&sort=<?php echo 'alphabetical';?>">Alphabetical</a></li>
<li class="filterOption"><a href="groups.php?member_id=<?php echo $member_id;?>&sort=<?php echo 'mostdiscussed';?>">Most Discussed</a></li>
<li class="filterOption"><a href="groups.php?member_id=<?php echo $member_id;?>&sort=<?php echo 'mostwall';?>">Most wall posts</a></li>
<li class="filterOption"><a href="groups.php?member_id=<?php echo $member_id;?>&sort=<?php echo 'mostmember';?>">Most Members</a></li>
<li class="filterOption"><a href="groups.php?member_id=<?php echo $member_id;?>&sort=<?php echo 'mostactive';?>">Most Active</a></li>
</ul>
</div>
</div>
</div>-->

<div class="cLayout clrfix" id="groupintex">
<div class="cSidebar">
<!--<div class="app-box">
<div class="app-box-header">
<h2 class="app-box-title">Latest Discussion</h2>
</div>
</div>-->
<div id="border">
<?php
if(isset($_REQUEST['sort']))
{
if($_REQUEST['sort']=="alphabetical")
 {
	 $group_sql = mysqli_query($con, "select * from  groups g WHERE g.country_id='$country_id' order by g.name asc") or die(mysqli_error());
 }
 else if($_REQUEST['sort']=="latest")
 {
 	$group_sql = mysqli_query($con, "select * from groups g WHERE g.country_id='$country_id' order by g.created desc");
 }
 else if($_REQUEST['sort']=="mostdiscussed")
 {
 	$group_sql = mysqli_query($con, "select * from groups g WHERE g.country_id='$country_id' order by g.discusscount desc");
 }
 else if($_REQUEST['sort']=="mostwall")
 {
 	$group_sql = mysqli_query($con, "select * from groups g WHERE g.country_id='$country_id' order by g.wallcount desc");
 }
 else if($_REQUEST['sort']=="mostmember")
 {
 	$group_sql = mysqli_query($con, "select * from groups g  WHERE g.country_id='$country_id' order by g.membercount desc");
 }
 else if($_REQUEST['sort']=="mostactive")
 {
 	$group_sql = mysqli_query($con, "select * from groups g WHERE g.country_id='$country_id' order by g.created desc");
 }
}
 else
 {
 	$group_sql = mysqli_query($con, "select * from groups g where g.country_id='$country_id' order by g.created desc");
 }
 $group_count = mysqli_num_rows($group_sql);
 if($group_count > 0)
 {
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
<h3><a href="groups_wall.php?group_id=<?php echo $group_res['id']?>"><?php echo $group_res['name'];?></a></h3>
</div>
<div class="groupDescription"><?php echo $group_res['description'];?></div>
<div class="small">Created on: <?php echo date("l, j F Y",$group_res['created']);?></div>
<div class="groupActions">
<span class="icon-group" style="margin-right:5px;">
<a href="group_members.php?group_id=<?php echo $group_id;?>"><?php echo $group_member_count;?> Members</a></span>
<span class="icon-discuss" style="margin-right:5px;"><a href="">0 Discusions</a></span>
<span class="icon-wall" style="margin-right:5px;"><a href="">0 Wall Posts</a></span>
</div>
</div>
<?php } 
 }
 else
 {
?>
<div class="group-not-found">
Group Not Found
</div>
<?php } ?>
</div><!--End border div-->
</div>
</div><!--End cLayout div-->

</div><!--end column_left div-->

    <!--Start column right-->
    <div class="col-lg-2 col-md-2 col-sm-3 hidden-xs"> 
       <div id="ads" style="width:220; float:left;">
       <h3>Partners
       <a href="add_ads.php" style="margin-left:55px;">Create Ads</a>   
       </h3>
       </div>
            <div style="border-bottom: 1px solid #DDDDDD;float: left;margin: 0px;padding-top: 0px;width: 220px;">
            <div style="font-size: 13px;font-weight: bold;padding: 5px 0;color: #005689;">
            <a href="">ad title goes here</a>
            </div>
            <div style="float: left;padding-right: 8px;">
            <a href="" target="_blank">
            <img src="images/add1_1317138137.jpg"/>
            </a>
            </div>
            <div style="font-size: 12px;padding: 0 5px 5px;line-height: 13px; float:left !important">
            ad body goes here...ad body goes here...ad body goes here...ad body goes here...
            </div>
            <div style="float:left"><img src="images/6.jpg" /></div>
              <div style="float: left;width: 18%;color: #005689;cursor: pointer;position: relative;top: 2px;margin-left: 10px;">Like        </div>
            </div>
            <div style="border-bottom: 1px solid #DDDDDD;float: left;margin: 0px;padding-top: 0px;width: 220px;">
            <div style="font-size: 13px;font-weight: bold;padding: 5px 0;color: #005689;">
            <a href="">ad title goes here</a>
            </div>
            <div style="float: left;padding-right: 8px;">
            <a href="" target="_blank">
            <img src="images/add1_1317138137.jpg"/>
            </a>
            </div>
             <div style="font-size: 12px;padding: 0 5px 5px;line-height: 13px; float:left !important">
            ad body goes here...ad body goes here...ad body goes here...ad body goes here...
            </div>
            <div style="float:left"><img src="images/6.jpg" /></div>
              <div style="float: left;width: 18%;color: #005689;cursor: pointer;position: relative;top: 2px;margin-left: 10px;">Like        </div>
            </div>
            <?php //@readfile('http://output63.rssinclude.com/output?type=php&id=731231&hash=d8599a7081893730dd46d6627357163f')
            ?>
        </div>
    <!--end column_right div-->
</div><!--end mainbody div-->
<?php
	include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_footer.php');
?>