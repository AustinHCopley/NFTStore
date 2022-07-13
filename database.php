<?php

  function getConnection() {
    require 'database_credentials.php';
    // create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
  }

  function insertCustomer($conn, $first, $last, $email) {
    $sql = "INSERT INTO customer (first_name, last_name, email) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $first, $last, $email);
    $first = $_POST['first'];
    $last = $_POST['last'];
    $email = $_POST['email'];
    $stmt->execute();
    $stmt->close();
  }

  function insertOrder($conn, $product_id, $customer_id, $quantity, $price, $tax, $donation, $timestamp, $in_stock) {
    $sql = "SELECT * FROM orders WHERE customer_id=? AND product_id=? AND timestamp=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iii', $customer_id, $product_id, $timestamp);
    $stmt->execute();
    $result = $stmt->get_result();
    if ( $result->num_rows > 0 ) {
      echo "Duplicate order!";
      return;
    }
    $newsql = "INSERT INTO orders (product_id, customer_id, quantity, price, tax, donation, timestamp) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $newStmt = $conn->prepare($newsql);
    $newStmt->bind_param('iiidddi', $product_id, $customer_id, $quantity, $price, $tax, $donation, $timestamp);
    $newStmt->execute();
    $newStmt->close();
    updateStock($conn, $in_stock, $product_id);
  }

  function insertProduct($conn, $name, $img, $price, $quant, $inactive) {
    $sql = "INSERT INTO product (product_name, image_name, price, in_stock, inactive) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdii", $name, $img, $price, $quant, $inactive);
    $name = $_POST['name'];
    $img = $_POST['img'];
    $price = $_POST['price'];
    $quant = $_POST['quant'];
    $inactive = $_POST['inact'];
    $stmt->execute();
    $stmt->close();
  }

  function updateProduct($conn, $name, $img, $price, $quant, $inactive) {
    $sql = "UPDATE product SET image_name=?, price=?, in_stock=?, inactive=? WHERE product_name=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdiis", $img, $price, $quant, $inactive, $name);
    $name = $_POST['name'];
    $img = $_POST['img'];
    $price = $_POST['price'];
    $quant = $_POST['quant'];
    $inactive = $_POST['inact'];
    $stmt->execute();
    $stmt->close();
  }

  function deleteProduct($conn, $name, $price) {
    $sql = "DELETE FROM product WHERE product_name=? AND price=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sd", $name, $price);
    if ($stmt) {
      $stmt->execute();
    } else {
      return false;
    }

    $stmt->close();
    return true;

  }

  function getProducts($conn) {
    $sql = "SELECT * FROM product";
    $result = mysqli_query($conn, $sql);
    return $result;
  }

  function getProdByName($conn, $value) {
    $sql = "SELECT * FROM product WHERE product_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $value);
    $stmt->execute();
    $result = $stmt->get_result();
    $prod = $result->fetch_assoc();
    return $prod;
  }

  function getCustomer($conn, $email) {
    $sql = "SELECT * FROM customer WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $customer = $result->fetch_assoc();
    return $customer;
  }

  function getCustomersByName($conn, $name, $fl) {
    if ( $fl == 'first' ) {
      $sql = "SELECT id FROM customer WHERE first_name LIKE ?";
    } else {
      $sql = "SELECT id FROM customer WHERE last_name LIKE ?";
    }
    $customers = array();
    if ($name == "") {
      return $customers;
    }
    $name = $name . '%';
    $stmt = $conn->prepare($sql);
    if (
	     $stmt -> bind_param('s', $name) &&
	     $stmt -> execute() &&
	     $stmt -> store_result() &&
	     $stmt -> bind_result($id)
    ) {
      	while ($stmt -> fetch()) {
      		$customers[] = $id;
      	}
      }
    return $customers;
  }

  function customerExists($conn, $email) {
    $sql = "SELECT * FROM customer WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) return false;
    return true;
  }

  function productExists($conn, $name) {
    $sql = "SELECT * FROM product WHERE product_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) return false;
    return true;
  }

  function updateStock($conn, $in_stock, $product_id) {
    $sql = "UPDATE product SET in_stock = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $in_stock, $product_id);
    $stmt->execute();
  }

  function getCustomers($conn) {
    $sql = "SELECT * FROM customer";
    $result = mysqli_query($conn, $sql);
    return $result;
  }

  function getOrders($conn) {
    $sql = "SELECT * FROM orders";
    $result = mysqli_query($conn, $sql);
    return $result;
  }

  function getCustomerbyID($conn, $id) {
    $sql = "SELECT * FROM customer WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $customer = $result->fetch_assoc();
    return $customer;
  }

  function getProductbyID($conn, $id) {
    $sql = "SELECT * FROM product WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    return $product;
  }

  function getProdQuant($conn, $nft) {
    $sql = "SELECT * FROM product WHERE product_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nft);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    return $product['in_stock'];
  }

  function getUser($conn, $email, $password) {
    $sql = "SELECT * FROM users WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    return $user;
  }

?>
