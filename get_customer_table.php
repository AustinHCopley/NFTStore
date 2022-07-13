
<?php

  require 'database.php';
  $q = $_REQUEST['q'];
  $n = $_REQUEST['n'];
  $conn = getConnection();
  $customers = getCustomersByName($conn, $q, $n);
  if ( $customers === [] ) {
    echo "No customer exists";
  } else {

    echo '<table id="search">';
    echo "<tr>";
    echo "<th>Last</th>";
    echo "<th>First</th>";
    echo "<th>email</th>";
    echo "</tr>";
    foreach($customers as $id) {
      $row = getCustomerbyID($conn, $id);
      echo "<tr>";
      echo "<td onclick='highlight_rows()'>" . $row['last_name'] . "</td>";
      echo "<td onclick='highlight_rows()'>" . $row['first_name'] . "</td>";
      echo "<td onclick='highlight_rows()'>" . $row['email'] . "</td>";
      echo "</tr>";
    }
    echo "</table>";

  }
?>
