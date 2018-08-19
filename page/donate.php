<?php
if(!isset($_SESSION['user_id'])){
	header("Location: ./login");
	exit();
}
?>
<iframe src="https://wall.superrewards.com/super/offers?h=your-app_key-here&uid=<?php echo $_SESSION['user_code']; ?>" frameborder="0" width="720" height="500" style="background-color:white"></iframe>
