<?php
/**
   * Global Variables
   * Global Variables will be decalared here
   * 
   * @package    common
   * @subpackage 
   * @author     Vishnu
   * Created date  02/05/2015 04:40:05
   * Updated date  02/05/2015 05:00:05
   * Updated by    Vishnu
 **/
   
	$QB_LOGGED_IN_MEMBER_ID=0;
	$QB_LOGGED_IN_MEMBER_USERNAME;
	$QB_MEMBER_IS_LOGGEDIN;
	$QB_LOGGED_IN_MEMBER_TOKEN;
	$QB_LOGGED_IN_MEMBER_ROLE; // FUTURE USE
	
	
	if($QB_LOGGED_IN_MEMBER_ID==0 && isset($_SESSION['SESS_MEMBER_ID']))
	{
		$QB_LOGGED_IN_MEMBER_ID= $QbSecurity->qbClean($_SESSION['SESS_MEMBER_ID'],$con);
		//if (class_exists('QB_Log')) {
		    //$log= new QB_Log();
		    write_log('Member ID assigned to global variable..','1','qb_global_variables.php',$QB_LOGGED_IN_MEMBER_ID);
		//}	
	}
	else{
	 	$QB_LOGGED_IN_MEMBER_ID=0;
	}
	
	
	
	
	
	
	
	
		