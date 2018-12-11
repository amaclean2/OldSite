<?php include("header.php"); ?>
<?php
	if($_SESSION['username'] == '')
    header("location: login.php");

	$reg = @$_POST['submit'];
  	$toolType = $ltt = "";
  	$description = $des = "";
  	$ins_code = $ins = "";
 	$notes = $ln = "";
	$partNumber = $pn = "";
  	$operation = $op = "";
	$date = "";
	$toolNumber = $tn = "";
	$id = "";
	$for = "";
	$sub = "Enter";

	if($reg)
	{
		$id = strip_tags(@$_POST['id']);
		$toolNumber = strip_tags((@$_POST['tool-number']));
		$toolType = strip_tags(@$_POST['toolType']);
		$toolType = str_replace("string:", "", $toolType);
		$description = strip_tags(@$_POST['description']);
		$ins_code = strip_tags(@$_POST['ins-code']);
		$notes = strip_tags(@$_POST['notes']);
		$partNumber = strip_tags(@$_POST['partNumber']);
		$operation = strip_tags(@$_POST['operation']);
		$for = strip_tags(@$_POST['for']);
		$date = date("Y-m-d H:i:s");

		if ($id == '')
	    {
	     	$query = mysqli_query($link, "INSERT INTO ltools
	      		(tool_number, type, description, insert_code, notes, part_number, operation, dateadded)
	      		VALUES ('$toolNumber', '$toolType', '$description', '$ins_code', '$notes', '$partNumber', '$operation', '$date')");
	    }
	    else
	    {
	        $data = mysqli_query($link, "DELETE FROM ltools WHERE id = '$id'");
	        //angle was a data entry that I changed to EDP Number. Everything that says angle, is really EDP
	        $query = mysqli_query($link, "INSERT INTO ltools
      			(id, tool_number, type, description, insert_code, notes, part_number, operation, dateadded)
      			VALUES ('$id', '$toolNumber', '$toolType', '$description', '$ins_code', '$notes', '$partNumber', '$operation', '$date')");
	    }
	    header("location: lhome.php");
	}

	if(isset($_POST['delete']))
	{
	    $id = $_POST['id'];
	    $data = mysqli_query($link, "DELETE FROM ltools WHERE id = '$id'");
	    header("location: lhome.php");
	}

	if(isset($_POST['edit']))
	{
	    $sub = "Enter Changes / Close";
	    $id = $_POST['id'];

	    $data = mysqli_query($link, "SELECT tool_number, type, description, insert_code, notes, part_number, operation
	    FROM ltools WHERE id = '$id'");
	    while( $row = mysqli_fetch_array($data, MYSQL_NUM))
	    {
	        $toolNumber = $row[0];
	        $tn = "Tool Number";
	        $toolType = $row[1];
	        $ltt = "Tool Type";
	        $description = $row[2];
	        $des = "Description";
	        $ins_code = $row[3];
	        $ins = "Insert Code";
	        $notes = $row[4];
	        $ln = "Notes";
	        $partNumber = $row[5];
	        $pn = "Part Number";
	        $operation = $row[6];
	        $op = "Operation";
	        echo "<style>
		      .field select, .field input[type='text'], .field input[type='number']{position: relative; display: inline-block;} .hidden-label{overflow: visible; opacity: 1;display: inline-block; height: 15px;}
		      </style>";
      	}
	}
?>

<div class = "wrapper" id = "wrapper">
	<br>
	<script>
    data = [];
    <?php
      $data = mysqli_query($link, "SELECT id, type, description, insert_code, notes, part_number FROM ltools");
      while( $row = mysqli_fetch_array($data, MYSQL_NUM))
      {
        echo "var newData =
          { id: '" . $row[0] . "', type: '" . $row[1] . "', description: '" . $row[2] . "', insertCode: '" . $row[3] . "', notes: '" . $row[4] . "', partNumber: '" .
           $row[5] . "' };";
        echo "data.push(newData);";
      }
    ?>

      angular.module('sortApp', [])

      .controller('mainController', function($scope) {
        $scope.ltools = data;
        $scope.numberOfPages = function() {
          return Math.ceil($scope.ltools.length/$scope.pageSize);
        }
        $scope.currentPage = 0;
        $scope.pageSize = 30;
        $scope.sortType = 'id';
        $scope.sortReverse = 'false';
        $scope.searchTools = '';
        $scope.toolOptions = ["Select a Tool Type", "Boring Bar", "Insert", "Drill", "Center Drill", "OD Tool", "Cutoff Tool", "Groove Tool", "Other"];
        $scope.iTool = function() {
        	<?php
        		if ($toolType != '') {echo "return '" . $toolType . "';";}
            	else {echo "return \$scope.toolOptions[0];";}
        	?>
        }
      });
    </script>
	<h2>Lathe Tools</h2>
	<div ng-app="sortApp" ng-controller="mainController" ng-init = "vis = true" >
		<form action = "" method = "post" ng-show = "vis">
			<input type = "hidden" name = "id" value = '<?php echo $id; ?>'>
			<input type = "hidden" name = "for" value = '<?php echo $for; ?>'>
			<div class = "field">
				<div class = "hidden-label"><label><?php echo $ltt; ?></label></div><br>
			    <select id = "toolType" name = "toolType" required ng-model = "selectedToolOption" ng-options = "item for item in toolOptions" ng-init = "selectedToolOption = iTool()" autofocus>
          		</select>
			</div>
			<div class = "field">
				<div class ="hidden-label"><label><?php echo $des; ?></label></div><br>
				<input type = "text" name = "description" id = "description" placeholder = "Description" value = "<?php echo $description; ?>" />
				</script>
			</div>
			<div class = "field">
			    <div class ="hidden-label"><label><?php echo $ins; ?></label></div><br>
			    <input type = "text" name = "ins-code" id = "ins-code" placeholder = "Insert Code" value = "<?php echo $ins_code; ?>" />
			</div>
			<div class = "field">
			    <div class ="hidden-label"><label><?php echo $ln; ?></label></div><br>
			    <input type = "text" name = "notes" id = "notes" placeholder = "Notes..." value = "<?php echo $notes; ?>" />
			</div>
			<div class = "field">
			    <div class = "hidden-label"><label><?php echo $pn; ?></label></div><br>
			    <select id = "partNumbers" name = "partNumber" required>
			    	<option selected disabled value="">Select a Part Number</option>
			         <?php
			            echo "<option ";
			            if($partNumber == 'Tool Drawer' || $partNumber == 'Stock')
			              	echo 'selected ';
			            echo 'value = "Stock">Stock</option>';
			            $data = mysqli_query($link, "SELECT part_number FROM parts ORDER BY part_number");
			            while ($row = mysqli_fetch_array($data, MYSQL_NUM))
			            {
			              	echo "<option ";
			              	if($row[0] == $partNumber)
			                	echo "selected ";
			              	echo "value = '" . $row[0] . "'>" . $row[0] . "</option>";
			            }
			        ?>
			    </select>
			</div>
			<div class = "field">
			    <div class = "hidden-label"><label><?php echo $op; ?></label></div><br>
			    <input type = 'text' name = 'operation' placeholder = "Operation" value = "<?php echo $operation; ?>" />
			</div>
			<div class = "field">
	        	<div class = "hidden-label"><label for = "toolNumber"><?php echo $tn; ?></label></div><br>
	        	<input type = 'text' name = 'tool-number' placeholder = "Tool Number on Setup" value = '<?php echo htmlentities($toolNumber); ?>' autocomplete = "off">
	      	</div>
			<div class = "end-buttons">
	          <input type = "submit" name = "submit" value = "<?php echo $sub; ?>">
	          <input type = "reset" value = "Clear">
	        </div>
		</form><br>
		<input type = "button" ng-click = "vis = !vis" value = 'show / hide new tool form' id = "hide-button" /><br><br>


		<div class="container" id = "locate">
	      <div class = "dataDisplay">
	        <form class = "search">
	          <input type = "text" style = "width: 50%;" placeholder = "Search" ng-model = "searchTools">
	        </form>
	        <table>
		        <tr>
		        	<th></th>
		            <th class = "filter">
		                <a href="#locate" ng-click="sortType = 'type'; sortReverse = !sortReverse">
		                Tool Type
		                <span ng-show="sortType == 'type' && !sortReverse" />
		                <span ng-show="sortType == 'type' && sortReverse" /></a>
	              	</th>
		            <th class = "filter">
		                <a href="#locate" ng-click="sortType = 'description'; sortReverse = !sortReverse">
		                Description
		                <span ng-show="sortType == 'description' && !sortReverse" />
		                <span ng-show="sortType == 'description' && sortReverse" /></a>
	              	</th>
		            <th>Insert Code</th>
		            <th>Notes</th>
		            <th class = "filter">
		                <a href="#locate" ng-click="sortType = 'partNumber'; sortReverse = !sortReverse">
		                Part Number
		                <span ng-show="sortType == 'partNumber' && !sortReverse" />
		                <span ng-show="sortType == 'partNumber' && sortReverse" /></a>
	              	</th>
		        </tr>
		        <tr ng-repeat = "y in ltools | filter: searchTools | orderBy:sortType:sortReverse | limitTo:pageSize:currentPage*pageSize">
		        	<td>
		              	<div class = "dropdown">
		                  	<button class = "dropbtn">Options</button>
		                  	<ul class = "dropdown-content">
		                    	<div class = "dropbuffer">
		                      		<li><span class = "void-link">Options</span></li>
		                      		<li><form action = 'lhome.php' method = 'post'>
	                        			<input type = 'hidden' name = 'id' value = "{{ y.id }}" />
	                        			<input type = 'hidden' name = 'for' value = "t" />
	                        			<input type = 'submit' name = 'edit' class = "link" value = 'Edit / View' /></form>
		                      		</li>
		                      		<li><form action = 'lhome.php' method = 'post'>
		                				<input type = 'hidden' name = 'id' value = "{{ y.id }}" />
		                				<input type = 'submit' name = 'delete' class = "link" value = 'Delete' /></form>
		                      		</li>
		                    	</div>
		                  	</ul>
		                </div>
		            </td>
		            <td>{{ y.type }}</td>
		            <td>{{ y.description }}</td>
		            <td>{{ y.insertCode }}</td>
		            <td>{{ y.notes }}</td>
		            <td>{{ y.partNumber }}</td>
		        </tr>
	        </table>
	        <div class = "pagination">
	          <input type = "button" onclick = "window.location='#locate';" ng-disabled = "currentPage == 0" ng-click = "currentPage = currentPage-1" value = "Previous" />
	          <input type = "button" onclick = "window.location='#locate';" ng-disabled = "currentPage >= numberOfPages()-1" ng-click = "currentPage=currentPage+1" value = "Next" />
	        </div>
	       </div>
	    </div>
	</div>
</div>