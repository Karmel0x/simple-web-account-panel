<?php
if (isset($_SESSION['user_id'])) {
	header("Location: ./account");
	exit();
}
?>

<div class="column grid-cell grid-cell-3-4">
	<?php
	$error = "";
	if (isset($_POST['reg_uname'])) {

		// flood check
		$dbh = dbc()->prepare("SELECT max(create_date) FROM bg_user WHERE ip = :ip");
		$dbh->bindParam(':ip', $GLOBALS['request_ip'], PDO::PARAM_INT);
		$dbh->execute();
		$result = $dbh->fetch();
		$time = strtotime($result[0]);

		if ((time() - $time) < 300)
			$error = 'You can only register 1 account for 5 minutes';

		else if (empty($_POST['reg_uname']) || !is_string($_POST['reg_uname']) || strlen($_POST['reg_uname']) < 4 || strlen($_POST['reg_uname']) > 15)
			$error = 'Username needs to be between 4 and 15 characters long';

		else if (!ctype_alnum($_POST['reg_uname']))
			$error = 'Username can only contain a-Z and 0-9';

		else if (empty($_POST['reg_pw1']) || !is_string($_POST['reg_pw1']) || strlen($_POST['reg_pw1']) < 4 || strlen($_POST['reg_pw1']) > 15)
			$error = 'Password needs to be between 4 and 15 characters long';

		else if (empty($_POST['reg_pw1']) || !is_string($_POST['reg_pw1']) || strcmp($_POST['reg_pw1'], $_POST['reg_pw2']) != 0)
			$error = 'The two passwords u entered are not the same';

		else if (empty($_POST['reg_email']) || !is_string($_POST['reg_email']) || strlen($_POST['reg_email']) < 1 || !filter_var($_POST['reg_email'], FILTER_VALIDATE_EMAIL))
			$error = 'Please enter a valid email address';

		else if (!isset($_POST['reg_tos']))
			$error = 'You have to accept the terms of service';

		else {
			$dbh = dbc()->prepare("SELECT count(*) FROM bg_user WHERE user_id = :userid");
			$dbh->bindParam(':userid', $_POST['reg_uname'], PDO::PARAM_STR);
			$dbh->execute();
			$result = $dbh->fetch();

			if ($result[0] != 0)
				$error = 'This username is already used by someone else';

			else {
				$dbh = dbc()->prepare("INSERT INTO bg_user (user_id, passwd, email, create_date, ip) VALUES (:userid, :passwd, :email, :date, :ip)");
				$passw = md5($_POST['reg_pw1']);
				$dbh->bindParam(':passwd', $passw, PDO::PARAM_STR);
				$dbh->bindParam(':userid', $_POST['reg_uname'], PDO::PARAM_STR);
				$dbh->bindParam(':email', $_POST['reg_email'], PDO::PARAM_STR);
				$dbh->bindParam(':ip', $GLOBALS['request_ip'], PDO::PARAM_STR);
				$date = date("Y-m-d H:i:s");
				$dbh->bindParam(':date', $date, PDO::PARAM_INT);
				$dbh->execute();
	?>
				<div class=" form-group">
					<label class="form-group-label">Registration is completed</label>
					<div class="help-panel-body">
						<br /><br />
						Have fun on <?php echo $GLOBALS['server_name']; ?>!
						<br /><br />
						Username: <?php echo $_POST['reg_uname']; ?><br />
						Password: <?php echo $_POST['reg_pw1']; ?><br />
						E-mail: <?php echo $_POST['reg_email']; ?><br />
					</div>
				</div>
	<?php
				echo '</div>';
				return true;
			}
		}
	}
	?>

	<form action="./register" method="post">
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
				<div class=" form-group">
					<label class="form-group-label">LOGIN</label>
					<input class="form-input form-control" maxlength="15" type="text" name="reg_uname" onchange="nameCheck(true);" value="<?php if (isset($_POST['reg_uname'])) echo $_POST['reg_uname']; ?>">
				</div>
				<div class=" form-group">
					<label class="form-group-label">E-MAIL</label>
					<input class="form-input form-control" maxlength="90" type="text" name="reg_email" oninput="mailCheck();" value="<?php if (isset($_POST['reg_email'])) echo $_POST['reg_email']; ?>">
				</div>
				<div class=" form-group">
					<label class="form-group-label">PASSWORD</label>
					<input class="form-input form-control" maxlength="15" type="password" name="reg_pw1" oninput="pw1Check();pw2Check();" value="<?php if (isset($_POST['reg_pw1'])) echo $_POST['reg_pw1']; ?>">
				</div>
				<div class=" form-group">
					<label class="form-group-label">REPEAT PASSWORD</label>
					<input class="form-input form-control" maxlength="15" type="password" name="reg_pw2" oninput="pw2Check();" value="<?php if (isset($_POST['reg_pw2'])) echo $_POST['reg_pw2']; ?>">
				</div>
				<label class="form-group-label">
					<input type="checkbox" style="vertical-align:middle;" name="reg_tos"> <small style="vertical-align:middle;">ACCEPT <a href="./about" target="_blank">RULES</a></small>
				</label>
			</div>
			<div class="grid-cell grid-cell-1-3">
				<div class="help-panel"><br>
					<div class="help-panel-body input-feedback">
						<p class="unsatisfied" id="namelen">Username needs to be between 4 and 15 characters long.</p>
						<p class="unsatisfied" id="namechar">Username can only contain a-Z and 0-9.</p>
						<p class="unsatisfied" id="nameuniq">Username have to be unique.</p>
						<p class="unsatisfied" id="mailvalid">Email address have to be valid.</p>
						<p class="unsatisfied" id="passlen">Password needs to be between 4 and 15 characters long.</p>
						<p class="unsatisfied" id="passchar">Password should contain at least one letter and number.</p>
						<p class="unsatisfied" id="passmatch">Passwords must match.</p>
					</div>
				</div>
			</div>
			<script src="./assets/register.js" type="text/javascript"></script>
		</div>
		<div class="column-footer grid">
			<div class="grid-cell">
				<p class="button">
					<button class="button-input">Submit</button>
				</p>
			</div>
		</div>
	</form>
</div>