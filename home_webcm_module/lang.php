<?php
session_start();
$lang=$_POST['lang'];
$filename = "Languages/".$lang.".php";
if(file_exists($filename))
$_SESSION['lang']=$lang;
else
$_SESSION['lang']="en";
//echo $_SESSION['lang'];
?>