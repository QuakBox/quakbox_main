<?php
include_once("../config.php");
  $q = mysqli_real_escape_string(f($_REQUEST['term'],'escapeAll'));
    $q = strtolower($q);
    
    $query = mysqli_query($con, "select distinct working_designation from member_working_history where working_designation like '%$q%'") or die(mysqli_error($con));
    while ($row = mysqli_fetch_array($query))
	{
		echo $row['working_designation']."\n";
		
    }
	
?>