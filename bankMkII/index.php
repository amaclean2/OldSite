<?php
include("connect.inc.php");
session_start();

if(isset($_SESSION['user_login']))
	header("location: home.php");
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset ="utf-8">
		<title>4mal</title>
		<link rel = "stylesheet" href = "style.css">
		<link href="https://fonts.googleapis.com/css?family=Lato|Roboto+Condensed" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
		<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
		<link rel = "icon" href = "4malFav.png" type = "image" size = "16x16">
	</head>
	<body>
	<a href = "cleverdistraction.com"><h2 id = "credits">Created by Andrew Maclean</h2></a>
	<div class = "nav-bar">
		<a class = "logo" href = "<?php if(isset($_SESSION['id'])) {echo 'profile.php';} else {echo 'index.php';}?>">4mal</a>
		<ul>
			<li><a href = "about.html">About</a></li>
			<li><a href="">Support</a></li>
			<li><a href="">Opportunities</a></li>
			<li><a href="">How to Save</a></li>
		</ul>
	</div>
	<div class = "wrapper">
		<div class = "banner">
			<h1>4mal</h1>
			<div class = "center-info">
				<h2>Visualize your spending</h2>
				<p>Analyze your bugdeting in a way you can w see and make action on immediately</p>
				<a href = "login.php?u=S">create an account</a>
				<a href = "login.php">log in</a>
			</div>
		</div>
		<div class = "column-group">
			<div class = "column">
				<h3>Budgets</h3>
				<p>Create budget lines to follow and 4mal will alert you when you are failing to accomplish your goals.
					4mal will also reward you when you are going exceedingly beyond your goals.</p>
			</div>
			<div class = "column">
				<h3>Trends</h3>
				<p>4mal will show you the trajectory of your transactions and when you are likely to run out of money.
					If you are worried about how much money you will have by the end of the week, 4mal can tell you what your path will look like.</p>
			</div>
			<div class = "column">
				<h3>Advice</h3>
				<p>4mal uses location services to predict your next purchases.
					If you walk into Starbucks without much money left, 4mal will give you a heads up on whether or not you want to buy that Frappuccino.</p>
			</div>
			<div class = "division"></div>
			<div class = "full-column">
				<h3>Look Inside for Free</h3>
				<p>Easy to use buttons can let you manipulate your expenses with ease. Just give it a try without any accounts to demo what it would feel like.</p>
			</div>
		</div> 
	</div> 
	<footer></footer>