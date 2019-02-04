<?php ob_start();
set_time_limit(0);

//path to the file.
//Your file should be in this folder only.
$file_path = 'backup/'.$_REQUEST['file'];

//Call the download function with file path,file name and file type
download_file($file_path, ''.$_REQUEST['file'].'', 'image/jpg');

function download_file($file, $name, $mime_type='')
{
 if(!is_readable($file)) die('File not found.');

 $size = filesize($file);
 $name = rawurldecode($name);

 $known_mime_types=array(
 	"pdf" => "application/pdf",
 	"txt" => "text/plain",
 	"html" => "text/html",
 	"htm" => "text/html",
"exe" => "application/octet-stream",
"zip" => "application/zip",
"doc" => "application/vnd.openxmlformats-officedocument.wordproce",
"xls" => "application/vnd.ms-excel",
"ppt" => "application/vnd.ms-powerpoint",
"gif" => "image/gif",
"png" => "image/png",
"jpeg"=> "image/jpg",
"jpg" =>  "image/jpg",
"php" => "text/plain"
 );

 if($mime_type==''){
$file_extension = strtolower(substr(strrchr($file,"."),1));
if(array_key_exists($file_extension, $known_mime_types)){
$mime_type=$known_mime_types[$file_extension];
} else {
$mime_type="application/force-download";
}
 }

 @ob_end_clean(); 

 // required for IE, otherwise Content-Disposition may be ignored
 if(ini_get('zlib.output_compression'))
  ini_set('zlib.output_compression', 'Off');

		header('Content-Description: File Transfer');		
		header('Content-Disposition: attachment; filename='.$name);
		header('Content-Type: '.$mime_type);
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . $size);		
readfile($file);
}
?>