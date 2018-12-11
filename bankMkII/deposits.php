<?php include ("homeHeader.inc.php"); ?>
<?php include ("dep.php"); ?>

<form action = "deposits.php" method = "post">
	<span class = "error"><?php echo $depositErr; ?><br>
	<span class = "error"><?php echo $btnErr; ?><br>
	<input type = "text" name = "dep" placeholder = "amount" autocomplete = "off"><br>
	<input type = "radio" name = "with" value = "deposit">Deposit<br>
	<input type = "radio" name = "with" value = "withdraw">Withdraw<br>
	<input type = "submit" name = "sub" value = "enter">
</form>

<?php include ("footer.inc.php") ?>