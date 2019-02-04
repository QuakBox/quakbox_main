<?php
include_once("../config.php");
 $q = mysqli_real_escape_string($con, f($_GET["findword"],'escapeAll'));
    $q = strtolower($q);
    
    $query = mysqli_query($con, "select distinct country_title from geo_country where country_title like '%$q%'") or die(mysqli_error($con));
    while ($row = mysqli_fetch_array($query))
	{
		echo $row['country_title']."\n";
		
    }
	
?>