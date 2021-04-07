<?php ob_start();
	session_start();
	require_once('config.php');
	require_once('includes/time_stamp.php');
	$session_member_id = $_SESSION['SESS_MEMBER_ID'];
	if(!isset($_SESSION['SESS_MEMBER_ID']))
	{
		header("location: ".$base_url."index.php");
		exit();
	}
	
	$group_id = $_REQUEST['group_id'];
	
	$sql = mysqli_query($con, "select ga.album_name, ga.album_id, g.name FROM 
						groups_album ga INNER JOIN groups g ON g.id = ga.album_group_id 
						WHERE ga.album_group_id='".$group_id."'") or die(mysqli_error($con));
						
	$res = mysqli_fetch_array($sql);
	
	$mquery = "SELECT username, profImage, member_id FROM members WHERE member_id = '$session_member_id'";
	$msql = mysqli_query($con, $mquery);
	$mres = mysqli_fetch_array($msql);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<title><?php echo $res['album_name'];?></title>
<head>
<link rel="stylesheet" type="text/css" href="css/style_albums.css"/>
<link rel="stylesheet" type="text/css" href="css/share_box.css"/>
<link rel="stylesheet" type="text/css" href="css/wall.css"/>
<link href="css/style5forimageGallery.css" rel="stylesheet" type="text/css" media="all" />
<link rel="icon" href="images/favicon.ico" type="image" />
<link rel="shortcut icon" href="images/favicon.ico" type="image" />

<link rel="stylesheet" type="text/css" href="css/format.css"/>
<link rel="stylesheet" type="text/css" href="css/search.css"/>
<link rel="stylesheet" type="text/css" href="css/dropdown.css"/>
<link rel="stylesheet" href="<?php echo $base_url;?>assets/chosen-jquery/chosen.css">
<link rel="stylesheet"  type="text/css" href="<?php echo $base_url;?>css/token-input.css"/>
<link rel="stylesheet"  type="text/css" href="<?php echo $base_url;?>css/token-input-facebook.css"/>
<link rel="stylesheet"  type="text/css" href="<?php echo $base_url;?>css/token-input-mac.css"/>
<script src="js/ibox.js"></script>
<script src="js/jquery.livequery.js" type="text/javascript"></script>
<script src="js/jquery.oembed.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script src="js/groups.js"></script>

<script type="text/javascript" src="js/jquery.livequery.js"></script>
<script type="text/javascript" src="js/autocomplete.js"></script>

<!-- drag -->
<link rel="stylesheet" href="css/jquery-ui.css" />
<link rel="stylesheet" href="/resources/demos/style.css" />
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui.js"></script>

<script type="text/javascript" src="<?php echo $base_url;?>js/jquery.tokeninput.js"></script>
<style>
.ui-widget-content { width:50px; height: 50px; padding: 0.5em;z-index:11000; border:#0000FF ridge 2px;;}

.ui-widget-content1 { width:50px; height: 50px;z-index:11000; display:none; position:absolute;}

.tagged { width:50px; height: 50px;z-index:12000; position:absolute;}
.commentMark{width:200px;}
 
 
 .albums { width:500px; height: 300px; padding: 0.5em;z-index:11000; text-align:center; alignment-adjust:}
.photo {z-index:12000; display:none;}

 
 
  </style>
 
 <script type="text/javascript">

$(function() {
    $( ".ui-widget-content" ).draggable();
  });


$(function() {
 $(".tag_text").autocomplete({
	 source: "load_data/member_names_ajax.php",			
			select: true
 });
});

function show_photo_tag()
{  
	$( ".ui-widget-content1" ).show();
}

function hide_photo_tag()
{  
	$( ".ui-widget-content1" ).hide();
}

$(function() {
	$( document ).tooltip();

});
</script>
<script type="text/javascript">
$(document).ready(function() 
{
$('.btn_tag_submit').click(function() {
	var s ='#tag_text'+$(this).attr("id");
	var txt=$(s).val();
	
	var div = '#draggable'+$(this).attr("id");
	var div_top=$(div).css("top");
	var div_left=$(div).css("left");
	var photo_id= $(this).attr("id");
	
	var dataString = "tag_text=" + txt+"&div_top="+div_top+"&div_left="+div_left+"&photo_id="+photo_id;

		URL = "load_data/group_photo_tag.php";
		$.ajax({
			type: "POST",
			url: URL,
			data: dataString,
			cache: false,
			success: function(html)	{
				$( ".ui-widget-content1" ).hide();
				location.reload();
			}
		})
	});
});
</script>

<script type="text/javascript">

function showHide() 
{			
   if(document.getElementById("privacy").selectedIndex == 1) 
   {
        document.getElementById("mvm").style.display = ""; // This line makes the DIV visible
		document.getElementById("mvm1").style.display = "none";
	   document.getElementById("mvm2").style.display = "none";
   }
   else
   {
	   document.getElementById("mvm").style.display = "none";	   
   } 
   if(document.getElementById("privacy").selectedIndex == 2)
   {            
        document.getElementById("mvm1").style.display = "";
		document.getElementById("mvm").style.display = "none"; 
		document.getElementById("mvm2").style.display = "none"; 
   }
   else
   {
	   document.getElementById("mvm1").style.display = "none";	   
   }
   if(document.getElementById("privacy").selectedIndex == 3)
   {            
        document.getElementById("mvm2").style.display = "";
		document.getElementById("mvm1").style.display = "none"; 
		document.getElementById("mvm").style.display = "none"; 
   }
   else
   {
	   document.getElementById("mvm2").style.display = "none";
	   	   
   }
   
}



</script>

 <script type="text/javascript">
$(document).ready(function(){
    $(".cancel_custom").click(function() {
	$("#popup").hide();
	});
	
	 $(".cancel_share").click(function() {
	$("#share_popup").hide();
	$(".share_body").children('div').remove();
	});
});

</script>

<style>
#share_popup{
	width: 100%;
	height: 100%;
	position: fixed;
	top: 0;	
	background-color: rgba(0,0,0,0.7); /*(255,255,255,0.5);*/
	color:#fff;
}	

</style>

</head>
<body style=" background-color:#000">

<div id="mainbody" style="margin-top:100px; border:solid 3px;">


	<div class="" style="width:">    

   <?php 
            function _make_url_clickable_cb($matches) {
	$ret = '';
	$url = $matches[2];
 
	if ( empty($url) )
		return $matches[0];
	// removed trailing [.,;:] from URL
	if ( in_array(substr($url, -1), array('.', ',', ';', ':')) === true ) {
		$ret = substr($url, -1);
		$url = substr($url, 0, strlen($url)-1);
	}
	return $matches[1] . "<a href=\"$url\" rel=\"nofollow\">$url</a>" . $ret;
}

function _make_web_ftp_clickable_cb($matches) {
	$ret = '';
	$dest = $matches[2];
	$dest = 'http://' . $dest;
 
	if ( empty($dest) )
		return $matches[0];
	// removed trailing [,;:] from URL
	if ( in_array(substr($dest, -1), array('.', ',', ';', ':')) === true ) {
		$ret = substr($dest, -1);
		$dest = substr($dest, 0, strlen($dest)-1);
	}
	return $matches[1] . "<a href=\"$dest\" rel=\"nofollow\" target=\"_blank\">$dest</a>" . $ret;
}
 
function _make_email_clickable_cb($matches) {
	$email = $matches[2] . '@' . $matches[3];
	return $matches[1] . "<a href=\"mailto:$email\">$email</a>";
}
    function clickable_link($text = '')
	{
			$text = preg_replace_callback('#(script|about|applet|activex|chrome):#is',function($matches) {
        return $matches[1];
			}, $text);
			$ret = ' ' . $text;
			$ret = preg_replace_callback("#(^|[\n ])([\w]+?://[\w\#$%&~/.\-;:=,?@\[\]+]*)#is",'_make_url_clickable_cb', $ret);
			
			$ret = preg_replace_callback("#(^|[\n ])((www|ftp)\.[\w\#$%&~/.\-;:=,?@\[\]+]*)#is",'_make_web_ftp_clickable_cb', $ret);
			$ret = preg_replace_callback("#(^|[\n ])([a-z0-9&\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)#i",'_make_email_clickable_cb', $ret);
			$ret = substr($ret, 1);
			return $ret;
	}
	
	
	$gaquery = "SELECT gp.photo_id, g.name, gp.FILE_NAME, m.member_id, gp.caption, gp.description, gp.group_id,
			m.username, m.profImage, gp.date_created, m.member_id, gp.msg_id 
			FROM groups_photo gp INNER JOIN groups g ON gp.group_id = g.id			
			LEFT JOIN members m on gp.member_id = m.member_id 
			WHERE gp.album_id=".$_REQUEST['album_id']."						 
			ORDER by gp.photo_id ASC";
	
	
	$gasql = mysqli_query($con, $gaquery) or die(mysqli_error($con));
	$totalnumofrec=mysqli_num_rows($gasql);
	$countrecord=1;
	$int_show_count=1;
	while ( $row = mysqli_fetch_array( $gasql ) )
	{
		$row['photo_id'];
		$msg_id = $row['msg_id'];
		  $total_comments = mysqli_query($con, "SELECT count(*) FROM photo_comments where  c_item_id = ".$row['photo_id']." order by c_when asc");
		  $records = mysqli_fetch_array($total_comments);
		  $records = $records[0];
		  
	    $comments = mysqli_query($con, "SELECT *,
		UNIX_TIMESTAMP() - c_when AS CommentTimeSpent FROM photo_comments, members where members.member_id=photo_comments.c_user_id and c_item_id = ".$row['photo_id']." order by c_when asc limit 0,4") or die(mysqli_error($con));		
		$comment_num_row = mysqli_num_rows(@$comments);
		
	  
	  if( $_REQUEST['image_id']== $row['photo_id'] )
	  	{
		echo '<div id="div_photo_'.$row['photo_id'].'" style="display:block; z-index:12000;" >';
		}
	  else
	  	{
		echo '<div id="div_photo_'.$row['photo_id'].'" class="photo">';	
		}
		
	  $int_show_count=0;
	  
		$url = $_REQUEST['back_page'];

	  ?>
	   			      	
        <a href=<?php echo $url;?>><div class="close"></div></a>
        
       	<span class="ecs_tooltip">Press Esc to close<a href="logged_in.php"> <span class="arrow"></span></a></span>
		<div id="popup_content"> <!--your content start-->
          
		<div id="div_left_panel" class="leftpanel" align="center">
				
				
		<?php 
			
			$tag_sql = "SELECT tag_id, member_in_tag_id, div_top, div_left FROM groups_photo_tag Where photo_id='".$row['photo_id']."'"; 
			$tag_data = mysqli_query($con, $tag_sql);
		
			while( $info=mysqli_fetch_array($tag_data)){
			echo "<div class='tagged'  id='tagged".$info['tag_id']."' style='top:".$info['div_top']."px;left:".$info['div_left']."px;' title='".$info['member_in_tag_id']."' >
		 	</div>";
			
			}
			
			echo "<div class='ui-widget-content1'>
		 	<div id='draggable".$row['photo_id']."' class='ui-widget-content'>
		 
		 	<input type='button' value='Ok' class='btn_tag_submit' id='".$row['photo_id']."'>
		 	<input type='button' value='X' name='btn_tag_box_close' onclick='hide_photo_tag()'>
			<br>		 
			<center>
			<input type='text' id='tag_text".$row['photo_id'] ."' class='tag_text' name='tag_text' size='3px' />
			</center>
</div> </div>";

				list($width, $height) = getimagesize($row['FILE_NAME']); 
				
				if($width>600 || $height>550)
				{
				echo '<img height="100%" width="100%" align="middle" src="'.$row['FILE_NAME'].'" id="'.$row['photo_id'].'" value="'.$_REQUEST['album_id'].'" />'; 	
				
				}
				else
				{
				
				$height1=(550-$height)/2;
				echo '<div style="margin-top:'.$height1.'px">';
				echo '<img align="middle" src="'.$row['FILE_NAME'].'" id="'.$row['photo_id'].'" value="'.$_REQUEST['album_id'].'" />';
				echo '</div>';
				} 
				
				$previousvalu= mysqli_query($con, "SELECT `photo_id` FROM groups_photo 
											WHERE album_id=".$_REQUEST['album_id']." and `photo_id` < 	'".$row['photo_id']."' 
											AND share !=1 ORDER BY `photo_id` DESC LIMIT 1");
				
				while ($getpreval = mysqli_fetch_array($previousvalu) )
				{
					$prevval = $getpreval['photo_id'];
				}
				
				$nextvalu= mysqli_query($con, "SELECT `photo_id` FROM groups_photo 
									WHERE album_id=".$_REQUEST['album_id']." 
									AND `photo_id` >'".$row['photo_id']."' 
									AND share !=1 ORDER BY `photo_id` ASC LIMIT 1");
									
				while ($getnextval = mysqli_fetch_array($nextvalu) )
				{
					echo $nextval = $getnextval['photo_id'];					
				}
				
				if($countrecord!=1)
				{
				?>				
				
				<a href="group_photo_view.php?back_page=<?php echo $_REQUEST['back_page']; ?>&group_id=<?php echo $group_id; ?>&album_id=<?php echo $_REQUEST['album_id']; ?>&image_id=<?php echo $prevval;?>" >
				
				<div class="leftnav"></div></a>
				<?php 
				} 
				
				if($countrecord != $totalnumofrec)
				{
				?>
				
				<a href="group_photo_view.php?back_page=<?php echo $_REQUEST['back_page']; ?>&group_id=<?php echo $group_id; ?>&album_id=<?php echo $_REQUEST['album_id']; ?>&image_id=<?php echo $nextval;?>">				
				
				<div class="rightnav"></div>
				<?php } ?>
				</div>
				</a>
                
				<!--here right panel--> 
                <div class="rightpanel">
				<div class="rightTop">
				<div class="image" style="height:60px">
				
				<img src="<?php echo $row['profImage']; ?>" width="60" height="60" class="CommentImg" style="float:left;" alt="" />
				<p><span style="margin-left:10px;">
				<b><?php echo $row['username']; ?></b></p></span>
				<p>
				<span style="margin-left:10px;">
				  <?php echo time_stamp($row['date_created']);?>
				</span></p>
				</div>
                
				<!--<div class="caption" >
				<?php
				if(!$row['caption'])
				{
					if($_SESSION['SESS_MEMBER_ID'] == $_REQUEST['member_id'])
	  				{
		  				echo '<p class="captions" id="'.$row['upload_data_id'].'"><b>Add Caption</b></p>';		  				
		  			}
		  		}
		  		else
		  		{
		  			echo $row['caption'];
		  		}
				 ?>
				</div>
				<div class="description" >
				<?php
				if(!$row['description'])
				{
					if($_SESSION['SESS_MEMBER_ID'] == $_REQUEST['member_id'])
					{
						echo '<p class="descriptions" id="'.$row['upload_data_id'].'"><b>Add Description</b></p>';
					}
				}
				else
				{
					echo $row['description'];
				}
				 ?>
				</div>-->
  

</div><!--end div righttop-->
				<div class="rightbottom">
                
                <div class="emot_comm">
    
<span id="show-cmt1">
 <?php
 
 $q = mysqli_query($con, "SELECT * FROM groups_wall_like WHERE member_id='". $_SESSION['SESS_MEMBER_ID'] ."' and remarks='".$msg_id."' ") or die(mysqli_error($con));
 
if(mysqli_num_rows($q) > 0)
{
	echo '<a href="javascript:void(0)" class="like" id="like'.$msg_id.'" title="Unlike" rel="Unlike">Unlike</a>';
} 
else 
{ 
	echo '<a href="javascript:void(0)" class="like" id="like'.$msg_id.'" title="Like" rel="Like">Like</a>';
} 
	
?>
</span>

<span  id="show-cmt1" class="show-cmt">
<a href="javascript: void(0)" id="<?php echo $msg_id;?>" class="commentopen">Comment</a>    
</span>

<span id="show-cmt1" class="show-cmt">
<a href="javascript: void(0)" rowtype="<?php echo $row['type'];?>" class="share_open" id="<?php echo $msg_id;?>">Share</a>
</span>

<span id="show-cmt1" class="show-cmt">
<a href="" id="<?php echo $msg_id;?>" class="flagopen">Flag this Status</a>
</span>

<?php 
if($session_member_id == $row['member_id'])
{
?>
<span id="show-cmt1" class="show-cmt">
<a href='javascript:show_photo_tag()' id='photo_tag'>Photo tag</a>
</span>
<?php } ?>

</div> <br />

<div class="commentPanel">

<?php	
			
$like_count = mysqli_num_rows($q);

if($like_count > 0) 
{ 
$query=mysqli_query($con, "SELECT m.username,m.member_id FROM groups_wall_like b LEFT JOIN members m ON m.member_id = b.member_id 
WHERE b.remarks='".$msg_id."' LIMIT 3");
$like = mysqli_num_rows($query);
?>
<div class='likeUsers' id="likes<?php echo $msg_id; ?>">
<?php
$new_like_count = $like_count-3; 
while($row12=mysqli_fetch_array($query))
{
$like_uid=$row12['member_id']; 
$likeusername=$row12['username']; 
if($like_uid == $session_member_id)
{
echo '<span id="you'.$msg_id.'"><a href="'.$likeusername.'">You, </a></span>';
}
else
{ 
echo '<a href="'.$likeusername.'">'.$likeusername.',</a>';
}  
}
if($new_like_count > 0)
echo 'and '.$like.' other friends';
echo 'Like this';
?> 
</div>
<?php }
else { 
echo '<div class="likeUsers" id="elikes'.$msg_id.'"></div>';
} 
?>
</div>
				
				<div class="friends_area" id="record-<?php echo $msg_id;?>">
				
				<br clear="all" />
				<div id="commentload<?php echo $msg_id;?>">
				<?php
				$cquery = "SELECT c.comment_id, c.content, m.username, m.profImage, c.date_created,
							c.post_member_id,m.member_id, c.type 
		  					FROM groups_wall_comment c LEFT JOIN members m ON m.member_id = c.post_member_id 
							WHERE msg_id = '$msg_id'";
		 		$csql = mysqli_query($con, $cquery) or die(mysqli_error($con));
								
				while ($cres = mysqli_fetch_array($csql))
				{
					$comment_time = $cres['date_created'];
						
				?>
				<div class="commentPanel" id="record-<?php  echo $cres['comment_id'];?>" align="left">
                <?php 
if($_SESSION['SESS_MEMBER_ID'] == $cres['member_id'])
{
?>
<a class="stcommentdelete" href="#" id='<?php echo $row1['comment_id']; ?>' title='Delete Comment'>X</a>
<?php } ?>
                <div class="photocommentimg">
                <a href="member_profile.php?member_id=<?php echo $cres['member_id'];?>">
				<img src="<?php echo $cres['profImage'];?>" height="30" width="30" class="small_face" alt="" />
                </a>
                </div>
                <div class="photocommenttext">
                <a href="member_profile.php?member_id=<?php echo $cres['member_id'];?>"><b><?php echo $cres['username']; ?></b> </a>
				<?php 
				if($cres['type']==1) echo $cres['content'];
				if($cres['type']==2) echo '<img src="'.$cres["content"].'" >';
				?>
                <div class="stcommenttime"><?php echo time_stamp($comment_time); ?>
				<span style="padding-left:5px;">
			<?php
		   
		   $clquery = "SELECT * FROM groups_wall_comment_like WHERE comment_id='". $cres['comment_id'] ."' ";
		   $clsql = mysqli_query($con, $clquery);

if(mysqli_num_rows($clsql) > 0)
{
	echo '<a class="comment_like" id="comment_like'.$cres['comment_id'].'" title="Unlike" rel="Unlike" href="javascript:void(0)">Unlike</a>';
} 
else 
{ 
	echo '<a class="comment_like" id="comment_like'.$cres['comment_id'].'" title="Like" rel="Like" href="javascript:void(0)">Like</a>';
} 
			
$like_count1 = mysqli_num_rows($clsql);

if($like_count1 > 0) 
{ 
$query1=mysqli_query($con, "SELECT m.username,m.member_id FROM groups_wall_comment_like c, members m WHERE m.member_id=c.member_id 
AND c.comment_id='".$cres['comment_id']."' LIMIT 3");
$like1 = mysqli_num_rows($query1);
?>
<div class='likeUsers' id="likes<?php echo $cres['comment_id'] ?>">
<?php
$new_like_count1 = $like_count1-3; 
while($row121=mysqli_fetch_array($query1))
{
$like_uid1=$row121['member_id']; 
$likeusername1=$row121['username']; 
if($like_uid1=$member_id)
{ 
	echo '<span id="you1'.$cres['comment_id'].'">
	<a style="font-size: 11px; margin: 3px 3px 3px 6px; text-decoration: none;" href="'.$likeusername1.'">You'; 
	if($like_count1>1)
	echo ' ,'; 
	echo '</a></span>';
}
else
{ 
	echo '<a style="font-size: 11px; margin: 3px 3px 3px 6px; text-decoration: none;" href="'.$likeusername1.'">'.$likeusername1.',</a>';
}  
}
if($new_like_count1 > 0)
	echo 'and '.$like1.' other friends';
echo 'Like this';
?> 
</div>
<?php 
}
else 
{ 
	echo '<div class="likeUsers" id="elikes1'.$cres['comment_id'].'"></div>';
} 
?>
</span>
</div>
	<?php
	$userip = $_SERVER['REMOTE_ADDR'];
	if($cres['post_member_id'] == $session_member_id){?>
    
	<!--<div>
	<div id="normal-button" class="settings-button" title="0" value="<?php echo $rows['c_id']; ?>" >
	<span title="Edit & Delete" style="bottom: 2px;float: right;position: relative;width: 33px;cursor: pointer;">
	<img src="images/edit_icon.png"/></span></div>
	<div class="submenu12" id="<?php echo $rows['c_id']; ?>-submenu12" style="display: none;float: right; position: relative; background:#000000">
	<a href="javascript:void(0)" class="edit_link" id="<?php  echo $rows['c_id'];?>" title="Edit">Edit</a><br>
	<a href="javascript:void(0)" id="CID-<?php  echo $rows['c_id'];?>" class="c_delete">Delete</a></div>
	</div>-->
						
	<?php
	}
	?>
    </div>
 </div>
	<?php 
	
}?>
</div><!--CommentPosted -->

<div class="photocommentupdate" style='display:none' id='commentbox<?php echo $msg_id;?>'>
<div class="photocommentimg">
<img src="<?php echo $mres['profImage'];?>" class='small_face'/>
</div>

<div class="photocommenttext" >
<form method="post" action="">
<textarea name="comment" class="photoscomment" maxlength="200"  id="ctextarea<?php echo $msg_id;?>"></textarea>
<br />
<input type="submit"  value=" Comment "  id="<?php echo $msg_id;?>" class="button"/>
<input type="button"  value=" Cancel "  id="<?php echo $msg_id;?>" onclick="cancelclose('commentbox<?php echo $msg_id;?>')" class="cancel"/>

</form>
</div>
</div><!--End commentupdate div	--> 

<div class="photocommentupdate" style='display:none' id='reportbox<?php echo $msg_id;?>'>
<div class="photocommentimg">
<img src="<?php echo $mres['profImage'];?>" class='small_face'/>
</div>

<div class="photocommenttext" >
<form method="post" action="">
<textarea name="comment" class="photoscomment" maxlength="200"  id="rptextarea<?php echo $msg_id;?>" placeholder="Flag this status.."></textarea>
<br />
<input type="submit"  value=" Report "  id="<?php echo $msg_id;?>" class="report"/>
<input type="button"  value=" Cancel "  id="<?php echo $msg_id;?>" onclick="canclose('reportbox<?php echo $msg_id;?>')" class="cancel"/>
</form>
</div>
</div><!--End commentupdate div	-->
                
</div> <!--friends_area --> 

</div>
</div>
                
        </div> <!--your content end-->
    </div> 
	<!--toPopup end-->
    
	<div class="loader" id="loader"></div>
   	<div class="backgroundPopup" id="backgroundPopup"></div>
	<?php
	$countrecord++;}
?>

</div>
</div>

</div>

</div>

<?php include_once 'share.php';?>


</div>

</body>
</html>