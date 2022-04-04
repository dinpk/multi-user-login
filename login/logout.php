<?php 
include_once("config.php");
session_start();
session_destroy();
?>
<html>
<head>
	<meta charset="utf-8">
	<title>Logged out</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body id="page-loggedout">
	<p><?php print MSG_LOGGED_OUT; ?></p>
	<p><a href="<?php print LOGIN_URL; ?>">Login</a></p>
</body>
</html>
