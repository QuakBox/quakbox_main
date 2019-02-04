<?php

/**
 * HybridAuth
 * http://hybridauth.sourceforge.net | http://github.com/hybridauth/hybridauth
 * (c) 2009-2015, HybridAuth authors | http://hybridauth.sourceforge.net/licenses.html
 */
// ----------------------------------------------------------------------------------------
//	HybridAuth Config file: http://hybridauth.sourceforge.net/userguide/Configuration.html
// ----------------------------------------------------------------------------------------

return
		array(
			"base_url" => "https://quakbox.com/qb_classes/hybridauth/",
			"providers" => array(
				// openid providers
				"OpenID" => array(
					"enabled" => false
				),
				"Yahoo" => array(
					"enabled" => false,
					"keys" => array("key" => "", "secret" => ""),
				),
				"AOL" => array(
					"enabled" => false
				),
				"Google" => array(
					"enabled" => true,
					"keys" => array("id" => "971575710673-6i3qk60tcehkcesjgpjdhe3h01u7a78p.apps.googleusercontent.com", "secret" => "hZj3sMJpWYDK69UHQjBkvIkB"),
                    "scope"           => "https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email"
//                    "approval_prompt" => "force",
				),
				"Facebook" => array(
					"enabled" => true,
					"keys" => array("id" => "237425489926564", "secret" => "1961b57b4d309ea277d0db1e0da05399"),
					"scope" => "email, user_about_me, user_birthday, user_hometown",
					"trustForwarded" => false
				),
				"Twitter" => array(
					"enabled" => false,
					"keys" => array("key" => "", "secret" => ""),
					"includeEmail" => false
				),
				// windows live
				"Live" => array(
					"enabled" => false,
					"keys" => array("id" => "", "secret" => "")
				),
				"LinkedIn" => array(
					"enabled" => false,
					"keys" => array("key" => "", "secret" => "")
				),
				"Foursquare" => array(
					"enabled" => false,
					"keys" => array("id" => "", "secret" => "")
				),
			),
			// If you want to enable logging, set 'debug_mode' to true.
			// You can also set it to
			// - "error" To log only error messages. Useful in production
			// - "info" To log info and error messages (ignore debug messages)
			"debug_mode" => true,
		"debug_file" => "bug.txt",
			// Path to file writable by the web server. Required if 'debug_mode' is not false
		
);
