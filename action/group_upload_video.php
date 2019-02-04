<?php  ob_start();
session_start();

 $upload_dir = '../group_video/';  
     $temp_name = $_FILES['uploadedfile']['tmp_name'];  
      $file_name = $_FILES['uploadedfile']['name'];  
      $file_path = $upload_dir.$upload_url.$file_name;
	  $file_type=$_FILES['uploadedfile']['type'];
	 
	$watermark_path="../images/watermark.png";
	$time = time();
	$ip=$_SERVER['REMOTE_ADDR'];
	$videoNamewithoutExtension = pathinfo($file_name, PATHINFO_FILENAME);
        $video_name= $time.$videoNamewithoutExtension;
	$ext = pathinfo($file_name, PATHINFO_EXTENSION);
				  if(move_uploaded_file($temp_name, $file_path))  
	{  
	 			
	 $replaced_name1 = str_replace(' ', '', $video_name );
	 $replaced_name2 = str_replace('_', '',$replaced_name1);
	 $replaced_name3 = str_replace('(', '',$replaced_name2);
	 $replaced_name4 = str_replace(')', '',$replaced_name3);
	 $replaced_name5 = str_replace('-', '',$replaced_name4);
	 $replaced_name6 = str_replace('`', '',$replaced_name5);
	 $replaced_name7 = str_replace('~', '',$replaced_name6);
	 $replaced_name8 = str_replace('!', '',$replaced_name7);
	 $replaced_name9 = str_replace('@', '',$replaced_name8);
	 $replaced_name10 = str_replace('#', '',$replaced_name9);
	 $replaced_name11 = str_replace('$', '',$replaced_name10);
	 $replaced_name12 = str_replace('%', '',$replaced_name11);
	 $replaced_name13 = str_replace('^', '',$replaced_name12);
	 $replaced_name14 = str_replace('&', '',$replaced_name13);
	 $replaced_name15 = str_replace('+', '',$replaced_name14);
	 $replaced_name16 = str_replace('=', '',$replaced_name15);
	 $replaced_name17 = str_replace('{', '',$replaced_name16);
	 $replaced_name18 = str_replace('}', '',$replaced_name17);
	 $replaced_name19 = str_replace('[', '',$replaced_name18);
	 $replaced_name20 = str_replace(']', '',$replaced_name19);
	 $replaced_name21 = str_replace(';', '',$replaced_name20);
	 $replaced_name22 = str_replace('.', '',$replaced_name21);
	 $replaced_name23 = str_replace(':', '',$replaced_name22);
	 $replaced_name = $replaced_name23.".".$ext;
	rename($upload_dir.$file_name, $upload_dir.$replaced_name);
	echo $video_name=$replaced_name;
			  
	  }
	  else
	  {
		if(!$check)
		echo "err1";
	  }
        
 ?>  