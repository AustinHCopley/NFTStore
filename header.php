<!DOCTYPE html>
<html>
  <body>
    <nav>
      <ul class="topnav" id="myTopnav">
        <?php session_start();
        if ( isset($_SESSION['role']) ) {
          $role = $_SESSION['role'];
        } else {
          $role = null;
        } ?>
        <li><a href="index.php" class="active">Home</a></li>
        <?php
          if ( $role != 1 ) {
            echo "<li><a href='store.php'>Store</a></li>";
          }
          if ( $role == 1 or $role == 2 )  {
            echo "<li><a href='order_entry.php'>Order Entry</a></li>";
            echo "<li><a id='admin' href='logout.php'>Logout</a></li>";
          }
          if ( $role == 2 ) {
            echo "<li><a href='adminProduct.php'>Products</a></li>";
            echo "<li><a href='admin.php'>Admin</a></li>";
          }
        ?>
      </ul>
    </nav>
    <header>
      <h1>NFT Store<h1>
    </header>
    <?php if ( isset($_SESSION['name']) ): ?>
      <aside>
        <p>Welcome, <?= $_SESSION['name']; ?></p>
      </aside>
    <?php endif ?>
  </body>
</html>
