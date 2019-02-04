<div class="column_internal_right" style="border:#CCCCCC 1px solid; padding:10px; margin-right:20px;">
<?php
//require_once('yahoo_api/globals.php'); 
//require_once('yahoo_api/oauth_helper.php');

/*$callback    =    $base_url."yahoo_api/yahoo_callback.php"; 
// Get the request token using HTTP GET and HMAC-SHA1 signature 
$retarr = get_request_token(OAUTH_CONSUMER_KEY, OAUTH_CONSUMER_SECRET, $callback, false, true, true);

if (! empty($retarr)){ 
list($info, $headers, $body, $body_parsed) = $retarr; 
if ($info['http_code'] == 200 && !empty($body)) { 

$_SESSION['request_token']  		 = $body_parsed['oauth_token'];
$_SESSION['request_token_secret']  = $body_parsed['oauth_token_secret']; 
$_SESSION['oauth_verifier'] 		= $body_parsed['oauth_token']; 
*/
?> <div>
<div style="padding:10px; border-bottom:1px solid #CCCCCC; margin-right:-10px; margin-left:-10px; font-size:14px; font-weight:bold; color:#005689">Invite Friends By Their Email</div>
<div id="submenushead" sty>
    <ul class="dropDown">
    <li style="border-right:padding:0 8px;"><a href="import-contact-country.php?country=<?php echo $country_code; ?>">Imported Contact List</a></li>   
	</ul>
   </div>
</div>
<ul class="dropDown">
<!--<li>
<a href="<?php echo urldecode($body_parsed['xoauth_request_auth_url']);?>" ><img src="images/yahoo.png" /></a>
</li>-->
<li>
<?php $countryQuerystring = base64_encode("country=" . $country_code);?>
<!--  <a  style="font-size:25px;font-weight:bold;" href="https://accounts.google.com/o/oauth2/auth?client_id=354718587142-uab3d8pect0pegpalvgknpe31s1j2v8n.apps.googleusercontent.com&redirec
t_uri=<?php echo $base_url;?>gmail_outh_for_country.php&scope=https://www.google.com/m8/feeds/&response_type=code"><img src="images/gmail.png" /></a> -->
<a  style="font-size:25px;font-weight:bold;" href="https://accounts.google.com/o/oauth2/auth?client_id=485256929182-6hvesue9gj8476qish83s8rp6hfpqgpe.apps.googleusercontent.com&redirec
t_uri=<?php echo $base_url;?>gmail_outh_for_country.php&scope=https://www.google.com/m8/feeds/&response_type=code&state=<?php echo $countryQuerystring?>"><img src="images/gmail.png" /></a>
</li>
<li>
<a href="https://login.live.com/oauth20_authorize.srf?client_id=000000004410F1ED&scope=wl.signin%20wl.basic%20wl.emails%20wl.contacts_emails&response_type=code&redirect_uri=<?php echo $base_url;?>oauth_hotmail_country.php" ><img src="images/hotmail.png" /></a>
</li>

</ul>
<?php
 //} }
 
 
?>
</div>