<?php
	function make_another_array(array $array)
	{
		foreach ($array as $key=>$value)
			$another_array[$key] = $value;
	}

	$another_array = array();
	$array = array(5 => 1, 12 => 2, 8 => 4);
	make_another_array($array);
	print_r($another_array);
?>