<?php include("header.php"); ?>
<?php include("purchaseHistoryCode.php"); ?>

    
 <div class = "wrapper" id = "wrapper">
    <br>
    <h2><?php echo $message; ?></h2>
    <div ng-app = "sortApp" ng-init = "<?php echo $visible; ?>"  ng-controller="mainController">
    	<form name = "toolForm" action = "purchased.php"  method = "post" id = "POForm" ng-show = "vis">
	        <div class = "add-part">
	        	<div class = "hidden-label"><label></label></div><br>
	        	<select id = "add" ng-model = "selectedRequests" ng-options = "item.Description for item in req" ng-init = "selectedRequests = req[0]" autofocus>
	        	</select>
	        	<input type = "button" value = "Add" ng-click = "additem()" />
	        </div>
	        <div class = "purchased-parts">
	        	<ul>
	        		<li ng-repeat = "x in added"><span class = "x" ng-click = "removeItem($index)">×</span><div class = "des" >{{ x.Description }}</div>
	        			<div class = "numbers">
	        				<input type = "hidden" name = "id" value = "{{ x.Id }}" />
	        				<input type = "hidden" name = "machine" value = "{{ x.Machine }}" />
	        				<input type = "number" name = "{{ x.Id + '.' + x.Machine }}.quantity" ng-model = "quantity" placeholder = "QTY {{ x.Quantity }}" required/>
	        				<input type = "number" name = "{{ x.Id + '.' + x.Machine }}.price" step = ".01" ng-model = "price" placeholder = "price" required/>
	        				<p>${{ price * quantity | number: 2 }}</p>
	        			</div>
	        		<li>
	        	</ul>

	        </div>
	        <style>
	        	.purchased-parts
	        	{
	        		border: 1px solid #bfbfbf;
	        		height: 150px;
	        		border-radius: 3px;
	        		width: 60%;
	        		clear: both;
	        		min-width: 350px;
	        		margin: 4px 0;
	        		overflow-y: scroll;
	        		overflow-x: hidden;
	        	}
	        	.numbers{float: right;}
	        	.des{width: calc(100% - 315px); height: 18px; float: left; overflow: hidden;}
	        	.x {cursor: pointer; padding-right: 10px; float: left;}
	        	.purchased-parts input[type='number']{width: 75px; padding: 3px; margin: 0 2px; display: inline-block;}
	        	.purchased-parts li{padding: 4px; width: 100%; clear: both;}
	        	.purchased-parts p{width: 100px; padding: 3px; margin: 0 2px; display: inline-block;}
	        	ul{margin: 0; padding: 5px 0 0 5px;}
	        	.add-part{clear: both; width: 40%; position: relative; padding: 8px 0;}
	        	.add-part select{width: calc(100% - 65px); float: left; padding: 5px; position: absolute; top: 0;}
	        	.add-part input[type='button']{width: 60px; float: left; position: absolute; top: 0; right: 0; padding: 6px;}
	        </style>
		    <div class = "field">
	          	<div class ="hidden-label"><label></label></div><br>
	          	<input type = "text" name = "source" id = "source" placeholder = "Source of Purchase" required />
	        </div>
	        <div class = "field">
	          	<div class ="hidden-label"><label></label></div><br>
	          	<input type = "text" ng-model = "poNum" name = "poNum" id = "poNum" placeholder = "Purchase Order Number" value = '{{ poNum }}' <?php if($edited == 'true') echo 'disabled'; ?> required selected/>
	          	<input type = "button" ng-click = "index()" name = "selectNext" id = "selectNext" value = 'select next' <?php if($poNum != '') echo 'disabled'; ?> />
	        </div>
		    <div class = "end-buttons">
		        <input type = "submit" name = "submit" value = "<?php echo $sub; ?>">
		        <input type = "reset" value = "Clear">
		    </div>
	    </form><br>
	    <input type = "button" ng-click = "vis = !vis" value = 'show / hide purchase form' id = "hide-button" /><br><br>
	    

	    <div class="container">

	      <div class = "dataDisplay">
	        <form class = "search">
	          <input type = "text" style = "width: 50%;" class = "form-control" placeholder = "Search" ng-model = "searchTools">
	        </form>

	        <div id = "skip-point">
	          <table>
	            <tr>
	              <th></th>
	              <th class = "filter">
	                <a href="#skip-point" ng-click="sortType = 'date'; sortReverse = !sortReverse">
	                Date Added
	                <span ng-show="sortType == 'date' && !sortReverse" />
	                <span ng-show="sortType == 'date' && sortReverse" /></a>
	              </th>
	              <th class = "filter">
	                <a href="#skip-point" ng-click="sortType = 'orderNumber'; sortReverse = !sortReverse">
	                Order Number
	                <span ng-show="sortType == 'orderNumber' && !sortReverse" />
	                <span ng-show="sortType == 'orderNumber' && sortReverse" /></a>
	              </th>
	              <th class = "filter">
	                <a href="#skip-point" ng-click="sortType = 'source'; sortReverse = !sortReverse">
	                Source
	                <span ng-show="sortType == 'source' && !sortReverse" />
	                <span ng-show="sortType == 'source' && sortReverse" /></a>
	              </th>
	              <th class = "filter">
	                <a href="#skip-point" ng-click="sortType = 'description'; sortReverse = !sortReverse">
	                Description
	                <span ng-show="sortType == 'description' && !sortReverse" />
	                <span ng-show="sortType == 'description' && sortReverse" /></a>
	              </th>
	            </tr>

	            <tr ng-repeat = "x in orders | orderBy:sortType:sortReverse | limitTo:pageSize:currentPage*pageSize | filter: searchTools">
	              <td>
	                <div class = "dropdown">
	                  <button class = "dropbtn">Options</button>
	                  <ul class = "dropdown-content">
	                    <div class = "dropbuffer">
	                      <li><span class = "void-link">Options</span></li>
	                      <li><form action = 'purchased.php' method = 'post'>
	                        <input type = 'hidden' name = 'ed' value = "{{ x.id }}" />
	                        <input type = 'hidden' name = 'machine' value = '{{ x.category }}' />
	                        <input type = 'hidden' name = 'edited' value = 'true' />
	                        <input type = 'submit' name = 'edit' class = "link" value = "Edit / View" /></form>
	                      <li>
	                    </div>
	                  </ul>
	                </div>
	              </td>
	              <td>{{ x.date }}</td>
	              <td>{{ x.orderNumber }}</td>
	              <td>{{ x.source }}</td>
	              <td>{{ x.description }}</td>
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