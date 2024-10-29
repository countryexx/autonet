<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Third Party Services
	|--------------------------------------------------------------------------
	|
	| This file is for storing the credentials for third party services such
	| as Stripe, Mailgun, Mandrill, and others. This file provides a sane
	| default location for this type of information, allowing packages
	| to have a conventional place to find your various credentials.
	|
	*/

	'mailgun' => array(
		'domain' => 'app.aotour.com.co',
		'secret' => 'key-72b69a77f145e70eeeda54456daef450',
	),

	'mandrill' => array(
		'secret' => 'c1RFf2qHlB8YN6NSnelEVg',
	),

	'stripe' => array(
		'model'  => 'User',
		'secret' => 'key-72b69a77f145e70eeeda54456daef450',
	),

);
