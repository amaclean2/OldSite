<?php
if($_SESSION['username'] == '')
    header("location: login.php");

$reg = @$_POST['submit'];
$poNum = "";
$description = "";
$notes = "";
$quantity = "";
$sub = "Enter";
$machine = "";
$operation = "";
$partNumber = "";
$urgent = "";
$cost = "";
$source = "";
$visible = 'vis = true';
$machine = "";
$edited = "";

$quan = "";
$pn = "";
$op = "";
$not = "";
$des = "";
$pur = "";
$sourceText = "";
$costText = "";

$date = date('Y-m-d');
$mid = strip_tags(@$_POST['ed']);

$message = "Purchases";
$data = mysqli_query($link, "SELECT id FROM purchases ORDER BY id DESC LIMIT 0, 1");
while( $row = mysqli_fetch_array($data, MYSQL_NUM))
  $sparePo = $row[0] + 1;

if($reg)
{
  $ids = array();
  $data = mysqli_query($link, "SELECT id FROM requests WHERE bought = '0'");
  while($row = mysqli_fetch_array($data, MYSQL_NUM))
    array_push($ids, $row[0]);
  $data = mysqli_query($link, "SELECT id FROM lrequests WHERE bought = '0'");
  while($row = mysqli_fetch_array($data, MYSQL_NUM))
    array_push($ids, $row[0]);
$data = mysqli_query($link, "SELECT id FROM orequests WHERE bought = '0'");
  while($row = mysqli_fetch_array($data, MYSQL_NUM))
    array_push($ids, $row[0]);

  print_r($ids);
}

if(isset($_POST['edit']))
{
}

?>

