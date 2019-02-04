<?php

session_start();

$config = dirname(__FILE__) . '/config.php';

require_once("./Hybrid/Auth.php");
require_once("../qb_registration_class.php");
require_once("../qb_member1.php");
try {
    $hybridauth = new Hybrid_Auth($config);
    $google = $hybridauth->authenticate("Google");
    $googleUserProfile = $google->getUserProfile();

    $registration = new registration();
    $userId = $registration->registerFromSocialNetwork(
        $registration::SocialNetworkFacebook,
        $googleUserProfile->identifier,
        $googleUserProfile->displayName,
        $googleUserProfile->email,
        $googleUserProfile->photoURL
    );

    if($userId > 0) {
		
		$registration->loginUser($userId);
		
			$memberObject1 = new member1();
			$PostMemberCountorymete=$memberObject1->select_member_meta_value($userId,"home_country");
			if($PostMemberCountorymete!='') {
					$PostMemberCountorycode=$memberObject1->select_GeoCountry_code($PostMemberCountorymete);
					require_once("../../config.php");	
					  $url=$base_url.'country/'.$PostMemberCountorycode;
					}else {
						$url='/home';   
					}
				header('Location:'.$url);
		} else {
        // Return user back to login page
			header('Location: /landing.php');
		}
	 unset($registration);
	exit();
} catch (Exception $e) {
    switch ($e->getCode()) {
        case 0 :
            echo "Unspecified error.";
            break;
        case 1 :
            echo "Hybriauth configuration error.";
            break;
        case 2 :
            echo "Provider not properly configured.";
            break;
        case 3 :
            echo "Unknown or disabled provider.";
            break;
        case 4 :
            echo "Missing provider application credentials.";
            break;
        case 5 :
            echo "Authentification failed. "
                . "The user has canceled the authentication or the provider refused the connection.";
            break;
        case 6 :
            echo "User profile request failed. Most likely the user is not connected "
                . "to the provider and he should authenticate again.";
            $google->logout();
            break;
        case 7 :
            echo "User not connected to the provider.";
            $google->logout();
            break;
        case 8 :
            echo "Provider does not support this feature.";
            break;
    }
}