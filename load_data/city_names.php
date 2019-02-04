<?php
include_once("../config.php");

	$q = mysqli_real_escape_string($con, f($_GET["findword"],'escapeAll'));
    $q = strtolower($q);    
    $query = mysqli_query($con, "select distinct city_title from geo_city where city_title like '%$q%'") or die(mysqli_error($con));
    while ($row = mysqli_fetch_array($query))
	{
		echo $row['city_title']."\n";		
 }
	
?>