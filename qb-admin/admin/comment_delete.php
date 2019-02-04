<?php session_start();

if(isset($_SESSION['id']))
{
	include("config.php");
	
			
			
echo $id1 = $_GET['id'];


$sql="select comment_id from postcomment where msg_id =$id1"; 

$res=mysqli_query($conn,$sql) or die(mysqli_error($conn));
$result = mysqli_fetch_array($res);
$comment_id = $result['comment_id'];

// --------------------------Delete Comment like-----------

$sql1=mysqli_query($conn,"delete From comment_like WHERE msg_id=$id1");

// --------------------------Delete Comment dislike-----------

$sql1=mysqli_query($conn,"delete From comment_dislike WHERE comment_id=$comment_id");

//--------------------------- Delete Comment reply like-------------------

$sql1="select reply_id from comment_reply WHERE comment_id=$comment_id";
$res1=mysqli_query($conn,$sql1) or die(mysqli_error($conn));
$result3 = mysqli_fetch_array($res1);
$sql2=mysqli_query($conn,"delete From reply_like WHERE reply_id=$result3");

//--------------------------- Delete Comment reply like-------------------


$sql2=mysqli_query($conn,"delete From reply_dislike WHERE reply_id=$result3");


// --------------------------Delete Comment reply-----------


$sql1=mysqli_query($conn,"delete From comment_reply WHERE comment_id=$comment_id");

// -------------------------- delete status dislike-----------
$sql1=mysqli_query($conn,"delete From post_dislike WHERE msg_id=$id1");

// -------------------------- delete status like-----------

$sql1=mysqli_query($conn,"delete From bleh WHERE remarks=$id1");

// --------------------------Delete Comment -----------

$sql1=mysqli_query($conn,"delete From postcomment WHERE msg_id=$id1");


// --------------------------Delete Status-----------

$sql1=mysqli_query($conn,"delete From message WHERE messages_id=$id1");

$sql1=mysqli_query($conn,"select reply_id From comment_reply WHERE comment_id=$comment_id");
$result3 = mysqli_fetch_array($sql1);
$sql2=mysqli_query($conn,"delete From reply_like WHERE reply_id=$result3");
$sql2=mysqli_query($conn,"delete From reply_dislike WHERE reply_id=$result3");



header("location:comment_report.php");
}

else
header("Location: login.php");
?>
