<?php include("header.php");?>
<?php include("partsCode.php");?>


  <div class = "wrapper" id = "wrapper">
    <br>
    <h2>Parts</h2>
    <div ng-app="sortApp" ng-init = "vis = true" ng-controller="mainController">
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
          <div class ="hidden-label"><label for = "toolbox"><?php echo $tb; ?></label></div><br>
          <input type = "text" name = "toolbox" placeholder = "Toolbox" value = "<?php echo $toolbox; ?>" required>
        </div>
        <h3 id = "fixture-label">Fixturing</h3>
          <div class = "mill-lathe-selector">
            <div class = "selector">
              <input type = "radio" name = "machine" id = "machine-mill" onclick = "show()" checked value = "0">
              <h4>Mill</h4>
            </div>
            <div class = "selector">
              <input type = "radio" name = "machine" id = "machine-lathe" onclick = "show()" value = "1">
              <h4>Lathe</h4>
            </div>
          </div>
          <div id = "reveal-if-mill">
            <div class = "field">
              <div class = "hidden-label"><label for = "fixture"><?php echo $fix; ?></label></div><br>
              <select id = "fixture-list" name = "fixture" ng-model = "selectedFixture" ng-options = "item for item in millFixtures" ng-init = "selectedFixture = iMill()">
              </select>
              <script>
                <?php
                  if($machine == '0')
                  {
                    echo "document.getElementById('machine-mill').checked = 'true';\n";
                    echo "document.getElementById('machine-lathe').disabled = 'true';\n";
                  }
                ?>
              </script>
            </div>
            <div class = "field">
              <div class = "hidden-label"><label for = "fixture-desc"><?php echo $not; ?></label></div><br>
              <input type = "text" id = "fixture-desc" name = "fixture-desc" value = '<?php echo htmlentities($notes); ?>' placeholder = "Description">
            </div>
            <div class = "shortFields">
              <div class = "sf-field">
                <div class = "hidden-sf-label"><label for = "x-0"><?php echo $x0; ?></label></div><br>
                <input type = "text" id = "x-0" name = "x-0" value = '<?php echo htmlentities($x_zero); ?>' placeholder = "x-zero">
              </div>
              <div class = "sf-field">
                <div class = "hidden-sf-label"><label for = "y-0"><?php echo $y0; ?></label></div><br>
                <input type = "text" id = "y-0" name = "y-0" value = '<?php echo htmlentities($y_zero); ?>' placeholder = "y-zero">
              </div><br>
              <div class = "sf-field">
                <div class = "hidden-sf-label"><label for = "z-0"><?php echo $z0; ?></label></div><br>
                <input type = "text" id = "z-0" name = "z-0" value = '<?php echo htmlentities($z_zero); ?>' placeholder = "z-zero">
              </div>
              <div class = "sf-field">
                <div class = "hidden-sf-label"><label for = "a-0"><?php echo $a0; ?></label></div><br>
                <input type = "text" id = "a-0" name = "a-0" value = '<?php echo htmlentities($a_zero); ?>' placeholder = "a-zero (optional)">
              </div>
            </div>
          </div>
          <div id = "reveal-if-lathe">
            <div class = "field">
              <div class = "hidden-label"><label for = "lFixture"><?php echo $fix; ?></label></div><br>
              <select name = "lFixture" id = "lFixtures" ng-model = "selectedLFixture" ng-options = "item for item in latheFixtures" ng-init = "selectedLFixture = iLathe()">
              </select>
              <script>
                <?php 
                  if($machine == '1')
                  {
                    echo "document.getElementById('machine-lathe').checked = 'true';";
                    echo "document.getElementById('machine-mill').disabled = 'true';";
                  }
                ?>
              </script>
            </div>
            <div class = "field">
              <div class = "hidden-label"><label for = "lathe-fixture"><?php echo $not; ?></label></div><br>
              <input type = "text" id = "lathe-fixture-description" name = "lathe-fixture" value = '<?php echo htmlentities($notes); ?>' placeholder = "Description">
            </div>
            <div class = "shortFields">
              <div class = "sf-field">
                <div class = "hidden-sf-label"><label for = "lx-0"><?php echo $x0; ?></label></div><br>
                <input type = "text" id = "lx-0" name = "lx-0" value = '<?php echo htmlentities($x_zero); ?>' placeholder = "x-zero">
              </div>
              <div class = "sf-field">
                <div class = "hidden-sf-label"><label for = "lz-0"><?php echo $z0; ?></label></div><br>
                <input type = "text" id = "lz-0" name = "lz-0" value = '<?php echo htmlentities($z_zero); ?>' placeholder = "z-zero">
              </div>
            </div>
          </div>
        <div class = "end-buttons">
          <input type = "submit" name = "submit" value = "<?php echo $sub; ?>">
          <input type = "reset" value = "Clear">
        </div>
      </form><br>
      <input type = "button" ng-click = "vis = !vis" value = 'show / hide new part form' id = "hide-button" /><br><br>

      <script>show();</script>

      <div class="container" id = "locate">
        <div class = "dataDisplay">
          <form class = "search">
            <input type = "text" placeholder = "Search" ng-model = "searchParts">
          </form>
          <table>
              <tr>
                <th></th>
                <th class = "filter">
                  <a href="#locate" ng-click="sortType = 'partNumber'; sortReverse = !sortReverse">
                  Part Number
                  <span ng-show="sortType == 'partNumber' && !sortReverse" />
                  <span ng-show="sortType == 'partNumber' && sortReverse" /></a>
                </th>
                <th>Revision</th>
                <th class = "filter">
                  <a href="#locate" ng-click="sortType = 'customer'; sortReverse = !sortReverse">
                  Customer
                  <span ng-show="sortType == 'customer' && !sortReverse" />
                  <span ng-show="sortType == 'customer' && sortReverse" /></a>
                </th>
                <th>Operation</th>
                <th class = "filter">
                  <a href="#locate" ng-click="sortType = 'toolbox'; sortReverse = !sortReverse">
                  Tool Box
                  <span ng-show="sortType == 'toolbox' && !sortReverse" />
                  <span ng-show="sortType == 'toolbox' && sortReverse" /></a>
                </th>
              </tr>
              <tbody ng-model = "parts">
                <tr ng-repeat = "x in parts | orderBy:sortType:sortReverse | limitTo:pageSize:currentPage*pageSize | filter: searchParts" >
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
                          <li><form target = "blank" action = 'setupsheet.php' method = 'get'>
                              <input type = 'hidden' name = 'id' value = '{{ x.id }}' />
                              <input type = 'submit' name = 'setup' value = 'Setup Sheet' class = "link" /></form>
                          </li>
                          <li><span class = "test-link link">Mark as Upcoming</span>
                          </li>
                        </div>
                      </ul>
                    </div>
                  </td>
                  <td>{{ x.partNumber }}</td>
                  <td>{{ x.revision }}</td>
                  <td>{{ x.customer }}</td>
                  <td>{{ x.operation }}</td>
                  <td>{{ x.toolbox }}</td>
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
  </div>
</body>
</html>