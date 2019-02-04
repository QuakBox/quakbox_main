<?php
include("config.php");

echo $id=$_GET['id'];

mysqli_query($conn,"UPDATE news SET status=0
WHERE news_id=$id") or die(mysqli_error($conn));
header("location:newstable.php");
?>


