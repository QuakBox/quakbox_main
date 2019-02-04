<?php

//include("constants.php");    
if(!defined("DB_SERVER"))
define("DB_SERVER", "localhost");
if(!defined("DB_USER"))
define("DB_USER", "qbdevqb_main");
/*if(!defined("DB_PASS"))
define("DB_PASS", "1@QBdevMaiN#;NC");*/
if(!defined("DB_PASS"))
define("DB_PASS", "uB#{(J;6rQ-o");
if(!defined("DB_NAME"))
define("DB_NAME", "qbdevqb_maindb");
define("TBL_USERS", "users");
define("TBL_ATTEMPTS", "login_attempts");
define("ATTEMPTS_NUMBER", "3");
define("TIME_PERIOD", "30");
define("COOKIE_EXPIRE", 60*60*24*100);      //100 days by default
define("COOKIE_PATH", "/");                 //Avaible in whole domain
 
class MySQLDB
{
	
	var $connection;         //The MySQL database connection

   function MySQLDB(){
      $this->connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysqli_error($this->connection));
      mysqli_select_db( $this->connection,DB_NAME) or die(mysqli_error($this->connection));
   }

   function confirmIPAddress($value) {
	$q = "SELECT attempts, (CASE when lastlogin is not NULL and DATE_ADD(LastLogin, INTERVAL ".TIME_PERIOD." MINUTE)>NOW() then 1 else 0 end) as Denied ".
   " FROM ".TBL_ATTEMPTS." WHERE ip = '$value'";
 
   $result = mysqli_query($this->connection, $q);
   $data = mysqli_fetch_array($result);   
    //Verify that at least one login attempt is in database

   if (!$data) {
     return 0;
   } 
   if ($data["attempts"] >= ATTEMPTS_NUMBER)
   {
      if($data["Denied"] == 1)
      {
         return 1;
      }
     else
     {
        $this->clearLoginAttempts($value);
        return 0;
     }
   }
   return 0;  
  }
   
   function addLoginAttempt($value) {
   // increase number of attempts
   // set last login attempt time if required    
	  $q = "SELECT * FROM ".TBL_ATTEMPTS." WHERE ip = '$value'"; 
	  $result = mysqli_query( $this->connection,$q);
	  $data = mysqli_fetch_array($result);
	  
	  if($data)
      {
        $attempts = $data["attempts"]+1;

        if($attempts==3) {
		 $q = "UPDATE ".TBL_ATTEMPTS." SET attempts=".$attempts.", lastlogin=NOW() WHERE ip = '$value'";
		 $result = mysqli_query($this->connection,$q);
		}
        else {
		 $q = "UPDATE ".TBL_ATTEMPTS." SET attempts=".$attempts." WHERE ip = '$value'";
		 $result = mysqli_query($this->connection,$q);
		}
       }
      else {
	   $q = "INSERT INTO ".TBL_ATTEMPTS." (attempts,IP,lastlogin) values (1, '$value', NOW())";
	   $result = mysqli_query($this->connection,$q);
	  }
    }
   
   
   function confirmUserPass($username, $password){
      /* Add slashes if necessary (for query) */
      if(!get_magic_quotes_gpc()) {
	      $username = addslashes($username);
      }

      /* Verify that user is in database */
      $q = "SELECT password FROM ".TBL_USERS." WHERE username = '$username'";
      $result = mysqli_query( $this->connection,$q);
      if(!$result || (mysqli_numrows($result) < 1)){
         return 1; //Indicates username failure
      }

      /* Retrieve password from result, strip slashes */
      $dbarray = mysqli_fetch_array($result);
      $dbarray['password'] = stripslashes($dbarray['password']);
      $password = stripslashes($password);

      /* Validate that password is correct */
      if($password == $dbarray['password']){
         return 0; //Success! Username and password confirmed
      }
      else{
         return 1; //Indicates password failure
      }
   }
   
   function confirmUserName($username){
      /* Add slashes if necessary (for query) */
      if(!get_magic_quotes_gpc()) {
	      $username = addslashes($username);
      }

      /* Verify that user is in database */
      $q = "SELECT * FROM ".TBL_USERS." WHERE username = '$username'";
      $result = mysqli_query( $this->connection,$q);
      if(!$result || (mysqli_numrows($result) < 1)){
         return 1; //Indicates username failure
      } 
	  
	  return 0;

   }
   
   function clearLoginAttempts($value) {
    $q = "UPDATE ".TBL_ATTEMPTS." SET attempts = 0 WHERE ip = '$value'"; 
	return mysqli_query($this->connection,$q);
   }
   
   function getUserInfo($username){
      $q = "SELECT * FROM ".TBL_USERS." WHERE username = '$username'";
      $result = mysqli_query($this->connection,$q);
      /* Error occurred, return given name by default */
      if(!$result || (mysqli_numrows($result) < 1)){
         return NULL;
      }
      /* Return result array */
      $dbarray = mysqli_fetch_array($result);
      return $dbarray;
   }
      
   function displayUsers(){
   $q = "SELECT username,password "
       ."FROM ".TBL_USERS." ORDER BY username";
   $result = mysqli_query( $this->connection,$q);

   $num_rows = mysqli_numrows($result);

   if($num_rows == 0){
      echo "Users table is empty";
      return;
   }

   echo "<p><table align=\"left\" border=\"1\" cellspacing=\"1\" cellpadding=\"1\">\n";
   echo "<tr><td class=\"tableheadprop\">&nbsp;Username&nbsp;</td><td class=\"tableheadprop\">&nbsp;Password&nbsp;</td></tr>\n";
   for($i=0; $i<$num_rows; $i++){
      $uname  = mysqli_result($result,$i,"username");
      $upass = mysqli_result($result,$i,"password");

      echo "<tr><td class=\"tableprop\">$uname</td><td class=\"tableprop\">$upass</td></tr>\n";
   }
   echo "</table></p><br>\n";
   }
   
   function displayAttempts($value){
   $q = "SELECT ip, attempts,lastlogin "
       ."FROM ".TBL_ATTEMPTS." WHERE ip = '$value' ORDER BY lastlogin";
   $result = mysqli_query( $this->connection,$q);

   $num_rows = mysqli_numrows($result);

   if($num_rows == 0){
      echo "LoginAttempts table is empty";
      return;
   }

   echo "<p><table align=\"left\" border=\"1\" cellspacing=\"1\" cellpadding=\"1\">\n";
   echo "<tr><td class=\"tableheadprop\">&nbsp;Your IP Address&nbsp;</td><td class=\"tableheadprop\">&nbsp;Attempts&nbsp;</td><td class=\"tableheadprop\">&nbsp;LastLogin&nbsp;</td></tr>\n";
   for($i=0; $i<$num_rows; $i++){
      $uip  = mysqli_result($result,$i,"ip");
      $uattempt = mysqli_result($result,$i,"attempts");
	  $ulogin = mysqli_result($result,$i,"lastlogin");
	  

      echo "<tr><td class=\"tableprop\">$uip</td><td class=\"tableprop\">$uattempt</td><td class=\"tableprop\">$ulogin</td></tr>\n";
   }
   echo "</table></p><br>\n";
   }

};

/* Create database connection */
$database = new MySQLDB;

?>