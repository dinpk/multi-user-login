<?php 	
include_once("authenticate_login.php");
$username = $_SESSION["username"];
if (isset($_POST["submit_button"])) {
	$old_password = isset($_POST["old_password"]) ? trim($_POST["old_password"]) : "";
	$new_password1 = isset($_POST["new_password1"]) ? trim($_POST["new_password1"]) : "";
	$new_password2 = isset($_POST["new_password2"]) ? trim($_POST["new_password2"]) : "";
	if (empty($old_password) || empty($new_password1) || empty($new_password2)) {
		$message = MSG_REQUIRED_INFO;
	} else if ($new_password1 != $new_password2) {
		$message = MSG_RETYPED_PASSWORD;
	} else if ((strlen($new_password1) < PASSWORD_MIN_LENGTH) || (strlen($new_password1) > PASSWORD_MAX_LENGTH)) {
		$message = MSG_PASSWORD_LENGTH;
	} else if (!isValidUsernamePassword($username, $old_password)) {
		$message = MSG_OLD_PASSWORD;
	} else {
		$new_password_hash = password_hash($new_password1, PASSWORD_DEFAULT);
		$users_data = file_get_contents(LOGIN_INFO_FILE);
		$users_array = json_decode($users_data, true);
		for ($i = 0; $i < count($users_array); $i++) {
			$user = $users_array[$i];
			if ($user["username"] == $username) {
				$users_array[$i]["password"] = $new_password_hash;
				break;
			}
		}
		$new_file_data = json_encode($users_array);
		file_put_contents(LOGIN_INFO_FILE, $new_file_data);
		$message = MSG_PASSWORD_UPDATED;
		unset($old_password);
		unset($new_password1);
		unset($new_password2);
	}
}
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Account</title>
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
			<h2>Change password</h2>
			<?php if (isset($message)) print $message; ?>
			<form method="post" action="change_password.php">
				<br>
				Old password<br>
				<input type="password" id="old_password" name="old_password" 
					value="<?php if (isset($old_password)) print $old_password; ?>" required autofocus><br><br>
				New password<br>
				<input type="password" id="new_password1" name="new_password1" 
					value="<?php if (isset($new_password1)) print $new_password1; ?>" required><br><br>
				Retype new password<br>
				<input type="password" id="new_password2" name="new_password2" 
					value="<?php if (isset($new_password2)) print $new_password2; ?>" required><br><br>
				<input type="submit" name="submit_button" value="Update">
			</form>
		</section>
	</main>
</body>
</html>