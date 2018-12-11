<?php
  if($_SESSION['username'] == '')
      header("location: index.php");

    $reg = @$_POST['edit'];
    $ltoolType = "";
    $toolType = "";
    $description = "";
    $ins_code = "";
    $tooltype = "";
    $diameter = "";
    $radius = "";
    $material = "";
    $flutes = "";
    $length = "";
    $edp = "";
    $notes = "";
    $quantity = "";
    $sub = "Enter";
    $machine = "";
    $operation = "";
    $partNumber = "";
    $urgent = "";

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

    $date = date("Y-m-d H:i:s");
    $mid = strip_tags(@$_POST['id']);
    $machine = strip_tags(@$_POST['machine']);

    $message = "Purchase History";

    if($reg)
    {
      $partNumber = strip_tags(@$_POST['partNumber']);
      $operation = strip_tags(@$_POST['operation']);
      $quantity = strip_tags(@$_POST['quantity']);
      $notes = strip_tags(@$_POST['notes']);
      $urgent = strip_tags(@$_POST['urgent']);
      $id = strip_tags(@$_POST['id']);

      if($machine == 'mill')
      {
        $tooltype = strip_tags(@$_POST['toolType']);
        $diameter = strip_tags(@$_POST['diameter']);
        $material = strip_tags(@$_POST['material']);
        $edp = strip_tags(@$_POST['edp']);

        if($urgent == 'ch')
          $seen = '-1';

        if($id == '')
        {
          $query = mysqli_query($link, "INSERT INTO requests
            (type, diameter, material, edp, quantity, part_number, seen, operation, notes, dateadded)
            VALUES ('$tooltype', '$diameter', '$material', '$edp', '$quantity', '$partNumber', '$seen', '$operation', '$notes', '$date')");
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
        $description = strip_tags(@$_POST['description']);
        $ins_code = strip_tags(@$_POST['ins-code']);

        if($urgent == 'ch')
          $seen = '-1';

        if($id == '')
        {
          $query = mysqli_query($link, "INSERT INTO lrequests
            (type, description, insert_code, notes, lquantity, part_number, seen, operation, dateadded)
            VALUES ('$ltoolType', '$description', '$ins_code', '$notes', '$lquantity', '$partNumber', '$seen' , '$operation', '$date')");
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
        $description = strip_tags(@$_POST['otherDescription']);

        if($urgent == 'ch')
          $seen = '-1';

        if($id == '')
        {
          $query = mysqli_query($link, "INSERT INTO orequests
            (description, notes, quantity, part_number, seen, operation, dateadded)
            VALUES ('$description', '$notes', '$quantity', '$partNumber', '$seen' , '$operation', '$date')");
        }
        else
        {
          $query = mysqli_query($link, "DELETE FROM orequests WHERE id = '$id'");
          $query = mysqli_query($link, "INSERT INTO orequests
            (id, description, notes, quantity, part_number, seen, operation, dateadded)
            VALUES ('$id', '$description', '$notes', '$quantity', '$partNumber', '$seen', '$operation', '$date')");
        }
      }
      header("location: purchased.php");
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

    if(isset($_POST['edd']))
    {
      $sub = "Enter Changes / Close";
      $id = $_POST['id'];
      $machine = $_POST['machine'];
      if($machine == 'mill')
      {
        $data = mysqli_query($link, "SELECT type, diameter, material, edp, quantity, part_number, operation, notes, dateadded 
          FROM requests WHERE id = '$id'");
        while( $row = mysqli_fetch_array($data, MYSQL_NUM))
        {
          $toolType = $row[0];
          $tt = "Tool Type";
          $diameter = $row[1];
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

          echo "<style>.field, .sf-field{max-height: 62px;} .hidden-label, .hidden-sf-label{overflow: visible; opacity: 1;}</style>";
        }
      }
      else if ($machine == 'lathe')
      {
        $data2 = mysqli_query($link, "SELECT type, description, insert_code, notes, lquantity, part_number, operation 
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

          echo "<style>.field, .sf-field{max-height: 62px;} .hidden-label, .hidden-sf-label{overflow: visible; opacity: 1;}</style>";
        }
      }
      else if ($machine == 'other')
      {
        $data2 = mysqli_query($link, "SELECT description, notes, quantity, part_number, operation FROM orequests WHERE id = '$id'");
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

          echo "<style>.field, .sf-field{max-height: 62px;} .hidden-label, .hidden-sf-label{overflow: visible; opacity: 1;}</style>";
        }
      }
    }

?>

    <script>
    data = [];
    <?php
      $data = mysqli_query($link, "SELECT id, dateadded, type, diameter, material, edp, notes, quantity, seen, part_number FROM requests WHERE bought = '0'");
      while( $row = mysqli_fetch_array($data, MYSQL_NUM))
      {
        $date = date_create($row[1]);
        $date = date_format($date,"m/d/Y");

        echo "var newData =
          { id: '" . $row[0] . "', date: '" . $date . "', type: '" . $row[2] . "', diameter: '" . $row[3] . "', material: '" . $row[4] . "', 
          edp: '" . $row[5] . "', notes: '" . $row[6] . "', quantity: '" . $row[7] . "', seen: '" . $color . "', markValue: '" . $markValue . "', orderLevel: '" . $category . "', markText: '" . $markText .
           "', partNumber: '" . $row[9] . "' };";
        echo "data.push(newData);";
      }
    ?>

      angular.module('sortApp', [])

      .controller('mainController', function($scope) {
        $scope.currentPage = 0;
        $scope.pageSize = 10;
        $scope.sortType = 'seen';
        $scope.sortReverse = 'false';
        $scope.searchTools = '';
        $scope.tools = data;
        $scope.numberOfPages = function() {
          return Math.ceil($scope.tools.length/$scope.pageSize);
        }
      });
    </script>
