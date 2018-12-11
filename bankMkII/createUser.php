<?php include("header.inc.php"); ?>
<?php
	$reg = @$_POST['reg'];
	$fn = ""; //firstname
	$ln = ""; //lastname
	$un = ""; //username
	$em = ""; //email
	$em2 = ""; //email 2
	$pswd = ""; //password
	$pswd2 = ""; //password 2
	$d = ""; //sign up date
	$u_check = "";
	$unError = $passError = $fieldError = $emError = "";	

	$fn = strip_tags(@$_POST['firstName']);
	$ln = strip_tags(@$_POST['lastName']);
	$un = strip_tags(@$_POST['userName']);
	$em = strip_tags(@$_POST['email']);
	$em2 = strip_tags(@$_POST['email2']);
	$pswd = strip_tags(@$_POST['password']);
	$pswd2 = strip_tags(@$_POST['password2']);
	$d = date("Y-m-d H:i:s");
	if($reg)
	{
		$unError = $passError = $fieldError = $emError = "";
		if($em == $em2)
		{
			$u_check = mysqli_query($link, "SELECT username FROM users WHERE username = '$un'");
			$check = mysqli_num_rows($u_check);
			if($check == 0)
			{
				if($fn&&$ln&&$un&&$em&&$em2&&$pswd&&$pswd2)
				{
					if($pswd == $pswd2)
					{
						if(strlen($un) > 25 || strlen($fn) > 25 || strlen($ln) > 25)
							echo "The maximum limit for username/first name/last name is 25 characters";
						else
						{
							if(strlen($pswd) > 30 || strlen($pswd) < 5)
								echo "Your password must be between 5 and 30 characters long";
							else
							{
								$pswd_hash = crypt($pswd);
								$pswd2_hash = crypt($pswd2, $pswd_hash);
								$query = mysqli_query($link, "INSERT INTO users
									(username, first_name, last_name, email, password, sign_up_date, activated)
									VALUES ('$un', '$fn', '$ln', '$em', '$pswd_hash', '$d', '0')");
								$dep = mysqli_query($link, "INSERT INTO exchanges (username, new_balance, amount, date_added)
									VALUES ('$un', '0', '0', '$d')");
								die("<h2>Login to get started...</h2>");
							}
						}
					}
					else
						$passError = "Your passwords don't match";
				}
				else
					$fieldError = "All fields are not filled in";
			}
			else
				$unError = "Username is already taken";
		}
		else
			$emError = "Your emails don't match";
	}

?>

<a class = "logo" href = "index.php">4mal</a>
	<div class = "create">
		<a href = "login.php" class = "sign-up">Log In</a>
		<h2>Enter some information<br>so we can get started</h2>
		<form action = "createUser.php" method = "post">
			<label for = "firstName">First name</label><br>
			<input type = "text" name = "firstName" required><br>
			<label for = "lastName">Last name</label><br>
			<input type = "text" name = "lastName" required><br>
			<label for = "userName">User name</label><br>
			<input type = "text" name = "userName" required><br>
			<label for = "email">E-mail</label><br>
			<input type = "email" name = "email" required>
			<input type = "email" name = "email2" required placeholder = "Re-enter your email"><br>
			<label for = "password">Password</label><br>
		   	<input type = "password" name = "password" required>
		   	<input type = "password" name = "password2" required placeholder = "Re-enter your password"><br>
		   	<button type = "submit" name = "reg" value = "submit"><i class="fa fa-lock" aria-hidden="true"></i> Create User</button>
		</form>
	</div>
<div class = "extras">
	<a href = "help">help</a>
	<a href = "privacy">privacy policy</a>
</div>

<?php include("footer.inc.php"); ?>