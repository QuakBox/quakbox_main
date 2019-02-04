<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/common/qb_session.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/common/common.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/qb_classes/qb_member1.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/qb_widgets/post_extra.php');

$member_id = $QbSecurity->qbClean($_REQUEST['member_id'], $con);
$session_member_id = $QbSecurity->qbClean($_SESSION['SESS_MEMBER_ID'], $con);
$objMember = new member1();
$album_id = $QbSecurity->qbClean($_REQUEST['album_id'], $con);
$img_id = $QbSecurity->qbClean($_REQUEST['image_id'], $con);
if (!(empty($album_id) || ($qbValidation->qbIntegerCheck($album_id)))) {
    $qb_err_msg = "Oops Something Went Wrong...!";
    $QbSecurity->qbErrorMessage($qb_err_msg, $homepage);
} elseif (!(empty($member_id) || ($qbValidation->qbIntegerCheck($member_id)))) {
    $qb_err_msg = "Oops Something Went Wrong...!";
    $QbSecurity->qbErrorMessage($qb_err_msg, $homepage);
} elseif (!(empty($img_id) || ($qbValidation->qbIntegerCheck($img_id)))) {
    $qb_err_msg = "Oops Something Went Wrong...!";
    $QbSecurity->qbErrorMessage($qb_err_msg, $homepage);

} else {
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/qb_header.php');
    $popup = '';

    if (isset($_REQUEST['popup']) && ($_REQUEST['popup'] == 1)) {
        $popup = '&popup=1';
?>
		<style type="text/css">
            .navbar.navbar-fixed-top{
                display:none!important;
            }
        </style>
<?php
	} 
	$sql = mysqli_query($con, "select * from member, user_album where member.member_id='".$member_id."'
	and member.member_id=user_album.album_user_id and user_album.album_user_id='".$album_id."'") or die(mysqli_error($con));
	$res = mysqli_fetch_array($sql);
	$memberProfilePic = $objMember->select_member_meta_value($member_id,'current_profile_image');
	if($memberProfilePic){			
		$memberProfilePic=SITE_URL.'/'.$memberProfilePic;	
	}
	else{
		$memberProfilePic=SITE_URL.'/images/default.png';
	}
	
	// Comment section
	$postExtra = new post_extra();
?>
<?php /*?><link rel="stylesheet" type="text/css" href="css/style_albums.css"/><?php */?>
<link rel="stylesheet" type="text/css" href="css/share_box.css"/>
<link href="css/style5forimageGallery.css" rel="stylesheet" type="text/css" media="all" />
<?php /*?><link rel="icon" href="images/favicon.ico" type="image" />
<link rel="shortcut icon" href="images/favicon.ico" type="image" />
<link rel="stylesheet" type="text/css" href="css/format.css"/>
<link rel="stylesheet" type="text/css" href="css/search.css"/>
<link rel="stylesheet" type="text/css" href="css/dropdown.css"/><?php */?>

<script type="text/javascript" src="<?php echo $base_url;?>js/jquery-ui.min.js"></script>
<?php /*?><script type="text/javascript" src="<?php echo $base_url;?>js/ibox.js"></script>
<!--common scripts for all wall pages-->
<script src="<?php echo $base_url;?>js/autoscroll22.js"></script>
<script type="text/javascript" src="<?php echo $base_url;?>js/jquery.tokeninput.js"></script><?php */?>
<?php /*include('includes/files.php');?>
<?php include_once('share.php');*/?>



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

//$(function() {
	//$( document ).tooltip();

//});
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
<?php /*?><script>
$('.share_open').live("click",function (e) {
e.preventDefault();

if (!$(this).data('isClicked')) {
        var link = $(this);

        // Your code on successful click
        //for resetting form and values
        $('#shareform')[0].reset();
	$('#countries').val('').trigger('chosen:updated');
	$("#group_name").tokenInput("clear");
	$("#friend_name").tokenInput("clear");
	$(".share_body").empty();
	$('#mydiv3').empty();
	$("#shareSubmitButtonID").removeAttr('disabled');
	$("#mvm").show();
	$("#hiddenIDForSelection").attr("value" , "0");
	$("#mvm1").hide();
	$("#mvm2").hide();

        var ID = $(this).attr("id");
        var rowtype = $(this).attr("rowtype");
        var rowTypeValue = null;
        if(rowtype=="0")
        { rowTypeValue='Share';}
        else if(rowtype=="1")
        { rowTypeValue='Share Photo';}
        else if(rowtype=="2")
        { rowTypeValue='Share Video';}
        else if(rowtype=="3")
        { rowTypeValue='Share Video';}
    var dataString = 'msg_id=' + ID;
    $.ajax({
        type: "POST",
        url: base_url +  "load_data/share_info.php",
        data: dataString,
        cache: false,
        success: function (html) {
        
        var test = html;
                 
                if(test == 1)
                {
                
                window.location.assign(base_url + "login.php");
                }
                else
                {
            $("#shareSubmitButtonID").attr("value",rowTypeValue );
            $(".share_popup").show();
            $(".share_body").append(html);
			$('#mydiv3').share({
        networks: ['facebook','pinterest','googleplus','twitter','linkedin','tumblr','in1','stumbleupon','digg'],        
        urlToShare: '<?php echo $base_url;?>fetch_posts.php?id='+ID
       
    });
    
    $('#mydiv3').append("<img id='email' src='<?php echo $base_url;?>images/sendemail.png' height='40' width='40' alt='Send Email' title='Send Email' onclick='showform()' class='pop share-icon'>");
    $('#email').css('cursor', 'pointer');
        }}
    });
    
        
        

        // Set the isClicked value and set a timer to reset in 3s
        link.data('isClicked', true);
        setTimeout(function() {
            link.removeData('isClicked')
        }, 3000);
    } else {
        // Anything you want to say 'Bad user!'
    }
    return false;
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
	background-color: rgba(0,0,0,0.7); 
	color:#fff;
}	

</style><?php */?>

	  <div class="insideWrapper container">
      	<div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12"> 


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
                
                
                $da= "SELECT * FROM upload_data u LEFT JOIN member m 
                    ON u.USER_CODE = m.member_id 
                    WHERE u.album_id=".$album_id." 
                    ORDER by u.upload_data_id ASC";
                
                $result = mysqli_query($con, $da) or die(mysqli_error($con));
                $totalnumofrec = mysqli_num_rows($result);
                $countrecord = 1;
                $int_show_count = 1;
                while ( $row = mysqli_fetch_array( $result ) )
                {
					$memberPic=$objMember->select_member_meta_value($row['member_id'],'current_profile_image');
					if($memberPic){			
						$memberPic=SITE_URL.'/'.$memberPic;	
					}
					else{
						$memberPic=SITE_URL.'/images/default.png';
					}
                    $msg_id = $row['msg_id'];			 	
                      
                      $total_comments = mysqli_query($con, "SELECT count(*) FROM postcomment where msg_id = '$msg_id' order by date_created asc");
                      $records = mysqli_fetch_array($total_comments);
                      $records = $records[0];
                      
                          
                  if( $img_id == $row['upload_data_id'] )
                    {		
                        echo '<div id="div_photo_'.$row['upload_data_id'].'" style="display:block; z-index:12000;" >';
                    }
                  else
                    {
                        echo '<div id="div_photo_'.$row['upload_data_id'].'" class="photo">';	
                    }
                    
                  $int_show_count=0;
                  
                $url = $_REQUEST['back_page'];
                //$url= $_SERVER['HTTP_REFERER'];
            
            $prevval = '';
			$nextval = '';
                  ?>
                                    
                    <a href="<?php echo $url;?>"><div class="close"></div></a>
                    
                    <span class="ecs_tooltip"><?php echo $lang['Press Esc to close'];?><a href="logged_in.php"> <span class="arrow"></span></a></span>
                    <div id="popup_content"> <!--your content start-->
                      
                            <div id="div_left_panel" class="leftpanel" align="center">
                            
                            
                        <?php 
                            $tag_sql = "SELECT tag_id, member_in_tag_id, div_top, div_left FROM tags Where photo_id='".$row['upload_data_id']."'"; 
                
                            $tag_data = mysqli_query($con, $tag_sql);
                        while( $info = mysqli_fetch_array($tag_data)){
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
                                                                        
                            list($width, $height) = getimagesize($row['FILE_NAME']); 
                            
                            if($width>600 || $height>550)
                            {
                            ?>
                            <img height="100%" width="100%" align="middle" src="<?php echo $row['FILE_NAME'];?>" 
                            id="<?php echo $row['upload_data_id'];?>" value="<?php echo $album_id;?>" />	
                            <?php
                            }
                        
                            else
                            {
                            $height1=(550-$height)/2;
                            echo '<div style="margin-top:'.$height1.'px">';
                            echo '<img align="middle" src="'.$row['FILE_NAME'].'" id="'.$row['upload_data_id'].'" value="'.$album_id.'" />';
                            echo '</div>';
                            } 
                            
                            $previousvalu= mysqli_query($con, "SELECT `upload_data_id` FROM `upload_data` WHERE album_id=".$album_id." and `upload_data_id` < 				'".$row['upload_data_id']."' AND share !=1 ORDER BY `upload_data_id` DESC LIMIT 1");
                            while ($getpreval = mysqli_fetch_array($previousvalu) )
                            {
                                $prevval = $getpreval['upload_data_id'];
                            }
                            
                            $nextvalu= mysqli_query($con, "SELECT `upload_data_id` FROM `upload_data` WHERE album_id=".$album_id." and `upload_data_id` > 				'".$row['upload_data_id']."' AND share !=1 ORDER BY `upload_data_id` ASC LIMIT 1");
                            while ($getnextval = mysqli_fetch_array($nextvalu) )
                            {
                                $nextval = $getnextval['upload_data_id'];			
                                
                            }
                            
                            if($countrecord!=1)
                            {?>
                            
                            
                            <a href="albums.php?back_page=<?php echo $_REQUEST['back_page']; ?>&member_id=<?php echo $member_id; ?>&album_id=<?php echo $album_id; ?>&image_id=<?php echo $prevval;?><?php echo $popup; ?>" >
                            
                            <div class="leftnav"></div></a>
                            <?php 
                            } 
                                if($countrecord!=$totalnumofrec)
                            {
                            ?>
                            
                            <a href="albums.php?back_page=<?php echo $_REQUEST['back_page']; ?>&member_id=<?php echo $member_id; ?>&album_id=<?php echo $album_id; ?>&image_id=<?php echo $nextval;?><?php echo $popup; ?>" >				
                            
                            <div class="rightnav"></div></a>
                            <?php } ?>
                            </div>
                            
                            
                            <div class="rightpanel" style="height:505px !important;">
                            <div class="rightTop" style="height:61px;">
                            <div class="image" style="height:60px">
                            
                            <img src="<?php echo $memberProfilePic; ?>" width="60" height="60" class="CommentImg" style="float:left;" alt="" />
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
                                if($session_member_id== $member_id)
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
                                if($session_member_id == $member_id)
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
                            <div class="rightbottom" style="margin-top: 17px; max-height: 427px; margin-left: -5px; width: 355px;">
                            
                            
                            
            <!-- LIke users display panel -->
            <?php 
            
            $post_like_sql = mysqli_query($con, "SELECT * FROM bleh WHERE remarks='". $msg_id ."'");
            $post_like_count = mysqli_num_rows($post_like_sql);
            
            $post_like_sql1 = mysqli_query($con, "SELECT m.username,m.member_id FROM bleh b, member m WHERE m.member_id=b.member_id AND b.remarks='".$msg_id."' AND b.member_id='".$session_member_id."'");
            $post_like_count1 = mysqli_num_rows($post_like_sql1);
            
            if($post_like_count1==1)
            {
            $post_like_sql2 = mysqli_query($con, "SELECT m.username,m.member_id FROM bleh b, member m WHERE m.member_id=b.member_id AND b.remarks='".$msg_id."' AND b.member_id!='".$session_member_id."' LIMIT 2");
            $plike_count = mysqli_num_rows($post_like_sql2);
            $new_plike_count=$post_like_count-2; 
            }
            else
            {
            $post_like_sql2 = mysqli_query($con, "SELECT m.username,m.member_id FROM bleh b, member m WHERE m.member_id=b.member_id AND b.remarks='".$msg_id."' LIMIT 3");
            $plike_count = mysqli_num_rows($post_like_sql2);
            $new_plike_count=$post_like_count-3; 
            }
            ?>
            <?php /*?><div class="commentPanel" id="likes<?php echo $msg_id;?>" style="margin-bottom: -21px; display:<?php if($post_like_count <= 0) { echo 'none'; } else { echo 'block'; }?>">
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
             <?php echo $lang['and'];?> <span id="plike_count<?php echo $msg_id;?>" class="pnumcount"><?php echo $new_plike_count;?></span> <?php echo $lang['others'];?><?php } ?> <?php echo $lang['like this'];?>.</div> <?php */?>
            <!--<span id="commentlikecout_container<?php echo $res['comment_id'];?>" style="display:<?php if($comment_like_count <= 0) { echo 'none'; } else { echo 'block'; }?>">
            
            <span id="commentlikecount<?php echo $res['comment_id'];?>">
            <?php
            echo $comment_like_count;
            ?>
            </span>
            Like this
            </span>
            -->
            <!-- LIke users display panel -->
            
            
            <!--Dislike users display panel-->
            <?php 
            
            $sql1 = mysqli_query($con, "SELECT * FROM post_dislike WHERE msg_id='". $msg_id ."'") or die(mysqli_error($con));
            $dislike_count = mysqli_num_rows($sql1);
             
            $query1=mysqli_query($con, "SELECT m.username,m.member_id FROM post_dislike b, member m WHERE m.member_id=b.member_id AND b.msg_id='".$msg_id."' LIMIT 3");
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
			
			<div style="width: 80%; padding: 5px 10px;" class="pull-left rp<?php echo $QbSecurity->QB_AlphaID($msg_id);?>">
			<?php echo $postExtra->extra_widget('', $msg_id, $QbSecurity->QB_AlphaID($msg_id), 1); ?>
            </div>
            
            
            <?php /*?><div class="commentupdate" style="display:none; margin-top:25px; width:310px;" id='commentbox<?php echo $QbSecurity->QB_AlphaID($msg_id);?>'>
            <div class="stcommentimg">
            <img src="<?php echo $memberPic;?>" class='small_face'/>
            </div>
            
            <div class="stcommenttext" style="width: 261px;">
            <form method="post" action="">
            <!--<textarea name="comment" class="comment" maxlength="200"  id="ctextarea<?php echo $msg_id;?>"></textarea>!-->
            <!-- code for smiley!-->
            
            <textarea id="ctextarea<?php echo $msg_id;?>" onkeyup="checkdata(this.id)" onclick="checkdata(this.id)" contenteditable="true" name="comment" class="comment" style="height:70px; width:268px; border:1px solid black; overflow-y:scroll;"></textarea>
            
            <!--<div id="showimg2_<?php echo $msg_id;?>" name="actcomment" style="display:none;" /></div>-->
            <input type="hidden" id="currentid" value="<?php echo $msg_id;?>" />
            
            <a herf="javascript:void(0)" style="cursor:pointer;" onclick="showsmiley(this.id)" id="<?php echo $row['messages_id'];?>"><img src="images/Glad.png" style="height: 17px; width: 17px;"></a>
            <!--code for smiley!-->
            
            <br />
            <input type="submit"  value="<?php echo $lang['Comment '];?>"  id="<?php echo $msg_id;?>" class="button22 cancel"/>
            
            
            
            <!--<input type="submit"  value=" Comment "  id="<?php echo $msg_id;?>" class="button"/>!-->
            <input type="button"  value=" <?php echo $lang["Cancel"];?> "  id="<?php echo $msg_id;?>" onclick="cancelclose('commentbox<?php echo $msg_id;?>')" class="cancel"/>
            
            </form>
            </div>			
             
            
            
            
            
            <!--End commentupdate div	-->
                          
            </div> <!--friends_area --> <?php */?>
            <div class="commentupdate" style="display:none; width:318px;" id='reportbox<?php echo $msg_id;?>'>
            <div class="stcommentimg">
            <img src="<?php echo $memberPic;?>" class='small_face'/>
            </div>
            
            <div class="stcommenttext" style="width: 275px;" >
            <form method="post" action="">
            <textarea name="comment" class="comment" maxlength="200" style="width:272px" id="rptextarea<?php echo $QbSecurity->QB_AlphaID($msg_id);?>" placeholder="<?php echo $lang['Flag this status'];?>.."></textarea>
            <br />
            <input type="submit"  value=" <?php echo $lang['Report'];?>"  id="<?php echo $msg_id;?>" class="report"/>
            <input type="button"  value=" <?php echo $lang['Cancel'];?>"  id="<?php echo $msg_id;?>" onclick="canclose('reportbox<?php echo $msg_id;?>')" class="cancel"/>
            </form>
            </div>
            </div>
            
            <?php /*?><div class="emot_comm">
                
            <span class="show-cmt" style="margin-right:5px;" id="wallsLikeP<?php echo $QbSecurity->QB_AlphaID($msg_id); ?>">
             <?php
             $q = mysqli_query($con, "SELECT * FROM bleh WHERE member_id='". $session_member_id ."' and remarks='".$msg_id."' ");
                if(mysqli_num_rows($q) > 0)
                {
                    echo '<a href="javascript: void(0)" class="like walls_unlike" id="'.$QbSecurity->QB_AlphaID($msg_id).'" title="'.$lang['Unlike'].'" rel="Unlike">'.$lang['Unlike'].' </a>';
                } 
            
                else 
                { 
                    echo '<a href="javascript: void(0)" class="like walls_like" id="'.$QbSecurity->QB_AlphaID($msg_id).'" title="'.$lang['Like'].'" rel="Like">'.$lang['Like'].'</a>';
                }
                
            ?>
            </span>
            
            <span class="show-cmt" style="margin-right:5px;" id="wallsDislikeP<?php echo $QbSecurity->QB_AlphaID($msg_id); ?>">
            <span class="mySpan_dot_class"> · </span>
             <?php
             
             //$pdislikequery = "SELECT dislike_id FROM post_dislike WHERE member_id='". $_SESSION['SESS_MEMBER_ID'] ."' and remarks='".$msg_id."' ";
             $pdislikequery = "SELECT dislike_id FROM post_dislike WHERE member_id='$member_id'";
             $pdislikesql = mysqli_query($con, $pdislikequery);
             
             
                if(mysqli_num_rows($pdislikesql) > 0)
                {
                    echo '<a href="javascript: void(0)" class="post_dislike walls_undislike" id="'.$QbSecurity->QB_AlphaID($msg_id).'" title="'.$lang['Unlike'].'" rel="disLike">'.$lang['DisLike'].'</a>';
                } 
            
                else 
                { 
                    echo '<a href="javascript: void(0)" class="post_dislike walls_dislike" id="'.$QbSecurity->QB_AlphaID($msg_id).'" title="'.$lang['Like'].'" rel="disLike">'.$lang['DisLike'].'</a>';
                }
                
                
            ?>
            </span>
            
            
            
            
            <span  class="show-cmt">
            <span class="mySpan_dot_class"> · </span>
            <a href="javascript:void(0)" id="<?php echo $QbSecurity->QB_AlphaID($msg_id);?>" class="commentopen show_cmt_linkClr"><?php echo $lang['Comment'];?></a>
            
            <!--<a href="javascript: void(0)" id="<?php echo $msg_id;?>" class="commentopen">Comment</a>-->
            </span>
            
            <span class="show-cmt">
            <span class="mySpan_dot_class"> · </span>
            <a href="javascript:void(0)" class="share_open show_cmt_linkClr" id="<?php echo $msg_id;?>" title="<?php echo $lang['Share'];?>"><?php echo $lang['Share'];?></a>
            
            <!--<a href="javascript: void(0)" class="share_open" id="<?php echo $msg_id;?>">Share</a>-->
            
            </span>
            
            <span class="show-cmt">
            <span class="mySpan_dot_class"> · </span>
            <a href="javascript:void(0)" id="<?php echo $msg_id;?>" class="flagopen show_cmt_linkClr"><?php echo $lang['Flag this Status'];?></a>
            
            <!--<a href="" id="<?php echo $msg_id;?>" class="flagopen">Flag this Status</a>-->
            </span>
            
            <?php 
            if($session_member_id == $row['USER_CODE'])
            {
            ?>
            <span class="show-cmt">
            <a href='javascript:show_photo_tag()' id='photo_tag'><?php echo $lang['Photo tag'];?></a>
            </span>
            <?php } ?>
            
            </div><?php */?> <br />
            
            </div>
            </div> 
                            
            </div> <!--your content end-->
            </div> 
                <!--toPopup end-->
                
                <div class="loader" id="loader"></div>
                <div class="backgroundPopup" id="backgroundPopup"></div>
<?php
	$countrecord++; } 
?>

<?php /*?><script>


$('.button22').live("click", function (e) {
e.preventDefault();

if (!$(this).data('isClicked')) {
        var link = $(this);

    var ID = $(this).attr("id");
    var comment = jQuery.trim($("#ctextarea"+ID).val());	
 
  if(comment.length==0){
  alert("Please write something"); return false;}
   
    var dataString = 'comment=' + comment + '&msg_id=' + ID;
    if (comment == '') {
        alert("Please Enter Comment Text");
    } else {
        $.ajax({
            type: "POST",
            url: base_url + "action/comment_ajax.php",
            data: dataString,
            cache: false,
            success: function (html) {
              var test = html;
                 
                if(test == 1)
                {
                
                window.location.assign("<?php echo $base_url;?>login.php");
                }
                else
                {
            	
               $("#commentload"+ID).append(html);
                $("#ctextarea"+ID).val('');
                $("#commentbox"+ID).hide();  
               
                
                           
                
            }}
        });
    }
    // Set the isClicked value and set a timer to reset in 3s
        link.data('isClicked', true);
        setTimeout(function() {
            link.removeData('isClicked')
        }, 3000);
    } else {
        // Anything you want to say 'Bad user!'
    }
    return false;
});





function like(id)
{

//commentstat
$("#"+id).text('Unlike');
var res = id.split("_");
//alert(res[1]);


                             $.ajax({
			      url: 'like.php',
			      type: 'post',
			      data: {'msgid':res[1]},
			      success: function(data, status) {
			      
			           // alert(data);
			          $('#commentstat').html(data);
			         
			        // alert($("#commentstat").length);
			         // alert('yes');
			          location.reload();
			         
			      },
			     
			    }); 
			    
			    // end ajax call
}



function dislike(id)
{
//alert(id);
//commentstat
//$("#"+id).text('Unlike');
var res = id.split("_");
//alert(res[1]);
$("#like_"+res[1]).text('Like');


                             $.ajax({
			      url: 'dislike.php',
			      type: 'post',
			      data: {'msgid':res[1]},
			      success: function(data, status) {
			      
			            //alert(data);
			          $('#commentstat').html(data);
			         
			        // alert($("#commentstat").length);
			         // alert('yes');
			          
			         location.reload();
			      },
			     
			    }); 
			    
			    // end ajax call
}


function show(id)
{
	//alert(id);
	$("#currentid").val(id);
	//alert('hi');
	$("#vinod").show();
	var scrol=$(document).scrollTop();
		//alert(scrol);
		$("#vinod").css('top', scrol+300);
}

function closesmiley()
{
	$("#vinod").hide();
}

function addsmiley(path)
{
	//alert(path);
	var currentid=$("#currentid").val();
	//alert(currentid);
	
	var olddata=$("#showimg2_"+currentid).html();
	//alert(olddata);
	//$("#ctextarea"+currentid).html("<img src="+path+" height='20' width='20'>");
	$("#ctextarea"+currentid ).append("<img src="+path+" height='20' width='20'>");
	//alert($("#showimg").text());
	//alert($("#ctextarea"+currentid).text());
	 //$("#showimg2_"+currentid).append($("#ctextarea"+currentid).text());
	 //var acttext= $('#anothertext').html();
	// alert(acttext);
	//alert($("#ctextarea"+currentid ).html());
	 $("#showimg2_"+currentid).append($("#ctextarea"+currentid ).html());
	 $("#vinod").hide();
	
}

function checkdata(id)
{
	//alert(id);
	var str=id.split('ctextarea');
	//alert(str[1]);
	var typecontent=$("#"+id).text();
	//alert(typecontent);
	$("#showimg2_"+str[1]).text(typecontent);
}

</script><?php */?>
<?php //include_once 'smiley.php'; ?>
<div id="vinod" class="PopupPanel" style="display:none;">
    <div align="right"><a href="#!" onclick="closesmiley()"><img src="images/closebox.png"></a></div>
    <table width="100%" cellpadding="4" cellspacing="4">
    <tr><td><img src='img/smiley/kiss.jpg' style="border-radius:50%" height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='img/smiley/laugh.jpg' height="40" style="border-radius:50%" width="40" onclick="addsmiley(this.src)" ></td><td><img src='img/smiley/wakulya.png' style="border-radius:50%" height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='img/smiley/cry.png' style="border-radius:50%" height="40" width="40" onclick="addsmiley(this.src)" ></td></tr>
    <tr><td><img src='img/smiley/fg.jpg' style="border-radius:50%" height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='img/smiley/images.jpg' height="40" style="border-radius:50%" width="40" onclick="addsmiley(this.src)" ></td><td><img src='img/smiley/images0.jpg' style="border-radius:50%" height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='img/smiley/images1.jpg' style="border-radius:50%" height="40" width="40" onclick="addsmiley(this.src)" ></td></tr>
    
    <tr><td><img src='img/smiley/images2.jpg' style="border-radius:50%" height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='img/smiley/images3.jpg' height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img style="border-radius:50%" src='img/smiley/images4.jpg' height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='img/smiley/images5.jpg' style="border-radius:50%" height="40" width="40" onclick="addsmiley(this.src)" ></td></tr>
    
    
    <tr><td><img src='img/smiley/surprised.png' style="border-radius:50%" height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='img/smiley/images7.jpg' height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='img/smiley/images8.jpg' style="border-radius:50%" height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='img/smiley/images9.jpg' style="border-radius:50%" height="40" width="40" onclick="addsmiley(this.src)" ></td></tr>
    
    <tr><td><img src='img/smiley/images/smiley-1.JPG' style="border-radius:50%" height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='img/smiley/images/smiley-2.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='img/smiley/images/smiley-3.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='img/smiley/images/smiley-4.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td></tr>
    
    
    
    <tr><td><img src='img/smiley/images/smiley-5.JPG' style="border-radius:50%" height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='img/smiley/images/smiley-6.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='img/smiley/images/smiley-7.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='img/smiley/images/smiley-8.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td></tr>
    
    <tr><td><img src='img/smiley/images/smiley-9.JPG' style="border-radius:50%" height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='img/smiley/images/smiley-10.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='img/smiley/images/smiley-11.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='img/smiley/images/smiley-12.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td></tr>
    
    
    <tr><td><img src='img/smiley/images/smiley-13.JPG' style="border-radius:50%" height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='img/smiley/images/smiley-14.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='img/smiley/images/smiley-15.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='img/smiley/images/smiley-16.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td></tr>
    
    
    <tr><td><img src='img/smiley/images/smiley-17.JPG' style="border-radius:50%" height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='img/smiley/images/smiley-18.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='img/smiley/images/smiley-19.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='img/smiley/images/smiley-20.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td></tr>
    
    
    <tr><td><img src='img/smiley/images/smiley-21.JPG' style="border-radius:50%" height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='img/smiley/images/smiley-22.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='img/smiley/images/smiley-23.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='img/smiley/images/smiley-24.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td></tr>
    
    
    <tr><td><img src='img/smiley/images/smiley-25.JPG' style="border-radius:50%" height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='img/smiley/images/smiley-26.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='img/smiley/images/smiley-27.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='img/smiley/images/smiley-28.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td></tr>
    
    <tr><td><img src='img/smiley/images/smiley-29.JPG' style="border-radius:50%" height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='img/smiley/images/smiley-30.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='img/smiley/images/smiley-31.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='img/smiley/images/smiley-32.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td></tr>
    
    
    <tr><td><img src='img/smiley/images/smiley-33.JPG' style="border-radius:50%" height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='img/smiley/images/smiley-34.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='img/smiley/images/smiley-35.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td><td><img src='img/smiley/images/smiley-36.JPG' height="40" width="40" onclick="addsmiley(this.src)" ></td></tr>
    
    </table>
</div>
			</div>
		</div>
	</div>
                            
<?php
		require_once($_SERVER['DOCUMENT_ROOT'].'/share.php');
		include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_footer.php');
	} ?>