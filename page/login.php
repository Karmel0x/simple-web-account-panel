<?php
if (isset($_SESSION['user_id'])) {
	header("Location: ./account");
	exit();
}

function LoginByPassword($login, $passw) {
	if (empty($login) || !is_string($login) || strlen($login) < 4 || strlen($login) > 15)
		return 'Username or password is incorrect';

	if (empty($passw) || !is_string($passw) || strlen($passw) < 4 || strlen($passw) > 15)
		return 'Username or password is incorrect';

	if (!ctype_alnum($login))
		return 'Username can only contain a-Z and 0-9';

	$dbh = dbc()->prepare("SELECT user_id, user_code FROM bg_user WHERE user_id = :userid AND passwd = :passwd");
	$dbh->bindParam(':userid', $login, PDO::PARAM_STR);
	$passw = md5($passw);
	$dbh->bindParam(':passwd', $passw, PDO::PARAM_STR);
	$dbh->execute();

	if ($dbh->rowCount() != 1)
		return 'Username or password is incorrect';

	$res1 = $dbh->fetch();
	session_regenerate_id();
	$_SESSION['user_id'] = $res1['user_id'];
	$_SESSION['user_code'] = $res1['user_code'];
	$date = date("Y-m-d H:i:s");
	//$dbh = dbc()->prepare("INSERT INTO a_loginhistory (user_code, date,ip) VALUES (:usercode, :date, :ip)");
	//$dbh->bindParam(':usercode', $res1['user_code'], PDO::PARAM_STR);
	//$dbh->bindParam(':ip', $GLOBALS['request_ip'], PDO::PARAM_STR);
	//$dbh->bindParam(':date', $date, PDO::PARAM_INT);
	//$dbh->execute();
	session_write_close();
	$dbh = dbc()->prepare("UPDATE bg_user SET active_date = :date WHERE user_code = :usercode");
	$dbh->bindParam(':usercode', $res1['user_code'], PDO::PARAM_INT);
	$dbh->bindParam(':date', $date, PDO::PARAM_INT);
	$dbh->execute();

	return 'OK';
}
?>

<div class="column grid-cell grid-cell-3-4">
	<?php
	$error = "";
	if (isset($_POST['logi_uname']) && isset($_POST['logi_pw1'])) {
		$error = LoginByPassword($_POST['logi_uname'], $_POST['logi_pw1']);
		if ($error == 'OK') {
			header("Location: ./account");
			exit();
		}
	}
	?>

	<form action="./login" method="post">
		<div class="column-body grid">
			<div class="grid-cell grid-cell-2-3">
				<?php
				if (!empty($error)) {
				?>
					<div class="input-feedback help-panel-body">
						<p class="satisfied nsatisfied"><?php echo $error; ?></p>
					</div>
				<?php
				}
				?>
				<div class="password-entry">
					<div class=" form-group">
						<label class="form-group-label">LOGIN</label>
						<input class="form-input form-control" maxlength="15" type="text" name="logi_uname">
					</div>
					<div class=" form-group">
						<label class="form-group-label">PASSWORD</label>
						<input class="form-input form-control" maxlength="15" type="password" name="logi_pw1">
					</div>
				</div>
			</div>
		</div>
		<a class="formfp" href="./lostpw"><small>Forgot your password?</small></a>
		<div class="column-footer grid">
			<div class="grid-cell">
				<p class="button">
					<button class="button-input">Submit</button>
				</p>
			</div>
		</div>
	</form>
</div>