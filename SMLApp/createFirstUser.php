<?php include("header.php"); ?>

<?php
	if($_SESSION['username'] != '')
    header("location: index.php");

	$reg = @$_POST['submit'];
	$fn = "";
	$ln = "";
	$un = "";
	$pswd = "";
	$pswd2 = "";
	$level = "";
	$d = "";
	$u_check = "";
	$passerror = $unerror = $fielderror = "";

	if($reg)
	{
		$fn = strip_tags(@$_POST['firstname']);
		$ln = strip_tags(@$_POST['lastname']);
		$un = strip_tags(@$_POST['username']);
		$pswd = strip_tags(@$_POST['password']);
		$pswd2 = strip_tags(@$_POST['password2']);
		$level = strip_tags(@$_POST['level']);
		$d = date("Y-m-d H:i:s");

		$u_check = mysqli_query($link, "SELECT username FROM users WHERE username = '$un'");
		$check = mysqli_num_rows($u_check);
		if($check == 0)
		{
			if($fn&&$ln&&$un&&$pswd&&$pswd2)
			{
				if($pswd == $pswd2)
				{
					if(strlen($un) > 25 || strlen($fn) > 25 || strlen($ln) > 25)
						echo "The maximum limit for username/firstname/lastname is 25 characters";
					else
					{
						if(strlen($pswd) > 30 || strlen($pswd) < 5)
							echo "Your password must be between 5 and 30 characters";
						else
						{
							$pswd_hash = crypt($pswd);
							$pswd2_hash = crypt($pswd2, $pswd_hash);
							$query = mysqli_query($link, "INSERT INTO users
									(username, first_name, last_name, password, user_level, sign_up_date)
									VALUES ('$un', '$fn', '$ln', '$pswd_hash', '$level', '$d')");
							header("location: login.php");
						}
					}
				}
				else
					$passerror = "Your passwords don't match";
			}
			else
				$fielderror = "All fields are not filled in";
		}
		else
			$unError = "Username is already taken";
	}
?>

<div class = "wrapper">
	<br>
	<h2>Create User</h2>
	<form action = "createFirstUser.php" method = "post">
		<input type = "text" name = "firstname" placeholder = "firstname" id = "firstname" required><br>
		<input type = "text" name = "lastname" placeholder = "lastname" id = 'lastname' required><br>
		<input type = "text" name = "username" placeholder = "username" id = 'username' required><br>
		<select name = "level" style = "width: 33%; padding: 5px; font-size: 15px;" id = "level" required>
			<option disabled selected>Select a user level</option>
			<option>Admin</option>
		<input type = "password" style = "clear: both;" name = "password" placeholder = "password" required><br>
		<input type = "password" name = "password2" placeholder = "re-enter your password" required><br>
		<input type = "submit" name = "submit" value = "Create User" id = "submit">
	</form>
</div>