<?php
	$link = mysqli_connect("localhost", "root", "")
		or die("Couldn't connect to SQL Server");
	mysqli_select_db($link, "Names") or die("Couldn't select DB");

	$name = "";
	if(isset($_POST['sub']))
	{
		$name = strip_tags(@$_POST['name']);
		$query = mysqli_query($link, "INSERT INTO namesList (name) VALUES ('$name')");
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<style>
			body
			{
				font-family: "helvetica";
				background-color: #f2f2f2;
			}
			.users
			{
				float: right;
				margin-right: 50px;
			}
			.users ul
			{
				list-style-type: none;
				font-size: 20px;
				padding: 0;
			}
			.users li
			{
				background-color: white;
				padding: 5px;
				margin: 5px;
				border: 1px solid #ccc;
				border-radius: 3px;
			}
		</style>
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
	</head>
	<body>
		<script>
			var app = angular.module('listOfNames', []);
			app.controller('namesController', function ($scope, $http)
			{
				$http.get("list.php").then(function (response)
				{
					$scope.names = response.data.records;
				});
			});
		</script>
		<div ng-app = "listOfNames" ng-controller = "namesController" class = "users">
			<h2>Other People</h2>
			<ul>
				<li ng-repeat = "x in names">{{ x.name }}</li>
			</ul>
		</div>
	</body>
</html>