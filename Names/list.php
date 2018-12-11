<?php
	$link = mysqli_connect("localhost", "root", "")
		or die("Couldn't connect to SQL Server");
	mysqli_select_db($link, "Names") or die("Couldn't select DB");

	$list = "";
	$data = mysqli_query($link, "SELECT name, id FROM namesList");
	while ($row = mysqli_fetch_array($data, MYSQL_NUM))
	{
		if($list != "" ) {$list .= ", ";}
		$list .= '{"name": "' . $row[0] . '", ';
		$list .= '"id": "' . $row[1] . '"}';
	}
	$list = '{"records" : [ ' . $list . ' ]} ';
	echo $list;
?>