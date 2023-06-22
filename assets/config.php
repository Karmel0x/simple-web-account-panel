<?php

$GLOBALS['server_name'] = 'PServer Last Chaos';

$GLOBALS['paymentwall_app_key'] = '';
$GLOBALS['paymentwall_secret_key'] = '';
$GLOBALS['superrewards_app_key'] = '';
$GLOBALS['superrewards_secret_key'] = '';
$GLOBALS['paypal_hosted_button_id'] = '';

error_reporting(0);
date_default_timezone_set('Europe/Berlin');

// HTTP_CF_CONNECTING_IP only while using cloudflare
$GLOBALS['request_ip'] = /*!empty($_SERVER['HTTP_CF_CONNECTING_IP']) ? $_SERVER['HTTP_CF_CONNECTING_IP'] :*/ $_SERVER['REMOTE_ADDR'];


function dbc() {
	$dsn = [
		'mysql:host=127.0.0.1;dbname=junedb_auth;charset=utf8',
		'root', ''
	];

	if (empty($GLOBALS['dbc'])) {
		try {
			$GLOBALS['dbc'] = new PDO($dsn[0], $dsn[1], $dsn[2]);
		} catch (PDOException $e) {
			exit('Error connecting to the database');
			//exit('Database connection error: ' . $e->getMessage());
		}
	}

	return $GLOBALS['dbc'];
}
