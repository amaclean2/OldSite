<?php
	$link = mysqli_connect("localhost", "root", "")
		or die("Couldn't connect to SQL Server");
	mysqli_select_db($link, "pictures") or die("Couldn't select DB");
	date_default_timezone_set("America/Los_Angeles");

	if(isset($_POST['upload']) && $_FILES['userfile']['size'] > 0) {
		$fileName = $_FILES['userfile']['name'];
		$tmpName = $_FILES['userfile']['tmp_name'];
		$fileSize = $_FILES['userfile']['size'];
		$fileType = $_FILES['userfile']['type'];

		$fp = fopen($tmpName, 'r');
		$content = fread($fp, filesize($tmpName));
		$content = addslashes($content);

		fclose($fp);

		if(!get_magic_quotes_gpc()) {
			$fileName = addslashes($fileName);
		}

		$query = "INSERT INTO pics (caption, img) VALUES ('$fileName', '$content')";

		mysqli_query($link, $query) or die('Query failed');

		echo "<br> $fileName uploaded <br>";
		header("location: display.php");
 	}

?>

<form method="post" enctype="multipart/form-data" action = "photos.php">
	<input name="userfile" type="file" id="userfile">
	<input name="upload" type="submit" class="box" id="upload" value="Upload">
</form>
