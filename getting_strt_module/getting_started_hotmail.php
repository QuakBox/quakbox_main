<?php
ob_start();
session_start();
require_once('config.php');
if(!isset($_SESSION['SESS_MEMBER_ID']))
	{
		header("location: ".$base_url."login.php?back=". urlencode($_SERVER['REQUEST_URI']));
		exit();
	}	

$member_id = $_SESSION['SESS_MEMBER_ID'];
//function for parsing the curl request
function curl_file_get_contents($url) {
$ch = curl_init();
curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
$data = curl_exec($ch);
curl_close($ch);
return $data;
}
$client_id = '000000004410F1ED';
$client_secret = 'gXrPACx93RVFOWsu0NdCrWsCc7uyvS4u';
$redirect_uri = $base_url.'getting_started_hotmail.php';
$auth_code = $_GET["code"];
$fields=array(
'code'=>  urlencode($auth_code),
'client_id'=>  urlencode($client_id),
'client_secret'=>  urlencode($client_secret),
'redirect_uri'=>  urlencode($redirect_uri),
'grant_type'=>  urlencode('authorization_code')
);
$post = '';
foreach($fields as $key=>$value) { $post .= $key.'='.$value.'&'; }
$post = rtrim($post,'&');
$curl = curl_init();
curl_setopt($curl,CURLOPT_URL,'https://login.live.com/oauth20_token.srf');
curl_setopt($curl,CURLOPT_POST,5);
curl_setopt($curl,CURLOPT_POSTFIELDS,$post);
curl_setopt($curl, CURLOPT_RETURNTRANSFER,TRUE);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,0);
$result = curl_exec($curl);
curl_close($curl);
$response =  json_decode($result);
$accesstoken = $response->access_token;
//$accesstoken = $_SESSION['accesstoken'] ;//= $_GET['access_token'];
$url = 'https://apis.live.net/v5.0/me/contacts?access_token='.$accesstoken.'&limit=2';
$xmlresponse =  curl_file_get_contents($url);
$xml = json_decode($xmlresponse, true);
$msn_email = "";
foreach($xml['data'] as $emails)
{
// echo $emails['name'];
$email_ids = implode(",",array_unique($emails['emails'])); //will get more email primary,sec etc with comma separate
$msn_email .= "<div><span>".$emails['name']."</span> &nbsp;&nbsp;&nbsp;<span>". rtrim($email_ids,",")."</span></div>";
$email = rtrim($email_ids,",");

$sql = mysqli_query($con, "SELECT id FROM import_contact WHERE member_id = '$member_id' AND email = '$email'");
if(mysqli_num_rows($sql) == 0){
mysqli_query($con, "insert into import_contact(member_id,email) VALUES('$member_id','$email')");
}

}
//echo $msn_email;
 header("location: ".$base_url."getting_started_contact.php");
 exit();
?>