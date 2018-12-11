<?php
  $link = mysqli_connect("localhost", "root", "")
    or die("Couldn't connect to SQL Server");
  mysqli_select_db($link, "pictures") or die("Couldn't select DB");
  date_default_timezone_set("America/Los_Angeles");

  $query = "SELECT id, caption FROM pictures";
  $result = mysqli_query($link, $query) or die('Something broke');

  if(mysql_num_rows($result) == 0) {
    echo "Database is empty <br>";
  } else {
    while (list($id, $name) = mysql_fetch_array($result)) {
      ?>
        <a href = "display.php?id=<?php=$id;?>"><?php=$name;?></a><br>
      <?php
    }
  }
?>
