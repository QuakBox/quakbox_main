<?php
include("config.php");
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_lookup.php');
$lookupObject = new lookup();
$inactiveID =  $lookupObject->getLookupKey("MEMBER STATUS", "INACTIVE");
 $id=$_GET['id'];
mysqli_query($con, "UPDATE member SET status='$inactiveID'
WHERE member_id=$id") or die(mysqli_error($conn));
header("location:user_table.php");