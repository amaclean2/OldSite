<?php include("stheader.php"); ?>
<?php
	if(isset($_GET['id']))
	{
		$id = $_GET['id'];
		$data = mysqli_query($link, "SELECT part_number, revision, customer, operation, toolbox 
      		FROM parts WHERE id = '$id'");
		while($row = mysqli_fetch_array($data, MYSQL_NUM))
		{
		    $partNumber = $row[0];
		    $revision = $row[1];
		    $customer = $row[2];
		    $operation = $row[3];
		    $toolbox = $row[4];
		}

		$data2 = mysqli_query($link, "SELECT mill FROM fixtures WHERE id = '$id'");
		while ($row = mysqli_fetch_array($data2, MYSQL_NUM))
			$machine = $row[0];

		if ($machine == '0')
		{
			$mach = "Mill";
			$data2 = mysqli_query($link, "SELECT fixture, x_zero, y_zero, z_zero, a_zero, notes 
		      FROM fixtures WHERE id = '$id'");
		    while ($row = mysqli_fetch_array($data2, MYSQL_NUM))
		    {
			    $fixture = $row[0];
			    $x_zero = $row[1];
			    $y_zero = $row[2];
			    $z_zero = $row[3];
			    $a_zero = $row[4];
			    $notes = $row[5];
		    }
		}
		else if ($machine == '1')
		{
			$mach = "Lathe";
			$data = mysqli_query($link, "SELECT fixture, x_zero, z_zero, notes
				FROM fixtures WHERE id = '$id'");
			while ($row = mysqli_fetch_array($data, MYSQL_NUM))
			{
				$fixture = $row[0];
			    $x_zero = $row[1];
			    $z_zero = $row[2];
			    $notes = $row[3];
			}
		}
	}
?>
<script>
	data = [];
	<?php
		if($machine == '0')
		{
			$data = mysqli_query($link, "SELECT tool_number, type, diameter, radius, material, flutes, length, angle, notes, id FROM tools
				WHERE part_number = '$partNumber' AND operation = '$operation' ORDER BY tool_number");
	      	while( $row = mysqli_fetch_array($data, MYSQL_NUM))
	      	{
	        	echo "var newData =
	          		{ toolNumber: '" . $row[0] . "', type: '" . $row[1] . "', diameter: '" . $row[2] . "', radius: '" . $row[3] . "', material: '" . $row[4] . "', flutes: '" .
	           		$row[5] . "', length: '" . $row[6] . "', edp: '" . $row[7] . "', notes: '" . $row[8] . "', id: '" . $row[9] . "' };";
	        	echo "data.push(newData);";
	      	}
		}
		else if ($machine == '1')
		{
			$data = mysqli_query($link, "SELECT tool_number, type, description, notes, id FROM ltools
				WHERE part_number = '$partNumber' AND operation = '$operation' ORDER BY tool_number");
			while( $row = mysqli_fetch_array($data, MYSQL_NUM))
	      	{
	        	echo "var newData =
	          		{ toolNumber: '" . $row[0] . "', type: '" . $row[1] . "', description: '" . $row[2] . "', notes: '" . $row[3] . "', id: '" . $row[4] . "' };";
	        	echo "data.push(newData);";
	      	}
		}
    ?>

    var app = angular.module('sortApp', []);

    app.controller('mainController', function($scope) {
        $scope.currentPage = 0;
        $scope.pageSize = 30;
        $scope.tools = data;
        $scope.sortType = 'id';
        $scope.sortReverse = 'false';
        $scope.searchTools = '';
        $scope.init = function()
        {
        	$scope.btn = false;
        	$scope.vis = true;
        }

    });
</script>
<div class = "width" style = "width: 1000px; margin: auto;" ng-app = "sortApp" ng-controller = "mainController" ng-init = 'init()'>
	<h1 style = "font-size: 25px;">SML Engineering <?php echo $mach; ?> Setup Sheet</h1>
	<div class = "info" style = "margin: 0px 25px; clear: both;">
		<div id = "hcolA" style = "width: 45%; float: left;">
			<h2 style = "font-size: 18px;">
				Part Number: <?php echo $partNumber; ?><br>
				<?php echo $customer; ?><br>
				<span style = "font-size: 16px;">Revision: <?php echo $revision; ?><br>
				Operation: <?php echo $operation; ?></span>
			</h2>
		</div>
		<div id = "hcolB" style = "float: left; width: 45%;">
			<h3 style = "font-size: 15px;">
				<?php echo $_SESSION['firstname'] . " " . $_SESSION['lastname']; ?><br>
				<?php echo date("M d, Y"); ?><br>
			</h3>
		</div>
		<h2 style = "clear: both; padding-top: 25px; font-size: 18px;">
			Workholding Information
		</h2>
		<div id = "fixcolA" style = "margin-left: 20px; float: left; width: 44%; font-size: 13px;">
			<p>
				<?php
					if ($machine == '0')
					{
						echo '<b style = "padding: 3px 5px;">X-Zero:</b>' . htmlentities($x_zero) . '<br>
							  <b style = "padding: 3px 5px;">Y-Zero:</b>' . htmlentities($y_zero) . '<br>
							  <b style = "padding: 3px 5px;">Z-Zero:</b>' . htmlentities($z_zero) . '<br>
							  <b style = "padding: 3px 5px;">A-Zero:</b>' . htmlentities($a_zero) . '<br>';
					}
					else if ($machine == '1')
					{
						echo '<b style = "padding: 3px 5px;">X-Zero:</b>' . htmlentities($x_zero) . '<br>
							  <b style = "padding: 3px 5px;">Z-Zero:</b>' . htmlentities($z_zero) . '<br>';
					}
				?>
			</p>
		</div>
		<div id = "fixcolB" style = "float: left; width: 45%;">
			<p style = "font-size: 15px;"><b style = "padding: 3px 5px;">Workholding:</b> <?php echo $fixture; ?><br></p>
                        <p style = "font-size: 15px;"><b style = "padding: 3px 2px;">Tool Box:</b> <?php echo $toolbox; ?><br></p>
			<p style = "font-size: 14px;"><b style = "padding: 3px 5px; font-size: 15px;">Notes:</b><br> <span style = "margin: 20px;"><?php echo htmlentities($notes); ?></span></p>
		</div>
		<style>
			th{font-size: 14px;}
			td{font-size: 13px;}
			button, input[type='button'], input[type='submit']{font-size: 13px;}
		</style>

		<h2 style = "clear: both; padding-top: 50px; font-size: 18px;">Tools</h2>
		<input type = "button" ng-click = 'btn = !btn' value = "Edit Tools" style = "margin-bottom: 10px;">
		
		<table>
			<?php
				if($machine == '0')
				{
					echo "
						<tr>
						<th></th>
						<th>Tool Number</th>
			            <th>Tool Type</th>
			            <th>Diameter</th>
			            <th>Corner Radius</th>
			            <th>Material/Coating</th>
			            <th>Flutes</th>
			            <th>Flute Length</th>
			            <th>EDP Number</th>
			            <th>Notes</th>
			            </tr>
			            <tr ng-repeat = \" x in tools | orderBy:sortType \">
			            <td>
			                <div class = 'dropdown'>
			                    <button class = 'dropbtn' ng-show = 'btn'>Options</button>
			                    <ul class = 'dropdown-content'>
			                      	<div class = 'dropbuffer'>
			                       	<li><span class = 'void-link'>Options</span></li>
			                        	<li><form action = 'request.php' method = 'post'>
			                          		<input type = 'hidden' name = 'machine' id = 'machine' value = 'mill-h' />
			                          		<input type = 'hidden' name = 'id' id = 'id' value = '{{ x.id }}'' />
			                          		<input type = 'submit' name = 'order' class = 'link' value = 'Order' /></form>
			                        	</li>
			                        	<li><form action = 'home.php' method = 'post'>
			                          		<input type = 'hidden' name = 'ed' value = '{{ x.id }}' />
			                          		<input type = 'hidden' name = 'for' value = '" . $id . "	' />
			                          		<input type = 'submit' name = 'edit' class = 'link' value = 'Edit / View' /></form>
			                        	</li>
			                      </div>
			                    </ul>
			                </div>
			            </td>
			            <td>{{ x.toolNumber }}</td>
			            <td>{{ x.type }}</td>
			            <td>{{ x.diameter | number: 3 }}</td>
			            <td>{{ x.radius | number: 3}}</td>
			            <td>{{ x.material }}</td>
			            <td>{{ x.flutes }}</td>
			            <td>{{ x.length | number: 3}}</td>
			            <td>{{ x.edp }}</td>
			            <td>{{ x.notes }}</td>
			            </tr>";
				}
				else if ($machine == '1')
				{
					echo "
						<tr>
						<th></th>
						<th>Tool Number</th>
			            <th>Tool Type</th>
			            <th>Description</th>
			            <th>Notes</th></tr>
			            <tr ng-repeat = \" x in tools | orderBy:sortType \">
			            <td></td>
			            <td>{{ x.toolNumber }}</td>
			            <td>{{ x.type }}</td>
			            <td>{{ x.description }}</td>
			            <td>{{ x.notes }}</td>
			            </tr>";
				}
			?>
	    </table><br>
	    <form action = 'home.php' method = 'post'>
	    	<input type = 'hidden' name = 'partNumber' value = <?php echo $partNumber; ?> />
	    	<input type = 'hidden' name = 'operation' value = <?php echo $operation; ?> />
	    	<input type = 'hidden' name = 'for' value = <?php echo $id; ?> />
	    	<input type = 'submit' name = 'add' class = 'link' value = 'Add Tool' /></form>
	</div>
</div>