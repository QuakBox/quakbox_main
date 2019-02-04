<?php
include("config.php");

echo $id=$_GET['id'];

mysqli_query($conn,"UPDATE videos SET featured=1
WHERE video_id=$id") or die(mysqli_error($conn));
header("location:video.php");
?>


