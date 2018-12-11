<?php
  if($_SESSION['username'] == '')
    header("location: login.php");

  $reg = @$_POST['submit'];
  $toolNumber = $tn = "";
  $tooltype = $tt = "";
  $diameter = $dia = "";
  $radius = $rad = "";
  $material = $mat = "";
  $flutes = $flu = "";
  $length = $len = "";
  $angle = $edp = "";
  $partNumber = $pn = "";
  $operation = $op = "";
  $notes = $not = "";
  $date = "";
  $id = "";
  $for = "";
  $sub = "Enter";
  $partNumber = strip_tags(@$_POST['partNumber']);
  $operation = strip_tags(@$_POST['operation']);
  $for = strip_tags(@$_POST['for']);

  if($reg)
  {
    $toolNumber = strip_tags(@$_POST['toolNumber']);
    $tooltype = strip_tags(@$_POST['toolType']);
    $tooltype = str_replace("string:", "", $tooltype);
    $diameter = strip_tags(@$_POST['diameter']);
    $radius = strip_tags(@$_POST['radius']);
    $material = strip_tags(@$_POST['material']);
    $material =str_replace("string:", "", $material);
    $flutes = strip_tags(@$_POST['flutes']);
    $length = strip_tags(@$_POST['length']);
    $angle = strip_tags(@$_POST['angle']);
    $notes = strip_tags(@$_POST['notes']);
    $date = date("Y-m-d H:i:s");
    $id = strip_tags($_POST['iid']);

    if ($id == '')
    {
      //angle was a data entry that I changed to EDP Number. Everything that says angle, is really EDP
      $query = mysqli_query($link, "INSERT INTO tools
      (tool_number, type, diameter, radius, material, flutes, length, angle, part_number, operation, notes, dateadded)
      VALUES ('$toolNumber', '$tooltype', '$diameter', '$radius', '$material', '$flutes', '$length', '$angle', '$partNumber', '$operation', '$notes', '$date')");
      if($for != '')
        header("location: setupsheet.php?id=" . $for . "&setup=Setup+Sheet");
      else
        header("location: home.php");
    }
    else
    {
      //for is an old method to insert into inventory when a tool is purchased
      //currently using for to edit a tool from a setup sheet
      /*if($for == 'r')
      {
        $data = mysqli_query($link, "DELETE FROM requests WHERE id = '$id'");
        //angle was a data entry that I changed to EDP Number. Everything that says angle, is really EDP
        $query = mysqli_query($link, "INSERT INTO tools
          (tool_number, type, diameter, radius, material, flutes, length, angle, part_number, operation, notes, dateadded)
          VALUES ('$toolNumber', '$tooltype', '$diameter', '$radius', '$material', '$flutes', '$length', '$angle', '$partNumber', '$operation', '$notes', '$date')");
      }*/

      $data = mysqli_query($link, "DELETE FROM tools WHERE id = '$id'");
      //angle was a data entry that I changed to EDP Number. Everything that says angle, is really EDP
      $query = mysqli_query($link, "INSERT INTO tools
        (id, tool_number, type, diameter, radius, material, flutes, length, angle, part_number, operation, notes, dateadded)
        VALUES ('$id', '$toolNumber', '$tooltype', '$diameter', '$radius', '$material', '$flutes', '$length', '$angle', '$partNumber', '$operation', '$notes', '$date')");
      if($for != '')
        header("location: setupsheet.php?id=" . $for . "&setup=Setup+Sheet");
      else
        header("location: home.php");
    }
  }

  if(isset($_POST['delete']))
  {
    $id = $_POST['id'];
    $data = mysqli_query($link, "DELETE FROM tools WHERE id = '$id'");
    header("location: home.php");
  }

  if(isset($_POST['edit']))
  {
    $sub = "Enter Changes / Close";
    $id = $_POST['ed'];

    $data = mysqli_query($link, "SELECT tool_number, type, diameter, radius, material, flutes, length, angle, part_number, operation, notes
    FROM tools WHERE id = '$id'");
    while( $row = mysqli_fetch_array($data, MYSQL_NUM))
    {
      $toolNumber = $row[0];
      $tn = "Tool Number";
      $tooltype = $row[1];
      $tt = "Tool Type";
      $diameter = $row[2];
      $dia = "Diameter";
      $radius = $row[3];
      $rad = "Corner Radius";
      $material = $row[4];
      $mat = "Material: ";
      $flutes = $row[5];
      $flu = "Flutes";
      $length = $row[6];
      $len = "Flute Length";
      $angle = $row[7];
      $edp = "EDP Number";
      $partNumber = $row[8];
      $pn = "Part Number";
      $operation = $row[9];
      $op = "Operation";
      $notes = $row[10];
      $not = "Notes";
    }
    echo "<style>
      .field select, .field input[type='text'], .field input[type='number']{position: relative; display: inline-block;} .hidden-label{overflow: visible; opacity: 1;display: inline-block; height: 15px;}
      </style>";
  }

?>

<script>
    data = [];
    <?php
      $data = mysqli_query($link, "SELECT id, type, diameter, radius, material, flutes, length, angle, part_number FROM tools");
      while( $row = mysqli_fetch_array($data, MYSQL_NUM))
      {
        echo "var newData =
          { id: '" . $row[0] . "', type: '" . $row[1] . "', diameter: '" . $row[2] . "', radius: '" . $row[3] . "', material: '" . $row[4] . "', flutes: '" .
           $row[5] . "', length: '" . $row[6] . "', angle: '" . $row[7] . "', partNumber: '" . $row[8] . "' };";
        echo "data.push(newData);";
      }
    ?>

      var app = angular.module('sortApp', []);

      app.controller('mainController', function($scope) {
        $scope.currentPage = 0;
        $scope.pageSize = 30;
        $scope.tools = data;
        $scope.numberOfPages = function() {
          return Math.ceil($scope.tools.length/$scope.pageSize);
        }
        $scope.sortType = 'id';
        $scope.sortReverse = 'false';
        $scope.searchTools = '';
        $scope.toolOptions =
          ["Select a Tool Type", "Endmill", "Drill", "Nachi Drill", "Stub Drill", "Reemer", "Key Cutter", "Spot Drill", "Center Drill", "Face Mill", "Inserts", "Dove Mill", "Tap", "Thread Mill", "Other"];
        $scope.matOptions = 
          ["Material and Coating" , "Carbide", "Coated Carbide", "Cobalt", "High Speed Steel", "Other"];
        $scope.iTool = function() {
          <?php
            if ($tooltype != '') {echo "return '" . $tooltype . "';";}
            else {echo "return \$scope.toolOptions[0];";}
          ?>
        }
        $scope.iMat = function() {
          <?php
            if ($material != '') {echo "return '" . $material . "';";}
            else {echo "return \$scope.matOptions[0];";}
          ?>
        }
      });
</script>