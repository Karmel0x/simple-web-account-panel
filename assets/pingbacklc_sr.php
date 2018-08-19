<?php // SuperRewards
/*CREATE TABLE `a_donatelog_sr` (
  `a_index` int(11) NOT NULL AUTO_INCREMENT,
  `a_user_code` int(11) NOT NULL,
  `a_date` datetime NOT NULL,
  `a_str` varchar(2550) DEFAULT NULL,
  `a_ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`a_index`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;*/

include 'config.php';
define('APP_SECRET_KEY', 'your-app_secret_key-here');
//error_reporting(E_WARNING);

// *** No more configuration below this line. ***
header('Content-Type:text/plain');

	$id = $_REQUEST['id']; // ID of this transaction.
	$uid = $_REQUEST['uid']; // ID of the user which performed this transaction. 
	$oid = $_REQUEST['oid']; // ID of the offer or direct payment method.
	$new = $_REQUEST['new']; // Number of in-game currency your user has earned by completing this offer.
	$total = $_REQUEST['total']; // Total number of in-game currency your user has earned on this App.
	$sig = $_REQUEST['sig']; // Security hash used to verify the authenticity of the postback.

	if(!(is_numeric($id) && is_numeric($uid) && is_numeric($oid) && is_numeric($new) && is_numeric($total)))
		exit('0');

	if($sig != md5($id.':'.$new.':'.$uid.':'.APP_SECRET_KEY))
		exit('0');

	$result = 1;
	try {
		$db = new PDO("mysql:host=".$sql_host.";dbname=".$db1, $sql_user, $sql_pass, array( PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING ));

		$dbh = $db->prepare("INSERT INTO a_donatelog_sr (a_user_code, a_date, a_ip, a_str) VALUES(:usercode, NOW(), :ip, :var)");
		$dbh->bindParam(':usercode', $uid, PDO::PARAM_INT, 11);
		$dbh->bindParam(':ip', $requestip, PDO::PARAM_STR, 20);
		$varr = var_export($_REQUEST, true);
		$dbh->bindParam(':var', $varr, PDO::PARAM_STR, 2550);
		$dbh->execute();

		$dbh = $db->prepare("UPDATE bg_user SET cash = cash + :new WHERE user_code = :uid");
		$dbh->bindParam(':uid', $uid, PDO::PARAM_INT);
		$dbh->bindParam(':new', $new, PDO::PARAM_INT);
		$dbh->execute();
	}
	catch (PDOException $e) {
		file_put_contents("pingbacklc_sr.txt", var_export($_REQUEST, true)."\n", FILE_APPEND);
		$result = 0;//exit($e->getMessage());
	}
	
	echo $result;// 1 (success), 0 (try sending again later)
?>