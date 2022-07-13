
<!DOCTYPE html>
<html>
  <head>
    <title>NFT Store</title>
    <meta charset="UTF-8">
    <meta name="author" content="Austin Copley">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
    <link rel="stylesheet" href="common.css">
    <link rel="stylesheet" href="store.css">
    <script src="cookie.js"></script>
  </head>
  <body>
    <?php
    require 'header.php';
    require 'database.php';
    date_default_timezone_set("America/Denver");
    $conn = getConnection();
    $products = getProducts($conn);
    ?>
    <form method="post" action="process_order.php">
      <article>
          <fieldset id="box">
            <legend><span>Personal Info</span></legend>
            <label for="first">First Name: <span>*</span></label>
            <input type="text" name="first" size="18" pattern="[A-Za-z.'. ]{0,}" title="Names can only include letters, spaces, and apostrophe" required><br>
            <label for="last">Last Name: <span>*</span></label>
            <input type="text" name="last" size="18" pattern="[A-Za-z.'. ]{0,}" title="Names can only include letters, spaces, and apostrophe" required><br>
            <label for="email">email: <span>*</span></label>
            <input type="text" name="email" size="23" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="characters@characters.domain" required><br>
          </fieldset>
          <div>
            <img id="img">
            <p id="placeholder">Please select an item to show it here</p>
          </div>
      </article>
      <article>
        <fieldset id="box">
          <legend><span>Product Info</span></legend>
          <select id="product" name="product" required onchange="display()">
            <option value="" disabled selected hidden>Choose an NFT</option>
            <?php if ($products): ?>
              <?php foreach($products as $row): ?>
                <?php if ( $row['inactive'] == 0 ): ?>
                  <option value="<?=$row['product_name'];?>" id="<?=$row['id']?>" data-quantity="<?=$row['in_stock']?>"><?=$row['product_name']?> - $<?=$row['price']?></option>
                <?php endif ?>
              <?php endforeach ?>
            <?php endif ?>
          </select><br>
          <label for="quantity">Quantity:</label>
          <input type="number" id="quantity" name="quantity" min="1" max="100" required>
        </fieldset>
        <p>Round up to the nearest dollar for a donation?</p>
        <input type="radio" id="yes" name="donate" value="yes" checked="checked">
        <label for="yes">Yes</label><br>
        <input type="radio" id="no" name="donate" value="no">
        <label for="no">No</label><br><br>
        <input type="hidden" name="timestamp" value="<?php echo time(); ?>">
        <input id="button" type="submit" value="Purchase">
      </article>
    </form>
    <?php require 'footer.php';?>
    <script>
      function display() {
        // get value select option and change the image source to match
        var img = document.getElementById("product").value;
        document.getElementById("img").src="images/"+img+".jpeg";

        var viewed = getCookie("viewed");
        var discountArray = JSON.parse(viewed);
        if ( discountArray != null ) {
          if ( !(discountArray.includes(img) )) {
            discountArray.push(img);
          }
        } else {
          discountArray = new Array(img);
        }
        var cookify = JSON.stringify(discountArray);
        setCookie('viewed', cookify, 10);

        // get the select element, then get data-quantity attribute from selected option
        var select = document.getElementById("product");
        var stock = select.options[select.selectedIndex].getAttribute('data-quantity');

        if ( stock == 0 ) {
          document.getElementById("placeholder").innerHTML="OUT OF STOCK";
        } else if ( stock <= 5 ) {
          document.getElementById("placeholder").innerHTML="Only " + stock + " left";
        } else {
          document.getElementById("placeholder").innerHTML="In Stock";
        }

      }


    </script>
  </body>
</html>
