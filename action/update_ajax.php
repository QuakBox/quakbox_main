<?php ob_start();
require($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php');
include($_SERVER['DOCUMENT_ROOT'].'/config.php');
require($_SERVER['DOCUMENT_ROOT'].'/common/qb_email.php');
error_reporting(-1);
if(!isset($_SESSION['SESS_MEMBER_ID']))
	{
echo "1";	
	}
	else
	{
	?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
$(document).ready(function () {
 $('.posttranslateButton').click(function (event) {
        var ID = $(this).attr('id');
        var sid = ID.split("posttranslateButton");
        var New_ID = sid[1];
        var optionss = 2;
        //alert(i);
      
        if(last_id==New_ID)
        {
        i++;
        
        }
         else
        {
         
        i=0;
        }
        
        if(i==0)
        {
        last_id=New_ID;
        fillList(Microsoft.Translator.Widget.GetLanguagesForTranslateLocalized(), New_ID, optionss);
        i++;
        }
       
        console.log('click - form');
        $('#posttranslatemenu' + New_ID)[0].focus();
        $('#posttranslatemenu' + New_ID).toggle(300);
        event.stopPropagation();
    });
    });
</script>

<?php

if(isset($_SESSION['lang']))

	{	

		include($_SERVER['DOCUMENT_ROOT'].'/common.php');

	}

	else

	{

		include($_SERVER['DOCUMENT_ROOT'].'/Languages/en.php');

		

	}

include($_SERVER['DOCUMENT_ROOT'].'/config.php');

include_once ($_SERVER['DOCUMENT_ROOT'].'/includes/time_stamp.php');

include_once ($_SERVER['DOCUMENT_ROOT'].'/includes/tolink.php');



$s_member_id = $_SESSION['SESS_MEMBER_ID'];

$member_id = f($_POST['member_id'], 'strip');
$member_id = f($member_id, 'escapeAll');
$member_id = mysqli_real_escape_string($con, $member_id);

$mystatusx =  f($_POST['update'] , 'escapeAll');
$mystatusx = nl2br($mystatusx);
$mystatusx = mysqli_real_escape_string($con, $mystatusx);
?>
<?php
if(isset($_SESSION['lang']))
{
?>	
<script>
var lan1="<?php echo $_SESSION['lang'];?>";
var text1="<?php echo $mystatusx;?>";
call(lan1,text1);
function call(lan1,text1)
{
var g_token = '';
var lan =lan1;
var src = text1;

    var requestStr = "../token.php";
       $.ajax({
        url: requestStr,
        type: "GET",
        cache: true,
        dataType: 'json',
        success: function (data) {        
            g_token = data.access_token;
           	
        },
        complete: function(request, status) {
     
			translate1231(g_token,src,lan);
			
			},    
    });

	
		}
		
function translate1231(g_token,src1,lan)
	{
		 var language=lan;
	
		var src = src1;
		
		var p = new Object;
		
    p.text = src;
    p.from = null;
    p.to = "" + language + "";
    p.oncomplete = 'ajaxTranslate';
    p.appId = "Bearer " + g_token;
   
    var requestStr = "https://api.microsofttranslator.com/V2/Ajax.svc/Translate";
       $.ajax({
        url: requestStr,
        type: "GET",
        data: p,
        dataType: 'jsonp',
        cache: 'true',
       
		});
	}	
		
	function ajaxTranslate(response) { 
		
		 document.getElementById("target_tr").innerHTML = response;

	}
    
    </script>
     
	<?php 
}


$country =  f($_POST['country'] , 'escapeAll');
$country = mysqli_real_escape_string($con, $country);

$privacy = f($_POST['privacy'], 'strip');
$privacy = f($privacy , 'escapeAll');
$privacy =  mysqli_real_escape_string($con, $privacy);


$smembersql =  mysqli_query($con, "select * from members where member_id='".$s_member_id."'");

$smemberres = mysqli_fetch_array($smembersql);


$share_member_id = f($_POST['share_member_id'], 'strip');
$share_member_id = f($share_member_id , 'escapeAll');
$share_member_id =  mysqli_real_escape_string($con, $share_member_id);

$unshare_member_id = f($_POST['unshare_member_id'], 'strip');
$unshare_member_id = f($unshare_member_id , 'escapeAll');
$unshare_member_id =  mysqli_real_escape_string($con, $unshare_member_id);



 $member_sql = mysqli_query($con, "select * from members where username='".$share_member_id."'");

 $mem_res = mysqli_fetch_array($member_sql);

	

 $member_sql1 = mysqli_query($con, "select * from members where username='".$unshare_member_id."'");

 $mem_res1 = mysqli_fetch_array($member_sql1);



$sql = mysqli_query($con, "select * from geo_country where country_title='".$country."'") or die(mysqli_error($con));

$res = mysqli_fetch_array($sql);

if($country = '')
{
if($country = 'mywall')
{
$content_id = 0;
} else{
	$content_id = $member_id;
	}
}

else
{
	$content_id = 0;
}

$member = mysqli_query($con, "select * from members where member_id = '$member_id'");

$member_res = mysqli_fetch_array($member);

if($_POST['country'] != 'mywall'){
$country = f($_POST['country'], 'escapeAll');
$country =  mysqli_real_escape_string($con, $country);
$countryWithSpace = str_replace('-', ' ', $country);
}

mysqli_query($con, "INSERT INTO message (member_id,content_id,messages,country_flag,type,wall_privacy,share_member_id,unshare_member_id,date_created)

VALUES('$member_id','$content_id','".$mystatusx."','$country',0,'".$privacy."','".$share_member_id."','".$unshare_member_id."',".strtotime(date("Y-m-d H:i:s")).")");
$langs=array("","hi","ar","bg","ca","cs","da","nl","et","fi","fr","zh-CHS","zh-CHT","de","el","ht","he","mww","hu","id","it","ja","tlh","ko","lv","lt","ms","mt","no","fa","pl","pt","ro","ru","sk","sl","es","sv","th","tr","uk","ur","vi","cy");
//$_SESSION['last_id1']= mysqli_insert_id($con);
$last_id1= mysqli_insert_id($con);
//$language="hi";
for($i=0;$i<=43;$i++)
{
$language=$langs[$i];

?>
<?php include "../test3.php"; }?>


<?php 


$sql = mysqli_query($con, "select * from message msg,members m where msg.member_id=m.member_id and country_flag='$country' order by messages_id desc");

$row = mysqli_fetch_array($sql);

if ($row)

{

	$time = $row['date_created'];

	$msg_id = $row['messages_id'];

	$messages = $row['messages'];
	
	$orimessage       = $row['messages'];

	$url = 'posts.php?id='.$msg_id.'';

	$type = $row['type'];

	

	

	$fquery = "select m.member_id,m.email_id from friendlist f,members m where f.member_id=m.member_id and f.added_member_id = '".$member_id."' AND status !=0";

//echo $fquery;

$fsql = mysqli_query($con, $fquery);



if(mysqli_num_rows($fsql) > 0)

{

while($fres = mysqli_fetch_array($fsql))

{

	$ids = $fres['email_id'];



$msg_member_id = $fres['member_id'];

$nquery = "INSERT INTO notifications (sender_id, received_id, type_of_notifications, href, is_unread, date_created)

				VALUES('$member_id','$msg_member_id',8,'$url',0,'$time')";

mysqli_query($con, $nquery);



	

/************************************* mail function ***********************************/

if($country != 'world')
{


if($country != NULL) {
	

	$subject_text = $country;

} else {

	$subject_text = 'wall';

}



if($type == 0){

	$subject_msg = 'status';

} else if($type == 1){

	$subject_msg = 'photo';

}else {

	$subject_msg = 'video';

}



$to = $ids;

$subject = "".ucfirst($member_res['username']). " post ".$subject_msg." in ".$subject_text."";

$mailTitle="";
$htmlbody = " 
        	<div style='width:100px;float:left;border:1px solid #ddd;'>
        		<a href='".$base_url.$member_res['username']."' title='".$member_res['username']."' target='_blank' style='text-decoration:none;'><img style='width:100%;' alt='".$member_res['username']."' title='".$member_res['username']."' src='".$base_url.$member_res['profImage']."' /></a>
        	</div> 
        	<div style='float:left;padding:15px;'>
        		<div>
        			<a href='".$base_url.$member_res['username']."' title='".$member_res['username']."' target='_blank' style='text-decoration:none;color:#085D93;'>".$member_res['username']." update a status on quakbox wall</a>
        		</div>
        		";
				
				
				if($country != NULL && $country != 'world') { 

$htmlbody .= "<div style='color:#808080;font-weight:bold;'>".$res['country_title']."</div>";
$htmlbody .= "<div><img src='".$base_url."images/Flags/flags_new/flags/".strtolower($res['code']).".png' width='100' height='100'></div>";
 } else {

$htmlbody .= "<div> wall </div>";

}
				if($type == 0) {

$htmlbody .="<div>Message: ".$messages."</div>";

} else if($type == 1) {

	$htmlbody .= "<a href='".$base_url."posts.php?id=".$msg_id."' target='_blank'><img src='".$base_url.$messages."' height='200' width='200'></a>";

} else if($type == 2) {

	$htmlbody .= "<a href='".$base_url."posts.php?id=".$msg_id."' target='_blank'><img src='".$base_url.$messages."' height='200' width='200'><a>";

}

$obj = new QBEMAIL(); 
$mail=$obj->send_email($to,$subject,'',$mailTitle,$htmlbody,'');



}

}

}

/************************************* end mail function ***********************************/

	

?>

<script type="text/javascript"> 
$(document).ready(function(){
	var text = $('#textoembed<?php echo $msg_id;?>').val();
	
	$("#stexpand<?php echo $msg_id;?>").oembed(text,{maxWidth: 400, maxHeight: 300});
});
</script>
<textarea id="textoembed<?php echo $msg_id;?>" style="display:none"><?php 

$string = $orimessage;
$regex = '/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i';
preg_match_all($regex, $string, $matches);
$urls = $matches[0];
// go over all links
foreach($urls as $url) {
    echo $url;
}
?></textarea>

<div class="stbody" id="stbody<?php echo $row['messages_id'];?>" data-id="<?php echo $row['messages_id'];?>" wall-type="1">

<div class="stimg">
<?php 
if($row['share'] != 1){
$profpic = $base_url.$row['profImage'];
$shusername = $base_url.$row['username'];
} else {
$profpic = $base_url.$smres['profImage'];
$shusername = $base_url.$smres['username'];
}

if($row['share'] != 1){
if($_SESSION['SESS_MEMBER_ID'] == $row['member_id'])
{
   
?>

<a href="<?php echo $base_url."i/".$row['username'];?>"><img src="<?php echo $profpic;?>" class='big_face' original-title="<?php echo $shusername ;?>"/></a> 

<?php } 
else
{
?>

<a href="<?php echo $shusername ;?>"><img src="<?php echo $profpic;?>" class='big_face' original-title="<?php echo $shusername ;?>"/></a> 

<?php } } else {
if($_SESSION['SESS_MEMBER_ID'] == $smres['member_id'])
{
   
?>


<a href="<?php echo $base_url."i/".$row['username'];?>"><img src="<?php echo $profpic;?>" class='big_face' original-title="<?php echo $shusername ;?>"/></a> 

<?php } 
else
{
?>


<a href="<?php echo $shusername ;?>"><img src="<?php echo $profpic;?>" class='big_face' original-title="<?php echo $shusername ;?>"/></a> 

<?php } }?>

</div><!--End stimg div	-->

<div class="sttext">
<?php 
if($_SESSION['SESS_MEMBER_ID'] == $row['member_id'])
{
?>
<a class="stdelete" href="#" id="<?php echo $row['messages_id'];?>" original-title="Delete update" title="<?php echo $lang['Delete update'];?>"></a>
<?php }
if($row['share'] != 1)
	{
if($_SESSION['SESS_MEMBER_ID'] == $row['member_id'])
{

?>


<a href="<?php echo $base_url."i/".$row['username'];?>"><b><?php echo $row['username'];?></b></a> 

<?php } 
else
{
?>
<a href="<?php echo $base_url.$row['username'];?>"><b><?php echo $row['username'];?></b></a> 
<?php }

	}
if($row['country_flag'] != NULL)
{
	if($row['share'] == 1)
	{
	if($_SESSION['SESS_MEMBER_ID'] == $smres['member_id']){
	
	echo "<a href='".$base_url."i/".$row['username']."'><b>".$smres['username']."</b></a>" ;
	} else {
	echo "<a href='".$base_url.$smres['username']."'><b>".$smres['username']."</b></a>" ;
	}
echo $lang['share a'];
//echo "<a href='".$base_url.$smres['username']."'><b>".$row['username']."</b></a>" ;	

if($row['type'] == 0)
{
	echo '<!--<a href="'.$base_url.'"posts.php?id='.$row['messages_id'].'">--> '.$lang['status'].'</a>';
}
else if($row['type'] == 1)
{
	echo '<!--<a href="'.$base_url.'albums.php?back_page=country_wall.php?country='.$row['country_flag'].'&member_id='.$row['member_id'].'&album_id='.$row['msg_album_id'].'&image_id='.$row['upload_data_id'].'">--> '.$lang['photo'].'</a>';
}
else
{
	echo '<!--<a href="'.$base_url.'watch.php?video_id='.$row['video_id'].'">--> '.$lang['video'].'</a>';
}
} 
else
{
?>
<img style="margin:0px 3px;" src="images/arrow_png.jpg" /> 
<a href="<?php echo $homepage;?>"><b><?php echo strtoupper($row['country_flag']);?></b></a>
<?php if(strtolower($row['country_flag'])!='world'){
	$flag_sel_query=mysqli_query($con,"SELECT * FROM `geo_country` WHERE `country_title`='$country'");
	$cfres=mysqli_fetch_array($flag_sel_query);?>
<img src="<?php echo $base_url."images/emblems/".$cfres['code'].".jpg";?>" width="20" height="20" style="margin-left:3px; vertical-align:middle;" />
<?php } }
}
if($_SESSION['SESS_MEMBER_ID'] == $row['member_id'])
{
?>

<?php //echo $msg_id ;
// include "test2.php"?>
<?php } ?>
<div style="margin:5px 0px;" class="text_exposed_root" id="id<?php echo $row['messages_id'];?>">
<?php 
 if($row['share']==1) {?>
 <div class="aboveUnitContent">
 <div class="_wk mbn">
 <span><?php echo $row['share_msg']; ?></span>
 <?php if($_SESSION['SESS_MEMBER_ID'] == $share_by1)
{
?>

<?php //echo $msg_id ;
// include "test2.php"?>
<?php } ?>
 </div>
 </div>
<br />	
 <?php } if($row['type']==0)
 
 {
	if(isset($_SESSION['lang'])&&($_SESSION['lang']<>"en"))
	{	
		
		$sql = mysqli_query($con, "select * from message1 where msg_id='".$row['messages_id']."' and tr_id='".$_SESSION['lang']."'")or die(mysqli_error($con));
$r_count = mysqli_num_rows($sql);
//echo $r_count;
if($r_count>0)
{
$row_post = mysqli_fetch_assoc($sql);

echo "<p style='display: inline;]>". $row_post['message']."</p>";

}
	
	else
	{
		//$i++;
		
		
	include "test9.php";	
		//sleep(3);
	}
	$sql1 =  mysqli_query($con, "select * from message1 where msg_id='".$row['messages_id']."' and tr_id='".$_SESSION['lang']."'")or die(mysqli_error($con));
	$r_count1 = mysqli_num_rows($sql1);
	if($r_count1==0)
{

	echo "<p style='display: inline;]>". tolink(htmlentities($row['messages']))."</p>";

}		
	}
	
	else
	{ $message = $row['messages'];
	  $message_count = strlen($message);
	  $message500 = substr($message,0,500);
	  $message1000 = substr($message,500);
	  if($message_count <= 500){
		?>
		<p style="display: inline;"><?php echo tolink(htmlentities($row['messages'])); ?></p>
        <?php } else {?>
        <p style="display: inline;"><?php echo tolink(htmlentities($message500)); ?></p>
        <span class="text_exposed_hide">...</span>
        <div class="text_exposed_show"><?php echo tolink(htmlentities($message1000)); ?></div>
        <span class="text_exposed_hide"> 
        <span class="text_exposed_link">
        <!--<a class="see_more_link" onclick="var parent = Parent.byClass(this, text_exposed_root); if (parent parent.getAttribute(id) == <?php //echo $row['messages_id'];?>) { CSS.addClass(parent, text_exposed); }; " href="#" role="button">See More</a>-->
        <a class="see_more_link" id="<?php echo $row['messages_id'];?>" href="#" role="button">See More</a>
        </span>
        </span>
<?php		}
	}
?> 
<?php 
$temp='en';
?>
<div tabindex="1" id="posttranslatemenu<?php echo $row['messages_id'];?>" class="posttranslatemenu" style="display:none; position:absolute;margin-left: 34%; "> <select id="postlangs<?php echo $row['messages_id'];?>" class="postlangs" onchange="selectOption(this.value, <?php echo $row['messages_id'];?>,2,'<?php 
if(isset($_SESSION['lang']))
{
echo $_SESSION['lang'];
}
else
{
 echo 'en';
 }?>')">
            <option value=""><?php echo $lang['select language'];?></option> 
            </select>
            </div> 
            
<textarea class="postsource" id="postsource<?php echo $row['messages_id']; ?>"  style="display:none;"><?php echo $row['messages']; ?></textarea>
<div class="posttarget" style="font:bold;" id="posttarget<?php echo $row['messages_id']; ?>"></div>
<?php
} 
if($row['type']==1){

$desc=mysqli_query($con, "select description from message where messages_id='".$row['messages_id']."'" );
$desc_res=mysqli_fetch_assoc($desc);
?><div><?php
echo $desc_res['description'];

?></div>
<a href="<?php echo $base_url;?>albums.php?back_page=<?php echo $homepage;?>&member_id=<?php echo $row['member_id']; ?>&album_id=<?php echo $row['msg_album_id']; ?>&image_id=<?php echo $row['upload_data_id'];?>" >
<?php
list($width, $height) = getimagesize($base_url.$row['messages']);
	
	if($width > $height)
	{
	?>
    <img src="<?php echo $base_url.$row['messages'];?>"  style="width: 400px" />
    <?php } 
	else if($width < $height)
	{
	?>
	<img src="<?php echo $base_url.$row['messages'];?>" style="height: 250px" />
	<?php } 
	else
	{
	?>
    <img src="<?php echo $base_url.$row['messages'];?>" width="<?php if($width<400)echo $width; else echo '400'?>px"  />
    <?php } ?>
</a>

<?php } if($row['type']==2){?>
<a href="<?php echo $base_url;?>watch.php?video_id=<?php echo $row['video_id'];?>" style="color:#993300;">





<h3 class="video_title"  >
<?php 
if(isset($_SESSION['lang'])&&($_SESSION['lang']<>"en"))
	{	
	
		//echo $row['messages_id'];
		$sql_vi = mysqli_query($con, "select * from videos1 where video_id='".$row['messages_id']."' and lang='".$_SESSION['lang']."'")or die(mysqli_error($con));
$r_count_vi = mysqli_num_rows($sql_vi);
//echo $r_count;
if($r_count_vi>0)
{
$row_post_vi = mysqli_fetch_assoc($sql_vi);


	echo $row_post_vi['title'];

}
	
	else
	{
		//$i++;
		
		
	include "video_trns.php";	
		//sleep(3);
	}
	$sql_vi1 =  mysqli_query($con, "select * from videos1 where video_id='".$row['messages_id']."' and lang='".$_SESSION['lang']."'")or die(mysqli_error($con));
	$r_count_vi1 = mysqli_num_rows($sql_vi1);
	if($r_count_vi1==0)
{

	echo $row['title'];

}		
	}
	
	else
	{
		echo $row['title'];
		
	}

?></h3></a>


 <div id="videoplayerid<?php echo $row['video_id'];?>"> </div>
 <?php 
 $videoid = "videoplayerid".$row['video_id'];
 $mp4videopath1 = $base_url.$mp4videopath;
 $oggpath = $base_url.$oggvideopath;
 $webmpath = $base_url.$webmvideopath;
 $thumwala = $base_url."uploadedvideo/videothumb/p400x225".$thumb;
 $adsmp4 = $base_url.$adsmp4videopath;
 $adsogg = $base_url.$adsoggvideopath;
 $adswebm = $base_url.$adswebmvideopath;
 $fetch = urlencode($base_url."watch.php?video_id=".$row['video_id']);
 $fetch_url_pinterest = urlencode($base_url.'uploadedvideo/videothumb/p200x150'.$thumb).'&url='.urlencode($base_url."watch.php?video_id=".$row['video_id']).'&is_video=true&description='.$description;   
 ?>
<script type="text/javascript" charset="utf-8">
       var videoidqw = "<?php Print($videoid); ?>";
    var title1 = "<?php Print($title); ?>";
		var desc1 = "<?php Print($description); ?>";
		var mp4videopath = "<?php Print($mp4videopath1); ?>";
		var oggvideopath = "<?php Print($oggpath); ?>";
		var webmvideopath = "<?php Print($webmpath); ?>";
		var thumb = "<?php Print($thumwala); ?>";
		var adsmp4videopath = "<?php Print($adsmp4); ?>";
		var adsoggvideopath = "<?php Print($adsogg); ?>";
		var adswebmvideopath = "<?php Print($adswebm); ?>";
		var ads = "<?php Print($ads); ?>";
		if(ads == 1){
			var adsFlag = true;
		}else {
			var adsFlag = false;
		}
		var click_url = "<?php Print($click_url); ?>";
		var fetch_url = "<?php Print($fetch); ?>";
		var pintereset = "<?php Print($fetch_url_pinterest); ?>";
        videoPlayer = $("#"+videoidqw).Video({
            autoplay:false,
            autohideControls:4,
            videoPlayerWidth:400,
            videoPlayerHeight:250,
            posterImg:thumb,
            fullscreen_native:false,
            fullscreen_browser:true,
            restartOnFinish:false,            
            rightClickMenu:true,
            
            share:[{
                show:true,
                facebookLink:"https://www.facebook.com/sharer/sharer.php?u="+fetch_url,
                twitterLink:"https://twitter.com/intent/tweet?source=webclient&text="+fetch_url,                
                pinterestLink:"http://pinterest.com/pin/create/bookmarklet/?media=" + pintereset,
                linkedinLink:"http://www.linkedin.com/cws/share?url="+fetch_url,
                googlePlusLink:"https://plus.google.com/share?url="+fetch_url,
                deliciousLink:"https://delicious.com/post?url="+fetch_url
            }],
            logo:[{
                show:false,
                clickable:true,
                path:"images/logo/logo.png",
                goToLink:"http://codecanyon.net/",
                position:"top-right"
            }],
             embed:[{
                show:false,
                embedCode:'<iframe src="www.yoursite.com/player/index.html" width="746" height="420" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>'
            }],
            videos:[{
                id:"0",
                title:"Oceans",
                mp4:mp4videopath,
                webm:webmvideopath,
                ogv:oggvideopath,
                info:desc1,

                popupAdvertisementShow:false,
                popupAdvertisementClickable:false,
                popupAdvertisementPath:"images/advertisement_images/ad2.jpg",
                popupAdvertisementGotoLink:"http://codecanyon.net/",
                popupAdvertisementStartTime:"00:02",
                popupAdvertisementEndTime:"00:10",

                videoAdvertisementShow:adsFlag,
                videoAdvertisementClickable:true,
                videoAdvertisementGotoLink:click_url,
                videoAdvertisement_mp4:adsmp4videopath,
                videoAdvertisement_webm:adswebmvideopath,
                videoAdvertisement_ogv:adsoggvideopath
            }]
        });

    

  </script>

  <br/>
  <span class="sttime"  > <h3><?php echo $row['description']; ?></h3></span>
  
 
<?php }?>
</div>

<div id="stexpandbox">
<div id="stexpand<?php echo $msg_id;?>"></div>
</div><!--End stexpandbox div	--> 

<div><span class="sttime" title="<?php echo date($time);?>"><?php echo time_stamp($time);?></span>
<br />
<!-- LIke users display panel -->
<?php 

$post_like_sql = mysqli_query($con, "SELECT * FROM bleh WHERE remarks='". $row['messages_id'] ."'");
$post_like_count = mysqli_num_rows($post_like_sql);

$post_like_sql1 = mysqli_query($con, "SELECT m.active,m.username,m.member_id FROM bleh b, members m WHERE m.active != 1 AND m.member_id=b.member_id AND b.remarks='".$row['messages_id']."' AND b.member_id='".$_SESSION['SESS_MEMBER_ID']."'");
$post_like_count1 = mysqli_num_rows($post_like_sql1);

if($post_like_count1==1)
{
$post_like_sql2 = mysqli_query($con, "SELECT m.username,m.active,m.member_id FROM bleh b, members m WHERE m.active != 1 AND m.member_id=b.member_id AND b.remarks='".$row['messages_id']."' AND b.member_id!='".$_SESSION['SESS_MEMBER_ID']."' LIMIT 2");
$plike_count = mysqli_num_rows($post_like_sql2);
$new_plike_count=$post_like_count-2; 

}
else
{
$post_like_sql2 = mysqli_query($con, "SELECT m.username,m.active,m.member_id FROM bleh b, members m WHERE m.active != 1 AND m.member_id=b.member_id AND b.remarks='".$row['messages_id']."' LIMIT 3");
$plike_count = mysqli_num_rows($post_like_sql2);
$new_plike_count=$post_like_count-3; 

}
?>
<div class="commentPanel" id="likes<?php echo $row['messages_id'];?>" style="display:<?php if($post_like_count <= 0) { echo 'none'; } else { echo 'block'; }?>">
<?php 

if($post_like_count1==1)
{?><span id="you<?php echo $row['messages_id'];?>"><?php echo $lang['You'];?><?php if($post_like_count>1)
echo ','; ?> </span><?php
}
?>

<input type="hidden"  value="<?php echo $post_like_count; ?>" id="commacount<?php echo $row['messages_id'];?>" >
<?php

$i = 0;
while($post_like_res = mysqli_fetch_array($post_like_sql2)){
$i++; 	  
?>

<a href="<?php echo $base_url.$post_like_res['username'];?>" id="likeuser<?php echo $row['messages_id'];?>"><?php echo $post_like_res['username']; ?></a>
<?php if($i <> $plike_count) { echo ',';}

} 
if($post_like_count > 3){
?>
 <?php echo $lang['and'];?><a href="likes.php?id=<?php echo $row['messages_id'];?>" class="show_cmt_linkClr" data-toggle="modal" data-target="#likemodal"> <span id="plike_count<?php echo $row['messages_id'];?>" class="pnumcount"><?php echo $new_plike_count;?></span> <?php echo $lang['others'];?></a><?php } ?> <?php echo $lang['like this'];?>.</div> 

<!-- LIke users display panel -->


<!--Dislike users display panel-->
<?php 

$sql1 = mysqli_query($con, "SELECT * FROM post_dislike WHERE msg_id='". $row['messages_id'] ."'") or die(mysqli_error($con));
$dislike_count = mysqli_num_rows($sql1);
 
$query1=mysqli_query($con, "SELECT m.username,m.active,m.member_id FROM post_dislike b, members m WHERE m.active != 1 AND m.member_id=b.member_id AND b.msg_id='".$row['messages_id']."' LIMIT 3");
$dislike = mysqli_num_rows($query1);
?>

<span class="commentPanel" id="postdislike_container<?php echo $row['messages_id'];?>" style="display:<?php if($dislike_count <= 0) { echo 'none'; } else { echo 'block'; }?>">
<span id="postdislikecount<?php echo $row['messages_id'];?>">
<?php
echo $dislike_count;
?>
</span>
<?php echo $lang['Person Dislike this'];?>
</span>

</div> <!-- End of timestamp div -->
<?php
$query1  = mysqli_query($con, "SELECT * FROM postcomment WHERE msg_id=" . $row['messages_id'] . " ORDER BY comment_id DESC");
$records = mysqli_num_rows($query1);
$s = mysqli_query($con, "SELECT * FROM postcomment WHERE msg_id=" . $row['messages_id'] . " ORDER BY comment_id DESC limit 4,$records");
$y = mysqli_num_rows($s);
if ($records > 4)
{
	$collapsed = true;?>
    <input type="hidden" value="<?php echo $records?>" id="totals-<?php  echo $row['messages_id'];?>" />
	<div class="commentPanel" id="collapsed-<?php  echo $row['messages_id'];?>" align="left">
	<img src="images/cicon.png" style="float:left;" alt="" />
	<a href="javascript: void(0)" class="ViewComments" id="<?php echo $row['messages_id'];?>">
	<?php echo $lang['View'];?> <?php echo $y;?> <?php echo $lang['more comments'];?> 
	</a>
	<span id="loader-<?php  echo $row['messages_id']?>">&nbsp;</span>
	</div>
<?php
}
?>


<div class="commentcontainer" id="commentload<?php echo $row['messages_id'];?>">

<?php
$comment1234  = mysqli_query($con, "SELECT * FROM postcomment p,members m  WHERE p.post_member_id=m.member_id and p.msg_id=" . $row['messages_id'] . " ORDER BY comment_id desc limit 0,4");
$result_arr = array();
$loop=0;
while($row1234 = mysqli_fetch_array($comment1234))
{

    $result_arr[] = $row1234['comment_id'];
}
 $loop_count=count($result_arr);
for($loop=$loop_count-1;$loop>=0;$loop--)
{
 $result_arr[$loop];
//}

//$comment  = mysqli_query($con, "SELECT * FROM postcomment p,members m  WHERE p.post_member_id=m.member_id and p.msg_id=" . $row['messages_id'] . " ORDER BY //comment_id  desc limit 0,4");
$comment  = mysqli_query($con,"SELECT * FROM postcomment p,members m  WHERE p.post_member_id=m.member_id and p.msg_id=" . $row['messages_id'] . " and p.comment_id='".$result_arr[$loop]."'");
$row1 = mysqli_fetch_assoc($comment);
//while($row1 = mysqli_fetch_assoc($comment))
//{
$re_memb_id=$row1['member_id'];
	
	$block=mysqli_query($con, "select * from blocklist where userid='$re_memb_id' and blocked_userid='$member_id' ");
	$block_count = mysqli_num_rows($block);
if($block_count==0 && $row1['active']==0)
{
	
?>
<div class="stcommentbody" id="stcommentbody<?php echo $row1['comment_id']; ?>">
<div class="stcommentimg">
<a href="<?php echo $base_url.$row['username'];?>"><img src="<?php echo $base_url.$row1['profImage']; ?>" class='small_face'/></a>
</div> 
<div class="stcommenttext">
<?php 
if($_SESSION['SESS_MEMBER_ID'] == $row1['member_id'])
{
?>
<a class="stcommentdelete" href="#" id='<?php echo $row1['comment_id']; ?>' title='<?php echo $lang['Delete Comment'];?> '></a>
<?php } ?>
<a href="<?php echo $base_url.$row1['username'];?>"><b><?php echo $row1['username']; ?></b> </a>
<br />
<?php 
if($row1['type']==1){ 


if(isset($_SESSION['lang'])&&($_SESSION['lang']<>"en"))
	{	
		
		$sql = mysqli_query($con, "select * from postcomment1 where msg_id='".$row1['comment_id']."' and tr_id='".$_SESSION['lang']."'")or die(mysqli_error($con));
$r_count = mysqli_num_rows($sql);
//echo $r_count;
if($r_count>0)
{
$row_comment = mysqli_fetch_assoc($sql);

	echo $row_comment['message'];

}
	
	else
	{
			include "test8.php";
		
	}
	$sql1 =  mysqli_query($con, "select * from postcomment1 where msg_id='".$row1['comment_id']."' and tr_id='".$_SESSION['lang']."'")or die(mysqli_error($con));
$r_count1 = mysqli_num_rows($sql1);
	if($r_count1==0)
{



	echo $row1['content'];

}		
	}
	
	else
	{
		echo $row1['content']; ;
		
	}
	?>
	
	<div id="translatemenu<?php echo $row1['comment_id'];?>" class="translatemenu" style="display:none; position:absolute;margin-left: 34%; "> <select id="langs<?php echo $row1['comment_id'];?>" class="langs" onchange="selectOption(this.value, <?php echo $row1['comment_id'];?>,1,'<?php 
if(isset($_SESSION['lang']))
{
echo $_SESSION['lang'];
}
else
{
 echo 'en';
 }?>')">
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

$comment_like_query1 = mysqli_query($con, "SELECT m.username,m.active,m.member_id FROM comment_like c, members m WHERE m.active != 1 AND m.member_id=c.member_id 
AND c.comment_id='".$row1['comment_id']."' AND c.member_id='".$_SESSION['SESS_MEMBER_ID']."' ");
$comment_like_res1 = mysqli_num_rows($comment_like_query1);
if($comment_like_res1==1)
{
$comment_like_query = mysqli_query($con, "SELECT m.username,m.active,m.member_id FROM comment_like c, members m WHERE m.active != 1 AND m.member_id=c.member_id 
AND c.comment_id='".$row1['comment_id']."' AND c.member_id!='".$_SESSION['SESS_MEMBER_ID']."' LIMIT 2");
$clike_count = mysqli_num_rows($comment_like_query);
$new_clike_count=$comment_like_count-2; 
}
else
{
$comment_like_query = mysqli_query($con, "SELECT m.username,m.active,m.member_id FROM comment_like c, members m WHERE m.active != 1 AND m.member_id=c.member_id 
AND c.comment_id='".$row1['comment_id']."' LIMIT 3");
$clike_count = mysqli_num_rows($comment_like_query);
$new_clike_count=$comment_like_count-3; 
}

?>
<div class="clike" id="clike<?php echo $row1['comment_id'];?>" style="display:<?php if($comment_like_count <= 0) { echo 'none'; } else { echo 'block'; }?>">
<?php 

if($comment_like_res1==1)
{?><span id="you<?php echo $row1['comment_id'];?>"><?php echo $lang['You'];?> <?php if($comment_like_count>1)
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

<a href="<?php echo $base_url.$comment_like_res['username']; ?>" id="likeuser<?php echo $row1['comment_id'];?>"><?php echo $comment_like_res['username']; ?></a>
<?php
	
if($i <> $clike_count) { echo ',';}
 
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

$cdquery1 = mysqli_query($con, "SELECT m.username,m.active,m.member_id FROM comment_dislike c, members m WHERE m.active != 1 AND m.member_id=c.member_id 
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
	echo '<a href="javascript: void(0)" class="comment_like show_cmt_linkClr" id="comment_like'.$row1['comment_id'].'" msg_id = '.$row['messages_id'].' title="'.$lang['Unlike'].'" rel="Unlike">'.$lang['Unlike'].'</a>';
} 
else 
{ 
	echo '<a href="javascript: void(0)" class="comment_like show_cmt_linkClr" id="comment_like'.$row1['comment_id'].'" msg_id = '.$row['messages_id'].' title="'.$lang['Like'].'" rel="Like">'.$lang['Like'].'</a>';
}
?>

</span>
<!-- End of like button -->
<!-- Dislike button -->
<span style="top:2px; padding-left:2px;">
<span class="mySpan_dot_class"> · </span>
<?php
$cdquery1 = "SELECT * FROM comment_dislike WHERE comment_id='". $row1['comment_id'] ."' and member_id = '".$member_id."'";
$cdsql1  = mysqli_query($con, $cdquery1) or die(mysqli_error($con));
$comment_dislike_count1 = mysqli_num_rows($cdsql1);
if($comment_dislike_count1 > 0) {
echo '<a href="javascript: void(0)" class="comment_dislike show_cmt_linkClr" id="comment_dislike'.$row1['comment_id'].'" title="'.$lang['dislike'].'" rel="disLike">'.$lang['dislike'].'</a>';
} else {
echo '<a href="javascript: void(0)" class="comment_dislike show_cmt_linkClr" id="comment_dislike'.$row1['comment_id'].'" title="'.$lang['Undislike'].'" rel="disLike">'.$lang['Undislike'].'</a>';
}
?>

</span> 
<!-- End of dislike  button -->
<!-- Reply Button -->
<span style="top:2px; margin-left:2px;">
<span class="mySpan_dot_class"> · </span>
<a href="" id="<?php echo $row1['comment_id'];?>" class="replyopen show_cmt_linkClr"><?php echo $lang['Reply'];?></a>

</span>
<!-- <?php if($row1['type']==1){?><span style="top:2px; left:3px;"><a class="translatebutton" onclick="translateSourceTarget(<?php echo $row1['comment_id'];?>);" href="javascript:void(0)" >Translate </a> </span><?php } ?> -->

<?php if($row1['type']==1)
{ ?>



<span style="top:2px; margin-left:2px;" >
<span class="mySpan_dot_class"> · </span>
 <a class="translateButton show_cmt_linkClr" href="javascript:void(0);" id="translateButton<?php echo $row1['comment_id'];?>"  ><?php echo  $lang['Translate'];?></a>

</span>

       
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

$repl_memb_id=$reply_res['member_id'];
	
	$block=mysqli_query($con, "select * from blocklist where userid='$repl_memb_id' and blocked_userid='$member_id' ");
	$block_count = mysqli_num_rows($block);
if($block_count==0 && $reply_res['active']==0)
{	
?>
<div class="streplybody" id="streplybody<?php echo $reply_res['reply_id']; ?>">
<div class="stcommentimg">
<a href="<?php echo $base_url.$row['username'];?>"><img src="<?php echo $base_url.$reply_res['profImage']; ?>" class='small_face'/></a>
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
 <br />	 
<?php
 }
   ?> 
 
<br />	 
<?php 
if(isset($_SESSION['lang'])&&($_SESSION['lang']<>"en"))
	{	
		
		$sql = mysqli_query($con, "select * from comment_reply1 where msg_id='".$reply_res['reply_id']."' and tr_id='".$_SESSION['lang']."'")or die(mysqli_error($con));
$r_count = mysqli_num_rows($sql);
if($r_count>0)
{
$row_comment = mysqli_fetch_assoc($sql);


	echo $row_comment['message'];

}
	
	else
	{
		
	include "test7.php";
		
	}
	$sql1 = mysqli_query($con, "select * from comment_reply1 where msg_id='".$reply_res['reply_id']."' and tr_id='".$_SESSION['lang']."'")or die(mysqli_error($con));
$r_count1 = mysqli_num_rows($sql1);
	if($r_count1==0)
{



	echo $reply_res['content'];

}		
	}
	
	else
	{
		echo $reply_res['content'];
		
	}
	


?>
<div class="replytarget" style="font:bold;" id="replytarget<?php echo $reply_res['reply_id'];?>"></div>


<div class="streplytime"><?php time_stamp($reply_res['date_created']); ?></div><div tabindex="1" id="replytranslatemenu<?php echo $reply_res['reply_id'];?>" class="replytranslatemenu" style="display:none; position:absolute;margin-left: 34%; "> <select id="replylangs<?php echo $reply_res['reply_id'];?>" class="postlangs" onchange="selectOption(this.value, <?php echo $reply_res['reply_id'];?>,3,'<?php 
if(isset($_SESSION['lang']))
{
echo $_SESSION['lang'];
}
else
{
 echo 'en';
 }?>')">
            <option value=""><?php echo $lang['select language'];?></option> 
            </select>
            </div> 
<span style="padding-left:5px;">
<!--like block-->
<div><br>
<?php
$reply_like_query = mysqli_query($con, "SELECT * FROM reply_like WHERE reply_id='". $reply_res['reply_id'] ."'");
$reply_like_count = mysqli_num_rows($reply_like_query);

$reply_like_query1 = mysqli_query($con, "SELECT m.username,m.active,m.member_id 
								  FROM reply_like c, members m 
								  WHERE m.active != 1 
								  AND m.member_id = c.member_id 
								  AND c.reply_id = '".$reply_res['reply_id']."' 
								  AND c.member_id = '".$_SESSION['SESS_MEMBER_ID']."' ");
$reply_like_count = mysqli_num_rows($reply_like_query1);
if($reply_like_count == 1)
{
$reply_like_query2 = mysqli_query($con ,"SELECT m.username,m.active,m.member_id 
								  FROM reply_like c, members m 
								  WHERE m.active != 1
								  AND m.member_id=c.member_id 
								  AND c.reply_id='".$reply_res['reply_id']."' 
								  AND c.member_id!='".$_SESSION['SESS_MEMBER_ID']."' LIMIT 2");
$rlike_count = mysqli_num_rows($reply_like_query2);
$new_rlike_count = $reply_like_count - 2; 
}
else
{
$reply_like_query2 = mysqli_query($con, "SELECT m.username,m.active,m.member_id 
                                 FROM reply_like c, members m 
								 WHERE m.active != 1 AND m.member_id=c.member_id 
								 AND c.reply_id='".$reply_res['reply_id']."' LIMIT 3");
$rlike_count = mysqli_num_rows($reply_like_query2);
$new_rlike_count=$reply_like_count - 3; 
}

?>
<div class="rlike" id="rlike<?php echo $reply_res['reply_id'];?>" style="display:<?php if($reply_like_count <= 0) { echo 'none'; } else { echo 'block'; }?>">
<?php 

if($reply_like_count == 1)
{?><span id="you<?php echo $reply_res['reply_id'];?>"><?php echo $lang['You'];?><?php if($reply_like_count>1)
echo ','; ?> </span><?php
}

?>

<input type="hidden"  value="<?php echo $reply_like_count; ?>" id="rcommacount<?php echo $reply_res['reply_id'];?>" >
<?php

$i = 0;
while($reply_like_res = mysqli_fetch_array($reply_like_query2)) {
$i++; 	  
?>

<a href="<?php echo $base_url.$reply_like_res['username']; ?>" id="likeuser<?php echo $reply_res['reply_id'];?>"><?php echo $reply_like_res['username']; ?></a>
<?php
	
if($i <> $rlike_count) { echo ',';}
 
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

$rdquery1 = mysqli_query($con, "SELECT m.username,m.active,m.member_id FROM comment_dislike c, members m WHERE m.active != 1 AND m.member_id=c.member_id 
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
	echo '<a href="javascript: void(0)" class="reply_like show_cmt_linkClr" id="reply_like'.$reply_res['reply_id'].'"  title="'.$lang['Unlike'].'" rel="Unlike">'.$lang['Unlike'].'</a>';
} 
else 
{ 
	echo '<a href="javascript: void(0)" class="reply_like show_cmt_linkClr" id="reply_like'.$reply_res['reply_id'].'"  title="'.$lang['like'].'" rel="Like">'.$lang['like'].'</a>';
}
?>
</span>
<!-- End of like button -->
<!-- Dislike button -->
<span style="top:2px; padding-left:5px;">
<span class="mySpan_dot_class"> · </span>
<?php
$reply_dislike_query = "SELECT dislike_reply_id FROM reply_dislike WHERE reply_id='". $reply_res['reply_id'] ."' and member_id = '".$member_id."'";
$reply_dislike_sql  = mysqli_query($con, $reply_dislike_query) or die(mysqli_error($con));
$reply_dislike_count = mysqli_num_rows($reply_dislike_sql);
if($reply_dislike_count > 0) {
echo '<a href="javascript: void(0)" class="reply_dislike show_cmt_linkClr" id="reply_dislike'.$reply_res['reply_id'].'" title="'.$lang['dislike'].'" rel="disLike">'.$lang['dislike'].'</a>';
} else {
echo '<a href="javascript: void(0)" class="reply_dislike show_cmt_linkClr" id="reply_dislike'.$reply_res['reply_id'].'" title="'.$lang['Undislike'].'" rel="disLike">'.$lang['Undislike'].'</a>';
}
?>
</span> 
<!-- End of dislike  button -->
<!-- Reply Button -->
<span style="top:2px; margin-left:5px;">
<span class="mySpan_dot_class"> · </span>
<a href="" id="<?php echo $reply_res['reply_id'];?>" class="reply-replyopen show_cmt_linkClr"><?php echo $lang['Reply']; ?></a>

</span>
<span style="top:2px; margin-left:3px;" >
<span class="mySpan_dot_class"> · </span>
 <a class="replytranslateButton show_cmt_linkClr" href="javascript:void(0);" id="replytranslateButton<?php echo $reply_res['reply_id'];?>"  ><?php echo $lang['Translate']; ?></a>

</span>





            
<textarea class="replysource" id="replysource<?php echo $reply_res['reply_id'];?>"  style="display:none;"><?php echo $reply_res['content'];?></textarea>
<div class="replytarget" style="font:bold;" id="replytarget<?php echo $reply_res['reply_id'];?>"></div>


<?php if($row1['type']==1)
{ ?>

       
<?php 
} ?>

</div><!--End streplytext div-->
<!--reply@reply-->
<div class="replycontainer" style="margin-left:40px;" id="reply-reply-load<?php echo $reply_res['reply_id'];?>">
<?php
$reply_r_sql  = mysqli_query($con, "SELECT m.username,m.active,m.member_id,m.profImage,
						   a.content, a.date_created,a.id
						   FROM reply_reply a 
						   LEFT JOIN members m ON a.member_id = m.member_id 
						   WHERE reply_id=" . $reply_res['reply_id'] . " 
						   ORDER BY id DESC limit 0,2");

while($reply_r_res = mysqli_fetch_assoc($reply_r_sql))
{
$repl_r_memb_id=$reply_r_res['member_id'];
	
	$block=mysqli_query($con, "select * from blocklist where userid='$repl_r_memb_id' and blocked_userid='$member_id' ");
	$block_count = mysqli_num_rows($block);
if($block_count==0 && $reply_r_res['active']==0)
{
?>
<div class="reply-reply-body" id="reply-reply-body<?php echo $reply_r_res['id']; ?>">
<div class="stcommentimg">
<a href="<?php echo $base_url.$reply_r_res['username'];?>"><img src="<?php echo $base_url.$reply_r_res['profImage']; ?>" class='small_face'/></a>
</div>

<div class="reply-reply-text">
 <?php 
if($_SESSION['SESS_MEMBER_ID'] == $reply_r_res['member_id'])
{
?>
<a class="reply-reply-delete" href="#" id='<?php echo $reply_r_res['id']; ?>' title='<?php echo $lang['Delete Reply']; ?>'></a>
<?php } ?>
<a href="<?php echo $base_url.$reply_r_res['username'];?>"><b><?php echo $reply_r_res['username']; ?> 
 
 </b></a>
<?php 
 
 if($reply_res['member_id'] <> $reply_r_res['member_id'])
 {
	 echo '@'; 
	?> <a href="<?php echo $base_url.$reply_res['username'];?>"><b><?php echo $reply_res['username']; ?> 
 
 </b></a>
 <br />	 
<?php
 }
?> 
 <br />	

<?php 
if(isset($_SESSION['lang'])&&($_SESSION['lang']<>"en"))
	{	
		
		$sql = mysqli_query($con, "select * from reply_reply1 where msg_id='".$reply_r_res['id']."' and tr_id='".$_SESSION['lang']."'")or die(mysqli_error($con));
$r_count = mysqli_num_rows($sql);
if($r_count>0)
{
$row_reply_reply = mysqli_fetch_assoc($sql);


	echo $row_reply_reply['message'];

}
	
	else
	{
		
include "test6.php";
		
	
		
	}
	$sql1 = mysqli_query($con, "select * from reply_reply1 where msg_id='".$reply_r_res['id']."' and tr_id='".$_SESSION['lang']."'")or die(mysqli_error($con));
$r_count1 = mysqli_num_rows($sql1);
	if($r_count1==0)
{



	echo $reply_r_res['content'];

}	
	}
	
	else
	{
		echo $reply_r_res['content'];
		
	}
?>
<div class="streplytime"><?php time_stamp($reply_r_res['date_created']); ?></div>

</div><!--End reply-reply div-->
<!--reply@reply-->

</div><!--End streplybody div-->
<?php } }?>
</div>
<!--Start replyupdate -->
<div class="reply-reply-update" style='display:none' id='reply-reply-update<?php echo $reply_res['reply_id'];?>'>
<div class="streplyimg">
<img src="<?php echo $base_url.$member_dres['profImage'];?>" class='small_face'/>
</div>

<div class="reply-reply-text" >
<form method="post" action="">
<textarea name="reply" class="reply-reply" id="reply-reply<?php echo $reply_res['reply_id'];?>"></textarea>
<br /> 
<input type="submit" abcd="<?php echo $reply_res['member_id']; ?>"  title="<?php echo $reply_res['username']; ?>" value="<?php echo $lang['Reply'];?>"  id="<?php echo $reply_res['reply_id'];?>" class="reply-reply reply_reply_button"/>
<input type="button"  value=" <?php echo $lang['Cancel'];?>"  onclick="closereplyreply('reply-reply-update<?php echo $reply_res['reply_id'];?>')" class="cancel"/>
</form>
</div>
</div>
<!--End replyupdate div	--> 
</div><!--End streplybody div-->
<?php }}
?>

<!--Start replyupdate -->
<div class="replyupdate" style='display:none' id='replybox<?php echo $row1['comment_id'];?>'>
<div class="streplyimg">
<img src="<?php echo $base_url.$member_dres['profImage'];?>" class='small_face'/>
</div>

<div class="streplytext" >
<form method="post" action="">
<textarea name="reply" class="reply"  id="rtextarea<?php echo $row1['comment_id'];?>"></textarea>
<br /> 
<input type="submit" abcd="<?php echo $row1['member_id']; ?>"  title="<?php echo $row1['username']; ?>" value="OK"  id="<?php echo $row1['comment_id'];?>" class="reply_button"/>
<input type="button"  value=" <?php echo $lang["Cancel"];?> "  id="<?php echo $row['messages_id'];?>" onclick="closereply('replybox<?php echo $row1['comment_id'];?>')" class="cancel"/>
</form>
</div>
</div>
<!--End replyupdate div	--> 
</div><!--End replycontainer div-->
</div>
<?php } }
$q = mysqli_query($con, "SELECT * FROM bleh WHERE member_id='". $_SESSION['SESS_MEMBER_ID'] ."' and remarks='".$row['messages_id']."' ");
?>

</div><!--End commentcontainer div--> 

<div class="commentupdate" style='display:none' id='commentbox<?php echo $row['messages_id'];?>'>
<div class="stcommentimg">
<img src="<?php echo $base_url.$member_dres['profImage'];?>" class='small_face'/>
</div>

<div class="stcommenttext" >
<form method="post" action="">
<textarea name="comment" class="comment" id="ctextarea<?php echo $row['messages_id'];?>"></textarea>
<!--code for smiley-->
<input type="hidden" id="currentid" value="<?php echo $row['messages_id'];?>" />

<a herf="javascript:void(0)" style="cursor:pointer;" onclick="showsmiley(this.id)" id="<?php echo $row['messages_id'];?>"><img src="images/Glad.png" style="height: 17px; width: 17px;"></a>
<!--code for smiley-->


<input type="submit"  value="<?php echo $lang['Comment'];?>"  id="<?php echo $row['messages_id'];?>" class="button22 cancel"/>



<!--<input type="submit"  value=" Comment "  id="<?php echo $row['messages_id'];?>" class="button"/>!-->
<input type="button"  value=" <?php echo $lang["Cancel"];?> "  id="<?php echo $row['messages_id'];?>" onclick="cancelclose('commentbox<?php echo $row['messages_id'];?>')" class="cancel"/>

</form>
</div>
</div><!--End commentupdate div	--> 
<div class="commentupdate" style='display:none' id='reportbox<?php echo $row['messages_id'];?>'>
<div class="stcommentimg">
<img src="<?php echo $base_url.$member_dres['profImage'];?>" class='small_face'/>
</div>

<div class="stcommenttext" >
<form method="post" action="">
<textarea name="comment" class="comment" maxlength="200"  id="rptextarea<?php echo $row['messages_id'];?>" placeholder="<?php echo $lang['Flag this status'];?>.."></textarea>
<br />
<input type="submit"  value=" <?php echo $lang['Report'];?>"  id="<?php echo $row['messages_id'];?>" class="report"/>
<input type="button"  value=" <?php echo $lang['Cancel'];?>"  id="<?php echo $row['messages_id'];?>" onclick="canclose('reportbox<?php echo $row['messages_id'];?>')" class="cancel"/>
</form>
</div>
</div><!--End commentupdate div	-->
 
<div class="emot_comm">

    
    
	
    
	<span class="show-cmt">
 <?php
	if(mysqli_num_rows($q) > 0)
	{
		echo '<a href="javascript: void(0)" class="like show_cmt_linkClr" id="like'.$row['messages_id'].'" title="'.$lang['Unlike'].'" rel="Unlike">'.$lang['Unlike'].' </a>';
	} 

	else 
	{ 
		echo '<a href="javascript: void(0)" class="like show_cmt_linkClr" id="like'.$row['messages_id'].'" title="'.$lang['Like'].'" rel="Like">'.$lang['Like'].'</a>';
	}
	
?>

</span>

<span class="show-cmt">
<span class="mySpan_dot_class"> · </span>
 <?php
 $pdislikequery = "SELECT dislike_id FROM post_dislike WHERE member_id='$member_id'";
 $pdislikesql = mysqli_query($con, $pdislikequery);
 
 
	if(mysqli_num_rows($pdislikesql) > 0)
	{
		echo '<a href="javascript: void(0)" class="post_dislike show_cmt_linkClr" id="post_dislike'.$row['messages_id'].'" title="'.$lang['dislike'].'" rel="disLike">'.$lang['dislike'].'</a>';
	} 

	else 
	{ 
		echo '<a href="javascript: void(0)" class="post_dislike show_cmt_linkClr" id="post_dislike'.$row['messages_id'].'" title="'.$lang['Undislike'].'" rel="disLike">'.$lang['Undislike'].'</a>';
	}
	
?>

</span>


<span class="show-cmt">
<span class="mySpan_dot_class"> · </span>
<a href="javascript:void(0)" id="<?php echo $row['messages_id'];?>" class="commentopen show_cmt_linkClr"><?php echo $lang['Comment'];?></a>

</span>

<span class="show-cmt">
<span class="mySpan_dot_class"> · </span>
<a href="javascript:void(0)" rowtype="<?php echo $row['type'];?>" class="share_open show_cmt_linkClr" id="<?php echo $row['messages_id'];?>" title="<?php echo $lang['Share'];?>"><?php echo $lang['Share'];?></a>

</span>

<span class="show-cmt">
<span class="mySpan_dot_class"> · </span>
<a href="javascript:void(0)" id="<?php echo $row['messages_id'];?>" class="flagopen show_cmt_linkClr"><?php echo $lang['Flag this Status'];?></a>

</span>

<?php if($row['type']==0)
 {
	 if(substr($row['messages'],0,4) != 'http' )
{ ?>
<span style="top:2px; left:3px;" >
<span class="mySpan_dot_class"> · </span>
<a class="posttranslateButton show_cmt_linkClr" href="javascript:void(0);" id="posttranslateButton<?php echo $row['messages_id'];?>"  ><?php echo $lang['Translate'];?></a>
</span>
<?php } } ?>
</div>

</div><!--End sttext div	--> 
</div><!--End stbody div	-->

<?php

}}

?> 