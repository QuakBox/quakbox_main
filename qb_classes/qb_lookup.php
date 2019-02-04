<?php
include_once($_SERVER['DOCUMENT_ROOT']."/qb_classes/connection/qb_database.php");

class lookup
{

function getLookupKey($lookup_category, $lookup_value)
{
	$lookup_category = strtolower($lookup_category);
	$lookup_value = strtolower($lookup_value);
	$sql = "SELECT a.lookup_key FROM qb_lookup a, (select lookup_key from qb_lookup where LOWER(lookup_value)='$lookup_category' ) x where a.lookup_parent= x.lookup_key and LOWER(a.lookup_value)='$lookup_value'";
	$db_Obj = new database();	
	$rs = $db_Obj-> execQuery($sql);
	if(mysqli_num_rows($rs) == 1)
	{
	$row = $rs->fetch_assoc();
	return $row['lookup_key'];	
	}
	else
	{
	return null;
	}	
}

function getValueByKey($lookup_key)
{
	$sql = "SELECT lookup_value FROM qb_lookup where lookup_key ='$lookup_key'";
	$db_Obj = new database();	
	$rs = $db_Obj-> execQuery($sql);
	if(mysqli_num_rows($rs) == 1)
	{
	$row = $rs->fetch_assoc();
	return $row['lookup_value'];	
	}
	else
	{
	return null;
	}		
}

function getKeyByValue($lookup_value)
{
	$lookup_value = strtolower($lookup_value);
	$sql = "SELECT lookup_key FROM qb_lookup where LOWER(lookup_value) ='$lookup_value'";
	$db_Obj = new database();	
	$rs = $db_Obj-> execQuery($sql);
	if(mysqli_num_rows($rs) == 1)
	{
	$row = $rs->fetch_assoc();
	return $row['lookup_key'];	
	}
	else
	{
	return null;
	}		
}

function getParentKey($lookup_key)
{
	$sql = "SELECT lookup_parent FROM qb_lookup where lookup_key ='$lookup_key'";
	$db_Obj = new database();	
	$rs = $db_Obj-> execQuery($sql);
	if(mysqli_num_rows($rs) == 1)
	{
	$row = $rs->fetch_assoc();
	return $row['lookup_parent'];	
	}
	else
	{
	return null;
	}	
}
function getLookupValue($lookup_category)
{
	$lookup_category = strtolower($lookup_category);
	$sql = "SELECT a.lookup_key, a.lookup_value FROM qb_lookup a, (select lookup_key from qb_lookup where LOWER(lookup_value)='$lookup_category' )  x where a.lookup_parent= x.lookup_key ";
	$db_Obj = new database();	
	$rs = $db_Obj-> execQuery($sql);
	return $rs;
		
}

			
}
?>