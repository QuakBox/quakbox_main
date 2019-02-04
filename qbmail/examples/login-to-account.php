<?php

/*
 * Copyright 2004-2015, AfterLogic Corp.
 * Licensed under AGPLv3 license or AfterLogic license
 * if commercial version of the product was purchased.
 * See the LICENSE file for a full license statement.
 */

	// remove the following line for real use
	//exit('remove this line');

	// Example of logging into WebMail account using email and password for incorporating into another web application

	// utilizing API
	include_once __DIR__.'/../libraries/afterlogic/api.php';

	if (class_exists('CApi') && CApi::IsValid())
	{
		// data for logging into account  uva681!@# gatien41@gmail.com Uva681!@# user@demo.afterlogic.com some-pass
		$sEmail = 'gatien41@gmail.com';
		$sPassword = 'uva681!@';

		try
		{
			// Getting required API class
			$oApiIntegratorManager = CApi::Manager('integrator');
			//echo "<pre>";
			//print_r($oApiIntegratorManager);
			// attempting to obtain object for account we're trying to log into
			$oAccount = $oApiIntegratorManager->loginToAccount($sEmail, $sPassword);
			//echo "<pre>";
			//print_r($oAccount);
			
			if ($oAccount)
			{
				// populating session data from the account
				$oApiIntegratorManager->setAccountAsLoggedIn($oAccount);

				// redirecting to WebMail
				CApi::Location('../');
			}
			else
			{
				// login error
				//echo "<pre>";
				print_r( $oApiIntegratorManager->GetLastErrorMessage());
			}
		}
		catch (Exception $oException)
		{
			// login error
			echo $oException->getMessage();
		}
	}
	else
	{
		echo 'AfterLogic API isn\'t available';
	}