<?php 
	
	require_once('common/common.php');
	$member_id = $QbSecurity->qbClean($_SESSION['SESS_MEMBER_ID'], $con);
	// Get search results based on group_id
	// normalize and validate group_id 
	$group_id=$QbSecurity->qbClean($_GET['group_id'], $con);
	$group_id=htmlspecialchars(trim($group_id));
	if(!(empty($group_id)||($qbValidation->qbIntegerCheck($group_id))))
	{
	$qb_err_msg="Oops Something Went Wrong...!";
    $QbSecurity->qbErrorMessage($qb_err_msg,$homepage);
	}
	else
	{
	$sql = mysqli_query($con, "select * from members where member_id='".$member_id."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);
	
	$gquery = "SELECT name FROM groups WHERE id = '$group_id'";
	$gsql = mysqli_query($con, $gquery);
	$gres = mysqli_fetch_array($gsql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<title><?php echo ucfirst($gres['name']);?></title>
<head>
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="icon" href="images/favicon.ico" type="image" />
<link rel="shortcut icon" href="images/favicon.ico" type="image" />

<link rel="stylesheet" type="text/css" href="css/format.css"/>
<link rel="stylesheet" type="text/css" href="css/album.css"/>
<link rel="stylesheet" type="text/css" href="css/search.css"/>
<link rel="stylesheet" type="text/css" href="css/dropdown.css"/>
<link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.css" />
<script src="js/ibox.js"></script>
<script src="js/jquery.livequery.js" type="text/javascript"></script>
<script src="js/jquery.oembed.js"></script>
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/script.js"></script>

</head>
<body>
<div id="wrapper">
<?php include('includes/header.php');?>
<div id="mainbody">
<div class="column_left">
	<div class="column_internal_left">
       
   <div id="border" style="bottom:4px !important;">
   
   <input type="button" class="button" value="<?php echo $lang['Back to Group'];?>" onclick="window.open('groups_wall.php?group_id=<?php echo $group_id;?>','_self')" />
   <div id="search_country" style="width:693px !important; margin:0px auto;">

<div class="ctitle"><h2 style="font-size:110%; font-weight:bold; margin:15px 0 3px; margin:10px !important;">
<?php echo ucfirst($gres['name']);?><?php echo $lang['Photos'];?></h2></div>

<div id="fb-album" style="height:200px">

 <a href="#" class="topopup"><img style="margin-left:10px;cursor:pointer;" src="images/uploadAlbum.png"></a>

<?php

	$da= "Select album_id, album_name from groups_album where album_group_id=".$group_id." "; 
	$result = mysqli_query($con, $da) or die(mysqli_error($con));
	if(mysqli_num_rows($result) > 0)
	{
	while ($row = mysqli_fetch_array($result) )
	{	
	
	  echo '<div class="albumWrapper" style=";clear:both">';
	  echo '<div class="albumThumb fbLink" style="width:161px;height:120px" title="'.$row['album_name'].'">';
	  $ia = "Select * from groups_photo where album_id=".$row["album_id"]." and group_id=".$group_id." AND share !=1 order by date_created";
	  $result1 = mysqli_query($con, $ia) or die(mysqli_error($con));
	  $count = mysqli_num_rows($result1);
	  $row1 = mysqli_fetch_array($result1);
	  $dir123 = $row1['FILE_NAME'];
	  
	  echo '<a href="group_load_album.php?back_page=group_photos.php='.$group_id.'&group_id='.$group_id.'&album_id='.$row["album_id"].'" 
	  style="clear:both;">';
	  
	  echo '<span class="albumThumbWrap">';
	  echo '<i style="width: 161px; height: 120px; background-image: url('.$dir123.'); background-size:161px 120px; "  ></i>';
	  echo '</span></a>';
	  echo '</div>';
	  echo '<div class="albumDetails" style="width:161px;">';
	  echo '<div class="albumText">';
	  echo '<div class="fbLink">';
	  echo '<strong>'.$row['album_name'].'&nbsp;&nbsp;</strong>';
	  
	  
	  echo '</div>';
	  echo '<div class="albumCount">';
	  echo ''.$count.''.$lang['Photos'];
	  echo '</div>';
	  echo '</div>';
	  echo '</div>';
	  
	  echo '</div>';
	  echo '</a>';
	}
	}
	else
	{
?>
<div class="community-empty-list"><?php echo $lang['There are no photos'];?></div>
 <?php } ?>

 </div>
<div id="toPopup">     	
        <div class="close"></div>
       	<span class="ecs_tooltip"><?php echo $lang['Press Esc to Cancel'];?> <span class="arrow"></span></span>
		<div id="popup_content"> <!--your content start-->
            <p>
            <form action="action/add_group_photo-exec.php" method="POST" enctype="multipart/form-data">
            <p>
	          &nbsp;<?php echo $lang['Enter Album Name'];?>    
            </p>
            <p><input type="text" id="album" name="album" class="validate" placeholder="<?php echo $lang['Type Your Album Name here'];?>.." required>
            <span class="error" style="display:none;color:#6f0000;">* <?php echo $lang['Enter Album Name'];?></span></p>
			<input class="sumbitform" type="file" name="files[]" multiple/>
            <input type="hidden" id="group_id" name="group_id" value="<?php echo $group_id;?>" />
			<input type="submit" value="<?php echo $lang['Upload'];?>" class=""/>
            </form></p>            
        </div> <!--your content end-->    
    </div> <!--toPopup end-->
    
    <div class="loader"></div>
   	<div id="backgroundPopup"></div>
</div>
</div>

</div>

    

</div>
</div>

</div>

</div>
<?php } ?>
</body>
</html>