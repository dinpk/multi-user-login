<?php 	
include_once("authenticate_login.php");
if ($_SESSION["username"] != "admin") exit;
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Account - Users</title>
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
			<div><img src="images/icon_add_user.png"> <a href="user_add.php">Add new user</a></div>
			<hr>
			<h2>Users</h2>
			<?php if (isset($message)) print $message; ?>
			<?php
			$html = "";
			$users_data = file_get_contents(LOGIN_INFO_FILE);
			$users_array = json_decode($users_data, true);
			for ($i = 0; $i < count($users_array); $i++) {
				$user = $users_array[$i];
				$username = $user["username"];
				if ($user["status"] == "active") {
					$html .= "
					<tr>
						<td>$username</td>
						<td><a href='user_permissions.php?user=$username' title='Permissions'><img src='images/icon_permissions.png'></a></td>
						<td><a href='user_password.php?user=$username' title='Password'><img src='images/icon_password.png'></a></td>
						<td><a href='user_delete.php?user=$username' title='Delete'><img src='images/icon_delete.png'></a></td>
					</tr>
					";
				}
			}
			print "<table cellspacing='20'>$html</table>";
			?>
		</section>
	</main>
</body>
</html>