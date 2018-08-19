<?php
	$server_name = "PServer Last Chaos";
	
	$sql_host = '127.0.0.1';
	$sql_user = 'root';
	$sql_pass = '';
	$db1 = 'junedb_auth'; // auth database
	//$db2 = 'junedb_db'; // db database
	//$db3 = 'junedb_data'; // data database

	error_reporting(0);
	date_default_timezone_set('Europe/Berlin');
	
	$requestip = $_SERVER['REMOTE_ADDR'];// HTTP_X_FORWARDED_FOR only while using cloudflare
	
?>