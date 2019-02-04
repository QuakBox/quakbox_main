<?php
/*
This class is an extension of script made by www.zubrag.com. You can access the original link from here
http://www.zubrag.com/scripts/cpanel-create-email-account.php

Class Name: cpmail
Clas Title: cPanel Mail Accounts Creator
Purpose: Create cPanel email account without loggin in to cPanel.
Version: 1.0
Author: Md. Zakir Hossain (Raju)
URL: http://www.rajuru.xenexbd.com

Company: Xenex Web Solutions
URL: http://www.xenexbd.com

License: GPL
You can freely use, modify, distribute this script. But a credit line is appreciated.

Installation:
see example.php for details

*/

//definding main class
class cpmail{
  //declare public variables
  var $cpuser;    // cPanel username
  var $cppass;        // cPanel password
  var $cpdomain;      // cPanel domain or IP
  var $cpskin;        // cPanel skin. Mostly x or x2.
  
  //defining constructor
  function cpmail($cpuser,$cppass,$cpdomain,$cpskin='x'){
    $this->cpuser=$cpuser;
	$this->cppass=$cppass;
	$this->cpdomain=$cpdomain;
	$this->cpskin=$cpskin;
	// See following URL to know how to determine your cPanel skin
	// http://www.zubrag.com/articles/determine-cpanel-skin.php
  }

  //now create email account, function takes three arguments
  /*
  $euser = email id
  $epass = email password
  $equota = mailbox allocated size
  */
  function create($euser,$epass,$equota){
    $path="http://".$this->cpuser.":".$this->cppass."@".$this->cpdomain.":2083/frontend/".$this->cpskin."/mail/doaddpop.html?quota=".$equota."&email=".$euser."&domain=".$this->cpdomain."&password=".$epass;
    $f = fopen($path,"r");
	if (!$f) {
	  return('Cannot create email account. Possible reasons: "fopen" function not allowed on your server, PHP is running in SAFE mode');
	}

    //check if the account exists
    while (!feof ($f)) {
	  $line = fgets ($f, 1024);
	  if (ereg ("already exists!", $line, $out)) {
	    return('Such email account already exists.');
	  }
	}
	fclose($f);
    //return success message
	return "Email account created.";
 }
}

?>