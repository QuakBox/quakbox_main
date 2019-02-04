<?php
include_once("connection/qb_database.php");

class ads
{



function view_ads()
{
	$db_Obj = new database(); 
	$sql = "select * from ads order by ads_id DESC LIMIT 10 ";		
	$rs = $db_Obj->execQueryWithFetchAll($sql); 
	return $rs;
}

function select_language_ads_title_byID($adsID,$language){
	$db_Obj = new database(); 
	$sql = "select * from ads_title  where ads_id = '".$adsID."' and  lang = '".$language."'";		
	$rs = $db_Obj->execQueryWithFetchAll($sql); 
	return $rs;
}
function select_language_ads_description_byID($adsID,$language){
	$db_Obj = new database(); 
	$sql = "select * from ads_description  where ads_id = '".$adsID."' and  lang = '".$language."'";		
	$rs = $db_Obj->execQueryWithFetchAll($sql); 
	return $rs;
}

function select_all_ads_like_byID($adsID){
	$db_Obj = new database(); 
	$sql = "SELECT count(ads_like_id) as 'count' from ads_like WHERE ads_id='".$adsID."'";		
	$rs = $db_Obj->execQueryWithFetchAll($sql); 
	return $rs;
}
function select_all_ads_like_byIDandMemberID($adsID,$memberID){
	$db_Obj = new database(); 
	$sql = "SELECT count(ads_like_id) as 'count' from ads_like WHERE ads_id='".$adsID."' and member_id='".$memberID."'";		
	$rs = $db_Obj->execQueryWithFetchAll($sql); 
	return $rs;
}

function insert_ads_like($adsID,$memberID){
	$db_Obj = new database(); 
	$sql = "INSERT INTO ads_like (`ads_id`, `member_id`) VALUES (".$adsID.", ".$memberID.");";		
	$rs = $db_Obj->insertQueryReturnLastID($sql); 
	return $rs;
}
function delete_ads_like($adsID,$memberID){
	$db_Obj = new database(); 
	$sql = "DELETE FROM ads_like WHERE ads_id='".$adsID."' and member_id='".$memberID."'";		
	$rs = $db_Obj->execQuery($sql); 
	return $rs;
}

}

?>