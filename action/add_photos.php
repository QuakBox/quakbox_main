<?php ob_start();
     include_once("../config.php");			

if(isset($_FILES['files'])){
	$ip = $_SERVER['REMOTE_ADDR'];
$time = time(); 
   $user_id = $_POST['member_id'];
   $user_id	 = 	f($user_id, 'strip');
$user_id	 = 	f($user_id, 'escapeAll');
$user_id   = mysqli_real_escape_string($con, $user_id);

   $id = $_POST['album_id'];
   $id	 = 	f($id, 'strip');
$id	 = 	f($id, 'escapeAll');
$id   = mysqli_real_escape_string($con, $id);

    $errors= array();
	foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){
		$file_name = 'uploadedimage/'.$_FILES['files']['name'][$key];
		$file_name1 = $_FILES['files']['name'][$key];
		$file_size =$_FILES['files']['size'][$key];
		$file_tmp =$_FILES['files']['tmp_name'][$key];
		$file_type=$_FILES['files']['type'][$key];	
        if($file_size > 2097152){
			$errors[]='File size must be less than 2 MB';
        }	
			
        $query="INSERT into upload_data (`USER_CODE`,`FILE_NAME`,`FILE_SIZE`,`FILE_TYPE`,`album_id`,`date_created`) VALUES('$user_id','$file_name','$file_size','$file_type','$id','$time'); ";

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
			echo $message_id=mysqli_insert_id($con); 
			
			$sqlu = "UPDATE upload_data set msg_id = '$message_id' WHERE upload_data_id = '$photo_id'";
			mysqli_query($con, $sqlu);
        }else{
                print_r($errors);
        }

//	mysqli_query($con, $query) or die(mysqli_error($con)) ;	
    }
	if(empty($error)){
		echo "Success";
			}
}

$url = $_SERVER['HTTP_REFERER'];
header("location: ".$url."");
die(mysqli_error($con));
?>