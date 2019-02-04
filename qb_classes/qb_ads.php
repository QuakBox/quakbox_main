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

function select_member_information($memberID, $info)
    {
        
        $sql = "SELECT $info FROM member WHERE member_id = '$memberID'  LIMIT 1";
        $db_Obj = new database();
        $results = $db_Obj->execQuery($sql);
        if (mysqli_num_rows($results) == 1) {
            $row = $results->fetch_assoc();
            return $row[$info];
        } else {
            return null;
        }
    }
 
function view_ads_by_meber($dob,$gender,$countories,$state,$city)
{
    $sql1="";
    $dob = new DateTime($dob);
    $today = new DateTime('today');
    $date=$today->format('Y-m-d');
    $age=$dob->diff($today)->y;
   
    
    $sql1.="SELECT * FROM `ads` WHERE ads_pic!=''";   
  if(empty($gender)!=1){
    if($gender==2){
        $gender="male";
		$sql1.=" AND targetgender='$gender'";
    }elseif($gender==3){
        $gender="female";
		$sql1.=" AND targetgender='$gender'";
    }
        
 }
 if(empty($dob)!=1){
	 if($age < 10 ) {
		$sql1.=" AND agelimit='<10'"; 
	 }
	 if($age > 10 && $age < 21) {
		$sql1.=" AND agelimit='>10 && <21'"; 
	 }
	 if($age > 20 && $age < 31 ) {
		$sql1.=" AND agelimit='>20&& <31'"; 
	 }
	 if($age > 30 ) {
		$sql1.=" AND agelimit='>30'"; 
	 }
 }	 
 
 if(empty($countories)!=1){
     $sql1.=" AND targetcountry='$countories'";
 }
 if(empty($state)!=1){
     $sql1.=" AND targetstate='$state'";
 }
 if(empty($city)!=1){
     $sql1.=" AND targetcity='$city'";
 }
 $sql1.=" AND end_date >='$date' order by ads_id DESC LIMIT 10";
 
    if($countories!='' || $state!='' || $city!=''){
		$db_Obj = new database(); 
	$rs = $db_Obj->execQueryWithFetchAll($sql1); 
	return $rs;
               
        }else{
	   $sql1="SELECT * FROM `ads` where ads_pic!='' order by ads_id DESC LIMIT 10";
            $db_Obj = new database(); 
	$rs = $db_Obj->execQueryWithFetchAll($sql1); 
	return $rs;
        }
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