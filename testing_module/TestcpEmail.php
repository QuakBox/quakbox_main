<?php

include "cpaneluapi.class.php"; //include the class file
$uapi = new cpanelUAPI('qbdevqb', '7q&u83:\?()AKAtp', 'qbdev.quakbox.com'); //instantiate the object
$uapi->scope = 'Email'; //use the email module
//create an email address
$uapi->add_pop(array('email' => 'email@email.com', 'password' => 'password123', 'quota' => 0, 'domain' => 'quakbox.com'));
