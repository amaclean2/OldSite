<?php
	include("header.inc.php");
	$userName = $_SESSION['userName'];
	session_unset($_SESSION['id']);
	header("Location: index.php");
	exit();
?>