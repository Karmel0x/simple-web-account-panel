<?php

include_once('config.php');


if ($_GET['check'] == 'userexist' && !empty($_GET['username']) && is_string($_GET['username'])) {
	$dbh = dbc()->prepare("SELECT count(*) FROM bg_user WHERE user_id = :user_id");
	$dbh->bindParam(':user_id', $_GET['username'], PDO::PARAM_STR);
	$dbh->execute();

	$result = $dbh->fetch();

	if ($result[0] == 0) echo 0;
	else echo 1;
}
