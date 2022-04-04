<?php
include_once("authenticate_login.php");
if ($_SESSION["username"] != "admin") exit;
$show_form = true;
if (isset($_GET["user"]) && isValidUser($_GET["user"])) {
	$user_query = $_GET["user"];
	if ($user_query == 'admin') {
		$message = MSG_ADMIN_DELETE;
		$show_form = false;
	}		
} else {
	die("Invalid username");
}
if (isset($_POST["delete_user"])) {
	// remove from active uesers
	$users_data = file_get_contents(LOGIN_INFO_FILE);
	$users_array = json_decode($users_data, true);
	for ($i = 0; $i < count($users_array); $i++) {
		$user = $users_array[$i];
		if ($user["username"] == $user_query) {
			$users_array[$i]["status"] = "deleted";
			break;
		}
	}
	$new_file_data = json_encode($users_array);
	file_put_contents(LOGIN_INFO_FILE, $new_file_data);
	$message = MSG_USER_DELETED;
	$show_form = false;
}
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Account - Delete User</title>
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
			<div><img src="images/icon_deleted_users.png"> <a href="users_deleted.php">Deleted users</a></div>
			<hr>
			<h2>Delete user</h2>
			<?php 
			if (isset($message)) print $message; 
			if ($show_form) {
				print "<form method='post'>
					<p>Do you really want to delete the user '$user_query'?</p>
					<p><input type='submit' name='delete_user' value='Delete'></p>
				</form>";
			}
			?>
		</section>
	</main>
</body>
</html>