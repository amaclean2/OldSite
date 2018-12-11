<?php include("header.php");?>
<?php include("priorityCode.php"); ?>

<div class = "wrapper" id = "wrapper">

    <br>
    <h2>Part Priority</h2>
    <div ng-app = "sortApp" ng-init = "vis = false"  ng-controller="mainController">
	    <form action = "parts.php" method = "post" ng-show = "vis">
	        <input type = "hidden" name = "iid" value = "<?php echo $id; ?>">
	        <div class = "field">
	            <div class = "hidden-label"><label for = "partNumber"><?php echo $pn; ?></label></div><br>
	            <input type = "text" name = "partNumber" placeholder = "Part Number" value = "<?php echo $partNumber; ?>" required autofocus>
	        </div>
	        <div class = "field">
	            <div class = "hidden-label"><label for = "revision"><?php echo $rev; ?></label></div><br>
	            <input type = "text" name = "revision" placeholder = "Revision" value = "<?php echo $revision; ?>" required>
	        </div>
	        <div class = "field">
	            <div class = "hidden-label"><label for = "customer"><?php echo $cus; ?></label></div><br>
	            <input type = "text" name = "customer" placeholder = "Customer" value = "<?php echo $customer; ?>" required>
	        </div>
	        <div class = "field">
	            <div class = "hidden-label"><label for = "operation"><?php echo $op; ?></label></div><br>
	            <input type = "text" name = "operation" placeholder = "Operation" value = "<?php echo htmlentities($operation);?>" required>
	        </div>
	        <div class = "field">
	        	<div class = "hidden-label"><label for = "description"><?php //echo $des; ?></label></div><br>
	        	<input type = "text" name = "description" placeholder = "Machine Requirements" value = "<?php //echo htmlentities($description);?>" />
	        </div>
	        <style>
	        	#dueText
	        	{
	        		width: 80px;
	        		background-color: #f2f2f2;
	        		display: inline-block;
	        		padding: 5px 0;
	        		text-align: center;
					border: 1px solid #bfbfbf;
					border-top-left-radius: 4px;
					border-bottom-left-radius: 4px;
					font-size: 14px;
	        	}
	        	#due
				{
					width: calc(100% - 101px);
					min-width: 200px;
					border-top-left-radius: 0;
					border-bottom-left-radius: 0;
					margin-left: -5px;
					height: 16px;
				}
	        </style>
	        <div class = "field">
	            <div class = "hidden-label"></div><br>
	            <div id = "dueText"><label for = "due">Due Date</label></div>
	            <input type = "date" name = "due" id = "due" value = "<?php echo $due; ?>" required>
	        </div>
	        <div class = "end-buttons">
	            <input type = "submit" name = "submit" value = "<?php echo $sub; ?>">
	            <input type = "reset" value = "Clear">
	        </div>
	    </form><br>
    	<input type = "button" ng-click = "vis = !vis" value = 'show / hide new operation form' id = "hide-button" /><br><br>

    <div class="container" id = "locate">
      	<div class = "dataDisplay">
        	<form class = "search">
          		<input type = "text" placeholder = "Search" ng-model = "searchParts">
        	</form>
        	<div id = "priority-buttons">
        		<input type = "button" value = "Show All" />
        	</div>
        	<div id = "priority-buttons">
          		<form target = "blank" action = "shoppingList.php" method = "post">
            		<input type = "submit" value = "Save Priority List" />
          		</form>
        	</div>
        	<h3>Mill</h3>
	        <table>
	        	<thead>
	            <tr>
		            <th></th>
		            <th class = "filter">
		                Part Number
		            </th>
		            <th>Revision</th>
		            <th class = "filter">
		            	Customer
		            </th>
		            <th>Operation</th>
		            <th>Due Date</th>
		            <th>Priority</th>
	            </tr>
	            <thead>
	            <tbody ui-sortable ng-model = "parts">
		            <tr ng-repeat = "x in parts | limitTo:pageSize:currentPage*pageSize | filter: searchParts" 
		              	ng-style = "{'background-color': colors[$index]}" style = "cursor: move;">
		                <td>
			                <div class = "dropdown">
			                    <button class = "dropbtn">Options</button>
			                    <ul class = "dropdown-content">
				                    <div class = "dropbuffer">
				                        <li><span class = "void-link">Options</span></li>
				                        <li><form action = 'parts.php' method = 'post'>
				                          	<input type = 'hidden' name = 'id' value = '{{ x.id }}' />
				                          	<input type = 'submit' name = 'edit' value = 'Edit / View' class = "link" /></form>
				                        </li>
				                        <li><form action = 'parts.php' method = 'post'>
				                          	<input type = 'hidden' name = 'id' value = '{{ x.id }}' />
				                          	<input type = 'submit' name = 'delete' value = 'Delete' class = "link" /></form>
				                        </li>
				                        <li><span class = "test-link link">Mark as Upcoming</span></li>
				                    </div>
			                    </ul>
			                </div>
		                </td>
		                <td>{{ x.partNumber }}</td>
		                <td>{{ x.revision }}</td>
		                <td>{{ x.customer }}</td>
		                <td>{{ x.operation }}</td>
		                <td>{{ x.dueDate }}</td>
		                <td>{{ $index + 1 }}</td>
		            </tr>
	            </tbody>
	          
	        </table>

	        <h3>Lathe</h3>
	        <table>
	        	<thead>
	            <tr>
		            <th></th>
		            <th class = "filter">
		                Part Number
		            </th>
		            <th>Revision</th>
		            <th class = "filter">
		            	Customer
		            </th>
		            <th>Operation</th>
		            <th>Due Date</th>
		            <th>Priority</th>
	            </tr>
	            <thead>
	            <tbody ui-sortable ng-model = "parts">
		            <tr ng-repeat = "x in parts | limitTo:pageSize:currentPage*pageSize | filter: searchParts" ng-class = "{ lhot: 'false' }" style = "cursor: move;">
		                <td>
			                <div class = "dropdown">
			                    <button class = "dropbtn">Options</button>
			                    <ul class = "dropdown-content">
				                    <div class = "dropbuffer">
				                        <li><span class = "void-link">Options</span></li>
				                        <li><form action = 'parts.php' method = 'post'>
				                          	<input type = 'hidden' name = 'id' value = '{{ x.id }}' />
				                          	<input type = 'submit' name = 'edit' value = 'Edit / View' class = "link" /></form>
				                        </li>
				                        <li><form action = 'parts.php' method = 'post'>
				                          	<input type = 'hidden' name = 'id' value = '{{ x.id }}' />
				                          	<input type = 'submit' name = 'delete' value = 'Delete' class = "link" /></form>
				                        </li>
				                        <li><span class = "test-link link">Mark as Upcoming</span></li>
				                    </div>
			                    </ul>
			                </div>
		                </td>
		                <td>{{ x.partNumber }}</td>
		                <td>{{ x.revision }}</td>
		                <td>{{ x.customer }}</td>
		                <td>{{ x.operation }}</td>
		                <td>{{ x.dueDate }}</td>
		                <td>{{ $index + 1 }}</td>
		            </tr>
	            </tbody>
	          
	        </table>
	        <div class = "pagination">
	          	<input type = "button" onclick = "window.location='#locate';" ng-disabled = "currentPage == 0" ng-click = "currentPage = currentPage-1" value = "Previous" />
	          	<input type = "button" onclick = "window.location='#locate';" ng-disabled = "currentPage >= numberOfPages()-1" ng-click = "currentPage=currentPage+1" value = "Next" />
	        </div>
        </div>
      
    </div>
</div>
</body>
</html>