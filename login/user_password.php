<?php 	
include_once("authenticate_login.php");
if ($_SESSION["username"] != "admin") exit;
if (isset($_GET["user"]) && isValidUser($_GET["user"])) {
	$user_query = $_GET["user"];
} else {
	die("Invalid username");
}
if (isset($_POST["submit_button"])) {
	$new_password = isset($_POST["new_password"]) ? trim($_POST["new_password"]) : "";
	if ((strlen($new_password) < PASSWORD_MIN_LENGTH) || (strlen($new_password) > PASSWORD_MAX_LENGTH)) {
		$message = MSG_PASSWORD_LENGTH;
	} else {
		$new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
		$users_data = file_get_contents(LOGIN_INFO_FILE);
		$users_array = json_decode($users_data, true);
		for ($i = 0; $i < count($users_array); $i++) {
			$user = $users_array[$i];
			if ($user["username"] == $user_query) {
				$users_array[$i]["password"] = $new_password_hash;
				break;
			}
		}
		$new_file_data = json_encode($users_array);
		file_put_contents(LOGIN_INFO_FILE, $new_file_data);
		$message = MSG_PASSWORD_UPDATED;
		unset($old_password);
	}
}
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Account - User Password</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>
	<header>
		<h1>Manage Account</h1>
	</header>
	<main>
		<section id="left-column">
			<?php include("menu.php");?>
		</section>
		<section id="right-column">
			<h2>Change password for user '<?php print $user_query; ?>'</h2>
			<?php if (isset($message)) print $message; ?>
			<form method="post">
				<br>
				New password<br>
				<input type="password" id="new_password" name="new_password" value="<?php if (isset($new_password)) print $new_password; ?>" required autofocus><br><br>
				<input type="submit" name="submit_button" value="Update">
			</form>
		</section>
	</main>
</body>
</html>