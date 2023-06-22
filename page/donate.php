<?php
if (!isset($_SESSION['user_id'])) {
	header("Location: ./login");
	exit();
}
?>

<?php
if (empty($GLOBALS['superrewards_app_key'])) {
?>
	Selected donate method is currently unavailable
<?php
} else {
?>

	<iframe src="https://wall.superrewards.com/super/offers?h=<?php echo $GLOBALS['superrewards_app_key']; ?>&uid=<?php echo $_SESSION['user_code']; ?>" frameborder="0" width="720" height="500" style="background-color:white"></iframe>

<?php
}
?>