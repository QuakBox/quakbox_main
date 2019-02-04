<?php 

$mysub =mysqli_query($con, "select * from videos_subscribe a INNER JOIN members b ON a.member_id= b.member_id where a.subscriber_member_id='$session_member_id' ORDER BY b.username asc LIMIT 3");



?>



<div id="leftSidePannel">

<ul>
<?php	if(isset($_SESSION['SESS_MEMBER_ID'])) 

	{
		// Added By Yasser Hossam and Mushira Ahmad 15/2/2016 to fix error
		require_once 'qb_classes/qb_member.php';
		$member = new Member();
		$username = $member->get_username_by_id($_SESSION['SESS_MEMBER_ID']);
	?>


<div class="nav_header"><span style="margin-left: 9px;"><?php echo $username;?></span> </div>
<li><i class="fa1 fa-user fa-2x"></i> 
<a href="<?php echo $base_url.'user/'.$username;?>" class="left_links"><?php echo $lang['My Stations'];?></a></li>

<li><i class="fa1 fa-user fa-2x"></i> 
<a href="<?php echo $base_url;?>myvideos.php" class="left_links"><?php echo $lang['My video'];?></a></li>

<li><i class="fa1 fa-user fa-2x"></i> 
<a href="<?php echo $base_url;?>mylivevideos.php" class="left_links"><?php echo "My Live video";?></a></li>
<li><i class="fa1 fa-user fa-2x"></i> <a href="<?php echo $base_url;?>add_video_gallery.php" class="left_links"><?php echo $lang['Add video'];?></a></li>
	<?php }?>
<div class="nav_header"><span style="margin-left: 9px;"><?php echo $lang['CATEGORIES'];?></span></div>

<li><i class="fa fa-foursquare fa-2x"></i> <a href="<?php echo $base_url;?>popular_videos.php" class="left_links"><?php echo $lang['Popping on Quakbox'];?></a></li>
 
 <li><i class="fa1 fa-headphones fa-2x"></i><a href="<?php echo $base_url;?>video_category.php?id=7" class="left_links"><?php echo $lang['Tune'];?></a></li>
<li><i class="fa1 icon-sport fa-2x"></i><a href="<?php echo $base_url;?>video_category.php?id=16" class="left_links"><?php echo $lang['Sports'];?></a></li>

<li><i class="fa1 fa-youtube-play fa-2x"></i><a href="<?php echo $base_url;?>video_category.php?id=12" class="left_links"><?php echo $lang['Silver Screen'];?></a></li>
 
 <li><i class="fa1 fa-film fa-2x"></i><a href="<?php echo $base_url;?>video_category.php?id=14" class="left_links"><?php echo $lang['TeleVision'];?></a></li>
 
<li><i class="fa1 fa-book fa-2x"></i> <a href="<?php echo $base_url;?>video_category.php?id=15" class="left_links"><?php echo $lang['Knowledge Base'];?></a></li>

<li> <a id="morectgrlink" class="left_links" style="text-decoration:underline;"><?php echo $lang['More Categories'];?></a></li>

<div id="moreCtgr">
<li><i class="fa1 fa-users fa-2x"></i> <a href="<?php echo $base_url;?>video_category.php?id=1" class="left_links"><?php echo $lang['Actors'];?></a></li>

<li><i class="fa1 fa-smile-o fa-2x"></i> <a href="<?php echo $base_url;?>video_category.php?id=2" class="left_links"><?php echo $lang['Comedy'];?></a></li>

<li><i class="fa1 fa-cutlery fa-2x"></i> <a href="<?php echo $base_url;?>video_category.php?id=3" class="left_links"><?php echo $lang['Cooking'];?></a></li>

<li><i class="fa1 fa-file fa-2x"></i> <a href="<?php echo $base_url;?>video_category.php?id=4" class="left_links"><?php echo $lang['Documentary'];?></a></li>

<li><i class="fa1 fa-envelope fa-2x"></i> <a href="<?php echo $base_url;?>video_category.php?id=5" class="left_links"><?php echo $lang['Greetings'];?></a></li>

<li><i class="fa1 fa-book fa-2x"></i> <a href="<?php echo $base_url;?>video_category.php?id=6" class="left_links"><?php echo $lang['Interviews'];?></a></li>

<li><i class="fa1 fa-file-text-o fa-2x"></i> <a href="<?php echo $base_url;?>video_category.php?id=8" class="left_links"><?php echo $lang['News & Info'];?></a></li>

<li><i class="fa1 fa-users fa-2x"></i> <a href="<?php echo $base_url;?>video_category.php?id=9" class="left_links"><?php echo $lang['Religious'];?></a></li>

<li><i class="fa1 fa-pencil-square-o fa-2x"></i> <a href="<?php echo $base_url;?>video_category.php?id=10" class="left_links"><?php echo $lang['Speeches'];?></a></li>

<li><i class="fa1 fa-male fa-2x"></i> <a href="<?php echo $base_url;?>video_category.php?id=11" class="left_links"><?php echo $lang['Talk Shows'];?></a></li>

<li><i class="fa1 fa-book fa-2x"></i> <a href="<?php echo $base_url;?>video_category.php?id=15" class="left_links"><?php echo $lang['Education'];?></a></li>

<li><i class="fa1 fa-truck fa-2x"></i> <a href="<?php echo $base_url;?>video_category.php?id=13" class="left_links"><?php echo $lang['Travel'];?> </a></li>
<li> <a id="hidectgrlink" class="left_links" style="text-decoration:underline;"><?php echo $lang['Hide Categories'];?></a></li>
</div>
<?php	if(isset($_SESSION['SESS_MEMBER_ID'])) 

	{?>

<li class="browse"><i class="fa1 fa-user fa-2x"></i> <a href="<?php echo $base_url;?>subscription_manager.php" class="left_links"><?php echo $lang['My Subscription'];?></a></li>

<?php while($mysub_res = mysqli_fetch_array($mysub))
	{?>
		<li>
<a href="<?php echo $base_url.'user/'.$mysub_res['username'];?>" title="<?php echo ucfirst($mysub_res['username']);?>"><img src="<?php echo $base_url. $mysub_res['profImage'];?>" width="20" height="20" style="margin-right:7px;"/><?php echo ucfirst($mysub_res['username']);?></a>
</li>

<?php }}?>
		



<li class="browse"><i class="fa fa-plus-square-o fa-2x"></i> <a href="<?php echo $base_url;?>browse_channel.php" class="left_links"><?php echo $lang['Browse Stations'];?></a></li>
</div>

<script>
$(function() {
$( "#morectgrlink" ).click(function() {
$( "#moreCtgr" ).show(1000);
$( "#morectgrlink" ).hide();
});
});
</script>

<script>
$(function() {
$( "#hidectgrlink" ).click(function() {
$( "#moreCtgr" ).hide(1000);
$( "#morectgrlink" ).show();
});
});
</script>
