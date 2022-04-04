<?php 	
include_once("authenticate_login.php");
if ($_SESSION["username"] != "admin") exit;
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Account -  Deleted Users</title>
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
			<h2>Deleted Users</h2>
			<?php if (isset($message)) print $message; ?>
			<?php
			$html = "";
			$users_data = file_get_contents(LOGIN_INFO_FILE);
			$users_array = json_decode($users_data, true);
			for ($i = 0; $i < count($users_array); $i++) {
				$user = $users_array[$i];
				$username = $user["username"];
				if ($user["status"] == "deleted") {
					$html .= "
					<tr>
						<td>$username</td>
						<td><a href='user_undelete.php?user=$username' title='Un-delete'><img src='images/icon_undelete.png'></a></td>
					</tr>";
				}
			}
			print "<table cellspacing='20'>$html</table>";
			?>
		</section>
	</main>
</body>
</html>