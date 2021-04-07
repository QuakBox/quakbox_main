<?php ob_start();
	session_start();
	

	if(isset($_SESSION['lang']))

	{	

		include('common.php');

	}

	else

	{

		include('en.php');

		

	}

	require_once('config.php');

	$member_id = $_SESSION['SESS_MEMBER_ID'];

	if(!isset($_SESSION['SESS_MEMBER_ID']))

	{

		header("location: ".$base_url."login.php?back=". urlencode($_SERVER['REQUEST_URI']));
		exit();

	}

	$sql = mysqli_query($con, "select * from members where member_id='".$member_id."'") or die(mysqli_error($con));

	$res = mysqli_fetch_array($sql);
	$id = $_REQUEST['id'];

?>
<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">People Who Like This</h4>
      </div>
      <div class="modal-body" style="overflow-y: scroll;">
      <?php 	  
	  $adssql = mysqli_query($con, "SELECT * FROM bleh a INNER JOIN members b ON a.member_id = b.member_id
	                       WHERE remarks='$id'") or die(mysqli_error($con));
	
	while($adsres = mysqli_fetch_array($adssql))
	{
		$member  = $adsres['member_id'];
		$count = mysqli_query($con, "select m.member_id,m.username,m.profImage,f.added_member_id from friendlist f,members m where f.added_member_id=m.member_id and f.member_id = '".$member."'");
		$count_res = mysqli_fetch_array($count);		
		$count_row = mysqli_num_rows($count);
		
		$fcount = mysqli_query($con, "select * from friendlist where (added_member_id = '$member_id' AND member_id='$member') OR
		(member_id = '$member_id' AND added_member_id='$member')") or die(mysqli_error($con));				
		$fcount_row = mysqli_num_rows($fcount);	
		
?>
        
<div class="mini-profile" id="mini-profile_<?php echo $adsres['member_id'];?>" style="width:100%; margin-top:10px;">
<div class="mini-profile-avatar">
<a href="<?php echo $base_url.$adsres['username'];?>" title="<?php echo ucfirst($adsres['username']);?>"><img src="<?php echo $adsres['profImage'];?>" style="width:50px; height:auto" /></a>
</div>
<div class="mini-profile-details">
<h3 style="font-size:120%;"><a href="<?php echo $base_url.$adsres['username'];?>" 
title="<?php echo ucfirst($adsres['username']);?>"><div<strong><?php echo ucfirst($adsres['username']);?></strong></a></h3>
</div>

</div><!--end mini profile-->
<?php }
?>
      </div>
      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->