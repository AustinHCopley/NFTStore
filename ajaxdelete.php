<?php
require 'database.php';
  $conn = getConnection();
  //Fetching Values from URL

  $name = "";
  $name = $_POST['name'];
  $price = $_POST['price'];

  if ( productExists($conn, $name) ) {

    if ( deleteProduct($conn, $name, $price) == false ) {
      echo "Can't delete, product " . $name . " does not exist";
    } else {
      echo "Deletion successful";
    }
  }

?>
