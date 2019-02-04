<?php session_start();
include("config.php");
 
if(isset($_POST['submit'])) { 	
	$id2= $_POST['id'];
	  $name = trim($_POST ['name']);
  list( $first_name, $last_name) = explode( " ", $name );
  $password = $_POST ['password'] ;
  $passwordUpdateStr = ""; // if password is empty, we dont update it 
  if( $password != "" ){
	$password = md5( $password );
	$passwordUpdateStr = " password = '$password',";
  }
  
  $cpassword = $_POST ['cpassword'];
  $email = $_POST ['email'];
  $member_type = $_POST ['member_type'];  
  $module = $_POST['module'];

  $updateMemberQuery = "UPDATE  admins SET 
						$passwordUpdateStr
						email = '$email',
						last_name = '$last_name', 
						first_name = '$first_name', 
						status = '$member_type' 
						WHERE id='$id2' LIMIT 1";
  mysqli_query ($conn, $updateMemberQuery );
  
  // delete if existing for some error cases
  $deleteQuery = "DELETE FROM member_accesslevel WHERE member_id='$id2'";
  mysqli_query($conn, $deleteQuery );
  
  if($member_type !="super admin")
  {
  // access level saving 
  foreach( $gModules as $module ){
	$editAccess = $deleteAccess = 0;
	if( isset($_POST['module'][$module])){
		$editAccess = intval($_POST['module'][$module]["check_edit"]);
		$deleteAccess = intval($_POST['module'][$module]["check_del"]);
	}
	mysqli_query ($conn, "insert into member_accesslevel(member_id,module_name,edit_access,delete_access) values('$id2','$module','$editAccess','$deleteAccess')" );
		
  }
 }

	header("location:member_table.php");
		
}
 
?>
