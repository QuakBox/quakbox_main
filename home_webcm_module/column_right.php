<!--onmouseover="scrollbar()" onmouseout="hidescrollbar()"!-->
<?php
include($_SERVER['DOCUMENT_ROOT'].'/common/qb_config.php'); 
?>
<style type="text/css" id="page-css">
			/* Styles specific to this particular page */
			.column_right
			{
				
				height: 200px;
				overflow: auto;
			}
			.horizontal-only
			{
				height: auto;
				max-height: 200px;
			}
		</style>
<div class="column_right" style="height:500px; position:fixed; overflow:hidden" onmouseover="scrollbar()" onmouseout="hidescrollbar()" >
<div >
	<div class="moduletable">
	<!--<div class="re" style="position: absolute; margin-left: 60px; margin-top: 39px; transform: rotate(35deg);">
	<img src="images/pinkrib1.png">
	</div>-->
    <img style="margin-top: 10px;margin-left: 5px;width: 150px;padding-left: 13px;" width=106 height=140 src="images/ww.png">
	<div align="center" style="white-space: nowrap;text-overflow: ellipsis;"><?php echo $lang['WORLD']; ?></div>
    <div style="border-bottom:1px solid rgb(236, 235, 235); margin: 4px 7px; padding: 0px 0px 10px;"></div>
	</div>
    
    <!--<div class="app-box">
    <div class="app-box-title">MY WORLD FANS</div>
   <?php 
$friend = mysqli_query($con,"select * from members where member_id!='$member_id' order by member_id desc");
while($friend_res = mysqli_fetch_array($friend))
{

?>
	<div style="border: 1px solid #ccc; float:left; height: 40px; width: 40px; overflow: hidden; padding: 3px; margin: 6px;">
		<a href="member_profile.php?member_id=<?php echo $friend_res['member_id'];?>" title="<?php echo $friend_res['username'];?>"><img src="<?php echo $friend_res['profImage'];?>" height="40" width="40"/></a>
	</div>
<?php 
}
?>
	 
    </div>
    
        <div class="app-box">
    <div class="app-box-title">OTHER WORLD FANS</div>
   <?php 
$friend = mysqli_query($con,"select * from members where member_id!='$member_id' order by member_id desc");
while($friend_res = mysqli_fetch_array($friend))
{

?>
	<div style="border: 1px solid #ccc; float:left; height: 40px; width: 40px; overflow: hidden; padding: 3px; margin: 6px;">
		<a href="member_profile.php?member_id=<?php echo $friend_res['member_id'];?>" title="<?php echo $friend_res['username'];?>"><img src="<?php echo $friend_res['profImage'];?>" height="40" width="40"/></a>
	</div>
<?php 
}
?>
	 
    </div>-->
    
	<!--<div style="margin:0 0 5px; width:100%; padding:0 !important; float:left; position:relative;">
    
	<label style="font-weight: bold; color:#3B5998; margin: 5px; font-size:12px;white-space: nowrap;text-overflow: ellipsis;"><?php echo $lang['Latest members'];?></label>
    <div style="float:left; width:100%;">
<?php 
$friend = mysqli_query($con,"select * from members where member_id!='$member_id' order by member_id desc LIMIT 10");
while($friend_res = mysqli_fetch_array($friend))
{

?>
	<div  style="border: 1px solid #ccc; float:left; height: 35px; width: 35px; overflow: hidden; padding: 3px; margin: 6px;" id="show-friend">
		<a href="<?php echo $base_url.$friend_res['username'];?>" title="<?php echo $friend_res['username'];?>"><img src="<?php echo $friend_res['profImage'];?>" height="35" width="35"/></a>
	</div>
<?php 
}
?>	
</div>
<br />

<div><a href="latest_members.php" style="float:right;white-space: nowrap;text-overflow: ellipsis;margin-right: 40px;"><?php echo $lang['show all'];?></a></div>
</div>-->

<!-- styles needed by jScrollPane - include in your own sites -->
		<link type="text/css" href="css/jquery.jscrollpane.css" rel="stylesheet" media="all" />

<!-- the mousewheel plugin -->
		<script type="text/javascript" src="js/jquery.mousewheel.js"></script>
		<!-- the jScrollPane script -->
		<script type="text/javascript" src="js/jquery.jscrollpane.min.js"></script>
		<!-- scripts specific to this demo site -->
		

		<script type="text/javascript" id="sourcecode">
			$(function()
			{
				$('.column_right').jScrollPane();
				//$('#news_feed').jScrollPane();
			});
			$(document).ready(function(e) {
                
				$('.jspVerticalBar').hide();
            });
		</script>
</div>
<div style="padding: 0px 0px 0px 8px;">
<a href="app.php"><p style="font-size: 15px; padding-bottom: 13px; font-family: initial; color: rgb(18, 66, 89);text-overflow: ellipsis;">Apps</p><!--<p style="float: right; margin: -28px 12px 4px 0px; font-size: 11px;white-space: nowrap;text-overflow: ellipsis;">Show All</p>--></a>

<?php 
$query=mysqli_query($con, "select *from app where status='1' order by id desc limit 10");
while($res=mysqli_fetch_array($query))
{
?>
<div   style="padding-bottom: 10px; width: 67px; font-size: 10px; font-family: unset; font-style: italic; float: left; height: 75px; padding-right: 17px;">

<a href="app1.php?code=<?php echo $res['id'];?>" style="text-overflow: ellipsis;" ><img src="<?php echo $res['image'];?>" style="width: 61px; padding-right: 4px; margin: 1px 0px 0px 1px;" /><?php echo $res['name'];?> </a>
</div>

<?php }?>

</div>

</div>