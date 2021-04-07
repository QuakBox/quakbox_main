<?php

if(!isset($_SESSION)){
    session_start();
}
if(isset($_SESSION['lang']))
{	
	$lan= $_SESSION['lang'].'.php';
	include($_SERVER['DOCUMENT_ROOT'].'/Languages/'.$lan);
}
else
{
	include($_SERVER['DOCUMENT_ROOT'].'/Languages/en.php');

}
				
?>