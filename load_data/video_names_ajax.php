<?php 

include('../config.php');
$results = array();

$q = htmlspecialchars(trim(f($_REQUEST['term'],'escapeAll')));
    $q = strtolower($q);

$req = "SELECT title FROM videos WHERE title LIKE '$q%' "; 

$query = mysqli_query($con, $req);

while($row = mysqli_fetch_array($query))
{
	$results[] = $row['title'];
}

echo json_encode($results);
?>