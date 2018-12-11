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
		<title>Shopping List</title>
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

<div class = "new-stuff">
	<h1 style = "margin: 10px 0 10px 10px">SML Engineering</h1>
	<div class = "wrapper" style = " width: 1000px; clear: both; padding: 20px 0 0 10px; font-size: 18px;">
		<h2 style = "margin: 0 0 20px 20px;">Shopping List: <?php echo date("l, F jS, Y"); ?></h2>
		<div class = "information" style = "margin-right: 10px;">
			<style>
				tr{font-size: 17px;}
				th{font-weight: 700;}
			</style>
			<h3 style = "margin-bottom: 10px;">Mill</h3>
			<table>
				<tr>
					<th>Tool Type</th>
					<th>Diameter</th>
					<th>Material and Coating</th>
					<th>EDP</th>
					<th>Notes</th>
					<th>Quantity</th>
					<th>Part Number</th>
				</tr>
				<?php
					$data = mysqli_query($link, "SELECT type, diameter, material, edp, notes, quantity, part_number FROM requests WHERE bought = '0' ORDER BY dateadded");
					while($row = mysqli_fetch_array($data, MYSQL_NUM))
					{
						echo "<tr>";
						echo "<td>" . $row[0] . "</td>";
						echo "<td>" . number_format($row[1], 3) . "</td>";
						echo "<td>" . $row[2] . "</td>";
						echo "<td>" . $row[3] . "</td>";
						echo "<td>" . $row[4] . "</td>";
						echo "<td>" . $row[5] . "</td>";
						echo "<td>" . $row[6] . "</td>";
						echo "</tr>";
					}
				?>
			</table>
			<h3 style = "margin-bottom: 10px;">Lathe</h3>
			<table>
				<tr>
					<th>Tool Type</th>
					<th>Description</th>
					<th>Insert Code</th>
					<th>Notes</th>
					<th>Quantity</th>
					<th>Part Number</th>
				</tr>
				<?php
					$data2 = mysqli_query($link, "SELECT type, description, insert_code, lquantity, notes, part_number FROM lrequests WHERE bought = '0' ORDER BY dateadded");
					while($row = mysqli_fetch_array($data2, MYSQL_NUM))
					{
						echo "<tr>";
						echo "<td>" . $row[0] . "</td>";
						echo "<td>" . $row[1] . "</td>";
						echo "<td>" . $row[2] . "</td>";
						echo "<td>" . $row[4] . "</td>";
						echo "<td>" . $row[3] . "</td>";
						echo "<td>" . $row[5] . "</td>";
						echo "</tr>";
					}
				?>
			</table>
			<h3 style = "margin-bottom: 10px;">Other Parts</h3>
			<table>
				<tr>
					<th>Description</th>
					<th>Notes</th>
					<th>Quantity</th>
					<th>Part Number</th>
				</tr>
				<?php
					$data = mysqli_query($link, "SELECT description, notes, quantity, part_number FROM orequests WHERE bought = '0' ORDER BY dateadded");
					while($row = mysqli_fetch_array($data, MYSQL_NUM))
					{
						echo "<tr>";
						echo "<td>" . $row[0] . "</td>";
						echo "<td>" . $row[1] . "</td>";
						echo "<td>" . $row[2] . "</td>";
						echo "<td>" . $row[3] . "</td>";
						echo "</tr>";
					}
				?>
			</table>
		</div>
	</div>
</div>