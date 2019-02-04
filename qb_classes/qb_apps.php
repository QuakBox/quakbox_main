<?php
include_once("connection/qb_database.php");

class apps
{

function view_apps()
{
	$sql = "select *from app where status='1' order by id desc limit 10";
	$db_Obj = new database();	
	$rs = $db_Obj->execQueryWithFetchAll($sql); 
	return $rs;
}
			
}



?>