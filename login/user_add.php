<?php 	
include_once("authenticate_login.php");
if ($_SESSION["username"] != "admin") exit;
$message = "";
if (isset($_POST["add_user"])) {
	$error = 0;
	$password = (isset($_POST["password"]) ? trim($_POST["password"]) : '');
	if (strlen($password) < PASSWORD_MIN_LENGTH || strlen($password) > PASSWORD_MAX_LENGTH) {
		$message .= MSG_PASSWORD_LENGTH;
		$error = 1;
	}
	$new_username = (isset($_POST["new_username"]) ? trim($_POST["new_username"]) : '');
	if (strlen($new_username) < USERNAME_MIN_LENGTH || strlen($new_username) > USERNAME_MAX_LENGTH) {
		$message .= MSG_USERNAME_LENGTH;
		$error = 1;
	}
	if (isValidUser($new_username) || isValidDeletedUser($new_username)) {
		$message .= MSG_USERNAME_EXISTS;
		$error = 1;
	}
	if ($error == 0) {
		$users_data = file_get_contents(LOGIN_INFO_FILE);
		$users_array = json_decode($users_data, true);
		$password_hash = password_hash($password, PASSWORD_DEFAULT);
		$new_user["username"] = $new_username;
		$new_user["password"] = $password_hash;
		$new_user["status"] = "active";
		$permission_files = ["index.php"];
		$new_user["permission_files"] = $permission_files;
		$users_array[] = $new_user;
		$new_file_data = json_encode($users_array);
		$result = file_put_contents(LOGIN_INFO_FILE, $new_file_data);
		if ($result) {
			unset($new_username);
			unset($password);
			$message = MSG_USER_ADDED;
		} else {
			$message = MSG_USER_ADDING_FAILED;
		}
	}
}
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Account - Add User</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>
	<header>
		<h1>Manage Account</h1>
	</header>
	<main>
		<section id="left-column">
			<?php include("menu.php"); ?>
		</section>
		<section id="right-column">
			<h2>New user</h2>
			<?php if (isset($message)) print $message; ?>
			<form method="post">
				<p><input type="text" name="new_username" placeholder="username" value="<?php if (isset($new_username)) {print $new_username; } else {print "";} ?>" autofocus></p>
				<p><input type="password" name="password" placeholder="password" value="<?php if (isset($password)) {print $password; } else {print "";} ?>"></p>
				<p><input type="submit" name="add_user" value="Add"></p>
			</form>
		</section>
	</main>
</body>
</html>