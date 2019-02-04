<?php
include_once("../config.php");
    $q = mysqli_real_escape_string($con, f($_REQUEST['term'],'escapeAll'));
    $q = strtolower($q);
    $return = array();
    $query = mysqli_query($con, "select UserName from members where UserName like '%$q%'") or die(mysqli_error($con));
    while ($row = mysqli_fetch_array($query))
	{
		$return[] = $row['UserName']."\n";
    }
	echo json_encode($return);
?>