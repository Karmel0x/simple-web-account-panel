<?php return;
if(!isset($_SESSION['user_id'])){
	header("Location: ./login");
	exit();
}
?>
<iframe src="https://api.paymentwall.com/api/ps/?key=your-app_key-here&widget=p10_1&uid=<?php echo $_SESSION['user_code']; ?>" frameborder="0" width="720" height="500"></iframe>
