<?php
session_start ();
include ("config.php");

if (isset ( $_POST ['submit'] )) {
  $name = $_POST ['name'];
  list( $first_name, $last_name) = explode( " ", $name );
  $username = $_POST ['login_name'];
  $password = md5( $_POST ['password'] );
  $cpassword = $_POST ['cpassword'];
  $email = $_POST ['email'];
  $member_type = $_POST ['member_type'];  
  $module = $_POST['module'];
  $insertMemberQuery = "insert into admins SET 
						username = '$username',
						password = '$password',
						email = '$email',
						last_name = '$last_name', 
						first_name = '$first_name', 
						status = '$member_type'";
  mysqli_query ( $conn, $insertMemberQuery );
  
 // echo "insert into member(displayname,username,password,email,member_type) values('$name','$login_name','$password','$email','$member_type')";
  //exit;
  if($member_type !="super admin")
  	{
	  $memberId = mysqli_insert_id ( $conn );
	  // access level saving 
	  
	  // delete if existing for some error cases 
	  $deleteQuery = "DELETE FROM member_accesslevel WHERE member_id='$memberId'";
	  mysqli_query($conn, $deleteQuery );
	  foreach( $gModules as $module ){
		$editAccess = $deleteAccess = 0;
		if( isset($_POST['module'][$module])){
			$editAccess = intval($_POST['module'][$module]["check_edit"]);
			$deleteAccess = intval($_POST['module'][$module]["check_del"]);
		}
		mysqli_query ($conn, "insert into member_accesslevel(member_id,module_name,edit_access,delete_access) values('$memberId','$module','$editAccess','$deleteAccess')" );
			
		}
	 }

  header ( "location:member_table.php" );
}

?>
