
<!DOCTYPE html>

<html>
  <head>
    <title>Order Processed</title>
    <link rel="stylesheet" href="common.css">
    <link rel="stylesheet" href="process_order.css">
    <script src="cookie.js"></script>
  </head>
  <body>
    <?php
      require 'header.php';
      require 'database.php';
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          // collect value of input field
          $first = $_POST['first'];
          $last = $_POST['last'];
          $email = $_POST['email'];
          $quantity = $_POST['quantity'];
          $nft = $_POST['product'];
          $price = 0; // default
          $yn = $_POST['donate'];
          $timestamp = $_POST['timestamp'];
          $conn = getConnection();
        }
    ?>
    <article>

      <?php
        echo "<h3>Hello {$first} {$last},</h3>";
        if ( customerExists($conn, $email) ) {
          echo "<h3>Thanks for shopping with us again!</h3>";
        } else {
          echo "<h3>Congratulations on your first order with us!</h3>";
          insertCustomer($conn, $first, $last, $email);
        }
        $customer = getCustomer($conn, $email);
        $product = getProdByName($conn, $nft);
        // product info
        $nft = $product['product_name'];
        $price = $product['price'];
        $product_id = $product['id'];
        $in_stock = $product['in_stock'];

        if ( ($in_stock - $quantity) < 0 ) {
          $quantity = 0;
        }
        // customer info
        $customer_id = $customer['id'];
        // order info
        $subtotal = $price * $quantity;
        $tax = $subtotal * 0.0075;
        $tax = number_format($tax, 2);
        $total = $subtotal + $tax;
        if ($yn == "yes") {
          $donation = number_format((ceil($total) - $total), 2) ;
          $total = ceil($total);
        } else {
          $donation = 0;
          $total = number_format($total, 2);
        }
      ?>
      <div class="receipt">
        <p id="order_title">Order info: </p>
        <span class="breakdown"><?php echo $quantity . " " . $nft . " @ $" . $price . "<br>";?></span>
        <span class="breakdown"><?php echo "Subtotal: $" . $subtotal . "<br>";?></span>
        <span class="breakdown"><?php echo "Tax (.75%): $" . $tax . "<br>";?></span>
        <span class="breakdown"><?php
          if ($yn == "yes") {
            echo "Total with donation: $" . $total;
          } else {
            echo "Total without donation: $" . $total;
          }?></span>
        </div>
        <p><?php echo "We'll send special offers to " . $email;?></p>
        <?php
          $quantity = (double)$quantity;
          $price = (double)$price;
          $tax = (double)$tax;
          $donation = (double)$donation;
          $timestamp = (int)$timestamp;
          insertOrder($conn, $product_id, $customer_id, $quantity, $price, $tax, $donation, $timestamp, ($in_stock - $quantity));
        ?>
        <div id="discount"></p>

    </article>
    <script>
      getItems();
      function getItems() {
        var cookie = getCookie("viewed");
        var cookieArray = JSON.parse(cookie);

        var count = 0;
        var displayMsg = "<p>We would like to give you a 20% discount on any of the following items:</p><ul>";
        if ( cookieArray != null ) {
          for ( var i = 0; i < cookieArray.length; i++ ) {
            if ( cookieArray[i] != "<?php echo $_POST['product']?>" ) {
              count += 1; // check if the product that was puchased is the only member of the array

              displayMsg += "<li>";
              displayMsg += cookieArray[i];
              displayMsg += "</li>";
            }
          }
        }
        displayMsg += "</ul>";
        if ( count > 0 ) {
          document.getElementById("discount").innerHTML = displayMsg;
        } else {
          document.getElementById("discount").innerHTML = "";
        }

        // after msg has been displayed, clear the cookie
        clearViewedProducts();
      }
    </script>
    <?php require 'footer.php';?>
  </body>
</html>
