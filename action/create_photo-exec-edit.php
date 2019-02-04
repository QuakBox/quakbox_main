<?php //Start session
	ob_start();
	session_start();
	
	//Include database connection details
	require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_lookup.php');
	$objLookupClass=new lookup();
	
	
if(isset($_REQUEST['album_id']))
{
$ip = $_SERVER['REMOTE_ADDR'];
$time = time();
$album_id=mysqli_real_escape_string($con, f($_REQUEST['album_id'],'escapeAll'));
$lookupWallID=$objLookupClass->getLookupKey('Wall Type', 'Photo Gallery');
//$sql="INSERT into user_album (album_user_id,album_name,type) VALUES('".$_SESSION['SESS_MEMBER_ID']."','".$album_name."','".$lookupWallID."');";
//mysqli_query($con, $sql) or die(mysqli_error($con)) ;
$id=$album_id;

if(isset($_FILES['myfiles'])){
   $user_id=$_SESSION['SESS_MEMBER_ID'];
    $errors= array();
	foreach($_FILES['myfiles']['tmp_name'] as $key => $tmp_name ){
		$file_name = 'uploadedimage/'.$_FILES['myfiles']['name'][$key];
		$file_name1 = $_FILES['myfiles']['name'][$key];
		$file_size =$_FILES['myfiles']['size'][$key];
		$file_tmp =$_FILES['myfiles']['tmp_name'][$key];
		$file_type=$_FILES['myfiles']['type'][$key];	
        if($file_size > 2097152){
			$errors[]='File size must be less than 2 MB';
        }		
        $query="INSERT into upload_data (`USER_CODE`,`FILE_NAME`,`FILE_SIZE`,`FILE_TYPE`,`album_id`,`date_created`) VALUES('$user_id','$file_name','$file_size','$file_type','$id','".strtotime(date("Y-m-d H:i:s"))."'); ";		
		$desired_dir="../uploadedimage";		
		
        if(empty($errors)==true){
            if(is_dir($desired_dir)==false){
                mkdir("$desired_dir", 0755);		// Create directory if it does not exist
            }
            if(is_dir("$desired_dir/".$file_name1)==false){
                move_uploaded_file($file_tmp,"$desired_dir/".$file_name1);
            }else{									// rename the file if another one exist
                $new_dir="$desired_dir/".$file_name1.time();
                 rename($file_tmp,$new_dir) ;				
            }
		 mysqli_query($con, $query) or die(mysqli_error($con)) ;
		 $photo_id = mysqli_insert_id($con);
		 
		 $sql="INSERT INTO message(messages,member_id,date_created,ip,type,msg_album_id,photo_id,wall_privacy,photo_status) VALUES ('$file_name','$user_id',$time,'$ip',1,'$id','$photo_id',3,1)"; 
			mysqli_query($con, $sql) or die(mysqli_error($con));
			$message_id=mysqli_insert_id($con);
			
			mysqli_query($con, "UPDATE upload_data set msg_id = '$message_id' WHERE upload_data_id = '$photo_id'");			
        }else{
                print_r($errors);
        }
    }
	if(empty($error)){
		echo "Success";
			}
}
}

	$url = $_SERVER['HTTP_REFERER'];
	


header("location: ".$url."");
exit();
?>