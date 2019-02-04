<?php
include_once($_SERVER['DOCUMENT_ROOT']."/qb_classes/connection/qb_database.php");
class AccessLevel{
	private static $instance = NULL;
	static public function getInstance()
	{
		if (self::$instance === NULL)
			self::$instance = new AccessLevel();
		return self::$instance;
	}
		
	public function __construct(){
		$this->user  = $this->getCurrentUser();	
		$this->getAccessLevels();
	}
	
	public function getCurrentUser(){
		$id = $_SESSION['id'];
		$sql = "SELECT id, username, first_name, last_name, email, status FROM admins WHERE id = '$id'";
		$db_Obj = new database();	
		$results = $db_Obj-> execQueryWithFetchObject($sql);
		return $results;
	}
	
	public function getMemberType(){
		return $this->user->status;
	}
	
	public function isSuperAdmin(){
		return ( $this->getMemberType() == "super admin");
	}
	
	public function getAccessLevels(){
		$sqlQuery = "SELECT module_name, edit_access, delete_access FROM member_accesslevel WHERE member_id ={$this->user->id}";
		$db_Obj = new database();	
		$result = $db_Obj-> execQuery($sqlQuery);
		$this->user->access_levels = array();
		while( $row = mysqli_fetch_object( $result )){
			$this->user->access_levels[$row->module_name]['edit_access'] = $row->edit_access;
			$this->user->access_levels[$row->module_name]['delete_access'] = $row->delete_access;
		}
		//print_r( $this->user->access_levels );
	}
	
	public function isAllowed( $module, $action ){
		if( $this->isSuperAdmin()){
			return true;
		}
		return $this->user->access_levels[$module][$action] == 1;
	}
	
}

?>