<?php
include("config.php");
$id=$_GET['id'];

mysqli_query($conn,"UPDATE videos_ads SET published=1
WHERE id=$id") or die(mysqli_error($conn));
header("location:video_ads.php");
?>


