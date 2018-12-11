<?php
include("connect.inc.php");
session_start();
if(!isset($_SESSION['user_login']))
{

}
else
	header("location: home.php");
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset ="utf-8">
		<title>4mal</title>
		<link rel = "stylesheet" href = "style.css">
		<link href="https://fonts.googleapis.com/css?family=Lato|Montserrat|Roboto+Condensed" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
		<link rel = "icon" href = "4malFav.png" type = "image" size = "16x16">
	</head>
	<body>
		<a href = "http://cleverdistraction.com"><h2 id = "credits">Created by Andrew Maclean</h2></a>