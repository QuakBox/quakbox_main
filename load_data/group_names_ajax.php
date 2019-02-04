<?php 

/**
   * load_data
   * @subpackage 
   * @author     Vishnu 
   * Created date  02/11/2015 04:40:05
   * Updated date  03/24/2015 05:00:05
   * Updated by    Vishnu S
 **/
 
 	//Start session
	ob_start();
	session_start();
	//Include database connection details
	include('../config.php');

	$member_id = $_SESSION['SESS_MEMBER_ID'];
	//Escape special characters in REQUEST value
	$q = mysqli_real_escape_string($con,f($_REQUEST['term'],'escapeAll'));
	
	$q = strtolower($q);
	
	$results = array();
	try{
		//Query to fetch name from tables members and friendlist according to value in $q
		 
		$req = "SELECT g.name,g.id FROM groups g inner join groups_members gm on gm.groupid = g.id WHERE g.name LIKE '$q%' AND gm.member_id = '".$member_id."' group by g.id ";  

		$query = mysqli_query($con, $req);

		$results = array();
		while($row = mysqli_fetch_array($query))
		{	
			array_push($results ,array("id"=>$row['id'],"value"=>$row['name']));
		}

		echo json_encode($results);
	}
	catch(Exception $ex)
	{
		/* General exception error message */
		// write_log($ex->getMessage(),"load_data/friends_names_ajax.php");
	}
?>