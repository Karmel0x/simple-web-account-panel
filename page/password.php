<?php
if(!isset($_SESSION['user_id'])){
	header("Location: ./login");
	exit();
}
?>
<div class="column grid-cell grid-cell-3-4">
<?php
function ChangePasswordPOST(){
	global $db, $db1, $requestip;
	$regpw0 = "";
	if(isset($_SESSION['passwd'])) $regpw0 = $_SESSION['passwd'];
	else if(isset($_POST['reg_pw0']))$regpw0 = md5($_POST['reg_pw0']);
	else return 'Current password is wrong';
			
	if(strcmp($regpw0, md5($_POST['reg_pw1'])) == 0)
		return 'You can\'t reuse your old password.';
			
	if(strlen($_POST['reg_pw1']) < 4 || strlen($_POST['reg_pw1']) > 15)
		return 'Password needs to be between 4 and 15 characters long';
			
	if(strcmp($_POST['reg_pw1'], $_POST['reg_pw2']) != 0)
		return 'The two passwords u entered are not the same';

	$dbh = $db->prepare("SELECT passwd FROM $db1.bg_user WHERE user_code = :usercode");
	$dbh->bindParam(':usercode', $_SESSION['user_code'], PDO::PARAM_INT, 11);
	$dbh->execute();
	$res1 = $dbh->fetch();

	if($res1[0] != $regpw0)
		return 'Current password is wrong';

	$dbh = $db->prepare("INSERT INTO $db1.bg_action (user_code, a_type, a_val, a_date, a_ip) VALUES(:usercode, 1, :val, '".date("Y-m-d H:i:s")."', :ip)");
	$dbh->bindParam(':usercode', $_SESSION['user_code'], PDO::PARAM_INT, 11);//a_type 1=PWCHANGE
	$dbh->bindParam(':val', $res1[0], PDO::PARAM_STR, 32);//oldpw
	$dbh->bindParam(':ip', $requestip, PDO::PARAM_STR, 15);
	$dbh->execute();

	$dbh = $db->prepare("UPDATE $db1.bg_user SET passwd = :passwd WHERE user_code = :usercode");
	$passw = md5($_POST['reg_pw1']);
	$dbh->bindParam(':passwd', $passw, PDO::PARAM_STR, 32);
	$dbh->bindParam(':usercode', $_SESSION['user_code'], PDO::PARAM_INT, 11);
	$dbh->execute();

	if(isset($_SESSION['passwd']))
		unset($_SESSION['passwd']);
	
	return 'OK';
}
	$error = "";
	if(isset($_POST['reg_pw1']) && isset($_POST['reg_pw2'])){
		$error = ChangePasswordPOST();
		if($error == 'OK'){
			
			?>
			<div class=" form-group">
				<label class="form-group-label">Password change</label>
				<div class="help-panel-body input-feedback"><br>
					<p class="satisfied">Your password has been successfully changed!</p>
				</div>
			</div>
			<?php
			echo '</div>';
			return true;
		}
	}
?>
<form action="./password" method="post">
    <div class="column-body grid">
        <div class="grid-cell grid-cell-2-3">
<?php
if ($error != ""){
	?>
<div class="input-feedback help-panel-body">
	<p class="satisfied nsatisfied"><?php echo $error;?></p>
</div>
	<?php
}
?>
            <div class="password-entry">
                <div class=" form-group">
                    <label class="form-group-label">CURRENT PASSWORD</label>
                    <input class="form-input form-control" maxlength="15" type="password" name="reg_pw0" <?php if(isset($_SESSION['passwd']))echo 'value="****" style="color:grey;" disabled';?>>
                </div>
                <hr>
                <div class=" form-group">
                    <label class="form-group-label">NEW PASSWORD</label>
                    <input class="form-input form-control" maxlength="15" type="password" name="reg_pw1" oninput="pw1Check();pw2Check();">
                </div>
                <div class=" form-group">
                    <label class="form-group-label">REPEAT NEW PASSWORD</label>
                    <input class="form-input form-control" maxlength="15" type="password" name="reg_pw2" oninput="pw2Check();">
                </div>
				<div class="input-feedback help-panel-body">
					<p class="unsatisfied" id="passre">You can't reuse your old password.</p>
					<p class="unsatisfied" id="passlen">Password needs to be between 4 and 15 characters long.</p>
					<p class="unsatisfied" id="passchar">Password should contain at least one letter and number.</p>
					<p class="unsatisfied" id="passmatch">Passwords must match.</p>
				</div>
            </div>
        </div><script src="./assets/password.js" type="text/javascript"></script>
    </div>
    <div class="column-footer grid">
        <div class="grid-cell">
            <p class="button">
                <button class="button-input">Submit</button>
            </p>
            <p class=" button">
                <a class="button-input" href="./account" style="display:block;text-align:center;text-decoration:none;box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;">Cancel</a>
            </p>
        </div>
    </div>
</form>
</div>