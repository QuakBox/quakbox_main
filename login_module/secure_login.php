<?php ob_start();
//Start session
	
	session_start();	
	require_once('config.php');
	require_once('common/qb_log.php');
	error_reporting(-1);
	if(isset($_POST['landing_submit'])){		
	
	//Sanitize the POST values
	$password = $_POST['password'];
	$ip = $_SERVER['REMOTE_ADDR'];
	$redirect = NULL;
	
	/*$query = mysql_query("SELECT salt FROM members WHERE email_id = '$login'");
	$res = mysql_fetch_array($query);	
	$salt = $res['salt'];	*/
	
	$salt = 'e94caf124624035b-89a3ad0e-80f4081b-fc6e0db8-2d2ac3f541b607a749a33ea3';
	
	
	
	// Changed By Yasser Hossam 14/1/2015
	//$passwordOriginal = '53118ac08da87c095457b713e906d4e34f1a560e2bdd43b3351984043973fabc';//qbdevteam@1P0s$wRd
	// 1- original pw after sha256 encryption : 267625da4331a998d4381784900b0795e0734b7d96f795139989d961ec7a6d70
	// 2- concatinate the string "e94caf124624035b-89a3ad0e-80f4081b-fc6e0db8-2d2ac3f541b607a749a33ea3" with the above
	// 3- Encrypt the result again
        
        
        
        // New Easy one By Yasser Hossam 23/2/2016
        // Changed By Yasser Hossam 14/1/2015
	$passwordOriginal = '3333426a2c81286dc0b0fc7d755139c63e326604b9cd3cd7a72761e54e13ed3b';//quakb@dev#
        
	
	
	
	$hash = hash('sha256', $password); 	
	$password = hash('sha256', $salt . $hash);
	
	
	
	
	
       /* if($_POST['location'] != '') {
        $redirect = $_POST['location'];
	}

	//Create query
	 $qry = "SELECT * FROM members WHERE email_id = '$login' AND Password='$password' AND Status_ID=1";
	 $result = mysql_query($qry);	 
	 
	 mysql_query("UPDATE members set lastvisitDate = now(), ip = '$ip' where member_id = '$member_id'");*/
	
	//Check whether the query was successful or not	
		if($passwordOriginal==$password) 
		{		
		    /*if(isset($redirect)) {
                $url = $redirect;
            } else {
				$url = $homepage;
			}
			
			$member = mysql_fetch_assoc($result);
	 $member_id = $member['member_id'];*/
	 
			$_SESSION['EMPLOYEE_ID'] = $ip ;
			unset($_SESSION['value_array_landing']);
            
			unset($_SESSION['protect_landing']);		   
			header("location: ".$site_landing."");
			exit;			
		}
		else 
		{
			/*$_SESSION['value_array_landing'] = $_POST;
         	
			
			if(!$_SESSION['protect_landing'])  {  $_SESSION['protect_landing']=0; } 
			$_SESSION['protect_landing']++;
			if($_SESSION['protect_landing'] > 2) {
				header("location: index.php");
				exit;
			}else {*/
				header("location: index.php?back=".$redirect."");
				exit;
			//}
						
		}
	}