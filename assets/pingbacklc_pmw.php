<?php // Paymentwall
/*CREATE TABLE `a_donatelog_pmw` (
  `a_index` int(11) NOT NULL AUTO_INCREMENT,
  `a_user_code` int(11) NOT NULL,
  `a_date` datetime NOT NULL,
  `a_ip` varchar(15) DEFAULT NULL,
  `a_str` varchar(2550) DEFAULT NULL,
  PRIMARY KEY (`a_index`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;*/

	include 'config.php';
	define('APP_SECRET_KEY', 'your-app_secret_key-here');
	//define('IP_WHITELIST_CHECK_ACTIVE', true);
	//define('CREDIT_TYPE_CHARGEBACK', 2);

	/* The IP addresses below are Paymentwall's
	 * servers. Make sure your pingback script
	 * accepts requests from these addresses ONLY. * /
	$ipsWhitelist = array(
		'174.36.92.186',
		'174.36.96.66',
		'174.36.92.187',
		'174.36.92.192',
		'174.37.14.28'
	);*/

	if (empty($_GET['uid']) || empty($_GET['currency']) || !isset($_GET['type']) || empty($_GET['ref']) || empty($_GET['sig']))
		exit('Missing parameters!');

    $signatureParams = array();
    
    // version 1 signature
    if (empty($_GET['sign_version']) || $_GET['sign_version'] <= 1) {
         $signatureParams = array(
            'uid' => $_GET['uid'],
            'currency' => $_GET['currency'],
            'type' => $_GET['type'],
            'ref' => $_GET['ref']
        );
    }
    // version 2+ signature
    else {
        foreach ($_GET as $param => $value)   
            $signatureParams[$param] = $value;
        unset($signatureParams['sig']);
    }

	// if the request's origin is one of Paymentwall's servers
    //if (IP_WHITELIST_CHECK_ACTIVE && !in_array($requestip, $ipsWhitelist))
	//	exit('IP not in whitelist!');
	
	// if the signature matches the parameters
    if ($_GET['sig'] != calculatePingbackSignature($signatureParams, APP_SECRET_KEY, $_GET['sign_version']))
		exit('Signature is not valid!');

	try{
		$db = new PDO("mysql:host=".$sql_host.";dbname=".$db1, $sql_user, $sql_pass, array( PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING ));

		$dbh = $db->prepare("INSERT INTO a_donatelog_pmw (a_user_code, a_date, a_ip, a_str) VALUES(:usercode, NOW(), :ip, :var)");
		$dbh->bindParam(':usercode', $_GET['uid'], PDO::PARAM_INT, 11);
		$dbh->bindParam(':ip', $requestip, PDO::PARAM_STR, 20);
		$varr = var_export($_GET, true);
		$dbh->bindParam(':var', $varr, PDO::PARAM_STR, 2550);
		$dbh->execute();

		$dbh = $db->prepare("UPDATE bg_user SET cash = cash + :cash WHERE user_code = :usercode");
		$dbh->bindParam(':usercode', $_GET['uid'], PDO::PARAM_INT, 11);
		$dbh->bindParam(':cash', $_GET['currency'], PDO::PARAM_INT, 11);
		$dbh->execute();

	}
	catch (PDOException $e) {
		file_put_contents("pingbacklc_pmw.txt", var_export($_GET, true)."\n", FILE_APPEND);
		exit($e->getMessage());
	}

	/* Always make sure to echo OK so Paymentwall
	 * will know that the transaction is successful. */
	echo 'OK';


function calculatePingbackSignature($params, $secret, $version) {
    $str = '';
    if ($version == 2) {
        ksort($params);
    }
    foreach ($params as $k=>$v) {
        $str .= "$k=$v";
    }
    $str .= $secret;
    return md5($str);
}
?>