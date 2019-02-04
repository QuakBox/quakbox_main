<?php ob_start();
     include_once("../config.php");			

if(isset($_FILES['files'])){ 
   $user_id = $_POST['member_id'];
   $user_id	 = 	f($user_id, 'strip');
$user_id	 = 	f($user_id, 'escapeAll');
$user_id   = mysqli_real_escape_string($con, $user_id);

   $group_id = $_POST['group_id'];
   $group_id	 = 	f($group_id, 'strip');
$group_id	 = 	f($group_id, 'escapeAll');
$group_id   = mysqli_real_escape_string($con, $group_id);

   $id = $_POST['album_id'];
   $id	 = 	f($id, 'strip');
$id	 = 	f($id, 'escapeAll');
$id   = mysqli_real_escape_string($con, $id);

    $errors= array();
	foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){
		$file_name = 'group_photo/'.$_FILES['files']['name'][$key];
		$file_name1 = $_FILES['files']['name'][$key];
		$file_size =$_FILES['files']['size'][$key];
		$file_tmp =$_FILES['files']['tmp_name'][$key];
		$file_type=$_FILES['files']['type'][$key];	
        if($file_size > 2097152){
			$errors[]='File size must be less than 2 MB';
        }	
			
        $query="INSERT into groups_photo (member_id,group_id,`FILE_NAME`,`FILE_SIZE`,`FILE_TYPE`,`album_id`,`date_created`) VALUES('$user_id','$group_id','$file_name','$file_size','$file_type','$id','".strtotime(date("Y-m-d H:i:s"))."'); ";

		$desired_dir="../group_photo";
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