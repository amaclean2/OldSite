<?php
  if($_SESSION['username'] == '')
    header("location: login.php");

  $reg = @$_POST['submit'];
  $partNumber = $pn = "";
  $revision = $rev = "";
  $customer = $cus = "";
  $operation = $op = "";
  $toolbox = $tb = "";
  $notes = $not = "";
  $date = "";
  $id = "";
  $machine = "";
  $due = "";
  $sub = "Add a New Part";

  if($reg)
  {
    $machine = strip_tags(@$_POST['machine']);
    $partNumber = strip_tags(@$_POST['partNumber']);
    $revision = strip_tags(@$_POST['revision']);
    $customer = strip_tags(@$_POST['customer']);
    $operation = strip_tags(@$_POST['operation']);
    $toolbox = strip_tags(@$_POST['toolbox']);

    if($machine == '0')
    {
      $fixture = strip_tags(@$_POST['fixture']);
      $x_zero = strip_tags(@$_POST['x-0']);
      $y_zero = strip_tags(@$_POST['y-0']);
      $z_zero = strip_tags(@$_POST['z-0']);
      $a_zero = strip_tags(@$_POST['a-0']);
      $notes = strip_tags(@$_POST['fixture-desc']);
    }
    else if ($machine = '1')
    {
      $fixture = strip_tags(@$_POST['lFixture']);
      $x_zero = strip_tags(@$_POST['lx-0']);
      $z_zero = strip_tags(@$_POST['lz-0']);
      $notes = strip_tags(@$_POST['lathe-fixture']);
    }
    $id = strip_tags(@$_POST['iid']);
    $date = date("Y-m-d");

    if ($id == '')
    {
      $query = mysqli_query($link, "INSERT INTO parts
        (part_number, revision, customer, operation, toolbox, dateadded)
        VALUES ('$partNumber', '$revision', '$customer', '$operation', '$toolbox', '$date')");
      if($machine == '0')
      {
        $query2 = mysqli_query($link, "INSERT INTO parts (machine) VALUES ('0')");
        $query2 = mysqli_query($link, "INSERT INTO fixtures
          (part_number, operation, fixture, x_zero, y_zero, z_zero, a_zero, mill, notes)
          VALUES ('$partNumber', '$operation', '$fixture', '$x_zero', '$y_zero', '$z_zero', '$a_zero', '0', '$notes')");
      }
      else if ($machine == '1')
      {
        $query2 = mysqli_query($link, "INSERT INTO parts (machine) VALUES ('1')");
        $query2 = mysqli_query($link, "INSERT INTO fixtures
          (part_number, operation, fixture, x_zero, z_zero, mill, notes)
          VALUES ('$partNumber', '$operation', '$fixture', '$x_zero', '$z_zero', '1', '$notes')");
      }
    }
    else
    {
      $query = mysqli_query($link, "DELETE FROM parts WHERE id = '$id'");
      $query = mysqli_query($link, "DELETE FROM fixtures WHERE id = '$id'");

      $query = mysqli_query($link, "INSERT INTO parts
        (id, part_number, revision, customer, operation, toolbox, dateadded)
        VALUES ('$id', '$partNumber', '$revision', '$customer', '$operation', '$toolbox', '$date')");
      if($machine == '0')
      {
        $query2 = mysqli_query($link, "INSERT INTO fixtures
          (id, part_number, operation, fixture, x_zero, y_zero, z_zero, a_zero, mill, notes)
          VALUES ('$id', '$partNumber', '$operation', '$fixture', '$x_zero', '$y_zero', '$z_zero', '$a_zero', '0', '$notes')");
      }
      else if($machine == '1')
      {
        $query2 = mysqli_query($link, "INSERT INTO fixtures
          (id, part_number, operation, fixture, x_zero, z_zero, mill, notes)
          VALUES ('$id', '$partNumber', '$operation', '$fixture', '$x_zero', '$z_zero', '1', '$notes')");
      }
    }
    header ("location: parts.php");
  }

  if(isset($_POST['delete']))
  {
    $id = $_POST['id'];
    $data = mysqli_query($link, "DELETE FROM parts WHERE id = '$id'");
    $data2 = mysqli_query($link, "DELETE FROM fixtures WHERE id = '$id'");
    header("location: parts.php");
  }

  if(isset($_POST['edit']))
  {
    $sub = "Enter Changes / Close";
    $id = $_POST['id'];
    $data = mysqli_query($link, "SELECT part_number, revision, customer, operation, toolbox 
      FROM parts WHERE id = '$id'");
    while( $row = mysqli_fetch_array($data, MYSQL_NUM))
    {
      $partNumber = $row[0];
      $pn = "Part Number";
      $revision = $row[1];
      $rev = "Revision";
      $customer = $row[2];
      $cus = "Customer";
      $operation = $row[3];
      $op = "Operation";
      $toolbox = $row[4];
      $tb = "Toolbox";
      echo "<style>
      .field select, .field input[type='text'], .field input[type='number']{position: relative; display: inline-block;} .hidden-label{overflow: visible; opacity: 1;display: inline-block; height: 15px;}
      </style>";
    }
    $data2 = mysqli_query($link, "SELECT mill FROM fixtures WHERE id = '$id'");
    while ($row = mysqli_fetch_array($data2, MYSQL_NUM))
    {
      $machine = $row[0];
    }
    if ($machine == '0')
    {
      $data2 = mysqli_query($link, "SELECT fixture, x_zero, y_zero, z_zero, a_zero, notes 
        FROM fixtures WHERE id = '$id'");
      while ($row = mysqli_fetch_array($data2, MYSQL_NUM))
      {
        $fixture = $row[0];
        $fix = "Work Holding";
        $x_zero = $row[1];
        $x0 = "X Zero";
        $y_zero = $row[2];  
        $y0 = "Y Zero";
        $z_zero = $row[3];
        $z0 = "Z Zero";
        $a_zero = $row[4];
        $a0 = "A Zero";
        $notes = $row[5];
        $not = "Description";

      }
    }
    else if ($machine == '1')
    {
      $data2 = mysqli_query($link, "SELECT fixture, x_zero, z_zero, notes 
        FROM fixtures WHERE id = '$id'");
      while ($row = mysqli_fetch_array($data2, MYSQL_NUM))
      {
        $fixture = $row[0];
        $fix = "Work Holding";
        $x_zero = $row[1];
        $x0 = "X Zero";
        $z_zero = $row[2];
        $z0 = "Z Zero";
        $notes = $row[3];
        $not = "Description";

      }
    }
  }
?>

<script>
data = [];
<?php
  $data = mysqli_query($link, "SELECT part_number, revision, customer, operation, toolbox, id FROM parts");
  while( $row = mysqli_fetch_array($data, MYSQL_NUM))
  {
    echo "var newData =
      { partNumber: '" . $row[0] . "', revision: '" . $row[1] . "', customer: '" . $row[2] . "', operation: '" . $row[3] . "', dueDate: '" .
       date("2016-12-10") . "', id: '" . $row[5] . "' };";
    echo "data.push(newData);";
  }
?>

  var app = angular.module('sortApp', ['ui.sortable']);

  app.controller('mainController', function($scope) {
    $scope.twoWeeks = new Date();
    $scope.twoWeeks.setDate($scope.twoWeeks.getDate() + 14);
    $scope.twoWeeks = $scope.twoWeeks.toISOString().slice(0, 10);
    $scope.colors = ['#fc3535'];
    $scope.colors2 = ['#f94316'];
    $scope.currentPage = 0;
    $scope.pageSize = 30;
    $scope.searchTools = '';
    $scope.parts = data;
    $scope.numberOfPages = function() {
      return Math.ceil($scope.parts.length/$scope.pageSize);
    }
    
  });
</script>