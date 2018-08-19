<?php

	include 'config.php';

	try {
		$db = new PDO("mysql:host=".$sql_host.";dbname=".$db1, $sql_user, $sql_pass);
	} 
	catch(PDOException $e) {
		die('Error connecting to the database');
	}


	if($_GET['check'] == 'userexist' && strlen($_GET['username']) > 0)
	{
		$dbh = $db->prepare("SELECT count(*) FROM bg_user WHERE user_id = :user_id");
		$dbh->bindParam(':user_id', $_GET['username'], PDO::PARAM_STR, 15);
		$dbh->execute();
		
		$result = $dbh->fetch();
		
		if($result[0] == 0) echo 0;
		else echo 1;
	}
?>