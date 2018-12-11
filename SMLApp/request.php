<?php include("header.php"); ?>
<?php include("requestphpCode.php"); ?>
    
  <div class = "wrapper" id = "wrapper">
    <br>
    <h2><?php echo $message; ?></h2>
    <div ng-init = '<?php echo $visible; ?>' ng-app="sortApp" ng-controller="mainController">
      <form name = "toolForm" action = "request.php"  method = "post" id = "attributeForm" ng-show = "vis" />
        <input type = "hidden" value = "<?php echo $id; ?>" name = "id" />
        <input type = "hidden" value = "<?php echo $machine; ?>" name = "machine" />
        <input type = "hidden" value = "<?php echo $bought; ?>" name = "bought" />

        <div class = "mill-lathe-selector">
          <div class = "selector">
            <input type = "radio" name = "machine" id = "machine-mill" onclick = "show()" value = "mill" checked>
            <h4>Mill</h4>
          </div>
          <div class = "selector">
            <input type = "radio" name = "machine" id = "machine-lathe" onclick = "show()" value = "lathe">
            <h4>Lathe</h4>
          </div>
          <div class = "selector">
            <input type = "radio" name = "machine" id = "machine-other" onclick = "show()" value = "other">
            <h4>Other Parts</h4>
          </div>
        </div>

        <div id = "reveal-if-mill">
          <div class = "field">
            <div class = "hidden-label"><label for = "toolType"><?php echo $tt; ?></label></div><br>
            <select id = "toolType" name = "toolType" required ng-model = "selectedToolOption" ng-options = "item for item in toolOptions" ng-init = "selectedToolOption = iTool()" autofocus>
            </select>
            <script>
              <?php 
                if($machine == 'mill')
                {
                  echo "document.getElementById('machine-mill').checked = 'true';\n";
                  echo "document.getElementById('machine-lathe').disabled = 'true';\n";
                }
              ?>
            </script>
          </div>
          <div class = "field">
            <div class = "hidden-label"><label for = "diameter"><?php echo $dia; ?></label></div><br>
            <input type = "number" step = ".0001" name = "diameter" id = "diameter" value = '<?php echo $diameter; ?>' placeholder = "Diameter">
          </div>
          <div class = "field">
            <div class = "hidden-label"><label for = "material"><?php echo $mat; ?></label></div><br>
            <select id = "material" name = "material" required ng-model = "selectedMatOption" ng-options = "item for item in matOptions" ng-init = "selectedMatOption = iMat()">
            </select>
          </div>
          <div class = "field">
            <div class = "hidden-label"><label for = "edp"><?php echo $edpText; ?></label></div><br>
            <input type = "text" name = "edp" placeholder = "EDP Number (optional)" value = '<?php echo $edp; ?>' />
          </div>
        </div>


        <div id = "reveal-if-lathe">
          <div class = "field">
            <div class = "hidden-label"><label for = "ltoolType"><?php echo $tt; ?></label></div><br>
            <select id = "ltoolType" name = "ltoolType" required ng-model = "selectedLatheTool" ng-options = "item for item in lToolOptions" ng-init = "selectedLatheTool = lTool()" autofocus>
            </select>
            <script>
              <?php
                if($machine == 'lathe')
                {
                  echo "document.getElementById('machine-lathe').checked = 'true';\n";
                  echo "document.getElementById('machine-mill').disabled = 'true';\n";
                }
              ?>
            </script>
          </div>
          <div class = "field">
            <div class ="hidden-label"><label for = "description"><?php echo $des; ?></label></div><br>
            <input type = "text" name = "ldescription" id = "ldescription" placeholder = "Description" value = '<?php echo $description; ?>' />
            </script>
          </div>
          <div class = "field">
            <div class ="hidden-label"><label for = "ins-code"><?php echo $ins; ?></label></div><br>
            <input type = "text" name = "ins-code" id = "ins-code" placeholder = "Insert Code" value = '<?php echo $ins_code; ?>' />
          </div>
        </div>


        <div id = "reveal-if-other">
          <div class = "field">
            <div class ="hidden-label"><label for = "otherDescription"><?php echo $des; ?></label></div><br>
            <input type = "text" name = "odescription" id = "odescription" placeholder = "Description" value = '<?php echo $description; ?>' />
            <script>
            <?php
              if($machine == 'other')
                echo "document.getElementById('machine-mill').disabled = 'true';\n
                  document.getElementById('machine-lathe').disabled = 'true';\n
                  document.getElementById('machine-other').checked = 'true';";
            ?>
            </script>
          </div>
        </div>

        <div class = "field">
          <div class ="hidden-label"><label for = "otherNotes"><?php echo $not; ?></label></div><br>
          <input type = "text" name = "notes" id = "notes" placeholder = "Notes..." value = '<?php echo $notes; ?>' />
        </div>
        <div class = "field">
          <div class = "hidden-label"><label for = "otherQuantity"><?php echo $quan; ?></label></div><br>
          <input type = "number" name = "quantity" id = "quantity" placeholder = "Quantity" value = '<?php echo $quantity; ?>' required />
        </div>
        <div class = "field">
          <div class = "hidden-label"><label for = "otherPartNumber"><?php echo $pn; ?></label></div><br>
          <select id = "partNumbers" name = "partNumber" required />
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
          <div class = "hidden-label"><label for "otherOperation"><?php echo $op; ?></label></div><br>
          <input type = 'text' name = 'operation' placeholder = "Operation" value = '<?php echo $operation; ?>' required />
        </div>
        <div class = "field">
          <div class = "hidden-label"><label></label></div><br>
          <div class = "urgent">
            <input type = "checkbox" name = "urgent" value = 'ch' />
            <h5>Mark As Urgent</h5>
          </div>
        </div>

        <div class = "end-buttons">
          <input type = "submit" name = "submit" value = "<?php echo $sub; ?>">
          <input type = "reset" value = "Clear">
        </div>
      </form><br>
      <input type = "button" ng-click = "vis = !vis" value = 'show / hide new request form' id = "hide-button" /><br><br>


      <script>
        function show()
        {
          var rim = document.getElementById("reveal-if-mill");
          var ril = document.getElementById("reveal-if-lathe");
          var rio = document.getElementById("reveal-if-other");

          if(document.getElementById("machine-mill").checked)
          {
            rim.style.overflow = "visible";
            rim.style.opacity = "1";
            rim.style.maxHeight = "500px";
            rim.style.paddingTop = "10px";
            document.getElementById("toolType").required = true;
            document.getElementById("diameter").required = true;
            document.getElementById("material").required = true;
            document.getElementById("ltoolType").required = false;
            document.getElementById("ldescription").required = false;
            document.getElementById("odescription").required = false;
          }
          else
          {
            rim.style.overflow = "hidden";
            rim.style.opacity = "0";
            rim.style.maxHeight = "0";
            rim.style.paddingTop = "0";
          }

          if(document.getElementById("machine-lathe").checked)
          {
            ril.style.overflow = "visible";
            ril.style.maxHeight = "500px";
            ril.style.opacity = "1";
            ril.style.paddingTop = "10px";
            document.getElementById("toolType").required = false;
            document.getElementById("diameter").required = false;
            document.getElementById("material").required = false;
            document.getElementById("ltoolType").required = true;
            document.getElementById("ldescription").required = true;
            document.getElementById("odescription").required = false;
          }
          else
          {
            ril.style.overflow = "hidden";
            ril.style.maxHeight = "0";
            ril.style.opacity = "0";
            ril.style.paddingTop = "0";
          }

          if(document.getElementById("machine-other").checked)
          {
            rio.style.overflow = "visible";
            rio.style.maxHeight = "500px";
            rio.style.opacity = "1";
            rio.style.paddingTop = "10px";
            document.getElementById("toolType").required = false;
            document.getElementById("diameter").required = false;
            document.getElementById("material").required = false;
            document.getElementById("ltoolType").required = false;
            document.getElementById("ldescription").required = false;
            document.getElementById("odescription").required = true;
          }
          else
          {
            rio.style.overflow = "hidden";
            rio.style.maxHeight = "0";
            rio.style.opacity = "0";
            rio.style.paddingTop = "0";
          }
        }
        show();
      </script>

      <div class="container"
        <div class = "dataDisplay">
          <form class = "search">
            <input type = "text" style = "width: 50%;" class = "form-control" placeholder = "Search" ng-model = "searchTools">
          </form>
          <div id = "print-button">
            <form target = "blank" action = "shoppingList.php" method = "post">
              <input type = "submit" value = "Print" />
            </form>
          </div>
          <div id = "skip-point-mill">
            <h3 id = "table-id">Mill</h3>
            <table>
              <tr>
                <th></th>
                <th class = "filter">
                  <a href="#skip-point-mill" ng-click="sortType = 'date'; sortReverse = !sortReverse">
                  Date Added
                  <span ng-show="sortType == 'date' && !sortReverse" />
                  <span ng-show="sortType == 'date' && sortReverse" /></a>
                </th>
                <th class = "filter">
                  <a href="#skip-point-mill" ng-click="sortType = 'type'; sortReverse = !sortReverse">
                  Tool Type
                  <span ng-show="sortType == 'type' && !sortReverse" />
                  <span ng-show="sortType == 'type' && sortReverse" /></a>
                </th>
                <th class = "filter">
                  <a href="#skip-point-mill" ng-click="sortType = 'diameter'; sortReverse = !sortReverse">
                  Diameter
                  <span ng-show="sortType == 'diameter' && !sortReverse" />
                  <span ng-show="sortType == 'diameter' && sortReverse" /></a>
                </th>
                <th>Material/Coating</th>
                <th>Notes</th>
                <th class = "filter">
                  <a href="#skip=point-mill" ng-click="sortType = 'quantity'; sortReverse = !sortReverse">
                  Quantity
                  <span ng-show="sortType == 'quantity' && !sortReverse" />
                  <span ng-show="sortType == 'quantity' && sortReverse" /></a>
                </th>
                <th class = "filter">
                  <a href="#skip-point-mill" ng-click="sortType = 'partNumber'; sortReverse = !sortReverse">
                  Part Number
                  <span ng-show="sortType == 'partNumber' && !sortReverse" />
                  <span ng-show="sortType == 'partNumber' && sortReverse" /></a>
                </th>
                <th class = "filter">
                  <a href="#skip-point-mill" ng-click="sortType = 'seen'; sortReverse = !sortReverse">
                  Order Level
                  <span ng-show="sortType == 'seen' && !sortReverse" />
                  <span ng-show="sortType == 'seen' && sortReverse" /></a>
                </th>
              </tr>

              <tr style = "background-color: {{ x.seen }};" ng-repeat = "x in tools | filter: searchTools | orderBy:sortType:sortReverse | limitTo:pageSize:currentPage*pageSize">
                <td>
                  <div class = "dropdown">
                    <button class = "dropbtn">Options</button>
                    <ul class = "dropdown-content">
                      <div class = "dropbuffer">
                        <li><span class = "void-link">Options</span></li>
                        <li><form action = 'purchased.php' method = 'post'>
                          <input type = 'hidden' name = 'ed' id = 'id' value = "{{ x.id }}" />
                          <input type = 'hidden' name = 'machine' id = 'machine-id' value = "mill" />
                          <input type = 'hidden' name = 'edited' value = 'false' />
                          <input type = 'submit' name = 'edit' class = "link" value = 'Purchase' /></form>
                        </li>
                        <li><form action = 'request.php' method = 'post'>
                          <input type = 'hidden' name = 'id' value = "{{ x.id }}" />
                          <input type = 'hidden' name = 'machine' value = 'mill' />
                          <input type = 'submit' name = 'edd' class = "link" value = "Edit / View" /></form>
                        <li>
                          <form action = 'request.php' method = 'post'>
                          <input type = 'hidden' name = 'ed' id = 'id' value = "{{ x.id }}" />
                          <input type = 'submit' name = 'delete' class = "link" value = 'Delete' /></form>
                        </li>
                        <?php 
                          if($_SESSION['level'] == 'Admin')
                          {
                            echo " <li><form action = 'request.php' method = 'post'>
                              <input type = 'hidden' name = 'seen' value = '{{ x.markValue }}' />
                              <input type = 'hidden' name = 'ed' value = '{{ x.id }}' />
                              <input type = 'hidden' name = 'machine' value = '0' />
                              <input type = 'submit' name = 'marked' class = 'link' value = ' {{ x.markText }}' /></form>
                              <li>";
                          }
                        ?>
                      </div>
                    </ul>
                  </div>
                </td>
                <td>{{ x.date }}</td>
                <td>{{ x.type }}</td>
                <td>{{ x.diameter | number: 3 }}</td>
                <td>{{ x.material }}</td>
                <td>{{ x.notes }}</td>
                <td>{{ x.quantity }}</td>
                <td>{{ x.partNumber }}</td>
                <td><b>{{ x.orderLevel }}</b></td>
              </tr>
              
            </table>
            <div class = "pagination">
              <input type = "button" onclick = "window.location='#locate';" ng-disabled = "currentPage == 0" ng-click = "currentPage = currentPage-1" value = "Previous" />
              <input type = "button" onclick = "window.location='#locate';" ng-disabled = "currentPage >= numberOfPages()-1" ng-click = "currentPage=currentPage+1" value = "Next" />
            </div>
          </div>

          <div id = "skip-point-lathe">
            <h3 id = "table-id">Lathe</h3>
            <table>
              <tr>
                <th></th>
                <th class = "filter">
                  <a href="#skip-point-lathe" ng-click="sortType = 'date'; sortReverse = !sortReverse">
                  Date Added
                  <span ng-show="sortType == 'date' && !sortReverse" />
                  <span ng-show="sortType == 'date' && sortReverse" /></a>
                </th>
                <th class = "filter">
                  <a href="#skip-point-lathe" ng-click="sortType = 'type'; sortReverse = !sortReverse">
                  Tool Type
                  <span ng-show="sortType == 'type' && !sortReverse" />
                  <span ng-show="sortType == 'type' && sortReverse" /></a>
                </th>
                <th>Description</th>
                <th>Insert Code</th>
                <th>Notes</th>
                <th class = "filter">
                  <a href="#skip-point-lathe" ng-click="sortType = 'quantity'; sortReverse = !sortReverse">
                  Quantity
                  <span ng-show="sortType == 'quantity' && !sortReverse" />
                  <span ng-show="sortType == 'quantity' && sortReverse" /></a>
                </th>
                <th class = "filter">
                  <a href="#skip-point-lathe" ng-click="sortType = 'partNumber'; sortReverse = !sortReverse">
                  Part Number
                  <span ng-show="sortType == 'partNumber' && !sortReverse" />
                  <span ng-show="sortType == 'partNumber' && sortReverse" /></a>
                </th>
                <th class = "filter">
                  <a href="#skip-point-lathe" ng-click="sortType = 'seen'; sortReverse = !sortReverse">
                  Order Level
                  <span ng-show="sortType == 'seen' && !sortReverse" />
                  <span ng-show="sortType == 'seen' && sortReverse" /></a>
                </th>
              </tr>

              <tr style = "background-color: {{ y.seen }};" ng-repeat = "y in ltools | filter: searchTools | orderBy:sortType:sortReverse | limitTo:pageSize:lcurrentPage*pageSize">
                <td>
                  <div class = "dropdown">
                    <button class = "dropbtn">Options</button>
                    <ul class = "dropdown-content">
                      <div class = "dropbuffer">
                        <li><span class = "void-link">Options</span></li>
                        <li><form action = 'purchased.php' method = 'post'>
                          <input type = 'hidden' name = 'ed' id = 'id' value = "{{ y.id }}" />
                          <input type = 'hidden' name = 'machine' id = 'machine-id' value = "lathe" />
                          <input type = 'hidden' name = 'edited' value = 'false' />
                          <input type = 'submit' name = 'edit' class = "link" value = 'Purchase' /></form>
                        </li>
                        <li><form action = 'request.php' method = 'post'>
                          <input type = 'hidden' name = 'id' value = "{{ y.id }}" />
                          <input type = 'hidden' name = 'machine' value = 'lathe' />
                          <input type = 'submit' name = 'edd' class = "link" value = "Edit / View" /></form>
                        <li>
                        <li><form action = 'request.php' method = 'post'>
                          <input type = 'hidden' name = 'ed' id = 'id' value = "{{ y.id }}" />
                          <input type = 'submit' name = 'ldelete' class = "link" value = 'Delete' /></form>
                        </li>
                        <?php 
                          if($_SESSION['level'] == 'Admin')
                          {
                            echo " <li><form action = 'request.php' method = 'post'>
                              <input type = 'hidden' name = 'seen' value = '{{ y.markValue }}' />
                              <input type = 'hidden' name = 'ed' value = '{{ y.id }}' />
                              <input type = 'hidden' name = 'machine' value = '1' />
                              <input type = 'submit' name = 'marked' class = 'link' value = '{{ y.markText }}' /></form>
                              <li>";
                          }
                        ?>
                      </div>
                    </ul>
                  </div>
                </td>
                <td>{{ y.date }}</td>
                <td>{{ y.type }}</td>
                <td>{{ y.description }}</td>
                <td>{{ y.insCode }}</td>
                <td>{{ y.notes }}</td>
                <td>{{ y.latheQuantity }}</td>
                <td>{{ y.partNumber }}</td>
                <td><b>{{ y.orderLevel }}</b></td>
              </tr>
            </table>
            <div class = "pagination">
              <input type = "button" onclick = "window.location='#locate';" ng-disabled = "lcurrentPage == 0" ng-click = "lcurrentPage = lcurrentPage-1" value = "Previous" />
              <input type = "button" onclick = "window.location='#locate';" ng-disabled = "lcurrentPage >= lnumberOfPages()-1" ng-click = "lcurrentPage=lcurrentPage+1" value = "Next" />
            </div>
          </div>

          <div id = "skip-point-other">
            <h3 id = "table-id">Other</h3>
            <table>
              <tr>
                <th></th>
                <th class = "filter">
                  <a href="#skip-point-other" ng-click="sortType = 'date'; sortReverse = !sortReverse">
                  Date Added
                  <span ng-show="sortType == 'date' && !sortReverse" />
                  <span ng-show="sortType == 'date' && sortReverse" /></a>
                </th>
                <th>Description</th>
                <th>Notes</th>
                <th class = "filter">
                  <a href="#skip-point-other" ng-click="sortType = 'quantity'; sortReverse = !sortReverse">
                  Quantity
                  <span ng-show="sortType == 'quantity' && !sortReverse" />
                  <span ng-show="sortType == 'quantity' && sortReverse" /></a>
                </th>
                <th class = "filter">
                  <a href="#skip-point-other" ng-click="sortType = 'partNumber'; sortReverse = !sortReverse">
                  Part Number
                  <span ng-show="sortType == 'partNumber' && !sortReverse" />
                  <span ng-show="sortType == 'partNumber' && sortReverse" /></a>
                </th>
                <th class = "filter">
                  <a href="#skip-point-other" ng-click="sortType = 'seen'; sortReverse = !sortReverse">
                  Order Level
                  <span ng-show="sortType == 'seen' && !sortReverse" />
                  <span ng-show="sortType == 'seen' && sortReverse" /></a>
                </th>
              </tr>

              <tr style = "background-color: {{ o.seen }};" ng-repeat = "o in otools | filter: searchTools | orderBy:sortType:sortReverse | limitTo:pageSize:ocurrentPage*pageSize">
                <td>
                  <div class = "dropdown">
                    <button class = "dropbtn">Options</button>
                    <ul class = "dropdown-content">
                      <div class = "dropbuffer">
                        <li><span class = "void-link">Options</span></li>
                        <li><form action = 'purchased.php' method = 'post'>
                          <input type = 'hidden' name = 'ed' id = 'id' value = "{{ o.id }}" />
                          <input type = 'hidden' name = 'machine' id = 'machine-id' value = "other" />
                          <input type = 'hidden' name = 'edited' value = 'false' />
                          <input type = 'submit' name = 'edit' class = "link" value = 'Purchase' /></form>
                        </li>
                        <li><form action = 'request.php' method = 'post'>
                          <input type = 'hidden' name = 'id' value = "{{ o.id }}" />
                          <input type = 'hidden' name = 'machine' value = 'other' />
                          <input type = 'submit' name = 'edd' class = "link" value = "Edit / View" /></form>
                        <li>
                        <li><form action = 'request.php' method = 'post'>
                          <input type = 'hidden' name = 'ed' id = 'id' value = "{{ o.id }}" />
                          <input type = 'submit' name = 'odelete' class = "link" value = 'Delete' /></form>
                        </li>
                        <?php 
                          if($_SESSION['level'] == 'Admin')
                          {
                            echo " <li><form action = 'request.php' method = 'post'>
                              <input type = 'hidden' name = 'seen' value = '{{ o.markValue }}' />
                              <input type = 'hidden' name = 'ed' value = '{{ o.id }}' />
                              <input type = 'hidden' name = 'machine' value = '2' />
                              <input type = 'submit' name = 'marked' class = 'link' value = '{{ o.markText }}' /></form>
                              <li>";
                          }
                        ?>
                      </div>
                    </ul>
                  </div>
                </td>
                <td>{{ o.date }}</td>
                <td>{{ o.description }}</td>
                <td>{{ o.notes }}</td>
                <td>{{ o.quantity }}</td>
                <td>{{ o.partNumber }}</td>
                <td><b>{{ o.orderLevel }}</b></td>
              </tr>
            </table>
            <div class = "pagination">
              <input type = "button" onclick = "window.location='#locate';" ng-disabled = "ocurrentPage == 0" ng-click = "ocurrentPage = ocurrentPage-1" value = "Previous" />
              <input type = "button" onclick = "window.location='#locate';" ng-disabled = "ocurrentPage >= onumberOfPages()-1" ng-click = "ocurrentPage=ocurrentPage+1" value = "Next" />
            </div>
          </div>
            
        </div>
      </div>
    </div>
  </div>
</body>
</html>