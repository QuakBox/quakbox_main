<?php 
	session_start();
	require_once('config.php');
	include_once('includes/time_stamp.php');
	if(isset($_SESSION['lang']))
	{	
		include('common.php');
	}
	else
	{
		include('Languages/en.php');
		
	}
	if(!isset($_SESSION['SESS_MEMBER_ID']))
	{
		header("location: ".$base_url."login.php?back=". urlencode($_SERVER['REQUEST_URI']));
		exit();
	}
	
	$country_id = $_REQUEST['country_id'];
	
	$sql = mysqli_query($con, "select ga.album_name, ga.album_id, c.country_title FROM 
						country_album ga INNER JOIN geo_country c ON c.country_id = ga.country_id 
						WHERE ga.country_id='".$country_id."'") or die(mysqli_error($con));
						
	$res = mysqli_fetch_array($sql);
	$country_title = $res['country_title'];
	$album_name = $res['album_name'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Photo album</title>
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
<script src="js/wall.js"></script>

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

		URL = "load_data/insert_tag_ajax.php";
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
	    document.getElementById("mvm1").style.display = "block"; // This line makes the DIV visible
		document.getElementById("mvm").style.display = "none";
	   	document.getElementById("mvm2").style.display = "none";
   }
   else
   {
	   document.getElementById("mvm1").style.display = "none";	   
   } 
   if(document.getElementById("privacy").selectedIndex == 2)
   {            
        document.getElementById("mvm2").style.display = "block";
		document.getElementById("mvm").style.display = "none"; 
		document.getElementById("mvm1").style.display = "none"; 
   }
   else
   {
	   document.getElementById("mvm2").style.display = "none";	   
   }
   
   if(document.getElementById("privacy").selectedIndex == 3)
   {            
        document.getElementById("world").value = "world";
		document.getElementById("mvm2").style.display = "none";
		document.getElementById("mvm").style.display = "none"; 
		document.getElementById("mvm1").style.display = "none";
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


	<div class="">    

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
	
	
	$gaquery = "SELECT gp.upload_data_id, gp.FILE_NAME, m.member_id, gp.caption, gp.description,
				m.username, gp.date_created as TimeSpent, m.profImage,gp.msg_id,gp.USER_CODE
			FROM upload_data gp LEFT JOIN members m on gp.USER_CODE = m.member_id 
			WHERE gp.album_id=".$_REQUEST['album_id']." 
			ORDER by gp.upload_data_id ASC";
	
	
	$gasql = mysqli_query($con, $gaquery) or die(mysqli_error($con));
	$totalnumofrec=mysqli_num_rows($gasql);
	$countrecord=1;
	$int_show_count=1;
	while ( $row = mysqli_fetch_array( $gasql ) )
	{
		$member_id = $row['USER_CODE'];
		$msg_id = $row['msg_id'];
		  $total_comments = mysqli_query($con, "SELECT count(*) FROM country_photo_comments where  c_item_id = ".$row['upload_data_id']." order by c_when asc");
		  $records = mysqli_fetch_array($total_comments);
		  $records = $records[0];
		  
	    $comments = mysqli_query($con, "SELECT *,UNIX_TIMESTAMP() - c_when AS CommentTimeSpent 
					FROM country_photo_comments c left join members m ON m.member_id = c.c_user_id 
					WHERE c_item_id = ".$row['upload_data_id']." order by c_when asc limit 0,4") or die(mysqli_error($con));
				
		$comment_num_row = mysqli_num_rows(@$comments);
		
	  
	  if( $_REQUEST['image_id']== $row['upload_data_id'] )
	  	{
		echo '<div id="div_photo_'.$row['upload_data_id'].'" style="display:block; z-index:12000;" >';
		}
	  else
	  	{
		echo '<div id="div_photo_'.$row['upload_data_id'].'" class="photo">';	
		}
		
	  $int_show_count=0;
	  
		$url = $_REQUEST['back_page'];

	  ?>
	   			      	
        <a href=<?php echo $url;?>><div class="close"></div></a>
        
       	<span class="ecs_tooltip">Press Esc to close<a href="logged_in.php"> <span class="arrow"></span></a></span>
		<div id="popup_content"> <!--your content start-->
          
		<div id="div_left_panel" class="leftpanel" align="center">
				
				
		<?php 
			
			$tag_sql = "SELECT tag_id, member_in_tag_id, div_top, div_left FROM tags Where photo_id='".$row['upload_data_id']."'"; 
			$tag_data = mysqli_query($con, $tag_sql) or die(mysqli_error($con));
		
			while( $info=mysqli_fetch_array($tag_data)){
			echo "<div class='tagged'  id='tagged".$info['tag_id']."' style='top:".$info['div_top']."px;left:".$info['div_left']."px;' title='".$info['member_in_tag_id']."' >
		 	</div>";
			
			}
			
			echo "<div class='ui-widget-content1'>
		 	<div id='draggable".$row['upload_data_id']."' class='ui-widget-content'>
		 
		 	<input type='button' value='Ok' class='btn_tag_submit' id='".$row['upload_data_id']."'>
		 	<input type='button' value='X' name='btn_tag_box_close' onclick='hide_photo_tag()'>
			<br>		 
			<center>
			<input type='text' id='tag_text".$row['upload_data_id'] ."' class='tag_text' name='tag_text' size='3px' />
			</center>
</div> </div>";

				list($width, $height) = getimagesize($row['FILE_NAME'].""); 
				
				if($width>600 || $height>550)
				{
				echo '<img height="100%" width="100%" align="middle" src="'.$row['FILE_NAME'].'" id="'.$row['upload_data_id'].'" value="'.$_REQUEST['album_id'].'" />'; 	
				
				}
				else
				{
				
				$height1=(550-$height)/2;
				echo '<div style="margin-top:'.$height1.'px">';
				echo '<img align="middle" src="'.$row['FILE_NAME'].'" id="'.$row['upload_data_id'].'" value="'.$_REQUEST['album_id'].'" />';
				echo '</div>';
				} 
				
				$previousvalu= mysqli_query($con, "SELECT `upload_data_id` FROM upload_data 
											WHERE album_id=".$_REQUEST['album_id']." and `upload_data_id` < 	'".$row['upload_data_id']."' 
											ORDER BY `upload_data_id` DESC LIMIT 1");
				
				while ($getpreval = mysqli_fetch_array($previousvalu) )
				{
					$prevval = $getpreval['upload_data_id'];
				}
				
				$nextvalu= mysqli_query($con, "SELECT `upload_data_id` FROM upload_data 
									WHERE album_id=".$_REQUEST['album_id']." 
									AND `upload_data_id` >'".$row['upload_data_id']."' 
									ORDER BY `upload_data_id` ASC LIMIT 1");
									
				while ($getnextval = mysqli_fetch_array($nextvalu) )
				{
					echo $nextval = $getnextval['upload_data_id'];					
				}
				
				if($countrecord!=1)
				{
				?>				
				
				<a href="country_photo_view.php?back_page=<?php echo $_REQUEST['back_page']; ?>&country_id=<?php echo $country_id; ?>&album_id=<?php echo $_REQUEST['album_id']; ?>&image_id=<?php echo $prevval;?>" >
				
				<div class="leftnav"></div></a>
				<?php 
				} 
				
				if($countrecord != $totalnumofrec)
				{
				?>
				
				<a href="country_photo_view.php?back_page=<?php echo $_REQUEST['back_page']; ?>&country_id=<?php echo $country_id; ?>&album_id=<?php echo $_REQUEST['album_id']; ?>&image_id=<?php echo $nextval;?>">			
				
				<div class="rightnav"></div></a>
				<?php } ?>
				</div>
				
                
				<!--here right panel--> 
                
                <div class="rightpanel">
				<div class="rightTop">
				<div class="image" style="height:60px">
				
				<img src="<?php echo $row['profImage']; ?>" width="60" height="60" class="CommentImg" style="float:left;" alt="" />
				<p><span style="margin-left:10px;">
				<b><?php echo $row['username']; ?></b></span></p>
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

<div id="commentstat"></div>
				<div class="rightbottom">
                
                
                <div class="emot_comm">
    
<span class="show-cmt">
 <?php
 $q = mysqli_query($con, "SELECT * FROM bleh WHERE member_id='". $_SESSION['SESS_MEMBER_ID'] ."' and remarks='".$msg_id."' ");
	if(mysqli_num_rows($q) > 0)
	{
		echo '<a href="javascript: void(0)" class="like" id="like'.$msg_id.'" title="'.$lang['Unlike'].'" rel="Unlike">'.$lang['Unlike'].' </a>';
	} 

	else 
	{ 
		echo '<a href="javascript: void(0)" class="like" id="like'.$msg_id.'" title="'.$lang['Like'].'" rel="Like">'.$lang['Like'].'</a>';
	}
	
?>
</span>

<span class="show-cmt">
 <?php
 
 //$pdislikequery = "SELECT dislike_id FROM post_dislike WHERE member_id='". $_SESSION['SESS_MEMBER_ID'] ."' and remarks='".$msg_id."' ";
 $pdislikequery = "SELECT dislike_id FROM post_dislike WHERE member_id='$member_id'";
 $pdislikesql = mysqli_query($con, $pdislikequery);
 
 
	if(mysqli_num_rows($pdislikesql) > 0)
	{
		echo '<a href="javascript: void(0)" class="post_dislike" id="post_dislike'.$msg_id.'" title="'.$lang['Unlike'].'" rel="disLike">'.$lang['DisLike'].'</a>';
	} 

	else 
	{ 
		echo '<a href="javascript: void(0)" class="post_dislike" id="post_dislike'.$msg_id.'" title="'.$lang['Like'].'" rel="disLike">'.$lang['DisLike'].'</a>';
	}
	
	
?>
</span>




<span  class="show-cmt">
<a href="javascript:void(0)" id="<?php echo $msg_id;?>" class="commentopen"><?php echo $lang['Comment'];?></a>

<!--<a href="javascript: void(0)" id="<?php echo $msg_id;?>" class="commentopen">Comment</a>-->
</span>

<span class="show-cmt">
<a href="javascript:void(0)" rowtype="<?php echo $row['type'];?>" class="share_open" id="<?php echo $msg_id;?>" title="<?php echo $lang['Share'];?>"><?php echo $lang['Share'];?>
<!--<a href="javascript: void(0)" class="share_open" id="<?php echo $msg_id;?>">Share</a>-->

</span>

<span class="show-cmt">

<a href="javascript:void(0)" id="<?php echo $msg_id;?>" class="flagopen"><?php echo $lang['Flag this Status'];?></a>

<!--<a href="" id="<?php echo $msg_id;?>" class="flagopen">Flag this Status</a>-->
</span>

<?php 
if($session_member_id == $row['USER_CODE'])
{
?>
<span class="show-cmt">
<a href='javascript:show_photo_tag()' id='photo_tag'>Photo tag</a>
</span>
<?php } ?>

</div> <br />

<!-- LIke users display panel -->
<?php 

$post_like_sql = mysqli_query($con, "SELECT * FROM bleh WHERE remarks='". $msg_id ."'");
$post_like_count = mysqli_num_rows($post_like_sql);

$post_like_sql1 = mysqli_query($con, "SELECT m.username,m.member_id FROM bleh b, members m WHERE m.member_id=b.member_id AND b.remarks='".$msg_id."' AND b.member_id='".$_SESSION['SESS_MEMBER_ID']."'");
$post_like_count1 = mysqli_num_rows($post_like_sql1);

if($post_like_count1==1)
{
$post_like_sql2 = mysqli_query($con, "SELECT m.username,m.member_id FROM bleh b, members m WHERE m.member_id=b.member_id AND b.remarks='".$msg_id."' AND b.member_id!='".$_SESSION['SESS_MEMBER_ID']."' LIMIT 2");
$plike_count = mysqli_num_rows($post_like_sql2);
$new_plike_count=$post_like_count-2; 
}
else
{
$post_like_sql2 = mysqli_query($con, "SELECT m.username,m.member_id FROM bleh b, members m WHERE m.member_id=b.member_id AND b.remarks='".$msg_id."' LIMIT 3");
$plike_count = mysqli_num_rows($post_like_sql2);
$new_plike_count=$post_like_count-3; 
}
?>
<div class="commentPanel" id="likes<?php echo $msg_id;?>" style="display:<?php if($post_like_count <= 0) { echo 'none'; } else { echo 'block'; }?>">
<?php 

if($post_like_count1==1)
{?><span id="you<?php echo $msg_id;?>"><a href="#"><?php echo $lang['You'];?></a><?php if($post_like_count>1)
echo ','; ?> </span><?php
}
?>

<input type="hidden"  value="<?php echo $post_like_count; ?>" id="commacount<?php echo $msg_id;?>" >
<?php

$i = 0;
while($post_like_res = mysqli_fetch_array($post_like_sql2)) {
$i++; 	  
?>

<a href="#" id="likeuser<?php echo $msg_id;?>"><?php echo $post_like_res['username']; ?></a>
<?php if($i <> $plike_count) { echo ',';}

} 
if($plike_count > 3) {
?>
 <?php echo $lang['and'];?> <span id="plike_count<?php echo $msg_id;?>" class="pnumcount"><?php echo $new_plike_count;?></span> <?php echo $lang['others'];?><?php } ?> <?php echo $lang['like this'];?>.</div> 

<!-- LIke users display panel -->


<!--Dislike users display panel-->
<?php 

$sql1 = mysqli_query($con, "SELECT * FROM post_dislike WHERE msg_id='". $msg_id ."'") or die(mysqli_error($con));
$dislike_count = mysqli_num_rows($sql1);
 
$query1=mysqli_query($con, "SELECT m.username,m.member_id FROM post_dislike b, members m WHERE m.member_id=b.member_id AND b.msg_id='".$msg_id."' LIMIT 3");
$dislike = mysqli_num_rows($query1);
?>

<span class="commentPanel" id="postdislike_container<?php echo $msg_id;?>" style="display:<?php if($dislike_count <= 0) { echo 'none'; } else { echo 'block'; }?>">
<span id="postdislikecount<?php echo $msg_id;?>">
<?php
echo $dislike_count;
?>
</span>
<?php echo $lang['Person Dislike this'];?>
</span>
				
<?php

$query1  = mysqli_query($con, "SELECT * FROM postcomment WHERE msg_id=" . $msg_id . " ORDER BY comment_id DESC");
$records = mysqli_num_rows($query1);
$s = mysqli_query($con, "SELECT * FROM postcomment WHERE msg_id=" . $msg_id . " ORDER BY comment_id DESC limit 4,$records");
$y = mysqli_num_rows($s);
if ($records > 4)
{
	$collapsed = true;?>
    <input type="hidden" value="<?php echo $records?>" id="totals-<?php  echo $msg_id;?>" />
	<div class="commentPanel" id="collapsed-<?php  echo $msg_id;?>" align="left">
	<img src="images/cicon.png" style="float:left;" alt="" />
	<a href="javascript: void(0)" class="ViewComments" id="<?php echo $msg_id;?>">
	<?php echo $lang['View'];?> <?php echo $y;?> <?php echo $lang['more comments'];?> 
	</a>
	<span id="loader-<?php  echo $msg_id?>">&nbsp;</span>
	</div>
<?php
}
?>

<div class="commentcontainer" id="commentload<?php echo $msg_id;?>">
<?php
$comment  = mysqli_query($con, "SELECT * FROM postcomment p,members m  WHERE p.post_member_id=m.member_id and p.msg_id=" . $msg_id . " ORDER BY comment_id DESC limit 0,4");
while($row1 = mysqli_fetch_assoc($comment))
{
?>
<div class="stcommentbody" id="stcommentbody<?php echo $row1['comment_id']; ?>">
<div class="stcommentimg">
<a href="<?php echo $base_url.$row['username'];?>"><img src="<?php echo $row1['profImage']; ?>" class='small_face'/></a>
</div> 
<div class="stcommenttext">
<?php 
if($_SESSION['SESS_MEMBER_ID'] == $row1['member_id'])
{
?>
<a class="stcommentdelete" href="#" id='<?php echo $row1['comment_id']; ?>' title='<?php echo $lang['Delete Comment'];?> '></a>
<?php } ?>
<a href="<?php echo $base_url.$row1['username'];?>"><b><?php echo $row1['username']; ?></b> </a>
<?php 
if($row1['type']==1){ echo $row1['content']; 
	?>
	
	<div id="translatemenu<?php echo $row1['comment_id'];?>" class="translatemenu" style="display:none; position:absolute;margin-left: 34%; "> <select id="langs<?php echo $row1['comment_id'];?>" class="langs" onchange="selectOption(this.value, <?php echo $row1['comment_id'];?>,1)">
            <option value=""><?php echo $lang['select language'];?></option> 
            </select></div> 
            
	<textarea class="source" id="source<?php echo $row1['comment_id']; ?>"  style="display:none;"><?php echo $row1['content']; ?></textarea>
	<?php
}
if($row1['type']==2) echo '<img src="'.$row1["content"].'" >';
?>
<div class="target" style="font:bold;" id="target<?php echo $row1['comment_id']; ?>"></div>
<div class="stcommenttime"><?php time_stamp($row1['date_created']); ?>
<!--  like button  -->
<span style="padding-left:5px;">
<!--like block-->
<div>
<?php
$sql = mysqli_query($con, "SELECT * FROM comment_like WHERE comment_id='". $row1['comment_id'] ."'");
$comment_like_count = mysqli_num_rows($sql);

$comment_like_query1 = mysqli_query($con, "SELECT m.username,m.member_id FROM comment_like c, members m WHERE m.member_id=c.member_id 
AND c.comment_id='".$row1['comment_id']."' AND c.member_id='".$_SESSION['SESS_MEMBER_ID']."' ");
$comment_like_res1 = mysqli_num_rows($comment_like_query1);
if($comment_like_res1==1)
{
$comment_like_query = mysqli_query($con, "SELECT m.username,m.member_id FROM comment_like c, members m WHERE m.member_id=c.member_id 
AND c.comment_id='".$row1['comment_id']."' AND c.member_id!='".$_SESSION['SESS_MEMBER_ID']."' LIMIT 2");
$clike_count = mysqli_num_rows($comment_like_query);
$new_clike_count=$comment_like_count-2; 
}
else
{
$comment_like_query = mysqli_query($con, "SELECT m.username,m.member_id FROM comment_like c, members m WHERE m.member_id=c.member_id 
AND c.comment_id='".$row1['comment_id']."' LIMIT 3");
$clike_count = mysqli_num_rows($comment_like_query);
$new_clike_count=$comment_like_count-3; 
}

?>
<div class="clike" id="clike<?php echo $row1['comment_id'];?>" style="display:<?php if($comment_like_count <= 0) { echo 'none'; } else { echo 'block'; }?>">
<?php 

if($comment_like_res1==1)
{?><span id="you<?php echo $row1['comment_id'];?>"><a href="#"><?php echo $lang['You'];?> </a><?php if($comment_like_count>1)
echo ','; ?> </span><?php
}

?>
<!-- <input type="hidden" value="<?php if($comment_like_res1==1)echo 1;else echo 0; ?>" id="youcount<?php echo $row1['comment_id'];?>" > -->
<input type="hidden"  value="<?php echo $comment_like_count; ?>" id="commacount<?php echo $row1['comment_id'];?>" >
<?php

$i = 0;
while($comment_like_res = mysqli_fetch_array($comment_like_query)) {
$i++; 	  
?>

<a href="#" id="likeuser<?php echo $row1['comment_id'];?>"><?php echo $comment_like_res['username']; ?></a>
<?php
	//}
if($i <> $clike_count) { echo ',';}
//} 
} 
if($clike_count > 3) {
?>
 <?php echo $lang['and'];?>  <span id="like_count<?php echo $row1['comment_id'];?>" class="numcount"><?php echo $new_clike_count;?></span> <?php echo $lang['others'];?><?php } ?> <?php echo $lang['like this'];?>.</div> 
<!--<span id="commentlikecout_container<?php echo $row1['comment_id'];?>" style="display:<?php if($comment_like_count <= 0) { echo 'none'; } else { echo 'block'; }?>">

<span id="commentlikecount<?php echo $row1['comment_id'];?>">
<?php
echo $comment_like_count;
?>
</span>
Like this
</span>
-->
</div>
<!--end like block-->

<!--dislie block-->
<div>
<?php
$cdquery = "SELECT * FROM comment_dislike WHERE comment_id='". $row1['comment_id'] ."'";
$cdsql  = mysqli_query($con, $cdquery) or die(mysqli_error($con));
$comment_dislike_count = mysqli_num_rows($cdsql);

$cdquery1 = mysqli_query($con, "SELECT m.username,m.member_id FROM comment_dislike c, members m WHERE m.member_id=c.member_id 
AND c.comment_id='".$row1['comment_id']."' LIMIT 3");
?>
<span id="dislikecout_container<?php echo $row1['comment_id'];?>" style="display:<?php if($comment_dislike_count <= 0) { echo 'none'; } else { echo 'block'; }?>">
<span id="dislikecout<?php echo $row1['comment_id'];?>">
<?php
echo $comment_dislike_count;
?>
</span>
<?php echo $lang['Person Dislike this'];?>
</span>
</div>
<!--end dislike block-->
</span>
<span style="top:2px;">
<?php
$comment_like = mysqli_query($con, "select * from comment_like where comment_id = '".$row1['comment_id']."' and member_id = '".$member_id."'");
if(mysqli_num_rows($comment_like) > 0)
{
	echo '<a href="javascript: void(0)" class="comment_like" id="comment_like'.$row1['comment_id'].'" msg_id = '.$msg_id.' title="'.$lang['Unlike'].'" rel="Unlike">'.$lang['Unlike'].'</a>';
} 
else 
{ 
	echo '<a href="javascript: void(0)" class="comment_like" id="comment_like'.$row1['comment_id'].'" msg_id = '.$msg_id.' title="'.$lang['Like'].'" rel="Like">'.$lang['Like'].'</a>';
}
?>
</span>
<!-- End of like button -->
<!-- Dislike button -->
<span style="top:2px; padding-left:5px;">
<?php
$cdquery1 = "SELECT * FROM comment_dislike WHERE comment_id='". $row1['comment_id'] ."' and member_id = '".$member_id."'";
$cdsql1  = mysqli_query($con, $cdquery1) or die(mysqli_error($con));
$comment_dislike_count1 = mysqli_num_rows($cdsql1);
if($comment_dislike_count1 > 0) {
echo '<a href="javascript: void(0)" class="comment_dislike" id="comment_dislike'.$row1['comment_id'].'" title="'.$lang['DisLike'].'" rel="disLike">'.$lang['DisLike'].'</a>';
} else {
echo '<a href="javascript: void(0)" class="comment_dislike" id="comment_dislike'.$row1['comment_id'].'" title="'.$lang['DisLike'].'" rel="disLike">'.$lang['DisLike'].'</a>';
}
?>
</span> 
<!-- End of dislike  button -->
<!-- Reply Button -->
<span style="top:2px; margin-left:5px;">
<a href="" id="<?php echo $row1['comment_id'];?>" class="replyopen"><?php echo $lang['Reply'];?></a>
</span>
<!-- <?php if($row1['type']==1){?><span style="top:2px; left:3px;"><a class="translatebutton" onclick="translateSourceTarget(<?php echo $row1['comment_id'];?>);" href="javascript:void(0)" >Translate </a> </span><?php } ?> -->

<?php if($row1['type']==1)
{ ?>
<span style="top:2px; margin-left:3px;" > <a class="translateButton" href="javascript:void(0);" id="translateButton<?php echo $row1['comment_id'];?>"  ><?php echo  $lang['Translate'];?></a></span>

       
<?php 
} ?>


<!--View more reply-->
<?php
$query12  = mysqli_query($con, "SELECT * FROM comment_reply WHERE comment_id=" . $row1['comment_id'] . " ORDER BY reply_id DESC");
$records1 = mysqli_num_rows($query12);
$p = mysqli_query($con, "SELECT * FROM comment_reply WHERE comment_id=" . $row1['comment_id'] . " ORDER BY reply_id DESC limit 2,$records1");
$q = mysqli_num_rows($p);
if ($records1 > 2)
{
	$collapsed1 = true;?>
    <input type="hidden" value="<?php echo $records1?>" id="replytotals-<?php  echo $row1['comment_id'];?>" />
	<div class="replyPanel" id="replycollapsed-<?php  echo $row1['comment_id'];?>" align="left">
	<img src="images/cicon.png" style="float:left;" alt="" />
	<a href="javascript: void(0)" class="ViewReply">
	<?php  echo $lang['View'];?> <?php echo $q;?> <?php  echo $lang['more replys'];?>
	</a>
	<span id="loader-<?php  echo $row1['comment_id']?>">&nbsp;</span>
	</div>
<?php
}
?>
</div>

</div>
<div class="replycontainer" style="margin-left:40px;" id="replyload<?php echo $row1['comment_id'];?>">

<?php
$reply_sql  = mysqli_query($con, "SELECT * FROM comment_reply c,members m WHERE c.member_id = m.member_id and comment_id=" . $row1['comment_id'] . " ORDER BY reply_id DESC limit 0,2");

while($reply_res = mysqli_fetch_assoc($reply_sql))
{
?>
<div class="streplybody" id="streplybody<?php echo $reply_res['reply_id']; ?>">
<div class="stcommentimg">
<a href="<?php echo $base_url.$row['username'];?>"><img src="<?php echo $reply_res['profImage']; ?>" class='small_face'/></a>
</div>
<div class="streplytext">
 <?php 
if($_SESSION['SESS_MEMBER_ID'] == $reply_res['member_id'])
{
?>
<a class="streplydelete" href="#" id='<?php echo $reply_res['reply_id']; ?>' title='<?php echo $lang['Delete Reply'];?>'></a>
<?php } ?>
<a href="<?php echo $base_url.$reply_res['username'];?>"><b><?php echo $reply_res['username']; ?> 
 
 </b></a>
<?php 
 
 if($row1['member_id'] <> $reply_res['member_id'])
 {
	 echo '@'; 
	?> <a href="<?php echo $base_url.$row1['username'];?>"><b><?php echo $row1['username']; ?> 
 
 </b></a>
	 
<?php
 }
   ?> 
 

<?php 
echo $reply_res['content'];
?>
<div class="streplytime"><?php time_stamp($reply_res['date_created']); ?></div>
<span style="padding-left:5px;">
<!--like block-->
<div>
<?php
$reply_like_query = mysqli_query($con, "SELECT * FROM reply_like WHERE reply_id='". $reply_res['reply_id'] ."'");
$reply_like_count = mysqli_num_rows($reply_like_query);

$reply_like_query1 = mysqli_query($con, "SELECT m.username,m.member_id 
								  FROM reply_like c, members m 
								  WHERE m.member_id = c.member_id 
								  AND c.reply_id = '".$reply_res['reply_id']."' 
								  AND c.member_id = '".$_SESSION['SESS_MEMBER_ID']."' ");
$reply_like_count = mysqli_num_rows($reply_like_query1);
if($reply_like_count == 1)
{
$reply_like_query2 = mysqli_query($con, "SELECT m.username,m.member_id 
								  FROM reply_like c, members m 
								  WHERE m.member_id=c.member_id 
								  AND c.reply_id='".$reply_res['reply_id']."' 
								  AND c.member_id!='".$_SESSION['SESS_MEMBER_ID']."' LIMIT 2");
$rlike_count = mysqli_num_rows($reply_like_query2);
$new_rlike_count = $reply_like_count - 2; 
}
else
{
$reply_like_query2 = mysqli_query($con, "SELECT m.username,m.member_id 
                                 FROM reply_like c, members m 
								 WHERE m.member_id=c.member_id 
								 AND c.reply_id='".$reply_res['reply_id']."' LIMIT 3");
$rlike_count = mysqli_num_rows($reply_like_query2);
$new_rlike_count=$reply_like_count - 3; 
}

?>
<div class="rlike" id="rlike<?php echo $row1['comment_id'];?>" style="display:<?php if($reply_like_count <= 0) { echo 'none'; } else { echo 'block'; }?>">
<?php 

if($reply_like_count == 1)
{?><span id="you<?php echo $row1['comment_id'];?>"><a href="#"><?php echo $lang['You'];?></a><?php if($reply_like_count>1)
echo ','; ?> </span><?php
}

?>

<input type="hidden"  value="<?php echo $reply_like_count; ?>" id="rcommacount<?php echo $reply_res['reply_id'];?>" >
<?php

$i = 0;
while($reply_like_res = mysqli_fetch_array($reply_like_query2)) {
$i++; 	  
?>

<a href="#" id="likeuser<?php echo $reply_res['reply_id'];?>"><?php echo $reply_like_res['username']; ?></a>
<?php
	//}
if($i <> $rlike_count) { echo ',';}
//} 
} 
if($rlike_count > 3) {
?>
<?php echo $lang['and'];?> <span id="rlike_count<?php echo $reply_res['reply_id'];?>" class="rnumcount"><?php echo $new_rlike_count;?></span><?php echo $lang['others'];?><?php } ?> <?php echo $lang['like this'];?>.</div> 

</div>
<!--end like block-->

<!--dislie block-->
<div>
<?php
$rdquery = "SELECT * FROM reply_dislike WHERE reply_id='". $reply_res['reply_id'] ."'";
$rdsql  = mysqli_query($con, $rdquery) or die(mysqli_error($con));
$reply_dislike_count = mysqli_num_rows($rdsql);

$rdquery1 = mysqli_query($con, "SELECT m.username,m.member_id FROM comment_dislike c, members m WHERE m.member_id=c.member_id 
AND c.comment_id='".$reply_res['reply_id']."'");
?>
<span id="rdislikecout_container<?php echo $reply_res['reply_id'];?>" style="display:<?php if($reply_dislike_count <= 0) { echo 'none'; } else { echo 'block'; }?>">
<span id="rdislikecout<?php echo $reply_res['reply_id'];?>">
<?php
echo $reply_dislike_count;
?>
</span>
<?php echo $lang['Person Dislike this'];?>
</span>
</div>
<!--end dislike block-->
</span>
<span style="top:2px;">
<?php
$reply_like = mysqli_query($con, "select like_id from reply_like where reply_id = '".$reply_res['reply_id']."' and member_id = '".$member_id."'");
if(mysqli_num_rows($reply_like) > 0)
{
	echo '<a href="javascript: void(0)" class="reply_like" id="reply_like'.$reply_res['reply_id'].'"  title="'.$lang['Unlike'].'" rel="Unlike">'.$lang['Unlike'].'</a>';
} 
else 
{ 
	echo '<a href="javascript: void(0)" class="reply_like" id="reply_like'.$reply_res['reply_id'].'"  title="'.$lang['like'].'" rel="Like">'.$lang['like'].'</a>';
}
?>
</span>
<!-- End of like button -->
<!-- Dislike button -->
<span style="top:2px; padding-left:5px;">
<?php
$reply_dislike_query = "SELECT dislike_reply_id FROM reply_dislike WHERE reply_id='". $reply_res['reply_id'] ."' and member_id = '".$member_id."'";
$reply_dislike_sql  = mysqli_query($con, $reply_dislike_query) or die(mysqli_error($con));
$reply_dislike_count = mysqli_num_rows($reply_dislike_sql);
if($reply_dislike_count > 0) {
echo '<a href="javascript: void(0)" class="reply_dislike" id="reply_dislike'.$reply_res['reply_id'].'" title="'.$lang['dislike'].'" rel="disLike">'.$lang['dislike'].'</a>';
} else {
echo '<a href="javascript: void(0)" class="reply_dislike" id="reply_dislike'.$reply_res['reply_id'].'" title="'.$lang['dislike'].'" rel="disLike">'.$lang['dislike'].'</a>';
}
?>
</span> 
<!-- End of dislike  button -->
<!-- Reply Button -->
<span style="top:2px; margin-left:5px;">
<a href="" id="<?php echo $reply_res['reply_id'];?>" class="reply-replyopen"><?php echo $lang['Reply']; ?></a>
</span>
<?php if($row1['type']==1)
{ ?>
<span style="top:2px; margin-left:3px;" > <a class="translateButton" href="javascript:void(0);" id="translateButton<?php echo $row1['comment_id'];?>"  ><?php echo $lang['Translate']; ?></a></span>
       
<?php 
} ?>

</div><!--End streplytext div-->
<!--reply@reply-->
<div class="replycontainer" style="margin-left:40px;" id="reply-reply-load<?php echo $reply_res['reply_id'];?>">
<?php
$reply_r_sql  = mysqli_query($con, "SELECT m.username,m.member_id,m.profImage,
						   a.content, a.date_created,a.id
						   FROM reply_reply a 
						   LEFT JOIN members m ON a.member_id = m.member_id 
						   WHERE reply_id=" . $reply_res['reply_id'] . " 
						   ORDER BY id DESC limit 0,2");

while($reply_r_res = mysqli_fetch_assoc($reply_r_sql))
{
?>
<div class="reply-reply-body" id="reply-reply-body<?php echo $reply_r_res['id']; ?>">
<div class="stcommentimg">
<a href="<?php echo $base_url.$reply_r_res['username'];?>"><img src="<?php echo $reply_r_res['profImage']; ?>" class='small_face'/></a>
</div>

<div class="reply-reply-text">
 <?php 
if($_SESSION['SESS_MEMBER_ID'] == $reply_r_res['member_id'])
{
?>
<a class="reply-reply-delete" href="#" id='<?php echo $reply_r_res['reply_id']; ?>' title='<?php echo $lang['Delete Reply']; ?>'></a>
<?php } ?>
<a href="<?php echo $base_url.$reply_r_res['username'];?>"><b><?php echo $reply_r_res['username']; ?> 
 
 </b></a>
<?php 
 
 if($reply_res['member_id'] <> $reply_r_res['member_id'])
 {
	 echo '@'; 
	?> <a href="<?php echo $base_url.$reply_res['username'];?>"><b><?php echo $reply_res['username']; ?> 
 
 </b></a>
	 
<?php
 }
?> 
 

<?php 
echo $reply_r_res['content'];
?>
<div class="streplytime"><?php time_stamp($reply_r_res['date_created']); ?></div>

</div><!--End reply-reply div-->
<!--reply@reply-->

</div><!--End streplybody div-->
<?php } ?>
</div>
<!--Start replyupdate -->
<div class="reply-reply-update" style='display:none' id='reply-reply-update<?php echo $reply_res['reply_id'];?>'>
<div class="streplyimg">
<img src="<?php echo $res['profImage'];?>" class='small_face'/>
</div>

<div class="reply-reply-text" >
<form method="post" action="">
<textarea name="reply" class="reply-reply" maxlength="200"  id="reply-reply<?php echo $reply_res['reply_id'];?>"></textarea>
<br /> 
<input type="submit" abcd="<?php echo $reply_res['member_id']; ?>"  title="<?php echo $reply_res['username']; ?>" value="    @    "  id="<?php echo $reply_res['reply_id'];?>" class="reply-reply"/>
<input type="button"  value=" <?php echo $lang["Cancel"];?>"  onclick="closereplyreply('reply-reply-update<?php echo $reply_res['reply_id'];?>')" class="cancel"/>
</form>
</div>
</div>
<!--End replyupdate div	--> 
</div><!--End streplybody div-->
<?php } ?>

<!--Start replyupdate -->
<div class="replyupdate" style='display:none' id='replybox<?php echo $row1['comment_id'];?>'>
<div class="streplyimg">
<img src="<?php echo $res['profImage'];?>" class='small_face'/>
</div>

<div class="streplytext" >
<form method="post" action="">
<textarea name="reply" class="reply" maxlength="200"  id="rtextarea<?php echo $row1['comment_id'];?>"></textarea>
<br /> 
<input type="submit" abcd="<?php echo $row1['member_id']; ?>"  title="<?php echo $row1['username']; ?>" value="    @    "  id="<?php echo $row1['comment_id'];?>" class="reply_button"/>
<input type="button"  value=" <?php echo $lang["Cancel"];?> "  id="<?php echo $msg_id;?>" onclick="closereply('replybox<?php echo $row1['comment_id'];?>')" class="cancel"/>
</form>
</div>
</div>
<!--End replyupdate div	--> 
</div><!--End replycontainer div-->
</div>
<?php } 
$q = mysqli_query($con, "SELECT * FROM bleh WHERE member_id='". $_SESSION['SESS_MEMBER_ID'] ."' and remarks='".$msg_id."' ");
?>

</div><!--End commentcontainer div--> 	

<div class="commentupdate" style='display:none' id='commentbox<?php echo $msg_id;?>'>
<div class="stcommentimg">
<img src="<?php echo $res['profImage'];?>" class='small_face'/>
</div>

<div class="stcommenttext" >
<form method="post" action="">
<!--<textarea name="comment" class="comment" maxlength="200"  id="ctextarea<?php echo $msg_id;?>"></textarea>!-->
<!-- code for smiley!-->
<div id="ctextarea<?php echo $msg_id;?>" onkeyup="checkdata(this.id)" onclick="checkdata(this.id)" contenteditable="true" name="comment" class="comment" style="height:70px; width:329px; border:1px solid black; overflow-y:scroll;"></div>
<div id="showimg2_<?php echo $msg_id;?>" name="actcomment" style="display:none;" /></div>
<input type="hidden" id="currentid" value="<?php echo $msg_id;?>" />
<!--<input type="button" value="show smiley" id="<?php echo $msg_id;?>" onclick="show(this.id)"  />!--><a herf="#!" style="cursor:pointer;" onclick="show(this.id)" id="<?php echo $msg_id;?>"><img src="images/Glad.png"></a>
<!--code for smiley!-->

<br />
<input type="submit"  value="<?php echo $lang['Comment '];?>"  id="<?php echo $msg_id;?>" class="button22 cancel"/>



<!--<input type="submit"  value=" Comment "  id="<?php echo $msg_id;?>" class="button"/>!-->
<input type="button"  value=" <?php echo $lang["Cancel"];?> "  id="<?php echo $msg_id;?>" onclick="cancelclose('commentbox<?php echo $msg_id;?>')" class="cancel"/>

</form>
</div>			
 
<div class="commentupdate" style='display:none' id='reportbox<?php echo $msg_id;?>'>
<div class="stcommentimg">
<img src="<?php echo $res['profImage'];?>" class='small_face'/>
</div>

<div class="stcommenttext" >
<form method="post" action="">
<textarea name="comment" class="comment" maxlength="200"  id="rptextarea<?php echo $msg_id;?>" placeholder="<?php echo $lang['Flag this status'];?>.."></textarea>
<br />
<input type="submit"  value=" <?php echo $lang['Report'];?>"  id="<?php echo $msg_id;?>" class="report"/>
<input type="button"  value=" <?php echo $lang['Cancel '];?>"  id="<?php echo $msg_id;?>" onclick="canclose('reportbox<?php echo $msg_id;?>')" class="cancel"/>
</form>
</div>
</div>



<!--End commentupdate div	-->
              
</div> <!--friends_area --> 

</div>
</div>

			<!--here end right panel-->
                
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