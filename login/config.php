<?php
define("LOGIN_URL", "http://localhost/shorts/myapp/login/");
define("HOME_URL", "http://localhost/shorts/myapp/login/home.php");
define("LOGIN_INFO_FILE", "unguessablefile");
define("USER_PERMISSION_FILES", "../*.php");
define("USERNAME_MIN_LENGTH", 5);
define("USERNAME_MAX_LENGTH", 15);
define("PASSWORD_MIN_LENGTH", 5);
define("PASSWORD_MAX_LENGTH", 15);
define("MSG_USERNAME_LENGTH", "<div style='color:red;'>Allowed length of username is 5-15.</div>");
define("MSG_PASSWORD_LENGTH", "<div style='color:red;'>Allowed length of password is 5-15.</div>");
define("MSG_INVALID_LOGIN", "<div style='color:red;'>Invalid username or password.</div>");
define("MSG_REQUIRED_INFO", "<div style='color:red;'>Please provide all the required information.</div>");
define("MSG_RETYPED_PASSWORD", "<div style='color:red;'>Password and retyped password do not match.</div>");
define("MSG_USERNAME_EXISTS", "<div style='color:red;'>User already exists.</div>");
define("MSG_INVALID_PASSWORD", "<div style='color:red;'>Password contains invalid characters.</div>");
define("MSG_OLD_PASSWORD", "<div style='color:red;'>Invalid old password.</div>");
define("MSG_USER_ADDED", "<div style='color:green'>User added successfully.</div>");
define("MSG_USER_ADDING_FAILED", "<div style='color:red'>Could not add user.</div>");
define("MSG_PASSWORD_UPDATED", "<div style='color:green'>Password updated successfully.</div>");
define("MSG_PERMISSIONS_SAVED", "<div style='color:green'>Permissions saved successfully.</div>");
define("MSG_PERMISSIONS_NOT_SAVED", "<div style='color:red'>Could not save permissions.</div>");
define("MSG_USER_DELETED", "<div style='color:green'>User deleted successfully.</div>");
define("MSG_USER_UNDELETED", "<div style='color:green'>User un-deleted successfully.</div>");
define("MSG_ADMIN_DELETE", "<div style='color:red'>The user 'admin' can not be deleted.</div>");
define("MSG_LOGGED_IN", "<div>You are logged in, welcome to multi user login system.</div>");
define("MSG_LOGGED_OUT", "<div>Logged out successfully.</div>");
define("MSG_LOGIN_FILE_READ", "<div style='color:red;'>Could not fetch login information.</div>");
define("MSG_LOGIN_FILE_WRITE", "<div style='color:red;'>Could not write data, please check file permissions.</div>");
define("MSG_NO_PERMISSION_PAGE", "<h3 style='color:black;'>You do not have access to this page.</h3><p><input type='button' value='Go back' onclick='history.back();'></p>");

function isValidUser($username) {
	$users_data = trim(file_get_contents(LOGIN_INFO_FILE));
	$users_array = json_decode($users_data, true);
	for ($i = 0; $i < count($users_array); $i++) {
		$user = $users_array[$i];
		if ($user["username"] == $username) return true;
	}
	return false;
}

function isValidDeletedUser($username) {
	$users_data = trim(file_get_contents(LOGIN_INFO_FILE));
	$users_array = json_decode($users_data, true);
	for ($i = 0; $i < count($users_array); $i++) {
		$user = $users_array[$i];
		if ($user["username"] == $username) return true;
	}
	return false;
}

function isValidUsernamePassword($username, $password) {
	$users_data = trim(file_get_contents(LOGIN_INFO_FILE));
	$users_array = json_decode($users_data, true);
	for ($i = 0; $i < count($users_array); $i++) {
		$user = $users_array[$i];
		if ($user["username"] == $username && password_verify($password, $user["password"])) return true;
	}
	return false;
}

function getUserPermissionFiles($username) {
	$users_data = trim(file_get_contents(LOGIN_INFO_FILE));
	$users_array = json_decode($users_data, true);
    for ($i = 0; $i < count($users_array); $i++) {
        $user = $users_array[$i];
        if ($user["username"] == $username) return $user["permission_files"];
    }
}

?>
