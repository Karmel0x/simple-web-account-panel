<?php
// Paymentwall

/*CREATE TABLE `a_donatelog_pmw` (
  `a_index` int(11) NOT NULL AUTO_INCREMENT,
  `a_user_code` int(11) NOT NULL,
  `a_date` datetime NOT NULL,
  `a_ip` varchar(15) DEFAULT NULL,
  `a_str` varchar(2550) DEFAULT NULL,
  PRIMARY KEY (`a_index`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;*/

include_once('config.php');

//define('IP_WHITELIST_CHECK_ACTIVE', true);
//define('CREDIT_TYPE_CHARGEBACK', 2);

function calculatePingbackSignature($params, $secret, $version) {
	$str = '';
	if ($version == 2) {
		ksort($params);
	}
	foreach ($params as $k => $v) {
		$str .= "$k=$v";
	}
	$str .= $secret;
	return md5($str);
}

if(empty($GLOBALS['paymentwall_secret_key']))
	exit('Pingback method not configured');

/* The IP addresses below are Paymentwall's
 * servers. Make sure your pingback script
 * accepts requests from these addresses ONLY. * /
$ipsWhitelist = [
	'174.36.92.186',
	'174.36.96.66',
	'174.36.92.187',
	'174.36.92.192',
	'174.37.14.28'
];*/

if (empty($_GET['uid']) || empty($_GET['currency']) || !isset($_GET['type']) || empty($_GET['ref']) || empty($_GET['sig']))
	exit('Missing parameters!');

$signatureParams = [];

// version 1 signature
if (empty($_GET['sign_version']) || $_GET['sign_version'] <= 1) {
	$signatureParams = [
		'uid' => $_GET['uid'],
		'currency' => $_GET['currency'],
		'type' => $_GET['type'],
		'ref' => $_GET['ref']
	];
}
// version 2+ signature
else {
	foreach ($_GET as $param => $value)
		$signatureParams[$param] = $value;
	unset($signatureParams['sig']);
}

// if the request's origin is one of Paymentwall's servers
//if (IP_WHITELIST_CHECK_ACTIVE && !in_array($GLOBALS['request_ip'], $ipsWhitelist))
//	exit('IP not in whitelist!');

// if the signature matches the parameters
if ($_GET['sig'] != calculatePingbackSignature($signatureParams, $GLOBALS['paymentwall_secret_key'], $_GET['sign_version']))
	exit('Signature is not valid!');


file_put_contents("pingbacklc_pmw.txt", var_export($_GET, true) . "\n", FILE_APPEND);

$dbh = dbc()->prepare("INSERT INTO a_donatelog_pmw (a_user_code, a_date, a_ip, a_str) VALUES (:usercode, NOW(), :ip, :var)");
$dbh->bindParam(':usercode', $_GET['uid'], PDO::PARAM_INT);
$dbh->bindParam(':ip', $GLOBALS['request_ip'], PDO::PARAM_STR);
$varr = var_export($_GET, true);
$dbh->bindParam(':var', $varr, PDO::PARAM_STR);
$dbh->execute();

$dbh = dbc()->prepare("UPDATE bg_user SET cash = cash + :cash WHERE user_code = :usercode");
$dbh->bindParam(':usercode', $_GET['uid'], PDO::PARAM_INT);
$dbh->bindParam(':cash', $_GET['currency'], PDO::PARAM_INT);
$dbh->execute();


/* Always make sure to echo OK so Paymentwall
 * will know that the transaction is successful. */
echo 'OK';
