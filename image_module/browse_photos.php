   <?php
   include('config.php');
   $member_id = $_REQUEST['member_id'];
	
	$uquery = "SELECT u.upload_data_id, u.FILE_NAME, m.member_id 
				FROM upload_data u LEFT JOIN member m ON u.USER_CODE = m.member_id 
				WHERE m.member_id = '$member_id'
				AND u.share != 1 
				ORDER by u.upload_data_id DESC";
	
	$result = mysqli_query($con, $uquery) or die(mysqli_error($con));
	
	while ($row = mysqli_fetch_array($result) )
	{
	?>  
	  
	<div class="photo" style="z-index:100009;margin-top: 20px;" >
	  
	<div id="<?php echo $row['upload_data_id'];?>" class="topup">
	  
	<a href="<?php echo $base_url;?>action/change_profile_picture.php?member_id=<?php echo $row['member_id']; ?>&image_id=<?php echo $row['upload_data_id'];?>" >
<img width="149" height="116" src="<?php echo $base_url.$row['FILE_NAME'];?>" id="<?php echo $row['upload_data_id'];?>"  />	  
	  </a>
      </div>	 	 
	  </div>
	   
   	<?php } ?>
	
