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
            echo "console.log('Hello!');";
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
          $scope.vis = false;
        }

    });
</script>


  <div class = "wrapper" id = "wrapper" ng-app="sortApp" ng-controller="mainController" ng-init = "init()">
    <style>
      .modalDialog
      {
        position: fixed;
        font-family: Helvetica, Arial, sans-serif;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background: rgba(0,0,0,0.8);
        z-index: 99999;
      }
      .modalDialog label
      {
        font-size: 14px;
      }
      .modalDialog input, .modalDialog select
      {
        font-size: 14px;
        padding: 3px 10px;
        margin-bottom: 10px;
      }
      .modalDialog .end-buttons input
      {
        font-size: 14px;
        padding: 5px 15px;
      }

      .modalDialog > div {
        width: 400px;
        position: relative;
        margin: 5% auto;
        padding: 5px 20px 13px 20px;
        border-radius: 4px;
        background: #fff;
      }

      .close {
        background: #606061;
        color: #FFFFFF;
        line-height: 25px;
        position: absolute;
        right: -12px;
        text-align: center;
        top: -10px;
        width: 24px;
        text-decoration: none;
        font-weight: normal;
        -webkit-border-radius: 12px;
        -moz-border-radius: 12px;
        border-radius: 12px;
        -moz-box-shadow: 1px 1px 3px #000;
        -webkit-box-shadow: 1px 1px 3px #000;
        box-shadow: 1px 1px 3px #000;
      }

      .close:hover { background: #00d9ff; }

      .width
      {
        width: 1000px;
        margin: auto;
      }
    </style>

    <br>
    <h2>Set Up 2</h2>
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
          input[type='button']{font-size: 13px;}
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
                      <th></th>
                      </tr>
                      <tr ng-repeat = \" x in tools | orderBy:sortType \">
                      <td>
                          <input type = 'button' name = 'edit' ng-click = 'vis = !vis' ng-show = 'btn' class = 'link' value = 'Edit / View' />
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
                      <td>{{ vis }}</td>
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
      </div>
    </div>
    <div id="openModal" class="modalDialog" ng-show="vis">
      <div>
        <a title="Close" class="close" ng-click = 'vis = false'>x</a>
        <h2>Edit Tool</h2>
        <form name = "toolForm" action = "home.php"  onsubmit = "return validateForm()" method = "post">
          <input type = "hidden" name = "iid" value = '<?php echo $id; ?>'>
          <div><label for = "toolType">Tool Type</label></div>
          <select id = "toolType" name = "toolType" required autofocus>
              <option selected disabled hidden value = "">Select a Tool Type</option>
              <option id = "Endmill" value = "Endmill">Endmill</option>
              <option id = "Drill" value = "Drill">Drill</option>
              <option id = "Nachi Drill" value = "Nachi Drill">Nachi Drill</option>
              <option id = "Stub Drill" value = "Stub Drill">Stub Drill</option>
              <option id = "Reemer" value = "Reemer">Reemer</option>
              <option id = "Key Cutter" value = "Key Cutter">Key Cutter</option>
              <option id = "Spot Drill" value = "Spot Drill">Spot Drill</option>
              <option id = "Center Drill" value = "Center Drill">Center Drill</option>
              <option id = "Face Mill" value = "Face Mill">Face Mill</option>
              <option id = "Inserts" value = "Inserts">Inserts</option>
              <option id = "Dove Mill" value = "Dove Mill">Dove Mill</option>
              <option id = "Tap" value = "Tap">Tap</option>
              <option id = "Thread Mill" value = "Thread Mill">Thread Mill</option>
              <option id = "Other" value = "Other">Other</option>
          </select>
            <script>
              <?php //echo "document.getElementById('" . $toolType . "').selected = 'true';"; ?>
            </script>
            
          <div><label for = "diameter">Diameter</label></div>
          <input type = "number" step = ".001" name = "diameter" placeholder = "Diameter" value = '<?php //echo $diameter; ?>' required autocomplete = "off">
            
          <div><label for = "radius">Radius</label></div>
          <input type = "number" step = ".001" name = "radius" placeholder = "Corner Radius (optional)" value = '<?php //echo $radius; ?>' autocomplete = "off">
            
          <div><label for = "material">Material</label></div>
          <select id = "material" name = "material" required>
            <option selected disabled hidden value = "">Material and Coating</option>
            <option id = "Carbide" value = "Carbide">Carbide</option>
            <option id = "Coated Carbide" value = "Coated Carbide">Coated Carbide</option>
            <option id = "Cobalt" value = "Cobalt">Cobalt</option>
            <option id = "High Speed Steel" value = "High Speed Steel">High Speed Steel</option>
            <option id = "Other" value = "Other">Other</option>
          </select>
          <script>
            <?php //echo "document.getElementById('" . $material . "').selected = 'true';"; ?>
          </script>
            
          <div><label for = "flutes">Number of Flutes</label></div>
          <input type = "number" name = "flutes" placeholder = "Flutes" value = '<?php //echo $flutes; ?>' required autocomplete = "off">
            
          <div><label for = "length">Flute Length</label></div>
          <input type = "number" step = ".001" name = "length" placeholder = "Flute Length" value = '<?php //echo $length; ?>' required autocomplete = "off">
            
          <div><label for = "angle">EDP Number</label></div>
          <input type = "text" name = "angle" placeholder = "EDP Number (optional)" value = '<?php //echo htmlentities($angle); ?>' autocomplete = "off">
            
          <div><label for = "partNumber">Part Number</label></div>
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
            
          <div><label for = "operation">Operation</label></div>
          <input type = 'text' name = 'operation' placeholder = "Operation" value = '<?php echo htmlentities($operation); ?>'>
      
          <div><label for = "toolNumber">Tool Number</label></div>
          <input type = 'text' name = 'toolNumber' placeholder = "Tool Number on Setup" value = '<?php //echo htmlentities($toolNumber); ?>' autocomplete = "off">
      
          <div><label for = "notes">Notes</label></div>
          <input type = "text" name = "notes" placeholder = "Notes..." value = '<?php //echo htmlentities($notes); ?>'>
              
          <div class = "end-buttons">
              <input type = "submit" name = "submit" value = "Submit" id = 'toolEntry' ng-click = 'vis = false'>
              <input type = "reset" name = "reset" value = "Clear">
          </div>
        </form>   
      </div>
    </div><br>
    <input type = "button" ng-click = "vis = !vis" value = 'show / hide new tool form' id = "hide-button" /><br><br>
  </div>
</body>
</html>