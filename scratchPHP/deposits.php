<?php
	$link = mysqli_connect("localhost", "root", "")
		or die("Couldn't connect to SQL Server");
	mysqli_select_db($link, "bank") or die("Couldn't select DB");
?>

<html>
<body>
<form action = "deposits.php" method = "post">
	<input type = "name" name = "un" placeholder = "username"><br>
	<input type = "password" name = "pass" placeholder = "password"><br>
	<input type = "text" name = "dep" placeholder = "amount"><br>
	<input type = "submit" name = "sub" value = "submit">
</form>

<?php

	if(isset($_POST["sub"]))
	{
		$deposit = $_POST["dep"];
		$un = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["un"]);
		$pass = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["pass"]);
		$date = date("Y-m-d");

		$sql = "SELECT id, password FROM users WHERE username = '$un'";
		$result = mysqli_query($link, $sql);
		$userCount = mysqli_num_rows($result);
		if ($userCount == 1)
		{
			while ($row = mysqli_fetch_assoc($result))
			{
				$pswd = $row["password"];
				$id = $row["id"];
			}
			if(crypt($pass, $pswd) == $pswd)
			{
				$query = mysqli_query($link, "INSERT INTO exchanges
					(amount, date_added, username)
					VALUES ('$deposit', '$date', '$un')");
				die("<h2>Payment  of $" . $deposit . " deposited to " . $un . " </h2>");
			}
			else
			{
				echo "<h2>The password is incorrect</h2>";
				exit();
			}
		}
		else
		{
			echo "<h2>Username is incorrect, try again</h2>";
			exit();
		}

		
	}

?>

</body>
</html>