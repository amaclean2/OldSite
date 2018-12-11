<?php include ("header.inc.php") ?>

<?php
	$heading = "Add an account";
	if(isset($_SESSION['id']))
		$id = $_SESSION['id'];
	else
		header("location: login.php");

	if(isset($_POST['reg']))
	{
		$userId = strip_tags(@$_POST['userID']);
		$account = strip_tags(@$_POST['account']);
		$type = strip_tags(@$_POST['type']);
		$bal = 0;
		$data = mysqli_query($link, "SELECT id FROM accounts WHERE userId = '$userId' AND accountNo = '$account'");
		$check = mysqli_num_rows($data);
		if($check == 0)
		{
			$data = mysqli_query($link, "INSERT INTO accounts (userId, accountNo, accountType, balance) VALUES ('$userId', '$account', '$type', '$bal')");
			header("location: profile.php?u=" . $id);
		}
		else
			$heading = "You already have this account number";
	}

?>

<a class = "logo" href = "index.php">4mal</a>
<div ng-app = "" >
	<div class = "create account">
		<a href = "profile.php?u=<?php echo $id; ?>" class = "sign-up" >Return to profile</a>
		<h2><?php echo $heading; ?></h2>
		<form action = "createAccount.php?u=<?php echo $id; ?>" method = "post">
			<input type = "hidden" name = "userID" value = "<?php echo $id; ?>">
			<label for = "bank">Bank of Account</label><br>
			<input type = "text" name = "bank" required><br>
			<label for = "account">Account Number</label><br>
			<input type = "number" name = "account" required><br>
			<label for = "routing">Routing Number</label><br>
			<input type = "number" name = "routing" required><br>
			<label for = "type">Account Type</label><br>
			<select name = "type" required>
				<option disabled selected value = "">Select an account</option>
				<option value = "savings">Savings</option>
				<option value = "checking">Checking</option>
				<option value = "credit">Credit</option>
				<option vlaue = "loan">Loan</option>
			</select><br>
		   	<button type = "submit" name = "reg" value = "submit"><i class="fa fa-lock" aria-hidden="true"></i> Add Account</button>
		</form>
	</div>
</div>
<div class = "extras">
	<a href = "help">help</a>
	<a href = "privacy">privacy policy</a>
</div>
