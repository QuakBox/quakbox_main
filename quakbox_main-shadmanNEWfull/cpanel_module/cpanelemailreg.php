<?php 
require("xmlapi.php");
require_once($_SERVER['DOCUMENT_ROOT']."/qb_classes/connection/qb_database.php");

$db_Obj = new database(); 
$mres = $db_Obj->execQueryWithFetchObject("select * from member where member_id = '".$member_id."'");
$email_user = $mres->username;
$email_password = $mres->password;


/*
$ip = '208.109.108.68';
$root_user = "qbdevqb";
$root_pass = '7q&u83:\?()AKAtp';
$account = "qbdevqb";
$email_domain = "qbdev.quakbox.com";
$email_quota = '100';

$xmlapi = new xmlapi($ip);
$xmlapi->password_auth($root_user,$root_pass);
$xmlapi->set_output('json');
$xmlapi->set_debug(0);
$xmlapi->api1_query($account, "Email", "addpop", array($email_user, $email_password, $email_quota, $email_domain) );
*/

$url = 'https://ns529456.ip-149-56-22.net:10000/virtual-server/remote.cgi?program=create-user&domain=quakbox.com&quota=204800&user='.$email_user.'&pass='.$email_password;
$username = 'root';
$password = '37qFaCCxys1i';

$c = curl_init();
curl_setopt($c, CURLOPT_URL, $url);
curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
curl_setopt($c, CURLOPT_TIMEOUT, 60);
curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($c, CURLOPT_USERPWD, $username.':'.$password);
$results = @curl_exec($c);
