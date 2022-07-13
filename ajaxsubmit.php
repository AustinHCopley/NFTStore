<?php
require 'database.php';
  $conn = getConnection();
  //Fetching Values from URL
  echo "hello";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first = $last = $email = $prod = $quant = "";
    $first = $_POST['first'];
    $last = $_POST['last'];
    $email = $_POST['email'];
    $prod = $_POST['product'];
    $quant = $_POST['quantity'];
    $price = 0;
    $donation = 0; // default for order entry
    $timestamp = $_POST['timestamp'];

    if ( !customerExists($conn, $email) ) {
      // if customer does not exist, create customer in database
      insertCustomer($conn, $first, $last, $email);
    }
    $customer = getCustomer($conn, $email);
    $product = getProdByName($conn, $prod);
    $price = $product['price'];
    $product_id = $product['id'];
    $in_stock = $product['in_stock'];
    $customer_id = $customer['id'];
    // order info
    $subtotal = $price * $quant;
    $tax = $subtotal * 0.0075;
    $tax = number_format($tax, 2);
    $total = number_format($subtotal + $tax, 2);
    //check formatting before inserting
    $quant = (double)$quant;
    $price = (double)$price;
    $tax = (double)$tax;
    $timestamp = (int)$timestamp;
    // insert order into database
    insertOrder($conn, $product_id, $customer_id, $quant, $price, $tax, $donation, $timestamp, ($in_stock - $quant));
    echo "<span>Order submitted for: <em>" . $first . " " . $last . "</em> " . $quant . " " . $prod . " Total $" . $total . "</span>";
  }
?>
