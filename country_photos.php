<?php 
	session_start();
	require_once('config.php');
	if(!isset($_SESSION['SESS_MEMBER_ID']))
	{
		header("location: ".$base_url."index.php");
		exit();
	}
	$member_id = $_SESSION['SESS_MEMBER_ID'];
	
	$country_code = $_REQUEST['country'];
	$sql = mysqli_query($con, "select * from members where member_id='".$member_id."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);
	
	$cnquery = "select country_title, country_id from geo_country where country_title = '$country_code'";
	$cnsql = mysqli_query($con, $cnquery);
	$cnres = mysqli_fetch_array($cnsql);
	
	$country_id = $cnres['country_id'];	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<title><?php echo ucfirst($cnres['country_title']);?> photo</title>
<head>
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="icon" href="images/favicon.ico" type="image" />
<link rel="shortcut icon" href="images/favicon.ico" type="image" />

<link rel="stylesheet" type="text/css" href="css/format.css"/>
<link rel="stylesheet" type="text/css" href="css/album.css"/>
<link rel="stylesheet" type="text/css" href="css/search.css"/>
<link rel="stylesheet" type="text/css" href="css/dropdown.css"/>
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
    <input type="button" class="button" value="<?php echo $country_code;?>" 
    onclick="window.open('country_wall.php?country=<?php echo $country_code;?>','_self');" /> 
       
   <div id="border" style="bottom:4px !important;">
   <div id="search_country" style="width:693px !important; margin:0px auto;">

<div class="ctitle"><h2 style="font-size:110%; font-weight:bold; margin:15px 0 3px; margin:10px !important;">
<?php echo ucfirst($cnres['country_title']);?> Photos</h2></div>

<div id="fb-album" style="height:200px">

<!-- <a href="#" class="topopup"><img style="margin-left:10px;cursor:pointer;" src="images/uploadAlbum.png"></a>!-->

<?php

	$da= "Select * from user_album where type = 1 and country_id = '$country_id'";
	$result = mysqli_query($con, $da) or die(mysqli_error($con));
	if(mysqli_num_rows($result) > 0)
	{
		while ($row = mysqli_fetch_array($result) )
		{	
		  echo '<div class="albumWrapper" style=";clear:both">';
		  echo '<div class="albumThumb fbLink" style="width:161px;height:120px" title="'.$row['album_name'].'">';
		  $ia = "Select * from upload_data where album_id=".$row["album_id"]." order by date_created";
		  $result1 = mysqli_query($con, $ia) or die(mysqli_error($con));
		  $count = mysqli_num_rows($result1);
		  $row1 = mysqli_fetch_array($result1);
		  $dir123 = $row1['FILE_NAME'];
		  
		  echo '<a href="country_load_album.php?back_page=country_photos.php?country='.$country_code.'&album_id='.$row["album_id"].'&country_id='.$country_id.'" style="clear:both;">';
		  
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
		  echo ''.$count.' Photos';
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
		<div class="community-empty-list">No Photos</div>
<?php 
	} 
?>

 </div>
<div id="toPopup">     	
        <div class="close"></div>
       	<span class="ecs_tooltip">Press Esc to Cancel <span class="arrow"></span></span>
		<div id="popup_content"> <!--your content start-->
            <p>
            <form action="action/add_country_photo-exec.php" method="POST" enctype="multipart/form-data">
            <p>
	          &nbsp;Enter Album Name    
            </p>
            <p><input type="text" id="album" name="album" class="validate" placeholder="Type Your Album Name here.." required>
            <span class="error" style="display:none;color:#6f0000;">* Enter Album Name</span></p>
			<input class="sumbitform" type="file" name="files[]" multiple/>
            <input type="hidden" name="member_id" id="member_id" value="<?php echo $member_id;?>" />
            <input type="hidden" name="country_id" id="country_id" value="<?php echo $country_id;?>" />
			<input type="submit" value="Upload" class=""/>
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
</body>
</html>