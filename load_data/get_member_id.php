<?php
include_once("../config.php");
    $q = mysqli_real_escape_string($con, f($_REQUEST['term'],'escapeAll'));
    $q = strtolower($q);
    $return = array();
    $query = mysqli_query($con, "select * from members where UserName='".$q."'") or die(mysqli_error($con));
    while ($row = mysqli_fetch_array($query)) {
		array_push($return,array('member_id'=>$row['member_id']));
    }
	echo (json_encode($return));
?>