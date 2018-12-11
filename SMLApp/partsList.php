<?php include("stheader.php"); ?>
<?php
	$fill = "";
	$data = mysqli_query($link, "SELECT part_number, revision, customer, operation, toolbox FROM parts");
	while($row = mysqli_fetch_array($data, MYSQL_NUM))
	{
		if($fill != "" ){$fill .= ", ";}
		$fill .= '{partNumber: "' . $row[0] . '", ';
		$fill .= 'revision: "' . $row[1] . '", ';
		$fill .= 'customer: "' . $row[2] . '", ';
		$fill .= 'operation: "' . $row[3] . '", ';
		$fill .= 'toolBox: "' . $row[4] . '"}';
	}

	$fill = '{"records" : [ ' . $fill . ' ]} ';
	echo ($fill);
?>