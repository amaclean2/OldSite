<?php
	include("connect.php");
	session_start();
	if(!isset($_SESSION['user_login']))
	{

	}
	else
		header("location: login.php");
?>

<!DOCTYPE html>
<html lang = "en">
<html>
	<head>
		<title>Setup Sheet</title>
		<meta charset = "utf-8">
		<link rel = "stylesheet" href = "style.css">
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
		<?php
				if($_SESSION['username'] == '')
				{
					echo "<style>
						a { color: #e6e6e6; }
					</style>";
				}
			?>
	</head>
	<body>