<?php 	
include_once("authenticate_login.php");
if ($_SESSION["username"] != "admin") exit;
$show_form = true;
if (isset($_GET["user"]) && isValidDeletedUser($_GET["user"])) {
	$user_query = $_GET["user"];
	if ($user_query == "admin") {
		$message = MSG_ADMIN_DELETE;
		$show_form = false;
	}		
} else {
	die("Invalid username");
}
if (isset($_POST["undelete_user"])) {
	$users_data = file_get_contents(LOGIN_INFO_FILE);
	$users_array = json_decode($users_data, true);
	for ($i = 0; $i < count($users_array); $i++) {
		$user = $users_array[$i];
		if ($user["username"] == $user_query) {
			$users_array[$i]["status"] = "active";
			break;
		}
	}
	$new_file_data = json_encode($users_array);
	file_put_contents(LOGIN_INFO_FILE, $new_file_data);
	$message = MSG_USER_UNDELETED;
	$show_form = false;
}
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Account - Un-delete User</title>
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
			<h2>Un-delete user</h2>
			<?php if (isset($message)) print $message; ?>
			<?php 
			if ($show_form) {
			print "<form method='post'>
				<p>Do you really want to un-delete the user '$user_query'?</p>
				<p><input type='submit' name='undelete_user' value='Un-delete'></p>
			</form>";
			}
			?>
		</section>
	</main>
</body>
</html>