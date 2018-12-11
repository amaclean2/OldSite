<?php
  if($_SESSION['username'] == '')
    header("location: login.php");

  $reg = @$_POST['submit'];
  $partNumber = $pn = "";
  $revision = $rev = "";
  $customer = $cus = "";
  $operation = $op = "";
  $toolbox = $tb = "";
  $fixture = $fix = "";
  $x_zero = $x0 = "";
  $y_zero = $y0 = "";
  $z_zero = $z0 = "";
  $a_zero = $a0 = "";
  $notes = $not = "";
  $date = "";
  $id = "";
  $machine = "";
  $sub = "Submit";

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
      $fixture = str_replace("string:", "", $fixture);
      $x_zero = strip_tags(@$_POST['x-0']);
      $y_zero = strip_tags(@$_POST['y-0']);
      $z_zero = strip_tags(@$_POST['z-0']);
      $a_zero = strip_tags(@$_POST['a-0']);
      $notes = strip_tags(@$_POST['fixture-desc']);
    }
    else if ($machine = '1')
    {
      $fixture = strip_tags(@$_POST['lFixture']);
      $fixture = str_replace("string:", "", $fixture);
      $x_zero = strip_tags(@$_POST['lx-0']);
      $z_zero = strip_tags(@$_POST['lz-0']);
      $notes = strip_tags(@$_POST['lathe-fixture']);
    }
    $id = strip_tags(@$_POST['iid']);
    $date = date("Y-m-d H:i:s");

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
        { partNumber: '" . $row[0] . "', revision: '" . $row[1] . "', customer: '" . $row[2] . "', operation: '" . $row[3] . "', toolbox: '" .
         $row[4] . "', id: '" . $row[5] . "' };";
      echo "data.push(newData);";
    }
  ?>

    var app = angular.module('sortApp', []);

    app.controller('mainController', function($scope) {
      $scope.currentPage = 0;
      $scope.pageSize = 30;
      $scope.sortType = 'partNumber';
      $scope.sortReverse = 'false';
      $scope.searchTools = '';
      $scope.parts = data;
      $scope.numberOfPages = function() {
        return Math.ceil($scope.parts.length/$scope.pageSize);
      }
      $scope.millFixtures = ["Select Work Holding", "Step Jaws", "Vertical Collet", "Horizontal Collet", "Pocket Jaws", "Fixture"];
      $scope.iMill = function() {
        <?php
          if ($fixture != '') {echo "return '" . $fixture . "';";}
          else {echo "return \$scope.millFixtures[0];";}
        ?>
      }
      $scope.latheFixtures = ["Select Work Holding", "Collet", "ID Collet", "Chuck Jaws", "ID Chuck", "Other"];
      $scope.iLathe = function() {
        <?php
          if($fixture != '') {echo "return '" . $fixture . "';";}
          else {echo "return \$scope.latheFixtures[0];";}
        ?>
      }
      
    });

    function show()
    {
      var rim = document.getElementById("reveal-if-mill");
      var ril = document.getElementById("reveal-if-lathe");
      if(document.getElementById("machine-mill").checked)
      {
        rim.style.overflow = "visible";
        rim.style.opacity = "1";
        rim.style.maxHeight = "500px";
        rim.style.paddingTop = "10px";
        document.getElementById("fixture-list").required = true;
        document.getElementById("x-0").required = true;
        document.getElementById("y-0").required = true;
        document.getElementById("z-0").required = true;
        document.getElementById("lFixtures").required = false;
        document.getElementById("lx-0").required = false;
        document.getElementById("lz-0").required = false;
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
        document.getElementById("fixture-list").required = false;
        document.getElementById("x-0").required = false;
        document.getElementById("y-0").required = false;
        document.getElementById("z-0").required = false;
        document.getElementById("lFixtures").required = true;
        document.getElementById("lx-0").required = true;
        document.getElementById("lz-0").required = true;
      }
      else
      {
        ril.style.overflow = "hidden";
        ril.style.maxHeight = "0";
        ril.style.opacity = "0";
        ril.style.paddingTop = "0";
      }
    }

</script>