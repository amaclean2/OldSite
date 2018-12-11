<?php
	$username = "name";
?>

<html> 
<body>

<form action="index.php" method="get">
User Name: <input type = "text" name = "pswd" value = <?php echo "$username" ?> readonly = "readonly"><br>
<input type="submit">
</form>

<?php
?>

</body>
</html>