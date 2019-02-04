<?php
error_reporting(-1);
$mysql_hostname = "localhost";
$mysql_user = "wwwquakb_main"; //user
/*$mysql_password = "1@QBdevMaiN#;NC"; //pass*/
$mysql_password = "uB#{(J;6rQ-o"; //pass
$mysql_database = "wwwquakb_maindb"; //database Name
$prefix = "";
$base_url = 'https://quakbox.com/';
$homepage = "https://quakbox.com/home.php";
$logo = "images/quack.png";
$logo1 = "images/email.jpg";
$conn = mysqli_connect($mysql_hostname, $mysql_user, $mysql_password,$mysql_database);
$con  = $conn;
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
mysqli_select_db($conn, $mysql_database) or die("Could not select database");


// available modules 
$gModules = array( "news", "users", "report", "videos", "videoads", "apps" );
// include access level class
include_once( 'accesslevel.class.php');

?>