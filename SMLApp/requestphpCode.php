<?php
  if($_SESSION['username'] == '')
      header("location: login.php");
    
    $reg = @$_POST['submit'];
    $ltoolType = "";
    $toolType = "";
    $description = "";
    $ins_code = "";
    $tooltype = "";
    $diameter = "";
    $material = "";
    $edp = "";
    $notes = "";
    $quantity = "";
    $sub = "Enter";
    $machine = "";
    $operation = "";
    $partNumber = "";
    $urgent = "";
    $bought = "";
    $visible = 'vis = true';

    $tt = "";
    $dia = "";
    $mat = "";
    $edpText = "";
    $quan = "";
    $pn = "";
    $op = "";
    $not = "";
    $des = "";
    $ins = "";
    $cblabel = "";

    $seen = strip_tags(@$_POST['seen']);
    $date = date("Y-m-d");
    $id = strip_tags(@$_POST['id']);
    $machine = strip_tags(@$_POST['machine']);

    $message = "Shopping Requests";

    function email($link)
    {
      $emails = array();
      $data = mysqli_query($link, "SELECT email FROM users WHERE reqNot = '1'");
      while($row = mysqli_fetch_array($data, MYSQL_NUM))
      {
        array_push($emails, $row[0]);
      }
      if ($_SESSION['email'] == 'false')
      {
        $msg = "There is a tool request to look at in the website. Can you look at it and select \"marked as seen\" once you have read the update?\n
          The website is still being tested so it is probably best to check with a machinist to see if the update is accurate.\n\n
          Check out smltoolsdb.com/request.php to look at the update.\n -Andrew Maclean";
        $to = $emails[0];
        if(count($emails) > 1)
        {
          for($i = 1; $i < count($emails); $i++)
            $to .= ", " . $emails[$i];
        }
        $headers = "From: jabberwocky";
        $sent = mail($to, "Tool Request", $msg, $headers);
        if($sent)
          $message = "A message was sent!";
        else
          $message = "Something went wrong.";
        $_SESSION['email'] = 'true';
      }
    }

    if($reg)
    {
      $partNumber = strip_tags(@$_POST['partNumber']);
      $operation = strip_tags(@$_POST['operation']);
      $quantity = strip_tags(@$_POST['quantity']);
      $notes = strip_tags(@$_POST['notes']);
      $urgent = strip_tags(@$_POST['urgent']);
      $id = strip_tags(@$_POST['id']);
      $bought = strip_tags(@$_POST['bought']);

      if($machine == 'mill')
      {
        $tooltype = strip_tags(@$_POST['toolType']);
        $tooltype = str_replace("string:", "", $tooltype);
        $diameter = strip_tags(@$_POST['diameter']);
        $material = strip_tags(@$_POST['material']);
        $material = str_replace("string:", "", $material);
        $edp = strip_tags(@$_POST['edp']);

        if($urgent == 'ch')
          $seen = '-1';

        if($id == '' || $bought != '0')
        {
          $query = mysqli_query($link, "INSERT INTO requests
            (type, diameter, material, edp, quantity, part_number, seen, operation, notes, dateadded, bought)
            VALUES ('$tooltype', '$diameter', '$material', '$edp', '$quantity', '$partNumber', '$seen', '$operation', '$notes', '$date', '0')");

          email($link);
        }
        else
        {
          $query = mysqli_query($link, "DELETE FROM requests WHERE id = '$id'");
          $query = mysqli_query($link, "INSERT INTO requests
            (id, type, diameter, material, edp, quantity, part_number, seen, operation, notes, dateadded)
            VALUES ('$id', '$tooltype', '$diameter', '$material', '$edp', '$quantity', '$partNumber', '$seen', '$operation', '$notes', '$date')");
        }
      }
      else if ($machine == 'lathe')
      {
        $ltoolType = strip_tags(@$_POST['ltoolType']);
        $ltoolType = str_replace("string:", "", $ltoolType);
        $description = strip_tags(@$_POST['ldescription']);
        $ins_code = strip_tags(@$_POST['ins-code']);

        if($urgent == 'ch')
          $seen = '-1';

        if($id == '' || $bought != '0')
        {
          $query = mysqli_query($link, "INSERT INTO lrequests
            (type, description, insert_code, notes, lquantity, part_number, seen, operation, dateadded, bought)
            VALUES ('$ltoolType', '$description', '$ins_code', '$notes', '$quantity', '$partNumber', '$seen' , '$operation', '$date', '0')");

          email($link);
        }
        else
        {
          $query = mysqli_query($link, "DELETE FROM lrequests WHERE id = '$id'");
          $query = mysqli_query($link, "INSERT INTO lrequests
            (id, type, description, insert_code, notes, lquantity, part_number, seen, operation, dateadded)
            VALUES ('$id', '$ltoolType', '$description', '$ins_code', '$notes', '$quantity', '$partNumber', '$seen', '$operation', '$date')");
        }
      }

      else if ($machine == 'other')
      {
        $description = strip_tags(@$_POST['odescription']);

        if($urgent == 'ch')
          $seen = '-1';

        if($id == '' || $bought != '0')
        {
          $query = mysqli_query($link, "INSERT INTO orequests
            (description, notes, quantity, part_number, seen, operation, dateadded, bought)
            VALUES ('$description', '$notes', '$quantity', '$partNumber', '$seen' , '$operation', '$date', '0')");

          email($link);
        }
        else
        {
          $query = mysqli_query($link, "DELETE FROM orequests WHERE id = '$id'");
          $query = mysqli_query($link, "INSERT INTO orequests
            (id, description, notes, quantity, part_number, seen, operation, dateadded)
            VALUES ('$id', '$description', '$notes', '$quantity', '$partNumber', '$seen', '$operation', '$date')");
        }
      }
      header("location: request.php");
    }

    if(isset($_POST['marked']))
    {
      $seen = $_POST['seen'];
      $id = $_POST['ed'];
      $machine = $_POST['machine'];
      if($machine == '0')
        $data = mysqli_query($link, "UPDATE requests SET seen = '$seen' WHERE id = '$id'");
      else if ($machine == '1')
        $data = mysqli_query($link, "UPDATE lrequests SET seen = '$seen' WHERE id = '$id'");
      else if ($machine == '2')
        $data = mysqli_query($link, "UPDATE orequests SET seen = '$seen' WHERE id = '$id'");
    }

    if(isset($_POST['delete']))
    {
      $id = $_POST['ed'];
      $data = mysqli_query($link, "DELETE FROM requests WHERE id = '$id'");
    }
    else if(isset($_POST['ldelete']))
    {
      $id = $_POST['ed'];
      $data = mysqli_query($link, "DELETE FROM lrequests WHERE id = '$id'");
    }
    else if(isset($_POST['odelete']))
    {
      $id = $_POST['ed'];
      $data = mysqli_query($link, "DELETE FROM orequests WHERE id = '$id'");
    }

    if(isset($_POST['edd']) || isset($_POST['order']))
    {
      $visible = 'vis = true';
      $sub = "Enter Changes / Close";
      $id = $_POST['id'];
      $machine = $_POST['machine'];
      if($machine == 'mill-h')
      {
        $data = mysqli_query($link, "SELECT type, diameter, radius, material, flutes, length, angle, notes, part_number, operation FROM tools WHERE id = '$id'");
        while( $row = mysqli_fetch_array($data, MYSQL_NUM))
        {
          $toolType = $row[0];
          $tt = "Tool Type";
          $diameter = number_format($row[1], 3);
          $dia = "Diameter";
          $material = $row[3];
          $mat = "Material and Coating";
          $edp = $row[6];
          $edpText = "EDP Number";
          $quantity = "";
          $quan = "Quantity";
          $partNumber = $row[8];
          $pn = "Part Number";
          $operation = $row[9];
          $op = "Operation";
          $notes = "";
          if($row[2] != '0')
            $notes .= "Corner Radius: " . number_format($row[2], 3) . "\", ";
          if($row[4] != '0')
            $notes .= $row[4] . " flutes, ";
          if($row[5] != '0')
            $notes .= "Flute length: " . number_format($row[5], 3) . "\", ";
          if($row[7] != '')
            $notes .= "Notes: " . $row[7] . "\", ";
          $not = "Notes";
          $cblabel = "Urgent";
          $bought = $row[8];
        }
      }
      if($machine == 'mill')
      {
        $data = mysqli_query($link, "SELECT type, diameter, material, edp, quantity, part_number, operation, notes, bought
          FROM requests WHERE id = '$id'");
        while( $row = mysqli_fetch_array($data, MYSQL_NUM))
        {
          $toolType = $row[0];
          $tt = "Tool Type";
          $diameter = number_format($row[1], 3);
          $dia = "Diameter";
          $material = $row[2];
          $mat = "Material and Coating";
          $edp = $row[3];
          $edpText = "EDP Number";
          $quantity = $row[4];
          $quan = "Quantity";
          $partNumber = $row[5];
          $pn = "Part Number";
          $operation = $row[6];
          $op = "Operation";
          $notes = $row[7];
          $not = "Notes";
          $cblabel = "Urgent";
          $bought = $row[8];
        }
      }
      else if ($machine == 'lathe')
      {
        $data2 = mysqli_query($link, "SELECT type, description, insert_code, notes, lquantity, part_number, operation, bought
          FROM lrequests WHERE id = '$id'");
        while ($row = mysqli_fetch_array($data2, MYSQL_NUM))
        {
          $toolType = $row[0];
          $tt = "Tool Type";
          $description = $row[1];
          $des = "Description";
          $ins_code = $row[2];
          $ins = "Insert Code";
          $notes = $row[3];
          $not = "Notes";
          $quantity = $row[4];
          $quan = "Quantity";
          $partNumber = $row[5];
          $pn = "Part Number";
          $operation = $row[6];
          $op = "Operation";
          $bought = $row[7];
        }
      }
      else if ($machine == 'other')
      {
        $data2 = mysqli_query($link, "SELECT description, notes, quantity, part_number, operation, bought FROM orequests WHERE id = '$id'");
        while ($row = mysqli_fetch_array($data2, MYSQL_NUM))
        {
          $description = $row[0];
          $des = "Description";
          $notes = $row[1];
          $not = "Notes";
          $quantity = $row[2];
          $quan = "Quantity";
          $partNumber = $row[3];
          $pn = "Part Number";
          $operation = $row[4];
          $op = "Operation";
          $bought = $row[5];
        }
      }
      echo "<style>
      .field select, .field input[type='text'], .field input[type='number']{position: relative; display: inline-block;} .hidden-label{overflow: visible; opacity: 1;display: inline-block; height: 15px;}
      </style>";
    }

?>

<script>
    data = [];
    ldata = [];
    odata = [];
    <?php
      $data = mysqli_query($link, "SELECT id, dateadded, type, diameter, material, edp, notes, quantity, seen, part_number FROM requests WHERE bought = '0'");
      while( $row = mysqli_fetch_array($data, MYSQL_NUM))
      {
        $color = $row[8];
        if ($color  == '2')
        {
          $color = '#487d84';
          $markText = 'Unmark';
          $markValue = '0';
          $category = 'Ordered';
        }
        else if($color == '1')
        {
          $color = '#66ff66';
          $markText = 'Mark as Ordered';
          $markValue = '2';
          $category = '';
        }
        else if ($color == '0')
        {
          $color = '#66ff66';
          $markText = 'Mark as Ordered';
          $markValue = '2';
          $category = '';
        }
        else if ($color == '-1' || $color == '3')
        {
          $color = '#ff3333';
          $markText = 'Mark as Ordered';
          $markValue = '2';
          $category = 'Urgent';
        }

        echo "var newData =
          { id: '" . $row[0] . "', date: '" . $row[1] . "', type: '" . $row[2] . "', diameter: '" . $row[3] . "', material: '" . $row[4] . "', 
          edp: '" . $row[5] . "', notes: '" . $row[6] . "', quantity: '" . $row[7] . "', seen: '" . $color . "', markValue: '" . $markValue . "', orderLevel: '" . $category . "', markText: '" . $markText .
           "', partNumber: '" . $row[9] . "' };";
        echo "data.push(newData);";
      }

      $data3 = mysqli_query($link, "SELECT id, dateadded, description, notes, quantity, seen, part_number FROM orequests WHERE bought = '0'");
      while( $row = mysqli_fetch_array($data3, MYSQL_NUM))
      {

        $color = $row[5];
        if ($color  == '2')
        {
          $color = '#487d84';
          $markText = 'Unmark';
          $markValue = '0';
          $category = 'Ordered';
        }
        else if ($color == '0')
        {
          $color = '#66ff66';
          $markText = 'Mark as Ordered';
          $markValue = '2';
          $category = '';
        }
        else if ($color == '-1' || $color == '3')
        {
          $color = '#ff3333';
          $markText = 'Mark as Ordered';
          $markValue = '2';
          $category = 'Urgent';
        }
        echo "var newData = 
          { id: '" . $row[0] . "', date: '" . $row[1] . "', description: '" . $row[2] . "', notes: '" . $row[3] . "', quantity: '" . $row[4] . "', seen: '" . $color . "', markValue: '" . $markValue .
           "', orderLevel: '" . $category . "', markText: '" . $markText . "', partNumber: '" . $row[6] . "' };";
        echo "odata.push(newData);";
      }

      $data2 = mysqli_query($link, "SELECT id, type, description, insert_code, notes, lquantity, seen, part_number, operation, dateadded FROM lrequests WHERE bought = '0'");
      while( $row = mysqli_fetch_array($data2, MYSQL_NUM))
      {
        $color = $row[6];
        if ($color  == '2')
        {
          $color = '#487d84';
          $markText = 'Unmark';
          $markValue = '0';
          $category = 'Ordered';
        }
        else if($color == '1')
        {
          $color = '#66ff66';
          $markText = 'Mark as Ordered';
          $markValue = '2';
          $category = 'Seen';
        }
        else if ($color == '0')
        {
          $color = '#66ff66';
          $markText = 'Mark as Ordered';
          $markValue = '2';
          $category = '';
        }
        else if ($color == '-1' || $color == '3')
        {
          $color = '#ff3333';
          $markText = 'Mark as Ordered';
          $markValue = '2';
          $category = 'Urgent';
        }
        echo "var newLData =
          { id: '" . $row[0] . "', date: '" . $row[9] . "', type: '" . $row[1] . "', description: '" . $row[2] . "', insCode: '" . 
          $row[3] . "', notes: '" . $row[4] . "', latheQuantity: '" . $row[5] . "', seen: '" . $color . "', markValue: '" . $markValue . "', orderLevel: '" . $category . "', markText: '" . $markText .
           "', partNumber: '" . $row[7] . "', operation: '" . $row[8] . "' };";
        echo "ldata.push(newLData);";
      }
    ?>

      angular.module('sortApp', [])

      .controller('mainController', function($scope) {
        $scope.currentPage = 0;
        $scope.lcurrentPage = 0;
        $scope.ocurrentPage = 0;
        $scope.pageSize = 10;
        $scope.sortType = 'date';
        $scope.sortReverse = 'false';
        $scope.searchTools = '';
        $scope.tools = data;
        $scope.ltools = ldata;
        $scope.otools = odata;
        $scope.numberOfPages = function() {
          return Math.ceil($scope.tools.length/$scope.pageSize);
        }
        $scope.lnumberOfPages = function() {
          return Math.ceil($scope.ltools.length/$scope.pageSize);
        }
        $scope.onumberOfPages = function() {
          return Math.ceil($scope.otools.length/$scope.pageSize);
        }
        $scope.toolOptions =
          ["Select a Tool Type", "Endmill", "Drill", "Nachi Drill", "Stub Drill", "Reemer", "Key Cutter", "Spot Drill", "Center Drill", "Face Mill", "Inserts", "Dove Mill", "Tap", "Thread Mill", "Other"];
        $scope.matOptions = 
          ["Material and Coating" , "Carbide", "Coated Carbide", "Cobalt", "High Speed Steel", "Other"];
        $scope.iTool = function() {
          <?php
            if ($toolType != '') {echo "return '" . $toolType . "';";}
            else {echo "return \$scope.toolOptions[0];";}
          ?>
        }
        $scope.iMat = function() {
          <?php
            if ($material != '') {echo "return '" . $material . "';";}
            else {echo "return \$scope.matOptions[0];";}
          ?>
        }

        $scope.lToolOptions = ["Select a Tool Type", "Boring Bar", "Insert", "Drill", "Center Drill", "OD Tool", "Cutoff Tool", "Groove Tool", "Other"];
        $scope.lTool = function() {
          <?php
            if ($toolType != '') {echo "return '" . $toolType . "';";}
            else {echo "return \$scope.lToolOptions[0];";}
          ?>
        }
      });
    </script>