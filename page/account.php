<?php
if(!isset($_SESSION['user_id'])){
	header("Location: ./login");
	exit();
}

	$dbh = $db->prepare("SELECT cash, email FROM $db1.bg_user WHERE user_code = :usercode");
	$dbh->bindParam(':usercode', $_SESSION['user_code'], PDO::PARAM_INT, 11);
	$dbh->execute();
	$result = $dbh->fetch();
?>
			<div class="column grid-cell grid-cell-3-4">
				<div class="column-body grid">
					<div class="grid-cell">
						<!-- div class="prompt">
							<p class="prompt-body">Your email address is currently unverified. Click 'Verify Now' to send a confirmation email.</p>
							<div class="prompt-actions">
								<p class="button-submit undefined button">
									<button class="button-input">Verify Now</button>
								</p>
							</div>
						</div -->
						<div class=" form-group">
							<label class="form-group-label">EMAIL ADDRESS</label>
							<div class="form-group-contents">
								<div class="edit-link">
									<div class="edit-link-contents"><span><?php echo $result['email']; ?></span></div>
									<!-- div class="edit-link-button">
										<a href="./email"></a>
									</div -->
								</div>
							</div>
						</div>
						<div class=" form-group">
							<label class="form-group-label">PASSWORD</label>
							<div class="form-group-contents">
								<div class="edit-link">
									<div class="edit-link-contents">***************</div>
									<div class="edit-link-button">
										<a href="./password"></a>
									</div>
								</div>
							</div>
						</div>
						<div class=" form-group">
							<label class="form-group-label">CASH BALANCE</label>
							<div class="form-group-contents">
								<div class="edit-link-contents"><?php echo $result['cash']; ?></div>
							</div>
						</div>
					</div>
				</div>
			</div>