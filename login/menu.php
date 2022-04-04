<?php
	$username = $_SESSION["username"];
	print "
		<h3>$username</h3>
		<table>
		<tr><td><img src='images/icon_loggedin_app.png'></td><td><a href='../index.php'>Application</a></td></tr>";
		if ($username == "admin") print "<tr><td><img src='images/icon_users.png'></td><td><a href='users.php'> Users</a></td></tr>";
	print "
		<tr><td><img src='images/icon_change_password.png'></td><td><a href='change_password.php'>Change password</a></td></tr>
		<tr><td><img src='images/icon_logout.png'></td><td><a href='logout.php'>Logout</a></td></tr>
		</table>
		";
?>