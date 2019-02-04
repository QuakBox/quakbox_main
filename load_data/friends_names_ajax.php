<?php 

	//Start session	
	ob_start();
	session_start();
	//Include database connection details
	require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');
	$member_id = $QbSecurity->qbClean($_SESSION['SESS_MEMBER_ID'], $con);
	//Escape special characters in REQUEST value
	$q = mysqli_real_escape_string($con, f($_REQUEST['term'],'escapeAll'));
	$q = strtolower($q);
	
	$results = array();
	try{
		//Query to fetch name from tables members and friendlist according to value in $q
		$req = "SELECT m.username,m.member_id 
		FROM member m inner join friendlist f on f.member_id = m.member_id 
		WHERE username LIKE '$q%' and f.added_member_id = '$member_id' group by m.member_id "; 

		$query = mysqli_query($con, $req);

		$results = array();
		while($row = mysqli_fetch_array($query))
		{	
			array_push($results ,array("id"=>$row['member_id'],"value"=>$row['username']));
		}

		echo json_encode($results);
	}
	catch(Exception $ex)
	{
		/* General exception error message */
		// write_log($ex->getMessage(),"load_data/friends_names_ajax.php");
	}
?>