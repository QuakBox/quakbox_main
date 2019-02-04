<?php

if (!isset($_SESSION)) {
    session_start();
}

$accessKey = 'TGBFoXqttNmxr9fwyrxrInhKzPBXZXNcCrh6uz55oJfXfA1wGKf5THwhmsH6r1lS';

// Check if this is test domain
if($_SERVER['HTTP_HOST'] === 'qbtest.quakbox.com'){
    // Check if secret key is set
    if(isset($_REQUEST['accessKey']) && $_REQUEST['accessKey'] == $accessKey){
        setcookie('accessKey', $accessKey);
        $_SESSION['accessKey'] = $_REQUEST['accessKey'];
        header('Location: /landing.php');
        exit();
    }

    // Verify secret key
    if((!isset($_SESSION['accessKey']) || $_SESSION['accessKey'] != $accessKey) && (!isset($_COOKIE['accessKey']) || $_COOKIE['accessKey'] != $accessKey)){
        echo "Please use authorization key to connect to staging website.";
        exit();
    }
}

if(!function_exists('isPageVisibleForEveryone')) {
    function isPageVisibleForEveryone()
    {
        global $pageIsVisibleForEveryone;
        static $_visible = null;
		if (strpos($_SERVER['REQUEST_URI'], 'watch.php') !== false || strpos($_SERVER['REQUEST_URI'], 'video_category.php') !== false || strpos($_SERVER['REQUEST_URI'], 'news_category.php') !== false || strpos($_SERVER['REQUEST_URI'], 'news_detail.php') !== false || strpos($_SERVER['REQUEST_URI'], 'news_detail.php') !== false || strpos($_SERVER['REQUEST_URI'], 'news_sitemap.php' ) !== false || strpos($_SERVER['REQUEST_URI'], 'news_sitemap_xml.php' ) !== false){
			$_visible = true;
		} else{
			if(is_null($_visible)) {
				if(isset($_SESSION['SESS_MEMBER_ID']) && $_SESSION['SESS_MEMBER_ID'] > 0){
					$pageIsVisibleForEveryone = false;
				}
				$_visible = $pageIsVisibleForEveryone;
			}
		}	

        return $_visible;
    }
}

if(!isPageVisibleForEveryone()){
    if (!isset($_SESSION['SESS_MEMBER_ID']) || $_SESSION['SESS_MEMBER_ID'] < 1) {
        $protocol = empty($_SERVER['HTTPS']) ? 'http' : 'https';
        $domain = $_SERVER['HTTP_HOST'];
        header("location:$protocol://{$domain}");
    }
} else {
	if (!isset($_SESSION['SESS_MEMBER_ID']) || $_SESSION['SESS_MEMBER_ID'] < 1) {
		$_SESSION['SESS_MEMBER_ID'] = 0;
	}
}

if (isset($_SESSION['lang'])) {
    $lan = $_SESSION['lang'] . '.php';
    include_once($_SERVER['DOCUMENT_ROOT'] . '/Languages/' . $lan);
} else {
    include_once($_SERVER['DOCUMENT_ROOT'] . '/Languages/en.php');
}

