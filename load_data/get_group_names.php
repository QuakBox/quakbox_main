<?php 

include('../config.php');
$q = mysqli_real_escape_string($con, f($_REQUEST['term'],'escapeAll'));
    $q = strtolower($q);
$results = array();
$req = "SELECT g.name FROM groups g inner join groups_members gm on gm.groupid = g.id 
		WHERE name LIKE '$q%' group by g.id "; 

$query = mysqli_query($con, $req);

while($row = mysqli_fetch_array($query))
{
	$results[] = $row['name'];
	
}

echo json_encode($results);
?>