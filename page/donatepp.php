<?php
if (!isset($_SESSION['user_id'])) {
	header("Location: ./login");
	exit();
}
?>

<?php
if (empty($GLOBALS['paypal_hosted_button_id'])) {
?>
	Selected donate method is currently unavailable
<?php
} else {
?>

	<div style="margin-left: auto;margin-right: auto;text-align: center;">
		<br /><br />
		<img src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/cc-badges-ppmcvdam.png"><br /><br />
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top" style="display:hidden">
			<input type="hidden" name="cmd" value="_s-xclick">
			<input type="hidden" name="hosted_button_id" value="<?php echo $GLOBALS['paypal_hosted_button_id']; ?>">
			<input type="hidden" name="on0" value="cash">
			<input type="hidden" name="on1" value="user_code">
			<input type="hidden" name="os1" value="<?php echo $_SESSION['user_code']; ?>">
			<input type="hidden" name="currency_code" value="USD">

			<div>cash</div>
			<select name="os0">
				<option value="1000">1000 - $1.00 USD</option>
				<option value="5000">5000 - $5.00 USD</option>
				<option value="10000">10000 - $10.00 USD</option>
				<option value="25000">25000 - $25.00 USD</option>
				<option value="50000">50000 - $50.00 USD</option>
			</select>
			<br /><br />

			<input type="image" src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/buy-logo-large.png" name="submit" alt="PayPal - The safer, easier way to pay online!">
			<br /><br />
		</form>
	</div>

<?php
}
?>