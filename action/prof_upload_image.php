<?php ob_start();

$member_id = $_POST['uploadedby'];;
include('../config.php');

$file=$_FILES['image']['tmp_name'];
$time 			= 	time();
$ip				=	$_SERVER['REMOTE_ADDR'];

$content_id = clean($_POST['content_id'], $con);
$content_id   = f($content_id, 'strip');
$content_id	 = 	f($content_id, 'escapeAll');
$content_id   = mysqli_real_escape_string($con, $content_id);

	if (!isset($file)) {
	echo "";
	}else{
	$image= addslashes(file_get_contents($_FILES['image']['tmp_name']));
	$image_name= addslashes($_FILES['image']['name']);
	$image_size= getimagesize($_FILES['image']['tmp_name']);

	
		if ($image_size==FALSE) {
		
			echo "That's not an image!";
			
		}else{
			
			move_uploaded_file($_FILES["image"]["tmp_name"],"../uploadedimage/" . $_FILES["image"]["name"]);
			
			$location="uploadedimage/" . $_FILES["image"]["name"];
			//$term=$_POST['term'];
			 $by=$_POST['uploadedby'];
			//$caption=$_POST['caption'];

			 $sql="INSERT INTO message(messages,member_id,content_id,date_created,ip,type) VALUES ('$location','$member_id','$content_id','$time','$ip',1)";
			 
			 //insert into news feeds
		$newwallid = mysqli_insert_id($con);
if(!empty($newwallid)){
 $sqlnfeeds = "INSERT INTO news_feeds ";
        $sqlnfeeds.= "(`date_created`, `msg_id`) ";
        $sqlnfeeds.= "VALUES ";
        $sqlnfeeds.= "('".strtotime(date("Y-m-d H:i:s"))."', '$newwallid') ";
        mysqli_query($con, $sqlnfeeds);
} 

mysqli_query($con, $sql) or die(mysqli_error($con));

			
	}
	}
?> 
<script type="text/javascript">
window.history.back();
</script>