<?php
include_once("config.php");
session_start();
if (!isset($_SESSION["loggedin"])) {
	header("location: " . LOGIN_URL);
} else if ($_SESSION["username"] != "admin") {
	$url = $_SERVER["REQUEST_URI"];
	$base_file_name = basename(substr($url, 0, strpos($url, ".")));
	if (!in_array($base_file_name, $_SESSION["user_permission_files"])) {
		print(MSG_NO_PERMISSION_PAGE);
		exit;
	}
}
?>