<script>
  data = [];
  otherData = [];
  otherData.push({Description: 'Add a Tool', Quantity: '0'});
  <?php
    $fill = "";
    $data = mysqli_query($link, "SELECT purchases.id, purchases.dateadded, purchases.catID, requests.type, requests.diameter,
      requests.material, requests.edp, requests.notes, requests.quantity, requests.part_number, requests.operation, requests.source, requests.price FROM purchases INNER JOIN requests
      ON purchases.catID=requests.id WHERE bought = '1' AND purchases.category = 'mill'");
    while($row = mysqli_fetch_array($data, MYSQL_NUM))
    {
      $desc = "";
      $desc .= number_format($row[4], 3) . "\" ";
      $desc .= $row[3] . ", ";
      $desc .= "Material: " . $row[5] . ", ";
      if($row[6] != '')
        $desc .= "EDP Number: " . $row[6];

      if($fill != "" ){$fill .= ", ";}
      $fill .= '{orderNumber: "' . $row[0] . '", ';
      $fill .= 'date: "' . $row[1] . '", ';
      $fill .= 'category: "mill",';
      $fill .= 'id: "' . $row[2] . '", ';
      $fill .= "description: '" . $desc . "', ";
      $fill .= "notes: '" . $row[7] . "', ";
      $fill .= 'quantity: "' . $row[8] . '", ';
      $fill .= 'partNumber: "' . $row[9] . '", ';
      $fill .= 'operation: "' . $row[10] . '", ';
      $fill .= 'source: "' . $row[11] . '", ';
      $fill .= 'price: "' . $row[12] . '"}';
      echo "data.push(" . $fill . ");";
      $fill = "";
    }

    $data = mysqli_query($link, "SELECT type, diameter, material, edp, notes, quantity, id FROM requests WHERE bought = '0' ORDER BY id DESC");
    while($row = mysqli_fetch_array($data, MYSQL_NUM))
    {
      $desc = "";
      $desc .= number_format($row[1], 3) . "\" ";
      $desc .= $row[0] . ", ";
      $desc .= $row[2] . ", ";
      if($row[3] != '')
        $desc .= "EDP Number: " . $row[3] . ", ";
      if($row[4] != '')
        $desc .= "\(" . $row[4] . "\)";
      echo "otherData.push({Description: '" . $desc . "', Quantity: '" . $row[5] . "', Machine: 'mill', Id: '" . $row[6] . "'});";
    }
    $data = mysqli_query($link, "SELECT type, description, lquantity, id FROM lrequests WHERE bought = '0' ORDER BY id DESC");
    while($row = mysqli_fetch_array($data, MYSQL_NUM))
    {
      $desc = "";
      $desc .= $row[0] . ", ";
      $desc .= $row[1];
      echo "otherData.push({Description: '" . $desc . "', Quantity: '" . $row[2] . "', Machine: 'lathe', Id: '" . $row[3] . "'});";
    }
    $data = mysqli_query($link, "SELECT description, quantity, id FROM orequests WHERE bought = '0' ORDER BY id DESC");
    while($row = mysqli_fetch_array($data, MYSQL_NUM))
    {
      $desc = "";
      $desc .= $row[0];
      echo "otherData.push({Description: '" . $desc . "', Quantity: '" . $row[1] . "', Machine: 'other', Id: '" . $row[2] . "'});";
    }

    $fill = "";
    $data = mysqli_query($link, "SELECT purchases.id, purchases.dateadded, purchases.catID, lrequests.type, lrequests.description,
      lrequests.insert_code, lrequests.notes, lrequests.lquantity, lrequests.part_number, lrequests.operation, lrequests.source, lrequests.price FROM purchases INNER JOIN lrequests
      ON purchases.catID=lrequests.id WHERE bought = '1' AND purchases.category = 'lathe'");
    while($row = mysqli_fetch_array($data, MYSQL_NUM))
    {
      $desc = "";
      if($row[3] != '')
        $desc .= $row[3];
      if($row[4] != '')
        $desc .= ", Descripton: " . $row[4];
      if($row[5] != '')
        $desc .= ", Insert Code: " . $row[5];

      if($fill != "" ){$fill .= ", ";}
      $fill .= '{orderNumber: "' . $row[0] . '", ';
      $fill .= 'date: "' . $row[1] . '", ';
      $fill .= 'category: "lathe",';
      $fill .= 'id: "' . $row[2] . '", ';
      $fill .= "description: '" . $desc . "', ";
      $fill .= "notes: '" . $row[6] . "', ";
      $fill .= 'quantity: "' . $row[7] . '", ';
      $fill .= 'partNumber: "' . $row[8] . '", ';
      $fill .= 'operation: "' . $row[9] . '", ';
      $fill .= 'source: "' . $row[10] . '", ';
      $fill .= 'price: "' . $row[11] . '"}';
      echo "data.push(" . $fill . ");";
      $fill = "";
    }

    $fill = "";
    $data = mysqli_query($link, "SELECT purchases.id, purchases.dateadded, purchases.catID, orequests.description,
      orequests.notes, orequests.quantity, orequests.part_number, orequests.operation, orequests.source, orequests.price FROM purchases INNER JOIN orequests
      ON purchases.catID=orequests.id WHERE bought = '1' AND purchases.category = 'other'");
    while($row = mysqli_fetch_array($data, MYSQL_NUM))
    {
      $desc = $row[3];

      if($fill != "" ){$fill .= ", ";}
      $fill .= '{orderNumber: "' . $row[0] . '", ';
      $fill .= 'date: "' . $row[1] . '", ';
      $fill .= 'category: "other",';
      $fill .= 'id: "' . $row[2] . '", ';
      $fill .= "description: '" . $desc . "', ";
      $fill .= "notes: '" . $row[4] . "', ";
      $fill .= 'quantity: "' . $row[5] . '", ';
      $fill .= 'partNumber: "' . $row[6] . '", ';
      $fill .= 'operation: "' . $row[7] . '", ';
      $fill .= 'source: "' . $row[8] . '", ';
      $fill .= 'price: "' . $row[9] . '"}';
      echo "data.push(" . $fill . ");";
      $fill = "";
    }

  ?>

  var app = angular.module('sortApp', [])

  .controller('mainController', function($scope) {
    $scope.poNum = '<?php echo $poNum; ?>';
    $scope.currentPage = 0;
    $scope.pageSize = 30;
    $scope.sortType = 'date';
    $scope.sortReverse = 'false';
    $scope.searchTools = '';
    $scope.orders = data;
    $scope.req = otherData;
    $scope.added = [];
    $scope.numberOfPages = function() {
      return Math.ceil($scope.orders.length/$scope.pageSize);
    }
    $scope.index = function() {
      if($scope.poNum == '') {$scope.poNum = '<?php echo $sparePo; ?>'}
      else {$scope.poNum++;}
    }
    $scope.additem = function() {
      if(!$scope.selectedRequests) {return;}
      if($scope.added.indexOf($scope.selectedRequests) == -1)
        $scope.added.push($scope.selectedRequests);
    }
    $scope.removeItem = function(x) {
      $scope.added.splice(x, 1);
    }
  });
</script>
