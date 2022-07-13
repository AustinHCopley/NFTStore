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
  echo $inactive;

  insertProduct($conn, $name, $img, $price, $quant, $inactive);

?>
