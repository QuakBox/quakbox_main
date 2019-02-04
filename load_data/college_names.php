<?php
include_once("../config.php");
    $q = mysqli_real_escape_string($con, f($_GET["findword"],'escapeAll'));
    $q = strtolower($q);
    $return = array();
    $query = mysqli_query($con, "select distinct organization_name from qb_country_education_record where organization_name like '%$q%'") or die(mysqli_error($con));
    while ($row = mysqli_fetch_array($query))
	{
		echo $row['organization_name']."\n";
    }
	//echo (json_encode($return));
?>