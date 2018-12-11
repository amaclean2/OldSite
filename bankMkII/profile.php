<?php include ("homeHeader.inc.php"); ?>
<?php include ("functions.php") ?>

<h1>4mal</h1>
<header>
	<a class = "logo" href = "<?php if($_SESSION['id'] != '') {echo 'profile.php';} else {echo 'index.php';}?>">4mal</a>
	<h3><?php echo "$firstname"; ?>, you have $<?php echo number_format($balance, 2); ?></h3>
</header>
<div class = "wrapper" ng-cloak ng-app = '' ng-init = 'vis = false; tools = false;'>
	<div class = "nav">
		<ul>
		<li><a href = "" ng-click = "tools = !tools">Toolbar</a></li>
		<li><a href = "" onclick = "reset()">Reset Graph Zoom</a></li>
		<li><a href = "logout.php?un=<?echo $username; ?>">Logout</a></li>
		</ul>
	</div>
	
	<div class = "tools" ng-show = "tools">
		<span class = "close big" ng-click = "tools = false">×</span>
		<h3>Toolbar</h3>
		<ul>
			<li><a href = "createAccount.php" ><span>+</span> Add Account</a></li>
			<li><a href = ""><i class="fa fa-area-chart" aria-hidden="true"></i> Projections</a></li>
			<li><a href = ""><i class="fa fa-line-chart" aria-hidden="true"></i> Budgets</a></li>
			<li><a href = ""><i class="fa fa-life-ring" aria-hidden="true"></i> Tips to Save</a></li>
			<li><a href = "invest.php"><i class="fa fa-briefcase" aria-hidden="true"></i> Investments</a></li>
			<li><a href = "" ng-click = "trans = !trans; vis = false;"><i class="fa fa-exchange" aria-hidden="true"></i> Transfer Between Accounts</a></li>
				<div class = "dep-with" ng-show = 'trans'>
					<span class = "close" ng-click = "trans = false">×</span>
					<form action = "profile.php" method = "post" >
						<input type = "hidden" name = "un" value = "<?php echo $username; ?>">
						<select name = "account" required>
							<option selected disabled value = "">transfer from</option>
							<?php
								$data = mysqli_query($link, "SELECT accountNo FROM accounts WHERE userId = '$id'");
								while( $row = mysqli_fetch_array($data, MYSQL_NUM))
									echo "<option value = " . $row[0] . ">" . $row[0] . "</option>";
							?>
						</select>
						<select name = "account" required>
							<option selected disabled value = "">transfer to</option>
							<?php
								$data = mysqli_query($link, "SELECT accountNo FROM accounts WHERE userId = '$id'");
								while( $row = mysqli_fetch_array($data, MYSQL_NUM))
									echo "<option value = " . $row[0] . ">" . $row[0] . "</option>";
							?>
						</select>
						<input type = "number"  step = ".01" name = "dep" placeholder = "amount" autocomplete = "off" required><br>
						<input type = "submit" name = "trans" value = "enter">
					</form>
				</div>
			<li><a href = "" ng-click = 'vis = !vis; trans = false;'><i class="fa fa-credit-card" aria-hidden="true"></i> Deposit/Withdraw</a>
				<div class = "dep-with" ng-show = 'vis'>
					<span class = "close" ng-click = "vis = false">×</span>
					<form action = "profile.php" method = "post" >
						<input type = "hidden" name = "un" value = "<?php echo $username; ?>">
						<select name = "account" required>
							<option selected disabled value = "">account number</option>
							<?php
								$data = mysqli_query($link, "SELECT accountNo FROM accounts WHERE userId = '$id'");
								while( $row = mysqli_fetch_array($data, MYSQL_NUM))
									echo "<option value = " . $row[0] . ">" . $row[0] . "</option>";
							?>
						</select>
						<input type = "number"  step = ".01" name = "dep" placeholder = "amount" autocomplete = "off" required><br>
						<input type = "radio" name = "with" value = "deposit"><span class = "rad">Deposit</span><br>
						<input type = "radio" name = "with" value = "withdraw"><span class = "rad">Withdraw</span><br>
						<input type = "submit" name = "sub" value = "enter">
					</form>
				</div>
			</li>
		</ul>
	</div>

	<div class = "graphs">
		<div id = "chart"></div>
		<div id = "bar-chart"></div>
	</div>
</div>



<link rel="stylesheet" type="text/css" href="dc.css" media="screen" />
<script src = "crossfilter.js"></script>
<script src = "d3.js"></script>
<script src = "dc.js"></script>
<script src = "graph.js"></script>

<?php include ("footer.inc.php"); ?>