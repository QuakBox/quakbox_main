<?php

if(!isset($_SESSION)){
session_start();
}
include('../config.php');
$rcquery = "select * from friendlist f,members m 
where f.member_id = m.member_id AND f.member_id = '".$_SESSION['SESS_MEMBER_ID']."' AND is_unread = 0";
$rcsql = mysqli_query($con, $rcquery) or die(mysqli_error($con));
$rcount = mysqli_num_rows($rcsql);

$friend_request = mysqli_query($con, "select * from friendlist f,members m where m.member_id=f.added_member_id and f.status = 0 and f.member_id = '".$_SESSION['SESS_MEMBER_ID']."'");
$request_count = mysqli_num_rows($friend_request);
//echo $request_count;
?>

        <div class="request">
		<a title="Friendship Requests" id="notifi_request" onclick="notification('','submenu1')" style="display:block;width:20px;height:20px;text-decoration:none;" href="javascript:void(0)">	
        <div class="alert" id="request_count_wrapper" style="cursor:pointer;"><span class="laers" id="request_count_value">
		<?php if($rcount > 0){ echo $rcount ;}?></span></div></a>
        </div>
        <div class="submenu1" id="submenu1"  style="display: none;padding:5px" >
        <div class="beeperNub"></div>
        <div style="padding:5px;">
        <div>
        <div style="float:right;"><a href="<?php echo $base_url;?>find_friend.php" style="color:#FFF;">Find Friend</a></div>
        <div><h3 style="font-size:11px;">Friend Requests</h3></div>
        </div>
        </div>
        <?php 
		 if($request_count > 0){
		?>
        <ul class="root" id="request-post" style="border-radius:0px;pading:5px;margin-top:5px;">        
        <?php 
			while($request_res = mysqli_fetch_array($friend_request))
			{
			?>
            <li style="display:block; margin-bottom:5px;">
            <div style="float:left; width:50px; height:50px; margin-right:8px;">
        <a href="<?php echo $base_url.$request_res['username'];?>" title="<?php echo $request_res['username'];?>"><img src="<?php echo $base_url.$request_res['profImage'];?>" width="50" height="50"/> </a>
        </div>
        <div style="overflow:hidden;">
        <div class="author"><a style="color:#fff;text-transform: capitalize;font-weight:normal;" href="<?php echo $base_url.$request_res['username'];?>" title="<?php echo $request_res['username'];?>"><?php echo $request_res['FirstName'];?></a>
        </div>
        <div style="float:right" id="friends1">
        <div style="display:inline;"><input type="button" name="accept_request" value="Confirm" id="<?Php echo $request_res['member_id'];?>" style="color:#fff;background:#1D7299;border:none;"
        class="accept_request"></div>
        <div style="display:inline;"><input type="button" style="color:#fff;background:#1D7299;border:none;"  name="cancel_request" value="Not Now" id="<?Php echo $request_res['member_id'];?>" class="cancel_request"></div>
        </div>
        <div style="display:none; float:right" id="friends">
        <input type="button" name="accept_request" value="Friends" class="friends">
        </div>
       
        </div>
	      <!--<a href="request.php" class="request_div" style="color:#FFF;"><?php echo $request_count;?> New Request</a>-->
          </li>
          <?php } ?> 
          </ul>
          <?php }
		  else {?>
        <div class="community-empty-list" >No new Request</div><?php } ?>


	      <div class="community-empty-list" style="padding:5px;"><a href="<?php echo $base_url;?>friends.php?friend_id=<?php echo $_SESSION['SESS_MEMBER_ID'];?>" style="color:#FFF;">Show All Friends</a></div>
	 
	</div>