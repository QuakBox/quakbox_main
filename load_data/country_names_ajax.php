<?php 
include('../config.php');
 $q = mysqli_real_escape_string($con, f($_REQUEST['term'],'escapeAll'));
    $q = strtolower($q);
$results = array();

$req = "SELECT country_title,country_id FROM geo_country WHERE country_title LIKE '%$q%' "; 

$query = mysqli_query($con, $req);

$results = array();
while($row = mysqli_fetch_array($query))
{	
	array_push($results ,array("id"=>$row['country_id'],"value"=>$row['country_title']));
}

echo json_encode($results);

?>