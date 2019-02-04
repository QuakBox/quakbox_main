<?php ob_start();
session_start();
include_once '../config.php';
include_once '../includes/time_stamp.php';

$member_id = $_SESSION['SESS_MEMBER_ID'];
$reply = $_POST['reply'];
$reply	 = 	f($reply, 'escapeAll');
$reply   = mysqli_real_escape_string($con, $reply);

$comment_id = $_POST['comment_id'];
$comment_id	 = 	f($comment_id, 'strip');
$comment_id	 = 	f($comment_id, 'escapeAll');
$comment_id   = mysqli_real_escape_string($con, $comment_id);


$uname = $_POST['uname'];
$uname	 = 	f($uname, 'strip');
$uname	 = 	f($uname, 'escapeAll');
$uname   = mysqli_real_escape_string($con, $uname);


$mem_id = $_POST['mem_id'];
$mem_id	 = 	f($mem_id, 'strip');
$mem_id	 = 	f($mem_id, 'escapeAll');
$mem_id   = mysqli_real_escape_string($con, $mem_id);

mysqli_query($con, "INSERT INTO groups_wall_reply_reply (member_id,reply_id,content, date_created)
VALUES('$member_id','$comment_id','$reply','".strtotime(date("Y-m-d H:i:s"))."')");
//$_SESSION['last_id4']= mysqli_insert_id($con);
$last_id4=mysqli_insert_id($con);

if(isset($_SESSION['lang']))
{
?>
<script>
var lan1="<?php echo $_SESSION['lang'];?>";
var text1="<?php echo $reply ;?>";
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
     
			translate1234(g_token,src,lan);
			
			},    
    });

	
		}
		
function translate1234(g_token,src1,lan)
	{
		 var language=lan;
	
		var src = src1;
		
		var p = new Object;
		
    p.text = src;
    p.from = null;
    p.to = "" + language + "";
    p.oncomplete = 'ajaxTranslate2';
    p.appId = "Bearer " + g_token;
   
    var requestStr = "http://api.microsofttranslator.com/V2/Ajax.svc/Translate";
       $.ajax({
        url: requestStr,
        type: "GET",
        data: p,
        dataType: 'jsonp',
        cache: 'true',
       
		});
	}	
		
	function ajaxTranslate2(response) { 
		
		 document.getElementById("target_tr_rr<?php echo $last_id4;?>").innerHTML = response;

	}
    
    </script>
    <?php
}

$langs=array("","hi","ar","bg","ca","cs","da","nl","et","fi","fr","zh-CHS","zh-CHT","de","el","ht","he","mww","hu","id","it","ja","tlh","ko","lv","lt","ms","mt","no","fa","pl","pt","ro","ru","sk","sl","es","sv","th","tr","uk","ur","vi","cy"," ");

$language="hi";
$i==0;
while($language!=" ")
{
$language=$langs[$i];

?>

<?php  include ("../test_reply_reply.php"); 

$i++;
//echo $language;
}?>


<?php 

$sql = mysqli_query($con, "select * from groups_wall_reply_reply a JOIN members m ON m.member_id = a.member_id where reply_id = '$comment_id' order by id desc");
$res = mysqli_fetch_array($sql);
if ($res)
{
	$com_id = $res['id'];	
	$comment = $res['content'];
	$time = $res['date_created'];
	$username = $res['username'];
	$cface = $res['profImage'];
?>
<div class="reply-reply-body" id="reply-reply-load<?php echo $com_id; ?>">
<div class="streplyimg">
<img src="<?php echo $base_url.$cface; ?>" class='small_face'/>
</div> 
<div class="reply-reply-text">
<a class="reply-reply-delete" href="#" id='<?php echo $com_id; ?>'></a>
<a href="<?php echo $base_url.$username;?>"><b><?php echo $username; ?></b></a> 
<?php if($mem_id != $member_id)
 {
	 echo '@'; 
	?> <a href="<?php echo $base_url.$uname;?>"><b><?php echo $uname; ?> 
 
 </b></a>
	 
<?php
 }
   ?>
 <br />
 <?php 
 
if(isset($_SESSION['lang']))
	{	
		
		?>
        <div id="target_tr_rr<?php echo $last_id4;?>"></div>
        <?php
		
	}
	
	else
	{
		echo $comment;
		
	}
?>
<div class="streplytime"><?php time_stamp($time); ?></div> 
</div>
</div>
<?php
}
sleep(3);
?>
