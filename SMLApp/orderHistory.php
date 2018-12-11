<?php include("stheader.php"); ?>
<?php
	$fill = "";
	$data = mysqli_query($link, "SELECT purchases.dateadded, requests.id, requests.part_number FROM purchases LEFT JOIN requests ON purchases.catID=requests.id; ");
	while($row = mysqli_fetch_array($data, MYSQL_NUM))
	{
		if($fill != "" ){$fill .= ", ";}
		$fill .= '{date: "' . $row[0] . '", ';
		$fill .= 'id: "' . $row[1] . '", ';
		$fill .= 'partNumber: "' . $row[2] . '"}';
	}

	$fill = '{"records" : [ ' . $fill . ' ]} ';
	echo ($fill);



	$fill = "";
    $data = mysqli_query($link, "SELECT purchases.id, purchases.dateadded, purchases.catID, requests.type, requests.diameter,
      requests.material, requests.edp, requests.notes, requests.quantity, requests.part_number, requests.operation, requests.source, requests.price FROM purchases INNER JOIN requests
      ON purchases.catID=requests.id");
    while($row = mysqli_fetch_array($data, MYSQL_NUM))
    {
      $description = "";
      if($row[3] != '')
        $description .= "Tool Type: " . $row[3] . ", ";
      if($row[4] != '')
        $description .= "Diameter: " . number_format($row[4], 3) . "\", ";
      if($row[5] != '')
        $description .= "Material: " . $row[5] . ", ";
      if($row[6] != '')
        $description .= "EDP Number: " . $row[6];

      if($fill != "" ){$fill .= ", ";}
      $fill .= '{orderNumber: "' . $row[0] . '", ';
      $fill .= 'date: "' . $row[1] . '", ';
      $fill .= 'description: "' . $description . '", ';
      $fill .= 'notes: "' . $row[7] . '", ';
      $fill .= 'quantity: "' . $row[8] . '", ';
      $fill .= 'partNumber: "' . $row[9] . '", ';
      $fill .= 'operation: "' . $row[10] . '", ';
      $fill .= 'source: "' . $row[11] . '", ';
      $fill .= 'price: "' . $row[12] . '"}';
      echo "data.push(" . $fill . ");";
      $fill = "";
    }
?>