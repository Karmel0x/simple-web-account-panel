<?php
if (!isset($_SESSION['user_id'])) {
	header("Location: ./login");
	exit();
}
?>

<?php
if (empty($GLOBALS['paymentwall_app_key'])) {
?>
	Selected donate method is currently unavailable
<?php
} else {
?>

	<iframe src="https://api.paymentwall.com/api/ps/?key=<?php echo $GLOBALS['paymentwall_app_key']; ?>&widget=p10_1&uid=<?php echo $_SESSION['user_code']; ?>" frameborder="0" width="720" height="500"></iframe>

<?php
}
?>