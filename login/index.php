<?php 	
include_once("config.php");
if (isset($_POST["submit_button"])) {
	$username = isset($_POST["username"]) ? trim($_POST["username"]) : "";
	$password = isset($_POST["password"]) ? trim($_POST["password"]) : "";
	if (empty($username) || empty($password)) {
		$message = MSG_REQUIRED_INFO;
	} else if (!isValidUsernamePassword($username, $password)) {
		$message = MSG_INVALID_LOGIN;
	} else {
		session_start();
		$_SESSION["loggedin"] = true;
		$_SESSION["username"] = $username;
		$_SESSION["user_permission_files"] = getUserPermissionFiles($username);
		header("location:" . HOME_URL);
		exit;
	}
}
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Login</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body id="page-login">
	<br>
	<form method="post">
		<h1>Login</h1>
		<?php if (isset($message)) print $message . "<br>"; ?>
		<input type="text" id="username" name="username" placeholder="username" value="<?php if (isset($username)) print $username; ?>" autofocus required><br>
		<input type="password" id="password" name="password" placeholder="password" value="<?php if (isset($password)) print $password; ?>" required><br><br>
		<input type="submit" name="submit_button" value="Login">
	</form>
</body>
</html>