<?php require 'header.php';
  if ( !isset($_SESSION['role']) ) {
    header("Location: index.php?err=You must log in first");
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Order Entry</title>
    <meta charset="UTF-8">
    <meta name="author" content="Austin Copley">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
    <link rel="stylesheet" href="common.css">
    <link rel="stylesheet" href="order_entry.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="script.js"></script>
  </head>
  <body>
    <?php
    require 'database.php';
    date_default_timezone_set("America/Denver");
    $conn = getConnection();
    $products = getProducts($conn);
    ?>
    <div id="right">
      <p id="choose"><em>Choose an existing customer:</em></p>
      <div id="table">

      </div>
    </div>
    <form id="4m">
      <article>
          <fieldset id="box">
            <legend><span>Personal Info</span></legend>
            <label for="first">First Name: <span>*</span></label>
            <input id="first_name" type="text" name="first" size="18" pattern="[A-Za-z.'. ]{0,}" title="Names can only include letters, spaces, and apostrophe" onkeyup="showHint(this.value, 'first')"><br>
            <label for="last">Last Name: <span>*</span></label>
            <input id="last_name" type="text" name="last" size="18" pattern="[A-Za-z.'. ]{0,}" title="Names can only include letters, spaces, and apostrophe" onkeyup="showHint(this.value, 'last')"><br>
            <label for="email">email: <span>*</span></label>
            <input id="email" type="text" name="email" size="23" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="characters@characters.domain"><br>
          </fieldset>
      </article>
      <article>
        <fieldset id="box">
          <legend><span>Product Info</span></legend>
          <select id="product" name="product" onchange="showAvail(this.value)">
            <option value="" disabled selected hidden>Choose an NFT</option>
            <?php if ($products): ?>
              <?php foreach($products as $row): ?>
                <option value="<?=$row['product_name'];?>" id="<?=$row['id']?>" data-quantity="<?=$row['in_stock']?>"><?=$row['product_name']?> - $<?=$row['price']?></option>
              <?php endforeach ?>
            <?php endif ?>
          </select><br>
          <label for="avail">Available:</label>
          <input id="available" type="text" name="avail" readonly required><br>
          <label for="quantity">Quantity:</label>
          <input id="quantity" type="number" name="quantity" min="1" max="100" required>
        </fieldset>
        <input type="hidden" name="timestamp" value="<?php echo time(); ?>">
        <input id="submitButton" type="submit" value="Purchase">
        <input id="resetButton" type="reset" value="Clear Fields">
      </article>
    </form>
    <?php require 'footer.php';?>
    <script>
      function showAvail(nft) {
        if ( nft == "" ) {
          document.getElementById("available").value = "";
          return;
        } else {
          // open xmlhttpreq
          var xmlhttp = new XMLHttpRequest();
          //document.getElementById("available").value = 0;
          xmlhttp.onreadystatechange = function() {
            if ( this.readyState == 4 && this.status == 200 ) {
              document.getElementById("available").value = this.responseText;
            }
          };
          // send request with product name in php parameter
          xmlhttp.open("GET","get_quantity.php?q="+nft,true);
          xmlhttp.send();
        }
      }

      function showHint(input, name) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if ( this.readyState == 4 && this.status == 200 ) {
            document.getElementById("table").innerHTML = this.responseText;
          }
        };
        xmlhttp.open("GET","get_customer_table.php?q="+ input + "&n=" + name,true);
        xmlhttp.send();
      }

      function highlight_rows() {
        var table = document.getElementById('search');
        var cells = table.getElementsByTagName('td');
        var selected;
        for ( var i = 0; i < cells.length; i++) {
          var cell = cells[i];
          cell.onclick = function() {
            var selectedCell = this.parentNode.rowIndex;

            // remove selected class and style from unselected rows
            var unselected = table.getElementsByTagName('tr');
            for ( var j = 0; j < unselected.length; j++ ) {
              unselected[j].style.backgroundColor = "#f9e7d4";
              unselected[j].classList.remove('selected');
            }
            // add selected class and style to selected row
            selected = table.getElementsByTagName('tr')[selectedCell];
            selected.style.backgroundColor = "#f6c403";
            selected.className += ' selected';

            var first_name = selected.cells[1].innerHTML;
            var last_name = selected.cells[0].innerHTML;
            var email = selected.cells[2].innerHTML;

            document.getElementById('first_name').value = first_name;
            document.getElementById('last_name').value = last_name;
            document.getElementById('email').value = email;
          }

        }

      }

    </script>
  </body>
</html>
