<?php include("header.php"); ?>
<?php
	if(isset($_POST["username"]) && isset($_POST["password"]))
	{
		$data = mysqli_query($link, "SELECT id FROM users");
		$rowCount = (mysqli_num_rows($data));
		if ($rowCount == 0)
			header("location: createFirstUser.php");
		else
		{
			$username = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["username"]);
			$password = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["password"]);
			$sql = "SELECT id, password, first_name, last_name, user_level FROM users WHERE username = '$username'";
			$result = mysqli_query($link, $sql);
			$userCount = mysqli_num_rows($result);
			if($userCount == 1)
			{
				while ($row = mysqli_fetch_assoc($result))
				{
					$pswd = $row["password"];
					$id = $row["id"];
					$level = $row["user_level"];
					$firstname = $row["first_name"];
					$lastname = $row["last_name"];
				}

				if(crypt($password, $pswd) == $pswd)
				{
					$_SESSION["username"] = $username;
					$_SESSION["firstname"] = $firstname;
					$_SESSION["lastname"] = $lastname;
					$_SESSION["level"] = $level;
					$_SESSION["email"] = 'false';
					$_SESSION["home"] = 'false';
					header("location: request.php");
				}
				else
				{
					echo "The password is incorrect";
					exit();
				}
			}
			else
			{
				echo "Username is incorrect, try again";
				exit();
			}
		}

	}
?>
	
		<div class = "wrapper">
			<br>
			<h2>Login</h2>
			<form action = "login.php" method = "post" autocomplete = "off">
				<input type = "text" name = "username" id = "user-name" size = "25" placeholder = "username" value = "" autofocus><br>
				<input type = "password" name = "password" id = "pass-entry" size = "25" placeholder = "password" value = "">
				<input type = "submit" name = "submit" value = "login">
			</form>
		</div>
	</body>
</html>