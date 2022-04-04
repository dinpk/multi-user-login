<?php
include_once("config.php");
session_start();
if (!isset($_SESSION["loggedin"])) {
	header("location: " . LOGIN_URL . "index.php");
}
?>