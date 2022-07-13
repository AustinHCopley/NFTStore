<?php
require 'database.php';
  $conn = getConnection();
  //Fetching Values from URL

  $name = $img = $quant = $price = $inactive = "";
  $name = $_POST['name'];
  $img = $_POST['img'];
  $quant = $_POST['quant'];
  $price = $_POST['price'];
  $inactive = $_POST['inact'];
  if ( productExists($conn, $name) ) {
    updateProduct($conn, $name, $img, $price, $quant, $inactive);
    echo "Update successful";
  } else {
    echo "Can't update, product " . $name . " does not exist";
  }




?>
