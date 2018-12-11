<?php
	include("connect.php");
	session_start();
	if(!isset($_SESSION['user_login']))
	{

	}
	else
		header("location: index.php");
?>
<!DOCTYPE html>
<html lang = "en">
<html>
	<head>
		<title>Tooling Database</title>
		<meta charset = "utf-8">
		<meta name = "viewport" content = "width=device-width, initial-scale=1.0">
		<link rel = "stylesheet" href = "style.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="http://code.jquery.com/ui/1.12.1/jquery-ui.js"
		  integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30="
		  crossorigin="anonymous"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
		<script src="src/sortable.js"></script>
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
		<header>
			<a href = "logout.php"><h1>Tooling Database</h1></a>
			<div class = "header-links">
				+
				<ul>
					<li><a href = "home.php#wrapper"><h3>mill tools</h3></a></li>
					<li><a href = "lhome.php#wrapper"><h3>lathe tools</h3></a></li>
					<li><a href = "parts.php#wrapper"><h3>parts</h3></a></li>
					<li class = 'header-dropdown'>
						<a href = 'request.php#wrapper'><h3>shopping requests</h3></a>
					<?php
						if ($_SESSION['level'] == 'Admin')
							echo "	<ul class = 'header-dropdown-content ph'><li><a href = 'purchased.php#wrapper'><h3>purchase history</h3></a></li></ul>";
						echo "</li>";
					?>
					<li class = 'mobile-header'><a href = "purchased.php#wrapper"><h3>purchase history</h3></a></li>
					<li><a href = 'priority.php'><h3>part priority</h3></a></li>
					<li><a href = "createUser.php#wrapper"><h3>users</h3></a></li>
					<?php
						if ($_SESSION['level'] == 'Admin')
							echo "	<li><a href = 'photos.php'><h3>edit photos</h3></a></li>";
					?>
					<li><a href = "logout.php"><h3>logout</h3></a></li>
				</ul>
			</div>
		</header>

