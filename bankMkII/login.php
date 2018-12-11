<?php include ("header.inc.php"); ?>
<?php
	if (!isset($_GET['u']))
	{
		$log = "true";
		$sign = "false";
	}
	else if($_GET['u'] == 'S')
	{
		$log = "false";
		$sign = "true";
	}

	if(isset($_POST["reg"]))
	{
		$userName = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["userName3"]);
		$password = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["password3"]);
		$sql = "SELECT id, password FROM users WHERE username = '$userName'";
		$result = mysqli_query($link, $sql);
		$userCount = mysqli_num_rows($result);
		if($userCount == 1)
		{
			while ($row = mysqli_fetch_assoc($result))
			{
				$pswd = $row["password"];
				$id = $row["id"];
			}

			if(crypt($password, $pswd) == $pswd)
			{
				$_SESSION["userName"] = $userName;
				$data = mysqli_query($link, "SELECT id, first_name FROM users WHERE username = '$userName'");
				while($row = mysqli_fetch_array($data, MYSQL_NUM))
				{
					$id = $row[0];
					$first = $row[1];
				}
				$_SESSION['id'] = $id;
				$_SESSION['first'] = $first;
				header("location: profile.php");
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

	$reg = @$_POST['reg2'];
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
								//fix this
								$data = mysqli_query($link, "SELECT id FROM users WHERE username = '$un'");
								while($row = mysqli_fetch_array($data, MYSQL_NUM))
									$id = $row[0];
								header("location: createAccount.php");
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
<a class = "logo" href = "<?php if(isset($_SESSION['id'])) {echo 'profile.php';} else {echo 'index.php';}?>">4mal</a>
<div ng-app = "" ng-init = "log = <?php echo $log; ?>; sign = <?php echo $sign; ?>;" >
	<div class = "log-in" ng-show = "log">
		<a href = "" class = "sign-up" ng-click = "sign = !sign; log = !log;">Sign Up</a>
		<h2>Log in to 4mal</h2>
		<form action = "login.php" method = "post">
			<label for = "userName">User name</label><br>
			<input type = "text" name = "userName3" ><br>
			<label for = "password">Password</label><br>
		   	<input type = "password" name = "password3" ><br>
		   	<button type = "submit" name = "reg" ><i class="fa fa-lock" aria-hidden="true"></i> Log In</button>
		</form>
		<a href = "" class = "reset">I forgot my username or password</a>
	</div>
	<div class = "create" ng-show = "sign">
		<a href = "" class = "sign-up" ng-click = "sign = !sign; log = !log;">Log In</a>
		<h2>Enter some information<br>so we can get started</h2>
		<form action = "login.php" method = "post">
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
		   	<button type = "submit" name = "reg2" value = "submit"><i class="fa fa-lock" aria-hidden="true"></i> Create User</button>
		</form>
	</div>
</div>
<div class = "extras">
	<a href = "help">help</a>
	<a href = "privacy">privacy policy</a>
</div>
