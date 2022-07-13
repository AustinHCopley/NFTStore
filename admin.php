<?php require 'header.php';
  if ( isset($_SESSION['role']) ) {
    $role = $_SESSION['role'];
    if ( $role == 1 ) {
      header("Location: index.php?err=You are not authorized for that page!");
    }
  } else {
    header("Location: index.php?err=You must log in first");
  }
?>
<!DOCTYPE html>

<html>
  <head>
    <title>Admin</title>
    <link rel="stylesheet" href="common.css">
    <link rel="stylesheet" href="admin.css">
  </head>
  <body>
    <?php
      require 'database.php';
      $conn = getConnection();
      $customers = getCustomers($conn);
      $orders = getOrders($conn);
      $products = getProducts($conn);
    ?>
    <article>
      <h3>Customers</h3>
      <table>
        <?php if ($customers): ?>
          <tr class="cols">
            <td>Last Name</td>
            <td>First Name</td>
            <td>Email</td>
          </tr>
          <?php foreach($customers as $row): ?>
            <tr>
              <td><?=$row['last_name'];?></td>
              <td><?=$row['first_name']?></td>
              <td><?=$row['email']?></td>
            </tr>
          <?php endforeach ?>
        <?php endif ?>
      </table>
      <h3>Orders</h3>
      <table>
        <?php if ($orders): ?>
          <tr class="cols">
            <td>Customer</td>
            <td>NFT</td>
            <td>Date</td>
            <td>Quantity</td>
            <td>Price</td>
            <td>Tax</td>
            <td>Donation</td>
            <td>Total</td>
          </tr>
          <?php foreach($orders as $row): ?>
            <tr>
              <td>
                <?php
                  $cust = getCustomerbyID($conn, $row['customer_id']);
                  echo $cust['first_name'] . " " . $cust['last_name'];
                ?>
              </td>
              <td>
                <?php
                  $prod = getProductbyID($conn, $row['product_id']);
                  echo $prod['product_name'];
                ?>
              </td>
              <td><?=date('m/d/Y H:i:s', $row['timestamp'])?></td>
              <td><?=$row['quantity']?></td>
              <td><?=$row['price']?></td>
              <td><?=$row['tax']?></td>
              <td><?=$row['donation']?></td>
              <td><?php echo $row['price'] + $row['tax'] + $row['donation']; ?></td>
            </tr>
          <?php endforeach ?>
        <?php endif ?>
        <?php if ( empty($orders) ):?>
          <tr><td>No Data</td></tr>
        <?php endif ?>
      </table>
      <h3>NFTs</h3>
      <table>
        <?php if ($products): ?>
          <tr class="cols">
            <td>NFT</td>
            <td>Quantity</td>
            <td>Price</td>
          </tr>
          <?php foreach($products as $row): ?>
            <tr>
              <td><?=$row['product_name'];?></td>
              <td><?=$row['in_stock']?></td>
              <td><?=$row['price']?></td>
            </tr>
          <?php endforeach ?>
        <?php endif ?>
      </table>
    </article>
    <?php
      require 'footer.php';
    ?>
  </body>
</html>
