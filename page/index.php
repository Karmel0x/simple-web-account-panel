<?php
if(isset($_SESSION['user_id']))
	header("Location: ./account");
else
	header("Location: ./login");

exit();
?>