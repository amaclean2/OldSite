<?php
	
	if(!isset($_SESSION['id']))
		header("location: login.php");

	$id = $_SESSION['id'];
	$username = $_SESSION['userName'];


	$un = $pass = $deposit = $with = "";

	if(isset($_POST['sub']))
	{
		$un = $_SESSION['userName'];
		$deposit = strip_tags(@$_POST["dep"]);
		$date = date("Y-m-d H:i:s");
		$with = "";
		$account = strip_tags(@$_POST['account']);

		$data = mysqli_query($link, "SELECT balance FROM accounts WHERE accountNo = '$account'");

		if(mysqli_num_rows($data) < 1)
			$bal = 0;
		else
		{
			$row = mysqli_fetch_assoc($data);
			$bal = $row['balance'];
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

				//Inserts the new balance and excchange amount into the primary account
				$query = mysqli_query($link, "INSERT INTO exchanges
					(accountNo, new_balance, amount, date_added)
					VALUES ('$account', '$bal', '$deposit', '$date')");
				$query = mysqli_query($link, "UPDATE accounts SET balance = '$bal' WHERE accountNo = '$account'");

				//Inserts a zero balance into all other accounts so that it can share a point on the graph
				$accounts = array();
				$balances = array();
				$data = mysqli_query($link, "SELECT accountNo, balance FROM accounts WHERE userId = '$id'");
				while ( $row = mysqli_fetch_array($data, MYSQL_NUM) )
				{
					if($row[0] != $account)
					{
						array_push($accounts, $row[0]);
						array_push($balances, $row[1]);
					}
				}

				$size = sizeof($accounts);

				for($i = 0; $i < $size; $i++)
				{
					$data = mysqli_query($link, "INSERT INTO
						exchanges (accountNo, new_balance, amount, date_added)
						VALUES ('$accounts[$i]', '$balances[$i]', '0', '$date')");
				}
			}
		}
	}



	if (ctype_alnum($username))
	{
		$check = mysqli_query($link, "SELECT username, first_name, activated
			FROM users WHERE username = '$username'");
		$get = mysqli_fetch_assoc($check);
		$active = $get["activated"];
		
		$firstname = $get["first_name"];
		$accounts = array();

		$data = mysqli_query($link, "SELECT accountNo FROM accounts WHERE userId = '$id'");
		while ( $row = mysqli_fetch_array($data, MYSQL_NUM))
			array_push($accounts, $row[0]);

		$accSize = sizeof($accounts);
		$accExchanges = array();
		$exchanges = array();
		$balance = 0;

		for($i = 0; $i < $accSize; $i++)
		{
			$data = mysqli_query($link, "SELECT accountNo, new_balance, date_added FROM exchanges WHERE accountNo = '$accounts[$i]' ORDER BY id");
			while( $row = mysqli_fetch_array($data, MYSQL_NUM))
				array_push($accExchanges, $row);

			$balance += $accExchanges[sizeOf($accExchanges) - 1][1];
			array_push($exchanges, $accExchanges);
			$accExchanges = array();
		}
		if(sizeof($exchanges) == 0)
			$balance = 0;
	}
?>




<script>
	accounts = [];

	function addData()
	{
		<?php $size = sizeof($exchanges);
		for($j = 0; $j < $size; $j++)
		{
			echo "account" . $j . " = [];\n";
			$accSize = sizeof($exchanges[$j]);
			for($i = 0; $i < $accSize; $i++)
			{
				$element = $exchanges[$j][$i];
				$accNumber = $element[0];
				$date = $element[2];
				$bal = $element[1];
				echo 'var newData = {account: "' . $accNumber . '", date: "' . $date . '", y: ' . $bal . '};';
				echo 'account' . $j . ".push(newData);\n";
			}
			echo "accounts.push(account" . $j . ");\n";
		} ?>
	}


	function reset(ndx)
	{
		chart.filterAll();
		chart2.filterAll();
		dc.redrawAll();
		dc.filterAll();
	}

	function trend(data, date)
	{
		var d1 = Date.parse(date);
		var n = data.length;
		var a = 0;
		var xSum = 0;
		var ySum = 0;
		var m = 0;
		var yInt = 0;
		var b = 0;
		var c = 0;
		var d = 0;
		var e = 0;
		var f = 0;
		for(var i = 0; i < n; i++)
		{
			a += data[i].date * data[i].y;
			xSum += data[i].date;
			ySum += data[i].y;
			c += (data[i].date * data[i].date);
			e += data[i].y;
		}
		a *= n;
		b = xSum * ySum;
		c *= n;
		d = xSum * xSum;
		m = ((a - b)/(c - d));
		f = m * xSum;
		yInt = (e - f)/n;
		return (m * d1) + yInt;
	}

	function forecast(data, date)
	{
		var d1;
		var a = [];
		var b = [];
		var size = data.length;
		var i = size - 1;
		var j = 0;
		while (i >= 0 && j <= data[i].y)
		{
			if (data[i].y >= j)
			{
				j = data[i].y;
				d1 = Date.parse(data[i].date);
				a.push({date: d1, y: j});
			}
			i--;
		}

		i = 5;
		while (i >= 0)
		{
			b.push(a[i]);
			i--;
		}
		return trend(b, date);
	}

	function predict(ndx)
	{
		d = new Date();
		yVar = forecast(data, d);
		d2 = {date: d, y: yVar};
		data.push(d2);
		for(var i = 0; i < data.length; i++)
			console.log(data[i]);
		//ndx.add(data);
		reset(ndx);
		dc.redrawAll();
	}

</script>