<?php include("header.php"); ?>
<?php
	$_SESSION['username'] = '';
	$data = mysqli_query($link, "EXIT;");
	header("location: login.php");
?>