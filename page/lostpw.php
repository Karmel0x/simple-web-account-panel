<?php
if (isset($_SESSION['user_id'])) {
	header("Location: ./account");
	exit();
}

function LoginByToken($login, $token) {
	if (!ctype_alnum($login) || !ctype_alnum($token))
		return 'Error 1'; //Username / Token can only contain a-Z and 0-9

	$dbh = dbc()->prepare("SELECT user_code, a_date FROM bg_action WHERE a_type = 3 AND a_val = :token"); //a_type 3=LOSTPW
	$dbh->bindParam(':token', $_GET['token'], PDO::PARAM_STR);
	$dbh->execute();

	if ($dbh->rowCount() != 1)
		return 'Error 2'; //Token is incorrect

	$res1 = $dbh->fetch();
	if ((time() - strtotime($res1['a_date'])) > 36000)
		return 'Token expired'; //Error 3

	$dbh = dbc()->prepare("SELECT user_id, user_code, passwd FROM bg_user WHERE user_code = :usercode");
	$dbh->bindParam(':usercode', $res1['user_code'], PDO::PARAM_INT);
	$dbh->execute();

	if ($dbh->rowCount() != 1)
		return 'Error 4'; //Username is incorrect

	$res2 = $dbh->fetch();
	if ($res2['user_id'] != $_GET['account'])
		return 'Error 5'; //Username is incorrect

	session_regenerate_id();
	$_SESSION['user_id'] = $res2['user_id'];
	$_SESSION['user_code'] = $res2['user_code'];
	$_SESSION['passwd'] = $res2['passwd'];
	session_write_close();
	$dbh = dbc()->prepare("UPDATE bg_user SET active_date = :date WHERE user_code = :usercode");
	$dbh->bindParam(':usercode', $res1['user_code'], PDO::PARAM_INT);
	$date = date("Y-m-d H:i:s");
	$dbh->bindParam(':date', $date, PDO::PARAM_INT);
	$dbh->execute();

	return 'OK';
}

function InitReminder($email) {

	if (empty($email) || !is_string($email) || strlen($email) < 3 || !filter_var($email, FILTER_VALIDATE_EMAIL))
		return 'Please enter a valid email address';

	$dbh = dbc()->prepare("SELECT max(a_date) FROM bg_action WHERE a_ip = :ip");
	$dbh->bindParam(':ip', $GLOBALS['request_ip'], PDO::PARAM_INT);
	$dbh->execute();
	$result = $dbh->fetch();

	if ((time() - strtotime($result[0])) < 300) // FloodCheck
		return 'You can init reminder only 1 time per 5 minutes';

	$dbh = dbc()->prepare("SELECT * FROM bg_user WHERE email = :email");
	$dbh->bindParam(':email', $email, PDO::PARAM_STR);
	$dbh->execute();

	if ($dbh->rowCount() < 1)
		return 'E-mail not found';

	$message = '<br>To change your password, click the link below:<br>';
	while ($result = $dbh->fetch()) {
		$dbh = dbc()->prepare("INSERT INTO bg_action (user_code, a_type, a_val, a_date, a_ip) VALUES (:usercode, 3, :val, :date, :ip)");
		$dbh->bindParam(':usercode', $result['user_code'], PDO::PARAM_INT); //a_type 3=LOSTPW

		$token = md5($result['user_id'] . rand(1000, 9999));
		$dbh->bindParam(':val', $token, PDO::PARAM_STR);
		$dbh->bindParam(':ip', $GLOBALS['request_ip'], PDO::PARAM_STR);
		$date = date("Y-m-d H:i:s");
		$dbh->bindParam(':date', $date, PDO::PARAM_INT);
		$dbh->execute();
		$message .= (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']) . '/?page=lostpw&account=' . $result['user_id'] . '&token=' . $token . "<br>";
	}
	$message .= '<br>If you did not request a password change, please ignore this email, no changes will be made to your account.<br>';

	$headers  = 'MIME-Version: 1.0' . "\r\n" .
		"Content-Type: text/html;charset=utf-8\n" .
		"Content-Transfer-Encoding: 8bit\n" .
		"FROM: " . $GLOBALS['server_name'] . " <noreply@" . $_SERVER['SERVER_NAME'] . ">";
	$sent = mail($email, $GLOBALS['server_name'] . ' password change request', $message, $headers);

	if(!$sent)
		return 'Error while sending email, try again later';

	return 'OK';
}
?>

<div class="column grid-cell grid-cell-3-4">
	<?php
	$error = "";
	if (isset($_GET['account']) && isset($_GET['token'])) {
		$error = LoginByToken($_GET['account'], $_GET['token']);
		if ($error == 'OK') {
			header("Location: ./password");
			exit();
		}
	} else if (isset($_POST['reg_email'])) {
		$error = InitReminder($_POST['reg_email']);
		if ($error == 'OK') {
	?>

			<div class="form-group">
				<label class="form-group-label">Lost password</label>
				<div class="input-feedback help-panel-body"><br>
					<p class="satisfied">E-mail sent. Sometimes it may take a few minutes before this email reaches your inbox.<br>If you can't find it, check spam folder.</p>
				</div>
			</div>

	<?php
			echo '</div>';
			return true;
		}
	}
	?>

	<label class="form-group-label">Lost password</label>
	<form action="./lostpw" method="post">
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
						<label class="form-group-label">E-mail</label>
						<div class="form-group-contents">
							<input class="form-input form-control" maxlength="90" type="text" name="reg_email">
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="column-footer grid">
			<div class="grid-cell">
				<p class="button">
					<button class="button-input">Submit</button>
				</p>
				<p class=" button">
					<a class="button-input" href="./login" style="display:block;text-align:center;text-decoration:none;box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;">Cancel</a>
				</p>
			</div>
		</div>
	</form>
</div>