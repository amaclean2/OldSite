<?php
	if(!isset($_POST['sub']))
	{
		$un = $pass = $deposit = $with = "";
		$depositErr = $btnErr = "";
		$un = mysqli_real_escape_string($link, $_GET['un']);
	}

	else
	{
		$depositErr = $btnErr = "";
		$un = $_SESSION['userName'];
		$deposit = $_POST["dep"];
		$date = date("Y-m-d H:i:s");
		$with = "";

		$data = mysqli_query($link, "SELECT id, username, new_balance, date_added
				FROM exchanges WHERE username = '$un' ORDER BY id DESC LIMIT 1");

		if(mysqli_num_rows($data) < 1)
			$bal = 0;
		else
		{
			$row = mysqli_fetch_assoc($data);
			$bal = $row['new_balance'];
		}
		if(is_numeric($deposit) && $deposit >= 0)
		{
			if(isset($_POST["with"]))
			{
				$with = $_POST["with"];
				if($with == "withdraw")
				{
					if($deposit <= $bal)
						$deposit *= -1;
					else
						die("<h2>You do not have enough money</h2>");
				}
				$bal += $deposit;
				$query = mysqli_query($link, "INSERT INTO exchanges
					(username, new_balance, amount, date_added)
					VALUES ('$un', '$bal', '$deposit', '$date')");

				header("location: profile.php?u=" . $un);
			}
			else
				$btnErr = "Enter a deposit or withdrawl";
		}
		else
			$depositErr = " Please only enter a positive number.";
	}
?>