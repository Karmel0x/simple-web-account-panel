<?php
if(!isset($_SESSION['user_id'])){
	header("Location: ./login");
	exit();
}
?>
<center style="margin-left: auto;margin-right: auto;">
	<br/><br/>
	<img src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/cc-badges-ppmcvdam.png"><br/><br/>
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top" style="display:hidden">
		<input type="hidden" name="cmd" value="_s-xclick">
		<input type="hidden" name="hosted_button_id" value="your-hosted_button_id-here">
		<table>
		<tr><td><input type="hidden" name="on0" value="cash">cash</td></tr><tr><td>
		<select name="os0">
			<option value="1000">1000 - $1.00 USD</option>
			<option value="5000">5000 - $5.00 USD</option>
			<option value="10000">10000 - $10.00 USD</option>
			<option value="25000">25000 - $25.00 USD</option>
			<option value="50000">50000 - $50.00 USD</option>
		</select> </td></tr>
		<input type="hidden" name="on1" value="user_code">
		<input type="hidden" name="os1" value="<?php echo $_SESSION['user_code'];?>">
		</table>
		<input type="hidden" name="currency_code" value="USD"><br/>
		<input type="image" src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/buy-logo-large.png" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
		<br/><br/>
	</form>
</center>
