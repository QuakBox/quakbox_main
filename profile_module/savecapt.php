<?php
session_start();
ob_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php
//echo "hi";
include('config.php');
$memberid=$_POST['memberid'];
$albumid=$_POST['albumid'];
$id=$_POST['id'];
$caption=$_POST['caption'];
$description=$_POST['editbox_description'];
//echo $id;
echo "update upload_data set caption='$caption',description='$description' where upload_data_id=$id";
mysqli_query($con, "update upload_data set caption='$caption',description='$description' where upload_data_id=$id");
$redir= $base_url."load_album.php?back_page=photos.php&album_id=$albumid&member_id=$memberid";
header("location: ".$redir."");	
exit();
?>
</body>
</html>