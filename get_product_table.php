
<?php

  require 'database.php';

  $conn = getConnection();
  $products = getProducts($conn);
  if ( $products === [] ) {
    echo "No products exists";
  } else {

    echo '<table id="search">';
    echo "<tr>";
    echo "<th>Product Name</th>";
    echo "<th>Image Name</th>";
    echo "<th>In Stock</th>";
    echo "<th>Price</th>";
    echo "<th>Inactive</th>";
    echo "</tr>";
    foreach($products as $row) {
      if ($row['inactive']) {
        $inact = "Yes";
      } else {
        $inact = "No";
      }
      echo "<tr>";
      echo "<td onclick='highlight_rows()'>" . $row['product_name'] . "</td>";
      echo "<td onclick='highlight_rows()'>" . $row['image_name'] . "</td>";
      echo "<td onclick='highlight_rows()'>" . $row['in_stock'] . "</td>";
      echo "<td onclick='highlight_rows()'>" . $row['price'] . "</td>";
      echo "<td onclick='highlight_rows()'>" . $inact . "</td>";
      echo "</tr>";
    }
    echo "</table>";

  }
?>
