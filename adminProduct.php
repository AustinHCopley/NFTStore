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
    <title>Products</title>
    <meta charset="UTF-8">
    <meta name="author" content="Austin Copley">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
    <link rel="stylesheet" href="common.css">
    <link rel="stylesheet" href="adminProduct.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="product_script.js"></script>
  </head>
  <body>
    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', True);
    require 'database.php';
    ?>
    <div id="left">
      <p id="choose"><em>Products:</em></p>
      <div id="table" style="overflow-y:scroll;">
        <?php //createTable($conn); ?>
      </div>
    </div>
    <div id="right">
      <h3 id="error"><h3>
      <form id="4m">
        <article>
            <fieldset id="box">
              <legend><span>NFT Info</span></legend>
              <label for="name">Product Name: <span>*</span></label>
              <input id="product_name" type="text" name="name" size="18" pattern="[A-Za-z.'. ]{0,}" title="Names can only include letters, spaces, and apostrophe" onkeyup="showHint(this.value, 'first')"><br>
              <label for="img">Product Image: </label>
              <input id="image_name" type="text" name="img" size="18" pattern="[A-Za-z.'. ]{0,}" title="Names can only include letters, spaces, and apostrophe" onkeyup="showHint(this.value, 'last')"><br>
              <label for="quantity">Quantity: </label>
              <input id="quantity" type="number" name="quant" pattern="[0-9]" title="characters@characters.domain"><br>
              <label for="price">Price: <span>*</span></label>
              <input id="price" type="number" name="price" pattern="[0-9]+([\.,][0-9]+)?" step="0.01" title="Price is a number with up to 2 decimal places."><br>
              <label for="inactive">Make Inactive:</label>
              <input id="inactive" type="checkbox" name="inactive">
            </fieldset>
            <input id="addButton" type="submit" value="Add NFT">
            <input id="updateButton" type="submit" value="Update">
            <input id="deleteButton" type="submit" value="Delete">
        </article>
      </form>
    </div>

    <?php
    require 'footer.php';
    ?>
    <script>

    function showTable() {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if ( this.readyState == 4 && this.status == 200 ) {
          document.getElementById("table").innerHTML = this.responseText;
        }
      };
      xmlhttp.open("GET","get_product_table.php?",true);
      xmlhttp.send();
    }
    showTable();

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

          var product_name = selected.cells[0].innerHTML;
          var image_name = selected.cells[1].innerHTML;
          var in_stock = selected.cells[2].innerHTML;
          var price = selected.cells[3].innerHTML;
          var inactive = selected.cells[4].innerHTML;
          alert

          document.getElementById('product_name').value = product_name;
          document.getElementById('image_name').value = image_name;
          document.getElementById('quantity').value = in_stock;
          document.getElementById('price').value = price;
          if ( inactive == "Yes" ) {
            document.getElementById('inactive').checked = true;
          } else {
            document.getElementById('inactive').checked = false;
          }
        }

      }

    }
    </script>
  </body>
</html>
