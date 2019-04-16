<?php
	$page = empty($_GET['page']) ? 'index' : preg_replace("/[^a-zA-Z0-9]/", "", $_GET['page']);

	session_start();

	if(isset($_GET['logout'])){
		$_SESSION = array();
		session_destroy();
		$page = 'login';
	}

	include_once "./assets/config.php";
	try{$db = new PDO("mysql:host=".$sql_host, $sql_user, $sql_pass);}
	catch(PDOException $e){echo('<div style="display:block;position:fixed;">Error connecting to the database</div>');}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>LC Account Management</title>
    <meta name="google" content="notranslate">
    <meta name="viewport" content="width=device-width, user-scalable=no, maximum-scale=1.0">
	<meta name="author" content="https://github.com/Karmel0x">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="./assets/app.css" rel="stylesheet">
    <link href="./favicon.ico" rel="shortcut icon">

</head>

<body class="headbar-present" style="background-position-y: 52px;">

	<div class="panel-frame">
		<div class="column-header">
			<header class="header">
				<nav>
				<a class="breadcrumb active" href="/">HOME / </a>
				<a class="breadcrumb active" style="text-transform: uppercase" href="./<?php echo $page; ?>"><?php echo $page; ?></a>
				<?php if(isset($_SESSION['user_id'])){ ?><a class="breadcrumb active" href="./account"><?php echo $_SESSION['user_id']; ?></a><?php } ?>
				</nav>
				<hr>
			</header>
		</div>
		<div class="column-body grid" style="min-height: 500px;">
			<div class="column grid-cell grid-cell-1-4 no-gutters">
				<div class="column-body">
					<nav class="menu">
						<?php
						if(isset($_SESSION['user_id'])){ ?>
						<a class="menu-item <?php if($page == 'account')echo 'menu-item-active';?>" href="./account">ACCOUNT</a>
						<a class="menu-item <?php if($page == 'donatepp')echo 'menu-item-active';?>" href="./donatepp">DONATE PAYPAL</a>
						<a class="menu-item <?php if($page == 'donate')echo 'menu-item-active';?>" href="./donate">DONATE SUPER REWARDS</a>
						<a class="menu-item <?php if($page == 'logout')echo 'menu-item-active';?>" href="./logout">LOGOUT</a>
						<?php }else{ ?>
						<a class="menu-item <?php if($page == 'register')echo 'menu-item-active';?>" href="./register">REGISTER</a>
						<a class="menu-item <?php if($page == 'login')echo 'menu-item-active';?>" href="./login">LOGIN</a>
						<?php } ?>
						<div class="menu-item"></div>
						<a class="menu-item <?php if($page == 'download')echo 'menu-item-active';?>" href="./download">DOWNLOAD</a>
						<a class="menu-item <?php if($page == 'about')echo 'menu-item-active';?>" href="./about">ABOUT</a>
					</nav>
				</div>
				<div class="column-footer"><a href="https://github.com/Karmel0x/simple-web-account-panel" class="version desktop-only">GITHUB</a></div>
			</div>
			
			<?php
			$inc = include "page/".$page.".php";
			if(!$inc){?>
			Error 404 - Page not found.
			<?php } ?>
		
		</div>
	</div>

    <div id="headbar-bar" class="headbar-base-element headbar-mobile-responsive headbar-brand-lol headbar-bar-content" lang="en">
        <div id="headbar-navbar" style="padding-left: 0px; padding-right: 0px; margin-left: 0px; visibility: visible;">
            <a class="headbar-navbar-link" href="../">Home</a>
            <a class="headbar-navbar-link" href="./register">Register</a>
            <a class="headbar-navbar-link" href="./download">Download</a>
            <a class="headbar-navbar-link" href="./about">About</a>
            <a class="headbar-navbar-link" href="https://board.lastchaos.com">Forum</a>
            <a class="headbar-navbar-link" href="./donate">Donate</a>
        </div>
    </div>
</body>

</html>
