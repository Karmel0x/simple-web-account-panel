<?php
	$error = "";
	if(isset($_POST['set_pw1'])){

		if(strlen($_POST['set_pw1']) < 4 || strlen($_POST['set_pw1']) > 15)
			$error = 'Password needs to be between 4 and 15 characters long';
		
		else if(strcmp($_POST['set_pw1'], $_POST['set_pw2']) != 0)
			$error = 'The two passwords u entered are not the same';

        else {
            $dbh = $db->prepare("SELECT passwd FROM $db1.bg_user WHERE user_code = :usercode");
            $dbh->bindParam(':usercode', $_SESSION['user_code'], PDO::PARAM_INT, 11);
            $dbh->execute();
            $result = $dbh->fetch();

            if($result[0] != md5($_POST['set_pw0']))
                $error = 'Old password is not correct';
               
            else {
				$dbh = $db->prepare("UPDATE $db1.bg_user SET passwd = :passwd, passwd_plain = :passwdplain WHERE user_code = :usercode");
				$dbh->bindParam(':passwd', md5($_POST['set_pw1']), PDO::PARAM_STR, 45);
                $dbh->bindParam(':usercode', $_SESSION['user_code'], PDO::PARAM_STR, 15);
				$dbh->bindParam(':passwdplain', $_POST['set_pw1'], PDO::PARAM_STR, 45);
                $dbh->execute();
				?>
	<div style="width: 80%;margin: 0 auto 20px auto;">
		<span class="input-group-addon" style="background-color: #25e000;height: 44px;border: 0;border-radius: 4px;color: white;">
					<h4>success</h4>
		</span>
	</div>
				<?php
            }
        }
	}
	
if ($error != ""){
	?>
	<div style="width: 80%;margin: 0 auto 20px auto;">
		<span class="input-group-addon" style="background-color: #ff4545;height: 44px;border: 0;border-radius: 4px;color: white;">
		<?php
		echo $error;
		?>
		</span>
	</div>
	<?php
}
?>

<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="row">
            <div class="col-md-6">
                <div class="block">
                    <div class="block-title">
                        <h2><img src="./template/edit.png"> <strong>Change Password to</strong> Your Account!</h2>
                    </div>
                    <div class="block-content">
                        <p></p>
                        <legend></legend>
                        <form name="master_account_change_password" action="" id="form-change-password-ma" class="form-bordered" method="post" onsubmit="return false;"><input name="module" value="global_informaiton_block" type="hidden"><input name="action" value="change_password_ma" type="hidden">
                            <div class="form-group">
                                <div class="input-group"><span class="input-group-addon"><img src="./template/key.png"></span><input name="set_pw0" id="change-password" class="form-control" placeholder="Old password" type="password"></div>
                            </div>
                            <div class="form-group">
                                <div class="input-group"><span class="input-group-addon"><img src="./template/key.png"></span><input name="set_pw1" id="change-password" class="form-control" placeholder="New password" type="password"></div>
                            </div>
                            <div class="form-group">
                                <div class="input-group"><span class="input-group-addon"><img src="./template/key.png"></span><input name="set_pw2" id="change-password-verify" class="form-control" placeholder="Retype your new password" type="password"></div>
                            </div>
                            <div class="form-group">
                                <div class="input-group"><span class="input-group-addon"><i class="fa fa-expeditedssl"></i></span><input name="change-password-pin" class="form-control" placeholder="Enter the Pin-code" type="password"></div>
                            </div>
                            <div class="form-group form-actions">
                                <div style="min-height: 30px">
                                    <div class="col-xs-8">
                                        <div class="show_master_account_change_password"></div>
                                    </div>
                                    <div class="col-xs-3"><button type="submit" id="change_password_master_account" class="btn btn-sm btn-success submit-btn"><i class="fa fa-angle-right"></i> Change password</button></div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="block">
                    <div class="block-title">
                        <h2><img src="./template/edit.png"> <strong>Restore</strong> PIN-CODE!</h2>
                    </div>
                    <div class="block-content">
                        <p></p>
                        <legend></legend>
                        <form name="pin_recovery_password" action="" id="form-recovery-password" class="form-bordered" method="post" onsubmit="return false;"><input name="module" value="global_informaiton_block" type="hidden"><input name="action" value="recovery-pin" type="hidden">
                            <div class="form-group text-center">
                                <h4>Do you really want to restore the Pin-code?</h4>
                            </div>
                            <div class="form-group form-actions">
                                <div class="center-block" style="min-height: 30px">
                                    <div class="col-md-10 col-md-offset-5 col-xs-10 col-xs-offset-5">
                                        <div class="show_pin_recovery_password"></div><button type="submit" class="btn btn-sm btn-primary submit-btn"> Yes</button></div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-12">
        <div class="row">
            <div class="col-md-6">
                <div class="block">
                    <div class="block-title">
                        <h2><img src="./template/message.png"> <strong>Сonfirm</strong> E-mail!</h2>
                    </div>
                    <div class="block-content">
                        <p>Confirmed E-mail will allow you to use all functionality of the Control Panel.</p>
                        <legend></legend>
                        <form name="create" action="" class="form-horizontal" method="post" onsubmit="return false;">
                            <div class="show_create">
                                <p>Registration E-mail. - <span class="themed-color-autumn"><?php echo $_SESSION['user_id']; ?></span></p>
                                <p>You will receive an E-mail with a confirmation code. In the form below, you will be able to bind E-mail by using this code.</p><input name="create_key" value="key" type="hidden"><input name="module" value="block_wedget_settings_bind_email"
                                    type="hidden">
                                <legend></legend>
                                <div class="form-actions"><button type="submit" class="btn btn-primary submit-btn">Send a letter</button></div>
                            </div>
                        </form>
                    </div>
                    <p class="text-muted"></p>
                </div>
            </div>
        </div>
    </div>
</div>