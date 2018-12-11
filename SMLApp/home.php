<?php include("header.php");
      include("homephpCode.php"); ?>


  <div class = "wrapper" id = "wrapper">

    <br>
    <h2>Mill Tools</h2>
    <div ng-app="sortApp" ng-controller="mainController" ng-init = "vis = true" >
      <form name = "toolForm" action = "home.php"  onsubmit = "return validateForm()" method = "post" ng-show = "vis">
        <input type = "hidden" name = "iid" value = '<?php echo $id; ?>'>
        <input type = "hidden" name = "for" value = '<?php echo $for; ?>'>
        <div class = "field">
          <div class = "hidden-label"><label for = "toolType"><?php echo $tt; ?></label></div><br>
          <select id = "toolType" name = "toolType" required ng-model = "selectedToolOption" ng-options = "item for item in toolOptions" ng-init = "selectedToolOption = iTool()" autofocus>
          </select>
        </div>
        <div class = "field">
          <div class = "hidden-label"><label for = "diameter"><?php echo $dia; ?></label></div><br>
          <input type = "number" step = ".0001" name = "diameter" placeholder = "Diameter" value = '<?php echo $diameter; ?>' required autocomplete = "off">
        </div>
        <div class = "field">
          <div class = "hidden-label"><label for = "radius"><?php echo $rad; ?></label></div><br>
          <input type = "number" step = ".001" name = "radius" placeholder = "Corner Radius (optional)" value = '<?php echo $radius; ?>' autocomplete = "off">
        </div>
        <div class = "field">
          <div class = "hidden-label"><label for = "material"><?php echo $mat; ?></label></div><br>
          <select id = "material" name = "material" required ng-model = "selectedMatOption" ng-options = "item for item in matOptions" ng-init = "selectedMatOption = iMat()">
          </select>
        </div>
        <div class = "field">
          <div class = "hidden-label"><label for = "flutes"><?php echo $flu; ?></label></div><br>
          <input type = "number" name = "flutes" placeholder = "Flutes" value = '<?php echo $flutes; ?>' required autocomplete = "off">
        </div>
        <div class = "field">
          <div class = "hidden-label"><label for = "length"><?php echo $len; ?></label></div><br>
          <input type = "number" step = ".001" name = "length" placeholder = "Flute Length" value = '<?php echo $length; ?>' required autocomplete = "off">
        </div>
        <div class = "field">
          <div class = "hidden-label"><label for = "angle"><?php echo $edp; ?></label></div><br>
          <input type = "text" name = "angle" placeholder = "EDP Number (optional)" value = '<?php echo htmlentities($angle); ?>' autocomplete = "off">
        </div>
        <div class = "field">
          <div class = "hidden-label"><label for = "partNumber"><?php echo $pn; ?></label></div><br>
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
          <div class = "hidden-label"><label for = "operation"><?php echo $op; ?></label></div><br>
          <input type = 'text' name = 'operation' placeholder = "Operation" value = '<?php echo htmlentities($operation); ?>'>
        </div>
        <div class = "field">
          <div class = "hidden-label"><label for = "toolNumber"><?php echo $tn; ?></label></div><br>
          <input type = 'text' name = 'toolNumber' placeholder = "Tool Number on Setup" value = '<?php echo htmlentities($toolNumber); ?>' autocomplete = "off">
        </div>
        <div class = "field">
          <div class = "hidden-label"><label for = "notes"><?php echo $not; ?></label></div><br>
          <input type = "text" name = "notes" placeholder = "Notes..." value = '<?php echo htmlentities($notes); ?>'>
        </div>
        <div class = "end-buttons">
          <input type = "submit" name = "submit" value = "<?php echo $sub; ?>" id = 'toolEntry'>
          <input type = "reset" name = "reset" value = "Clear">
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
                  <span ng-show="sortType == 'type' && !sortReverse" class = "fa fa-caret-down"/>
                  <span ng-show="sortType == 'type' && sortReverse" class = "fa fa-caret-up"/></a>
                </th>
                <th class = "filter">
                  <a href="#locate" ng-click="sortType = 'diameter'; sortReverse = !sortReverse">
                  Diameter
                  <span ng-show="sortType == 'diameter' && !sortReverse" />
                  <span ng-show="sortType == 'diameter' && sortReverse" /></a>
                </th>
                <th>Material/Coating</th>
                <th class = "filter">
                  <a href="#locate" ng-click="sortType = 'length'; sortReverse = !sortReverse">
                  Flute Length
                  <span ng-show="sortType == 'length' && !sortReverse" />
                  <span ng-show="sortType == 'length' && sortReverse" /></a>
                </th>
                <th class = "filter">
                  <a href="#locate" ng-click="sortType = 'edp'; sortReverse = !sortReverse">
                  EDP Number
                  <span ng-show="sortType == 'edp' && !sortReverse" />
                  <span ng-show="sortType == 'edp' && sortReverse" /></a>
                </th>
                <th class = "filter">
                  <a href="#locate" ng-click="sortType = 'partNumber'; sortReverse = !sortReverse">
                  Part Number
                  <span ng-show="sortType == 'partNumber' && !sortReverse" />
                  <span ng-show="sortType == 'partNumber' && sortReverse" /></a>
                </th>
              </tr>

              <tr ng-repeat = "x in tools | filter: searchTools | orderBy:sortType:sortReverse | limitTo:pageSize:currentPage*pageSize">
                <td>
                  <div class = "dropdown">
                    <button class = "dropbtn">Options</button>
                    <ul class = "dropdown-content">
                      <div class = "dropbuffer">
                        <li><span class = "void-link">Options</span></li>
                        <li><form action = 'request.php' method = 'post'>
                          <input type = 'hidden' name = 'machine' id = 'machine' value = "mill-h" />
                          <input type = 'hidden' name = 'id' id = 'id' value = "{{ x.id }}" />
                          <input type = 'submit' name = 'order' class = "link" value = 'Order' /></form>
                        </li>
                        <li><form action = 'home.php' method = 'post'>
                          <input type = 'hidden' name = 'ed' value = "{{ x.id }}" />
                          <input type = 'submit' name = 'edit' class = "link" value = 'Edit / View' /></form>
                        </li>
                        <li><form action = 'home.php' method = 'post'>
                          <input type = 'hidden' name = 'id' id = 'id' value = "{{ x.id }}" />
                          <input type = 'submit' name = 'delete' class = "link" value = 'Delete' /></form>
                        </li>
                      </div>
                    </ul>
                  </div>
                </td>
                <td>{{ x.type }}</td>
                <td>{{ x.diameter | number: 3 }}</td>
                <td>{{ x.material }}</td>
                <td>{{ x.length | number: 1 }}</td>
                <td>{{ x.angle }}</td>
                <td>{{ x.partNumber }}</td>
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
</body>
</html>