<?php
include_once("authenticate_login.php");
if ($_SESSION["username"] != "admin") exit;
if (isset($_GET["user"]) && isValidUser($_GET["user"])){
	$user_query = $_GET["user"];
} else {
	die("Invalid username");
}
$directory_files = glob(USER_PERMISSION_FILES);
if (isset($_POST["set_permissions"])) {
	$checked_files_array = array();
	for ($i = 0; $i < sizeof($directory_files); $i++) {
		$base_name = basename($directory_files[$i]);
		$base_name = str_replace(".php", "", $base_name);
		if (array_key_exists($base_name, $_POST)) {
			$checked_files_array[] = $base_name;
		}
	}
	$users_data = file_get_contents(LOGIN_INFO_FILE);
	$users_array = json_decode($users_data, true);
	for ($i = 0; $i < count($users_array); $i++) {
		$user = $users_array[$i];
		if ($user["username"] == $user_query) {
			$users_array[$i]["permission_files"] = $checked_files_array;
			break;
		}
	}	
	$new_file_data = json_encode($users_array);
	file_put_contents(LOGIN_INFO_FILE, $new_file_data);
	$message = MSG_PERMISSIONS_SAVED;
}
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Account - User Permissions</title>
	<link rel="stylesheet" href="styles.css">
	<script>
		function checkBoxes(option) {
			var boxes = document.querySelectorAll("input[type='checkbox']");
			if (option == "check") {
				for (i = 0; i < boxes.length; i++) {
					boxes[i].checked = true;
				}
			} else {
				for (i = 0; i < boxes.length; i++) {
					boxes[i].checked = false;
				}
			}
		}
	</script>
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
			<?php if (isset($message)) print $message; ?>
			<h2>Permissions for user '<?php print $user_query; ?>'</h2>
			<form method="post">
			<p>
				<input type="button" value="Select all" onclick="checkBoxes('check');"> 
				<input type="button" value="Un-select all" onclick="checkBoxes('');"> 
			</p>
			<div id="permission-files">
				<?php 
				$user_permission_files_array = getUserPermissionFiles($user_query);
				for ($i = 0; $i < sizeof($directory_files); $i++) { // directory files
					$directory_file = basename($directory_files[$i]);
					$directory_file = str_replace(".php", "", $directory_file);
					if (in_array($directory_file, $user_permission_files_array)) {
						$checked = 'checked';
					} else {
						$checked = '';
					}
					print "<div><input type='checkbox' name='$directory_file' $checked> $directory_file</div>";
				}
				?>
			</div>
			<p><input type="submit" value="Save" name="set_permissions"></p>
			</form>			
		</section>
	</main>
</body>
</html>
