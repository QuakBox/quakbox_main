<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Quakbox</title>
<link rel="stylesheet" href="css/style2.css" type="text/css" media="screen"/>
<link rel="stylesheet" type="text/css" href="css/template.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/album.css">
<script type="text/javascript" src="js/jquery-1.8.0.min.js"></script>
<script type="text/javascript">
$(function(){/*
var albumname=document.getElementById("album").value;
	 alert(albumname);
	 if(albumname=="")
	 {
		 document.getElementById("error")style.display='block';
		 return false;
	 }
*/
jQuery(document).live("click", function(e) { 
	var $clicked = $(e.target); 
	
	if ($clicked.hasClass("validate")){
	//alert("ddsds"); 
	
	}
});

$(".search").keyup(function() 
{ 
var inputSearch = $(this).val();
var dataString = 'searchword='+ inputSearch;
if(inputSearch!='')
{
	$.ajax({
	type: "POST",
	url: "search.php",
	data: dataString,
	cache: false,
	success: function(html)
	{
	
	$("#divResult").html(html).show();
        
	}
	});
}return false;    
});


jQuery(document).live("click", function(e) { 
	var $clicked = $(e.target); 
	
	if (! $clicked.hasClass("search")){
	jQuery("#divResult").fadeOut();
        jQuery("#divResultMobile").fadeOut();
	}
});
$('#inputSearch').click(function(){
jQuery("#divResult").fadeIn();
jQuery("#divResultMobile").fadeIn();
});
});
</script>
<link href="css/style4.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="js/jquery.min.js"> </script>
<script type="text/javascript" src="js/script.js"></script>

</head>

<body>
<div class="container">
<?php include("header.php"); 
include("sidebar.php");
?>
 <div class="content1" style="height:1280px; margin-left:20px">
    <h1>Photo<br>
 Content goes here...</h1>
 
 
 <div id="fb-album" style="height:200px">
 <a href="#" class="topopup"><img style="margin-left:10px;cursor:pointer;margin-bottom: 50px;" src="images/uploadAlbum.png"></a>

<!--
 
  <div id="fb-album-content">
  <div id="fb-albums-all" style="display:block;">
 
-->
 
 
<?php 
	$da= "Select * from user_album where album_user_id=".$_SESSION['id']."";
	$result = mysqli_query($con, $da) or die(mysqli_error($con));
	while ($row = mysqli_fetch_array($result) )
	{ 
	  echo '<a href="photo_cmnts.php?album_id='.$row["album_id"].'" style=";clear:both;">';
	  echo '<div class="albumWrapper" style=";clear:both">';
	  echo '<div class="albumThumb fbLink" style="width:161px;height:120px" title="'.$row['album_name'].'">';
	  $ia = "Select * from upload_data where album_id=".$row["album_id"]." and user_code=".$_SESSION['id']." order by date_created ";
	  $result1 = mysqli_query($con, $ia) or die(mysqli_error($con));
	  $count = mysqli_num_rows($result1);
	  while($row1 = mysqli_fetch_array($result1))
	  $dir = $row1['FILE_NAME'];
	  echo '<span class="albumThumbWrap">';
	  echo '<i style="width: 161px; height: 120px; background-image: url(user_data/'.$dir.'); background-size:161px 120px; "  ></i>';
	  echo '</span>';
	  echo '</div>';
	  echo '<div class="albumDetails" style="width:161px;">';
	  echo '<div class="albumText">';
	  echo '<div class="fbLink" href="">';
	  echo '<strong>'.$row['album_name'].'</strong>';
	  echo '</div>';
	  echo '<div class="albumCount">';
	  echo ''.$count.' Photos';
	  echo '</div>';
	  echo '</div>';
	  echo '</div>';
	  
	  echo '</div>';
	  echo '</a>';
	}
?>

 
 <!--
 </div>
  </div>
 
-->
 </div>
    <div id="toPopup"> 
    	
        <div class="close"></div>
       	<span class="ecs_tooltip">Press Esc to Cancel <span class="arrow"></span></span>
		<div id="popup_content"> <!--your content start-->
            <p>

            <form action="demo.php" method="POST" enctype="multipart/form-data">

            <p>
	          &nbsp;Enter Album Name    
            </p>
            <p><input type="text" id="album" name="album" class="validate" placeholder="Type Your Album Name here.." required>
            <span class="error" style="display:none;color:#6f0000;">* Enter Album Name</span></p>
			<input class="sumbitform" type="file" name="files[]" multiple/>
			<input type="submit" value="Upload" class=""/>
            </form></p>
           
            
            
        </div> <!--your content end-->
    
    </div> <!--toPopup end-->
    
	<div class="loader"></div>
   	<div id="backgroundPopup"></div>
     
    
    <!-- end .content -->
  </div>
<!-- end .container --></div>

<body>
</body>
</html>