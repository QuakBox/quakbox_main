<?php
include "config.php";
/* RECEIVE VALUE */
$validateValue= strtolower( $_REQUEST['fieldValue'] );
$validateId=$_REQUEST['fieldId'];


$validateError= "This username is already taken";
$validateSuccess= "This username is available";

$query = "SELECT * FROM admins
WHERE username = '$validateValue'";
	
	

$sql = mysqli_query($conn,$query);
$res = mysqli_fetch_array($sql);
$res1= strtolower( $res['username'] );

	/* RETURN VALUE */
	$arrayToJs = array();
	$arrayToJs[0] = $validateId;

if($validateValue !=$res1){		// validate??
	$arrayToJs[1] = true;			// RETURN TRUE
	echo json_encode($arrayToJs);			// RETURN ARRAY WITH success
}else{
	for($x=0;$x<1000000;$x++){
		if($x == 990000){
			$arrayToJs[1] = false;
			echo json_encode($arrayToJs);		// RETURN ARRAY WITH ERROR
		}
	}
	
}

?>