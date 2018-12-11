<?php
	$link = mysqli_connect("localhost", "root", "")
		or die("Couldn't connect to SQL Server");
	mysqli_select_db($link, "Names") or die("Couldn't select DB");
	date_default_timezone_set("America/Los_Angeles");
	session_start();

?>