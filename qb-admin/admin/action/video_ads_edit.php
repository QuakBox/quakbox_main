<?php 
ob_start();
session_start();

include('../config.php');
$id = $_POST['id'];
$title = $_POST['title'];
$status = $_POST['published'];
$click_url = $_POST['click_url'];

$vquery = "UPDATE videos_ads SET ads_name = '$title',published = '$status' ,click_url = '$click_url'
           WHERE id = '$id'";

mysqli_query($conn, $vquery) ;?>